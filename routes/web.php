<?php

use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\CategoryController;
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

// Route::get('category',[HomeController::class,'category'] )->name('category');

Route::get('create_category',[HomeController::class,'create_category'] )->name('create.category');
Route::get('admin/order',[HomeController::class,'order'] )->name('order');
Route::get('setting',[HomeController::class,'setting'] )->name('setting.update');
Route::get('admin/order_chuaduyet',[HomeController::class,'order_chuaduyet'] )->name('chuaduyet');

// Route::resource('category', CategoryController::class);
//Route Category

Route::get('category',[CategoryController::class,'index'] )->name('category.index');
Route::post('category',[CategoryController::class,'store'] )->name('category.store');
Route::get('category/create',[CategoryController::class,'create'] )->name('category.create');
Route::put('category/{category}',[CategoryController::class,'update'] )->name('category.update');
Route::get('category/{category}',[CategoryController::class,'destroy'] )->name('category.destroy');
Route::get('category/{category}/edit',[CategoryController::class,'edit'] )->name('category.edit');

// Route::get('login', function () {
//     return view('admin.layouts.login');
// })->name('login');
//Route Product
