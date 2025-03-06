<?php

namespace App\Providers;

use App\Classes\ImagesSettings;
use App\Classes\Navigation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
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
        Paginator::useBootstrapFive();

        // ? Permite al webmaster tener todos los permisos, siempre
        Gate::before(function ($user, $ability) {
           if( $user->hasRole('webmaster') )
           { return TRUE; }
        });
    }
}
