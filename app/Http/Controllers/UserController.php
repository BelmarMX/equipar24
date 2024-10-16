<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function toggle_dark_mode()
    {
        $user = auth()->user();
        $user->dark_mode = !$user->dark_mode;
        $user->save();

        return Redirect::back();
    }
}
