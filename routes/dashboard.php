<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Admin\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\OrdersController;
use App\Http\Controllers\Dashboard\StoresController;
use App\Http\Controllers\Dashboard\VendorsController;


// Admin Authentication routes
Route::prefix('admin')->middleware('guest:admin')->group(function () {
    Route::get('login', [LoginController::class, 'create'])
        ->name('admin.login');

    Route::post('login', [LoginController::class, 'store']);
});


Route::group([
    'prefix' => 'dashboard',
    'middleware' => [
        'RedirectIfNotAdmin',
        'admin_role:Admin,Super_Admin,Vendor'
    ],
    'as' => 'dashboard.'
], function () {

    // Main dashboard route
    Route::get('/', [DashboardController::class, 'index'])
        ->name('index');


    // Categories routes
    Route::middleware('admin_role:Admin,Super_Admin')->group(function () {

        Route::get('/categories/trash', [CategoriesController::class, 'trash'])
            ->name('categories.trash');

        Route::put('/categories/{category}/restore', [CategoriesController::class, 'restore'])
            ->name('categories.restore');

        Route::delete('/categories/{category}/forcedelete', [CategoriesController::class, 'forcedelete'])
            ->name('categories.forcedelete');

        Route::resource('/categories', CategoriesController::class);

        Route::get('/vendors', [VendorsController::class, 'index'])
            ->name('vendors.index');
        Route::get('/vendors/{vendor}', [VendorsController::class, 'show'])
            ->name('vendors.show');
        Route::get('/vendors/{vendor}/edit', [VendorsController::class, 'edit'])
            ->name('vendors.edit');
        Route::put('/vendors/{vendor}', [VendorsController::class, 'update'])
            ->name('vendors.update');
        Route::patch('/vendors/{vendor}/status', [VendorsController::class, 'updateStatus'])
            ->name('vendors.status');
    });


    // Products routes
    Route::get('/products/trash', [ProductsController::class, 'trash'])
        ->name('products.trash');

    Route::put('/products/{product}/restore', [ProductsController::class, 'restore'])
        ->name('products.restore');

    Route::delete('/products/{product}/forcedelete', [ProductsController::class, 'forcedelete'])
        ->name('products.forcedelete');

    Route::resource('/products', ProductsController::class);


    // Stores routes
    Route::resource('/stores', StoresController::class)
        ->except(['destroy']);

    Route::patch('/stores/{store}/status', [StoresController::class, 'updateStatus'])
        ->name('stores.status');


    // Orders routes
    Route::get('/orders', [OrdersController::class, 'index'])
        ->name('orders.index');

    Route::get('/orders/{order}', [OrdersController::class, 'show'])
        ->name('orders.show');

    Route::patch('/orders/{order}/status', [OrdersController::class, 'updateStatus'])
        ->name('orders.status');


    // Profile routes
    Route::get('/profile/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');


    // Logout Route
    Route::post('logout', [LoginController::class, 'destroy'])
        ->name('logout');
});