<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\BlogArticleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormSubmitController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ReelController;
use Illuminate\Support\Facades\Route;

/* --------------------------------------------------------------------------------------------------------------------
 * AUTHENTICATED ROUTES
-------------------------------------------------------------------------------------------------------------------- */
Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'verified']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/states', [DashboardController::class, 'states'])->name('dashboard.states');
    Route::post('/states', [DashboardController::class, 'get_states'])->name('dashboard.states.get');

    Route::get('/states/{state}/cities', [DashboardController::class, 'state_cities'])->name('dashboard.state-cities');
    Route::post('/states/{state}/cities', [DashboardController::class, 'get_state_cities'])->name('dashboard.state-cities.get');

    Route::get('/cities', [DashboardController::class, 'cities'])->name('dashboard.cities');
    Route::post('/cities', [DashboardController::class, 'get_cities'])->name('dashboard.cities.get');

    Route::group(['prefix' => 'banner', 'controller' => BannerController::class], function () {
        Route::get('/', function () {
            return view('dashboard');
        })->name('dashboard.banner.index');
    });

    Route::group(['prefix' => 'reels', 'controller' => ReelController::class], function () {
        Route::get('/', function () {
            return view('dashboard');
        })->name('dashboard.reels.index');
    });

    Route::group(['prefix' => 'products', 'controller' => ProductController::class], function () {
        Route::get('/', function () {
            return view('dashboard');
        })->name('dashboard.products.index');
    });

    Route::group(['prefix' => 'promotions', 'controller' => PromotionController::class], function () {
        Route::get('/', function () {
            return view('dashboard');
        })->name('dashboard.promotions.index');
    });

    Route::group(['prefix' => 'projects', 'controller' => ProjectController::class], function () {
        Route::get('/', function () {
            return view('dashboard');
        })->name('dashboard.projects.index');
    });

    Route::group(['prefix' => 'blog', 'controller' => BlogArticleController::class], function () {
        Route::get('/', function () {
            return view('dashboard');
        })->name('dashboard.blog.index');
    });

    Route::group(['prefix' => 'contacts', 'controller' => FormSubmitController::class], function () {
        Route::get('/', function () {
            return view('dashboard');
        })->name('dashboard.contacts.index');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
