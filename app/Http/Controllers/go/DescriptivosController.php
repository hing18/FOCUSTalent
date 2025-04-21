<?php

namespace App\Http\Controllers\go;

use App\Http\Controllers\Controller;
use App\Models\go\Descriptivos;
use App\Models\go\descrip_area_respon;
use App\Models\go\descrip_area_respon_tareas;
use App\Models\go\descrip_habilidades;
use App\Models\go\descrip_programa;
use App\Models\go\descrip_idioma;
use App\Models\go\descrip_decisiones;
use App\Models\go\Jerarquias;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DescriptivosController extends Controller
{

    public function index()
    {   $id_menu=7;
        $id_menu_sup=4;
        if (isset(Auth::user()->id)) 
        {   $id_user = Auth::user()->id;
            $data=0;
            $query = DB::select("SELECT rm.id_menu 
            FROM usr_rol ur INNER JOIN rol_menu rm ON (rm.id_rol=ur.id_rol AND rm.id_menu=$id_menu) 
            WHERE ur.id_usr=$id_user");
            foreach ($query as $r)
            {   $data=$r->id_menu;}
            if($data!=0)
            { 
                $data_jer = DB::table('jerarquias as jer')
                ->select('jer.id AS id', 
                'jer.nombrejer AS nombrejer',
                'jer.status AS status', 
                'jer.orden AS orden', 
                'tipojer.id AS idtipo',
                'tipojer.nombretipojer AS tipo')
                ->leftjoin('tipojerarquia as tipojer','tipojer.id','=','jer.tipo')     
                ->where('jer.status','=','true')  
                ->orderBy('tipojer.nombretipojer')->orderBy('jer.orden')        
                ->get();

                $data_df= DB::table('descriptivos as desc')
                ->select('desc.id AS id', 
                'desc.nombredesc AS nombredesc',
                'desc.status AS status',
                'jer.nombrejer AS nombrejer',
                'tipojer.nombretipojer AS nombretipojer' )
                ->leftjoin('jerarquias as jer','jer.id','=','desc.idjer')  
                ->leftjoin('tipojerarquia as tipojer','tipojer.id','=','jer.tipo')       
                ->orderBy('tipojer.nombretipojer')->orderBy('desc.nombredesc')        
                ->get();

                return view('go.descriptivos')
                ->with('data_jer',$data_jer)
                ->with('data_df',$data_df)
                ->with('id_menu',$id_menu)
                ->with('id_menu_sup',$id_menu_sup);   
            }
            else{   return view('auth.login');}
        }
        else{   return view('auth.login');}
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data= request()->except('_token');
            
            $id_temp= date("Y-m-d H:i:s.u");
            $id= $data["id"];
            $nombredesc= $data['namedf'];
            $idjer= $data['idjer'];
            $cargojefe= $data['cargojefe'];
            $area_depto= trim($data['nameareadf']);
            $reportes= $data['numreportedir'];
            $proposito= trim($data['txtproposito']);

            $status= $data['status'];

            $txt_interno= trim($data['txt_interno']);
            $txt_externo= trim($data['txt_externo']);
            $sel_riesgo= $data['sel_riesgo'];
            $txt_epp= trim($data['txt_epp']);
            $opt_nivel_aca= $data['opt_nivel_aca'];
            $estatus_nivel_aca= $data['estatus_nivel_aca'];
            $txt_nivel_aca= trim($data['txt_nivel_aca']);
  
            $experiencia_norequiere= $data['experiencia_norequiere'];
            $experiencia_aux_asis= $data['experiencia_aux_asis'];
            $experiencia_ana_esp= $data['experiencia_ana_esp'];
            $experiencia_sup_coor= $data['experiencia_sup_coor'];
            $experiencia_jef_dep= $data['experiencia_jef_dep'];
            $experiencia_ge_dir= $data['experiencia_ge_dir'];
            $anos_experiencia= trim($data['anos_experiencia']);
            
            $nrows_habilidad= $data['nrows_habilidad'];      
            if($nrows_habilidad>0)
            {   $data_rows_habilidades= json_decode($data['datajson_habilidades'], true);
                $row_habilidades= $data_rows_habilidades['datos_habilidades'];}
            
            $nrows_programa= $data['nrows_programa'];      
            if($nrows_programa>0)
            {   $data_rows_programa= json_decode($data['datajson_programa'], true);
                $row_programa=$data_rows_programa['datos_programa'];}

            $nrows_idioma= $data['nrows_idioma'];      
            if($nrows_programa>0)
            {  $data_rows_idioma= json_decode($data['datajson_idioma'], true);
               $row_idioma=$data_rows_idioma['datos_idioma'];}

            $nrows_decisiones_sin= $data['nrows_decisiones_sin'];
            $nrows_decisiones_con= $data['nrows_decisiones_con'];

                  
            if(($nrows_decisiones_con>0)||($nrows_decisiones_sin>0))
            {  $data_rows_decisiones= json_decode($data['datajson_decisiones'], true);
                $row_decisiones=$data_rows_decisiones['datos_decisiones'];}

            if($id==0)
            {
                $new = new Descriptivos();
                $new->id_temp = $id_temp;
                $new->nombredesc = $nombredesc;
                $new->idjer = $idjer;
                $new->cargojefe = $cargojefe;
                $new->area_depto = $area_depto;
                $new->reportes = $reportes;
                $new->proposito = $proposito;
                $new->status =  $status;
                $new->relacion_interna =  $txt_interno;
                $new->relacion_externa =  $txt_externo;
                $new->riesgo_ofi_cam =  $sel_riesgo;
                $new->epp =  $txt_epp;
                $new->nivel_academico =  $opt_nivel_aca;
                $new->estatus_academico =  $estatus_nivel_aca;
                $new->estudio_requerido =  $txt_nivel_aca;
                $new->experiencia_norequiere =  $experiencia_norequiere;
                $new->experiencia_aux_asis =  $experiencia_aux_asis;
                $new->experiencia_ana_esp =  $experiencia_ana_esp;
                $new->experiencia_sup_coor =  $experiencia_sup_coor;
                $new->experiencia_jef_dep =  $experiencia_jef_dep;
                $new->experiencia_ge_dir =  $experiencia_ge_dir;
                $new->anos_experiencia =  $anos_experiencia;
                $new->save();


                $query = DB::select("SELECT id FROM descriptivos WHERE id_temp='$id_temp'");
                foreach ($query as $res)
                {   $id= $res->id; } 
                
            }
            else{
                DB::table('descriptivos')
              ->where('id','=', $id)
              ->update([
              'nombredesc' => $nombredesc,
              'idjer' => $idjer,
              'cargojefe' => $cargojefe, 
              'area_depto' => $area_depto, 
              'reportes' => $reportes, 
              'proposito' => $proposito, 
              'status' => $status,
              'relacion_interna' =>  $txt_interno,
              'relacion_externa' =>  $txt_externo,
              'riesgo_ofi_cam' =>  $sel_riesgo,
              'epp' =>  $txt_epp,
              'nivel_academico' =>  $opt_nivel_aca,
              'estatus_academico' =>  $estatus_nivel_aca,
              'estudio_requerido' =>  $txt_nivel_aca,
              'experiencia_norequiere' =>  $experiencia_norequiere,
              'experiencia_aux_asis' =>  $experiencia_aux_asis,
              'experiencia_ana_esp' =>  $experiencia_ana_esp,
              'experiencia_sup_coor' =>  $experiencia_sup_coor,
              'experiencia_jef_dep' =>  $experiencia_jef_dep,
              'experiencia_ge_dir' =>  $experiencia_ge_dir,
              'anos_experiencia' =>  $anos_experiencia,
              ]);
              
            }

            if($nrows_habilidad>0)
            {   
                DB::table('descrip_habilidades') ->where('iddf','=', $id) ->delete();
                foreach ($row_habilidades as $habilidades)
                {   $new = new descrip_habilidades();
                    $new->iddf = $id;
                    $new->habilidad = trim($habilidades['habilidades']);
                    $new->nivel =  $habilidades['nivel_habilidades'];
                    $new->save();
                }
            }

            if($nrows_programa>0)
            {   
                DB::table('descrip_programa') ->where('iddf','=', $id) ->delete();
                foreach ($row_programa as $programa)
                {   $new = new descrip_programa();
                    $new->iddf = $id;
                    $new->programa = trim($programa['programa']);
                    $new->nivel =  $programa['nivel_programa'];
                    $new->save();
                }
            }

            if($nrows_idioma>0)
            {   
                DB::table('descrip_idioma') ->where('iddf','=', $id) ->delete();
                foreach ($row_idioma as $idioma)
                {   $new = new descrip_idioma();
                    $new->iddf = $id;
                    $new->idioma = trim($idioma['idioma']);
                    $new->nivel =  $idioma['nivel_idioma'];
                    $new->save();
                }
            }

            if(($nrows_decisiones_sin>0)||($nrows_decisiones_con>0))
            {   DB::table('descrip_decisiones') ->where('iddf','=', $id) ->delete();
                foreach ($row_decisiones as $decisiones)
                {   $new = new descrip_decisiones();
                    $new->iddf = $id;
                    $new->desicion = trim($decisiones['decisiones']);
                    $new->tipo	=  $decisiones['tipo_decisiones'];
                    $new->save();
                }
            }
            $result= DB::table('descriptivos as desc')
            ->select('desc.id AS id', 
            'desc.nombredesc AS nombredesc',
            'desc.status AS status',
            'jer.nombrejer AS nombrejer',
            'tipojer.nombretipojer AS nombretipojer' )
            ->leftjoin('jerarquias as jer','jer.id','=','desc.idjer')  
            ->leftjoin('tipojerarquia as tipojer','tipojer.id','=','jer.tipo')       
            ->orderBy('tipojer.nombretipojer')->orderBy('desc.nombredesc')        
            ->get();
 

            DB::commit();
            echo $result; 
            
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            echo 2;
        }
    }

    public function addtarea(Descriptivos $descriptivos)
    {
        $data= request()->except('_token');
        $ad_up= $data['ad_up'];
        $id_arearespon= $data['id_arearespon'];
        $iddf= $data['iddf'];
        $nombredesc= $data['namedf'];
        $idjer= $data['idjer'];
        $data_rows=json_decode($data['datajson'], true);
        $row_tareas=$data_rows['datos'];
        $txt_arearespon= $data['txt_arearespon'];
        $txt_kpi= $data['txt_kpi'];
        $nrows= $data['nrows'];
        $id_temp= date("Y-m-d H:i:s.u");

        if($id_arearespon==0)
        {    if($iddf==0)
            {
                $new = new Descriptivos();
                $new->nombredesc = $nombredesc;
                $new->idjer = $idjer;
                $new->id_temp = $id_temp;
                $new->status='true';
                $new->save();
                $id=0;
                $band=0;
                $query = DB::select("SELECT id FROM descriptivos WHERE id_temp='$id_temp'");
                foreach ($query as $res)
                {   $iddf= $res->id; 
                    $band=1;  
                }    
                if($band==1)
                {    
                    $new = new descrip_area_respon();
                    $new->iddf = $iddf;
                    $new->id_temp = $id_temp;
                    $new->area_respon = trim($txt_arearespon);
                    $new->kpi = $txt_kpi;
                    $new->cant_tarea=$nrows;
                    $new->save();
                    $band=2;
                }  
                if($band==2)
                {    $query = DB::select("SELECT id FROM descrip_area_respon WHERE id_temp='$id_temp'");
                    foreach ($query as $res)
                    {   $idarearespon= $res->id;
                        foreach ($row_tareas as $tareas)
                        {   $new = new descrip_area_respon_tareas();
                            $new->idarearespon = $idarearespon;
                            $new->tarea =trim($tareas['tareas']);
                            $new->criticidad =$tareas['criticidad'];
                            $new->save();
                        }
                    }
                }
            }
            else
            {
                $new = new descrip_area_respon();
                $new->iddf = $iddf;
                $new->id_temp = $id_temp;
                $new->area_respon = trim($txt_arearespon);
                $new->kpi = $txt_kpi;
                $new->cant_tarea=$nrows;
                $new->save();

                $query = DB::select("SELECT id FROM descrip_area_respon WHERE id_temp='$id_temp'");
                foreach ($query as $res)
                {   $idarearespon= $res->id;
                    foreach ($row_tareas as $tareas)
                    {   $new = new descrip_area_respon_tareas();
                        $new->idarearespon = $idarearespon;
                        $new->tarea = trim($tareas['tareas']);
                        $new->criticidad =$tareas['criticidad'];;
                        $new->save();
                    }
                }
            }
            $query = DB::select("SELECT respon.id as id_respon, respon.area_respon as area_respon, respon.kpi as kpi, respon.cant_tarea as cant_tarea
            FROM descrip_area_respon as respon 
            WHERE respon.iddf=$iddf");
            foreach ($query as $res)
            {   $id_respon= $res->id_respon;
                $area_respon= $res->area_respon;
                $kpi= $res->kpi;
                $cant_tarea= $res->cant_tarea;
            }
    
            $query_tareas = DB::select("SELECT tareas.tarea, tareas.criticidad
            FROM descrip_area_respon_tareas AS tareas 
            WHERE tareas.idarearespon=$id_respon");
    
            $salidaJson=array(
                "iddf"=>$iddf,
                "id_respon"=>$id_respon,
                "area_respon"=>$area_respon,
                "kpi"=>$kpi,
                "cant_tarea"=>$cant_tarea,
                "tareas"=>$query_tareas,
            );
        }
        else
        {   
            DB::table('descrip_area_respon')
            ->where('id','=', $id_arearespon)
            ->update([
            'id_temp' => $id_temp,
            'area_respon' => trim($txt_arearespon),
            'kpi' => trim($txt_kpi),
            'cant_tarea'=> $nrows,]);

            DB::table('descrip_area_respon_tareas') ->where('idarearespon','=', $id_arearespon) ->delete();
            $query = DB::select("SELECT iddf FROM descrip_area_respon WHERE id='$id_arearespon'");
            foreach ($query as $res)
            {   $iddf= $res->iddf;
                foreach ($row_tareas as $tareas)
                {   $new = new descrip_area_respon_tareas();
                    $new->idarearespon = $id_arearespon;
                    $new->tarea = trim($tareas['tareas']);
                    $new->criticidad =$tareas['criticidad'];;
                    $new->save();
                }
            }
            $query_respon = DB::select("SELECT respon.id as id_respon, respon.area_respon as area_respon, respon.kpi as kpi, respon.cant_tarea as cant_tarea
            FROM descrip_area_respon as respon 
            WHERE respon.iddf=$iddf");  
    
            $query_tareas= DB::select("SELECT tareas.idarearespon, tareas.tarea, tareas.criticidad
            FROM descrip_area_respon as respon            
            LEFT JOIN descrip_area_respon_tareas as tareas ON (respon.id=tareas.idarearespon)
            WHERE respon.iddf=$iddf
            ORDER BY tareas.id");
            
            $salidaJson=array(
                "respons"=>$query_respon,
                "tareas"=>$query_tareas,
            );
        }

       
        echo(json_encode($salidaJson));
    }


    public function edit(Descriptivos $descriptivos)
    {
        $data= request()->except('_token');
        $id= $data['id'];
        $query_datadf =DB::select("SELECT df.id AS id, 
        df.nombredesc AS nombredesc,
        df.cargojefe AS cargojefe,
        df.area_depto AS area_depto,
        df.idjer AS idjer,
        df.reportes AS reportes,
        df.proposito AS proposito,
        df.status AS estatus,
        df.relacion_interna AS relacion_interna,
        df.relacion_externa AS relacion_externa,
        df.riesgo_ofi_cam AS riesgo_ofi_cam,
        df.epp AS epp,
        df.nivel_academico AS nivel_academico,
        df.estatus_academico AS estatus_academico,
        df.estudio_requerido AS estudio_requerido,
        df.experiencia_norequiere AS experiencia_norequiere,
        df.experiencia_aux_asis AS experiencia_aux_asis,
        df.experiencia_ana_esp AS experiencia_ana_esp,
        df.experiencia_sup_coor AS experiencia_sup_coor,
        df.experiencia_jef_dep AS experiencia_jef_dep,
        df.experiencia_ge_dir AS experiencia_ge_dir,
        df.anos_experiencia AS anos_experiencia
        FROM descriptivos as df            
        WHERE df.id=$id");
        
        foreach ($query_datadf as $rsdatadf)
        {  $nombredesc = $rsdatadf->nombredesc;
           $cargojefe = $rsdatadf->cargojefe;
           $area_depto = $rsdatadf->area_depto;
           $idjer = $rsdatadf->idjer;
           $reportes = $rsdatadf->reportes;
           $proposito = $rsdatadf->proposito;
           $estatus = $rsdatadf->estatus;

           $relacion_interna = $rsdatadf->relacion_interna;
           $relacion_externa = $rsdatadf->relacion_externa;
           $riesgo_ofi_cam =1;

           if($rsdatadf->riesgo_ofi_cam=='Baja (100% Oficina / 0% Campo)'){    $riesgo_ofi_cam =1;}
           if($rsdatadf->riesgo_ofi_cam=='Media Baja (60% Oficina / 40% Campo)'){    $riesgo_ofi_cam =2;}
           if($rsdatadf->riesgo_ofi_cam=='Media (50% Oficina / 50% Campo)'){    $riesgo_ofi_cam =3;}
           if($rsdatadf->riesgo_ofi_cam=='Media Alta (40% Oficina / 60% Campo)'){    $riesgo_ofi_cam =4;}
           if($rsdatadf->riesgo_ofi_cam=='Alta (0% Oficina / 100% Campo)'){    $riesgo_ofi_cam =5;}
           $epp = $rsdatadf->epp;

           $nivel_academico = $rsdatadf->nivel_academico;
           $estatus_academico = $rsdatadf->estatus_academico;
           $estudio_requerido = $rsdatadf->estudio_requerido;
           $experiencia_norequiere = $rsdatadf->experiencia_norequiere;
           $experiencia_aux_asis = $rsdatadf->experiencia_aux_asis;
           $experiencia_ana_esp = $rsdatadf->experiencia_ana_esp;
           $experiencia_sup_coor = $rsdatadf->experiencia_sup_coor;
           $experiencia_jef_dep = $rsdatadf->experiencia_jef_dep;
           $experiencia_ge_dir = $rsdatadf->experiencia_ge_dir;
           $anos_experiencia = $rsdatadf->anos_experiencia;
        }

        $query_respon = DB::select("SELECT respon.id as id_respon, respon.area_respon as area_respon, respon.kpi as kpi, respon.cant_tarea as cant_tarea
        FROM descrip_area_respon as respon 
        WHERE respon.iddf=$id");  

        $query_tareas= DB::select("SELECT tareas.idarearespon, tareas.tarea, tareas.criticidad
        FROM descrip_area_respon as respon            
        LEFT JOIN descrip_area_respon_tareas as tareas ON (respon.id=tareas.idarearespon)
        WHERE respon.iddf=$id
        ORDER BY tareas.id");
        
        $query_habilidades= DB::select("SELECT habi.habilidad, habi.nivel
        FROM descrip_habilidades as habi
        WHERE habi.iddf=$id
        ORDER BY habi.id");
      
        $query_programa= DB::select("SELECT prog.programa, prog.nivel
        FROM descrip_programa as prog
        WHERE prog.iddf=$id
        ORDER BY prog.id");
      
        $query_idioma= DB::select("SELECT idio.idioma, idio.nivel
        FROM descrip_idioma as idio
        WHERE idio.iddf=$id
        ORDER BY idio.id");

        $query_decisiones= DB::select("SELECT decs.desicion, decs.tipo
        FROM descrip_decisiones as decs
        WHERE decs.iddf=$id
        ORDER BY decs.id");

        $query_comp= DB::table('reljercomp as rel')
        ->select(
        'rel.idcomp AS idcomp',
        'comp.nombre AS nomcomp',
        'rel.idtipocomp AS idtipocomp',
        'tipo.nombretipocompetencia AS nomtipocomp',
        'rel.esperado AS perfil')            
        ->leftjoin('competencias as comp','comp.id','=','rel.idcomp')
        ->leftjoin('tipocompetencia as tipo','tipo.id','=','rel.idtipocomp')
        ->where('rel.idjer','=', $idjer)
        ->orderBy('tipo.id')
        ->orderBy('comp.nombre')
        ->get();
        
        $salidaJson=array(
        //-- Información Genral
        "nombredesc" => $nombredesc,
        "idjer" => $idjer,
        "cargojefe" => $cargojefe,
        "area_depto" => $area_depto,
        "reportes" => $reportes,
        "estatus" => $estatus,
        //-- Proposito del cargo
        "proposito" => $proposito,
        //-- Principales responsabildiades del cargo
        "respons"=>$query_respon,
        "tareas"=>$query_tareas,
        //-- Relación de Interacción
        "relacion_interna"=>$relacion_interna,
        "relacion_externa"=>$relacion_externa,
        //-- Seguridad del Puesto
        "riesgo_ofi_cam"=>$riesgo_ofi_cam,
        "epp"=>$epp,
        //-- Requisitos del Puesto
        "nivel_academico" => $nivel_academico,
        "estatus_academico" => $estatus_academico,
        "estudio_requerido" => $estudio_requerido,
        "experiencia_norequiere" => $experiencia_norequiere,
        "experiencia_aux_asis" => $experiencia_aux_asis,
        "experiencia_ana_esp" => $experiencia_ana_esp,
        "experiencia_sup_coor" => $experiencia_sup_coor,
        "experiencia_jef_dep" => $experiencia_jef_dep,
        "experiencia_ge_dir" => $experiencia_ge_dir,
        "anos_experiencia" => $anos_experiencia,
        "programa"=>$query_programa,
        "idioma"=>$query_idioma,
        //-- Habilidades y otros conocimientos del Puesto
        "habilidades"=>$query_habilidades,
        //-- Competencias
        "comp"=>$query_comp,
        //-- Autoridad del Puesto
        "decisiones"=>$query_decisiones,
        );
        echo(json_encode($salidaJson)); 
    }
    
    public function edit_respon(Descriptivos $descriptivos)
    {
        $data= request()->except('_token');
        $id_respon= $data['id_respon'];
        $query = DB::select("SELECT respon.id as id_respon, respon.area_respon as area_respon, respon.kpi as kpi, respon.cant_tarea as cant_tarea
        FROM descrip_area_respon as respon 
        WHERE respon.id=$id_respon");
        $area_respon='-';
        foreach ($query as $res)
        {   
            $area_respon= $res->area_respon;
            $kpi= $res->kpi;
            $cant_tarea= $res->cant_tarea;
        }

        $query_tareas = DB::select("SELECT tareas.tarea, tareas.criticidad
        FROM descrip_area_respon_tareas AS tareas 
        WHERE tareas.idarearespon=$id_respon");

        $salidaJson=array(
            "area_respon"=>trim($area_respon),
            "kpi"=>$kpi,
            "cant_tarea"=>$cant_tarea,
            "tareas"=>$query_tareas,
        );
        echo(json_encode($salidaJson));
    }

    public function update(Request $request, Descriptivos $descriptivos)
    {
        $data= request()->except('_token');
        $id= $data['id'];
        $nombredesc= $data['namedf'];
        $idjer= $data['idjer'];
        $cargojefe= $data['cargojefe'];
        $area_depto= $data['nameareadf'];
        $reportes= $data['numreportedir'];
        $status= $data['status'];
        
        $proposito= $data['txtproposito'];
        
        $status= $data['status'];

            $txt_interno= $data['txt_interno'];
            $txt_externo= $data['txt_externo'];
            $sel_riesgo= $data['sel_riesgo'];
            $txt_epp= $data['txt_epp'];
            $opt_nivel_aca= $data['opt_nivel_aca'];
            $estatus_nivel_aca= $data['estatus_nivel_aca'];
            $txt_nivel_aca= $data['txt_nivel_aca'];
  
            $experiencia_norequiere= $data['experiencia_norequiere'];
            $experiencia_aux_asis= $data['experiencia_aux_asis'];
            $experiencia_ana_esp= $data['experiencia_ana_esp'];
            $experiencia_sup_coor= $data['experiencia_sup_coor'];
            $experiencia_jef_dep= $data['experiencia_jef_dep'];
            $experiencia_ge_dir= $data['experiencia_ge_dir'];
            $anos_experiencia= $data['anos_experiencia'];          

            $nrows_habilidad= $data['nrows_habilidad'];            
            if($nrows_habilidad>0)
            {   $data_rows_habilidades= json_decode($data['datajson_habilidades'], true);
                $row_habilidades= $data_rows_habilidades['datos_habilidades'];}

            
            $nrows_programa= $data['nrows_programa'];            
            if($nrows_programa>0)
            {   $data_rows_programa= json_decode($data['datajson_programa'], true);
                $row_programa= $data_rows_programa['datos_programa'];}

                
            $nrows_idioma= $data['nrows_idioma'];            
            if($nrows_idioma>0)
            {   $data_rows_idioma= json_decode($data['datajson_idioma'], true);
                $row_idioma= $data_rows_idioma['datos_idioma'];}


            $nrows_decisiones_sin= $data['nrows_decisiones_sin'];
            $nrows_decisiones_con= $data['nrows_decisiones_con'];

            if(($nrows_decisiones_sin>0)||($nrows_decisiones_con>0))
            {
                $data_rows_decisiones= json_decode($data['datajson_decisiones'], true);
                $row_decisiones= $data_rows_decisiones['datos_decisiones'];
            }
        
        DB::beginTransaction();
        try {
                        
            DB::table('descriptivos')
            ->where('id','=', $id)
            ->update([
            'nombredesc' => trim($nombredesc),
            'idjer' => $idjer,
            'cargojefe' => trim($cargojefe), 
            'area_depto' => trim($area_depto), 
            'reportes' => $reportes, 
            'proposito' => trim($proposito), 
            'status' => $status,
            'relacion_interna' =>  trim($txt_interno),
            'relacion_externa' =>  trim($txt_externo),
            'riesgo_ofi_cam' =>  $sel_riesgo,
            'epp' =>  trim($txt_epp),
            'nivel_academico' =>  $opt_nivel_aca,
            'estatus_academico' =>  $estatus_nivel_aca,
            'estudio_requerido' =>  $txt_nivel_aca,
            'experiencia_norequiere' =>  $experiencia_norequiere,
            'experiencia_aux_asis' =>  $experiencia_aux_asis,
            'experiencia_ana_esp' =>  $experiencia_ana_esp,
            'experiencia_sup_coor' =>  $experiencia_sup_coor,
            'experiencia_jef_dep' =>  $experiencia_jef_dep,
            'experiencia_ge_dir' =>  $experiencia_ge_dir,
            'anos_experiencia' => trim($anos_experiencia),]);

            DB::table('descrip_habilidades') ->where('iddf','=', $id) ->delete();
            if($nrows_habilidad>0)
            {   foreach ($row_habilidades as $habilidades)
                {   $new = new descrip_habilidades();
                    $new->iddf = $id;
                    $new->habilidad = trim($habilidades['habilidades']);
                    $new->nivel =  $habilidades['nivel_habilidades'];
                    $new->save();
                }
            }
            
            DB::table('descrip_programa') ->where('iddf','=', $id) ->delete();
            if($nrows_programa>0)
            {   foreach ($row_programa as $programa)
                {   $new = new descrip_programa();
                    $new->iddf = $id;
                    $new->programa = trim($programa['programa']);
                    $new->nivel =  $programa['nivel_programa'];
                    $new->save();
                }
            }
            
            DB::table('descrip_idioma') ->where('iddf','=', $id) ->delete();
            if($nrows_idioma>0)
            {   foreach ($row_idioma as $idioma)
                {   $new = new descrip_idioma();
                    $new->iddf = $id;
                    $new->idioma = trim($idioma['idioma']);
                    $new->nivel =  $idioma['nivel_idioma'];
                    $new->save();
                }
            }

            DB::table('descrip_decisiones') ->where('iddf','=', $id) ->delete();
            if(($nrows_decisiones_sin>0)||($nrows_decisiones_con>0))
            {   foreach ($row_decisiones as $decisiones)
                {   $new = new descrip_decisiones();
                    $new->iddf = $id;
                    $new->desicion = trim($decisiones['decisiones']);
                    $new->tipo	=  trim($decisiones['tipo_decisiones']);
                    $new->save();
                }
            }
             
            $result= DB::table('descriptivos as desc')
              ->select('desc.id AS id', 
              'desc.nombredesc AS nombredesc',
              'desc.status AS status',
              'jer.nombrejer AS nombrejer',
              'tipojer.nombretipojer AS nombretipojer' )
              ->leftjoin('jerarquias as jer','jer.id','=','desc.idjer')  
              ->leftjoin('tipojerarquia as tipojer','tipojer.id','=','jer.tipo')       
              ->orderBy('tipojer.nombretipojer')->orderBy('desc.nombredesc')        
              ->get(); 

              DB::commit();
              echo $result;
              
       
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            echo 2;
        }
    }

    public function destroy(Descriptivos $descriptivos)
    {
        $data= request()->except('_token');
        $id= $data['id'];
        DB::beginTransaction();
        try {
            descriptivos::where('id','=', $id)->delete();             
            descrip_decisiones::where('iddf','=', $id)->delete();   
            descrip_habilidades::where('iddf','=', $id)->delete();
            descrip_idioma::where('iddf','=', $id)->delete();
            descrip_programa::where('iddf','=', $id)->delete();                     

            descrip_area_respon_tareas::whereIn('idarearespon', DB::table('descrip_area_respon')->select('id')->where('iddf', '=', $id))->delete();
            descrip_area_respon::where('iddf','=', $id)->delete(); 

            DB::table('posiciones')
              ->where('iddf','=', $id)
              ->update(['iddf' => null]);
             
            $result= DB::table('descriptivos as desc')
              ->select('desc.id AS id', 
              'desc.nombredesc AS nombredesc',
              'desc.status AS status',
              'jer.nombrejer AS nombrejer',
              'tipojer.nombretipojer AS nombretipojer' )
              ->leftjoin('jerarquias as jer','jer.id','=','desc.idjer')  
              ->leftjoin('tipojerarquia as tipojer','tipojer.id','=','jer.tipo')       
              ->orderBy('tipojer.nombretipojer')->orderBy('desc.nombredesc')        
              ->get(); 

              DB::commit();
              echo $result;
              
       
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            echo 2;
        }
    }

    public function destroyres(Request $request) {
        $data= request()->except('_token');
        $id_repon= $data['id_repon'];
        $iddf= $data['iddf'];
        DB::beginTransaction();
        try {
            DB::table('descrip_area_respon_tareas')
              ->where('idarearespon','=', $id_repon)
              ->delete();
              
            DB::table('descrip_area_respon')
            ->where('id','=', $id_repon)
            ->delete();

            $query_respon = DB::select("SELECT respon.id as id_respon, respon.area_respon as area_respon, respon.kpi as kpi, respon.cant_tarea as cant_tarea
            FROM descrip_area_respon as respon 
            WHERE respon.iddf=$iddf");  

            $query_tareas= DB::select("SELECT tareas.idarearespon, tareas.tarea, tareas.criticidad
            FROM descrip_area_respon as respon            
            LEFT JOIN descrip_area_respon_tareas as tareas ON (respon.id=tareas.idarearespon)
            WHERE respon.iddf=$iddf
            ORDER BY tareas.id");
    
            $salidaJson=array(
                "resp"=>1,
                "respons"=>$query_respon,
                "tareas"=>$query_tareas,
            );

            DB::commit();

            } catch (\Exception $e) {
                DB::rollback();
                echo $e->getMessage();
                $salidaJson=array(
                    "resp"=>2,
                );
            }
            echo(json_encode($salidaJson));
    }
}