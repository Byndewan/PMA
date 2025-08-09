<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfRoot
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('/')) {
            return redirect('/login');
        }

        return $next($request);
    }
}
