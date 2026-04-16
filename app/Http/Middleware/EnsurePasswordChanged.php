<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsurePasswordChanged
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->must_change_password) {
            $allowedRoutes = ['admin.password.change', 'admin.password.update', 'logout'];

            if (! in_array($request->route()?->getName(), $allowedRoutes)) {
                return redirect()->route('admin.password.change');
            }
        }

        return $next($request);
    }
}
