<?php

namespace App\Http\Controllers;

use App\Classes\Navigation;
use Illuminate\Http\Request;

class UnoxController extends Controller
{
    public function unox()
    {
        return view('web.unox.unox', Navigation::get_static_data([
            'banners', 'reels', 'related', 'articles'
        ]));
    }

    public function bakertop()
    {
        return view('web.unox.unox-bakertop', Navigation::get_static_data([
            'banners', 'reels', 'related', 'articles'
        ]));
    }

    public function cheftop()
    {
        return view('web.unox.unox-cheftop', Navigation::get_static_data([
            'banners', 'reels', 'related', 'articles'
        ]));
    }

    public function bakerlux()
    {
        return view('web.unox.unox-bakerlux', Navigation::get_static_data([
            'banners', 'reels', 'related', 'articles'
        ]));
    }

    public function bakerlux_shop()
    {
        return view('web.unox.unox-bakerlux-shop', Navigation::get_static_data([
            'banners', 'reels', 'related', 'articles'
        ]));
    }

    public function bakerlux_speed_pro()
    {
        return view('web.unox.unox-bakerlux-speed-pro', Navigation::get_static_data([
            'banners', 'reels', 'related', 'articles'
        ]));
    }

    public function evereo()
    {
        return view('web.unox.unox-evereo', Navigation::get_static_data([
            'banners', 'reels', 'related', 'articles'
        ]));
    }

    public function speed_x()
    {
        return view('web.unox.unox-speed-x', Navigation::get_static_data([
            'banners', 'reels', 'related', 'articles'
        ]));
    }
}
