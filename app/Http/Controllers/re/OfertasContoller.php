<?php

namespace App\Http\Controllers\re;

use App\Http\Controllers\Controller;
use App\Models\re\Ofertas;
use App\Models\re\Curriculum;
use App\Models\re\Currexperiencialab;
use App\Models\re\Curreducacion;
use App\Models\re\Curri_val_referencias;
use App\Models\re\Curri_prueba_psico;
use App\Models\re\Curri_docattach;
use App\Models\re\Usr_part_curri_entrevistafun;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Mail\ContactanosMailable;
use Illuminate\Support\Facades\Mail;

use App\Models\re\Currcursos;
use App\Models\re\Currreferencia;
use App\Models\re\Usr_partici_cartaofl;
use App\Models\re\usr_participantes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OfertasContoller extends Controller
{
    public function index()
    {   $id_menu=15;
        $id_menu_sup=2;
        if (isset(Auth::user()->id)) 
        {   
            $data_ofertas= DB::select("SELECT sol.id, DATE (sol.created_at) AS fecha_sol, DATE (sol.hasta) AS fecha_tope, est.nameund AS unidad_economica,
            estsec.nameund AS seccion, sol.id_puesto, pos.descpue, sol.cantidad, sol.proceso, sol.contratados,
            sol.id_estatus, sta.estatus, sta.icono, usr.name
            FROM vacantes_solicitudes sol
            LEFT JOIN posiciones pos ON (sol.id_puesto=pos.id)
            LEFT JOIN estructuras est ON (est.id=sol.id_ue)
            LEFT JOIN estructuras estsec ON (estsec.id=sol.id_secc)
            LEFT JOIN vacantes_estatus sta ON (sta.id=sol.id_estatus)
            LEFT JOIN users usr ON (usr.id=sol.id_user_solicitante)
            WHERE sol.id_estatus  <=3");


            $data_areas_sub= DB::select("SELECT a.id as id_area, a.area, s.id as id_sub, s.subarea  FROM carreras_area  as a
            LEFT JOIN carreras_subarea s ON (a.id=s.id_area)
            order by a.area, s.subarea ");

            $data_vacstatus= DB::select("SELECT id,estatus,icono FROM vacantes_estatus WHERE id not in (3,5) order by id asc");
            $data_provincias= DB::select("SELECT id,provincia FROM dir_provincias order by provincia asc");
            $data_nacionalidades= DB::select("SELECT id,pais FROM usr_nacionalidad order by pais asc");
            $data_tipo_documento= DB::select("SELECT id,letra,tipodoc FROM usr_tipo_documento");
            $data_listdiscapacidad= DB::select("SELECT id,discapacidad FROM usr_listdiscapacidad");
            $data_nivel_educ= DB::select("SELECT id,nivel_educ FROM usr_nivel_educ");
            $data_estatus_educ= DB::select("SELECT id,estatuseduc FROM usr_estatus_educ");
            $data_rela_ref= DB::select("SELECT id,rela_ref FROM usr_tipo_rela_referencia");
            $data_tipo_permiso= DB::select("SELECT id,tipopermiso FROM usr_tipo_permiso_trab");
            $data_partici_etapas_proceso= DB::select("SELECT id, nometapa, orden FROM usr_partici_etapas_proceso order by orden asc");

            $data_users_entrevistas= DB::select("SELECT id,name,puesto,email FROM users where estatus=1 and aplicaentrevista=1");




            return view('re.ofertas')
            ->with('id_menu',$id_menu)
            ->with('id_menu_sup',$id_menu_sup)
            ->with('data_ofertas',$data_ofertas)
            ->with('data_vacstatus',$data_vacstatus)

            ->with('data_provincias',$data_provincias)
            ->with('data_nacionalidades',$data_nacionalidades)
            ->with('data_tipo_documento',$data_tipo_documento)
            ->with('data_listdiscapacidad',$data_listdiscapacidad)
            ->with('data_estatus_educ',$data_estatus_educ)
            ->with('data_rela_ref',$data_rela_ref)
            ->with('data_nivel_educ',$data_nivel_educ)
            ->with('data_tipo_permiso',$data_tipo_permiso)
            ->with('data_partici_etapas_proceso',$data_partici_etapas_proceso)
            ->with('data_areas_sub',$data_areas_sub)
            ->with('data_users_entrevistas',$data_users_entrevistas);
        }
        else{   return view('auth.login');}
    }
    
    // AGREGA ENTREVITAS
    public function fentrevist(Request $request)
    {   if (isset(Auth::user()->id)) 
        {  $data= request()->except('_token');
            $sel_entrevistador= $data['sel_entrevistador'];
            $id_curri= $data['id_curri']; 
            $id_participante= $data['id_participante'];
            $sel_fecha= $data['sel_fecha'];
            $sel_hora= $data['sel_hora'];
            $paso= $data['paso'];
            $data_users_entrevistas= DB::select("SELECT id,name as nombre ,puesto,email as mail FROM users where id=$sel_entrevistador");
            
            foreach ($data_users_entrevistas as $r)
                {   $id=$r->id;
                    $nombre=$r->nombre;
                    $puesto=$r->puesto;
                    $mail=$r->mail;
                }
 
                $new= new Usr_part_curri_entrevistafun();
                $new->id_curri= $id_curri;
                $new->id_participante= $id_participante;
                $new->nom_entrevistador= $nombre;
                $new->email= $mail;
                $new->puesto= $puesto;
                $new->fecha= $sel_fecha;
                $new->hora= $sel_hora;
                $new->save();

                $data_entrevistas= DB::select("SELECT id FROM usr_part_curri_entrevistafun where id_curri=$id_curri and id_participante=$id_participante");            
                foreach ($data_entrevistas as $r)
                {   $id_entrevista=$r->id;}

                
                DB::table('usr_participantes')
                ->where('id','=', $id_participante)
                ->update(['id_etapa' => $paso]);
    
                $query_part = DB::select("SELECT  partici_status.banges as banges
                FROM usr_participantes AS partici 
                LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
                WHERE partici.id=$id_participante");
    
                foreach ($query_part as $res)
                {   $banges=$res->banges;}





                $salidaJson=array(
                    "id"=>$id,
                    "nombre"=>$nombre,
                    "puesto"=>$puesto,
                    "mail"=>$mail,
                    "id_entrevista"=>$id_entrevista,
                    "banges"=>$banges,
                );
            echo(json_encode($salidaJson));    
        }
        else{   return view('auth.login');}  
    }

    
    public function destroyentre(Request $request)
    {   if (isset(Auth::user()->id)) 
        {  $data= request()->except('_token');
            $id_entrevista= $data['id_entrevista'];
            $id_participante= $data['id_participante'];
            DB::table('usr_part_curri_entrevistafun')
            ->where('id','=', $id_entrevista)
            ->delete();

            $cant=1;
            $data_cant_entrevistas= DB::select("SELECT count(*) as cant FROM usr_part_curri_entrevistafun where id=$id_entrevista");            
            foreach ($data_cant_entrevistas as $r)
            {   $cant=$r->cant; }

            if($cant==0)
            {                     
                DB::table('usr_participantes')
                ->where('id','=', $id_participante)
                ->update(['id_etapa' => 3]);
            }

            $banges='-';
            $query_part = DB::select("SELECT  partici_status.banges as banges
            FROM usr_participantes AS partici 
            LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
            WHERE partici.id=$id_participante");
    
            foreach ($query_part as $res)
            {   $banges=$res->banges;}   
                $salidaJson=array("banges"=>$banges,"cant"=>$cant,);
            echo(json_encode($salidaJson));
  
        }
        else{   return view('auth.login');}  
    }

    public function notientre(Request $request)
    {   if (isset(Auth::user()->id)) 
        {   $email_user_cc=Auth::user()->email;
            $data= request()->except('_token');
            $id_entrevista= $data['id_entrevista'];
            $data_entrevistas= DB::select("SELECT entre.nom_entrevistador, entre.email, entre.fecha, entre.hora, 
            po.descpue, curri.prinombre, curri.segnombre, curri.priapellido, curri.segapellido, curri.cv_doc, 
            est.nameund, df.proposito 
            FROM usr_part_curri_entrevistafun AS entre 
            LEFT JOIN usr_participantes AS parti ON (parti.id= entre.id_participante) 
            LEFT JOIN posiciones AS po ON (po.id=parti.id_puesto) 
            LEFT JOIN usr_part_curriculum AS curri ON (curri.id=entre.id_curri) 
            LEFT JOIN estructuras AS est ON (est.id=po.idue) 
            LEFT JOIN descriptivos AS df ON(df.id=po.iddf) 
            WHERE entre.id=$id_entrevista");
           foreach ($data_entrevistas as $r)
            {   $fecha=explode("-", $r->fecha);
                $nombre=$r->prinombre;
                if($r->segnombre!=null){    $nombre.=" ".$r->segnombre;}
                $nombre.=" ".$r->priapellido;
                if($r->segapellido!=null){  $nombre.=" ".$r->segapellido;}

                $nom_entrevistador=$r->nom_entrevistador;
                $email=$r->email;
                $fecha=$fecha[2].'-'.$fecha[1].'-'.$fecha[0];
                $hora=$r->hora;
                $descpue=$r->descpue;
                $cv_doc=$r->cv_doc;
                $nameund=$r->nameund;
                $proposito=$r->proposito;
            }                   
  
                $salidaJson=array(
                    "nom_entrevistador"=>$nom_entrevistador,
                    "email"=>$email,
                    "fecha"=>$fecha,
                    "hora"=>$hora,
                    "nombre"=>$nombre,
                    "descpue"=>$descpue,
                    "cv_doc"=>$cv_doc,
                    "nameund"=>$nameund,
                    "proposito"=>$proposito,
                );
          
                Mail::to($email)->bcc($email_user_cc)->send(new ContactanosMailable($salidaJson));
            /*    if (Mail::failures()) {
                    $msg = 'Se ha presentado un problemas al momento de enviar la notificación';
                    $envio=0;
                } else { */
                    $msg = 'La notificación se envió con éxito';
                    $envio=1;
                    DB::table('usr_part_curri_entrevistafun')
                    ->where('id','=', $id_entrevista)
                    ->update(['notificado' => $envio]);                   
               // }

                $salidaJson=array(
                    "msn"=>$msg,
                    "envio"=>$envio,
                );
            echo(json_encode($salidaJson)); 
        }
        else
        {   return view('auth.login');}
    }

    public function store(Request $request)
    {
        if (isset(Auth::user()->id)) 
        {   $data= request()->except('_token');
            $id_ofl= $data['id_ofl'];
            $prinombre= $data['prinombre'];
            $segnombre= $data['segnombre'];
            $priapellido= $data['priapellido'];
            $segapellido= $data['segapellido'];
            $f_nacimiento= $data['f_nacimiento'];
            $genero= $data['genero'];
            $sel_provincias= $data['sel_provincias'];
            $sel_distrito= $data['sel_distrito'];
            $sel_corregimiento= $data['sel_corregimiento'];
            $dir= $data['dir'];
            $nacio_extran= $data['nacio_extran'];
            $sel_nacionalidad= $data['sel_nacionalidad'];
            $sel_tipodoc= $data['sel_tipodoc'];
            $num_docip= $data['num_docip'];
            $f_vencimiento_docip= $data['f_vencimiento_docip'];
            $telefono= $data['telefono'];
            $mail= $data['mail'];
            $sel_discapacidad= $data['sel_discapacidad'];
            $explique_disc= $data['explique_disc'];
            $cv_doc=$data['cv_doc'];
            if($data['permiso_trab']!='Seleccionar'){$permiso_trab=$data['permiso_trab'];}else{$permiso_trab='-';}
            $f_vence_permiso_trab=$data['f_vence_permiso_trab'];
            $permiso_doc=$data['permiso_doc'];
            $estado_registro=0;

            $data_exp=json_decode($data['datajson_exp'], true);
            $experiencias=$data_exp['datos_exp'];

            $data_edu=json_decode($data['datajson_edu'], true);
            $educaciones=$data_edu['datos_edu'];

            $data_cur=json_decode($data['datajson_cur'], true);
            $cursos=$data_cur['datos_cur'];

            $data_ref=json_decode($data['datajson_ref'], true);
            $referencias=$data_ref['datos_ref'];

            $newnamecompleto='-';
            if($cv_doc!='-')
            {   define("fileName", '');
                $fileName= '';
                $path="cv/";
                if(isset($_FILES["cv_doc"]["type"])){
                    $target_dir= $path;
                    $carpeta=$target_dir;
                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0777, true);
                    }
                    $extension= explode('.',$_FILES['cv_doc']['name']);
                    $num= count($extension)-1;
                    $newname=fileName.time().'.'.$extension[$num];
                    $newnamecompleto= $target_dir.$newname;
                    $target_file= $carpeta . basename($_FILES["cv_doc"]["name"]);
                    $uploadOkcv= 1;
                    $uploadOkper= 1;
                    $mensaje= '';
                    $imageFileType= pathinfo($target_file,PATHINFO_EXTENSION);
                    if (file_exists($target_file)) {
                        $mensaje= ' La hoja de vida ya existe.';
                        $uploadOkcv= 0;
                    }
                    if($imageFileType != "pdf" && $imageFileType != "doc" && $imageFileType != "png" && $imageFileType != "jpg" && $imageFileType != "jpeg" ) {
                        $mensaje= $mensaje.' Solamente se admiten archivos .pdf, .doc, .png, .jpg, .jpeg.';
                        $uploadOkcv = 0;
                    }
                    if ($uploadOkcv == 0) {
                        $mensaje= ' La hoja de vida no fue adjuntada.'.$mensaje;
                    } else {
                        if (move_uploaded_file($_FILES["cv_doc"]["tmp_name"], $newnamecompleto)) {
                            $mensaje= ' La hoja de vida se adjuntó con éxito.';            
                        } else {
                            $mensaje= ' Hubo un error subiendo el archivo de la hoja de vida.';
                            $uploadOkcv= 0;
                        }
                    }
                }
            }
            $newnamecompleto_permi='-';            
            if($uploadOkcv==1)   
            {
                if($permiso_doc!='-')
                {
                    define("fileNamep", '');
                    $fileNamep= '';
                    $path="permisos/";
                    if(isset($_FILES["permiso_doc"]["type"])){
                        $target_dir= $path;
                        $carpeta=$target_dir;
                        if (!file_exists($carpeta)) {
                            mkdir($carpeta, 0777, true);
                        }
                        $extension= explode('.',$_FILES['permiso_doc']['name']);
                        $num= count($extension)-1;
                        $newname=fileNamep.time().'.'.$extension[$num];
                        $newnamecompleto_permi= $target_dir.$newname;
                        $target_file= $carpeta . basename($_FILES["permiso_doc"]["name"]);
                        $mensaje= '';
                        
                        $imageFileType= pathinfo($target_file,PATHINFO_EXTENSION);
                        if (file_exists($target_file)) {
                            $mensaje= ' El archivo del permiso de trabajo ya existe.';
                            $uploadOkper= 0;
                        }
                        if($imageFileType != "pdf" && $imageFileType != "doc" && $imageFileType != "png" && $imageFileType != "jpg" && $imageFileType != "jpeg" ) {
                            $mensaje= $mensaje.' Solamente se admiten archivos .pdf, .doc, .png, .jpg, .jpeg.';
                            $uploadOkper = 0;
                        }
                        if ($uploadOkper == 0) {
                            $mensaje= ' El archivo del permiso de trabajo no fue adjuntado.'.$mensaje;
                        } else {
                            if (move_uploaded_file($_FILES["permiso_doc"]["tmp_name"], $newnamecompleto_permi)) {
                                $mensaje= ' El archivo del permiso de trabajo se adjuntó con éxito.'; 
                            } else {
                                $mensaje= ' Hubo un error subiendo el archivo del permiso de trabajo.';
                            }
                        }
                    }
                }
            }
            if($uploadOkcv==1 && $uploadOkper==1)
            {
                $id_part_curriculum_alt= date("Y-m-d H:i:s.u");

                $new= new Curriculum();
                $new->id_part_curriculum_alt= $id_part_curriculum_alt;
                $new->prinombre= $prinombre;
                $new->segnombre= $segnombre;
                $new->priapellido= $priapellido;
                $new->segapellido= $segapellido;
                $new->genero= $genero;
                $new->nacio_extran= $nacio_extran;
                $new->f_nacimiento= $f_nacimiento;

                $new->id_nacionalidad= $sel_nacionalidad;
                $new->id_tipo_doc_letra= $sel_tipodoc;
                $new->num_doc= $num_docip;
                $new->f_vencimiento= $f_vencimiento_docip;
                $new->tel= $telefono;
                $new->email= $mail;
                $new->id_provincia= $sel_provincias;
                $new->id_distrito= $sel_distrito;
                $new->id_corregimiento= $sel_corregimiento;
                $new->direccion= $dir;
                $new->discapacidad= $sel_discapacidad;
                $new->detalle_descapacidad= $explique_disc;
                $new->cv_doc= $newnamecompleto;     

                $new->permiso_trab= $permiso_trab;
                $new->f_vence_permiso_trab	=$f_vence_permiso_trab;
                $new->permiso_doc= $newnamecompleto_permi;
                $new->estado_registro= $estado_registro;

                $new->save();

                foreach ($experiencias as $experiencia)
                {  
                    
                    $hasta_exp='1900-01-01';
                    if($experiencia['hasta_exp']!='Hasta la fecha'){    $hasta_exp=$experiencia['hasta_exp'];}
                    $new= new Currexperiencialab();
                    $new->id_part_curriculum_alt= $id_part_curriculum_alt;
                    $new->empresa= $experiencia['empresa_exp'];
                    $new->puesto= $experiencia['puesto_exp'];
                    $new->area= $experiencia['area_exp'];
                    $new->desde=  $experiencia['desde_exp'];
                    $new->hasta=  $hasta_exp;    
                    $new->save();
                }

                foreach ($educaciones as $educacion)
                {   $new= new Curreducacion();
                    $hasta_edu='1900-01-01';
                    if($educacion['hasta_edu']!='-'&&$educacion['hasta_edu']!='Hasta la fecha'){   $hasta_exp=$educacion['hasta_edu'];}
                    $new->id_part_curriculum_alt= $id_part_curriculum_alt;
                    $new->nivel_educ= $educacion['nivel_edu'];
                    $new->estatuseduc= $educacion['estatus_edu'];
                    $new->entidad= $educacion['entidad_edu'];
                    $new->titulo= $educacion['titulo_edu'];
                    $new->desde=  $educacion['desde_edu'];
                    $new->hasta=  $hasta_edu;    
                    $new->save();
                }

                foreach ($cursos as $curso)
                {   $new= new Currcursos();
                    $hasta_cur='1900-01-01';
                    if($curso['hasta_cur']!='Hasta la fecha'){   $hasta_exp=$curso['hasta_cur'];}
                    $new->id_part_curriculum_alt= $id_part_curriculum_alt;
                    $new->entidad= $curso['entidad_cur'];
                    $new->nombre= $curso['curso_cur'];
                    $new->desde=  $curso['desde_cur'];
                    $new->hasta=  $hasta_cur;    
                    $new->save();
                }

                foreach ($referencias as $referencia)
                {   $new= new Currreferencia();
                    $new->id_part_curriculum_alt= $id_part_curriculum_alt;
                    $new->nombre= $referencia['nombre_ref'];
                    $new->cargo= $referencia['cargo_ref'];
                    $new->tipo_rela_referencia=  $referencia['rela_ref'];
                    $new->contacto=  $referencia['contact_ref'];    
                    $new->save();
                }

                $query = DB::select("SELECT id
                FROM usr_part_curriculum AS curri 
                WHERE curri.id_part_curriculum_alt='$id_part_curriculum_alt'");
                foreach ($query as $r)
                {   $id_part_curriculum=$r->id;}

                $query = DB::select("SELECT id, id_puesto, id_jer
                FROM vacantes_solicitudes AS solvac 
                WHERE solvac.id=$id_ofl");
                foreach ($query as $r)
                {   $id_puesto=$r->id_puesto;
                    $id_jer=$r->id_jer;
                    $id_etapa=1;
                }
                
                $new= new usr_participantes();
                $new->id_part_curriculum= $id_part_curriculum;
                $new->id_part_curriculum_alt= $id_part_curriculum_alt;
                $new->id_ofl= $id_ofl;
                $new->id_jer= $id_jer;
                $new->id_puesto= $id_puesto;
                $new->id_etapa=  $id_etapa;
                $new->save();
                
                $query_part = DB::select("SELECT partici.id as id_participante, curri.prinombre, curri.priapellido, curri.tel, curri.email, partici_status.banges, curri.num_doc, curri.id as id_curri
                FROM vacantes_solicitudes as sol 
                LEFT JOIN usr_participantes AS partici ON (partici.id_ofl=sol.id)
                LEFT JOIN usr_part_curriculum AS curri ON (curri.id=partici.id_part_curriculum)
                LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
                WHERE sol.id=$id_ofl");

                $querycantproceso = DB::select("SELECT count(*)  as cantproceso FROM usr_participantes                 
                WHERE id_etapa not in (5,6) and id_ofl=$id_ofl");
                foreach ($querycantproceso as $res)
                {   $cantproceso=$res->cantproceso;}

                DB::table('vacantes_solicitudes')
                ->where('id','=', $id_ofl)
                ->update(['proceso' => $cantproceso]);

                $salidaJson=array(
                    "conteos"=>$cantproceso,
                    "participantes"=>$query_part,
                    "uploadOk"=>1,
                    "mensaje"=>$mensaje,
                );
            }
            else
            {
                if($uploadOkcv==1)
                {   unlink($newnamecompleto);}
                    $salidaJson=array(
                    "conteos"=>0,
                    "participantes"=>0,
                    "uploadOk"=>0,
                    "mensaje"=>$mensaje,
                );
            }
            echo(json_encode($salidaJson));
        }
        else{   return view('auth.login');}
    }

    public function show(Ofertas $ofertas)
    {   if (isset(Auth::user()->id)) 
        {   $data= request()->except('_token');
            $id_ofl= $data['id_ofl'];
            $query= DB::select("SELECT 
            sol.id, 
            DATE (sol.created_at) AS fecha_sol, 
            DATE (sol.hasta) AS fecha_tope, 
            est.nameund AS unidad_economica,
            estsec.nameund AS seccion, 
            mot.motivo,
            sol.autorizacion, 
            sol.comentarios,
            gen.genero,
            sol.rango_edad, 
            pos.descpue, 
            sol.cantidad, 
            sol.id_estatus, 
            sol.id_user_solicitante,
            usr.name as usrname,
            pos.aprobado,
            (select count(0) from colab_pl_rh HCR where (HCR.COD_PUESTO_RH= pos.codigo and TRIM(HCR.COD_UE)=TRIM(est.codigo))) AS countreal,
            ceco.planillera,
            ceco.centrocosto
            FROM vacantes_solicitudes sol
            LEFT JOIN posiciones pos ON (sol.id_puesto=pos.id)
            LEFT JOIN estructuras est ON (est.id=sol.id_ue)
            LEFT JOIN estructuras estsec ON (estsec.id=sol.id_secc)
            LEFT JOIN vacantes_motivo mot ON (mot.id=sol.id_motivo)
            LEFT JOIN vacantes_genero gen ON (gen.letra=sol.genero)
            LEFT JOIN users usr ON (usr.id=sol.id_user_solicitante)
            LEFT JOIN colab_planillera_ceco ceco ON (ceco.cod_cia_costo=sol.cod_ceco)
            WHERE sol.id=$id_ofl");

            foreach ($query as $r)
            {  
                
                $fsol=explode("-", $r->fecha_sol);
                $fcie=explode("-", $r->fecha_tope);

                $id=$r->id;
                $fecha_sol= $fsol[2].'-'.$fsol[1].'-'.$fsol[0];
                $fecha_tope= $fcie[2].'-'.$fcie[1].'-'.$fcie[0];
                $unidad_economica= $r->unidad_economica;
                $seccion= $r->seccion;
                $motivo= $r->motivo;
                $autorizacion= $r->autorizacion;
                $comentarios= $r->comentarios;
                $genero= $r->genero;
                $rango_edad= $r->rango_edad;
                $descpue= $r->descpue;
                $cantidad= $r->cantidad;
                $id_estatus= $r->id_estatus;
                $usrname= $r->usrname;
                $aprobado= $r->aprobado;
                $countreal =$r->countreal;
                $planillera =$r->planillera;
                $ceco =$r->centrocosto;
            }

            $salidaJson=array(
                "id"=>$id,
                "fecha_sol"=>$fecha_sol,
                "fecha_tope"=> $fecha_tope,
                "unidad_economica"=> $unidad_economica,
                "seccion"=> $seccion,
                "descpue"=> $descpue,
                "cantidad"=> $cantidad,
                "genero"=> $genero,
                "rango_edad"=> $rango_edad,
                "motivo"=> $motivo,
                "autorizacion"=> $autorizacion,
                "comentarios"=> $comentarios,
                "id_estatus"=> $id_estatus,
                "usrname"=> $usrname,
                "aprobado" => $aprobado,
                "countreal" => $countreal,
                "planillera"=>$planillera,
                "ceco"=>$ceco,
                );

            echo(json_encode($salidaJson));

            }
            else{   return view('auth.login');}
    }

    public function finddistcor(Ofertas $ofertas)
    {   
        $data= request()->except('_token');
        $opt_find= $data['opt_find'];
        $sel= $data['sel'];  
        if($opt_find=='distrito')      
        {   $data= DB::select("SELECT id, distrito as lugar FROM dir_distritos where id_provincia=$sel order by distrito asc");}
        if($opt_find=='corregimiento')
        {   $data= DB::select("SELECT id, corregimiento as lugar FROM dir_corregimientos where id_distrito=$sel order by corregimiento asc");}

        
        echo(json_encode($data));
    }

    public function edit(Ofertas $ofertas)
    {   $data= request()->except('_token');
        $id_ofl= $data['id_ofl'];
        $query = DB::select("SELECT partici.id as id_participante, curri.prinombre, curri.priapellido, curri.tel, curri.email, partici_status.nometapa, partici_status.banges, curri.num_doc, curri.id as id_curri
        FROM vacantes_solicitudes as sol 
        LEFT JOIN usr_participantes AS partici ON (partici.id_ofl=sol.id)
        LEFT JOIN usr_part_curriculum AS curri ON (curri.id=partici.id_part_curriculum)
        LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
        WHERE sol.id=$id_ofl
        ");
        echo(json_encode($query));
    }

    public function update(Request $request, Ofertas $ofertas)
    {
        if (isset(Auth::user()->id)) 
        {   $data= request()->except('_token');
            $id_ofl= $data['id_ofl'];
            $id_estatus= $data['id_estatus'];   

            if($id_estatus==4)
            {   $txt_area_observacion= $data['txt_area_observacion'];
                DB::table('vacantes_solicitudes')
                ->where('id','=', $id_ofl)
                ->update(['id_estatus' => $id_estatus,'observacion' => $txt_area_observacion,]);

                $result= DB::table('vacantes_solicitudes as sol')                    
                ->select('sol.id','sol.created_at AS fecha_sol','sol.hasta AS fecha_tope','est.nameund AS unidad_economica',
                'estsec.nameund AS seccion','pos.descpue','sol.cantidad','sol.proceso','sol.contratados',
                'sol.id_estatus','sta.estatus','sta.icono')

                ->leftjoin('posiciones as pos','sol.id_puesto','=','pos.id')
                ->leftjoin('estructuras as est','est.id','=','sol.id_ue')
                ->leftjoin('estructuras as estsec','estsec.id','=','sol.id_secc')
                ->leftjoin('vacantes_estatus as sta','sta.id','=','sol.id_estatus')

                ->where('sol.id_estatus', '<=', 3)
                ->get();
                echo $result;
            }
            if($id_estatus==2)
            {   DB::table('vacantes_solicitudes')
                ->where('id','=', $id_ofl)
                ->update(['id_estatus' => $id_estatus]);

                $result= DB::table('vacantes_estatus as vacstas')                    
                ->select('vacstas.estatus','vacstas.icono')
                ->where('vacstas.id', '=', $id_estatus)
                ->get();
                echo $result;
            }
        }
        else{   return view('auth.login');}
    }

    public function destroy(Ofertas $ofertas)
    {
        $data= request()->except('_token');
        $id_ofl= $data['id_ofl'];
        $idparti= $data['idparti'];
        
        DB::table('usr_participantes')
        ->where('id','=', $idparti)
        ->delete();

        $querycantproceso = DB::select("SELECT count(*)  as cantproceso FROM usr_participantes                 
        WHERE id_etapa not in (5,6) and id_ofl=$id_ofl");
        foreach ($querycantproceso as $res)
        {   $cantproceso=$res->cantproceso;}

        DB::table('vacantes_solicitudes')
        ->where('id','=', $id_ofl)
        ->update(['proceso' => $cantproceso]);



        $querycantproceso = DB::select("SELECT count(*)  as cantproceso FROM usr_participantes                 
        WHERE id_etapa not in (5,6) and id_ofl=$id_ofl");
        foreach ($querycantproceso as $res)
        {   $cantproceso=$res->cantproceso;}

        $salidaJson=array(
            "conteos"=>$cantproceso);

            echo(json_encode($salidaJson));
    }

    public function findidcurri(Ofertas $ofertas)
    {   $data= request()->except('_token');
        $id_curri= $data['id_curri'];
        $id_participante= $data['id_participante'];
        $data_parti= DB::select("SELECT curri.prinombre, curri.segnombre, curri.priapellido, curri.segapellido, curri.num_doc, curri.f_nacimiento,
        curri.tel, curri.email, prov.provincia, ditri.distrito, corr.corregimiento, curri.direccion,
        nacio.nacionalidad, curri.cv_doc,
        curri.nacio_extran, curri.permiso_trab, curri.f_vence_permiso_trab, curri.permiso_doc         
            FROM usr_part_curriculum curri
            LEFT JOIN dir_provincias prov ON (prov.id = curri.id_provincia)
            LEFT JOIN dir_distritos ditri ON (ditri.id = curri.id_distrito)
            LEFT JOIN dir_corregimientos corr ON (corr.id = curri.id_corregimiento)
            LEFT JOIN usr_nacionalidad nacio ON (nacio.id = curri.id_nacionalidad)            
            WHERE curri.id=$id_curri");
            $querypruebaspsico = DB::select("SELECT id, nom_prueba FROM pruebaspsicometricas");

            
            $data_prueba_psico= DB::select("SELECT pru_psico.prueba as id_prueba, pru_psico.f_prueba ,pru_psico.resultado as txtresp_prueba, resppru_psico.id as resp_prueba, partici.id_etapa as paso,  docattach.nomdoc as rp_docattach 
            FROM usr_part_curri_pru_psico pru_psico
            LEFT JOIN pruebaspsicoresp resppru_psico ON (resppru_psico.id = pru_psico.resultado) 
            LEFT JOIN usr_participantes partici ON (partici.id = pru_psico.id_participante) 
            LEFT JOIN usr_part_curri_docattach docattach ON (docattach.id_participante = pru_psico.id_participante) 
            WHERE pru_psico.id_participante=$id_participante");

            $paso=1;
            foreach ($data_prueba_psico as $res)
            {  $paso=$res->paso;}

            $ref_val='N';
            $data_valida_ref='-';
            $aplica_entrevistas='N';
            $data_entrevistas='-';
            
            if($paso>1)
            {   $data_valida_ref= DB::select("SELECT valref.entidad, valref.nombre, valref.puesto, valref.contacto, valref.comentarios
                FROM usr_participantes as partic
                LEFT JOIN usr_part_curri_validacionref as valref ON (valref.id_participante = partic.id) 
                WHERE partic.id=$id_participante");
                foreach ($data_valida_ref as $res)
                {  if($res->entidad!=null){$ref_val='S';}}




                $data_entrevistas= DB::select("SELECT entre.id as id_entrevista, entre.nom_entrevistador, entre.email, entre.puesto, entre.fecha, entre.hora, entre.notificado
                FROM usr_part_curri_entrevistafun as entre
               
                WHERE entre.id_curri=$id_curri and entre.id_participante=$id_participante");
                foreach ($data_entrevistas as $res)
                {  if($res->id_entrevista!=null){$aplica_entrevistas='S';}}

            }

            $salidaJson=array(
                "participante"=>$data_parti,
                "pruebaspsico"=>$querypruebaspsico, 
                "paso"=>$paso,
                "prueba_psico"=>$data_prueba_psico,  
                "ref_val"=>$ref_val,
                "valida_refres"=>$data_valida_ref,   
                "aplica_entrevistas"=>$aplica_entrevistas,
                "entrevistas"=>$data_entrevistas, 
                );
            echo(json_encode($salidaJson));            
    }

    public function fin_respsico(Ofertas $ofertas)
    {   $data= request()->except('_token');
        $sel_prueba= $data['sel_prueba'];
        $queryresppruebaspsico ='';
        $querypruebaspsico = DB::select("SELECT resp_pruebas FROM pruebaspsicometricas where id=$sel_prueba");
        foreach ($querypruebaspsico as $res)
        {   $resp_pruebas=$res->resp_pruebas;}
        if($resp_pruebas=='s')
        { $resp=1;
            $queryresppruebaspsico = DB::select("SELECT id, respuesta FROM pruebaspsicoresp where id_prueba=$sel_prueba");
        }
        else
        { $resp=0;}

        $salidaJson=array(
            "resp"=>$resp,
            "resppruebaspsico"=>$queryresppruebaspsico,                
            );
        echo(json_encode($salidaJson));            
    }

   

    public function sigpaso(Ofertas $ofertas)
    {
        $data= request()->except('_token');

        $paso= $data['paso']; 
        $id_curri= $data['id_curri'];
		$id_participante= $data['id_participante']; 
        if($paso<=2)
        {   $indica_down_cp= $data['indica_down_cp']; 
            $ref_sino= $data['ref_sino'];
            if($ref_sino=='S')
            {
                $data_val_ref= json_decode($data['datajson_val_ref'], true);
                $data_val_referencias=$data_val_ref['datos_val_ref'];
            }
            

            $sel_evaluacion_aplicada= $data['sel_evaluacion_aplicada'];
            $f_envio_prueba= $data['f_envio_prueba'];
            $pruebapsico_resultado= $data['pruebapsico_resultado'];	
            $filerecord= $data['filerecord'];
            $uploadOk= 1;
            if($indica_down_cp==0)
            {
                if($filerecord!='-')
                {   define("fileName", '');
                    $fileName= '';
                    $id_doc=1;
                    $path="rp/";
                    if(isset($_FILES["filerecord"]["type"])){
                        $target_dir= $path;
                        $carpeta=$target_dir;
                        if (!file_exists($carpeta)) {
                            mkdir($carpeta, 0777, true);
                        }
                        $extension= explode('.',$_FILES['filerecord']['name']);
                        $num= count($extension)-1;
                        $newname=fileName.time().'.'.$extension[$num];
                        $newnamecompleto= $target_dir.$newname;
                        $target_file= $carpeta . basename($_FILES["filerecord"]["name"]);
                        $mensaje= '';
                        $imageFileType= pathinfo($target_file,PATHINFO_EXTENSION);
                        if (file_exists($target_file)) {
                            $mensaje= ' El recod policivo ya existe.';
                            $uploadOk= 0;
                        }
                        if($imageFileType != "pdf" && $imageFileType != "doc" && $imageFileType != "png" && $imageFileType != "jpg" && $imageFileType != "jpeg" ) {
                            $mensaje= $mensaje.' Solamente se admiten archivos .pdf, .doc, .png, .jpg, .jpeg.';
                            $uploadOk = 0;
                        }
                        if ($uploadOk == 0) {
                            $mensaje= ' El recod policivo no fue adjuntado.'.$mensaje;
                        } else {
                            if (move_uploaded_file($_FILES["filerecord"]["tmp_name"], $newnamecompleto)) {
                                $mensaje= ' El recod policivo se adjuntó con éxito.';            
                            } else {
                                $mensaje= ' Hubo un error subiendo el archivo del recod policivo.';
                                $uploadOk= 0;
                            }
                        }
                    }
                }
            }
            if($uploadOk==1)
            {   DB::table('usr_part_curri_validacionref')->where('id_curri','=', $id_curri)->where('id_participante','=', $id_participante)->delete();
                if($ref_sino=='S')
                {   foreach ($data_val_referencias as $val_referencias)
                    {   $new= new Curri_val_referencias();
                        $new->id_curri= $id_curri;
                        $new->entidad= $val_referencias['entidad_val_ref'];
                        $new->nombre= $val_referencias['nombre_val_ref'];
                        $new->puesto= $val_referencias['puesto_val_ref'];
                        $new->contacto=  $val_referencias['contacto_val_ref'];
                        $new->comentarios=  $val_referencias['comentarios_val_ref'];   
                        $new->id_participante=  $id_participante;   
                        $new->save();
                    }
                }

                DB::table('usr_part_curri_pru_psico')->where('id_curri','=', $id_curri)->where('id_participante','=', $id_participante)->delete();
                $new= new Curri_prueba_psico();
                $new->id_curri= $id_curri;
                $new->prueba= $sel_evaluacion_aplicada;
                $new->f_prueba= $f_envio_prueba;
                $new->resultado= $pruebapsico_resultado;
                $new->id_participante=  $id_participante;   
                $new->save();

                if($indica_down_cp==0)
                {   DB::table('usr_part_curri_docattach')->where('id_curri','=', $id_curri)->where('id_participante','=', $id_participante)->delete();
                    $new= new Curri_docattach();
                    $new->id_curri= $id_curri;
                    $new->iddoc= $id_doc;
                    $new->nomdoc= $newnamecompleto;
                    $new->id_participante=  $id_participante;
                    $new->save();
                }
                
                DB::table('usr_participantes')
                ->where('id','=', $id_participante)
                ->update(['id_etapa' => 3]);

                $query_part = DB::select("SELECT  partici_status.banges as banges
                FROM usr_participantes AS partici 
                LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
                WHERE partici.id=$id_participante");

                foreach ($query_part as $res)
                {   $banges=$res->banges;}
                if($indica_down_cp==0)
                {   $salidaJson=array("newnamecompleto"=>$newnamecompleto,"banges"=>$banges,);}
                else
                {   $salidaJson=array("banges"=>$banges,);}
                echo(json_encode($salidaJson));
            }
        }
        if($paso==3)
        {
            DB::table('usr_participantes')
            ->where('id','=', $id_participante)
            ->update(['id_etapa' => 4]);

            $query_part = DB::select("SELECT  partici_status.banges as banges
                FROM usr_participantes AS partici 
                LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
                WHERE partici.id=$id_participante");
                foreach ($query_part as $res)
                {   $banges=$res->banges;}
                $salidaJson=array("banges"=>$banges,);
                echo(json_encode($salidaJson));

        }
    }

    public function deldoc(Ofertas $ofertas)
    {   
        $data= request()->except('_token');
        $optdoc= $data['optdoc']; 
        $id_curri= $data['id_curri'];
		$id_participante= $data['id_participante']; 
        

        if($optdoc=='rp')
        {   $id_doc=1;}
        $query = DB::select("SELECT  nomdoc
        FROM usr_part_curri_docattach AS docatch 
        WHERE id_participante=$id_participante and id_curri=$id_curri and iddoc= $id_doc");

        foreach ($query as $res)
        {   $nomdoc=$res->nomdoc;
            unlink($nomdoc);
            DB::table('usr_part_curri_docattach')->where('iddoc','=', $id_doc)->where('id_curri','=', $id_curri)->where('id_participante','=', $id_participante)->delete();
            DB::table('usr_participantes')->where('id','=', $id_participante)->update(['id_etapa' => 2]);
        }
        $query_part = DB::select("SELECT  partici_status.banges as banges
            FROM usr_participantes AS partici 
            LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
            WHERE partici.id=$id_participante");

            foreach ($query_part as $res)
            {   $banges=$res->banges;}
            
            $salidaJson=array("banges"=>$banges,);

            echo(json_encode($salidaJson));

    }
    

public function pdf(Ofertas $ofertas){
    //return view('re.PDFcartaoferta');
    
    if (isset(Auth::user()->id)) 
    {    $data= request()->except('_token');
        
        setlocale(LC_ALL, 'es_ES');

        $id_participante= $data['id_participante']; 
        $salario= $data['salario']; 
        $finicio= $data['finicio']; 
        $fterminacion= $data['fterminacion']; 
        $sel_tipo_contrato= $data['sel_tipo_contrato']; 
        $sel_tipo_salario= $data['sel_tipo_salario']; 

        $fecha_actual = \Carbon\Carbon::now()->isoFormat(' D \d\e MMMM \d\e\l Y');
        $fecha_larga_inicio = \Carbon\Carbon::parse($finicio)->isoFormat('dddd D \d\e MMMM \d\e\l Y');



        $new= new Usr_partici_cartaofl();
        $new->id_participante= $id_participante;
        $new->salario= $salario;
        $new->finicio= $finicio;
        $new->fterminacion= $fterminacion;
        $new->sel_tipo_contrato= $sel_tipo_contrato;
        $new->sel_tipo_salario= $sel_tipo_salario;
        $new->save();


       /* $data_cartas= DB::select("SELECT id, salario, finicio, fterminacion, sel_tipo_contrato, sel_tipo_salario
        FROM usr_partici_cartaofl         
        WHERE id_participante  =$id_participante order by created_at desc");

        echo json_encode($data_cartas);*/
        $data_ofertas= DB::select("SELECT pla.nombre_memb, pla.apartado, pla.email, pla.tel,
        curri.prinombre, curri.segnombre, curri.priapellido, curri.segapellido, curri.genero,
        pos.descpue
        FROM usr_participantes parti
        LEFT JOIN vacantes_solicitudes ofl ON (ofl.id=parti.id_ofl)
        LEFT JOIN colab_planillera_membretes pla ON (pla.id_planillera=ofl.cod_planillera)
        LEFT JOIN usr_part_curriculum curri ON (curri.id=parti.id_part_curriculum)
        LEFT JOIN posiciones pos ON (pos.id=parti.id_puesto)
        WHERE parti.id  =$id_participante");
        


        //$fecha_actual = strtotime("now");
        //$fecha_actual = date('l jS \of F Y');
        //$miFecha=now();
       // $fecha_actual =$now->format('l d \d\e F \d\e\l Y');

        foreach ($data_ofertas as $r)
        {   $segnombre=" ";$segapellido=" ";
            $estimado='Estimado';
            $sr='Señor';
            if($r->genero=='F')
            {   $estimado='Estimada';
                $sr='Señora';}
            

            $nombre_memb= $r->nombre_memb;
            $apartado= $r->apartado;
            $email= $r->email;
            $tel= $r->tel;

            $prinombre= $r->prinombre;
            if($r->segnombre!=null)
            {   $segnombre= $r->segnombre;}
            
            $priapellido= $r->priapellido;
            if($r->segapellido!=null)
            {   $segapellido= $r->segapellido;}
           
            $genero= $r->genero;

            $descpue= $r->descpue;
            
        }                  
        
        




            $salida=array(
                "nombre_memb"=>$nombre_memb,
                "apartado"=>$apartado,
                "email"=>$email,                
                "tel"=>$tel,
                "fecha_actual"=>$fecha_actual,
                "sr"=>$sr,
                "estimado"=>$estimado,

                "descpue"=>$descpue,
                "prinombre"=>$prinombre,
                "segnombre"=>$segnombre,
                "priapellido"=>$priapellido,
                "segapellido"=>$segapellido,
                "salario"=>$salario,
                "finicio"=>$finicio,
                "fterminacion"=>$fterminacion,
                "firmante"=>Auth::user()->name,
                "puestofirmante"=>Auth::user()->puesto,
                "emailfirmante"=>Auth::user()->email,
                "sel_tipo_contrato"=>$sel_tipo_contrato,
                "fecha_larga_inicio"=>$fecha_larga_inicio,
            );

        echo json_encode($salida);
            
        //$datas = Ofertas::all();
       // $pdf= PDF::loadView('re.PDFcartaoferta', compact('data_ofertas'));
        //echo($salida);
        //return $pdf->download('file.pdf');

        //return view('re.PDFcartaoferta')->with('data_ofertas',$data_ofertas);
    }
    else{   return view('auth.login');}
}

}