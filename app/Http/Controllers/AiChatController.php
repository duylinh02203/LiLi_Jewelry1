<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiChatController extends Controller
{
    protected static string $apiKey;
    protected static array $history = [];
    protected static bool $initialized = false;

    public static function init(): void
    {
        $sessionHistory = session('chat_history', null);
        if ($sessionHistory !== null) {
            self::$history = $sessionHistory;
            self::$initialized = true;
            return;
        }

        self::$apiKey = env('GEMINI_API_KEY');

        $products = Product::with(['category', 'firstImage', 'sizes'])->get();

        $productsInfo = $products->map(function ($product) {
            $categoryName = $product->category->name ?? 'Không có danh mục';
            $image = $product->firstImage->image ?? 'default.png';

            $discountPercent = null;
            if ($product->listed_price && $product->listed_price > $product->price) {
                $discountPercent = round((($product->listed_price - $product->price) / $product->listed_price) * 100);
            }

            $sizeInfo = $product->sizes->map(function ($size) {
                return "{$size->size} ({$size->quantity})";
            })->implode(', ');

            $info = "ID: {$product->id} - {$product->name} - Giá: {$product->price} - Mô tả: {$product->description} - slug: {$product->slug} - 
         Giới tính: {$product->gender} - Danh mục: {$categoryName} - Hình ảnh: {$image} - Kích thước: {$sizeInfo}";

            if ($discountPercent) {
                $info .= " - Giảm giá: {$discountPercent}% (Giá niêm yết: {$product->listed_price})";
            }

            return $info;
        })->join("\n");

        $reviews = ProductReview::with('product')->get();

        $reviewsInfo = $reviews->map(function ($review) {
            return "Đánh giá ID: {$review->id} - Sản phẩm: {$review->product->name} - Người dùng: {$review->user_name} - 
         Số sao: {$review->rating} - Bình luận: {$review->comment} - Ngày: {$review->created_at->format('d/m/Y')}";
        })->join("\n");

        $prompt = <<<EOT
Bạn là một nhân viên tư vấn trang sức chuyên nghiệp và thân thiện.

Dưới đây là danh sách sản phẩm hiện có:
{$productsInfo}

Và một số đánh giá khách hàng:
{$reviewsInfo}

Khi người dùng hỏi về sản phẩm nào đó, hãy:
- Tìm sản phẩm phù hợp nhất từ danh sách trên (dựa theo tên hoặc mô tả)
- Trả lời ngắn gọn, lịch sự, dễ hiểu
- Nếu có sản phẩm phù hợp, hãy **hiển thị HTML sau đây** để bot frontend có thể hiển thị đúng:
  - Ảnh sản phẩm: sử dụng `http://127.0.0.1:8000/images/<tên_ảnh>`
  - Tên sản phẩm in đậm
  - Giá định dạng: `1.000.000đ`
  - Nút xem chi tiết sản phẩm: <a href="http://127.0.0.1:8000/product/<slug>" target="_blank">Xem chi tiết</a>
  - Nếu sản phẩm có nhiều size, hãy liệt kê các size (ví dụ: "Size: 6, 7, 8")
- Nếu sản phẩm có giảm giá, hãy ghi rõ mức giảm giá (ví dụ: "Giảm 30%")

Ví dụ sản phẩm hiển thị:
<div class="product-card">
  <img src="http://127.0.0.1:8000/images/abc.jpg" alt="Tên sản phẩm">
  <div class="name">Tên sản phẩm</div>
  <div class="price">Giá: 2.000.000đ</div>
  <div class="discount">Giảm 30%</div>
  <a href="http://127.0.0.1:8000/product/slug" target="_blank">
    <button>Xem chi tiết</button>
  </a>
</div>

Nếu người dùng hỏi cách chọn size trang sức (như nhẫn, vòng...), hãy trả lời ngắn gọn và cung cấp hướng dẫn đo size như sau:

**Cách đo size tại nhà:**
1. Dùng dây hoặc mảnh giấy nhỏ quấn quanh ngón tay (hoặc cổ tay, nếu là vòng).
2. Đánh dấu điểm giao nhau và đo chiều dài bằng thước (đơn vị mm).
3. Gửi số đo cho cửa hàng để được tư vấn size phù hợp.

Luôn bắt đầu bằng lời chào thân thiện và ngắn gọn.
Chỉ đưa sản phẩm nếu thấy phù hợp.
EOT;

        self::$history[] = ['role' => 'user', 'parts' => [['text' => $prompt]]];
        self::$initialized = true;
        session(['chat_history' => self::$history]);
    }

    public function chatAjax(Request $request)
    {
        self::init();
        $message = $request->prompt ?? '';

        if (!$message || !is_string($message) || trim($message) === '') {
            return response()->json([
                'success' => false,
                'message' => 'Trường message là bắt buộc.',
                'errors' => ['message' => ['validation.required']]
            ], 422);
        }

        self::$history[] = ['role' => 'user', 'parts' => [['text' => $message]]];

        try {
            $response = Http::post(
                "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . env('GEMINI_API_KEY'),
                ['contents' => self::$history]
            );

            if ($response->failed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lỗi khi gọi API Gemini',
                    'error' => $response->body(),
                ], 500);
            }

            $text = $response->json('candidates.0.content.parts.0.text') ?? 'Không có phản hồi.';

            // Tìm sản phẩm liên quan theo tên
            $products = Product::with('firstImage')
                ->where('name', 'like', '%' . $message . '%')
                ->limit(3)
                ->get();

            if ($products->count() > 0) {
                $text .= "<div><strong>Sản phẩm phù hợp bạn tìm:</strong></div>";

                foreach ($products as $product) {
                    $image = optional($product->firstImage)->image ?? 'default.png';
                    $imgUrl = asset('images/' . $image);
                    $link = url('/product/' . $product->slug);
                    $price = number_format($product->price) . 'đ';
                    $discount = $product->listed_price && $product->listed_price > $product->price
                        ? round((($product->listed_price - $product->price) / $product->listed_price) * 100)
                        : null;

                    $text .= '
                            <div class="bot">
                            <div class="product-card">
                                <img src="' . $imgUrl . '" alt="' . e($product->name) . '">
                                <div class="name">' . e($product->name) . '</div>
                                <div class="price">Giá: ' . $price . '</div>' .
                        ($discount ? '<div class="discount">Giảm ' . $discount . '%</div>' : '') . '
                                <a href="' . $link . '" target="_blank">
                                <button>Xem chi tiết</button>
                                </a>
                            </div>
                            </div>';
                }
            }

            self::$history[] = ['role' => 'model', 'parts' => [['text' => $text]]];
            session(['chat_history' => self::$history]);

            return response()->json([
                'success' => true,
                'message' => $text,
                'history' => array_slice(self::$history, 1),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi kết nối Gemini: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function clearChatHistory()
    {
        try {
            self::$history = [];
            self::$initialized = false;
            session()->forget('chat_history');

            return response()->json([
                'success' => true,
                'message' => 'Lịch sử chat đã được xóa.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa lịch sử. Vui lòng thử lại sau.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
