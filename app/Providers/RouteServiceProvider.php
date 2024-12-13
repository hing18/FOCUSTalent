<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Override the default home path after authentication.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public static function redirectTo($request)
    {
        // Verifica si el usuario está autenticado
        if (Auth::check()) {
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

        // Si no está autenticado, redirige al login
        return route('login');
    }
}
