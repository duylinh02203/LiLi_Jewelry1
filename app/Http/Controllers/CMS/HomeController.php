<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\UserInfor;

class HomeController extends Controller
{
    public function handbook_1()
    {
        return view('cms.handbook.handbook_1');
    }
    public function handbook_2()
    {
        return view('cms.handbook.handbook_2');
    }
    public function handbook_3()
    {
        return view('cms.handbook.handbook_3');
    }
    public function handbook_4()
    {
        return view('cms.handbook.handbook_4');
    }


    public function index()
    {
        $user = session('userData');

        $categories = Category::with('products')->orderBy('created_at', 'desc')->get();

        $newCategories = Category::withCount('products')
            ->orderBy('products_count', 'desc')
            ->take(3)
            ->get();

        $products = Product::with('images')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->take(12)
            ->get();

        $productSales = Product::where('status', 'active')
            ->whereRaw(
                'ROUND((CAST(listed_price AS SIGNED) - CAST(price AS SIGNED)) / listed_price * 100) BETWEEN 30 AND 45'
            )
            ->get();

        return view('cms.home.content', compact(
            'user',
            'categories',
            'products',
            'newCategories',
            'productSales'
        ));
    }

    public function products($slug)
    {
        $categories = Category::where('slug', $slug)->firstOrFail();
        $products = Product::with('images', 'category')
            ->where('status', 'active')
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
