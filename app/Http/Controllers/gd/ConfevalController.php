<?php

namespace App\Http\Controllers\gd;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConfevalController extends Controller
{
    public function index()
    {   $id_menu=24;
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
            {   $query_evaluaciones = Db::select("SELECT id,desde, hasta, observacion, status, activo, proceso, finalizado, rechazado, total FROM vw_evaluaciones order by id desc");

                return view('gd.confeval')
                ->with('id_menu',$id_menu)
                ->with('id_menu_sup',$id_menu_sup)
                ->with('evaluaciones',$query_evaluaciones);
            }else{
                return view('auth.login');
            }
        }else{
            return view('auth.login');
        }
    }

    public function cambiapuesto(Request $request)
    {
        $data= request()->except('_token');        
        $code_puestoevaldo= $data['code_puestoevaldo'];        
        $query_unidades = Db::select("SELECT id, nameund FROM estructuras where id_tipo=2 order by nameund");        
        $query_puestos = Db::select("SELECT pue1.id,pue1.descpue, pue1.idue FROM posiciones pue1 INNER JOIN posiciones pue2 on (pue2.idue=pue1.idue and pue2.id=$code_puestoevaldo ) order by pue1.descpue");
        $salidaJson=array(
            "unidades"=>$query_unidades,
            "puestos"=>$query_puestos,               
        );
        echo(json_encode($salidaJson));
    }

    public function cambiaunidad(Request $request)
    {
        $data= request()->except('_token');        
        $sel_unidad= $data['sel_unidad'];                
        $query_puestos = Db::select("SELECT pue1.id,pue1.descpue, pue1.idue FROM posiciones pue1 where pue1.idue=$sel_unidad order by pue1.descpue");
        $salidaJson=array(
            "puestos"=>$query_puestos,               
        );
        echo(json_encode($salidaJson));
    }

    public function cambianewpuesto(Request $request)
    {
        $data= request()->except('_token');
        $id_eval= $data['id_eval'];  
        $cod_evaluado= $data['cod_evaluado'];  
        $sel_puesto= $data['sel_puesto'];  

        $query = Db::select("SELECT eval.status FROM eval_evaluado_evaluador eval where id_evaluacion=$id_eval and id_evaluado=$cod_evaluado");
        foreach ($query as $r)
        {   $status=$r->status;}
        if($status==1)
        {
            DB::table('eval_evaluado_evaluador')
                ->where('id_evaluacion','=', $id_eval)->where('id_evaluado','=', $cod_evaluado)
                ->update(['id_posicion_evaluado' => $sel_puesto]);
        }
        echo $status;
    }

    public function levaldos(Request $request)
    {
        if (isset(Auth::user()->id)) 
        {   $data= request()->except('_token');
            $id= $data['id_eval'];
            $query_evaluacion = Db::select("SELECT id,desde, hasta, observacion, status, activo, proceso, finalizado, rechazado, total FROM vw_evaluaciones where id=$id");
            $query_evaluados = DB::table('eval_evaluado_evaluador as eval')
            ->select('eval.id_evaluado',               
                'emp.prinombre',      
                'emp.priapellido',           
                'eval.id_posicion_evaluado',   
                'pos.descpue',
                'pos.iduni',
                'pos.idue',
                'est.nameund',
                'pos.iddf',
                'eval.status',
                'eval.resultado',
                'eval.id_evaluador',               
                'emp_evaldor.prinombre as nom_evaldor',      
                'emp_evaldor.priapellido as ape_evaldor')
            ->leftjoin('posiciones as pos','pos.id','=','eval.id_posicion_evaluado') 
            ->leftjoin('m_empleados as emp','emp.id','=','eval.id_evaluado') 
            ->leftjoin('estructuras as est','est.id','=','pos.iduni')        
            ->leftjoin('m_empleados as emp_evaldor','emp_evaldor.id','=','eval.id_evaluador') 
            ->where('eval.id_evaluacion','=',$id)    
            ->get();

            $salidaJson=array(
                "evaluacion"=>$query_evaluacion,
                "evaluados"=>$query_evaluados,               
            );
    
            echo(json_encode($salidaJson));
        }
        else
        {   return view('auth.login');}
    }

    public function levaldores(Request $request)
    {
        if (isset(Auth::user()->id)) 
        {   $data= request()->except('_token');
            $id= $data['id_eval'];
            $query_evaluacion = Db::select("SELECT id,desde, hasta, observacion, status, activo, proceso, finalizado, rechazado, total FROM vw_evaluaciones where id=$id");
            $query_evaluadores = DB::select("WITH evaluadores as (SELECT e.id_evaluador, 
                SUM(CASE WHEN e.status <= 1 THEN 1 ELSE 0 END) AS pendiente, 
                SUM(CASE WHEN e.status = 2 THEN 1 ELSE 0 END) AS en_proceso, 
                SUM(CASE WHEN e.status = 3 THEN 1 ELSE 0 END) AS evaluado, 
                SUM(CASE WHEN e.status = 4 THEN 1 ELSE 0 END) AS rechazado
            FROM eval_evaluado_evaluador e 
            WHERE e.id_evaluacion = $id
            GROUP BY e.id_evaluador) 
            SELECT eval.id_evaluador, emp.prinombre, emp.priapellido, pos.descpue, pos.iduni, est.nameund, eval.pendiente+eval.en_proceso as por_evaluar,
            eval.evaluado+eval.rechazado as por_evaluados
            from evaluadores eval 
            left join m_empleados as emp on (emp.id=eval.id_evaluador) 
            left join posiciones as pos on (pos.id=emp.id_posicion) 
            left join estructuras as est on (est.id=pos.iduni)");

            $salidaJson=array(
                "evaluacion"=>$query_evaluacion,
                "evaluadores"=>$query_evaluadores,               
            );
    
            echo(json_encode($salidaJson));
        }
        else
        {   return view('auth.login');}
    }
    public function editstatus(Request $request)
    {
        if (isset(Auth::user()->id)) 
        {   $data= request()->except('_token');
            $st= $data['st'];      
            if($st==1)
            {   DB::table('eval_evaluado_evaluador')
                ->where('id_evaluacion','=', $data['eval_id'])
                ->where('id_evaluado','=', $data['cod_evaluado'])
                ->where('id_evaluador','=', $data['cod_evaluador'])
                ->update(['status' =>  $st,'logros' => null,'comentarios_evaldor' => null,'resultado'=>0,'carrera' => 2]);
                      
                DB::table('eval_res_comp')->where('id_eval','=', $data['eval_id'])->where('id_evaluado','=', $data['cod_evaluado'])->where('id_evaluador','=', $data['cod_evaluador'])->delete();
                DB::table('eval_res_tar')->where('id_eval','=', $data['eval_id'])->where('id_evaluado','=', $data['cod_evaluado'])->where('id_evaluador','=', $data['cod_evaluador'])->delete();
                DB::table('eval_res_hab')->where('id_eval','=', $data['eval_id'])->where('id_evaluado','=', $data['cod_evaluado'])->where('id_evaluador','=', $data['cod_evaluador'])->delete();      
                DB::table('eval_res_cursos_cumpli')->where('id_eval','=', $data['eval_id'])->where('id_evaluado','=', $data['cod_evaluado'])->where('id_evaluador','=', $data['cod_evaluador'])->delete();  
                DB::table('eval_res_cursos_pid_comp')->where('id_eval','=', $data['eval_id'])->where('id_evaluado','=', $data['cod_evaluado'])->where('id_evaluador','=', $data['cod_evaluador'])->delete();     
                DB::table('eval_res_cursos_pid_hab')->where('id_eval','=', $data['eval_id'])->where('id_evaluado','=', $data['cod_evaluado'])->where('id_evaluador','=', $data['cod_evaluador'])->delete();        
                DB::table('eval_res_cursos_pid_adic')->where('id_eval','=', $data['eval_id'])->where('id_evaluado','=', $data['cod_evaluado'])->where('id_evaluador','=', $data['cod_evaluador'])->delete();    
                DB::table('eval_res_gap')->where('id_eval','=', $data['eval_id'])->where('id_evaluado','=', $data['cod_evaluado'])->delete(); 
            }
            if($st>1)
            {   DB::table('eval_evaluado_evaluador')
                ->where('id_evaluacion','=', $data['eval_id'])
                ->where('id_evaluado','=', $data['cod_evaluado'])
                ->where('id_evaluador','=', $data['cod_evaluador'])
                ->update(['status' =>  $st]); 
            }
            if($st==1){ $respons='<span class="badge bg-secondary">Pendiente</span>';}
            if($st==2){ $respons='<span class="badge bg-warning">En Proceso</span>';}
            if($st==3){ $respons='<span class="badge bg-primary">Evaluado</span>';}
            if($st==4){ $respons='<span class="badge bg-danger">Rechazado</span>';}
            echo $respons;
        }
        else
        {   return view('auth.login');}
    }
    
    public function evaluadores(Request $request)
    {
        if (isset(Auth::user()->id)) 
        {   $data= request()->except('_token');
            $eval_id=$data['eval_id'];
            $query_evaluadores= DB::select("SELECT distinct mae.id as id_evaluador, mae.prinombre, mae.priapellido, mae.id_posicion, pos.descpue 
            /*FROM eval_evaluado_evaluador edor 
                left join m_empleados mae on (mae.id = edor.id_evaluador)*/
                FROM m_empleados mae
                left join posiciones pos on (mae.id_posicion = pos.id)
               /* where edor.id_evaluacion=$eval_id  */
                order by mae.prinombre and mae.priapellido");
            echo(json_encode($query_evaluadores));
        }
        else
        {   return view('auth.login');}
    }

    public function updateevaldor(Request $request)
    {
        if (isset(Auth::user()->id)) 
        {   $data= request()->except('_token');
            $new_cod_evaluador=$data['new_cod_evaluador'];
            DB::table('eval_evaluado_evaluador')
                ->where('id_evaluacion','=', $data['eval_id'])
                ->where('id_evaluado','=', $data['cod_evaluado'])
                ->where('id_evaluador','=', $data['cod_evaluador'])
                ->update(['id_evaluador' =>  $new_cod_evaluador]);

            $query_new_evaluador= DB::select("SELECT  mae.id, mae.prinombre, mae.priapellido FROM m_empleados mae             
                where mae.id=$new_cod_evaluador");
            echo(json_encode($query_new_evaluador));
        }
        else
        {   return view('auth.login');}
    }   

    public function mailevaluador(Request $request)
    {   if (isset(Auth::user()->id)) 
        { 
            $data= request()->except('_token');
            $id_evaldor=$data['id_evaldor'];
            $query_mail_evaluador= DB::select("SELECT email as mail FROM users where codigo=$id_evaldor");
            echo(json_encode($query_mail_evaluador));
        }
        else
        {   return view('auth.login');}
    }
    public function resetpass(Request $request)
    {   if (isset(Auth::user()->id)) 
        {   $data= request()->except('_token');
            $codigo=$data['id_evaldor'];
            $mail=$data['mail'];
            $query = DB::table('users')
            ->select('id')
            ->where('codigo', $codigo)
            ->where('email', $mail)
            ->first();
            $band=0;
            foreach ($query as $r)
            {   $band=1; }
            if($band==1)
            {   DB::table('users')
                ->where('codigo','=', $data['id_evaldor'])->where('email','=', $data['mail'])
                ->update(['password' => Hash::make($data['newpass']),'reset_pass'=>$data['chk']]);}
            echo $band;        
        }
        else
        {   return view('auth.login');}
    }

    public function informe(Request $request)
    {
        $data= request()->except('_token');     
        $eval_id= $data['eval'];
        $id_evdo= $data['evaldo'];
        $id_evaluador= $data['evaldor'];



        $data_evaluado=DB::select("SELECT eval.status, eval.resultado, eval.categoria, eval.color, eval.logros, eval.comentarios_evaldor, eval.carrera, eval.updated_at  FROM eval_evaluado_evaluador eval WHERE eval.id_evaluado=$id_evdo and eval.id_evaluador=$id_evaluador and eval.id_evaluacion=$eval_id");
        foreach ($data_evaluado as $r)
        {   $status=$r->status;
            $resultado=$r->resultado;
            $categoria=$r->categoria;
            $color=$r->color;
            $logros=$r->logros;
            $comentarios=$r->comentarios_evaldor;
            $carrera=$r->carrera;
            $feval= \Carbon\Carbon::parse($r->updated_at)->isoFormat('DD \d\e MMM  Y');}        

            $data_evaluado=DB::select("SELECT 
            emp.id,
            emp.prinombre,
            emp.segnombre, 
            emp.priapellido,
            emp.genero,
            emp.finicio,
            emp.id_posicion,
            pos.descpue,
            est.nameund,
            pos.iddf
            FROM m_empleados AS emp 
            LEFT JOIN eval_evaluado_evaluador eval on (eval.id_evaluado=$id_evdo and eval.id_evaluacion=$eval_id)
            LEFT JOIN posiciones as pos ON (pos.id=eval.id_posicion_evaluado)
            LEFT JOIN estructuras as est ON (est.id=pos.iduni)
            WHERE emp.id=$id_evdo");
            foreach ($data_evaluado as $r)
            {   $nom_evaluado=$r->prinombre." ".$r->priapellido;
                
                $code_evaluado=$r->id;
                $finicio= \Carbon\Carbon::parse($r->finicio)->isoFormat('DD \d\e MMM  Y');
                $iddf=$r->iddf;
            }
            /*$id_escala="";$query_habilidades="";$query_res_cursos="";$query_tareas="";$query_respon = "";$data_competencias="";$query_resp_comp="";$query_resp_gap="";$query_resp_curcomp="";$query_resp_curhab="";$query_resp_curadic="";$query_resp_respon="";$query_resp_tar="";
            $query_resp_hab="";$query_resp_cursos="";$query_res_kpi="";$query_res_kpi_cumpli="";
            $prom_metas=0;*/


            $query_resp_evaluador= DB::select("SELECT emp.id, emp.prinombre, emp.priapellido, pos.descpue FROM m_empleados emp 
            LEFT JOIN posiciones pos on (pos.id=emp.id_posicion) where emp.id=$id_evaluador");
            foreach ($query_resp_evaluador as $r)
            {   $nom_evaluador=$r->id." - ".$r->prinombre." ".$r->priapellido;
                $puesto_evaldor=$r->descpue;                
            }

        $query_resp_comp= DB::select("SELECT id_comp, comp, opt, prf, peso, obtenido, gap  FROM eval_res_comp WHERE id_eval=$eval_id and id_evaluado=$id_evdo  and id_evaluador=$id_evaluador order by prf desc, gap desc");

        $query_resp_respon= DB::select("SELECT id_respon, respon, sum(peso) as peso, sum(obtenido) as obtenido, sum(gap) as gap FROM eval_res_tar WHERE id_eval=$eval_id and id_evaluado=$id_evdo and id_evaluador=$id_evaluador  GROUP BY id_respon, respon");
        $query_resp_tar= DB::select("SELECT id_respon, tar, opt, peso, obtenido, gap FROM eval_res_tar WHERE id_eval=$eval_id and id_evaluado=$id_evdo  and id_evaluador=$id_evaluador ");
        $query_resp_hab= DB::select("SELECT hab, opt, peso, obtenido, gap FROM eval_res_hab WHERE id_eval=$eval_id and id_evaluado=$id_evdo and id_evaluador=$id_evaluador ");
        $query_resp_cursos= DB::select("SELECT curso, opt, peso, obtenido, (peso-obtenido) as gap FROM eval_res_cursos_cumpli WHERE id_eval=$eval_id and id_evaluado=$id_evdo and id_evaluador=$id_evaluador  ");

        $query_res_kpi_cumpli= DB::select("SELECT cumplimiento_promedio, peso, obtenido FROM eval_res_kpi_cumpli WHERE id_eval=$eval_id and id_evaluado=$id_evdo ");
        $query_res_kpi= DB::select("SELECT metas.id, metas.nom_kpi, metas.real FROM eval_kpi_metas as metas WHERE metas.id_eval=$eval_id and metas.id_evaluado=$id_evdo");


        $query_resp_gap= DB::select("SELECT gap_ci, gap_na, gap_comp, gap_conhab, gap  FROM eval_res_gap WHERE id_eval=$eval_id and id_evaluado=$id_evdo ");
        $query_resp_curcomp= DB::select("SELECT id_comp, comp, curso, fecha  FROM eval_res_cursos_pid_comp WHERE id_eval=$eval_id and id_evaluado=$id_evdo  and id_evaluador=$id_evaluador");
        $query_resp_curhab= DB::select("SELECT  id_curso, curso, fecha  FROM eval_res_cursos_pid_hab WHERE id_eval=$eval_id and id_evaluado=$id_evdo  and id_evaluador=$id_evaluador ");
        $query_resp_curadic= DB::select("SELECT area, curso, accion  FROM eval_res_cursos_pid_adic WHERE id_eval=$eval_id and id_evaluado=$id_evdo  and id_evaluador=$id_evaluador");



        $salidaJson=array(
            "evaluador"=>$id_evaluador,
            "status"=>$status,
            "nom_evaluado"=>$nom_evaluado,
            "finicio"=>$finicio,
            "evaluado"=>$data_evaluado,
            "nom_evaldor"=>$nom_evaluador,
            "puesto_evaldor"=>$puesto_evaldor,
           /* "competencias"=>$data_competencias,
            "respons"=>$query_respon,
            "tareas"=>$query_tareas,
            "habilidades"=>$query_habilidades,
            "res_cursos"=>$query_res_cursos,
            "res_kpi"=>$query_res_kpi,
            "prom_metas"=>round($prom_metas,2),
            "escala"=>$id_escala,*/
            "resultado"=>round($resultado,1),
            "categoria"=>$categoria,
            "color"=>$color,
            "logros"=>$logros,
            "comentarios"=>$comentarios,
            "carrera"=>$carrera,


            "resp_comp"=>$query_resp_comp,
            "resp_respon"=>$query_resp_respon,
            "resp_tar"=>$query_resp_tar,
            "resp_hab"=>$query_resp_hab,
            "resp_cursos"=>$query_resp_cursos,
            "resp_kpi_cumpli"=>$query_res_kpi_cumpli,
            "res_kpi"=>$query_res_kpi,
            "resp_gap"=>$query_resp_gap,
            "resp_curcomp"=>$query_resp_curcomp,
            "resp_resp_curhab"=>$query_resp_curhab,
            "resp_curadic"=>$query_resp_curadic,
            "feval"=>$feval,
            
        );

        echo(json_encode($salidaJson));
        
    }

    public function avances(Request $request)
    {
        if (isset(Auth::user()->id)) 
        {   $data= request()->except('_token');
            $id_eval=$data['id_eval'];
            $query_grupos= DB::select("SELECT 
                up.nameund AS undsup, 
                u.nameund AS und, 
                SUM(e.status <= 1) AS pendiente, 
                SUM(e.status = 2) AS en_proceso, 
                SUM(e.status = 3) AS evaluado, 
                SUM(e.status = 4) AS rechazado, 
                COUNT(*) AS total,
                ROUND(COALESCE((SUM(e.status = 3) + SUM(e.status = 4)) * 1.0 / NULLIF(COUNT(*), 0), 0)*100, 0) AS cumplimiento
            FROM eval_evaluado_evaluador e 
            JOIN posiciones p ON e.id_posicion_evaluado = p.id 
            JOIN estructuras u ON p.idue = u.id 
            JOIN estructuras up ON u.id_sup = up.id 
            WHERE e.id_evaluacion = $id_eval
            GROUP BY up.id, up.nameund, u.id, u.nameund
            ORDER BY up.id ASC, cumplimiento DESC;");
    //        echo(json_encode($query_grupos));

            $query_grp_consolidado= DB::select("SELECT 
                up.nameund AS undsup, 
                SUM(CASE WHEN e.status <= 1 THEN 1 ELSE 0 END) AS pendiente, 
                SUM(CASE WHEN e.status = 2 THEN 1 ELSE 0 END) AS en_proceso, 
                SUM(CASE WHEN e.status = 3 THEN 1 ELSE 0 END) AS evaluado, 
                SUM(CASE WHEN e.status = 4 THEN 1 ELSE 0 END) AS rechazado, 
                COUNT(*) AS total, 
                ROUND(COALESCE((SUM(CASE WHEN e.status IN (3,4) THEN 1 ELSE 0 END) * 1.0 / NULLIF(COUNT(*), 0)), 0) * 100, 0) AS cumplimiento
            FROM eval_evaluado_evaluador e
            JOIN posiciones p ON e.id_posicion_evaluado = p.id
            JOIN estructuras u ON p.idue = u.id
            JOIN estructuras up ON u.id_sup = up.id
            WHERE e.id_evaluacion = $id_eval
            GROUP BY up.nameund
            ORDER BY up.nameund ASC;");

            $salidaJson=array(
                "det_grupos"=>$query_grupos,                
                "grp_consolidado"=>$query_grp_consolidado,                
            );
    
            echo(json_encode($salidaJson));



        }
        else
        {   return view('auth.login');}
    }

}

