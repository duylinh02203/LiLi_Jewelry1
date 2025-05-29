<?php

use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\CMS\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ADMIN\CategoryController;
use App\Http\Controllers\ADMIN\ContactController;
use App\Http\Controllers\ADMIN\ProductController;
use App\Http\Controllers\CMS\AuthController;
use App\Http\Controllers\ADMIN\AuthController as AuthAdminController;
use App\Http\Controllers\CMS\ShopController;
use App\Http\Controllers\ADMIN\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('product', [HomeController::class, 'product'])->name('product');
Route::get('home', [HomeController::class, 'index'])->name('home');
Route::get('cart', [HomeController::class, 'cart'])->name('cart');
Route::get('contact', [HomeController::class, 'contact'])->name('contact');
Route::get('about', [HomeController::class, 'about'])->name('about');
Route::get('checkout', [HomeController::class, 'checkout'])->name('checkout');
//Shop
Route::get('shop', [ShopController::class, 'shop'])->name('shop');
Route::get('product/{slug}', [ShopController::class, 'productDetails'])->name('shop.product.details');
//success
Route::get('/contact-us/success', [ContactController::class, 'success'])->name('admin.contact.success');


// cms
Route::prefix('auth')->group(
    function () {
        Route::get('login', [AuthController::class, 'login'])->name('login');
        Route::post('login', [AuthController::class, 'loginAction'])->name('login.action');
        Route::get('register', [AuthController::class, 'register'])->name('register');
        Route::post('register', [AuthController::class, 'registerAction'])->name('register');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
        Route::post('forgot-password', [AuthController::class, 'forgotPasswordAction'])->name('forgot-password');
    }
);

Route::middleware('auth.login')->group(function () {
    Route::get('information', [AuthController::class, 'information'])->name('information');
});

Route::prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/login', [AuthAdminController::class, 'login'])->name('login');
        Route::post('/login', [AuthAdminController::class, 'loginAction'])->name('login');
        Route::middleware('auth.admin.login')->group(function () {
            Route::get('logout', [AuthAdminController::class, 'logout'])->name('logout');
            Route::get('/', [HomeController::class, 'dashboard'])->name('dashboard');
            Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
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
        });
    });
