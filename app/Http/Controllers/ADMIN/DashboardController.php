<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
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

        // Chuẩn bị label và data cho thống kê trạng thái
        $labels = array_map(function ($status) use ($statusMap) {
            return $statusMap[$status] ?? ucfirst($status);
        }, array_keys($orderStats));
        $data = array_values($orderStats);

        // Thống kê doanh thu theo từng ngày
        $revenueStats = Order::selectRaw("DATE(CONVERT_TZ(created_at, '+00:00', '+07:00')) as date, SUM(total_price) as revenue")
            ->where('status', 'completed')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $revenueLabels = $revenueStats->pluck('date')->map(function ($date) {
            return date('d-m-Y', strtotime($date));
        })->toArray();
        $revenueData = $revenueStats->pluck('revenue')->toArray();
        // Doanh thu của ngày hôm nay
        $todayRevenue = Order::where('status', 'completed')
            ->whereDate('created_at', Carbon::now('Asia/Ho_Chi_Minh')->toDateString())
            ->sum('total_price');
        // Lấy tháng được chọn từ form hoặc mặc định là tháng hiện tại
        $selectedMonth = $request->input('month', date('Y-m'));
        $year = date('Y', strtotime($selectedMonth));
        $month = date('m', strtotime($selectedMonth));
        // Thống kê doanh thu theo ngày trong tháng được chọn
        $monthlyRevenueStats = Order::selectRaw("DATE(CONVERT_TZ(created_at, '+00:00', '+07:00')) as date, SUM(total_price) as revenue")
            ->where('status', 'completed')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $monthlyRevenueLabels = $monthlyRevenueStats->pluck('date')->map(function ($date) {
            return date('d-m-Y', strtotime($date));
        })->toArray();
        $monthlyRevenueData = $monthlyRevenueStats->pluck('revenue')->toArray();
        // Tổng doanh thu của tháng được chọn
        $monthlyRevenueTotal = array_sum($monthlyRevenueData);

        return view('admin.dashboard', compact(
            'productsCount',
            'categories',
            'usersCount',
            'ordersCount',
            'totalPrice',
            'labels',
            'data',
            'revenueLabels',
            'revenueData',
            'todayRevenue',
            'monthlyRevenueLabels',
            'monthlyRevenueData',
            'monthlyRevenueTotal',
            'selectedMonth'
        ));
    }
}
