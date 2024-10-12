<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UnoxController extends Controller
{
    public function unox()
    {
        return view('web.unox.unox');
    }

    public function bakertop()
    {
        return view('web.unox.bakertop');
    }

    public function cheftop()
    {
        return view('web.unox.unox');
    }

    public function bakerlux()
    {
        return view('web.unox.unox');
    }

    public function bakerlux_shop()
    {
        return view('web.unox.bakerlux_shop');
    }

    public function bakerlux_speed_pro()
    {
        return view('web.unox.bakerlux_speed_pro');
    }

    public function evereo()
    {
        return view('web.unox.evereo');
    }

    public function speed_x()
    {
        return view('web.unox.speed_x');
    }
}
