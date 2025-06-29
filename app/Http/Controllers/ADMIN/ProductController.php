<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Requests\ADMIN\CreateProductRequest;
use App\Http\Requests\ADMIN\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductReview;
use App\Models\ProductSize;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $categoryId = $request->category;

        $query = Product::with(['images', 'category', 'sizes'])
            ->where('status', 'active')
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            })
            ->when($categoryId && $categoryId !== 'all', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            })
            ->orderBy('created_at', 'desc');

        $products = $query->paginate(5);
        $categories = Category::all();

        return view('admin.products.product', compact('products', 'categories'));
    }


    public function soldOut(Request $request)
    {

        $search = $request->search;
        $categoryId = $request->category;

        $query = Product::with(['images', 'category', 'sizes'])
            ->where('status', 'soldout')
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            })
            ->when($categoryId && $categoryId !== 'all', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            })
            ->orderBy('created_at', 'desc');

        $products = $query->paginate(5);
        $categories = Category::all();
        return view('admin.products.soldout', compact('products', 'categories'));
    }




    public function createForm()
    {
        $categories = Category::all();
        return view('admin.products.create_product', compact('categories'));
    }

    public function create(CreateProductRequest $request)
    {
        DB::beginTransaction();
        try {
            // Lấy danh sách size từ JSON (nếu có)
            $sizesJson = $request->input('sizes');
            $parsedSizes = collect(json_decode($sizesJson, true));

            $isFreeSize = $parsedSizes->isEmpty() ? 1 : 0;

            // ✅ Tính tổng số lượng từ các size, nếu có size
            $totalQuantity = $isFreeSize
                ? $request->quantity
                : $parsedSizes->sum('quantity');

            // Tạo sản phẩm
            $dataProduct = [
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'listed_price' => $request->listed_price ?? '',
                'category_id' => $request->category_id,
                'gender' => $request->gender,
                'quantity' => $totalQuantity,
                'slug' => Str::slug($request->name),
                'is_free_size' => $isFreeSize,
            ];

            $createdProduct = Product::create($dataProduct);
            if (!$createdProduct) {
                return redirect()->route('admin.product.index')->with('error', 'Thêm sản phẩm thất bại!');
            }

            // Upload ảnh
            if ($request->hasFile('image')) {
                foreach ($request->image as $key => $image) {
                    $imageName = $key . time() . '.' . $image->extension();
                    $image->move(public_path('images'), $imageName);

                    ProductImage::create([
                        'product_id' => $createdProduct->id,
                        'image' => $imageName,
                    ]);
                }
            }

            // Thêm size và số lượng vào bảng product_sizes nếu có
            if (!$isFreeSize) {
                foreach ($parsedSizes as $sizeData) {
                    if (!isset($sizeData['size']) || !isset($sizeData['quantity'])) continue;

                    ProductSize::create([
                        'product_id' => $createdProduct->id,
                        'size' => $sizeData['size'],
                        'quantity' => $sizeData['quantity'],
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.product.index')->with('success', 'Thêm sản phẩm thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }


    public function editForm($id)
    {
        $categories = Category::all();

        // ✅ Lấy cả size và quantity
        $productSizes = ProductSize::where('product_id', $id)->get(['size', 'quantity']);

        $productUpdate = Product::find($id);
        return view('admin.products.edit_product', compact(['categories', 'productUpdate', 'productSizes']));
    }


    public function edit(UpdateProductRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $oldProduct = Product::findOrFail($id);

            // ✅ Xử lý ảnh nếu có
            if ($request->hasFile('image')) {
                $images = $request->file('image');
                if (is_array($images)) {
                    foreach ($images as $key => $image) {
                        $imageName = $key . time() . '.' . $image->extension();
                        $image->move(public_path('images'), $imageName);
                        ProductImage::create([
                            'product_id' => $oldProduct->id,
                            'image' => $imageName,
                        ]);
                    }
                }
            }

            // ✅ Xử lý sizes từ JSON (gửi từ view)
            $sizesJson = $request->input('sizes'); // Chuỗi JSON
            $sizes = json_decode($sizesJson, true); // Mảng dạng: [['size' => 'M', 'quantity' => 10], ...]

            // Nếu không phải array hợp lệ
            if (!is_array($sizes)) {
                throw new \Exception("Dữ liệu size không hợp lệ");
            }

            // Xoá toàn bộ size cũ
            ProductSize::where('product_id', $oldProduct->id)->delete();

            $totalQuantity = 0;
            foreach ($sizes as $item) {
                $size = trim($item['size'] ?? '');
                $quantity = intval($item['quantity'] ?? 0);

                if ($size !== '' && $quantity >= 0) {
                    ProductSize::create([
                        'product_id' => $oldProduct->id,
                        'size' => $size,
                        'quantity' => $quantity,
                    ]);
                    $totalQuantity += $quantity;
                }
            }

            // ✅ Nếu không có size thì là freesize
            $isFreeSize = count($sizes) === 0;
            $oldProduct->is_free_size = $isFreeSize;
            $oldProduct->quantity = $isFreeSize
                ? intval($request->input('quantity')) // nếu freesize thì lấy từ input "quantity"
                : $totalQuantity; // nếu có size thì lấy tổng size
            $oldProduct->save();

            // ✅ Update thông tin chung của sản phẩm
            $newProduct = [
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'listed_price' => $request->listed_price,
                'category_id' => $request->category_id ?? $oldProduct->category_id,
                'gender' => $request->gender ?? $oldProduct->gender,
                'slug' => Str::slug($request->name),
            ];
            $oldProduct->update($newProduct);

            DB::commit();

            return redirect()
                ->route($oldProduct->status === 'active' ? 'admin.product.index' : 'admin.product.soldOut')
                ->with('success', 'Chỉnh sửa sản phẩm thành công !');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Sửa sản phẩm thất bại: ' . $th->getMessage());
        }
    }


    public function remove($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::find($id);
            if (!$product) {
                return redirect()->route('admin.product.index')->with('error', 'Không tìm thấy sản phẩm');
            }
            ProductSize::where('product_id', $id)->delete();
            Wishlist::where('product_id', $id)->delete();
            ProductReview::where('product_id', $id)->delete();
            $product->delete();
            DB::commit();
            if ($product->status === 'active') {
                return redirect()->route('admin.product.index')->with('success', 'Xóa quản sản phẩm thành công !');
            } else {
                return redirect()->route('admin.product.soldOut')->with('success', 'Xóa sản phẩm thành công !');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Xóa sản phẩm thất bại');
        }
    }

    public function detail($id)
    {
        $product = Product::with('images', 'category')->findOrFail($id);
        if ($product->listed_price && $product->listed_price > $product->price) {
            $sale = round((($product->listed_price - $product->price) / $product->listed_price) * 100);
        }
        $reviewStats = ProductReview::where('product_id', $id)
            ->selectRaw('COUNT(*) as total_reviews, AVG(rating) as avg_rating')
            ->first();

        $totalReviews = $reviewStats->total_reviews ?? 0;
        $avgRating = round($reviewStats->avg_rating) ?? 0;
        return view('admin.products.detail', compact('product', 'sale','totalReviews', 'avgRating'));
    }

    public function updateStatus(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->status = $request->status;
        $product->save();

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công.');
    }
}
