<?php

namespace App\Http\Controllers\gd;

use App\Http\Controllers\Controller;
use App\Models\gd\eval_res_comp;
use App\Models\gd\eval_res_cursos_cumpli;
use App\Models\gd\eval_res_cursos_pid_adic;
use App\Models\gd\eval_res_cursos_pid_comp;
use App\Models\gd\eval_res_cursos_pid_hab;
use App\Models\gd\eval_res_gap;
use App\Models\gd\eval_res_hab;
use App\Models\gd\eval_res_kpi_cumpli;
use App\Models\gd\eval_res_tar;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EvaluacionController extends Controller
{
    public function index()
    {               
        $id_menu=20;
        $id_menu_sup=19;
        if (isset(Auth::user()->id)) 
        {   $id_user = Auth::user()->id;
            $reset_pass=0;
            $email='-';
            $query_reset = DB::select("SELECT reset_pass, email FROM users where id=$id_user");     
         
            foreach ($query_reset as $r)
            {   $reset_pass=$r->reset_pass;$email=$r->email; }
            if($reset_pass==0)
            { 
                $id_codigo_evaluador = Auth::user()->codigo;
                $data=0;
                $query = DB::select("SELECT rm.id_menu 
                FROM usr_rol ur INNER JOIN rol_menu rm ON (rm.id_rol=ur.id_rol AND rm.id_menu=$id_menu) 
                WHERE ur.id_usr=$id_user ");
                foreach ($query as $r)
                {   $data=$r->id_menu;}
                if($data!=0)
                {   $eval_id=0;$eval_desde="";$eval_hasta="";
                    $query_evaluaciones = DB::select("SELECT 
                    eval.id, eval.desde, eval.hasta
                    FROM evaluaciones eval  
                    WHERE eval.status=1 ");//0 pausada, 1 abierta, 2 cerrada
                    foreach ($query_evaluaciones as $r)
                    {   $eval_id=$r->id;
                        $eval_desde= \Carbon\Carbon::parse($r->desde)->isoFormat('DD \d\e MMM  Y');
                        $eval_hasta= \Carbon\Carbon::parse($r->hasta)->isoFormat('DD \d\e MMM  Y'); }
                    
                    $nom_pue_evaluador="-";$nom_evaluador="-";
                    $query_evaluador = DB::select("SELECT 
                    emp.prinombre,
                    emp.segnombre,
                    emp.priapellido,
                    pos.descpue
                    FROM m_empleados emp  
                    LEFT JOIN posiciones pos on (pos.id=emp.id_posicion)
                    WHERE emp.id=$id_codigo_evaluador ");
                    
                    foreach ($query_evaluador as $r)
                    {   $nom_evaluador=$r->prinombre;
                        if(($r->segnombre!=null)&&($r->segnombre!=NULL))
                        {   $nom_evaluador.=" ".$r->segnombre;}
                        $nom_evaluador.=" ".$r->priapellido;
                        $nom_pue_evaluador=$r->descpue;
                    }

                    $query_evaluados = DB::table('eval_evaluado_evaluador as eval')
                    ->select('eval.id_evaluado',               
                        'emp.prinombre',         
                        'emp.segnombre',     
                        'emp.priapellido',           
                        'eval.id_posicion_evaluado',   
                        'pos.descpue',
                        'pos.iduni',
                        'est.nameund',
                        'pos.iddf',
                        'eval.status',
                        'eval.resultado')
                    ->leftjoin('posiciones as pos','pos.id','=','eval.id_posicion_evaluado') 
                    ->leftjoin('m_empleados as emp','emp.id','=','eval.id_evaluado') 
                    ->leftjoin('estructuras as est','est.id','=','pos.iduni')    
                    ->where('eval.id_evaluador','=',$id_codigo_evaluador)     
                    ->where('eval.id_evaluacion','=',$eval_id)    
                    ->get();
                
                    return view('gd.evaluacion')
                    ->with('id_menu',$id_menu)
                    ->with('id_menu_sup',$id_menu_sup)
                    ->with('eval_id',$eval_id)
                    ->with('eval_desde',$eval_desde)
                    ->with('eval_hasta',$eval_hasta)
                    ->with('evaluados',$query_evaluados)
                    ->with('codigo_evaluador',$id_codigo_evaluador)
                    ->with('nom_evaluador',$nom_evaluador)
                    ->with('nom_pue_evaluador',$nom_pue_evaluador);
                }
                else{   return redirect()->route('login');}
            }else{
                return view('conf.reset')
                ->with('email',$email)
                ->with('pag','evaluacion');
            }

        }
        else{   return redirect()->route('login');}
    }

    public function evaluado(Request $request)
    {   $id_evaluador = Auth::user()->codigo;        
        $data= request()->except('_token');
        $id_evdo= $data['id_evdo'];
        $eval_id=0;
        $status=0;
        $nom_evaluado='-';$photo="-";$iddf=0;$resultado=0;$logros=""; $comentarios="";$carrera="";

        $query_evaluaciones = DB::select("SELECT eval.id FROM evaluaciones eval WHERE eval.status=1 ");//0 pausada, 1 abierta, 2 cerrada
        foreach ($query_evaluaciones as $r)
        {   $eval_id=$r->id; }

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
            eval.id_posicion_evaluado,
            pos.descpue,
            est.nameund,
            pos.iddf
            FROM m_empleados AS emp 
            LEFT JOIN eval_evaluado_evaluador eval ON (eval.id_evaluacion=$eval_id and eval.id_evaluado=emp.id and eval.id_evaluador=$id_evaluador)
            LEFT JOIN posiciones as pos ON (pos.id=eval.id_posicion_evaluado)
            LEFT JOIN estructuras as est ON (est.id=pos.iduni)
            WHERE emp.id=$id_evdo;");
            foreach ($data_evaluado as $r)
            {   $nom_evaluado=$r->prinombre." ".$r->priapellido;
                
                $code_evaluado=$r->id;
                $finicio= \Carbon\Carbon::parse($r->finicio)->isoFormat('DD \d\e MMM  Y');
                $iddf=$r->iddf;
            }
            $id_escala="";$query_habilidades="";$query_res_cursos="";$query_tareas="";$query_respon = "";$data_competencias="";$query_resp_comp="";$query_resp_gap="";$query_resp_curcomp="";$query_resp_curhab="";$query_resp_curadic="";$query_resp_respon="";$query_resp_tar="";
            $query_resp_hab="";$query_resp_cursos="";$query_res_kpi="";$query_res_kpi_cumpli="";
            $prom_metas=0;
        if($status<=2)
        {    
            if($iddf>0)
            {
                $data_competencias=DB::select("SELECT 
                rel.idcomp AS idcomp,
                comp.nombre AS nomcomp,
                comp.definicion AS definicion,
                comp.definicion_resumen AS definicion_resumen,
                tipo.nombretipocompetencia AS nomtipocomp,
                rel.esperado AS perfil,
                resp.opt
                FROM descriptivos AS df 
                    LEFT JOIN reljercomp as rel ON (rel.idjer=df.idjer)
                    LEFT JOIN competencias as comp ON (comp.id=rel.idcomp)
                    LEFT JOIN tipocompetencia as tipo ON (tipo.id=rel.idtipocomp)
                    LEFT JOIN eval_res_comp as resp ON (resp.id_comp=rel.idcomp and resp.id_evaluado=$id_evdo and resp.id_evaluador=$id_evaluador and resp.id_eval=$eval_id)
                WHERE df.id=$iddf ORDER BY tipo.id, comp.nombre");
                
                $escala_comp=0;
                $escala_respon=0;
                $escala_habi=0;
                $escala_cursos=0;
                $escala_kpi=0;
                $escala_rse=0;

                foreach( $data_competencias as $competencias )
                { $escala_comp=1;}
                
                $query_respon = DB::select("SELECT respon.id as id_respon, respon.area_respon as area_respon, respon.kpi as kpi, (SELECT count(1) from descrip_area_respon_tareas as tareas where tareas.criticidad='Alto' and respon.id=tareas.idarearespon) as cant_tarea
                FROM descrip_area_respon as respon 
                WHERE respon.iddf=$iddf
                AND respon.id in(SELECT tareas.idarearespon from descrip_area_respon_tareas as tareas where tareas.criticidad='Alto')
                ORDER BY respon.id");  
                foreach( $query_respon as $respon )
                { $escala_respon=1;}
                
                $query_tareas= DB::select("SELECT tareas.idarearespon, tareas.id, tareas.tarea, tareas.criticidad, resp.opt
                FROM descrip_area_respon as respon            
                INNER JOIN descrip_area_respon_tareas as tareas ON (respon.id=tareas.idarearespon and tareas.criticidad='Alto')
                LEFT JOIN eval_res_tar as resp ON (resp.id_tar=tareas.id and resp.id_evaluado=$id_evdo and resp.id_evaluador=$id_evaluador and resp.id_eval=$eval_id)
                WHERE respon.iddf=$iddf
                ORDER BY tareas.id");

                $query_habilidades= DB::select("SELECT habi.id, habi.habilidad, habi.nivel, resp.opt
                FROM descrip_habilidades as habi
                LEFT JOIN eval_res_hab as resp ON (resp.id_hab=habi.id and resp.id_evaluado=$id_evdo and resp.id_evaluador=$id_evaluador and resp.id_eval=$eval_id)
                WHERE habi.iddf=$iddf
                ORDER BY habi.id");
                foreach( $query_habilidades as $habilidades)
                { $escala_habi=1;}
                
                $query_res_cursos= DB::select("SELECT res.id_curso, res.nom_curso, res.nota FROM eval_res_cursos as res
                WHERE res.id_eval=$eval_id and res.cod_colab=$id_evdo and id_curso<>23484");# 23484 es "como navegar en UBITS" este curso no se toma en cuenta
                foreach( $query_res_cursos as $rescursos )
                { $escala_cursos=1;}

                $cont_meta=0;$prom_metas=0;
                $query_res_kpi= DB::select("SELECT metas.id, metas.nom_kpi, metas.real FROM eval_kpi_metas as metas WHERE metas.id_eval=$eval_id and metas.id_evaluado=$id_evdo");
                foreach( $query_res_kpi as $kpis )
                { $escala_kpi=1;
                    $cont_meta++;
                    $prom_metas= $prom_metas+ $kpis->real;
                }
                if($escala_kpi==1)
                {
                    $prom_metas= $prom_metas/$cont_meta;
                }
                $clave= $escala_comp.$escala_respon.$escala_habi.$escala_cursos.$escala_kpi.$escala_rse;// ESAS VARIABLES LLEVAN EL CONTROL DE LAS SECCIONES DE LA EVALUACIÓN CONTROLANDO LAS ESCALAS DE QUE APLICARAN EN LA EVALUACIÓN
                
                $query_escala= DB::select("SELECT id FROM eval_m_escalas WHERE clave=$clave");
                foreach( $query_escala as $escala )
                { $id_escala= $escala->id;}
                $query_resp_curcomp= DB::select("SELECT  id_comp, comp,id_curso, curso, fecha  FROM eval_res_cursos_pid_comp WHERE id_eval=$eval_id and id_evaluado=$id_evdo and id_evaluador=$id_evaluador ");
                $query_resp_curhab= DB::select("SELECT  id_curso, curso, fecha  FROM eval_res_cursos_pid_hab WHERE id_eval=$eval_id and id_evaluado=$id_evdo and id_evaluador=$id_evaluador ");
                $query_resp_curadic= DB::select("SELECT area, curso, accion  FROM eval_res_cursos_pid_adic WHERE id_eval=$eval_id and id_evaluado=$id_evdo and id_evaluador=$id_evaluador ");
                $query_resp_hab= DB::select("SELECT hab, opt, peso, obtenido, gap FROM eval_res_hab WHERE id_eval=$eval_id and id_evaluado=$id_evdo and id_evaluador=$id_evaluador ");
                $query_resp_cursos= DB::select("SELECT curso, opt, peso, obtenido, (peso-obtenido) as gap FROM eval_res_cursos_cumpli WHERE id_eval=$eval_id and id_evaluado=$id_evdo and id_evaluador=$id_evaluador ");
            }
        }
        if($status==3)
        { 
            $query_resp_comp= DB::select("SELECT id_comp, comp, opt, prf, peso, obtenido, gap  FROM eval_res_comp WHERE id_eval=$eval_id and id_evaluado=$id_evdo  order by prf desc, gap desc");

            $query_resp_respon= DB::select("SELECT id_respon, respon, sum(peso) as peso, sum(obtenido) as obtenido, sum(gap) as gap FROM eval_res_tar WHERE id_eval=$eval_id and id_evaluado=$id_evdo  GROUP BY id_respon, respon");
            $query_resp_tar= DB::select("SELECT id_respon, tar, opt, peso, obtenido, gap FROM eval_res_tar WHERE id_eval=$eval_id and id_evaluado=$id_evdo  ");
            $query_resp_hab= DB::select("SELECT hab, opt, peso, obtenido, gap FROM eval_res_hab WHERE id_eval=$eval_id and id_evaluado=$id_evdo ");
            $query_resp_cursos= DB::select("SELECT curso, opt, peso, obtenido, (peso-obtenido) as gap FROM eval_res_cursos_cumpli WHERE id_eval=$eval_id and id_evaluado=$id_evdo  ");

            $query_res_kpi_cumpli= DB::select("SELECT cumplimiento_promedio, peso, obtenido FROM eval_res_kpi_cumpli WHERE id_eval=$eval_id and id_evaluado=$id_evdo");
            $query_res_kpi= DB::select("SELECT metas.id, metas.nom_kpi, metas.real FROM eval_kpi_metas as metas WHERE metas.id_eval=$eval_id and metas.id_evaluado=$id_evdo");


            $query_resp_gap= DB::select("SELECT gap_ci, gap_na, gap_comp, gap_conhab, gap  FROM eval_res_gap WHERE id_eval=$eval_id and id_evaluado=$id_evdo ");
            $query_resp_curcomp= DB::select("SELECT id_comp, comp, curso, fecha  FROM eval_res_cursos_pid_comp WHERE id_eval=$eval_id and id_evaluado=$id_evdo ");
            $query_resp_curhab= DB::select("SELECT  id_curso, curso, fecha  FROM eval_res_cursos_pid_hab WHERE id_eval=$eval_id and id_evaluado=$id_evdo  ");
            $query_resp_curadic= DB::select("SELECT area, curso, accion  FROM eval_res_cursos_pid_adic WHERE id_eval=$eval_id and id_evaluado=$id_evdo ");
        }
        $salidaJson=array(
            "evaluador"=>$id_evaluador,
            "status"=>$status,
            "nom_evaluado"=>$nom_evaluado,
            "finicio"=>$finicio,
            "evaluado"=>$data_evaluado,
            "competencias"=>$data_competencias,
            "respons"=>$query_respon,
            "tareas"=>$query_tareas,
            "habilidades"=>$query_habilidades,
            "res_cursos"=>$query_res_cursos,
            "res_kpi"=>$query_res_kpi,
            "prom_metas"=>round($prom_metas,2),
            "escala"=>$id_escala,
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
            "resp_gap"=>$query_resp_gap,
            "resp_curcomp"=>$query_resp_curcomp,
            "resp_resp_curhab"=>$query_resp_curhab,
            "resp_curadic"=>$query_resp_curadic,
            "feval"=>$feval,
        );

        echo(json_encode($salidaJson));
    }

    public function showfoto(Request $request)
    {
       /* if (isset(Auth::user()->id)) 
        {  */ $data= request()->except('_token');
            $id_evdo= $data['id_evdo'];
            
            $query = DB::select("SELECT photo FROM m_empleados WHERE id=$id_evdo");
            foreach ($query as $res)
            {   if($res->photo!=null)
                {   $dataresp= '<img src="data:image/png;base64,'.base64_encode($res->photo).'" class="rounded-circle" id="img_photo"/>';}
                else
                { $dataresp=$res->photo;  }
            }
            echo($dataresp);
       /* }else{
            return view('auth.login');
        }*/
    }

    public function compcursos(Request $request)
    {
       /* if (isset(Auth::user()->id)) 
        { */  $data= request()->except('_token');
            if($data['tipo']=='hab')
            {
                $evaluado= $data['evaluado'];
                $eval_id= $data['eval_id'];
                $query= DB::select("SELECT curso.id_curso, curso.curso, curso.area
                FROM cursos_habilidades as curso
                WHERE curso.id_curso not in (Select id from eval_res_cursos where cod_colab=$evaluado and id_eval=$eval_id)
                ORDER BY curso.area");
            }
            else
            {   $id= $data['id'];
                $evaluado= $data['evaluado'];
                $eval_id= $data['eval_id'];
                $query= DB::select("SELECT curso.id_curso, curso.curso
                FROM competencias_cursos as curso
                WHERE curso.id_comp=$id and curso.id_curso not in (Select id from eval_res_cursos where cod_colab=$evaluado and id_eval=$eval_id)
                ORDER BY curso.curso");
            }
            echo(json_encode($query));
        /*}else{
            return view('auth.login');
        }*/
    }

    public function save(Request $request)
    {
       /* if (isset(Auth::user()->id)) 
        { */ $data= request()->except('_token');
           $competencias= $data['competencias'];
           $tareas=  $data['tareas'];
           $hab=  $data['hab'];           

            DB::table('eval_res_comp')->where('id_eval','=', $data['eval_id'])->where('id_evaluado','=', $data['cod_evaluado'])->where('id_evaluador','=', $data['cod_evaluador'])->delete();
            DB::table('eval_res_tar')->where('id_eval','=', $data['eval_id'])->where('id_evaluado','=', $data['cod_evaluado'])->where('id_evaluador','=', $data['cod_evaluador'])->delete();
            DB::table('eval_res_hab')->where('id_eval','=', $data['eval_id'])->where('id_evaluado','=', $data['cod_evaluado'])->where('id_evaluador','=', $data['cod_evaluador'])->delete();      
            DB::table('eval_res_cursos_cumpli')->where('id_eval','=', $data['eval_id'])->where('id_evaluado','=', $data['cod_evaluado'])->where('id_evaluador','=', $data['cod_evaluador'])->delete();  
            DB::table('eval_res_kpi_cumpli')->where('id_eval','=', $data['eval_id'])->where('id_evaluado','=', $data['cod_evaluado'])->delete();  
            DB::table('eval_res_cursos_pid_comp')->where('id_eval','=', $data['eval_id'])->where('id_evaluado','=', $data['cod_evaluado'])->where('id_evaluador','=', $data['cod_evaluador'])->delete();     
            DB::table('eval_res_cursos_pid_hab')->where('id_eval','=', $data['eval_id'])->where('id_evaluado','=', $data['cod_evaluado'])->where('id_evaluador','=', $data['cod_evaluador'])->delete();        
            DB::table('eval_res_cursos_pid_adic')->where('id_eval','=', $data['eval_id'])->where('id_evaluado','=', $data['cod_evaluado'])->where('id_evaluador','=', $data['cod_evaluador'])->delete();    
            DB::table('eval_res_gap')->where('id_eval','=', $data['eval_id'])->where('id_evaluado','=', $data['cod_evaluado'])->delete();      
            
            $id_escala=$data['id_escala'];
            $query_escala_peso= DB::select("SELECT id_seccion, peso 
            FROM  eval_secciones_pesos 
            WHERE id_escala=$id_escala");
            $cumplimiento_comp=0;
            $cumplimiento_tar=0;
            $cumplimiento_hab=0;

            foreach ($query_escala_peso as $escala_peso)
            {   
                if(($escala_peso->id_seccion==1)&&($escala_peso->peso>0))
                {   $peso_comp=$escala_peso->peso;
                    $tot_obtenido_comp=0;
                    foreach ($competencias as $res)
                    {   $id_comp= $res['id'];
                        $nom_comp= $res['nom_comp'];
                        $valor= $res['valor'];
                        $perf= $res['perf']+1;
                        $peso=$escala_peso->peso/$data['countcomp'];
                        $obtenido=0;
                        if($valor>=$perf)
                        {   $obtenido=$peso;}
                        else
                        {   $obtenido=($valor/$perf)*$peso;}
                        
                        $tot_obtenido_comp=$tot_obtenido_comp+$obtenido;

                        $gap=$peso-$obtenido;
                        $new = new eval_res_comp();
                        $new->id_eval = $data['eval_id'];
                        $new->id_evaluado = $data['cod_evaluado'];
                        $new->id_evaluador = $data['cod_evaluador'];
                        $new->id_comp = $id_comp;
                        $new->comp = $nom_comp;
                        $new->opt = $valor;
                        $new->prf = $perf;
                        $new->peso =  round($peso,7);
                        $new->obtenido =  round($obtenido,7);
                        $new->gap =  round($gap,7);
                        $new->save();
                    }
                    $cumplimiento_comp=$tot_obtenido_comp/$peso_comp;
                    
                }
                if(($escala_peso->id_seccion==2)&&($escala_peso->peso>0))
                {   $peso_tar=$escala_peso->peso;
                    $tot_obtenido_tar=0;
                    foreach ($tareas as $res)
                    {
                        $id_respon= $res['idrespon'];
                        $respon= $res['respon'];
                        $id_tar= $res['idtar'];
                        $tar= $res['tar'];
                        $valor= $res['valor'];
                        $peso= $escala_peso->peso/$data['counttar'];
                        $obtenido=($valor/5)*$peso;

                        $tot_obtenido_tar=$tot_obtenido_tar+$obtenido;

                        $gap=$peso-$obtenido;
                        $new = new eval_res_tar();
                        $new->id_eval = $data['eval_id'];
                        $new->id_evaluado = $data['cod_evaluado'];
                        $new->id_evaluador = $data['cod_evaluador'];
                        $new->id_respon = $id_respon;
                        $new->respon = $respon;
                        $new->id_tar = $id_tar;
                        $new->tar = $tar;
                        $new->opt = $valor;
                        $new->peso =  round($peso,7);
                        $new->obtenido =  round($obtenido,7);
                        $new->gap =  round($gap,7);
                        $new->save();
                    }
                    $cumplimiento_tar=$tot_obtenido_tar/$peso_tar;
                }
                if(($escala_peso->id_seccion==3)&&($escala_peso->peso>0))
                {   $peso_hab=$escala_peso->peso;
                    
                    $tot_obtenido_hab=0;
                    foreach ($hab as $res)
                    {
                        $idhab= $res['idhab'];
                        $hab= $res['hab'];                    
                        if($res['valor']==1){   $valor= 0;}
                        if($res['valor']==2){   $valor= 3;}
                        if($res['valor']==3){   $valor= 5;}
                        $peso= $escala_peso->peso/$data['counthab'];
                        $obtenido=($valor/5)*$peso;

                        $tot_obtenido_hab=$tot_obtenido_hab+$obtenido;

                        
                        $gap=$peso-$obtenido;
                        $new = new eval_res_hab();
                        $new->id_eval = $data['eval_id'];
                        $new->id_evaluado = $data['cod_evaluado'];
                        $new->id_evaluador = $data['cod_evaluador'];
                        $new->id_hab = $idhab;
                        $new->hab = $hab;
                        $new->opt = $valor;
                        $new->peso =  round($peso,7);
                        $new->obtenido =  round($obtenido,7);
                        $new->gap =  round($gap,7);
                        $new->save();
                    }
                    $cumplimiento_hab=$tot_obtenido_hab/$peso_hab;
                }


          
                if(($escala_peso->id_seccion==4)&&($escala_peso->peso>0))
                {   $total_cursos=$data['countpid_cumpli'];
                    foreach ($data['pid_cursos_cumpli'] as $res)
                    {
                        $id_curso_cumpli= $res['id_curso_cumpli'];
                        $nom_curso_cumpli= $res['nom_curso_cumpli'];         
                        $nota_curso_cumpli= $res['nota_curso_cumpli'];  

                                        
                        if($nota_curso_cumpli<80){   $obtenido= 0;} 
                        if($nota_curso_cumpli>=80){  $obtenido= $escala_peso->peso/ $data['countpid_cumpli'];}
                        $peso= $escala_peso->peso/$data['countpid_cumpli'];
                        
                        
                        $new = new eval_res_cursos_cumpli();
                        $new->id_eval = $data['eval_id'];
                        $new->id_evaluado = $data['cod_evaluado'];
                        $new->id_evaluador = $data['cod_evaluador'];
                        $new->id_curso = $id_curso_cumpli;
                        $new->curso = $nom_curso_cumpli;
                        $new->opt = $nota_curso_cumpli;
                        $new->peso =  round($peso,7);
                        $new->obtenido =  round($obtenido,7);
                        $new->save();
                    }
                }

                if(($escala_peso->id_seccion==5)&&($data['countkpi_cumpli']>0))
                {   $promedio=0;
                    $obtenido=0;
                    $peso= $escala_peso->peso;

                    $eval_id = $data['eval_id'];
                    $id_evdo = $data['cod_evaluado'];

                    $query_res_kpi= DB::select("SELECT AVG(metas.real) as prom FROM eval_kpi_metas as metas WHERE metas.id_eval=$eval_id and metas.id_evaluado=$id_evdo");
                    foreach( $query_res_kpi as $r )
                    { $promedio= $r->prom; }

                    $query= DB::select("SELECT esc.porcentaje FROM eval_escala_x_seccion AS esc WHERE esc.id_seccion=5 and $promedio>=esc.minimo_mayor_igual and  $promedio<=esc.maximo_menor_que");
                    foreach( $query as $r )
                    { $obtenido= ($r->porcentaje/100) * $escala_peso->peso; }

                    $new = new eval_res_kpi_cumpli();
                    $new->id_eval = $data['eval_id'];
                    $new->id_evaluado = $data['cod_evaluado'];

                    $new->cumplimiento_promedio = round($promedio,2);
                    $new->peso =  round($peso,7);
                    $new->obtenido =  round($obtenido,7);
                    $new->save();
                    
                }
               }   
                
                if(count($data['pid_comp_cursos'])>0)
                {   foreach ($data['pid_comp_cursos'] as $res)
                    {   if($res['pid_id_comp']>0)
                        { 
                            $pid_id_comp= $res['pid_id_comp'];
                            $pid_comp= $res['pid_comp'];
                            $pid_comp_fecha= $res['fecha'];
            
                            $new = new eval_res_cursos_pid_comp();
                            $new->id_eval = $data['eval_id'];
                            $new->id_evaluado = $data['cod_evaluado'];
                            $new->id_evaluador = $data['cod_evaluador'];
                            $new->id_comp = $pid_id_comp;
                            $new->comp = $pid_comp;
                            if($res['id_curso_com']>0)
                            {   $new->id_curso = $res['id_curso_com'];
                                $new->curso = $res['nom_curso_com'];
                                $new->fecha = $pid_comp_fecha;
                            }
                            $new->save();
                        }
                    }
                }
                
                if(count($data['pid_hab_cursos'])>0)
                {    foreach ($data['pid_hab_cursos'] as $res)
                    {   if($res['id_curso_hab']>0)
                        {   $id_curso_hab= $res['id_curso_hab'];
                            $nom_curso_hab= $res['nom_curso_hab'];    
                            $fecha_curso_hab= $res['fecha'];                 
                            $new = new eval_res_cursos_pid_hab();
                            $new->id_eval = $data['eval_id'];
                            $new->id_evaluado = $data['cod_evaluado'];
                            $new->id_evaluador = $data['cod_evaluador'];
                            $new->id_curso = $id_curso_hab;
                            $new->curso = $nom_curso_hab;
                            $new->fecha = $fecha_curso_hab;
                            $new->save();
                        }
                    }
                }

                if(count($data['pid_adic_cursos'])>0)
                {    foreach ($data['pid_adic_cursos'] as $res)
                    {   if($res['area']!='-')
                        {                 
                            $new = new eval_res_cursos_pid_adic();
                            $new->id_eval = $data['eval_id'];
                            $new->id_evaluado = $data['cod_evaluado'];
                            $new->id_evaluador = $data['cod_evaluador'];
                            $new->area = $res['area'];
                            $new->curso = $res['nom_curso'];
                            $new->accion = $res['accion'];
                            $new->save();
                        }
                    }
                }

            $id_evaluado=$data['cod_evaluado'];
            $query= DB::select("SELECT coef_intelectual, niv_academico 
            FROM  m_empleados 
            WHERE id=$id_evaluado");
            foreach ($query as $res)
            {
                $coef_intelectual=($res->coef_intelectual)/100;
                $niv_academico=($res->niv_academico)/100;
            }

            $new = new eval_res_gap();
            $new->id_eval = $data['eval_id'];
            $new->id_evaluado = $data['cod_evaluado'];
        
            $new->ci = round(($coef_intelectual * 20),7);
            $new->na = round(($niv_academico * 20),7);
            $new->comp = round(($cumplimiento_comp * 30),7);
            $new->conhab =  round((($cumplimiento_hab * 10)+($cumplimiento_tar * 20)),7);
            $new->cumplimiento =  round(( ($coef_intelectual * 20)+($niv_academico * 20)+($cumplimiento_comp * 30)+(($cumplimiento_hab * 10)+($cumplimiento_tar * 20))),7);

            $new->gap_ci = round((20-($coef_intelectual * 20)),7);
            $new->gap_na = round((20-($niv_academico * 20)),7);
            $new->gap_comp = round((30-($cumplimiento_comp * 30)),7);
            $new->gap_conhab =  round(((10-($cumplimiento_hab * 10))+(20-($cumplimiento_tar * 20))),7);
            $new->gap =  round(( (20-($coef_intelectual * 20)) + (20-($niv_academico * 20)) + (30-($cumplimiento_comp * 30)) + ((10-($cumplimiento_hab * 10))+(20-($cumplimiento_tar * 20)))),7);

            $new->save();

            $obtenido_comp=0; $obtenido_tar=0; $obtenido_hab=0; $obtenido_cumpli=0; $obtenido_kpi_cumpli=0;
            $id_eval=$data['eval_id'];
            $id_evaluado= $data['cod_evaluado'];
            $cod_evaluador=$data['cod_evaluador'];

            $query= DB::select("SELECT sum(obtenido) as obtenido FROM eval_res_comp WHERE id_eval=$id_eval and id_evaluado=$id_evaluado and id_evaluador=$cod_evaluador");
            foreach( $query as $res )
            { $obtenido_comp= $res->obtenido;}
            
            $query= DB::select("SELECT sum(obtenido) as obtenido FROM eval_res_tar WHERE id_eval=$id_eval and id_evaluado=$id_evaluado and id_evaluador=$cod_evaluador");
            foreach( $query as $res )
            { $obtenido_tar= $res->obtenido;}
            
            $query= DB::select("SELECT sum(obtenido) as obtenido FROM eval_res_hab WHERE id_eval=$id_eval and id_evaluado=$id_evaluado and id_evaluador=$cod_evaluador");
            foreach( $query as $res )
            { $obtenido_hab= $res->obtenido;}
            
            $query= DB::select("SELECT sum(obtenido) as obtenido FROM eval_res_cursos_cumpli WHERE id_eval=$id_eval and id_evaluado=$id_evaluado and id_evaluador=$cod_evaluador");
            foreach( $query as $res )
            { $obtenido_cumpli= $res->obtenido;}

            $query= DB::select("SELECT sum(obtenido) as obtenido FROM eval_res_kpi_cumpli WHERE id_eval=$id_eval and id_evaluado=$id_evaluado");
            foreach( $query as $res )
            { $obtenido_kpi_cumpli= $res->obtenido;}

            $total=round(($obtenido_comp + $obtenido_tar + $obtenido_hab + $obtenido_cumpli + $obtenido_kpi_cumpli),7);

            $categoria='-';$color='';
            $query= DB::select("SELECT categoria, color FROM eval_res_escala WHERE id_eval = $id_eval and $total >= minimo and $total< maximo");
            foreach( $query as $res )
            {   $categoria=$res->categoria;
                $color=$res->color; }

            DB::table('eval_evaluado_evaluador')
            ->where('id_evaluacion','=', $data['eval_id'])
            ->where('id_evaluado','=', $data['cod_evaluado'])
            ->where('id_evaluador','=', $data['cod_evaluador'])
            ->update(['status' => $data['estatus'],'logros' => trim($data['logros']),'comentarios_evaldor' => trim($data['comentarios']),'resultado'=>$total,'categoria'=>$categoria, 'color'=>$color,'carrera' => $data['desarrollo']]);

            $salidaJson=array("resultado"=>$total,"categoria"=>$categoria,"color"=>$color, );
    
            echo(json_encode($salidaJson));

       /* }
        else{   return view('auth.login');}*/
    }
    
    public function print(Request $request)
    {
        /*if (isset(Auth::user()->id)) 
        { */  $data= request()->except('_token');
            $id_evdo= $data['id_evdo_rpt'];
            $id_evaluador = Auth::user()->codigo;
            $eval_id= $data['eval_id_rpt'];
            $status= $data['estatus_rpt'];
            $imgData =  $data['image'];

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
                LEFT JOIN posiciones as pos ON (pos.id=emp.id_posicion)
                LEFT JOIN estructuras as est ON (est.id=pos.iduni)
                WHERE emp.id=$id_evdo");
                foreach ($data_evaluado as $r)
                {   $nom_evaluado=$r->prinombre;
                    if(($r->segnombre!=null)&&($r->segnombre!=NULL))
                    {   $nom_evaluado.=" ".$r->segnombre;}
                    $nom_evaluado.=" ".$r->priapellido;
                    $code_evaluado=$r->id;
                    $finicio= \Carbon\Carbon::parse($r->finicio)->isoFormat('DD \d\e MMM  Y');
                    $iddf=$r->iddf;

                }

                $query = DB::select("SELECT photo FROM m_empleados WHERE id=$id_evdo");
                foreach ($query as $res)
                {   if($res->photo!=null)
                    {   $photo= '<img src="data:image/png;base64,'.base64_encode($res->photo).'" class="rounded-circle" id="img_photo" width="100" height="100"/>';}
                    else
                    { $photo=$res->photo;  }
                }
                $query_resp_comp= DB::select("SELECT id_comp, comp, opt, prf, peso, obtenido, gap  FROM eval_res_comp WHERE id_eval=$eval_id and id_evaluado=$id_evdo  order by prf desc, gap desc");

                $query_resp_respon= DB::select("SELECT id_respon, respon, sum(peso) as peso, sum(obtenido) as obtenido, sum(gap) as gap FROM eval_res_tar WHERE id_eval=$eval_id and id_evaluado=$id_evdo GROUP BY id_respon, respon");
                $query_resp_tar= DB::select("SELECT id_respon, tar, opt, peso, obtenido, gap FROM eval_res_tar WHERE id_eval=$eval_id and id_evaluado=$id_evdo  ");
                $query_resp_hab= DB::select("SELECT hab, opt, peso, obtenido, gap FROM eval_res_hab WHERE id_eval=$eval_id and id_evaluado=$id_evdo  ");
                $query_resp_cursos= DB::select("SELECT curso, opt, peso, obtenido, (peso-obtenido) as gap FROM eval_res_cursos_cumpli WHERE id_eval=$eval_id and id_evaluado=$id_evdo ");
    
                $query_res_kpi_cumpli= DB::select("SELECT cumplimiento_promedio, peso, obtenido FROM eval_res_kpi_cumpli WHERE id_eval=$eval_id and id_evaluado=$id_evdo");
                $query_res_kpi= DB::select("SELECT metas.id, metas.nom_kpi, metas.real FROM eval_kpi_metas as metas WHERE metas.id_eval=$eval_id and metas.id_evaluado=$id_evdo");

                $query_resp_gap= DB::select("SELECT gap_ci, gap_na, gap_comp, gap_conhab, gap  FROM eval_res_gap WHERE id_eval=$eval_id and id_evaluado=$id_evdo ");
                $query_resp_curcomp= DB::select("SELECT id_comp, comp, curso, fecha  FROM eval_res_cursos_pid_comp WHERE id_eval=$eval_id and id_evaluado=$id_evdo  ");
                $query_resp_curhab= DB::select("SELECT  id_curso, curso, fecha  FROM eval_res_cursos_pid_hab WHERE id_eval=$eval_id and id_evaluado=$id_evdo ");
                $query_resp_curadic= DB::select("SELECT area, curso, accion  FROM eval_res_cursos_pid_adic WHERE id_eval=$eval_id and id_evaluado=$id_evdo ");

                // Eliminar el prefijo de base64
                $imgData = str_replace('data:image/png;base64,', '', $imgData);
                $imgData = base64_decode($imgData);
        
                // Crear una imagen temporal para guardarla en el servidor
                $imagePath = storage_path('app/public/grafica.png');
                file_put_contents($imagePath, $imgData);             

                $data=json_encode(array(
                "feval"=>$feval,
                "id_evdo"=>$id_evdo,
                "id_evdor"=>$id_evaluador,
                "eval_id"=>$eval_id,
                "status"=>$status,
                "nom_evaluado"=>$nom_evaluado,
                "finicio"=>$finicio,
                "evaluado"=>$data_evaluado,
                "resultado"=>round($resultado,1),
                "categoria"=>$categoria,
                "color"=>$color,
                "logros"=>$logros,
                "comentarios"=>$comentarios,
                "carrera"=>$carrera,
                "photo"=>$photo,
               /* "competencias"=>$data_competencias,
                "respons"=>$query_respon,
                "tareas"=>$query_tareas,
                "habilidades"=>$query_habilidades,
                "res_cursos"=>$query_res_cursos,
                "escala"=>$id_escala,*/

                
                "res_kpi"=>$query_res_kpi,
                "resp_kpi_cumpli"=>$query_res_kpi_cumpli,
                "resp_comp"=>$query_resp_comp,
                "resp_respon"=>$query_resp_respon,
                "resp_tar"=>$query_resp_tar,
                "resp_hab"=>$query_resp_hab,
                "resp_cursos"=>$query_resp_cursos,
                "resp_gap"=>$query_resp_gap,    
                "resp_curcomp"=>$query_resp_curcomp,
                "resp_resp_curhab"=>$query_resp_curhab,
                "resp_curadic"=>$query_resp_curadic,
                "imgData"=>'<img src="data:image/png;base64,'.base64_encode($imgData).'" id="graf" width="100%" />',
            ));
    
            

            $pdf = Pdf::setPaper('letter')->loadView('gd.print', compact('data'));                
            $safe_nom_evaluado = preg_replace('/[^a-zA-Z0-9_\-]/', '', $nom_evaluado);
            return $pdf->stream('Evaluación '.$safe_nom_evaluado.'.pdf');



       /* }
        else{   return view('auth.login');}*/
    }

    public function leermas(Request $request)
    {
        $data= request()->except('_token');
        $idcomp= $data['idcomp'];
        $query = DB::select("SELECT nombre,definicion,nivel_alto,nivel_bajo FROM competencias WHERE id=$idcomp");
       
        echo(json_encode($query));
        
    }
}
