<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;


class HomeController extends Controller
{
    
    public function category()
    {
        
        return view('admin.categories.category');
    }

    public function addcategory()
    {
        return view('admin.categories.create_category');
    }

    public function setting()
    {
        return view('admin.setting.sett');
    }

    public function order()
    {
        return view('admin.orders.order');
    }

    public function order_chuaduyet()
    {
        return view('admin.orders.chuaduyet');
    }
    public function product()
    {
        return view('admin.products.product');
    }
}
