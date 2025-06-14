<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Jobs\AcceptedOrder;
use App\Jobs\CancelledOrder;
use Illuminate\Support\Str;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function newOrder()
    {
        $query = Order::with('orderItems.product')->where('status', 'pending')->orderBy('created_at', 'desc');
        if (request()->has('status') && request()->status !== 'all') {
            $query->where('status', request()->status);
        }
        $orders = $query->paginate(5);
        return view('admin.orders.new_order', compact('orders'));
    }


    public function acceptOrder(Request $request)
    {
        DB::beginTransaction();
        try {
            $order = Order::find($request->order_id);
            $status = 'shipping';
            if (!$order) {
                return redirect()->back()->with('error', 'Không tìm thấy đơn hàng.');
            }
            $order->update([
                'status' => $status,
            ]);
            DB::commit();
            $orderWithItems = Order::with('orderItems.product')->find($order->id);
            AcceptedOrder::dispatch($orderWithItems);
            return redirect()->back()->with('success', 'Xác nhận đơn hàng thành công !');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('success', 'Xác nhận đơn hàng thất bại !');
        }
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
        DB::beginTransaction();
        try {
            $order = Order::find($request->order_id);
            if (!$order) {
                return back()->with('error', 'Không tìm thấy đơn hàng.');
            }
            if ($order->status == 'shipping' || $order->status == 'completed') {
                return back()->with('error', 'Không thể hủy đơn hàng ở trạng thái hiện tại.');
            }
            $orderWithItems = Order::with('orderItems.product')->find($order->id);
            $order->delete();
            DB::commit();
            CancelledOrder::dispatch($orderWithItems);
            return back()->with('success', 'Đơn hàng đã được hủy.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Đã xảy ra lỗi khi hủy đơn hàng.');
        }
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
