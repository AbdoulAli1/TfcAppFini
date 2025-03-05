<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BibliothecaireMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'bibliothecaire') {
            return $next($request);
        }

        abort(403, 'Accès interdit');
    }
}
