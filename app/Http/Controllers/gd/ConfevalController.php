<?php

namespace App\Http\Controllers\gd;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConfevalController extends Controller
{
    public function index()
    {   $id_menu=24;
        $id_menu_sup=19;
        if (isset(Auth::user()->id)) 
        {   $id_user = Auth::user()->id;
            $data=0;
            $query = Db::select("SELECT rm.id_menu 
            FROM usr_rol ur INNER JOIN rol_menu rm ON (rm.id_rol=ur.id_rol AND rm.id_menu=$id_menu) 
            WHERE ur.id_usr=$id_user");
            foreach ($query as $r)
            {   $data=$r->id_menu;}
            if($data!=0)
            {   $query_evaluaciones = Db::select("SELECT desde, hasta, observacion, status, activo, proceso, finalizado, rechazado, total FROM vw_evaluaciones order by id desc");

                return view('gd.confeval')
                ->with('id_menu',$id_menu)
                ->with('id_menu_sup',$id_menu_sup)
                ->with('evaluaciones',$query_evaluaciones);
            }else{
                return view('auth.login');
            }
        }else{
            return view('auth.login');
        }
    }
}
