<?php

namespace App\Http\Controllers\go;

use App\Http\Controllers\Controller;
use App\Models\go\Competencias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CompetenciasController extends Controller
{
    public function index()
    {   $id_menu=9;
        $id_menu_sup=4;
        if (isset(Auth::user()->id)) 
        {   $id_user = Auth::user()->id;
            $data=0;
            $query = DB::select("SELECT rm.id_menu 
            FROM usr_rol ur INNER JOIN rol_menu rm ON (rm.id_rol=ur.id_rol AND rm.id_menu=$id_menu) 
            WHERE ur.id_usr=$id_user ");
            foreach ($query as $r)
            {   $data=$r->id_menu;}
            if($data!=0)
            { 
                $resultcomp = Competencias::select()->orderBy('nombre','ASC')->get();
                return view('go.competencias')
                ->with('resultcomp',$resultcomp)
                ->with('id_menu',$id_menu)
                ->with('id_menu_sup',$id_menu_sup);
            }
            else{   return view('auth.login');}
        }
        else{   return view('auth.login');}
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data= request()->except('_token');
            $nombre= $data['nombre'];
            $status= $data['status'];
            $definicion= $data['definicion'];
            $definicion_resumen= $data['definicion_resumen'];
            $nivelalto= $data['nivelalto'];
            $nivelbajo= $data['nivelbajo'];
            $new = new Competencias();
            $new->nombre = $nombre;
            $new->definicion = $definicion;
            $new->definicion_resumen = $definicion_resumen;
            $new->nivel_alto = $nivelalto;
            $new->nivel_bajo = $nivelbajo;
            $new->status =  $status;
            $new->save();

            $result = Competencias::select()->orderBy('nombre','ASC')->get();
            DB::commit();
            echo $result; 
            
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            echo 2;
        }
    }

    public function show(Competencias $competencias)
    {
    }

    public function edit(Competencias $competencias)
    {   
        $data= request()->except('_token');
        $id= $data['id'];
        $result = Competencias::select()->where('id','=', $id)->get();
        echo $result;
    }

    public function update(Request $request, Competencias $competencias)
    {
        $data= request()->except('_token');
        $id= $data['id'];
        $nombre= $data['nombre'];
        $definicion= $data['definicion'];
        $definicion_resumen= $data['definicion_resumen'];
        $nivel_alto= $data['nivelalto'];
        $nivel_bajo= $data['nivelbajo'];
        $status='true';
        if($data['status']=='false')
        { $status='false';}
        DB::table('competencias')
        ->where('id','=', $id)
        ->update(['nombre' => $nombre,'definicion' => $definicion,'definicion_resumen' => $definicion_resumen,'nivel_alto' => $nivel_alto,'nivel_bajo' => $nivel_bajo,'status' => $status]);
        $result = Competencias::select()->orderBy('nombre','ASC')->get();
        echo $result;
        
    }

    public function destroy(Competencias $competencias)
    {
        $data= request()->except('_token');
        $id= $data['id'];
        DB::beginTransaction();
        try {
            DB::table('competencias')
              ->where('id','=', $id)
              ->delete();
             $result = Competencias::select()->orderBy('nombre','ASC')->get();
              DB::commit();
              echo $result;
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            echo 2;
        }
    }
}
