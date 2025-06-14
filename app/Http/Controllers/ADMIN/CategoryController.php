<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Requests\ADMIN\CreateCategoryRequest;
use App\Http\Requests\ADMIN\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\ProductImage;


class CategoryController extends Controller
{
    public function index()
    {
        $cats = Category::paginate(5);
        return view('admin.categories.category', compact('cats'));
    }

    public function create()
    {
        return view('admin.categories.create_category');
    }

    public function store(CreateCategoryRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'name' => $request->name,
                'slug' => Str::slug($request->name),
            ];
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->extension();
                $image->move(public_path('images/categories'), $imageName);
                $data['image'] = $imageName;
            }
            $createdCategory = Category::create($data);
            if (!$createdCategory) {
                DB::rollBack();
                return redirect()->route('admin.category.index')->with('error', 'Category creation failed.');
            }
            DB::commit();
            return redirect()->route('admin.category.index')->with('success', 'Thêm danh mục thành công.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('admin.category.create')->with('error', 'Lỗi thêm danh mục: ' . $th->getMessage());
        }
    }

    public function editForm($id)
    {
        $categoryUpdate = Category::find($id);
        return view('admin.categories.edit_category', compact('categoryUpdate'));
    }
    public function edit(UpdateCategoryRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $oldCategory = Category::findOrFail($id);
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->extension();
                $image->move(public_path('images/categories'), $imageName);

                if ($oldCategory->image && file_exists(public_path('images/categories/' . $oldCategory->image))) {
                    unlink(public_path('images/categories/' . $oldCategory->image));
                }
                $oldCategory->image = $imageName;
            }
            $oldCategory->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'image' => $oldCategory->image,
            ]);
            DB::commit();
            return redirect()->route('admin.category.index')->with('success', 'Chỉnh sửa danh mục thành công.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('admin.category.index')->with('error', 'Chỉnh sửa danh mục thất bại: ' . $th->getMessage());
        }
    }

    public function searchCategory(Request $request)
    {
        dd($request->all());
        $search = $request->search;
        $cats = Category::where('name', 'like', "%$search%")->get();
        return view('admin.categories.category', compact('cats'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $categoryDelete = Category::find($id);
            $product = Product::where('category_id', $id);
            if ($product->count() > 0) {
                return redirect()->route('admin.category.index')->with('error', 'Không thể xóa danh mục vì nó có sản phẩm.');
            }
            if (!$categoryDelete) {
                return redirect()->route('admin.category.index')->with('error', 'Không tìm thấy danh mục.');
            }
            $categoryDelete->delete();
            DB::commit();
            return redirect()->route('admin.category.index')->with('success', 'Xóa danh mục thành công.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('admin.category.index')->with('error', 'Xóa danh mục không thành công.');
        }
    }

    public function detail($id)
    {
        $cat = Category::find($id);
        return view('admin.categories.detail', compact('cat'));
    }
}
