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
            $query_evaluadores = DB::select("WITH evaluadores as (Select DISTINCT id_evaluador 
            from eval_evaluado_evaluador where id_evaluacion=$id) 
            SELECT eval.id_evaluador, emp.prinombre, emp.priapellido, pos.descpue, pos.iduni, est.nameund 
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
            $query_evaluadores= DB::select("SELECT distinct edor.id_evaluador, mae.prinombre, mae.priapellido, mae.id_posicion, pos.descpue FROM eval_evaluado_evaluador edor 
                left join m_empleados mae on (mae.id = edor.id_evaluador)
                left join posiciones pos on (mae.id_posicion = pos.id)
                where edor.id_evaluacion=$eval_id  order by mae.prinombre and mae.priapellido");
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
}

