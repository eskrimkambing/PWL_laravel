<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (session('role') !== $role) {
            // Simpan halaman tujuan (mis. /checkout?cart=...) supaya setelah
            // login pembeli kembali ke halaman itu, bukan ke dashboard lain.
            if ($role === 'pembeli' && $request->isMethod('GET')) {
                session(['url.intended' => $request->fullUrl()]);
            }

            return redirect()->route('login');
        }
        return $next($request);
    }
}