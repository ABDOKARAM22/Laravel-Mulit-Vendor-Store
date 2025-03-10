<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Store\CartController;
use App\Http\Controllers\Store\CheckoutController;
use App\Http\Controllers\Store\HomeController;
use App\Http\Controllers\Store\ProductsController;


Route::get('/', [HomeController::class,'index'])->name('home');

Route::get('/products', [ProductsController::class,'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductsController::class,'show'])->name('products.show');

Route::resource('/cart',CartController::class);

Route::get('/cheackout',[CheckoutController::class,'create'])->name('checkout');
Route::post('/cheackout',[CheckoutController::class,'store'])->name('checkout');

Route::middleware('auth:web')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';

require __DIR__.'/dashboard.php';