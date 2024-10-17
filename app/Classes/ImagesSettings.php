<?php

namespace App\Classes;

class ImagesSettings
{
    const FILE_MIN_SIZE                                 = 0;
    const FILE_MAX_SIZE                                 = 2048;

    const BANNER_FOLDER                                 = "banners/";
    const BANNER_WIDTH                                  = 1920;
    const BANNER_HEIGHT                                 = 520;
    const BANNER_WIDTH_MV                               = 340;
    const BANNER_HEIGHT_MV                              = 220;

    const PROMOS_FOLDER                                 = "promos/";
    const PROMOS_WIDTH                                  = 1920;
    const PROMOS_HEIGHT                                 = 520;
    const PROMOS_WIDTH_MV                               = 340;
    const PROMOS_HEIGHT_MV                              = 220;

    const GALLERY_FOLDER                                = "galeria/";
    const GALLERY_WIDTH                                 = 800;
    const GALLERY_HEIGHT                                = 600;
    const GALLERY_RX_WIDTH                              = 400;
    const GALLERY_RX_HEIGHT                             = 300;

    const ARTICLE_FOLDER                                = "articulos/";
    const ARTICLE_WIDTH                                 = 725;
    const ARTICLE_HEIGHT                                = 195;
    const ARTICLE_RX_WIDTH                              = 360;
    const ARTICLE_RX_HEIGHT                             = 255;

    const PRODUCT_CAT_FOLDER                            = "productos-categorias/";
    const PRODUCT_CAT_WIDTH                             = 400;
    const PRODUCT_CAT_HEIGHT                            = 540;
    const PRODUCT_CAT_RX_WIDTH                          = 200;
    const PRODUCT_CAT_RX_HEIGHT                         = 270;

    const PRODUCT_SUBCAT_FOLDER                         = "productos-subcategorias/";
    const PRODUCT_SUBCAT_WIDTH                          = 400;
    const PRODUCT_SUBCAT_HEIGHT                         = 540;
    const PRODUCT_SUBCAT_RX_WIDTH                       = 200;
    const PRODUCT_SUBCAT_RX_HEIGHT                      = 270;

    const PRODUCT_BRAND_FOLDER                         = "productos-marcas/";
    const PRODUCT_BRAND_WIDTH                          = 400;
    const PRODUCT_BRAND_HEIGHT                         = 540;
    const PRODUCT_BRAND_RX_WIDTH                       = 200;
    const PRODUCT_BRAND_RX_HEIGHT                      = 270;

    const PRODUCT_FOLDER                                = "productos/";
    const PRODUCT_WIDTH                                 = 800;
    const PRODUCT_HEIGHT                                = 600;
    const PRODUCT_RX_WIDTH                              = 380;
    const PRODUCT_RX_HEIGHT                             = 380;

    const PORTFOLIO_FOLDER                              = "portafolio/";
    const PORTFOLIO_WIDTH                               = 800;
    const PORTFOLIO_HEIGHT                              = 600;
    const PORTFOLIO_RX_WIDTH                            = 380;
    const PORTFOLIO_RX_HEIGHT                           = 380;

    const PORTFOLIO_IMG_FOLDER                          = "portafolio-images/";
    const PORTFOLIO_IMG_WIDTH                           = 1200;
    const PORTFOLIO_IMG_HEIGHT                          = 800;
    const PORTFOLIO_IMG_RX_WIDTH                        = 380;
    const PORTFOLIO_IMG_RX_HEIGHT                       = 380;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {}

    public function upload_image($file_name, $image, $width, $height, $folder)
    {}

    public function resize_image($file_name, $image, $width, $height, $folder)
    {}
}
