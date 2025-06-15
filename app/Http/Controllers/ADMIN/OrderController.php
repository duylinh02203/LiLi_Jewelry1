<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Jobs\AcceptedOrder;
use App\Jobs\CancelledOrder;
use Illuminate\Support\Str;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function newOrder(Request $request)
    {
        $query = Order::with('orderItems.product')->where('status', 'pending')->orderBy('created_at', 'desc');
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;

            if (Str::startsWith($search, 'JL00')) {
                $id = (int) Str::replaceFirst('JL00', '', $search);
                $query->where('id', $id);
            } else {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->orWhere('id', (int) $search);
                });
            }
        }
        $orders = $query->paginate(5);
        return view('admin.orders.new_order', compact('orders'));
    }

    public function orderAll(Request $request)
    {
        $query = Order::with('orderItems.product')
            ->whereIn('status', ['shipping', 'completed']);

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;

            if (Str::startsWith($search, 'JL00')) {
                $id = (int) Str::replaceFirst('JL00', '', $search);
                $query->where('id', $id);
            } else {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->orWhere('id', (int) $search);
                });
            }
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $query->orderByRaw("FIELD(status, 'shipping', 'completed')")
            ->orderBy('created_at', 'desc');

        $orders = $query->paginate(5);

        $statusMap = [
            'shipping' => 'Đang giao hàng',
            'completed' => 'Đã giao',
        ];

        return view('admin.orders.order_all', compact('orders', 'statusMap'));
    }


    public function orderCancelled(Request $request)
    {
        $query = Order::with('orderItems.product')->onlyTrashed();

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;

            if (Str::startsWith($search, 'JL00')) {
                $id = (int) Str::replaceFirst('JL00', '', $search);
                $query->where('id', $id);
            } else {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->orWhere('id', (int) $search);
                });
            }
        }
        $query->orderBy('created_at', 'desc');
        $orders = $query->paginate(5);
        return view('admin.orders.order_cancelled', compact('orders'));
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

    public function cancelOrder(Request $request)
    {
        DB::beginTransaction();
        try {
            $order = Order::find($request->order_id);

            if (!$order) {
                return back()->with('error', 'Không tìm thấy đơn hàng.');
            }

            if (in_array($order->status, ['shipping', 'completed'])) {
                return back()->with('error', 'Không thể hủy đơn hàng ở trạng thái hiện tại.');
            }
            $orderWithItems = Order::with('orderItems.product')->find($order->id);
            $order->delete();
            DB::commit();
            CancelledOrder::dispatch($orderWithItems);
            return back()->with('success', 'Đơn hàng đã được hủy.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Đã xảy ra lỗi khi hủy đơn hàng.');
        }
    }


    public function detail($id)
    {
        $order = Order::with('orderItems.product')->withTrashed()->find($id);
        if (!$order) {
            return redirect()->back()->with('error', 'Đơn hàng không tồn tại.');
        }
        return view('admin.orders.order_detail', compact('order'));
    }
}
