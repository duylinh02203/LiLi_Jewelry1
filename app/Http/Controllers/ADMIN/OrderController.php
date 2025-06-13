<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Jobs\AcceptedOrder;
use Illuminate\Support\Str;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function newOrder()
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(5);
        return view('admin.orders.new_order', compact('orders'));
    }

    public function acceptOrder(Request $request)
    {
        $order = Order::find($request->order_id);
        $status = $request->status;
        if (!$order) {
            return redirect()->back()->with('error', 'Không tìm thấy đơn hàng.');
        }
        $order->update([
            'status' => $status,
        ]);
        return redirect()->back()->with('success', 'Chính sửa trạng thái thành công !');
    }

    public function searchOrder(Request $request)
    {
        $search = $request->input('search');
        if (Str::startsWith($search, 'DL00')) {
            $id = (int) Str::replaceFirst('DL00', '', $search);
            $orders = Order::where('id', $id)->paginate(2);
        } else {
            $orders = Order::where('name', 'like', "%$search%")
                ->orWhere('id', (int) $search)
                ->paginate(5);
        }

        return view('admin.orders.new_order', compact('orders'));
    }

    public function cancelOrder(Request $request)
    {
        $order = Order::find($request->order_id);
        if (!$order) {
            return back()->with('error', 'Không tìm thấy đơn hàng.');
        }

        if (!in_array($order->status, ['pending', 'accepted'])) {
            return back()->with('error', 'Không thể hủy đơn hàng ở trạng thái hiện tại.');
        }

        $order->update(['status' => 'cancelled']);
        return back()->with('success', 'Đơn hàng đã được hủy.');
    }
    public function detail($id)
    {
        $order = Order::with('orderItems.product')->find($id);
        if (!$order) {
            return redirect()->back()->with('error', 'Đơn hàng không tồn tại.');
        }
        return view('admin.orders.order_detail', compact('order'));
    }
}
