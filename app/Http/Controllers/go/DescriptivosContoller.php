<?php

namespace App\Http\Controllers\go;

use App\Http\Controllers\Controller;
use App\Models\go\Descriptivos;
use App\Models\go\Jerarquias;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DescriptivosContoller extends Controller
{

    public function index()
    {   $id_menu=7;
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
                $data_jer = DB::table('jerarquias as jer')
                ->select('jer.id AS id', 
                'jer.nombrejer AS nombrejer',
                'jer.status AS status', 
                'jer.orden AS orden', 
                'tipojer.id AS idtipo',
                'tipojer.nombretipojer AS tipo')
                ->leftjoin('tipojerarquia as tipojer','tipojer.id','=','jer.tipo')     
                ->where('jer.status','=','true')  
                ->orderBy('tipojer.nombretipojer')->orderBy('jer.orden')        
                ->get();

                $data_df= DB::table('descriptivos as desc')
                ->select('desc.id AS id', 
                'desc.nombredesc AS nombredesc',
                'desc.status AS status',
                'jer.nombrejer AS nombrejer',
                'tipojer.nombretipojer AS nombretipojer' )
                ->leftjoin('jerarquias as jer','jer.id','=','desc.idjer')  
                ->leftjoin('tipojerarquia as tipojer','tipojer.id','=','jer.tipo')       
                ->orderBy('tipojer.nombretipojer')->orderBy('desc.nombredesc')        
                ->get();

                return view('go.descriptivos')
                ->with('data_jer',$data_jer)
                ->with('data_df',$data_df)
                ->with('id_menu',$id_menu)
                ->with('id_menu_sup',$id_menu_sup);   
            }
            else{   return view('auth.login');}
        }
        else{   return view('auth.login');}
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data= request()->except('_token');
            $nombredesc= $data['namedf'];
            $idjer= $data['idjer'];
            $cargojefe= $data['cargojefe'];
            $area_depto= $data['nameareadf'];
            $reportes= $data['numreportedir'];
            $proposito= $data['txtproposito'];

            $status= $data['status'];

            $new = new Descriptivos();
            $new->nombredesc = $nombredesc;
            $new->idjer = $idjer;
            $new->cargojefe = $cargojefe;
            $new->area_depto = $area_depto;
            $new->reportes = $reportes;
            $new->proposito = $proposito;
            $new->status =  $status;
            $new->save();

         
            $result= DB::table('descriptivos as desc')
            ->select('desc.id AS id', 
            'desc.nombredesc AS nombredesc',
            'desc.status AS status',
            'jer.nombrejer AS nombrejer',
            'tipojer.nombretipojer AS nombretipojer' )
            ->leftjoin('jerarquias as jer','jer.id','=','desc.idjer')  
            ->leftjoin('tipojerarquia as tipojer','tipojer.id','=','jer.tipo')       
            ->orderBy('tipojer.nombretipojer')->orderBy('desc.nombredesc')        
            ->get();
 

            DB::commit();
            echo $result; 
            
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            echo 2;
        }
    }

    public function show(Descriptivos $descriptivos)
    {
        
    }

    public function edit(Descriptivos $descriptivos)
    {
        $data= request()->except('_token');
        $id= $data['id'];
        $result = DB::table('descriptivos as desc')
        ->select('desc.id AS id', 
        'desc.nombredesc AS nombredesc',
        'desc.cargojefe AS cargojefe',
        'desc.area_depto AS area_depto',
        'desc.idjer AS idjer',
        'desc.reportes AS reportes',
        'desc.proposito AS proposito',
        'desc.status AS status')    
        ->where('desc.id','=',$id)
        ->get();
        echo $result;
    }

    public function update(Request $request, Descriptivos $descriptivos)
    {
        $data= request()->except('_token');
        $id= $data['id'];
        $nombredesc= $data['namedf'];
        $idjer= $data['idjer'];
        $cargojefe= $data['cargojefe'];
        $area_depto= $data['nameareadf'];
        $reportes= $data['numreportedir'];
        $proposito= $data['txtproposito'];

            $status= $data['status'];
        DB::beginTransaction();
        try {
                        
            DB::table('descriptivos')
              ->where('id','=', $id)
              ->update(['nombredesc' => $nombredesc,'idjer' => $idjer,'cargojefe' => $cargojefe, 'area_depto' => $area_depto, 'reportes' => $reportes, 'proposito' => $proposito, 'status' => $status]);
             
            $result= DB::table('descriptivos as desc')
              ->select('desc.id AS id', 
              'desc.nombredesc AS nombredesc',
              'desc.status AS status',
              'jer.nombrejer AS nombrejer',
              'tipojer.nombretipojer AS nombretipojer' )
              ->leftjoin('jerarquias as jer','jer.id','=','desc.idjer')  
              ->leftjoin('tipojerarquia as tipojer','tipojer.id','=','jer.tipo')       
              ->orderBy('tipojer.nombretipojer')->orderBy('desc.nombredesc')        
              ->get(); 

              DB::commit();
              echo $result;
              
       
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            echo 2;
        }
    }

    public function destroy(Descriptivos $descriptivos)
    {
        $data= request()->except('_token');
        $id= $data['id'];
        DB::beginTransaction();
        try {
            DB::table('descriptivos')
              ->where('id','=', $id)
              ->delete();
            
            DB::table('posiciones')
              ->where('iddf','=', $id)
              ->update(['iddf' => null]);
             
            $result= DB::table('descriptivos as desc')
              ->select('desc.id AS id', 
              'desc.nombredesc AS nombredesc',
              'desc.status AS status',
              'jer.nombrejer AS nombrejer',
              'tipojer.nombretipojer AS nombretipojer' )
              ->leftjoin('jerarquias as jer','jer.id','=','desc.idjer')  
              ->leftjoin('tipojerarquia as tipojer','tipojer.id','=','jer.tipo')       
              ->orderBy('tipojer.nombretipojer')->orderBy('desc.nombredesc')        
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