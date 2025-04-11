<?php

use App\Http\Controllers\AdminProductController;
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

Route::get('product',[AdminProductController::class,'product'] )->name('product');
Route::get('category',[AdminProductController::class,'category'] )->name('category');
Route::get('addCategory',[AdminProductController::class,'addcategory'] )->name('addCategory');
Route::get('admin/order',[AdminProductController::class,'order'] )->name('order');
Route::get('setting',[AdminProductController::class,'setting'] )->name('setting.update');
Route::get('admin/order_chuaduyet',[AdminProductController::class,'order_chuaduyet'] )->name('chuaduyet');

// Route::get('login', function () {
//     return view('admin.layouts.login');
// })->name('login');
