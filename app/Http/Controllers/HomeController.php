<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function product()
    {
        return view('admin.products.product');
    }

    public function category()
    {
        
        return view('admin.categories.category');
    }

    public function addcategory()
    {
        return view('admin.categories.addcategory');
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
}
