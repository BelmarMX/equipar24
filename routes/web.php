<?php

use App\Http\Controllers\BlogArticleController;
use App\Http\Controllers\FormSubmitController;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\ProductBrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\UnoxController;
use Illuminate\Support\Facades\Route;

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
    Route::get('/', 'index')->name('productos');
    Route::get('/{slug_category}', 'index')->name('productos-categories');
    Route::get('/{slug_category}/{slug_subcategory}', 'index')->name('productos-subcategories');
    Route::get('/{slug_category}/{slug_subcategory}/{slug_product}', 'index')->name('producto-open');
    // * POST METHODS
    Route::post('search', 'search')->name('search');
    Route::post('autocomplete', 'index')->name('autocomplete');
});
Route::get('resultados/{term}', [ProductController::class, 'index'])->name('results');

Route::group(['prefix' => 'marcas', 'controller' => ProductBrandController::class], function () {
    Route::get('/{slug_brand}', 'index')->name('brands');
    Route::get('/{slug_brand}/{slug_category}', 'index')->name('brands-categories');
    Route::get('/{slug_brand}/{slug_category}/{slug_subcategory}', 'index')->name('brands-subcategories');
});

Route::group(['prefix' => 'promociones', 'controller' => PromotionController::class], function () {
    Route::get('/{slug_promotion}', 'index')->name('promociones');
    Route::get('/{slug_promotion}/productos', 'index')->name('promociones-productos');
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
    Route::get('/', 'index')->name('blog');
    Route::get('/{slug_blog_category}', 'index')->name('blog-categories');
    Route::get('/{slug_blog_category}/{slug_blog_article}', 'index')->name('blog-open');
});

Route::group(['prefix' => 'contacto', 'controller' => FormSubmitController::class], function () {
    Route::get('/'
        ,   [NavigationController::class, 'contacto']
    )->name('contacto');
    // * POST METHODS
    Route::post('find', 'find')->name('clientfind');
    Route::post('send', 'send')->name('contacto-send');
});

Route::group(['prefix' => 'cotizar', 'controller' => FormSubmitController::class], function () {
    Route::get('/'
        ,   [NavigationController::class, 'cotizar']
    )->name('cotizar');
    // * POST METHODS
    Route::post('add', 'add_quotation')->name('cotizaciones.add');
    Route::post('update', 'update_quotation')->name('cotizaciones.remove');
    Route::post('clear', 'clear_quotation')->name('cotizaciones.update');
    Route::post('send', 'send_quotation')->name('cotizaciones.send');
});
