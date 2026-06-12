<?php

use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ChatController;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UI\ProductController as UIProductController;

Route::get('/', function () {return view('layouts.home');})->name('home');
Route::get('/auth', [AuthController::class, 'index'])->name('auth');
Route::get('/products', [UIProductController::class, 'index'])->name('products');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::get('/store', function() { return view('store.index'); })->name('store');
Route::get('/contact', function() { return view('contact.index'); })->name('contact');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/chat/ask', [ChatController::class, 'askAI'])->name('chat.ask');
Route::post('/admin/products/import', [App\Http\Controllers\Admin\ProductController::class, 'importExcel'])->name('admin.products.import');


Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
    Route::get('/history/{id}', [HistoryController::class, 'show'])->name('history.show');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->as('admin.')->group(function() {
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoriesController::class);
    Route::resource('users', UsersController::class);
    Route::resource('orders', OrdersController::class)->except(['create', 'store']);
});
