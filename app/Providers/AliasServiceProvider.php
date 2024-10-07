<?php

namespace App\Providers;

use app\Helpers\Currency\Currency;
use app\Helpers\HandelImageController\HandelImageController;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class AliasServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Get the AliasLoader instance
        $alias_loader = AliasLoader::getInstance(); 
        
        // Add your aliases
        $alias_loader->alias('Handel_image',HandelImageController::class);
        
        $alias_loader->alias('Currency',Currency::class);


    }


    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
