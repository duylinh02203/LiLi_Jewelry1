<?php

use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\CMS\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ADMIN\CategoryController;
use App\Http\Controllers\ADMIN\ProductController;
use App\Http\Controllers\CMS\ShopController;

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

Route::get('/', function () {
    return view('admin.content');
});
Route::get('dashboard', function () {
    return view('admin.content');
})->name('dashboard');

Route::get('product', [HomeController::class, 'product'])->name('product');
Route::get('admin/logout', [AdminProductController::class, 'logout'])->name('admin.logout');
Route::get('home', [HomeController::class, 'index'])->name('home');
Route::get('cart', [HomeController::class, 'cart'])->name('cart');
Route::get('contact', [HomeController::class, 'contact'])->name('contact');
Route::get('about', [HomeController::class, 'about'])->name('about');
// Route::get('show',[HomeController::class,'show'] )->name('show');
Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
Route::get('checkout', [HomeController::class, 'checkout'])->name('checkout');
Route::get('login', [HomeController::class, 'login'])->name('login');
Route::get('register', [HomeController::class, 'register'])->name('register');
//Shop
Route::get('shop', [ShopController::class, 'shop'])->name('shop');
Route::get('product/{id}', [ShopController::class, 'productDetails'])->name('shop.product.details');

Route::prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::prefix('category')
            ->as('category.')
            ->group(function () {
                Route::get('/', [CategoryController::class, 'index'])->name('index');
                Route::post('/', [CategoryController::class, 'store'])->name('store');
                Route::get('/create', [CategoryController::class, 'create'])->name('create');
                Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
                Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
                Route::get('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
            });
        Route::prefix('product')
            ->as('product.')
            ->group(function () {
                Route::get('', [ProductController::class, 'index'])->name('index');
                Route::get('/create', [ProductController::class, 'createForm'])->name('create');
                Route::post('/create', [ProductController::class, 'create'])->name('create');
                Route::get('/edit/{id}', [ProductController::class, 'editForm'])->name('edit');
                Route::put('/edit/{id}', [ProductController::class, 'edit'])->name('edit');
                Route::get('/remove/{id}', [ProductController::class, 'remove'])->name('remove');
            });
    });
