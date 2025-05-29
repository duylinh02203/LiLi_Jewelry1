<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function logout()
    {

        return view('admin.auth.login');
    }
    public function index()
    {

        return view('cms.home.content');
    }

    public function cart()
    {
        return view('cms.cart.cart');
    }
    public function shop()
    {
        $products = Product::with('images')->where('status', 'active')->get();
        dd($products);
        return view('cms.shop.shop', compact('products'));
    }
}
