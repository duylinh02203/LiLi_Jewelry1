<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function allOrders()
    {
        $idUser = session('userData')->id;
        $allOrders = Order::where('user_id', $idUser)->get();
        return view('cms.order.all_order', compact('allOrders'));
    }
}
