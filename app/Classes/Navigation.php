<?php

namespace App\Classes;

use App\Models\Banner;
use App\Models\BlogArticle;
use App\Models\Branch;
use App\Models\City;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\Promotion;
use App\Models\Reel;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

class Navigation
{
    // * MARKETING Y VENTAS
    const SOCIAL_FACEBOOK               = "https://www.facebook.com/equiparcocinas/";
    const SOCIAL_INSTAGRAM              = "https://www.instagram.com/equiparcocinas/?hl=es-la";
    const SOCIAL_LINKEDIN               = "https://www.linkedin.com/in/equipar-servicios-integrales-7257081b1/";
    const MESSENGER_LINK                = "https://m.me/444842359663118";
    const LOCATION_MATRIZ               = "https://goo.gl/maps/efuFXA4bFRTs8PCX8";
    const LOCATION_SUCURSAL             = "https://g.page/equi-par-zapopan?share";
    const TEL_LOCAL_SHOW                = "(33) 2886 2661";
    const TEL_WHATS_SHOW                = "33 2287 6603";
    const CONTACT_EMAIL                 = "atencionaclientes@equi-par.com";
    // * AVISO DE PRIVACIDAD
    const AVISO_EMPRESA                 = 'Equi-par';
    const AVISO_DIRECCION               = 'Av. Cvln. Jorge Álvarez del Castillo núm 1442, Col. Lomas del Country en Guadalajara, Jalisco.';
    const AVISO_RESPONSABLE             = 'Departamento de Atención al Cliente';
    const AVISO_TELEFONOS               = '+52 (33) 2886 2661';
    const AVISO_EMAIL                   = 'atencionaclientes@equi-par.com';
    const AVISO_ULTIMA_ACTUALIZACION    = '16 marzo 2022';

    public static function phone_local_dial()
    {
        return "+521".str_replace(['(', ')', ' '], '', self::TEL_LOCAL_SHOW);
    }

    public static function phone_whats_dial()
    {
        return "52".str_replace(['(', ')', ' '], '', self::TEL_WHATS_SHOW);
    }

    public static function mex_phone_number($phone)
    {
        $number = new \stdClass();
        $number -> dial     = '+52'.$phone;
        $number -> display  = '+52 1'.substr($phone, 0, 2) . ' ' . substr($phone, 2, 4) . ' ' . substr($phone, 6, 4);
        return $number;
    }

    public static function get_static_data($unset = [], $states = FALSE)
    {
        $slug_brand         = Route::current()->parameter('slug_brand');
        $slug_category      = Route::current()->parameter('slug_category');
        $slug_subcategory   = Route::current()->parameter('slug_subcategory');
        $slug_product       = Route::current()->parameter('slug_product');

        $data = [
                'banners'   => !in_array('banners', $unset)     ? Banner::get_banners()                         : NULL
            ,   'reels'     => !in_array('reels', $unset)       ? Reel::get_reels()                             : NULL
            ,   'featured'  => !in_array('featured', $unset)    ? ProductCategory::get_categories_featured()    : NULL
            ,   'related'   => !in_array('related', $unset)     ? Product::take_products(4, $slug_brand, $slug_category, $slug_subcategory, $slug_product) : NULL
            ,   'promos'    => !in_array('promos', $unset)      ? Promotion::get_active_promotions()            : NULL
            ,   'articles'  => !in_array('articles', $unset)    ? BlogArticle::get_articles()                   : NULL
            ,   'states'    => $states                                  ? State::get_states_alias()                     : NULL
            ,   'menu_cat'  => ProductCategory::get_categories()
            ,   'brands'    => ProductBrand::get_brands()
            ,   'branches'  => Branch::all()

        ];

        return $data;
    }

