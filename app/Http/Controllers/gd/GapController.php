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
                    FORMAT(AVG(r.TOTAL),1)  AS gap
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

                $query_gap_grupos= Db::select("SELECT 
                    MAX(r.id_eval) AS max_id_eval, 
                    e.ano_corresp AS year_ano_corresp,
                    r.idgrupo,
                    r.grupo,
                    FORMAT(r.COEFICIENTE_INTELECTUAL,1) COEFICIENTE_INTELECTUAL, 
                    FORMAT(r.NIVEL_ACADEMICO,1) NIVEL_ACADEMICO, 
                    FORMAT(r.COMPETENCIAS,1) COMPETENCIAS, 
                    FORMAT(r.HABILIDADES,1) HABILIDADES, 
                    FORMAT(r.TOTAL,1) TOTAL
                FROM 
                    rpt_gap_total r 
                LEFT JOIN 
                    evaluaciones e ON e.id = r.id_eval
                    WHERE e.ano_corresp=$ano
                GROUP BY 
                    r.idgrupo, r.grupo, 
                    r.COEFICIENTE_INTELECTUAL, 
                    r.NIVEL_ACADEMICO, 
                    r.COMPETENCIAS, 
                    r.HABILIDADES, 
                    r.TOTAL,
                    e.ano_corresp 
                order by r.idgrupo");

                $query_gap_total_jer= Db::select("SELECT jerarquia, gap_jer gap FROM rpt_gap_total_jer  where id_eval=$id_eval ORDER BY rpt_gap_total_jer.orden_jer ASC");

                $query_gap_unidades=Db::select("SELECT idgrupo,grupo,unidad,COEFICIENTE_INTELECTUAL,NIVEL_ACADEMICO,COMPETENCIAS,HABILIDADES,GAP FROM rpt_gap_unidades WHERE id_eval=$id_eval ORDER BY idgrupo,GAP asc");

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

                $meta_dap=20;
                return view('gd.dashgap')
                ->with('id_menu',$id_menu)
                ->with('id_menu_sup',$id_menu_sup)
                ->with('gap_global',$query_gap_global)
                ->with('gap_grupos',$query_gap_grupos)
                ->with('meta_dap',$meta_dap)
                ->with('gap_total_jer',$query_gap_total_jer)
                ->with('gap_unidades',$query_gap_unidades)
                ->with('gap_jer_unidades',$query_gap_jer_unidades);
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
