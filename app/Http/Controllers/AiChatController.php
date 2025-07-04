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
            // 
            $discountPercent = null;
            if ($product->listed_price && $product->listed_price > $product->price) {
                $discountPercent = round((($product->listed_price - $product->price) / $product->listed_price) * 100);
            }
            // Lấy danh sách kích thước và số lượng
            $sizeInfo = $product->sizes->map(function ($size) {
                return "{$size->size} ({$size->quantity})";
            })->implode(', '); // Ngăn cách các size bằng dấu phẩy

            $info = "ID: {$product->id} - {$product->name} - Giá: {$product->price} - Mô tả: {$product->description} - slug: {$product->slug} - Số lượng: {$product->quantity} -
         Giới tính: {$product->gender} - Trạng thái:{$product->status} - Danh mục: {$categoryName} - Hình ảnh: {$image} - Kích thước: {$sizeInfo}";

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
Bạn là tư vấn viên trang sức chuyên nghiệp, thân thiện, am hiểu sản phẩm, phong thủy và xu hướng quà tặng.

Dưới đây là danh sách sản phẩm:
{$productsInfo}

Và một số đánh giá khách hàng:
{$reviewsInfo}

---

Khi người dùng hỏi, hãy:

1. **Gợi ý tối đa 1–3 sản phẩm phù hợp**:
   - Chỉ chọn sản phẩm còn hàng (`số lượng > 0`)
   - Lọc theo từ khóa, mệnh, dịp tặng, ngân sách, giới tính...
   - Ưu tiên có đánh giá tốt, giảm giá, nhiều size, ý nghĩa phong thủy

2. **Hiển thị HTML sản phẩm theo mẫu sau**:
<div style="margin:10px 0;padding:10px;border:1px solid #ddd;border-radius:10px;max-width:200px;font-size:12px;background:#fafafa;">
  <img src="http://127.0.0.1:8000/images/abc.jpg" alt="Tên sản phẩm" style="width:80px;height:auto;border-radius:8px;margin-bottom:8px;">
  <div style="font-weight:bold;margin-bottom:4px;">Tên sản phẩm</div>
  <div style="color:#c0392b;margin-bottom:6px;">Giá: 1.000.000đ</div>
  <div style="margin-bottom:6px;">Size: 6, 7, 8</div>
  <a href="http://127.0.0.1:8000/product/slug" target="_blank" style="display:inline-block;padding:6px 12px;background:#007bff;color:#fff;text-decoration:none;border-radius:6px;">
    Xem chi tiết
  </a>
</div>

3. Nếu hỏi về **mệnh**:
   - Gợi ý màu/chất liệu hợp mệnh
   - Nếu không có, ưu tiên màu trung tính (trắng, bạc)

4. Nếu hỏi theo **dịp tặng**:
   - Chọn mẫu có ý nghĩa, thiết kế đẹp, phù hợp dịp
   - Có thể thêm lời chúc nhẹ

5. Nếu hỏi về **ngân sách**:
   - Chọn sản phẩm dưới mức giá
   - Không có thì gợi ý gần nhất

6. Nếu hỏi về **size**:
   - Trả lời: Dùng dây quấn, đo mm, gửi lại để được tư vấn

7. Nếu hỏi về **chất liệu, đá quý**:
   - Giải thích ngắn: đó là gì, ưu điểm, hợp với ai

8. Nếu không tìm thấy sản phẩm phù hợp:
   - Lịch sự từ chối và gợi ý sản phẩm gần nhất

---

❗Luôn chào thân thiện, trả lời ngắn gọn, không spam nhiều sản phẩm.
EOT;




        self::$history[] = ['role' => 'user', 'parts' => [['text' => $prompt]]];
        self::$initialized = true;
        session(['chat_history' => self::$history]);
    }



    public function chatAjax(Request $request)
    {
        self::init();
        $message = $request->prompt ?? $request->prompt;
        if (!$message || !is_string($message) || trim($message) === '') {
            return response()->json([
                'success' => false,
                'message' => 'Trường message là bắt buộc.',
                'errors' => ['message' => ['validation.required']]
            ], 422);
        }
        self::$history[] = ['role' => 'user', 'parts' => [['text' => $message]]];
        try {
            $response = Http::post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=AIzaSyBkqcA8SCP-nEnUDTJsl2mLpvV8Jnr9HtY", [
                'contents' => self::$history
            ]);

            if ($response->failed()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lỗi khi gọi API Gemini',
                    'error' => $response->body(),
                ], 500);
            }

            $text = $response->json('candidates.0.content.parts.0.text') ?? 'Không có phản hồi.';

            // Tìm sản phẩm liên quan theo tên hoặc từ khóa trong message
            $products = Product::with('firstImage')->where('name', 'like', '%' . $message . '%')->limit(3)->get();

            if ($products->count() > 0) {
                $text .= "<div style='margin-top:10px;'><strong>Sản phẩm phù hợp bạn tìm:</strong></div>";

                foreach ($products as $product) {
                    $image = optional($product->firstImage)->image ?? 'default.png';
                    $imgUrl = asset('images/' . $image);
                    $link = url('/product/' . $product->slug);
                    $price = number_format($product->price) . 'đ';

                    $text .= '
        <div style="margin:10px 0;padding:10px;border:1px solid #ddd;border-radius:10px;max-width:200px;font-size:12px;background:#fafafa;">
            <img src="' . $imgUrl . '" alt="' . e($product->name) . '" style="width:100%;height:auto;border-radius:8px;margin-bottom:8px;">
            <div style="font-weight:bold;margin-bottom:4px;">' . e($product->name) . '</div>
            <div style="color:#c0392b;margin-bottom:6px;">Giá: ' . $price . '</div>
            <a href="' . $link . '" target="_blank" style="display:inline-block;padding:6px 12px;background:#007bff;color:#fff;text-decoration:none;border-radius:6px;">
                Xem chi tiết
            </a>
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
