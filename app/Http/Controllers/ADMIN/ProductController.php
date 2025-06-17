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
            $sizes = collect(explode(',', $request->sizes))
                ->map(fn($size) => trim($size))
                ->filter(fn($size) => $size !== '')
                ->values();

            $isFreeSize = $sizes->isEmpty() ? 1 : 0;

            $dataProduct = [
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'listed_price' => $request->listed_price ?? '',
                'category_id' => $request->category_id,
                'gender' => $request->gender,
                'slug' => Str::slug($request->name),
                'is_free_size' => $isFreeSize,
            ];
            $createdProduct = Product::create($dataProduct);
            if (!$createdProduct) {
                return redirect()->route('product.index')->with('error', 'Thêm sản phẩm thất bại !');
            }
            if ($request->hasFile('image')) {
                foreach ($request->image as $key =>  $image) {
                    $imageName = $key .  time() . '.' . $image->extension();
                    $image->move(public_path('images'), $imageName);
                    ProductImage::create([
                        'product_id' => $createdProduct->id,
                        'image' => $imageName,
                    ]);
                }
            }
            if ($isFreeSize === 0 && $request->sizes) {
                $sizes = collect(explode(',', $request->sizes))
                    ->map(fn($size) => trim($size))
                    ->filter(fn($size) => $size !== '')
                    ->all();

                foreach ($sizes as $size) {
                    ProductSize::create([
                        'product_id' => $createdProduct->id,
                        'size' => $size,
                    ]);
                }
            }


            DB::commit();
            return redirect()->route('admin.product.index')->with('success', 'Thêm sản phẩm thành công');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('admin.product.index')->with('error', 'Thêm sản phẩm thất bại');
        }
    }

    public function editForm($id)
    {
        $categories = Category::all();
        $productSizes = ProductSize::where('product_id', $id)->pluck('size')->toArray();
        $productUpdate = Product::find($id);
        return view('admin.products.edit_product', compact(['categories', 'productUpdate', 'productSizes']));
    }

    public function edit(UpdateProductRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $oldProduct = Product::findOrFail($id);
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
            // Xử lý danh sách size sau khi trim và lọc rỗng
            $sizes = collect(explode(',', $request->sizes))
                ->map(fn($size) => trim($size))
                ->filter(fn($size) => $size !== '')
                ->values(); // reset lại key

            // Cập nhật lại is_free_size
            $oldProduct->is_free_size = $sizes->isEmpty() ? 1 : 0;
            $oldProduct->save();

            // Xoá toàn bộ size cũ
            ProductSize::where('product_id', $oldProduct->id)->delete();

            // Nếu có size mới thì tạo lại
            if (!$sizes->isEmpty()) {
                foreach ($sizes as $size) {
                    ProductSize::create([
                        'product_id' => $oldProduct->id,
                        'size' => $size,
                    ]);
                }
            }

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
            if ($oldProduct->status === 'active') {
                return redirect()->route('admin.product.index')->with('success', 'Chỉnh sửa quản sản phẩm thành công !');
            } else {
                return redirect()->route('admin.product.soldOut')->with('success', 'Chỉnh sửa sản phẩm thành công !');
            }
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
        return view('admin.products.detail', compact('product'));
    }

    public function updateStatus(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->status = $request->status;
        $product->save();

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công.');
    }
}
