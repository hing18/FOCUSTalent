<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                #return redirect(RouteServiceProvider::HOME);
                $user = Auth::user();

                // Lógica personalizada de redirección, por ejemplo:
                $id_user = $user->id;
                $reset_pass = 0;
                $pag = 'dashboard';
                
                // Verifica si el usuario necesita restablecer su contraseña
                $query_reset = DB::select("SELECT reset_pass FROM users WHERE id = $id_user");
                foreach ($query_reset as $r) {
                    $reset_pass = $r->reset_pass;
                }

                // Si no necesita restablecer la contraseña
                if ($reset_pass == 0) {
                    // Obtén la página a la que se redirigirá el usuario
                    $query = DB::select("SELECT link 
                        FROM menu 
                        WHERE id IN (
                            SELECT id_menu 
                            FROM rol_menu 
                            WHERE id_rol = (
                                SELECT id_rol FROM usr_rol
                                WHERE id_usr = $id_user
                            )
                        ) 
                        AND tipo IN ('S', 'H') 
                        ORDER BY id ASC 
                        LIMIT 1;");
                    
                    foreach ($query as $r) {
                        $pag = $r->link;
                    }

                    // Redirige a la página obtenida de la consulta
                    return redirect()->route($pag);
                } else {
                    // Si el usuario necesita restablecer la contraseña, redirige a la vista de restablecimiento
                    return view('conf.reset');
                }
            }
        }

        return $next($request);
    }
}
