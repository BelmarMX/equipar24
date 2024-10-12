<?php

namespace App\Classes;

use App\Models\Banner;
use App\Models\BlogArticle;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Promotion;
use App\Models\Reel;

class Navigation
{
    const SOCIAL_FACEBOOK           = "https://www.facebook.com/equiparcocinas/";
    const SOCIAL_INSTAGRAM          = "https://www.instagram.com/equiparcocinas/?hl=es-la";
    const SOCIAL_LINKEDIN           = "https://www.linkedin.com/in/equipar-servicios-integrales-7257081b1/";
    const MESSENGER_LINK            = "https://m.me/444842359663118";
    const LOCATION_MATRIZ           = "https://goo.gl/maps/efuFXA4bFRTs8PCX8";
    const LOCATION_SUCURSAL         = "https://g.page/equi-par-zapopan?share";
    const TEL_LOCAL_SHOW            = "(33) 2886 2661";
    const TEL_WHATS_SHOW            = "33 2287 6603";
    const CONTACT_EMAIL             = "atencionaclientes@equi-par.com";

    public static function phone_local_dial()
    {
        return "+521".str_replace(['(', ')', ' '], '', self::TEL_LOCAL_SHOW);
    }

    public static function phone_whats_dial()
    {
        return "52".str_replace(['(', ')', ' '], '', self::TEL_WHATS_SHOW);
    }

    public static function get_static_data($unset = [])
    {
        $data = [
                'banners'   => !in_array('banners', $unset)     ? Banner::get_banners()                         : NULL
            ,   'reels'     => !in_array('reels', $unset)       ? Reel::get_reels()                             : NULL
            ,   'featured'  => !in_array('featured', $unset)    ? ProductCategory::get_categories_featured()    : NULL
            ,   'related'   => !in_array('related', $unset)     ? Product::take_products()                      : NULL
            ,   'promos'    => !in_array('promos', $unset)      ? Promotion::get_promotions()                   : NULL
            ,   'articles'  => !in_array('articles', $unset)    ? BlogArticle::get_articles()                   : NULL
            ,   'menu_cat'  => ProductCategory::get_categories()
        ];

        return $data;
    }
}
