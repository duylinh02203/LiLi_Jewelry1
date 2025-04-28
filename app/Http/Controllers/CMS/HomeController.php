<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;



class HomeController extends Controller
{

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
        $products = Product::with('images')->where('status', 'active')->paginate(5);
        return view('cms.shop.shop', compact('products'));
    }
    public function productDetails($slug)
    {   
        $product = Product::where('slug', $slug)->first();
        return view('cms.show.show', compact('product'));
    }

    public function contact()
    {
        return view('cms.contact.contact');
    }

    public function about()
    {
        return view('cms.about.about');
    }

    public function show()
    {
        return view('cms.show.show');
    }

    public function dashboard()
    {
        return view('cms.user.dashboard');
    }

    public function checkout()
    {
        return view('cms.checkout.checkout');
    }

    public function login()
    {
        return view('cms.account.login');
    }

    public function register()
    {
        return view('cms.account.register');
    }
}
