<?php

namespace App\Http\Controllers\re;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EscalasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   $id_menu=27;
        $id_menu_sup=2;
        if (isset(Auth::user()->id)) 
        {   
            $query_grp_jer = DB::select("SELECT 
                tj.id id_grupo,
                tj.nombretipojer grupo, 
                j.orden, 
                j.id id_jerarquia, 
                j.nombrejer jerarquia 
                FROM jerarquias j 
                    LEFT JOIN tipojerarquia tj on (tj.id=j.tipo)  
                    ORDER BY tj.id,j.orden ASC;") ;

            $query_escalas = DB::select("SELECT 
                    tj.id id_grupo,
                    e.id id_escala ,
                    e.nombre nom_escala, 
                    j.id idjer, 
                    j.nombrejer jerarquia, 
                    ej.tiempo  FROM `escalas` e
                RIGHT JOIN tipojerarquia tj on (tj.id=e.id_tipo_jerarquia)
                LEFT JOIN jerarquias j on (j.tipo=tj.id)
                LEFT JOIN escalas_jeraquias ej on (ej.id_escala=e.id and ej.id_jerarquia=j.id)
                order by tj.id,e.id,j.orden") ;
            

            
            return view('re.escalas')
            ->with('grupos',$query_grp_jer)
            ->with('escalas',$query_escalas)
            ->with('id_menu',$id_menu)
            ->with('id_menu_sup',$id_menu_sup);
        }
        else{   return view('auth.login');}
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
    }
}