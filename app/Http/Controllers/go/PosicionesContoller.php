<?php

namespace App\Http\Controllers\go;

use App\Http\Controllers\Controller;
use App\Models\go\Posicion;
use Illuminate\Http\Request;
use App\Models\go\Descriptivos;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PosicionesContoller extends Controller
{
    public function index()
    {   $id_menu=6;
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
                $data_df= DB::table('descriptivos as desc')
                ->select('desc.id AS id', 
                'desc.nombredesc AS nombredesc',
                'desc.status AS status')
                ->where('desc.status','=','true')
                ->orderBy('desc.nombredesc')
                ->get();

                $data_est = DB::table('estructuras')
                ->select('id','nameund')
                ->where('id_tipo','=',2)
                ->orderBy('nameund')
                ->get();

                $data_pos= DB::table('posiciones as pos')
                ->select(
                    'pos.id as id',
                    'pos.descpue as descpue',
                    'desc.nombredesc as descrip',
                    'ue.nameund as nomue',
                    'posj.descpue as descpuej',
                    'pos.status as status'
                )            
                ->leftjoin('descriptivos as desc','desc.id','=','pos.iddf')
                ->leftjoin('estructuras as ue','ue.id','=','pos.idue')
                ->leftjoin('posiciones as posj','posj.id','=','pos.idpuejefe')
                ->orderBy('pos.descpue')
                ->get();


            return view('go.posiciones')
                ->with('data_df',$data_df)
                ->with('data_est',$data_est)
                ->with('data_pos',$data_pos)
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
            $codpue= $data['codpue'];
            $namepue= $data['namepue'];
            $hcaprobado= $data['hcaprobado'];
            $sel_ue= $data['sel_ue'];
            $secciones= $data['secciones'];
            $id_df= $data['id_df'];
            $idpuejefe= $data['idpuejefe'];
            $status= $data['status'];

            $new = new Posicion();
            $new->codigo = $codpue;
            $new->descpue = $namepue;
            $new->aprobado =  $hcaprobado;
            $new->idue =  $sel_ue;
            $new->iduni = $secciones;
            $new->iddf =  $id_df;
            $new->idpuejefe =  $idpuejefe;
            $new->status =  $status;
            $new->save();

           

            $result= DB::table('posiciones as pos')
            ->select(
                'pos.id as id',
                'pos.descpue as descpue',
                'desc.nombredesc as descrip',
                'ue.nameund as nomue',
                'posj.descpue as descpuej',
                'pos.status as status'
            )            
            ->leftjoin('descriptivos as desc','desc.id','=','pos.iddf')
            ->leftjoin('estructuras as ue','ue.id','=','pos.idue')
            ->leftjoin('posiciones as posj','posj.id','=','pos.idpuejefe')
            ->orderBy('pos.descpue')
            ->get();
            

            DB::commit();
            echo $result; 
            
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            echo 2;
        }
    }

    public function show(Posicion $posicion)
    {
        //
    }

    public function edit(Posicion $posicion)
    {
        $data= request()->except('_token');
        $id= $data['id'];
        $data_pos= DB::table('posiciones as pos')
        ->select(
            'pos.id as id',
            'pos.codigo as codigo',
            'pos.descpue as descpue',
            'pos.iddf as iddf',
            'pos.aprobado as aprobado',
            'pos.status as status',
            'pos.idue as idue',
            'pos.iduni as iduni',
            'posj.idue as iduej',
            'pos.idpuejefe as idpuejefe',
        )            
        ->leftjoin('posiciones as posj','posj.id','=','pos.idpuejefe')
        ->where('pos.id','=',$id)
        ->get();
        echo $data_pos;
    }

    public function update(Request $request, Posicion $posicion)
    {
        DB::beginTransaction();
        try {
            $data= request()->except('_token');
            $codpue= $data['codpue'];
            $namepue= $data['namepue'];
            $hcaprobado= $data['hcaprobado'];
            $sel_ue= $data['sel_ue'];
            $secciones= $data['secciones'];
            $id_df= $data['id_df'];
            $idpuejefe= $data['idpuejefe'];
            $status= $data['status'];
            $id= $data['id'];

            DB::table('posiciones')
            ->where('id','=', $id)
            ->update([
                'codigo' => $codpue, 
                'descpue' => $namepue, 
                'aprobado' => $hcaprobado, 
                'idue' => $sel_ue , 
                'iduni' => $secciones , 
                'iddf' => $id_df, 
                'idpuejefe' => $idpuejefe, 
                'status' => $status]);

           

            $result= DB::table('posiciones as pos')
            ->select(
                'pos.id as id',
                'pos.descpue as descpue',
                'desc.nombredesc as descrip',
                'ue.nameund as nomue',
                'posj.descpue as descpuej',
                'pos.status as status'
            )            
            ->leftjoin('descriptivos as desc','desc.id','=','pos.iddf')
            ->leftjoin('estructuras as ue','ue.id','=','pos.idue')
            ->leftjoin('posiciones as posj','posj.id','=','pos.idpuejefe')
            ->orderBy('pos.descpue')
            ->get();
            

            DB::commit();
            echo $result; 
            
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            echo 2;
        }
    }

    public function destroy(Posicion $posicion)
    {
        $data= request()->except('_token');
        $id= $data['id'];
        DB::beginTransaction();
        try {
            DB::table('posiciones')
              ->where('id','=', $id)
              ->delete();

            DB::table('posiciones')
              ->where('id','=', $id)
              ->update([
                  'idpuejefe' => null 
                  ]);

              $result= DB::table('posiciones as pos')
              ->select(
                  'pos.id as id',
                  'pos.descpue as descpue',
                  'desc.nombredesc as descrip',
                  'ue.nameund as nomue',
                  'posj.descpue as descpuej',
                  'pos.status as status'
              )            
              ->leftjoin('descriptivos as desc','desc.id','=','pos.iddf')
              ->leftjoin('estructuras as ue','ue.id','=','pos.idue')
              ->leftjoin('posiciones as posj','posj.id','=','pos.idpuejefe')
              ->orderBy('pos.descpue')
              ->get(); 

              DB::commit();
              echo $result;
              
       
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            echo 2;
        }
    }
}
