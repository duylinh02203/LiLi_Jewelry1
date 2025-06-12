<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function newOrder()
    {
        $orders = Order::where('status', 'pending')->get();
        return view('admin.orders.new_order', compact('orders'));
    }

    public function acceptOrder(Request $request)
    {
        $order = Order::find($request->order_id);
        if (!$order) {
            return redirect()->back()->with('error', 'Không tìm thấy đơn hàng.');
        }
        $order->update([
            'status' => 'accepted',
        ]);
        return redirect()->back()->with('success', 'Đơn hàng đã được xác nhận.');
    }
}
