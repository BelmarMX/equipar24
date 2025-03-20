<?php

use App\Http\Controllers\BlogArticleController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\FormSubmitController;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\ProductBrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPackageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\UnoxController;
use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;

/* --------------------------------------------------------------------------------------------------------------------
 * OPEN ROUTES
-------------------------------------------------------------------------------------------------------------------- */
Route::get('/'
    ,   [NavigationController::class, 'home']
)->name('index');

Route::get('servicios'
    ,   [NavigationController::class, 'servicios']
)->name('servicios');

Route::get('fabricacion-muebles-acero-inoxidable'
    ,   [NavigationController::class, 'diseno_acero']
)->name('diseno-acero');

Route::get('nosotros'
    ,   [NavigationController::class, 'nosotros']
)->name('nosotros');

Route::get('proyectos'
    ,   [NavigationController::class, 'proyectos']
)->name('proyectos');

Route::get('aviso-de-privacidad'
    ,   [NavigationController::class, 'aviso_privacidad']
)->name('aviso-privacidad');

Route::get('gracias'
    ,   [NavigationController::class, 'gracias']
)->name('gracias');

Route::group(['prefix' => 'portafolio', 'controller' => ProjectController::class], function () {
    Route::get('/', 'view')->name('portafolio');
    Route::get('/{slug_project}', 'show')->name('portafolio-open');
});

Route::group(['prefix' => 'productos', 'controller' => ProductController::class], function () {
    Route::get('/', 'show_categories')->name('productos');
    Route::get('/{slug_category}', 'show_category')->name('productos-categories');
    Route::get('/{slug_category}/{slug_subcategory}', 'show_subcategory')->name('productos-subcategories');
    Route::get('/{slug_category}/{slug_subcategory}/{slug_product}', 'show_product')->name('producto-open');
    // * POST METHODS
    Route::post('subcategorias', 'get_subcategories')->name('get_subcategories');
    Route::post('filtrados', 'get_filtrados')->name('get_filtrados');
    Route::post('search', 'search')->name('search');
    Route::post('autocomplete', 'autocomplete')->name('autocomplete');
});
Route::get('resultados/{termino}', [ProductController::class, 'results'])->name('results');

Route::group(['prefix' => 'marcas', 'controller' => ProductBrandController::class], function () {
    Route::get('/{slug_brand}', 'show_brand')->name('brands');
    Route::get('/{slug_brand}/{slug_category}', 'show_category')->name('brands-categories');
    Route::get('/{slug_brand}/{slug_category}/{slug_subcategory}', 'show_subcategory')->name('brands-subcategories');
});

Route::group(['prefix' => 'promociones', 'controller' => PromotionController::class], function () {
    Route::get('/{slug_promotion}', 'show_promotion')->name('promociones-productos');
});

Route::group(['prefix' => 'paquetes', 'controller' => ProductPackageController::class], function () {
	Route::get('/{slug_package}', 'show_package')->name('paquetes-productos');
});

Route::group(['prefix' => 'unox', 'controller' => UnoxController::class], function () {
    Route::get('/', 'unox')->name('unox');
    Route::get('/bakertop', 'bakertop')->name('unoxBakertop');
    Route::get('/cheftop', 'cheftop')->name('unoxCheftop');
    Route::get('/bakerlux', 'bakerlux')->name('unoxBakerlux');
    Route::get('/bakerlux-shop', 'bakerlux_shop')->name('unoxBakerluxShop');
    Route::get('/bakerlux-speed-pro', 'bakerlux_speed_pro')->name('unoxBakerluxSpeedPro');
    Route::get('/evereo', 'evereo')->name('unoxEvereo');
    Route::get('/speed-x', 'speed_x')->name('unoxSpeedX');
});

Route::group(['prefix' => 'blog', 'controller' => BlogArticleController::class], function () {
    Route::get('/', 'show_categories')->name('blog');
    Route::get('/{slug_blog_category}', 'show_category')->name('blog-categories');
    Route::get('/{slug_blog_category}/{slug_blog_article}', 'show_article')->name('blog-open');
});

Route::group(['prefix' => 'contacto', 'controller' => FormSubmitController::class], function () {
    Route::get('/', [NavigationController::class, 'contacto'])->name('contacto');
    // * POST METHODS
    Route::post('find', 'find_contact')->name('contacto.find');
    Route::post('cities', 'get_cities')->name('contacto.get_cities');
    Route::post('send', 'send_contact')->name('contacto-send')->middleware(ProtectAgainstSpam::class);
});

Route::group(['prefix' => 'cotizar', 'controller' => FormSubmitController::class], function () {
    Route::get('/', [NavigationController::class, 'cotizar'])->name('cotizar');
    // * POST METHODS
    Route::post('add', 'add_quotation')->name('cotizaciones.add');
    Route::post('update', 'update_quotation')->name('cotizaciones.remove');
    Route::post('clear', 'clear_quotation')->name('cotizaciones.update');
    Route::post('send', 'send_quotation')->name('cotizaciones.send')->middleware(ProtectAgainstSpam::class);
});
