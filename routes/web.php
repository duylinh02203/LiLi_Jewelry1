<?php

use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\ADMIN\CategoryController;
use App\Http\Controllers\ADMIN\HomeController;
use App\Http\Controllers\ADMIN\ProductController;
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

Route::get('/', function () {
    return view('admin.content');
});
Route::get('dashboard', function () {
    return view('admin.content');
})->name('dashboard');





Route::get('create_category', [HomeController::class, 'create_category'])->name('create.category');
Route::get('admin/order', [HomeController::class, 'order'])->name('order');
Route::get('setting', [HomeController::class, 'setting'])->name('setting.update');
Route::get('admin/order_chuaduyet', [HomeController::class, 'order_chuaduyet'])->name('chuaduyet');


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
