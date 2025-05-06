<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    // public function shop(Request $request)
    // {
    //     $page = $request->query('page', 1);
    //     $size = $request->query('size', 5);
    //     $sort = $request->query('sort','price_asc');
    //     $range = $request->query('range', '0,500000000');
    //     $q= $request->query('q', '');
    //     $category_ids = $request->query('category', []);

    //     $categories = Category::all();
    //     $query = Product::with('images')->where('status', 'active');

    //     if (!empty($category_ids)) {
    //         $query->whereIn('category_id', $category_ids);
    //     }
    //     switch ($sort) {
    //         case 'newest':
    //             $query->orderBy('created_at', 'desc');
    //             break;
    //         case 'price_asc':
    //             $query->orderBy('price', 'asc');
    //             break;
    //         case 'price_desc':
    //             $query->orderBy('price', 'desc');
    //             break;
    //     }

    //     $from = explode(',', $range)[0];
    //     $to = explode(',', $range)[1];
    //     $query->whereBetween('price', [$from, $to]);
    //     $query->where('name', 'like', '%' . $q . '%');
    //     $products = $query->paginate($size)->appends($request->query());
    //     return view('cms.shop.shop', compact('products', 'categories', 'page', 'size', 'sort', 'from', 'to','q'));
    // }
    public function shop(Request $request)
    {
        // Lấy các tham số từ request
        $page = $request->query('page', 1);
        $size = $request->query('size', 5);
        $sort = $request->query('sort', 'price_asc');
        $q = $request->query('q', '');
        $category_ids = $request->query('category', []);
        $price = $request->query('price', []); 
        $gender = $request->query('gender', []); 
        
        $categories = Category::all();
    
        $query = Product::with('images')->where('status', 'active');

        if (!empty($category_ids)) {
            $query->whereIn('category_id', $category_ids);
        }
        if (!empty($gender)) {
            $query->whereIn('gender', $gender);
        }
        if (!empty($price)) {
            $query->where(function ($q) use ($price) {
                foreach ($price as $range) {
                    [$from, $to] = explode(',', $range);
                    $q->orWhereBetween('price', [(float)$from, (float)$to]);
                }
            });
        }
    
        if (!empty($q)) {
            $query->where('name', 'like', '%' . $q . '%');
        }
    
        switch ($sort) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->orderBy('price', 'asc');
                break;
        }
    
        $products = $query->paginate($size)->appends($request->query());
    
        return view('cms.shop.shop', compact('products', 'categories', 'page', 'size', 'sort', 'q', 'price', 'category_ids','gender'));
    }
    
    public function productDetails($id)
    {
        $product = Product::with('images')->findOrFail($id);
        return view('cms.show.show', compact('product'));
    }
}
