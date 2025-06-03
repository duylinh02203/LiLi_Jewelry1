<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $productsCount = Product::count();
        $categories = Category::all();
        $usersCount = User::where('role', 2)->count();
        return view('admin.dashboard', compact('productsCount', 'categories', 'usersCount'));
    }
}
