<?php

namespace App\Http\Controllers\gd;

use App\Http\Controllers\Controller;
use App\Models\re\Ofertas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   $id_menu=25;
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
            {   
                $query_gap_global= Db::select("SELECT 
                    MAX(r.id_eval) AS max_id_eval, 
                    e.ano_corresp AS year_ano_corresp,
                    FORMAT(AVG(r.COEFICIENTE_INTELECTUAL),1) AS ci, 
                    FORMAT(AVG(r.NIVEL_ACADEMICO),1) AS na, 
                    FORMAT(AVG(r.COMPETENCIAS),1) AS com, 
                    FORMAT(AVG(r.HABILIDADES),1) AS hab, 
                    FORMAT(AVG(r.TOTAL),1)  AS gap,
                    SUM(r.HC) HC
                FROM 
                    rpt_gap_total r 
                LEFT JOIN 
                    evaluaciones e ON e.id = r.id_eval
                GROUP BY 
                    e.ano_corresp");
                $ano=0;$id_eval=0;
                foreach ($query_gap_global as $r)
                {   $ano=$r->year_ano_corresp;
                    $id_eval=$r->max_id_eval;
                }

                $query_prom_desemp= DB::select("
                -- 1: Calcular el promedio
                    WITH promedio_general AS (
                        SELECT AVG(resultado) AS promedio FROM rpt_gap_consolidado where id_eval= ?
                    )

                -- 2: Buscar el rango correspondiente
                    SELECT ROUND((p.promedio), 1) as promedio, e.categoria, e.color
                    FROM promedio_general p
                    JOIN eval_res_escala e ON p.promedio >= e.minimo AND p.promedio < e.maximo
                    WHERE e.id_eval = ?", [ $id_eval,$id_eval ]);
                $prom_desemp = $query_prom_desemp[0] ?? null;

                $query_prom_desemp_grp = DB::select("
                    WITH promedio_general AS (
                        SELECT idgrupo, AVG(resultado) AS promedio 
                        FROM rpt_gap_consolidado 
                        WHERE id_eval = ? 
                        GROUP BY idgrupo
                    )
                    SELECT 
                        p.idgrupo, 
                        ROUND(p.promedio, 1) AS promedio, 
                        e.categoria, 
                        e.color
                    FROM promedio_general p
                    JOIN eval_res_escala e 
                        ON p.promedio >= e.minimo AND p.promedio < e.maximo
                    WHERE e.id_eval = ?
                ", [ $id_eval, $id_eval ]);

                $prom_desemp_grp = $query_prom_desemp_grp;

                $query_gap_grupos = DB::select("
                    SELECT 
                        MAX(r.id_eval) AS max_id_eval, 
                        e.ano_corresp AS year_ano_corresp,
                        r.idgrupo,
                        r.grupo,
                        ROUND(AVG(r.COEFICIENTE_INTELECTUAL), 1) AS COEFICIENTE_INTELECTUAL,
                        ROUND(AVG(r.NIVEL_ACADEMICO), 1) AS NIVEL_ACADEMICO,
                        ROUND(AVG(r.COMPETENCIAS), 1) AS COMPETENCIAS,
                        ROUND(AVG(r.HABILIDADES), 1) AS HABILIDADES,
                        ROUND(AVG(r.TOTAL), 1) AS TOTAL,
                        SUM(r.HC) AS HC
                    FROM rpt_gap_total r
                    LEFT JOIN evaluaciones e ON e.id = r.id_eval
                    WHERE e.ano_corresp = ?
                    GROUP BY r.idgrupo, r.grupo, e.ano_corresp
                    ORDER BY r.idgrupo
                ", [ $ano ]);


                $query_gap_total_jer= Db::select("SELECT jerarquia, gap_jer gap FROM rpt_gap_total_jer  where id_eval=$id_eval ORDER BY rpt_gap_total_jer.orden_jer ASC");

                $query_gap_unidades=Db::select("SELECT idgrupo,grupo,unidad,COEFICIENTE_INTELECTUAL,NIVEL_ACADEMICO,COMPETENCIAS,HABILIDADES,GAP, HC FROM rpt_gap_unidades WHERE id_eval=$id_eval ORDER BY idgrupo,GAP,HC asc");

                $query_gap_jer_unidades= Db::select("SELECT r.idgrupo, r.grupo, r.jerarquia, 
                    FORMAT((SUM(r.tot_gap) / total_gap_data.total_gap_sum) * MAX(t.TOTAL),1) AS gap_jer
                FROM rpt_gap_consol_jer r
                LEFT JOIN rpt_gap_total t ON t.id_eval = r.id_eval AND t.idgrupo = r.idgrupo
                JOIN ( 
                    SELECT id_eval, idgrupo, SUM(tot_gap) AS total_gap_sum
                    FROM rpt_gap_consol_jer
                    WHERE id_eval = $id_eval
                    GROUP BY id_eval, idgrupo
                ) total_gap_data ON total_gap_data.id_eval = r.id_eval AND total_gap_data.idgrupo = r.idgrupo
                WHERE r.id_eval = $id_eval
                GROUP BY r.idgrupo, r.grupo, r.jerarquia, total_gap_data.total_gap_sum
                ORDER BY r.idgrupo, MAX(r.orden_jer) ASC; ");

                $data_escalas = DB::select("
                    SELECT 
                        escala.categoria,
                        COUNT(r.resultado) AS total_personas,
                        COALESCE(
                            ROUND(COUNT(r.resultado) * 100.0 / NULLIF(t.total_general, 0), 0),
                            0
                        ) AS porcentaje
                    FROM 
                        eval_res_escala escala
                    LEFT JOIN 
                        rpt_gap_consolidado r 
                            ON r.resultado > escala.minimo 
                            AND r.resultado <= escala.maximo 
                            AND r.id_eval = ?
                    JOIN (
                        SELECT 
                            COUNT(*) AS total_general
                        FROM 
                            rpt_gap_consolidado
                        WHERE 
                            id_eval = ? 
                            AND resultado > 0 
                            AND idarea_cadena NOT IN (129, 157)
                    ) t
                    WHERE 
                        escala.id_eval = ?
                    GROUP BY 
                        escala.categoria, escala.maximo, t.total_general
                    ORDER BY 
                        escala.maximo DESC
                ", [ $id_eval, $id_eval, $id_eval ]);


                // Obtener total general aparte
                $total_general = DB::table('rpt_gap_consolidado')
                    ->where('id_eval', $id_eval)
                    ->where('resultado', '>', 0)
                    ->count();

                // Evita dividir por cero
                $total_general = $total_general ?: 1;

                // Consulta principal usando el total como parámetro
                $data_escalas_grp = DB::select("
                    SELECT 
                        r.idgrupo,
                        r.grupo,
                        escala.categoria,
                        COUNT(r.resultado) AS total_personas,
                        COALESCE(
                            ROUND(COUNT(r.resultado) * 100.0 / ?, 0),
                            0
                        ) AS porcentaje
                    FROM 
                        eval_res_escala escala
                    LEFT JOIN 
                        rpt_gap_consolidado r 
                        ON r.resultado > escala.minimo 
                        AND r.resultado <= escala.maximo 
                        AND r.id_eval = ?
                    WHERE 
                        escala.id_eval = ?
                    GROUP BY 
                        escala.categoria, escala.maximo, r.idgrupo, r.grupo
                    ORDER BY 
                        r.idgrupo ASC, 
                        escala.maximo DESC
                ", [$total_general, $id_eval, $id_eval]);



                $meta_dap=20;
                return view('gd.dashgap')
                ->with('id_menu',$id_menu)
                ->with('id_menu_sup',$id_menu_sup)
                ->with('gap_global',$query_gap_global)
                ->with('gap_grupos',$query_gap_grupos)
                ->with('meta_dap',$meta_dap)
                ->with('gap_total_jer',$query_gap_total_jer)
                ->with('gap_unidades',$query_gap_unidades)
                ->with('gap_jer_unidades',$query_gap_jer_unidades)
                ->with('data_escalas',$data_escalas)
                ->with('data_escalas_grp',$data_escalas_grp )
                ->with('prom_desemp',$prom_desemp)
                ->with('prom_desemp_grp',$prom_desemp_grp);
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
    public function show(Ofertas $ofertas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ofertas $ofertas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ofertas $ofertas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ofertas $ofertas)
    {
        //
    }
}
