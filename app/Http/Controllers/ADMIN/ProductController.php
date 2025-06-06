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
        $query = Product::with(['images', 'category', 'sizes']);
        $categories = Category::all();
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
        $query->orderBy('created_at', 'desc');
        $products = $query->paginate(5);
        return view('admin.products.product', compact('products', 'categories'));
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
            $status = $request->quantity && $request->quantity > 0 ? 'active' : 'inactive';
            $isFreeSize = empty($request->sizes) ? 1 : 0;
            $dataProduct = [
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'listed_price' => $request->listed_price ?? '',
                'category_id' => $request->category_id,
                'gender' => $request->gender,
                'quantity' => $request->quantity ?? 0,
                'slug' => Str::slug($request->name),
                'status' => $status,
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
                $sizes = explode(',', $request->sizes);
                foreach ($sizes as $size) {
                    ProductSize::create([
                        'product_id' => $createdProduct->id,
                        'size' => trim($size),
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
            $newStatus = $request->quantity && $request->quantity > 0 ? 'active' : 'inactive';
            if ((!$request->has('is_free_size')) && $request->has('sizes')) {
                $sizes = explode(',', $request->sizes);
                ProductSize::where('product_id', $oldProduct->id)->delete();
                foreach ($sizes as $size) {
                    ProductSize::create([
                        'product_id' => $oldProduct->id,
                        'size' => trim($size),
                    ]);
                }
            } else {
                ProductSize::where('product_id', $oldProduct->id)->delete();
            }
            $newProduct = [
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'listed_price' => $request->listed_price,
                'category_id' => $request->category_id ?? $oldProduct->category_id,
                'gender' => $request->gender ?? $oldProduct->gender,
                'status' => $newStatus,
                'slug' => Str::slug($request->name),
                'quantity' => $request->quantity ?? $oldProduct->quantity,
                'is_free_size' => $request->has('is_free_size') ? 1 : 0,
            ];
            $oldProduct->update($newProduct);

            DB::commit();
            return redirect()->route('admin.product.index')->with('success', 'Sửa sản phẩm thành công');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('admin.product.index')->with('error', 'Sửa sản phẩm thất bại: ' . $th->getMessage());
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
            return redirect()->route('admin.product.index')->with('success', 'Xóa sản phẩm thành công');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('admin.product.index')->with('error', 'Xóa sản phẩm thất bại');
        }
    }

    public function detail($id)
    {
        $product = Product::with('images', 'category')->findOrFail($id);
        return view('admin.products.detail', compact('product'));
    }

    public function searchProduct(Request $request)
    {
        $search = $request->search;
        $products = Product::with(['images', 'category'])
            ->where('name', 'LIKE', "%{$search}%")
            ->paginate(5);
        $categories = Category::all();
        return view('admin.products.product', compact('products','categories'));
    }
}
