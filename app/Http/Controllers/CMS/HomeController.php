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
