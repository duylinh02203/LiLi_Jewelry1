<?php

namespace App\Http\Controllers;

use App\Models\Category;

use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_name' => 'required',
            'category_description' => 'required',
        ]);
        Category::create($data);
        return redirect()->route('category.index')->with('success', 'Category created successfully.');
        // $category = new Category();
        // $category->category_name = $request->input('category_name');
        // $category->category_description = $request->input('category_description');
        // $category->save();
        // return redirect()->route('category.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit_category', compact('category'));
    }

    public function update(Request $request, Category $category)
    {

        $name = $request->input('category_name');
        $description = $request->input('category_description');
        $category->update([
            'category_name' => $name,
            'category_description' => $description,
        ]);
        return redirect()->route('category.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Category deleted successfully.');
    }
}