    public static function is_mobile()
    {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        return preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4));
    }

    public static function dashboard_menu()
    {
        return [
                'dashboard'             => [
                    'route'         => route('dashboard')
                ,   'route_is'      => 'dashboard'
                ,   'link_text'     => '<i class="fa-solid fa-chart-line me-1"></i> '.__('Dashboard')
            ]
            ,   'banners'               => [
                    'route'         => route('banners.index')
                ,   'route_is'      => 'banners.*'
                ,   'link_text'     => '<i class="fa-solid fa-images me-1"></i> Banners'
            ]
            ,   'reels'                 => [
                    'route'         => route('reels.index')
                ,   'route_is'      => 'reels.*'
                ,   'link_text'     => '<i class="fa-solid fa-clapperboard me-1"></i> Reels'
            ]
            ,   'products'                  => [
                    'dropdown'      => TRUE
                ,   'route_is'      => ['products.*', 'productBrands.*', 'productCategories.*', 'productSubcategories.*', 'productPrices.*', 'productFreights.*']
                ,   'link_text'     => '<i class="fa-solid fa-barcode me-1" style="vertical-align: middle;"></i> Productos'
                ,   'items'         => [
                        'productos'      => [
                            'route'         => route('products.index')
                        ,   'route_is'      => 'products.*'
                        ,   'link_text'     => '<i class="fa-solid fa-barcode me-1"></i> Productos'
                    ]
                    ,   'brands'        => [
                            'route'         => route('productBrands.index')
                        ,   'route_is'      => 'productBrands.*'
                        ,   'link_text'     => '<i class="fa-solid fa-registered me-1"></i> Marcas'
                    ]
                    ,   'categories'     => [
                            'route'         => route('productCategories.index')
                        ,   'route_is'      => 'productCategories.*'
                        ,   'link_text'     => '<i class="fa-solid fa-tag me-1"></i> Categorías'
                    ]
                    ,   'subcategories' => [
                            'route'         => route('productSubcategories.index')
                        ,   'route_is'      => 'productSubcategories.*'
                        ,   'link_text'     => '<i class="fa-solid fa-tags me-1"></i> Subcategorías'
                    ]
                    ,   'prices'        => [
                            'route'         => route('productPrices.index')
                        ,   'route_is'      => 'productPrices.*'
                        ,   'link_text'     => '<i class="fa-solid fa-dollar-sign me-1"></i> Precios'
                    ]
                    ,   'freight'        => [
                            'route'         => route('productFreights.index')
                        ,   'route_is'      => 'productFreights.*'
                        ,   'link_text'     => '<i class="fa-solid fa-truck-fast me-1"></i> Flete'
                    ]
                ]
            ]
            ,   'promotions'            => [
                    'route'         => route('promotions.index')
                ,   'route_is'      => 'promotions.*'
                ,   'link_text'     => '<i class="fa-solid fa-money-check-dollar me-1"></i> Promociones'
            ]
            ,   'projects'              => [
                    'route'         => route('projects.index')
                ,   'route_is'      => 'projects.*'
                ,   'link_text'     => '<i class="fa-regular fa-folder-open me-1"></i> Proyectos'
            ]
            ,   'blog'                  => [
                    'dropdown'      => TRUE
                ,   'route_is'      => ['blogArticles.*', 'blogCategories.*']
                ,   'link_text'     => '<i class="fa-solid fa-rss me-1" style="vertical-align: middle;"></i> Blog'
                ,   'items'         => [
                        'articles'      => [
                            'route'         => route('blogArticles.index')
                        ,   'route_is'      => 'blogArticles.*'
                        ,   'link_text'     => '<i class="fa-solid fa-rss me-1"></i> Artículos'
                    ]
                    ,   'categories'     => [
                            'route'         => route('blogCategories.index')
                        ,   'route_is'      => 'blogCategories.*'
                        ,   'link_text'     => '<i class="fa-solid fa-tag me-1"></i> Categorías'
                    ]
                ]
            ]
            ,   'contacts'              => [
                    'route'         => route('contacts.index')
                ,   'route_is'      => 'contacts.*'
                ,   'link_text'     => '<i class="fa-solid fa-envelope-open me-1"></i> Contactos'
            ]
            ,   'branches'              => [
                    'route'         => route('branches.index')
                ,   'route_is'      => 'branches.*'
                ,   'link_text'     => '<i class="fa-solid fa-store me-1"></i> Sucursales'
            ]
            /*,   'site'                  => [
                    'route'         => route('index')
                ,   'route_is'      => NULL
                ,   'link_text'     => '<i class="fa-solid fa-earth-americas me-1"></i>'
                ,   'tooltip'       => 'Ir al sitio web'
            ]*/
        ];
    }

    public static function split_date($date)
    {
        $parsed         = Carbon::parse( $date );
        $months         = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
        $short_months   = array('', 'ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC');

        return (object) [
                'day'           => $parsed -> day
            ,   'month'         => $parsed -> month
            ,   'short_month'   => $short_months[ $parsed -> month ]
            ,   'year'          => $parsed -> year
            ,   'large'         => "{$parsed -> day} {$months[ $parsed -> month ]} de {$parsed -> year}"
        ];
    }

    public static function percent($original, $final)
    {
        if ($original == $final)
        {
            return 0;
        }

        $original		= $original > 0 ? $original : $final;
        $percent        = (100 * $final) / $original - 100;
        return number_format( $percent, 2);
    }
}
