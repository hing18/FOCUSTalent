<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    
   ### protected $redirectTo = 'evaluacion';

    /**
     * Create a new controller instance.
     *
     * 
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    protected function authenticated(Request $request, $user)
    {
        // Lógica personalizada de redirección, por ejemplo:
        $id_user =Auth::user()->id;
        $reset_pass=0;
        $pag='dashboard';
        $query_reset = DB::select("SELECT reset_pass FROM users where id=$id_user");     
         
        foreach ($query_reset as $r)
        {   $reset_pass=$r->reset_pass; }
        if($reset_pass==0)
        {   $query = DB::select("SELECT link 
            FROM menu 
            WHERE id IN (
                SELECT id_menu 
                FROM rol_menu 
                WHERE id_rol = (
                    SELECT id_rol  from usr_rol
                    WHERE id_usr = $id_user
                )
            ) 
            AND tipo IN ('S', 'H') 
            ORDER BY id ASC 
            LIMIT 1;");
            foreach ($query as $r)
            {   $pag=$r->link; }
            return redirect()->route($pag);  // Redirigir a la página de evaluación por defecto
        }else{
            return view('conf.reset');
        }
    }

    public function logout(Request $request)
    {
        // Desautentica al usuario
        Auth::logout();
        
        // Invalidar la sesión y regenerar el token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Limpiar cookies de sesión
        $cookies = cookie()->forget('laravel_session');   // Cookie de sesión
        $cookies = cookie()->forget('XSRF-TOKEN');         // Cookie del token CSRF
    
        // Redirigir al login y evitar el almacenamiento en caché
        return redirect('/login')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0')
            ->withCookie($cookies); // Añadir cookies para borrar
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        // Personaliza el mensaje de error
        return redirect()->back()->with('error', 'Las credenciales no son correctas.')->withInput();
    }
}