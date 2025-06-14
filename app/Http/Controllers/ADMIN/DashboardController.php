<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $productsCount = Product::count();
        $categories = Category::all();
        $usersCount = User::where('role', 2)->count();
        $ordersCount = Order::where('status', 'completed')->count();
        $totalPrice = Order::where('status', 'completed')->sum('total_price');
        $statusMap = [
            'pending' => 'Chờ xác nhận',
            'accepted' => 'Đã xác nhận',
            'shipping' => 'Đang giao hàng',
            'completed' => 'Đã giao',
            'cancelled' => 'Đã hủy',
        ];

        // Đếm số đơn theo trạng thái
        $orderStats = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Chuẩn bị label và data
        $labels = array_map(function ($status) use ($statusMap) {
            return $statusMap[$status] ?? ucfirst($status);
        }, array_keys($orderStats));
        $data = array_values($orderStats);
        return view('admin.dashboard', compact('productsCount', 'categories', 'usersCount', 'ordersCount', 'totalPrice', 'labels', 'data'));
    }
}
