<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // Si el usuario está autenticado y está intentando acceder a la página de login,
        // forzamos el logout antes de mostrar el formulario de login.
        if (Auth::guard($guard)->check() && $request->is('login')) {
            Auth::logout(); // Cierra la sesión del usuario autenticado
            return redirect()->route('login'); // Redirige nuevamente a la página de login
        }
        return $next($request);
    }
}
