<?php

namespace App\Http\Middleware;

use Closure;

class CheckPin
{
    public function handle($request, Closure $next)
    {
        if ($request->cookie('access') === 'pass') {
            return $next($request);
        }

        return redirect(route('pin.create'));
    }
}
