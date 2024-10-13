<?php

namespace App\Providers;

use App\Classes\ImagesSettings;
use App\Classes\Navigation;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share('Navigation', new Navigation());
        View::share('ImagesSettings', new ImagesSettings());
    }
}
