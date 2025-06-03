<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\UserInfor;

class HomeController extends Controller
{

    public function index()
    {
        $user = session('userData');
        $categories = Category::with('products')->orderBy('created_at', 'desc')->get();
        $newCategories = Category::withCount('products')->orderBy('products_count', 'desc')->take(3)->get();
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

    public function contact()
    {
        $userData = null;

        if (session()->has('userData')) {
            $sessionUserData = session('userData');

            $userInfor = UserInfor::where('user_id', $sessionUserData['id'])->first();

            $userData = [
                'email' => $sessionUserData['email'],
                'phone' => $userInfor->phone ?? null,
            ];
        }
        return view('cms.contact.contact', compact('userData'));
    }

    public function review()
    {
        return view('cms.review.review_shop');
    }

    public function checkout()
    {
        return view('cms.checkout.checkout');
    }
    public function wishlist()
    {
        return view('cms.wishlist.wishlist');
    }
}
