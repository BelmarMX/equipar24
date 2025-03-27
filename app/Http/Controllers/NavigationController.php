<?php

namespace App\Http\Controllers;

use App\Classes\Navigation;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function home()
    {
	    $icon_map = ProductController::CATEGORIES_ICONS;
        return view('web.static.home', array_merge(
				Navigation::get_static_data()
			,   compact('icon_map')
        ));
    }

    public function servicios()
    {
        return view('web.static.servicios', Navigation::get_static_data([
            'banners', 'reels', 'featured', 'related', 'articles'
        ]));
    }

    public function diseno_acero()
    {
        return view('web.static.diseno-acero', Navigation::get_static_data([
            'banners', 'reels', 'featured', 'related', 'articles'
        ]));
    }

    public function nosotros()
    {
        return view('web.static.nosotros', Navigation::get_static_data([
            'reels', 'featured', 'related', 'articles'
        ]));
    }

    public function proyectos()
    {
        return view('web.static.proyectos', Navigation::get_static_data());
    }

    public function aviso_privacidad()
    {
        return view('web.static.aviso-privacidad', Navigation::get_static_data([
            'banners', 'reels', 'featured', 'related', 'articles'
        ]));
    }

    public function gracias()
    {
        return view('web.static.gracias', Navigation::get_static_data([
            'banners', 'reels', 'featured', 'related', 'articles'
        ]));
    }

    public function contacto()
    {
        return view('web.static.contacto', Navigation::get_static_data([
            'banners', 'reels', 'featured', 'related', 'articles'
        ], TRUE));
    }

    public function cotizar()
    {
        return view('web.static.cotizar', Navigation::get_static_data([
            'banners', 'reels', 'featured', 'related', 'articles'
        ], TRUE));
    }
}
