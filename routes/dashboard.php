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
use App\Http\Controllers\ProductFreightController;
use App\Http\Controllers\ProductGalleryController;
use App\Http\Controllers\ProductPriceController;
use App\Http\Controllers\ProductSubcategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectGalleryController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\PromotionProductController;
use App\Http\Controllers\ReelController;
use App\Http\Controllers\UserController;
use App\Models\FormContact;
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

    Route::get('/contactList', [DashboardController::class, 'contactList'])->name('dashboard.contactList');
    Route::post('/contactList', [DashboardController::class, 'get_contactList'])->name('dashboard.contactList.get');

    // * WITH RESOURCES

    Route::resource('banners', BannerController::class);
    Route::group(['prefix' => 'banners', 'controller' => BannerController::class], function () {
        Route::post('datatable', 'datatable')->name('dashboard.banners.datatable');
        Route::get('archived/view', 'archived')->name('banners.archived');
        Route::get('delete/{banner}', 'destroy')->name('banners.delete');
        Route::get('restore/{banner_id}', 'restore')->name('banners.restore');
    });

    Route::resource('reels', ReelController::class);
    Route::group(['prefix' => 'reels', 'controller' => ReelController::class], function () {
        Route::post('datatable', 'datatable')->name('dashboard.reels.datatable');
        Route::get('archived/view', 'archived')->name('reels.archived');
        Route::get('delete/{reel}', 'destroy')->name('reels.delete');
        Route::get('restore/{reel_id}', 'restore')->name('reels.restore');
    });

    Route::resource('products', ProductController::class);
    Route::group(['prefix' => 'products', 'controller' => ProductController::class], function () {
        Route::post('datatable', 'datatable')->name('dashboard.products.datatable');
        Route::get('archived/view', 'archived')->name('products.archived');
        Route::get('delete/{product}', 'destroy')->name('products.delete');
        Route::get('restore/{product_id}', 'restore')->name('products.restore');
    });

    Route::resource('productBrands', ProductBrandController::class);
    Route::group(['prefix' => 'productBrands', 'controller' => ProductBrandController::class], function () {
        Route::post('datatable', 'datatable')->name('dashboard.productBrands.datatable');
        Route::get('archived/view', 'archived')->name('productBrands.archived');
        Route::get('delete/{product_brand}', 'destroy')->name('productBrands.delete');
        Route::get('restore/{product_brand_id}', 'restore')->name('productBrands.restore');
    });

    Route::resource('productCategories', ProductCategoryController::class);
    Route::group(['prefix' => 'productCategories', 'controller' => ProductCategoryController::class], function () {
        Route::post('datatable', 'datatable')->name('dashboard.productCategories.datatable');
        Route::get('archived/view', 'archived')->name('productCategories.archived');
        Route::get('delete/{product_category}', 'destroy')->name('productCategories.delete');
        Route::get('restore/{product_category_id}', 'restore')->name('productCategories.restore');
    });

    Route::resource('productSubcategories', ProductSubcategoryController::class);
    Route::group(['prefix' => 'productSubcategories', 'controller' => ProductSubcategoryController::class], function () {
        Route::post('datatable', 'datatable')->name('dashboard.productSubcategories.datatable');
        Route::get('archived/view', 'archived')->name('productSubcategories.archived');
        Route::get('delete/{product_subcategory}', 'destroy')->name('productSubcategories.delete');
        Route::get('restore/{product_subcategory_id}', 'restore')->name('productSubcategories.restore');
    });

    Route::resource('productGalleries', ProductGalleryController::class);
    Route::group(['prefix' => 'productGalleries', 'controller' => ProductGalleryController::class], function () {
        Route::post('datatable/{product}', 'datatable')->name('dashboard.productGalleries.datatable');
        Route::get('product/{product}', 'gallery')->name('productGalleries.gallery');
        Route::get('archived/view', 'archived')->name('productGalleries.archived');
        Route::get('delete/{product_gallery}', 'destroy')->name('productGalleries.delete');
        Route::get('restore/{product_gallery_id}', 'restore')->name('productGalleries.restore');
    });

    Route::resource('productPrices', ProductPriceController::class);
    Route::group(['prefix' => 'productPrices', 'controller' => ProductPriceController::class], function () {
        Route::post('datatable', 'datatable')->name('dashboard.productPrices.datatable');
        Route::post('update_massive', 'update_massive')->name('productPrices.update_massive');
        Route::post('generate_massive_file', 'generate_massive_file')->name('productPrices.generate_massive_file');
        Route::post('update_massive_file', 'update_massive_file')->name('productPrices.update_massive_file');
        Route::get('archived/view', 'archived')->name('productPrices.archived');
        Route::get('delete/{product_price}', 'destroy')->name('productPrices.delete');
        Route::get('restore/{product_price_id}', 'restore')->name('productPrices.restore');
    });

    Route::resource('productFreights', ProductFreightController::class);
    Route::group(['prefix' => 'productFreights', 'controller' => ProductFreightController::class], function () {
        Route::post('datatable', 'datatable')->name('dashboard.productFreights.datatable');
        Route::post('update_massive', 'update_massive')->name('productFreights.update_massive');
        Route::get('archived/view', 'archived')->name('productFreights.archived');
        Route::get('delete/{product_freight}', 'destroy')->name('productFreights.delete');
        Route::get('restore/{product_freight_id}', 'restore')->name('productFreights.restore');
    });

    Route::resource('promotions', PromotionController::class);
    Route::group(['prefix' => 'promotions', 'controller' => PromotionController::class], function () {
        Route::post('datatable', 'datatable')->name('dashboard.promotions.datatable');
        Route::get('archived/view', 'archived')->name('promotions.archived');
        Route::get('delete/{promotion}', 'destroy')->name('promotions.delete');
        Route::get('restore/{promotion_id}', 'restore')->name('promotions.restore');
    });

    //Route::resource('promotionProducts', PromotionProductController::class);
    Route::group(['prefix' => 'promotionProducts', 'controller' => PromotionProductController::class], function () {
        Route::get('{promotion}', 'index')->name('promotionProducts.index');
        Route::post('{promotion}/datatable', 'datatable')->name('dashboard.promotionProducts.datatable');
        Route::post('{promotion}/update_massive', 'update_massive')->name('promotionProducts.update_massive');
        Route::get('delete/{promotion_product}', 'destroy')->name('promotionProducts.delete');
    });

    Route::resource('projects', ProjectController::class);
    Route::group(['prefix' => 'projects', 'controller' => ProjectController::class], function () {
        Route::post('datatable', 'datatable')->name('dashboard.projects.datatable');
        Route::get('archived/view', 'archived')->name('projects.archived');
        Route::get('delete/{project}', 'destroy')->name('projects.delete');
        Route::get('restore/{project_id}', 'restore')->name('projects.restore');
    });

    Route::resource('projectGalleries', ProjectGalleryController::class);
    Route::group(['prefix' => 'projectGalleries', 'controller' => ProjectGalleryController::class], function () {
        Route::post('datatable/{project}', 'datatable')->name('dashboard.projectGalleries.datatable');
        Route::get('project/{project}', 'gallery')->name('projectGalleries.gallery');
        Route::get('archived/view', 'archived')->name('projectGalleries.archived');
        Route::get('delete/{projectGallery}', 'destroy')->name('projectGalleries.delete');
        Route::get('restore/{project_gallery_id}', 'restore')->name('projectGalleries.restore');
    });

    Route::resource('blogArticles', BlogArticleController::class);
    Route::group(['prefix' => 'blogArticles', 'controller' => BlogArticleController::class], function () {
        Route::post('datatable', 'datatable')->name('dashboard.blogArticles.datatable');
        Route::get('archived/view', 'archived')->name('blogArticles.archived');
        Route::get('delete/{blogArticle}', 'destroy')->name('blogArticles.delete');
        Route::get('restore/{blog_article_id}', 'restore')->name('blogArticles.restore');
    });

    Route::resource('blogCategories', BlogCategoryController::class);
    Route::group(['prefix' => 'blogCategories', 'controller' => BlogCategoryController::class], function () {
        Route::post('datatable', 'datatable')->name('dashboard.blogCategories.datatable');
        Route::get('archived/view', 'archived')->name('blogCategories.archived');
        Route::get('delete/{blogCategory}', 'destroy')->name('blogCategories.delete');
        Route::get('restore/{blog_category_id}', 'restore')->name('blogCategories.restore');
    });

    Route::resource('contacts', FormSubmitController::class);
    Route::group(['prefix' => 'contacts', 'controller' => FormSubmitController::class], function () {
        Route::post('datatable', 'datatable')->name('dashboard.contacts.datatable');
        Route::post('datatable/{filter}', 'datatable')->name('dashboard.contacts.datatable.filter');
        Route::get('index/{filter}', 'index')->name('contacts.filter');
        Route::get('archived/view', 'archived')->name('contacts.archived');
        Route::get('delete/{contact}', 'destroy')->name('contacts.delete');
        Route::get('restore/{contact_id}', 'restore')->name('contacts.restore');
    });

    Route::resource('branches', BranchController::class);
    Route::group(['prefix' => 'branches', 'controller' => BranchController::class], function () {
        Route::post('datatable', 'datatable')->name('dashboard.branches.datatable');
        Route::get('archived/view', 'archived')->name('branches.archived');
        Route::get('delete/{branch}', 'destroy')->name('branches.delete');
        Route::get('restore/{branch_id}', 'restore')->name('branches.restore');
    });

    Route::resource('users', UserController::class);
    Route::group(['prefix'=>'users', 'controller'=>UserController::class], function(){
        Route::post('datatable', 'datatable')->name('dashboard.users.datatable');
        Route::get('archived/view', 'archived')->name('users.archived');
        Route::get('delete/{user}', 'destroy')->name('users.delete');
        Route::get('restore/{user_id}', 'restore')->name('users.restore');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
