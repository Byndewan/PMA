<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  array  ...$roles  Role yang diizinkan (contoh: admin,operator,customer)
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $userRole = Auth::user()->role;

        if (!in_array($userRole, $roles, true)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin akses.');
        }

        return $next($request);
    }
}
