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
        $categories = Category::with('products')->orderBy('created_at', 'desc')->get();
        $newCategories = $categories->take(3);
        $products = Product::with('images')->where('status', 'active')->orderBy('created_at', 'desc')->take(12)->get();
        return view('cms.home.content', compact('categories', 'products', 'newCategories'));
    }

    public function products($slug)
    {
        $categories = Category::where('slug', $slug)->firstOrFail();

        $products = Product::with('images', 'category')
            ->where('category_id', $categories->id)
            ->paginate(10);

        return view('cms.shop.shop', compact('products'));
    }


    public function cart()
    {
        return view('cms.cart.cart');
    }

    public function contact()
    {
        return view('cms.contact.contact');
    }

    public function about()
    {
        return view('cms.about.about');
    }

    public function dashboard()
    {
        return view('cms.user.dashboard');
    }

    public function checkout()
    {
        return view('cms.checkout.checkout');
    }
}
