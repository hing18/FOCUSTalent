<?php

namespace App\Http\Controllers\me;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EmpleadosController extends Controller
{
    public function index()
    {
        $id_menu=22;
        $id_menu_sup=21;
        if (isset(Auth::user()->id)) 
        {   $id_user = Auth::user()->id;
            $data=0;
            $query = DB::select("SELECT rm.id_menu 
            FROM usr_rol ur INNER JOIN rol_menu rm ON (rm.id_rol=ur.id_rol AND rm.id_menu=$id_menu) 
            WHERE ur.id_usr=$id_user");
            foreach ($query as $r)
            {   $data=$r->id_menu;}
            if($data!=0)
            {               
                $query_empleados = DB::table('m_empleados as emp')
                ->select('emp.id', 
                    'emp.prinombre', 
                    'emp.priapellido', 
                    'pos.descpue', 
                    'est.nameund as ue', 
                    'est1.nameund as uni')
                ->leftjoin('posiciones as pos','pos.id','=','emp.id_posicion') 
                ->leftjoin('estructuras as est','est.id','=','pos.idue')
                ->leftjoin('estructuras as est1','est1.id','=','pos.iduni')    

    //            ->orderBy('emp.prinombre')->orderBy('emp.priapellido')  ->orderBy('est.nameund') ->orderBy('est1.nameund')       
                ->get();

                return view('me.empleados')
                ->with('id_menu',$id_menu)
                ->with('id_menu_sup',$id_menu_sup)
                ->with('empleados',$query_empleados);
            }
            else{   return view('auth.login');}
        }
        else{   return view('auth.login');}
    }
}
