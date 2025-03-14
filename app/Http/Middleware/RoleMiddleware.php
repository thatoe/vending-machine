<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role = null): Response
    {
        if ($role && (!Auth::check() || !Auth::user()->hasRole($role))) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}