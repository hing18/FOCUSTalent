<?php

namespace App\Http\Controllers\re;

use App\Http\Controllers\Controller;
use App\Models\re\escalas_jeraquias;
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
            $query_select_escalas=DB::select("SELECT e.id, e.id_tipo_jerarquia idgrupo, e.nombre FROM escalas e");

            $query_grp_jer = DB::select("SELECT 
                tj.id_grp_estructura id_grupo,
                tj.nombretipojer grupo, 
                j.orden, 
                j.id id_jerarquia, 
                j.nombrejer jerarquia 
                FROM jerarquias j 
                    LEFT JOIN tipojerarquia tj on (tj.id=j.tipo)
                    WHERE  (j.orden not in (1,0))
                    ORDER BY tj.id,j.orden ASC;") ;

            $query_escalas = DB::select("SELECT 
                    tj.id_grp_estructura id_grupo,
                    e.id id_escala ,
                    e.nombre nom_escala, 
                    j.id idjer, 
                    j.nombrejer jerarquia, 
                    ej.tiempo  FROM `escalas` e
                RIGHT JOIN tipojerarquia tj on (tj.id_grp_estructura=e.id_tipo_jerarquia)
                LEFT JOIN jerarquias j on (j.tipo=tj.id)
                LEFT JOIN escalas_jeraquias ej on (ej.id_escala=e.id and ej.id_jerarquia=j.id)
                order by tj.id,e.id,j.orden") ;
            
            $query_unidades = DB::select("SELECT idgrupo, grupo, idunidad, unidad, idescala, escala FROM v_unidades_escalas") ;

                        
            $query_tiendas = DB::table('v_unidades_tiendas_escalas')->get();
            
            return view('re.escalas')
            ->with('select_escala',$query_select_escalas)
            ->with('escala_unidades',$query_unidades)
            ->with('escala_tiendas',$query_tiendas)
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
        try {
            $data = $request->except('_token');
    
            // Si viene del botón de agregar nueva escala
            if (isset($data['escala']) && isset($data['grupoId'])) {
                $nombre = trim($data['escala']);
                $grupoId = intval($data['grupoId']);
    
                if ($nombre === '' || $grupoId === 0) {
                    return response()->json([
                        'code' => 400,
                        'message' => 'Nombre o grupo no válido.'
                    ]);
                }
    
                // Crear la nueva escala
                $id_nueva = DB::table('escalas')->insertGetId([
                    'nombre' => $nombre,
                    'id_tipo_jerarquia' => $grupoId
                ]);

                $query_select_escalas=DB::select("SELECT e.id, e.id_tipo_jerarquia idgrupo, e.nombre FROM escalas e");
    
                return response()->json([
                    'code' => 200,
                    'message' => 'Escala creada correctamente.',
                    'data' => [
                        'id_escala' => $id_nueva,
                        'select_escalas'=> $query_select_escalas,
                    ]
                ]);
            }
    
            // Si viene del botón de guardar (editar tiempos)
            $esc = $data['esc'] ?? null;
            $datos = json_decode($data['datos'] ?? '[]');
    
            if (!$esc || !is_array($datos) || empty($datos)) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Datos incompletos o inválidos.'
                ]);
            }
    
            DB::beginTransaction();
    
            DB::table('escalas_jeraquias')->where('id_escala', '=', $esc)->delete();
    
            foreach ($datos as $item) {
                if (!isset($item->idjer) || !isset($item->tiempo)) {
                    continue;
                }
    
                if ($item->tiempo > 0) {
                    DB::table('escalas_jeraquias')->insert([
                        'id_escala' => $esc,
                        'id_jerarquia' => $item->idjer,
                        'tiempo' => $item->tiempo
                    ]);
                }
            }
    
            DB::commit();
    
            return response()->json([
                'code' => 200,
                'message' => 'Datos guardados correctamente.'
            ]);
    
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'code' => 500,
                'message' => 'Error al guardar.',
                'error' => $e->getMessage()
            ]);
        }
    }
    

    

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $data = $request->except('_token');
        $idescala = $data['idescala'];
        
        $query_escalas = DB::select("SELECT id_unidad FROM escalas_unidades_rel WHERE id_escala=$idescala") ;
        
        return response()->json([
            'code' => 200,
            'message' => 'Success.',
            'data' => [
                'unidades' => $query_escalas
            ]
            
        ]);
        
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
        $data = $request->except('_token');
        $idescala = $data['idescala'];
        $cl = $data['cl'];
        $seleccionados = $data['selechk']; 
    
        // Opcional: eliminar los registros anteriores para esa escala si querés limpiar antes
        DB::table('escalas_unidades_rel')->where('id_escala', $idescala)->delete();
        DB::table('escalas_unidades_rel')->whereIn('id_unidad', $seleccionados)->delete();
    
        // Insertar los nuevos seleccionados
        foreach ($seleccionados as $item) {
            DB::table('escalas_unidades_rel')->insert([
                'id_escala' => $idescala,
                'id_unidad' => $item
            ]);
        }
    

        if($cl==0)
        {   $query = DB::select("SELECT idunidad, escala FROM v_unidades_escalas") ;}

        else
        {   $query = DB::select("SELECT idsuc as idunidad , escala FROM v_unidades_tiendas_escalas") ;}
       


        return response()->json([
            'code' => 200,
            'message' => 'Escala actualizada correctamente.',
            'data' => [
                'unidades_escala' => $query
            ]
        ]);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $data = $request->except('_token');
        $esc = $data['esc'] ?? null;
    
        if (!$esc) {
            return response()->json(['code' => 400, 'message' => 'ID de escala no proporcionado.']);
        }
    
        // Verificar si la escala está relacionada con alguna unidad
        $relacionadas = DB::table('escalas_unidades_rel')
                          ->where('id_escala', $esc)
                          ->pluck('id_unidad');
    
        if ($relacionadas->isEmpty()) {
            // Eliminar datos relacionados
            DB::table('escalas_jeraquias')->where('id_escala', $esc)->delete();
            DB::table('escalas')->where('id', $esc)->delete(); // Opcional: elimina también la escala en sí

            $query_escalas = DB::select("SELECT id_unidad FROM escalas_unidades_rel WHERE id_escala=$esc") ;



            $query_select_escalas=DB::select("SELECT e.id, e.id_tipo_jerarquia idgrupo, e.nombre FROM escalas e");
    
            return response()->json([
                'code' => 200,
                'message' => 'Escala eliminada correctamente.',
                'data' => [
                    'select_escalas'=> $query_select_escalas,
                ]
            ]);

        } else {
            return response()->json([
                'code' => 403,
                'message' => 'No se puede eliminar la escala. Está relacionada a una unidad, por favor verifique.'
            ]);
        }
    }
    
}