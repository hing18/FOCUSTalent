<?php

namespace App\Http\Controllers\gd;

use App\Http\Controllers\Controller;
use App\Models\re\Ofertas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GapDirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   $id_menu=26;
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
                {   $query_dir= Db::select("SELECT grupo, codigo, nameund, tipo FROM v_unidades_direcciones ORDER BY idgrupo, nameund asc");
                    return view('gd.dashgapdir')
                    ->with('id_menu',$id_menu)
                    ->with('id_menu_sup',$id_menu_sup)
                    ->with('rsdir',$query_dir);
                }else{
                return view('auth.login');
            }
        }else{
            return view('auth.login');}
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
        // Obtener los datos del request, excluyendo _token
        $data = request()->except('_token');
        $item = explode("-", $data['selectedValue']);
        $idund = $item[0];
        $tipo = $item[1];

        // Definir la consulta con parámetros vinculados
        
            // Consulta cuando tipo no es 3
            $query_gapund = DB::select("
                SELECT 
                    MAX(id_eval) AS id_eval,
                    MAX(year_ano_corresp)year_ano_corresp,
                    idgrupo,
                    grupo,
                    idunidad,
                    unidad,
                    COEFICIENTE_INTELECTUAL,
                    NIVEL_ACADEMICO,
                    COMPETENCIAS,
                    HABILIDADES,
                    GAP
                FROM rpt_gap_und_consolidado
                WHERE idunidad = ? 
                GROUP BY idgrupo, grupo, idunidad, unidad, COEFICIENTE_INTELECTUAL, NIVEL_ACADEMICO, COMPETENCIAS, HABILIDADES, GAP", [$idund]);

        // Inicializar variables
        $ano = "";
        $id_eval = 0;
        $unidad = "-";
        // Extraer los resultados de la consulta
        foreach ($query_gapund as $r) {
            $unidad = $r->unidad;
            $ano = $r->year_ano_corresp;
            $id_eval = $r->id_eval; }

            $query_gapundjer = DB::select("
            SELECT           
            id_eval,
            idunidad,
            unidad,
            jerarquia,
            orden_jer,
            gap_ci,
            gap_na,
            gap_comp as gap_com,
            gap_hab,
            tot_gap
            FROM rpt_gap_und_jer
            WHERE idunidad = ? AND id_eval = ? 
            ORDER BY orden_jer ASC", [$idund, $id_eval]);

        if($tipo==2)
        { $query_colab=DB::select("SELECT 
            jerarquia,
            unidad,
            area_cadena,
            id_evaluado,
            nombre,
            puesto,
            gap_ci,
            gap_na,
            gap_comp as gap_com,
            gap_conhab as gap_hab,
            gap 
            FROM rpt_gap_consolidado 
            where idarea_cadena not in (129,157) 
            and id_eval= ?
            and idunidad= ?
            ORDER BY orden_jer, puesto  ASC", [$id_eval,$idund]);

            $query_fotos = DB::select("SELECT r.id_evaluado, m.genero, m.photo 
            FROM rpt_gap_consolidado r  
            LEFT JOIN m_empleados m ON (m.id = r.id_evaluado)
            WHERE r.idarea_cadena NOT IN (129,157) 
            AND r.id_eval = ? 
            AND r.idunidad = ?", [$id_eval, $idund]);
        }
            
        if($tipo==3)
        {   $query_colab=DB::select("SELECT 
            jerarquia,
            unidad,
            area_cadena,
            id_evaluado,
            nombre,
            puesto,
            gap_ci,
            gap_na,
            gap_comp as gap_com,
            gap_conhab as gap_hab,
            gap 
            FROM rpt_gap_consolidado
            where id_eval= ?
            and idarea_cadena= ? 
            ORDER BY orden_jer, puesto ASC", [$id_eval,$idund]);

            $query_fotos = DB::select("SELECT r.id_evaluado, m.genero, m.photo 
            FROM rpt_gap_consolidado r  
            LEFT JOIN m_empleados m ON (m.id = r.id_evaluado)
            WHERE r.id_eval = ? 
            AND r.idarea_cadena = ?", [$id_eval, $idund]);
        }
        $datos_photo = []; // Array para guardar todas las fotos
        foreach ($query_fotos as $res) {
            if(($res->photo != null)) {
                $photo = '<img src="data:image/png;base64,'.base64_encode($res->photo).'" class="card-img-top rounded-circle bg-white" alt="..." style="width: 120px; height: 120px; object-fit: cover; border: 5px solid #4B6EAD;">';
            } else {
                if($res->genero == 'F') {
                    $photo = '<img src="storage/profiles/photo/ella.png" class="card-img-top rounded-circle bg-white" alt="..." style="width: 120px; height: 120px; object-fit: cover; border: 5px solid #4B6EAD;">';
                } else {
                    ///FOCUSTalent/public/
                    $photo = '<img src="storage/profiles/photo/el.png" class="card-img-top rounded-circle bg-white" alt="..." style="width: 120px; height: 120px; object-fit: cover; border: 5px solid #4B6EAD;">';
                }
            }
            // Guardar todas las fotos en el array
            $datos_photo[] = ['id_ivaluado' => $res->id_evaluado, 'photo' => $photo];
        }
        
        // Crear el arreglo de salida
        $salidaJson = array(
            "unidad" => $unidad,
            "ano" => $ano,
            "id_eval" => $id_eval,
            "gapund" => $query_gapund,
            "gapundjer" => $query_gapundjer,
            "colab" => $query_colab,
            "photos"=> $datos_photo,
        );

        // Devolver la respuesta en formato JSON
        return response()->json($salidaJson);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function pid(Request $request)
    {
        $data = request()->except('_token');
        $id_eval = $data['id_eval'];
        $id_evaluado = $data['id_evaluado'];
        $query_pidcomp=DB::select("SELECT comp,curso,fecha 
        FROM eval_res_cursos_pid_comp
        where id_eval= ?
        and id_evaluado= ? ", [$id_eval,$id_evaluado]);

        $query_pidhab=DB::select("SELECT curso,fecha 
        FROM eval_res_cursos_pid_hab
        where id_eval= ?
        and id_evaluado= ? ", [$id_eval,$id_evaluado]);

        $query_pidad=DB::select("SELECT area,curso,accion
        FROM eval_res_cursos_pid_adic
        where id_eval= ?
        and id_evaluado= ? ", [$id_eval,$id_evaluado]);

        $query_values_comp=DB::select("SELECT comp,opt,prf+2 prf,prf prfmin FROM eval_res_comp where id_eval= ? and id_evaluado= ? ", [$id_eval,$id_evaluado]);

        // Crear el arreglo de salida
        $salidaJson = array(
            "pidcomp" => $query_pidcomp,
            "pidhab" => $query_pidhab,
            "pidad" => $query_pidad,
            "values_comp"=>$query_values_comp,
            
        );

        // Devolver la respuesta en formato JSON
        return response()->json($salidaJson);
  

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
    }
}
