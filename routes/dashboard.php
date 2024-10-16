<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\BlogArticleController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormSubmitController;
use App\Http\Controllers\ProductBrandController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductGalleryController;
use App\Http\Controllers\ProductSubcategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectGalleryController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ReelController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/* --------------------------------------------------------------------------------------------------------------------
 * AUTHENTICATED ROUTES
-------------------------------------------------------------------------------------------------------------------- */
Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'verified']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/toggle-dark-mode', [UserController::class, 'toggle_dark_mode'])->name('toggle-dark-mode');

    Route::get('/states', [DashboardController::class, 'states'])->name('dashboard.states');
    Route::post('/states', [DashboardController::class, 'get_states'])->name('dashboard.states.get');

    Route::get('/states/{state}/cities', [DashboardController::class, 'state_cities'])->name('dashboard.state-cities');
    Route::post('/states/{state}/cities', [DashboardController::class, 'get_state_cities'])->name('dashboard.state-cities.get');

    Route::get('/cities', [DashboardController::class, 'cities'])->name('dashboard.cities');
    Route::post('/cities', [DashboardController::class, 'get_cities'])->name('dashboard.cities.get');

    // * WITH RESOURCES

    Route::resource('banners', BannerController::class);
    Route::group(['prefix' => 'banners', 'controller' => BannerController::class], function () {
        Route::get('delete/{banner}', 'destroy')->name('banners.delete');
    });

    Route::resource('reels', ReelController::class);
    Route::group(['prefix' => 'reels', 'controller' => ReelController::class], function () {
        Route::get('delete/{reel}', 'destroy')->name('reels.delete');
    });

    Route::resource('products', ProductController::class);
    Route::group(['prefix' => 'products', 'controller' => ProductController::class], function () {
        Route::get('delete/{product}', 'destroy')->name('products.delete');
    });

    Route::resource('productBrands', ProductBrandController::class);
    Route::group(['prefix' => 'productBrands', 'controller' => ProductBrandController::class], function () {
        Route::get('delete/{project}', 'destroy')->name('projects.delete');
    });

    Route::resource('productCategories', ProductCategoryController::class);
    Route::group(['prefix' => 'productCategories', 'controller' => ProductCategoryController::class], function () {
        Route::get('delete/{productCategory}', 'destroy')->name('productCategories.delete');
    });

    Route::resource('productSubcategories', ProductSubcategoryController::class);
    Route::group(['prefix' => 'productSubcategories', 'controller' => ProductSubcategoryController::class], function () {
        Route::get('delete/{productSubcategory}', 'destroy')->name('productSubcategories.delete');
    });

    Route::resource('productGalleries', ProductGalleryController::class);
    Route::group(['prefix' => 'productGalleries', 'controller' => ProductGalleryController::class], function () {
        Route::get('delete/{productGallery}', 'destroy')->name('productGalleries.delete');
    });

    Route::resource('promotions', PromotionController::class);
    Route::group(['prefix' => 'promotions', 'controller' => PromotionController::class], function () {
        Route::get('delete/{promotion}', 'destroy')->name('promotion.delete');
    });

    Route::resource('projects', ProjectController::class);
    Route::group(['prefix' => 'projects', 'controller' => ProjectController::class], function () {
        Route::get('delete/{project}', 'destroy')->name('projects.delete');
    });

    Route::resource('projectGalleries', ProjectGalleryController::class);
    Route::group(['prefix' => 'projectGalleries;', 'controller' => ProjectGalleryController::class], function () {
        Route::get('delete/{projectGallery}', 'destroy')->name('projectGalleries.delete');
    });

    Route::resource('blog', BlogArticleController::class);
    Route::group(['prefix' => 'blog', 'controller' => BlogArticleController::class], function () {
        Route::get('delete/{blog}', 'destroy')->name('blog.delete');
    });

    Route::resource('blogCategories', BlogCategoryController::class);
    Route::group(['prefix' => 'blogCategories', 'controller' => BlogCategoryController::class], function () {
        Route::get('delete/{blogCategory}', 'destroy')->name('blogCategories.delete');
    });

    Route::resource('contacts', FormSubmitController::class);
    Route::group(['prefix' => 'contacts', 'controller' => FormSubmitController::class], function () {
        Route::get('delete/{contact}', 'destroy')->name('contacts.delete');
    });

    Route::resource('branches', BranchController::class);
    Route::group(['prefix' => 'branches', 'controller' => BranchController::class], function () {
        Route::post('datatable', 'datatable')->name('dashboard.branches.datatable');
        Route::get('archived/view', 'archived')->name('branches.archived');
        Route::get('delete/{branch}', 'destroy')->name('branches.delete');
        Route::get('restore/{branch_id}', 'restore')->name('branches.restore');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
