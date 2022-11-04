<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isAdministratorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guest() || ! auth()->user()->admin) {

            return redirect('/logout');
        }

        return $next($request);
    }
}
