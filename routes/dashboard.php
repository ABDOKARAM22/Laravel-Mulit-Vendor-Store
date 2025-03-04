<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Admin\LoginController;
use App\Http\Controllers\Auth\Admin\RegisterController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\ProfileController;



// Admin Authentication routes
Route::prefix('admin')->middleware('guest:admin')->group(function () {

    Route::get('register', [RegisterController::class, 'create'])->name('admin.register');
    Route::post('register', [RegisterController::class, 'store']);

    Route::get('login', [LoginController::class, 'create'])->name('admin.login');
    Route::post('login', [LoginController::class, 'store']);
    
});


Route::group(['prefix' => 'dashboard', 'middleware' => ['RedirectIfNotAdmin'] , 'as' => 'dashboard.'], function () {
    
        
    // Main dashboard route
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    
    // Categories routes
    Route::get('/categories/trash', [CategoriesController::class, 'trash'])->name('categories.trash');
    Route::put('/categories/{category}/restore', [CategoriesController::class, 'restore'])->name('categories.restore');
    Route::delete('/categories/{category}/forcedelete', [CategoriesController::class, 'forcedelete'])->name('categories.forcedelete');
    Route::resource('/categories', CategoriesController::class);
    
    // Products routes
    Route::get('/products/trash', [ProductsController::class, 'trash'])->name('products.trash');
    Route::put('/products/{product}/restore', [ProductsController::class, 'restore'])->name('products.restore');
    Route::delete('/products/{product}/forcedelete', [ProductsController::class, 'forcedelete'])->name('products.forcedelete');
    Route::resource('/products', ProductsController::class);
    
    // Profile routes
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');


    // Logout Route
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

});
