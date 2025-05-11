<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Requests\ADMIN\CreateProductRequest;
use App\Http\Requests\ADMIN\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['images', 'category'])->paginate(10);
        return view('admin.products.product', compact('products'));
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
            ];
            $createdProduct = Product::create($dataProduct);
            if (!$createdProduct) {
                return redirect()->route('product.index')->with('error', 'Product created failed');
            } else {
                foreach ($request->image as $key =>  $image) {
                    $imageName = $key .  time() . '.' . $image->extension();
                    $image->move(public_path('images'), $imageName);
                    ProductImage::create([
                        'product_id' => $createdProduct->id,
                        'image' => $imageName,
                    ]);
                }
                DB::commit();
                return redirect()->route('admin.product.index')->with('success', 'Product created successfully');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('admin.product.index')->with('error', 'Product created failed');
        }
    }

    public function editForm($id)
    {
        $categories = Category::all();
        $productUpdate = Product::find($id);
        return view('admin.products.edit_product', compact(['categories', 'productUpdate']));
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
            ];
            $oldProduct->update($newProduct);

            DB::commit();
            return redirect()->route('admin.product.index')->with('success', 'Product updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('admin.product.index')->with('error', 'Product update failed: ' . $th->getMessage());
        }
    }

    public function remove($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::find($id);
            if (!$product) {
                return redirect()->route('admin.product.index')->with('error', 'Product not found');
            }
            $product->delete();
            DB::commit();
            return redirect()->route('admin.product.index')->with('success', 'Product deleted successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('admin.product.index')->with('error', 'Product deleted failed');
        }
    }
}
