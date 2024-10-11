<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/* --------------------------------------------------------------------------------------------------------------------
 * OPEN ROUTES
-------------------------------------------------------------------------------------------------------------------- */
Route::get('/', function () {
    return view('web.static.home');
});

Route::get('servicios', function () {
    return view('welcome');
});

Route::get('fabricacion-muebles-acero-inoxidable', function () {
    return view('welcome');
});

Route::get('nosotros', function () {
    return view('welcome');
});

Route::get('contacto', function () {
    return view('welcome');
});

Route::get('cotizar', function () {
    return view('welcome');
});

Route::get('aviso-de-privacidad', function () {
    return view('welcome');
});

Route::group(['prefix' => 'proyectos'], function () {
    Route::get('/', 'Controller@method')->name('');
    Route::get('/{slug_project}', 'Controller@method')->name('');
});

Route::group(['prefix' => 'productos'], function () {
    // * BY CATEGORIES
    Route::get('/', 'Controller@method')->name('');
    Route::get('/{slug_category}', 'Controller@method')->name('');
    Route::get('/{slug_category}/{slug_subcategory}', 'Controller@method')->name('');
    Route::get('/{slug_category}/{slug_subcategory}/{slug_product}', 'Controller@method')->name('');
    // * BY BRANDS
    Route::get('/marcas/{slug_brand}', 'Controller@method')->name('');
    Route::get('/marcas/{slug_brand}/{slug_category}', 'Controller@method')->name('');
    Route::get('/marcas/{slug_brand}/{slug_category}/{slug_subcategory}', 'Controller@method')->name('');
});

Route::group(['prefix' => 'resultados'], function () {
    Route::get('/{term}', 'Controller@method')->name('');
    Route::get('/{slug_category}/{slug_subcategory}', 'Controller@method')->name('');
    Route::get('/{slug_category}/{slug_subcategory}/{slug_product}', 'Controller@method')->name('');
});

Route::group(['prefix' => 'unox'], function () {
    Route::get('/', 'Controller@method')->name('');
    Route::get('/{slug_catalog}', 'Controller@method')->name('');
});

Route::group(['prefix' => 'blog'], function () {
    Route::get('/', 'Controller@method')->name('');
    Route::get('/{slug_blog_category}', 'Controller@method')->name('');
    Route::get('/{slug_blog_category}/{slug_blog_article}', 'Controller@method')->name('');
});
