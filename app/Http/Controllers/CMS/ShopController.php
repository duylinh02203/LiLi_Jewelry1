<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function shop(Request $request)
    {
        $page = $request->query('page', 1);
        $size = $request->query('size', 5);
        $sort = $request->query('sort');
        $prange = $request->query('prange', '0,500000000');

        $categories = Category::all();
        $query = Product::with('images')->where('status', 'active');

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
        }

        $from = explode(',', $prange)[0];
        $to = explode(',', $prange)[1];
        $query->whereBetween('price', [$from, $to]);

        $products = $query->paginate($size)->appends($request->query());
        return view('cms.shop.shop', compact('products', 'categories', 'page', 'size', 'sort', 'from', 'to'));
    }

    public function productDetails($id)
    {
        $product = Product::with('images')->findOrFail($id);
        return view('cms.show.show', compact('product'));
    }
}
