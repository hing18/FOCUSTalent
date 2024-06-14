<?php

namespace App\Http\Controllers\conf;

use App\Http\Controllers\Controller;
use App\Models\conf\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RolesContoller extends Controller
{
    public function index()
    {   $id_menu=14;
        $id_menu_sup=12;
        if (isset(Auth::user()->id)) 
        {
            $id_user = Auth::user()->id;
            $data=0;
            $query = DB::select("SELECT rm.id_menu 
            FROM usr_rol ur INNER JOIN rol_menu rm ON (rm.id_rol=ur.id_rol AND rm.id_menu=$id_menu) 
            WHERE ur.id_usr=$id_user ");
            foreach ($query as $r)
            {
                $data=$r->id_menu;
            }
            if($data!=0)
            {
                return view('conf.roles')
                ->with('id_menu',$id_menu)
                ->with('id_menu_sup',$id_menu_sup);
            }else{
                return view('auth.login');
            }
        }else{
            return view('auth.login');
        }
    }
}
