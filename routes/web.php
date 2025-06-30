<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/', [ProductController::class, 'index'])->name('choose');
Route::post('/store', [ProductController::class, 'store'])->name('products.store');

Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout.submit');

Route::middleware('auth')->group(function () {
    Route::get('/orders', [CartController::class, 'order'])->name('orders.index');
    Route::delete('/orders/{id}', [CartController::class, 'deleteOrder'])->name('orders.delete');
    Route::get('/products', [ProductController::class, 'listOFproduct'])->name('products.listOFproduct');
    Route::get('/orders/{order}', [CartController::class, 'show'])->name('orders.show');
});
require __DIR__.'/auth.php';
