<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (session('role') !== $role) {
            return redirect()->route('login');
        }
        return $next($request);
    }
}