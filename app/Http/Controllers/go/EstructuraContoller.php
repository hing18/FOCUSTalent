<?php

namespace App\Http\Controllers\go;

use App\Http\Controllers\Controller;
use App\Models\go\Estructura;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class EstructuraContoller extends Controller
{
    public function index(Request $request)
        {   $id_menu=10;
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
                {   //$data_tipos=DB::table('tipoestructuras')->get();
                    $data_sups=DB::table('estructuras')->where('id_sup','=','0')->get();
                    //$data_vestruc= DB::table('vestructuras')->get();

                    return view('go.estructura')
                        //->with('data_tipos',$data_tipos)
                        ->with('data_sups',$data_sups)
                       // ->with('data_vestruc',$data_vestruc)
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
            $data= request()->except('_token');
            Estructura::insert($data);
            $data_tipos= DB::table('tipoestructuras')->get();
            $data_sups= DB::table('estructuras')->where('id_sup','=','0')->get();
            $data_vestruc= DB::table('vestructuras')->get();
            return view('go.estructura')
                ->with('data_tipos',$data_tipos)
                ->with('data_sups',$data_sups)
                ->with('data_vestruc',$data_vestruc);
        }

    public function show(Estructura $estuctura)
        {
            //        
        }

    public function edit(Estructura $estuctura)
        {
            //
        }

    public function update(Request $request, Estructura $estuctura)
        {
            //
        }

    public function destroy(Estructura $estuctura)
        {
            //
        }

    public function muestra(Request $request)
        {
            return view("go.procedimientos",compact('request'));
        }

    public function unidades(Request $request)
        {   $id_menu=5;
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
                    $data_tipos=DB::table('tipoestructuras')->get();
                    $data_sups=DB::table('estructuras')->where('id_sup','=','0')->get();
                    $data_vestruc= DB::table('estructuras as est')
                    ->select('est.id AS IDUND', 
                    'est.codigo AS CODUND',
                    'est.nameund AS UND', 
                    'est.id_sup AS IDSUP', 
                    'estsup.nameund AS UNDSUP', 
                    'est.id_tipo AS IDTIPO', 
                    'tipos.name as NTIPO', 
                    'est.status AS STATUS')
                    ->leftjoin('tipoestructuras as tipos','tipos.id','=','est.id_tipo')
                    ->leftjoin('estructuras as estsup','estsup.id','=','est.id_sup')
                    ->get();

                    return view('go.unidades')
                        ->with('data_tipos',$data_tipos)
                        ->with('data_sups',$data_sups)
                        ->with('data_vestruc',$data_vestruc)
                        ->with('id_menu',$id_menu)
                        ->with('id_menu_sup',$id_menu_sup);   
                }
                else{   return view('auth.login');}
            }
            else{   return view('auth.login');}
        }
}
