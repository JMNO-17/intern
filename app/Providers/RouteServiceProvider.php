<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\\Http\\Controllers';

    /**
     * Register services.
     */
    // public function register(): void
    // {
    //
    // }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/frontend.php'));
    }
}
