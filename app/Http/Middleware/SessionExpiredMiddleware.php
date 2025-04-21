<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SessionExpiredMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        
        // Si la sesión ha expirado
        if (session()->has('expired') && session('expired')) {
            session()->flush();  // Borra todos los datos de sesión

            // Redirige al login con el mensaje
            return redirect()->route('login')->with('status', 'Tu sesión ha finalizado por inactividad.');
        }

        return $next($request);
    }
}
