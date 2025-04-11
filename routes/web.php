<?php

use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('app', function () {
    return view('admin.content');
});
Route::get('dashboard', function () {
    return view('admin.content');
})->name('dashboard');

// Route::get('product', function () {
//     return view('admin.layouts.products.product');
// })->name('product');

Route::get('product',[HomeController::class,'product'] )->name('product');
Route::get('category',[HomeController::class,'category'] )->name('category');
Route::get('addCategory',[HomeController::class,'addcategory'] )->name('addCategory');
Route::get('admin/order',[HomeController::class,'order'] )->name('order');
Route::get('setting',[HomeController::class,'setting'] )->name('setting.update');
Route::get('admin/order_chuaduyet',[HomeController::class,'order_chuaduyet'] )->name('chuaduyet');

// Route::get('login', function () {
//     return view('admin.layouts.login');
// })->name('login');
