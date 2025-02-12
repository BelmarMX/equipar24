<?php

namespace App\Http\Controllers;

use App\Classes\Navigation;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class UnoxController extends Controller
{
    public function unox()
    {
        $unox_brand             = ProductBrand::where('slug', 'unox')->first();
        $unox_categories_ids    = array_column(Product::where('product_brand_id', $unox_brand->id)->get()->toArray(), 'product_category_id');
        $unox_categories        = ProductCategory::whereIn('id', $unox_categories_ids)->get();

        return view('web.unox.unox', array_merge(Navigation::get_static_data([
            'banners', 'featured', 'reels', 'related', 'articles'
        ])
        ,   [
            'featured' => $unox_categories
        ]));
    }

    public function bakertop()
    {
        return view('web.unox.unox-bakertop', array_merge(Navigation::get_static_data([
            'banners', 'featured', 'reels', 'related', 'articles'
        ])
        ,   [
                'featured' => Product::search('bakertop', 'unox')
        ]));
    }

    public function cheftop()
    {
        return view('web.unox.unox-cheftop', array_merge(Navigation::get_static_data([
            'banners', 'featured', 'reels', 'related', 'articles'
        ])
        ,   [
                'featured' => Product::search('cheftop', 'unox')
        ]));
    }

    public function bakerlux()
    {
        return view('web.unox.unox-bakerlux', array_merge(Navigation::get_static_data([
            'banners', 'featured', 'reels', 'related', 'articles'
        ])
        ,   [
                'featured' => Product::search('bakerlux', 'unox')
        ]));
    }

    public function bakerlux_shop()
    {
        return view('web.unox.unox-bakerlux-shop', array_merge(Navigation::get_static_data([
            'banners', 'featured', 'reels', 'related', 'articles'
        ])
        ,   [
                'featured' => Product::search('bakerlux%shop', 'unox')
        ]));
    }

    public function bakerlux_speed_pro()
    {
        return view('web.unox.unox-bakerlux-speed-pro', array_merge(Navigation::get_static_data([
            'banners', 'featured', 'reels', 'related', 'articles'
        ])
        ,   [
                'featured' => Product::search('bakerlux%speed', 'unox')
        ]));
    }

    public function evereo()
    {
        return view('web.unox.unox-evereo', array_merge(Navigation::get_static_data([
            'banners', 'featured', 'reels', 'related', 'articles'
        ])
        ,   [
                'featured' => Product::search('evereo', 'unox')
        ]));
    }

    public function speed_x()
    {
        return view('web.unox.unox-speed-x', array_merge(Navigation::get_static_data([
            'banners', 'featured', 'reels', 'related', 'articles'
        ])
        ,   [
                'featured' => Product::search('speed-x', 'unox')
        ]));
    }
}
