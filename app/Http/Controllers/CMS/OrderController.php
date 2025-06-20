<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function allOrders()
    {
        $idUser = session('userData')->id;
        $allOrders = Order::where('user_id', $idUser)->get();

        $allOrdersCancelled = Order::onlyTrashed()->where('user_id', $idUser)->get();
        return view('cms.order.all_order', compact('allOrders', 'allOrdersCancelled'));
    }

    public function detail($id)
    {
        $order = Order::with('orderItems.product')->withTrashed()->find($id);
        if (!$order) {
            return redirect()->back()->with('error', 'Đơn hàng không tồn tại.');
        }
        $userCancel = User::find($order->status);
        return view('cms.order.detail_order', compact('order', 'userCancel'));
    }

    public function cancelOrder(Request $request)
    {
        $order = Order::find($request->order_id);

        if (!$order) {
            return back()->with('error', 'Không tìm thấy đơn hàng.');
        }

        if (in_array($order->status, ['shipping', 'completed'])) {
            return back()->with('error', 'Không thể hủy đơn hàng ở trạng thái hiện tại.');
        }

        $orderWithItems = Order::with('orderItems.product')->find($order->id);
        $order->delete();
        return back()->with('success', 'Đơn hàng đã được hủy.');
    }

    public function completeOrder(Request $request)
    {
        $order = Order::find($request->order_id);
        if (!$order) {
            return back()->with('error', 'Không tìm thấy đơn hàng.');
        }
        $order->update(['status' => 'completed']);
        return back()->with('success', 'Đơn hàng đã được hoàn thành.');
    }

    public function getOrderProducts($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);

        $products = $order->orderItems->map(function ($detail) {
            return [
                'id' => $detail->product->id,
                'name' => $detail->product->name,
                'slug' => $detail->product->slug,
            ];
        });

        return response()->json(['products' => $products]);
    }
}
