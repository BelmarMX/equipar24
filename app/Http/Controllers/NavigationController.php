<?php

namespace App\Http\Controllers;

use App\Classes\Navigation;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function home()
    {
        return view('web.static.home', Navigation::get_static_data());
    }

    public function servicios()
    {
        return view('web.static.servicios', Navigation::get_static_data());
    }

    public function diseno_acero()
    {
        return view('web.static.diseno-acero', Navigation::get_static_data());
    }

    public function nosotros()
    {
        return view('web.static.nosotros', Navigation::get_static_data());
    }

    public function proyectos()
    {
        return view('web.static.proyectos', Navigation::get_static_data());
    }

    public function aviso_privacidad()
    {
        return view('web.static.aviso-privacidad', Navigation::get_static_data());
    }

    public function gracias()
    {
        return view('web.static.gracias', Navigation::get_static_data());
    }

    public function contacto()
    {
        return view('web.static.contacto', Navigation::get_static_data());
    }

    public function cotizaciones()
    {
        return view('web.static.cotizaciones', Navigation::get_static_data());
    }
}