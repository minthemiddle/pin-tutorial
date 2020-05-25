<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class PinController extends Controller
{
    public function store(Request $request)
    {
        if ($request->pin === Config::get('settings.PIN')) {
            return redirect(route('root'))->withCookie('access', 'pass', 60);
        }

        return redirect(route('pin.create'));
    }
}
