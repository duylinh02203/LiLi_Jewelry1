<?php

use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\CMS\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ADMIN\CategoryController;
use App\Http\Controllers\ADMIN\ContactController;
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
Route::get('checkout', [HomeController::class, 'checkout'])->name('checkout');
Route::get('login', [HomeController::class, 'login'])->name('login');
Route::get('register', [HomeController::class, 'register'])->name('register');
//Shop
Route::get('shop', [ShopController::class, 'shop'])->name('shop');
Route::get('product/{slug}', [ShopController::class, 'productDetails'])->name('shop.product.details');
//success
Route::get('/contact-us/success', [ContactController::class, 'success'])->name('admin.contact.success');

Route::prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::prefix('category')
            ->as('category.')
            ->group(function () {
                Route::get('/', [CategoryController::class, 'index'])->name('index');
                Route::post('/', [CategoryController::class, 'store'])->name('store');
                Route::get('/create', [CategoryController::class, 'create'])->name('create');
                Route::get('/edit/{id}', [CategoryController::class, 'editForm'])->name('edit');
                Route::put('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
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
        Route::prefix('contact')
            ->as('contact.')
            ->group(function () {
                Route::get('', [ContactController::class, 'index'])->name('index');
                Route::post('/create', [ContactController::class, 'create'])->name('create');
                Route::get('/remove/{id}', [ContactController::class, 'remove'])->name('remove');
            });
        Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    });
