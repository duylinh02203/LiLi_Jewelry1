<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Http\Requests\ADMIN\CreateCategoryRequest;
use App\Http\Requests\ADMIN\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $cats = Category::all();
        return view('admin.categories.category', compact('cats'));
    }

    public function create()
    {
        return view('admin.categories.create_category');
    }

    public function store(CreateCategoryRequest $request)
    {
        try {
            $data = $request->all();
            Category::create($data);
            return redirect()->route('admin.category.index')->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.category.create')->with('error', 'Error creating category.');
        }
    }

    public function edit($id)
    {
        $categoryUpdate = Category::find($id);
        return view('admin.categories.edit_category', compact('categoryUpdate'));
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $categoryUpdate = Category::find($id);
            if (!$categoryUpdate) {
                return redirect()->route('admin.category.index')->with('error', 'Category not found.');
            }
            $data = $request->all();
            $categoryUpdate->update($data);
            DB::commit();
            return redirect()->route('admin.category.index')->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.category.index')->with('error', 'Category not found.');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $categoryDelete = Category::find($id);
            if (!$categoryDelete) {
                return redirect()->route('admin.category.index')->with('error', 'Category not found.');
            }
            $categoryDelete->delete();
            DB::commit();
            return redirect()->route('admin.category.index')->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.category.index')->with('error', 'Category not found.');
        }
    }
}
