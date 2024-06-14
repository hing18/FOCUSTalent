<?php

namespace App\Http\Controllers\go;

use App\Http\Controllers\Controller;
use App\Models\go\Jerarquias;
use App\Models\go\Reljercomp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class JerarquiasContoller extends Controller
{

    public function index()
    {   $id_menu=8;
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
                $data_jer= DB::table('jerarquias as jer')
                ->select('jer.id AS id', 
                'jer.nombrejer AS nombrejer',
                'jer.status AS status', 
                'jer.orden AS orden', 
                'tipojer.id AS idtipo',
                'tipojer.nombretipojer AS tipo')
                ->addSelect(DB::raw('(SELECT count(idjer)  FROM reljercomp where reljercomp.idjer=jer.id)AS cantcomp'))
                ->leftjoin('tipojerarquia as tipojer','tipojer.id','=','jer.tipo')       
                ->orderBy('tipojer.nombretipojer')->orderBy('jer.orden')        
                ->get();  
                $data_tipocomp = DB::table('tipocompetencia')
                ->select('id','nombretipocompetencia' )->orderBy('id','ASC')->get();
                $data_tipojer= DB::table('tipojerarquia')->get();
                return view('go.jerarquias')
                ->with('data_jer',$data_jer)
                ->with('data_tipojer',$data_tipojer)
                ->with('data_tipocomp',$data_tipocomp)
                ->with('id_menu',$id_menu)
                ->with('id_menu_sup',$id_menu_sup);
            }
            else{   return view('auth.login');}
        }
        else{   return view('auth.login');}
    }

    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $data= request()->except('_token');
            $id= $data['id'];
            $id_comp= $data['id_comp'];
            $id_tipo_comp= $data['id_tipo_comp'];
            $esperado= $data['esperado'];

            $new = new Reljercomp();
            $new->idjer = $id;
            $new->idcomp = $id_comp;
            $new->idtipocomp =  $id_tipo_comp;
            $new->esperado =  $esperado;
            $new->save();

           

            $result= DB::table('reljercomp as rel')
            ->select(
            'rel.idcomp AS idcomp',
            'comp.nombre AS nomcomp',
            'rel.idtipocomp AS idtipocomp',
            'tipo.nombretipocompetencia AS nomtipocomp',
            'rel.esperado AS perfil')            
            ->leftjoin('competencias as comp','comp.id','=','rel.idcomp')
            ->leftjoin('tipocompetencia as tipo','tipo.id','=','rel.idtipocomp')
            ->orderBy('tipo.id')
            ->orderBy('comp.nombre')
            ->where('rel.idjer','=', $id)->get();

            DB::commit();
            echo $result; 
            
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            echo 2;
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data= request()->except('_token');
            $nombre= $data['nombre'];
            $status= $data['status'];
            $tipojer= $data['tipojer'];
            $orden= $data['orden'];

            $new = new Jerarquias();
            $new->nombrejer = $nombre;
            $new->tipo = $tipojer;
            $new->status =  $status;
            $new->orden =  $orden;
            $new->save();

            $result = Jerarquias::select()->orderBy('nombrejer','ASC')->get();

            $result= DB::table('jerarquias as jer')
            ->select('jer.id AS id', 
            'jer.nombrejer AS nombrejer',
            'jer.status AS status', 
            'jer.orden AS orden', 
            'tipojer.id AS idtipo',
            'tipojer.nombretipojer AS tipo' )
            ->addSelect(DB::raw('(SELECT count(idjer)  FROM reljercomp where reljercomp.idjer=jer.id)AS cantcomp'))
            ->leftjoin('tipojerarquia as tipojer','tipojer.id','=','jer.tipo')       
            ->orderBy('tipojer.nombretipojer')->orderBy('jer.orden')        
            ->get(); 

            DB::commit();
            echo $result; 
            
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            echo 2;
        }
    }

    public function show(Jerarquias $jerarquias)
    {
        $data= request()->except('_token');
        $id= $data['id'];
        $result= DB::table('reljercomp as rel')
            ->select(
            'rel.idcomp AS idcomp',
            'comp.nombre AS nomcomp',
            'rel.idtipocomp AS idtipocomp',
            'tipo.nombretipocompetencia AS nomtipocomp',
            'rel.esperado AS perfil')            
            ->leftjoin('competencias as comp','comp.id','=','rel.idcomp')
            ->leftjoin('tipocompetencia as tipo','tipo.id','=','rel.idtipocomp')
            ->where('rel.idjer','=', $id)
            ->orderBy('tipo.id')
            ->orderBy('comp.nombre')
            ->get();
        echo $result;
    }

    public function showcomp(Jerarquias $jerarquias)
    {

        
        $result= DB::table('competencias as comp')
            ->select(
            'comp.id AS idcomp',
            'comp.nombre AS nomcomp')            
            ->whereNotIn('comp.id', function($q){ 
                $data= request()->except('_token');
                $id= $data['id'];
                $q->select('rel.idcomp')->from('reljercomp as rel')->where('rel.idjer','=', $id);
                
                })
            ->orderBy('comp.nombre','ASC')
            ->get();
        echo $result;
    }

    public function edit(Jerarquias $jerarquias)
    {
        $data= request()->except('_token');
        $id= $data['id'];
        $result = Jerarquias::select()->where('id','=', $id)->get();
        echo $result;
    }

    public function update(Request $request, Jerarquias $jerarquias)
    {
        $data= request()->except('_token');
        $nombre= $data['nombre'];
        $status= $data['status'];
        $tipojer= $data['tipojer'];
        $orden= $data['orden'];
        $id= $data['id'];

 

        DB::table('jerarquias')
        ->where('id','=', $id)
        ->update(['nombrejer' => $nombre,'tipo' => $tipojer,'orden' => $orden,'status' => $status]);

        $result= DB::table('jerarquias as jer')
        ->select('jer.id AS id', 
        'jer.nombrejer AS nombrejer',
        'jer.status AS status', 
        'jer.orden AS orden', 
        'tipojer.id AS idtipo',
        'tipojer.nombretipojer AS tipo')
        ->addSelect(DB::raw('(SELECT count(idjer)  FROM reljercomp where reljercomp.idjer=jer.id)AS cantcomp'))
        ->leftjoin('tipojerarquia as tipojer','tipojer.id','=','jer.tipo')       
        ->orderBy('tipojer.nombretipojer')->orderBy('jer.orden')        
        ->get(); 
        echo $result;
    }

    public function destroy(Jerarquias $jerarquias)
    {
        $data= request()->except('_token');
        $id= $data['id'];
        DB::beginTransaction();
        try {
            DB::table('Jerarquias')
              ->where('id','=', $id)
              ->delete();
            DB::table('reljercomp')
              ->where('idjer','=', $id)
              ->delete();
             
            $result= DB::table('jerarquias as jer')
              ->select('jer.id AS id', 
              'jer.nombrejer AS nombrejer',
              'jer.status AS status', 
              'jer.orden AS orden', 
              'tipojer.id AS idtipo',
              'tipojer.nombretipojer AS tipo')
              ->addSelect(DB::raw('(SELECT count(idjer)  FROM reljercomp where reljercomp.idjer=jer.id)AS cantcomp'))
              ->leftjoin('tipojerarquia as tipojer','tipojer.id','=','jer.tipo')       
              ->orderBy('tipojer.nombretipojer')->orderBy('jer.orden')        
              ->get(); 

              DB::commit();
              echo $result;
              
       
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            echo 2;
        }
    }

    public function destroycomp(Jerarquias $jerarquias)
    {
        $data= request()->except('_token');
        $id= $data['id'];
        $idcomp= $data['idcomp'];
        DB::beginTransaction();
        try {

            DB::table('reljercomp')
              ->where('idjer','=', $id)
              ->where('idcomp','=', $idcomp)
              ->delete();
             
              $result= DB::table('reljercomp as rel')
              ->select(
              'rel.idcomp AS idcomp',
              'comp.nombre AS nomcomp',
              'rel.idtipocomp AS idtipocomp',
              'tipo.nombretipocompetencia AS nomtipocomp',
              'rel.esperado AS perfil')            
              ->leftjoin('competencias as comp','comp.id','=','rel.idcomp')
              ->leftjoin('tipocompetencia as tipo','tipo.id','=','rel.idtipocomp')
              ->where('rel.idjer','=', $id)
              ->orderBy('tipo.id')
              ->orderBy('comp.nombre')
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
