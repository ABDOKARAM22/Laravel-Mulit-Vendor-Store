<?php

namespace App\Providers;

use App\Repositories\Cart\CartModelRepository;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Paginator::useBootstrapFour();

        $this->app->bind(CartModelRepository::class, function () {
            return new CartModelRepository();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.header', function ($view) {
            $cart = app(CartModelRepository::class);

            $cartCount = $cart->get()->sum('quantity');

            $view->with('cartCount', $cartCount);
        });
    }
}