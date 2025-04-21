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
use App\Models\re\Usr_parti_dependientes;
use Barryvdh\DomPDF\Facade\Pdf;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Mail\ContactanosMailable;
use Illuminate\Support\Facades\Mail;

use App\Models\re\Currcursos;
use App\Models\re\Currreferencia;
use App\Models\re\Usr_parti_contactos;
use App\Models\re\Usr_partici_cartaofl;
use App\Models\re\usr_participantes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OfertasController extends Controller
{
    public function index()
    {   $id_menu=15;
        $id_menu_sup=2;
        if (isset(Auth::user()->id)) 
        {   
            $data_ofertas= DB::select("SELECT sol.id, DATE (sol.created_at) AS fecha_sol, DATE (sol.hasta) AS fecha_tope, est.nameund AS unidad_economica,
            estsec.nameund AS seccion, sol.id_puesto, pos.descpue, sol.cantidad, sol.proceso, sol.contratados,
            sol.id_estatus, sta.estatus, sta.icono, usr.name,
            (select count(1) from usr_participantes where id_ofl=sol.id and id_etapa in (1,2)) as incial,
            (select count(1) from usr_participantes where id_ofl=sol.id and id_etapa=3) as funcional,
            (select count(1) from usr_participantes where id_ofl=sol.id and id_etapa=4) as ofertalaboral,
            (select count(1) from usr_participantes where id_ofl=sol.id and id_etapa=5) as documentacion,
            (select count(1) from usr_participantes where id_ofl=sol.id and id_etapa=6) as firma,
            (select count(1) from usr_participantes where id_ofl=sol.id and id_etapa=7) as contratado
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
            $data_tipo_parentesco= DB::select("SELECT id,parentesco FROM usr_tipo_parentesco ");

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
            ->with('data_users_entrevistas',$data_users_entrevistas)
            ->with('data_tipo_parentesco',$data_tipo_parentesco);
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

    // AGREGA DEPENDIENTES
    public function dependientes(Request $request)
    {   if (isset(Auth::user()->id)) 
        {
            $data= request()->except('_token');
            $nombre_dependiente= $data['nombre_dependiente'];
            $sel_parentesco= $data['sel_parentesco'];
            $fech_nac_dependiente= $data['fech_nac_dependiente'];
            $id_curri= $data['id_curri'];

            $query_parentesco= DB::select("SELECT parentesco FROM usr_tipo_parentesco where id=$sel_parentesco");            
            foreach ($query_parentesco as $r)
            {   $parentesco=$r->parentesco; }

            $new= new Usr_parti_dependientes();
            $new->id_part_curriculum= $id_curri;
            $new->nombre= $nombre_dependiente;
            $new->parentesco= $parentesco;
            $new->f_nacimiento= $fech_nac_dependiente;
            $new->save();

            $query_parentesco= DB::select("SELECT id,id_part_curriculum,nombre,parentesco,f_nacimiento  FROM usr_part_dependientes where id_part_curriculum=$id_curri");            

            echo(json_encode($query_parentesco));    
        }
        else{   return view('auth.login');}
    }

    // AGREGA CONTACTOS DE URGENCIA
    public function contactos(Request $request)
    {   if (isset(Auth::user()->id)) 
            {
                $data= request()->except('_token');
                $nombre_contacto= $data['nombre_contacto'];
                $tel_contacto= $data['tel_contacto'];
                $id_curri= $data['id_curri'];
    
    
                $new= new Usr_parti_contactos();
                $new->id_part_curriculum= $id_curri;
                $new->nombre= $nombre_contacto;
                $new->contacto= $tel_contacto;
                $new->save();
    
                $query_contactos= DB::select("SELECT id,nombre,contacto  FROM usr_part_contactos where id_part_curriculum=$id_curri");            
    
                echo(json_encode($query_contactos));    
            }
            else{   return view('auth.login');}
    }
    
    // DESCARTE DE CANDIDATO
    public function descarte(Request $request)
    {
        if (isset(Auth::user()->id)) 
        {   $data= request()->except('_token');
            $id_curri=$data['id_curri']; 
            $id_participante= $data['id_participante']; 
            $encuenta= $data['encuenta']; 
            $txt_area_descarte= $data['txt_area_descarte']; 
            
            DB::table('usr_participantes')->where('id','=', $id_participante ) ->update(['id_etapa' => 8,'motivo_descarte'=>$txt_area_descarte]);
            $query_part = DB::select("SELECT  partici_status.banges as banges, partici.id_ofl id_ofl
            FROM usr_participantes AS partici 
            LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
            WHERE partici.id_part_curriculum=$id_curri");
            foreach ($query_part as $res)
            {   $banges=$res->banges;
                $id_ofl=$res->id_ofl;}      

            if($encuenta==1)
            {   DB::table('usr_part_curriculum')->where('id','=', $id_curri ) ->update(['estado_registro' => 2,'motivo_descarte'=>$txt_area_descarte]);}

            $cant_inicial=0; $cant_funcional=0; $cant_ofertalaboral=0; $cant_documentacion=0; $cant_firma=0; $cant_contratado=0; $cant_proceso=0;
            $query = DB::select("SELECT id_etapa, count(1)  as cant FROM usr_participantes                 
            WHERE id_ofl=$id_ofl group by id_etapa");
            foreach ($query as $res)
            {   
                if($res->id_etapa==1 || $res->id_etapa==2)
                {   $cant_inicial= $cant_inicial + $res->cant;}
                if($res->id_etapa==3)
                {   $cant_funcional= $cant_funcional + $res->cant;}
                if($res->id_etapa==4)
                {   $cant_ofertalaboral= $cant_ofertalaboral + $res->cant;}
                if($res->id_etapa==5)
                {   $cant_documentacion= $cant_documentacion + $res->cant;}
                if($res->id_etapa==6)
                {   $cant_firma= $cant_firma + $res->cant;}
                if($res->id_etapa==7)
                {   $cant_contratado= $cant_contratado + $res->cant;}
            }
            // cantidad en proceso NO cuenta los contratador y eliminados
            $cant_proceso= $cant_inicial + $cant_funcional + $cant_ofertalaboral + $cant_documentacion + $cant_firma;            
            DB::table('vacantes_solicitudes')->where('id','=', $id_ofl)->update(['proceso' => $cant_proceso, 'contratados' => $cant_contratado ]);

            $salidaJson=array(
                "banges"=>$banges,
                "cant_proceso"=>$cant_proceso,
                "cant_inicial"=>$cant_inicial,
                "cant_funcional"=>$cant_funcional,
                "cant_ofertalaboral"=>$cant_ofertalaboral,
                "cant_documentacion"=>$cant_documentacion,
                "cant_firma"=>$cant_firma,
                "cant_contratado"=>$cant_contratado,
                "id_ofl"=>$id_ofl,
            );

            echo(json_encode($salidaJson));
        }
        else{   return view('auth.login');}        
    }

    // AGREGA PRUEBAS PSICOLÓGICAS
    public function pruebaspsico(Request $request)
    {   
        if (isset(Auth::user()->id)) 
        {  $data= request()->except('_token');
           $id_curri=$data['id_curri']; 
           $id_participante= $data['id_participante']; 
           $sel_evaluacion_aplicada= $data['sel_evaluacion_aplicada'];
           $pruebapsico_resultado= $data['pruebapsico_resultado'];
           $f_envio_prueba= $data['f_envio_prueba'];
           $new= new Curri_prueba_psico();
           $new->id_curri= $id_curri;
           $new->prueba= $sel_evaluacion_aplicada;
           $new->resultado= $pruebapsico_resultado;
           $new->f_prueba= $f_envio_prueba;
           $new->id_participante= $id_participante;   
           $new->save();
           
            $data_prueba_psico= DB::select("SELECT pru_psico.id as id_prueba, pruebas.nom_prueba, pru_psico.f_prueba, pru_psico.resultado, resppruebas.respuesta
            FROM usr_part_curri_pru_psico pru_psico
            LEFT JOIN pruebaspsicoresp resppru_psico ON (resppru_psico.id = pru_psico.resultado) 
            LEFT JOIN pruebaspsicometricas pruebas ON (pruebas.id = pru_psico.prueba) 
            LEFT JOIN pruebaspsicoresp resppruebas ON (resppruebas.id = pru_psico.resultado) 

            WHERE pru_psico.id_participante=$id_participante");

            $salidaJson=array(  "prueba_psico"=>$data_prueba_psico,  );

            echo(json_encode($salidaJson));    
        }
        else{   return view('auth.login');}
    }

    //  ELIMINA REGISTRO DE PRUEBA PSICOMETRICA
    public function destroypruebapsico(Request $request)
    {   if (isset(Auth::user()->id)) 
        {   $data= request()->except('_token');
            $id_curri= $data['id_curri'];
            $id_prueba= $data['id_prueba'];
            $resp=0;
            $paso=2;
            $banges="";
            
            $query_parentesco= DB::select("SELECT count(id) conteo FROM usr_part_curri_pru_psico where id_curri=$id_curri");  
            foreach ($query_parentesco as $r)
            {   $resp=$r->conteo;}

                if($resp>=1)
                { DB::table('usr_part_curri_pru_psico')->where('id_curri','=', $id_curri)->where('id','=', $id_prueba)->delete();}
                
                if($resp==1)
                {  DB::table('usr_participantes')->where('id_part_curriculum','=', $id_curri ) ->update(['id_etapa' => $paso]);
                    $query_part = DB::select("SELECT  partici_status.banges as banges
                    FROM usr_participantes AS partici 
                    LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
                    WHERE partici.id_part_curriculum=$id_curri");
                    foreach ($query_part as $res)
                    {   $banges=$res->banges;}               
                 }
                 $salidaJson=array("banges"=>$banges,
                 "paso"=>$paso,
                 "resp"=>$resp,);
                 echo(json_encode($salidaJson));
            }
            else{   return view('auth.login');}
    }   

    //  ELIMINA CONTACTOS
    public function destroycontacto(Request $request)
    {   if (isset(Auth::user()->id)) 
        {   $data= request()->except('_token');
            $id_curri= $data['id_curri'];
            $id_contacto= $data['id_contacto'];
            $resp=0;
            $paso=5;
            $i=0;
            $query_parentesco= DB::select("SELECT id  FROM usr_part_contactos where id_part_curriculum=$id_curri and id=$id_contacto");  
            foreach ($query_parentesco as $r)
            {   $resp=1;
                $i++; }
            if($resp==1)
            { DB::table('usr_part_contactos')->where('id_part_curriculum','=', $id_curri)->where('id','=', $id_contacto)->delete();}
            if($i==1)
            {  DB::table('usr_participantes')->where('id_part_curriculum','=', $id_curri ) ->update(['id_etapa' => $paso]);
                $query_part = DB::select("SELECT  partici_status.banges as banges
                FROM usr_participantes AS partici 
                LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
                WHERE partici.id_part_curriculum=$id_curri");
                foreach ($query_part as $res)
                {   $banges=$res->banges;}               
             }
             $salidaJson=array("banges"=>$banges,
             "paso"=>$paso,
             "resp"=>$resp,);
             echo(json_encode($salidaJson));
        }
        else{   return view('auth.login');}
    }

    //  ELIMINA DEPENDIENTES
    public function destroydepend(Request $request)
    {   if (isset(Auth::user()->id)) 
        {   $data= request()->except('_token');
            $id_curri= $data['id_curri'];
            $id_depend= $data['id_depend'];
            $resp=0;
            $query_parentesco= DB::select("SELECT id,id_part_curriculum,nombre,parentesco,f_nacimiento  FROM usr_part_dependientes where id_part_curriculum=$id_curri and id=$id_depend");  
            foreach ($query_parentesco as $r)
            {   $resp=1; }
            if($resp==1)
            { DB::table('usr_part_dependientes')->where('id_part_curriculum','=', $id_curri)->where('id','=', $id_depend)->delete();}
            echo $resp;
            
        }
        else{   return view('auth.login');}
    }
    //  ELIMINA ENTREVISTA
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

    // ENVÍA NOTIFICACIÓN DE ENTREVISTA POR CORREO
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

    // AGREGA CANDIDATOS
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
            $sel_estadocivil = $data['sel_estadocivil'];
            $num_ss= $data['num_ss'];
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
                $new->estadocivil= $sel_estadocivil;
                $new->num_ss= $num_ss;
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

               /*$querycantproceso = DB::select("SELECT count(*)  as cantproceso FROM usr_participantes                 
                WHERE id_etapa not in (7,8) and id_ofl=$id_ofl");
                foreach ($querycantproceso as $res)
                {   $cantproceso=$res->cantproceso;}

                $querycontratados = DB::select("SELECT count(*)  as cantcontratados FROM usr_participantes                 
                WHERE id_etapa=7 and id_ofl=$id_ofl");
                foreach ($querycontratados as $res)
                {   $cantcontratados=$res->cantcontratados;}*/
        
                $cant_inicial=0; $cant_funcional=0; $cant_ofertalaboral=0; $cant_documentacion=0; $cant_firma=0; $cant_contratado=0; $cant_proceso=0;
                $query = DB::select("SELECT id_etapa, count(1) as cant FROM usr_participantes WHERE id_ofl=$id_ofl group by id_etapa");
                foreach ($query as $res)
                {   
                    if($res->id_etapa==1 || $res->id_etapa==2)
                    {   $cant_inicial= $cant_inicial + $res->cant;}
                    if($res->id_etapa==3)
                    {   $cant_funcional= $cant_funcional + $res->cant;}
                    if($res->id_etapa==4)
                    {   $cant_ofertalaboral= $cant_ofertalaboral + $res->cant;}
                    if($res->id_etapa==5)
                    {   $cant_documentacion= $cant_documentacion + $res->cant;}
                    if($res->id_etapa==6)
                    {   $cant_firma= $cant_firma + $res->cant;}
                    if($res->id_etapa==7)
                    {   $cant_contratado= $cant_contratado + $res->cant;}
                }
                // cantidad en proceso NO cuenta los contratador y eliminados
                $cant_proceso= $cant_inicial + $cant_funcional + $cant_ofertalaboral + $cant_documentacion + $cant_firma;            
                DB::table('vacantes_solicitudes')->where('id','=', $id_ofl)->update(['proceso' => $cant_proceso, 'contratados' => $cant_contratado ]);
                
                $salidaJson=array(
                    "cant_proceso"=>$cant_proceso,
                    "cant_inicial"=>$cant_inicial,
                    "cant_funcional"=>$cant_funcional,
                    "cant_ofertalaboral"=>$cant_ofertalaboral,
                    "cant_documentacion"=>$cant_documentacion,
                    "cant_firma"=>$cant_firma,
                    "cant_contratado"=>$cant_contratado,
                    "id_ofl"=>$id_ofl,
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
                    "conteoscontratados"=>0,
                    "participantes"=>0,
                    "uploadOk"=>0,
                    "mensaje"=>$mensaje,
                );
            }
            echo(json_encode($salidaJson));
        }
        else{   return view('auth.login');}
    }

    // MUESTRA DETALLE DE LA OFERTA LABORAL EN ESTATUS INICIAL
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
            ceco.PAGADORA,
            ceco.nom_cia
            FROM vacantes_solicitudes sol
            LEFT JOIN posiciones pos ON (sol.id_puesto=pos.id)
            LEFT JOIN estructuras est ON (est.id=sol.id_ue)
            LEFT JOIN estructuras estsec ON (estsec.id=sol.id_secc)
            LEFT JOIN vacantes_motivo mot ON (mot.id=sol.id_motivo)
            LEFT JOIN vacantes_genero gen ON (gen.letra=sol.genero)
            LEFT JOIN users usr ON (usr.id=sol.id_user_solicitante)
            LEFT JOIN colab_planillera_ceco ceco ON (ceco.cod_cia=sol.cod_cia)
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
                $PAGADORA =$r->PAGADORA;
                $ceco =$r->nom_cia;
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
                "PAGADORA"=>$PAGADORA,
                "ceco"=>$ceco,
                );

            echo(json_encode($salidaJson));

            }
            else{   return view('auth.login');}
    }

    // BUSCAR DITRITO Y CORREGIMIENTO
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
        $query = DB::select("SELECT partici.id as id_participante, curri.prinombre, curri.segnombre, curri.priapellido, curri.segapellido, curri.tel, curri.email, partici_status.nometapa, partici_status.banges, curri.num_doc, curri.id as id_curri
        FROM vacantes_solicitudes as sol 
        LEFT JOIN usr_participantes AS partici ON (partici.id_ofl=sol.id)
        LEFT JOIN usr_part_curriculum AS curri ON (curri.id=partici.id_part_curriculum)
        LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
        WHERE sol.id=$id_ofl
        ");
        echo(json_encode($query));
    }

    // ACTUALIZA EL ESTATUS DE LAS VACANTES
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

    // ELIMINA PARTICIPANTES
    public function destroy(Ofertas $ofertas)
    {
        $data= request()->except('_token');
        $id_ofl= $data['id_ofl'];
        $idparti= $data['idparti'];
        
        DB::table('usr_participantes')
        ->where('id','=', $idparti)
        ->whereNotIn('id_etapa',[6,7])           
        ->delete();

       /* $querycantproceso = DB::select("SELECT count(*)  as cantproceso FROM usr_participantes                 
        WHERE id_etapa not in (7,8) and id_ofl=$id_ofl");
        foreach ($querycantproceso as $res)
        {   $cantproceso=$res->cantproceso;}

        $querycontratados = DB::select("SELECT count(*)  as cantcontratados FROM usr_participantes                 
        WHERE id_etapa =7 and id_ofl=$id_ofl");
        foreach ($querycontratados as $res)
        {   $cantcontratados=$res->cantcontratados;}*/

        $cant_inicial=0; $cant_funcional=0; $cant_ofertalaboral=0; $cant_documentacion=0; $cant_firma=0; $cant_contratado=0; $cant_proceso=0;
        $query = DB::select("SELECT id_etapa, count(1)  as cant FROM usr_participantes                 
        WHERE id_ofl=$id_ofl group by id_etapa");
        foreach ($query as $res)
        {   
            if($res->id_etapa==1 || $res->id_etapa==2)
            {   $cant_inicial= $cant_inicial + $res->cant;}
            if($res->id_etapa==3)
            {   $cant_funcional= $cant_funcional + $res->cant;}
            if($res->id_etapa==4)
            {   $cant_ofertalaboral= $cant_ofertalaboral + $res->cant;}
            if($res->id_etapa==5)
            {   $cant_documentacion= $cant_documentacion + $res->cant;}
            if($res->id_etapa==6)
            {   $cant_firma= $cant_firma + $res->cant;}
            if($res->id_etapa==7)
            {   $cant_contratado= $cant_contratado + $res->cant;}
        }

        // cantidad en proceso NO cuenta los contratador y eliminados
        $cant_proceso= $cant_inicial + $cant_funcional + $cant_ofertalaboral + $cant_documentacion + $cant_firma;            
        DB::table('vacantes_solicitudes')->where('id','=', $id_ofl)->update(['proceso' => $cant_proceso, 'contratados' => $cant_contratado ]);
        


        //DB::table('vacantes_solicitudes') ->where('id','=', $id_ofl)->update(['proceso' => $cantproceso,'contratados' => $cantcontratados ]);
        $eliminado=0;
        $querycantproceso = DB::select("SELECT id FROM usr_participantes WHERE id= $idparti");
        foreach ($querycantproceso as $res)
        {   $eliminado=1;}

        $salidaJson=array(
            "cant_proceso"=>$cant_proceso,
            "cant_inicial"=>$cant_inicial,
            "cant_funcional"=>$cant_funcional,
            "cant_ofertalaboral"=>$cant_ofertalaboral,
            "cant_documentacion"=>$cant_documentacion,
            "cant_firma"=>$cant_firma,
            "cant_contratado"=>$cant_contratado,
            "id_ofl"=>$id_ofl,
            "eliminado"=>$eliminado,);

            echo(json_encode($salidaJson));
    }

    // BUSCA DETALLE DEL PARTICIPANTE PARA EL FLOJO DE CONTRATACIÓN
    public function findidcurri(Ofertas $ofertas)
    {   $data= request()->except('_token');
        $id_curri= $data['id_curri'];
        $id_participante= $data['id_participante'];
        
        $data_participante= DB::select("SELECT parti.motivo_descarte, parti.id_etapa as paso,curri.estado_registro, ofl.finicio FROM usr_participantes parti 
        left join usr_part_curriculum curri on (curri.id=parti.id_part_curriculum)
        left join usr_partici_cartaofl ofl on (ofl.id_participante=parti.id)
        WHERE parti.id=$id_participante");
        foreach ($data_participante as $res)
        {  $paso=$res->paso;
            $motivo_descarte=$res->motivo_descarte;
            $estado_registro=$res->estado_registro;
            $contrato_finicio=$res->finicio;
        }

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

            
            $data_prueba_psico= DB::select("SELECT pru_psico.id as id_prueba, pruebas.nom_prueba, pru_psico.f_prueba ,pru_psico.resultado,resppruebas.respuesta, resppru_psico.id as resp_prueba
            FROM usr_part_curri_pru_psico pru_psico
            LEFT JOIN pruebaspsicoresp resppru_psico ON (resppru_psico.id = pru_psico.resultado) 
            LEFT JOIN pruebaspsicometricas pruebas ON (pruebas.id = pru_psico.prueba) 
            LEFT JOIN pruebaspsicoresp resppruebas ON (resppruebas.id = pru_psico.resultado) 
            LEFT JOIN usr_participantes partici ON (partici.id = pru_psico.id_participante) 

            WHERE pru_psico.id_participante=$id_participante");

            

            $ref_val='N';
            $data_valida_ref='-';
            $aplica_entrevistas='N';
            $data_entrevistas='-';
            $data_cartas='-';
            $data_docatach='-';
            $data_dependientes='-';
            $data_contactos='-';
            $data_valida_sipe='-';
            $data_info_contrato='-';
            
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

                $data_cartas= DB::select("SELECT id, salario, finicio, fterminacion, sel_tipo_contrato, sel_tipo_salario, estado,aprobacion_ofl, aceptacion_ofl, descargada_por, faceptacion
                FROM usr_partici_cartaofl         
                WHERE id_participante=$id_participante order by created_at desc");

                $data_docatach= DB::select("SELECT id, iddoc, nomdoc
                FROM usr_part_curri_docattach         
                WHERE id_participante=$id_participante and id_curri=$id_curri");

                $data_dependientes= DB::select("SELECT id, nombre, parentesco, f_nacimiento
                FROM usr_part_dependientes         
                WHERE id_part_curriculum=$id_curri");

                $data_contactos= DB::select("SELECT id, nombre, contacto
                FROM usr_part_contactos         
                WHERE id_part_curriculum=$id_curri");

                $data_valida_sipe= DB::select("SELECT partic.valida_sipe as valida_sipe, id_etapa, partic.marcacion
                FROM usr_participantes as partic         
                WHERE partic.id=$id_participante");

                
                $data_info_contrato= DB::select("SELECT 
                sol.COD_PAGADORA, ceco.PAGADORA, sol.cod_cia, ceco.nom_cia,  est.nameund, parti.id_puesto, pos.descpue,
                cartofl.salario, cartofl.finicio, cartofl.fterminacion, cartofl.sel_tipo_contrato, cartofl.sel_tipo_salario, cartofl.estado
                FROM usr_participantes parti
                LEFT JOIN vacantes_solicitudes sol ON (sol.id=parti.id_ofl)
                LEFT JOIN posiciones pos ON (pos.id=parti.id_puesto)
                LEFT JOIN estructuras est on (est.id= pos.idue)
                LEFT JOIN colab_planillera_ceco ceco ON (ceco.COD_PAGADORA=sol.COD_PAGADORA and sol.cod_cia=ceco.COD_CIA)
                LEFT JOIN usr_partici_cartaofl cartofl on (cartofl.id_participante=parti.id )
                WHERE parti.id=$id_participante");
            }

            $salidaJson=array(
                "participante"=>$data_parti,
                "pruebaspsico"=>$querypruebaspsico, 
                "paso"=>$paso,
                "motivo_descarte"=>$motivo_descarte,
                "estado_registro"=>$estado_registro,
                "contrato_finicio"=>$contrato_finicio,
                "prueba_psico"=>$data_prueba_psico,  
                "ref_val"=>$ref_val,
                "valida_refres"=>$data_valida_ref,   
                "aplica_entrevistas"=>$aplica_entrevistas,
                "entrevistas"=>$data_entrevistas, 
                "cartas"=>$data_cartas,
                "docatach"=>$data_docatach,
                "dependientes"=>$data_dependientes,
                "contactos"=>$data_contactos,
                "valida_sipe"=>$data_valida_sipe,
                "info_contrato"=>$data_info_contrato, );

            echo(json_encode($salidaJson));            
    }

    // VALIDACIÓN DE SIPE
    public function valsipe(Ofertas $ofertas)
    {
        $data= request()->except('_token');
        $val= $data['val']; 
        $paso=5;
		$id_participante= $data['id_participante']; 
        DB::table('usr_participantes')->where('id','=', $id_participante)->update(['valida_sipe' => $val]);
        if($val==0)
        {   DB::table('usr_participantes')->where('id','=', $$id_participante ) ->update(['id_etapa' => $paso]);}
    }
    // VALIDACIÓN MARCACION
    public function valmarcacion(Ofertas $ofertas)
    {
        $data= request()->except('_token');
        $val= $data['val']; 
        $paso=5;
		$id_participante= $data['id_participante']; 
        DB::table('usr_participantes')->where('id','=', $id_participante)->update(['marcacion' => $val]);
        if($val==0)
        {   DB::table('usr_participantes')->where('id','=', $$id_participante ) ->update(['id_etapa' => $paso]);}
    }
    

    // BUSCA LAS LISTADO DE LOS RESULTADOS DE LAS PRUEBAS PSICOLÓGICAS
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

   
    // mUESTRA LOS DATOS DE CADA PASO EN EL FLUJO DE CONTRACIÓN
    public function sigpaso(Ofertas $ofertas)
    {
        $data= request()->except('_token');
        $paso= $data['paso']; 
        $id_curri= $data['id_curri'];
		$id_participante= $data['id_participante']; 
        if($paso<=2)
        {   //$indica_down_cp= $data['indica_down_cp']; 
            $ref_sino= $data['ref_sino'];
            if($ref_sino=='S')
            {
                $data_val_ref= json_decode($data['datajson_val_ref'], true);
                $data_val_referencias=$data_val_ref['datos_val_ref'];
            }
            

                DB::table('usr_part_curri_validacionref')->where('id_curri','=', $id_curri)->where('id_participante','=', $id_participante)->delete();
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

                


               /* if($indica_down_cp==0)
                {   DB::table('usr_part_curri_docattach')->where('id_curri','=', $id_curri)->where('id_participante','=', $id_participante)->where('iddoc','=', 1)->delete();
                    $new= new Curri_docattach();
                    $new->id_curri= $id_curri;
                    $new->iddoc= $id_doc;
                    $new->nomdoc= $newnamecompleto;
                    $new->id_participante=  $id_participante;
                    $new->save();
                }*/
                
                DB::table('usr_participantes')->where('id','=', $id_participante)->update(['id_etapa' => 3]);

                $query_part = DB::select("SELECT  partici_status.banges as banges
                FROM usr_participantes AS partici 
                LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
                WHERE partici.id=$id_participante");

                foreach ($query_part as $res)
                {   $banges=$res->banges;}
                
                /*if($indica_down_cp==0)
                {   $salidaJson=array("newnamecompleto"=>$newnamecompleto,"banges"=>$banges,);}
                else
                {*/   
                    $salidaJson=array("banges"=>$banges,);
                //}
                echo(json_encode($salidaJson));
            //}
        }
        if($paso==3)
        {
            DB::table('usr_participantes')->where('id','=', $id_participante)->update(['id_etapa' => 4]);
            $query_part = DB::select("SELECT  partici_status.banges as banges
                FROM usr_participantes AS partici 
                LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
                WHERE partici.id=$id_participante");
                foreach ($query_part as $res)
                {   $banges=$res->banges;}
                $salidaJson=array("banges"=>$banges,);
                echo(json_encode($salidaJson));
        }
        if($paso==4)
        {
            DB::table('usr_participantes')->where('id','=', $id_participante)->update(['id_etapa' => 5]);

            $query_part = DB::select("SELECT  partici_status.banges as banges
                FROM usr_participantes AS partici 
                LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
                WHERE partici.id=$id_participante");
                foreach ($query_part as $res)
                {   $banges=$res->banges;}
                $salidaJson=array("banges"=>$banges,);
                echo(json_encode($salidaJson));
        }
        if($paso==5)
        {
            DB::table('usr_participantes')->where('id','=', $id_participante)->update(['id_etapa'=> 6]);

            $query_part = DB::select("SELECT partici_status.banges as banges
                FROM usr_participantes AS partici 
                LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
                WHERE partici.id=$id_participante");
                foreach ($query_part as $res)
                {   $banges=$res->banges;}
                $salidaJson=array("banges"=>$banges,);
                echo(json_encode($salidaJson));
        }
    }

    // ELIMINA DOCUMENTOS ADJUNTOS EN EL PROCESO DE CONTRATACIÓN
    public function deldoc(Ofertas $ofertas)
    {   if (isset(Auth::user()->id)) 
        {
            $data= request()->except('_token');
            $optdoc= $data['optdoc'];  
            
            if($optdoc=='rp') // los tipo de documentos estan en la tabla usr_part_curri_tipodocattach
            {
                $id_curri= $data['id_curri'];
                $id_participante= $data['id_participante'];
                
                $id_doc=1; // los tipo de documentos estan en la tabla usr_part_curri_tipodocattach
            
                $query = DB::select("SELECT nomdoc
                FROM usr_part_curri_docattach AS docatch 
                WHERE id_participante=$id_participante and id_curri=$id_curri and iddoc= $id_doc");

                foreach ($query as $res)
                {   $nomdoc=$res->nomdoc;
                    unlink($nomdoc);
                    $paso=2;
                    DB::table('usr_part_curri_docattach')->where('iddoc','=', $id_doc)->where('id_curri','=', $id_curri)->where('id_participante','=', $id_participante)->delete();
                    DB::table('usr_participantes')->where('id','=', $id_participante)->update(['id_etapa' => $paso]);
                }
                $query_part = DB::select("SELECT  partici_status.banges as banges
                    FROM usr_participantes AS partici 
                    LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
                    WHERE partici.id=$id_participante");

                    foreach ($query_part as $res)
                    {   $banges=$res->banges;}
                    
                    $salidaJson=array("banges"=>$banges,
                                        "paso"=>$paso,);

                    echo(json_encode($salidaJson));
            }
            else
            {   if($optdoc=='aprob') // eliminando archivo de aprobación por parte de jefe de la ofera laboral
                {   $paso=4;
                    $id= $data['id'];
                    $resp='-';
                    $query = DB::select("SELECT aprobacion_ofl as url_doc,id_participante  FROM usr_partici_cartaofl WHERE id=$id and aceptacion_ofl is null");
                    foreach ($query as $res)
                    {   $nomdoc=str_replace('/storage', "", $res->url_doc);
                        $id_participante=$res->id_participante;
                        Storage::disk('public')->delete($nomdoc);
                        DB::table('usr_partici_cartaofl')->where('id','=', $id)->where('aceptacion_ofl','=', null)->update(['aprobacion_ofl' => null]);
                        DB::table('usr_participantes')->where('id','=', $id_participante) ->update(['id_etapa' => $paso]);
                        $query_part = DB::select("SELECT  partici_status.banges as banges
                                FROM usr_participantes AS partici 
                                LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
                                WHERE partici.id=$id_participante");
                                foreach ($query_part as $res)
                                {   $banges=$res->banges;}
                        $resp=1;
                    }
                    $salidaJson=array("resp"=>$resp,
                    "paso"=>$paso,
                    "banges"=>$banges,);
                    echo(json_encode($salidaJson));
                }
                else
                {   if($optdoc=='oflacept') // eliminando archivo de aceptación por parte del candidato
                    {   $paso=4;
                        $id= $data['id'];
                        $resp='-';
                        $banges='-';
                        $query = DB::select("SELECT aceptacion_ofl as url_doc,id_participante  FROM usr_partici_cartaofl WHERE id= $id");
                        foreach ($query as $res)
                        {   $nomdoc=str_replace('/storage', "", $res->url_doc);
                            $id_participante=$res->id_participante;
                            Storage::disk('public')->delete($nomdoc);
                            $resp=1;
                            DB::table('usr_partici_cartaofl')->where('id','=', $id)->update(['aceptacion_ofl' => null,'estado' => 5,'faceptacion'=> null]);
                            DB::table('usr_participantes')->where('id','=', $id_participante) ->update(['id_etapa' => $paso]);
                            $query_part = DB::select("SELECT  partici_status.banges as banges
                                FROM usr_participantes AS partici 
                                LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
                                WHERE partici.id=$id_participante");
                    
                                foreach ($query_part as $res)
                                {   $banges=$res->banges;}
                        }                        
                        $salidaJson=array("resp"=>$resp,
                        "paso"=>$paso,
                        "banges"=>$banges,);
                        echo(json_encode($salidaJson));
                    }
                    else
                    {   $id= $data['id'];
                        $resp='-';
                        $banges='-';
                        // los tipo de documentos estan en la tabla usr_part_curri_tipodocattach
                        if($data['optdoc']=='record'){  $id_doc=1; $paso=2; }
                        if($data['optdoc']=='ced'){  $id_doc=2; $paso=5; }
                        if($data['optdoc']=='certificado_nacimiento'){  $id_doc=3; $paso=5;  }
                        if($data['optdoc']=='carnet_css'){  $id_doc=4; $paso=5;  }
                        if($data['optdoc']=='constancia_dir'){  $id_doc=5; $paso=5;  }
                        if($data['optdoc']=='dimploma'){  $id_doc=6; $paso=5;    }
                        if($data['optdoc']=='foto'){  $id_doc=7; $paso=5;   }
                        
                        $query = DB::select("SELECT nomdoc as url_doc, id_participante FROM usr_part_curri_docattach WHERE id=$id and iddoc=$id_doc");
                        foreach ($query as $res)
                        {   $nomdoc=str_replace('/storage', "", $res->url_doc);
                            $id_participante=$res->id_participante;
                            Storage::disk('public')->delete($nomdoc);
                            DB::table('usr_part_curri_docattach')->where('id','=', $id)->where('iddoc','=', $id_doc)->delete();
                            $resp=1;
                            
                            DB::table('usr_participantes')->where('id','=', $id_participante) ->update(['id_etapa' => $paso]);
                            $query_part = DB::select("SELECT  partici_status.banges as banges
                                FROM usr_participantes AS partici 
                                LEFT JOIN usr_partici_etapas_proceso AS partici_status ON (partici_status.id=partici.id_etapa)
                                WHERE partici.id=$id_participante");
                    
                                foreach ($query_part as $res)
                                {   $banges=$res->banges;}

                        }
                        $salidaJson=array("resp"=>$resp,
                        "paso"=>$paso,
                        "banges"=>$banges,);
                        echo(json_encode($salidaJson));
                    }
                }
            }
        }
        else{   return view('auth.login');}
    }
    
    // INSERTA LOS DATOS Y QUE ESTÉN DISPONIBLES PARA LA CREACIÓN DE LAS CARTAS DE OFERTAS LABOTALES
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

            DB::table('usr_partici_cartaofl')
            ->where('id_participante','=', $id_participante)
            ->where('estado','=', 1)
            ->update(['estado' => 2]);

            DB::table('usr_partici_cartaofl')
            ->where('id_participante','=', $id_participante)
            ->delete();

            $new= new Usr_partici_cartaofl();
            $new->id_participante= $id_participante;
            $new->salario= $salario;
            $new->finicio= $finicio;
            $new->fterminacion= $fterminacion;
            $new->sel_tipo_contrato= $sel_tipo_contrato;
            $new->sel_tipo_salario= $sel_tipo_salario;
            $new->save();


            $data_cartas= DB::select("SELECT id, salario, finicio, fterminacion, sel_tipo_contrato, sel_tipo_salario, estado,aprobacion_ofl, aceptacion_ofl, faceptacion, descargada_por
            FROM usr_partici_cartaofl         
            WHERE id_participante  =$id_participante order by created_at desc");

            echo json_encode($data_cartas);

 
        }
        else{   return view('auth.login');}
    }

    public function cartapdf(Ofertas $ofertas)
    {
       
        if (isset(Auth::user()->id)) 
        {
            $data= request();
            if($data['opt']==0)
            {
                setlocale(LC_ALL, 'es_ES');
                $txtid= $data['txtid']; 
                
                $data_ofertas= DB::select("SELECT cart.salario, cart.finicio, cart.fterminacion, cart.sel_tipo_contrato, cart.sel_tipo_salario
                ,pla.nombre_memb, pla.apartado, pla.email, pla.tel,
                curri.prinombre, curri.segnombre, curri.priapellido, curri.segapellido, curri.genero,
                pos.descpue
                FROM usr_partici_cartaofl cart 
                LEFT JOIN usr_participantes parti ON (parti.id= cart.id_participante)
                LEFT JOIN vacantes_solicitudes ofl ON (ofl.id=parti.id_ofl)
                LEFT JOIN colab_planillera_membretes pla ON (pla.id_planillera=ofl.COD_PAGADORA)
                LEFT JOIN usr_part_curriculum curri ON (curri.id=parti.id_part_curriculum)
                LEFT JOIN posiciones pos ON (pos.id=parti.id_puesto)
                WHERE cart.id=$txtid and cart.estado");

                //var_dump($data_ofertas);
                foreach ($data_ofertas as $r)
                {   $finicio= $r->finicio;
                    $salario= $r->salario;
                    $fterminacion= $r->fterminacion;
                    $sel_tipo_contrato= $r->sel_tipo_contrato;
                    $segnombre=" ";$segapellido=" ";
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
            
                $fecha_actual = \Carbon\Carbon::now()->isoFormat(' D \d\e MMMM \d\e\l Y');
                $fecha_larga_inicio = \Carbon\Carbon::parse($finicio)->isoFormat('dddd D \d\e MMMM \d\e\l Y');

                DB::table('usr_partici_cartaofl')->where('id','=', $txtid)->update(['estado' => 5]);

                $data=json_encode(array(
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
                ));

                $pdf = Pdf::loadView('re.PDFcartaoferta',compact('data')); 
                return $pdf->download('Carta Oferta '.$descpue.'.pdf');
            }else{echo $data['opt'];}
        }
        else{   return view('auth.login');}
    }

    public function cartapdfcontrato(Ofertas $ofertas)
    {
        if (isset(Auth::user()->id)) 
        {   $data= request();            
            if($data['opt_cont']==0)
            {
                $id_participante=$data['id_participante_cont'];
                $id_curri=$data['id_curri_cont'];
                $data_ofertas= DB::select("SELECT cart.salario, cart.finicio, cart.fterminacion, cart.sel_tipo_contrato, cart.sel_tipo_salario,
                pla.nombre_memb, pla.apartado, pla.email, pla.tel, pla.detalle, pla.representante, pla.det_representante, pla.ced_representante,
                curri.prinombre, curri.segnombre, curri.priapellido, curri.segapellido, curri.genero, nac.nacionalidad, curri.direccion, curri.f_nacimiento, curri.id_tipo_doc_letra, curri.num_doc, curri.num_ss, curri.estadocivil,
                prov.provincia, distri.distrito, correg.corregimiento,
                pos.descpue,descri.proposito, est.hrs_semanales,  est.hrs_mensuales, est.horarios
                FROM usr_participantes parti
                LEFT JOIN usr_partici_cartaofl cart  ON (parti.id= cart.id_participante and cart.estado=3)
                LEFT JOIN vacantes_solicitudes ofl ON (ofl.id=parti.id_ofl)
                LEFT JOIN colab_planillera_membretes pla ON (pla.id_planillera=ofl.COD_PAGADORA)
                LEFT JOIN usr_part_curriculum curri ON (curri.id=parti.id_part_curriculum)
                LEFT JOIN posiciones pos ON (pos.id=parti.id_puesto)
                LEFT JOIN usr_nacionalidad nac ON (nac.id=curri.id_nacionalidad)
                LEFT JOIN dir_provincias prov ON (prov.id=curri.id_provincia)
                LEFT JOIN dir_distritos distri ON (distri.id=curri.id_distrito)
                LEFT JOIN dir_corregimientos correg ON (correg.id=curri.id_corregimiento)
                LEFT JOIN descriptivos descri ON (descri.id=pos.iddf)
                LEFT JOIN estructuras est ON (est.id=pos.idue)
                WHERE parti.id=$id_participante and parti.id_part_curriculum=$id_curri");



                foreach ($data_ofertas as $r)
                {   $finicio= $r->finicio;
                    $salario= $r->salario;
                    $fterminacion= $r->fterminacion;
                    $sel_tipo_salario = $r->sel_tipo_salario;
                    $num_ss = $r->num_ss;
                    $estadocivil = $r->estadocivil;
                    
                    $tipo_contrato='-';
                    $sel_tipo_contrato= $r->sel_tipo_contrato;
                    if($sel_tipo_contrato=='T') { $tipo_contrato="DEFINIDO";}
                    if($sel_tipo_contrato=='P') { $tipo_contrato="INDEFINIDO";}

                    $segnombre=" ";$segapellido=" ";
                    $estimado='Estimado';
                    $sr='Señor';
                    $masc_fem='masculino';
                    if($r->genero=='F')
                    {   $estimado='Estimada';
                        $sr='Señora';
                        $masc_fem="femenino";}
                    $nacionalidad= $r->nacionalidad;
                    


                    $anios=\Carbon\Carbon::parse($r->f_nacimiento)->age;

                    $nombre_memb= $r->nombre_memb;
                    $representante= $r->representante;
                    $ced_representante= $r->ced_representante;
                    $det_representante= $r->det_representante;
                    $apartado= $r->apartado;
                    $detalle= $r->detalle;

                    $prinombre= $r->prinombre;
                    if($r->segnombre!=null)
                    {   $segnombre= $r->segnombre;}
                    
                    $priapellido= $r->priapellido;
                    if($r->segapellido!=null)
                    {   $segapellido= $r->segapellido;}
                
                    $direccion= $r->direccion;
                    $provincia= $r->provincia;
                    $distrito= $r->distrito;
                    $corregimiento= $r->corregimiento;
                    $genero= $r->genero;
                    $tipo_doc_firma='';
                    if($r->id_tipo_doc_letra='C')
                    {   $tipo_doc='de la cédula de identidad personal  No.'.$r->num_doc;
                        $tipo_doc_firma='Cédula No. '.$r->num_doc;}
                    if($r->id_tipo_doc_letra='P')
                    {   $tipo_doc='del pasaporte No. '.$r->num_doc;
                        $tipo_doc_firma='Pasaporte No. '.$r->num_doc;}
                    
                    $descpue= $r->descpue;
                    $proposito=$r->proposito;
                    $hrs_semanales=$r->hrs_semanales; 
                    $hrs_mensuales=$r->hrs_mensuales; 
                    $horarios=$r->horarios;
                }                  

                $data_dependientes= DB::select("SELECT id, nombre, parentesco, f_nacimiento
                FROM usr_part_dependientes         
                WHERE id_part_curriculum=$id_curri");
            
                $fecha_actual = \Carbon\Carbon::now()->isoFormat(' D \d\í\a\s \d\e\l\ \m\e\s\ \d\e MMMM \d\e\l Y');
                $fecha_larga_inicio = \Carbon\Carbon::parse($finicio)->isoFormat('dddd D \d\e MMMM \d\e\l Y');
                $fecha_larga_terminacion =$fterminacion;
                if($fterminacion!='1900-01-01'&&$sel_tipo_contrato!='P')
                {   $fecha_larga_terminacion = \Carbon\Carbon::parse($fterminacion)->isoFormat('dddd D \d\e MMMM \d\e\l Y');}

                $data=json_encode(array(
                    "nombre_memb"=>$nombre_memb,
                    
                    "representante"=>$representante,
                    "ced_representante"=>$ced_representante,
                    "det_representante"=> $det_representante,
                    "detalle"=> $detalle,
                    "apartado"=>$apartado,

                    "fecha_actual"=>$fecha_actual,
                    "sr"=>$sr,
                    "estimado"=>$estimado,
                    "descpue"=>$descpue,
                    "proposito"=>$proposito,
                    "prinombre"=>$prinombre,
                    "segnombre"=>$segnombre,
                    "priapellido"=>$priapellido,
                    "segapellido"=>$segapellido,
                    "masc_fem"=> $masc_fem,
                    "nacionalidad"=> $nacionalidad,
                    "anios"=>$anios,

                    "direccion"=>$direccion,
                    "provincia"=> $provincia,
                    "distrito"=> $distrito,
                    "corregimiento"=> $corregimiento,
                    "tipo_doc"=>$tipo_doc,
                    "num_ss" => $num_ss,
                    "estadocivil" => $estadocivil,
                    "tipo_doc_firma"=>$tipo_doc_firma,
                    "salario"=>$salario,
                    "sel_tipo_salario" => $sel_tipo_salario,
                    "finicio"=>$finicio,
                    "fterminacion"=>$fterminacion,
                    "firmante"=>Auth::user()->name,
                    "puestofirmante"=>Auth::user()->puesto,
                    "emailfirmante"=>Auth::user()->email,
                    
                    "sel_tipo_contrato"=>$sel_tipo_contrato,
                    "tipo_contrato"=>$tipo_contrato,
                    "fecha_larga_inicio"=>$fecha_larga_inicio,
                    "fecha_larga_terminacion" =>$fecha_larga_terminacion,
                    "dependientes"=>$data_dependientes,
                    "hrs_semanales"=> $hrs_semanales,
                    "hrs_mensuales"=> $hrs_mensuales, 
                    "horarios"=> $horarios,
                ));

                $pdf = Pdf::loadView('re.PDFcontwork',compact('data')); 
                return $pdf->download('Contrato '.$prinombre." ".$segnombre." ".$priapellido." ".$segapellido.'.pdf');
            }
        }
        else{   return view('auth.login');}
    }
    public function subirfoto(Request $request)
    {    if (isset(Auth::user()->id)) 
        {
            if($request->isMethod('POST'))
            {

                    $data = $request['image'];
                    $num_aprob_ofl=$request['num_aprob_ofl'];
                    $image_array_1 = explode(";", $data);
                    $image_array_2 = explode(",", $image_array_1[1]);
                    $data = base64_decode($image_array_2[1]);
                    $imageName = time() . '.png';
                    file_put_contents($imageName, $data);
                    $image_file = addslashes(file_get_contents($imageName));
                    DB::table('usr_part_curriculum')->where('id','=', $num_aprob_ofl)->update(['photo' => $data]);
                    $dataresp='-';
                    $query = DB::select("SELECT photo FROM usr_part_curriculum WHERE id= $num_aprob_ofl");
                    foreach ($query as $res)
                    {   $dataresp= $res->photo;
                    unlink($imageName);}
                    
                    echo('<img src="data:image/png;base64,'.base64_encode($dataresp).'" class="rounded-circle"  id="img_photo" />');

            }
        }        
        else{   return view('auth.login');}
    }

    public function subir(Request $request)
    {    if (isset(Auth::user()->id)) 
        {
            $url="-";
            if($request->isMethod('POST'))
            {  $num_aprob_ofl=$request['num_aprob_ofl'];

                if($request['optarchi']!='photo')
                {   $file=$request->file('filedoc')->store('public/'.$request['optarchi']);
                    $url=Storage::url($file);
                }

                if($request['optarchi']=='aprob')
                {   DB::table('usr_partici_cartaofl')
                    ->where('id','=', $num_aprob_ofl)
                    ->update(['aprobacion_ofl' => $url]);
                    echo $url; 
                }      
                else 
                {   
                    if($request['optarchi']=='oflacept')
                    {   $hoy = date("Y-m-d");
                        DB::table('usr_partici_cartaofl')
                        ->where('id','=', $num_aprob_ofl)
                        ->where('aprobacion_ofl','<>', null)
                        ->update(['aceptacion_ofl' => $url,'estado' => '3','faceptacion'=> $hoy]);
                        
                        $salidaJson=array("url"=>$url,"faceptacion"=>$hoy);
                        echo(json_encode($salidaJson));
                         
                    }     
                    else 
                    {   if($request['optarchi']=='contwork')
                        {   $hoy = date("Y-m-d");
                            DB::table('usr_partici_cartaofl')
                            ->where('id','=', $num_aprob_ofl)
                            ->update(['contworkfirmado' => $url,'f_contworkfirmado'=> $hoy]);
                            
                            $salidaJson=array("url"=>$url,"f_contworkfirmado"=>$hoy);
                            echo(json_encode($salidaJson));
                             
                        }     
                        else 
                        {   if($request['optarchi']=='photo')
                            {   
                                $hoy = date("YmdHisu");
                                $nombre = $hoy.'.'.$request->file('filedoc')->getClientOriginalExtension();
                                $ruta = storage_path().'\app\public\profiles\photo/'. $nombre;
                                
                                $manager = new ImageManager(new Driver());

                                // read image from file system
                                /*$image = $manager->read($request->file('filedoc'))                                
                                ->resize(null,800, function ($constraint){$constraint->aspectRatio();})                               
                                ->save($ruta);*/

                                
                                $manager = new ImageManager(new Driver());
                                $image = $manager->read($request->file('filedoc'));

                                // scale to fixed height
                                $image->scale(height: 500)->save($ruta); // 400 x 300
                                $url='/FOCUSTalent/public/storage/profiles/photo/'. $nombre;
                               /*  $query = DB::select("SELECT photo FROM usr_part_curriculum WHERE id= $num_aprob_ofl");
                                foreach ($query as $res)
                                {   
                                    $nomdoc=str_replace('/storage', "", $res->photo);
 
                                    Storage::disk('public')->delete($nomdoc);
                                } */ 

                                    
                                DB::table('usr_part_curriculum')->where('id','=', $num_aprob_ofl)->update(['photo' => $url]);
                                $data='-';
                                $query = DB::select("SELECT photo FROM usr_part_curriculum WHERE id= $num_aprob_ofl");
                                foreach ($query as $res)
                                {   $data= $res->photo;}
                                echo($data);
                            }     
                            else 
                            {    // los tipo de documentos estan en la tabla usr_part_curri_tipodocattach
                                if($request['optarchi']=='record'){  $id_doc=1;  }
                                if($request['optarchi']=='ced'){  $id_doc=2;  }
                                if($request['optarchi']=='certificado_nacimiento'){  $id_doc=3;    }
                                if($request['optarchi']=='carnet_css'){  $id_doc=4;    }
                                if($request['optarchi']=='constancia_dir'){  $id_doc=5;    }
                                if($request['optarchi']=='dimploma'){  $id_doc=6;    }
                                if($request['optarchi']=='foto'){  $id_doc=7;    }
                                $id_curri=$request['id_curri'];
                                $id_participante=$request['id_participante'];
        
                                //DB::table('usr_part_curri_docattach')->where('id_curri','=', $id_curri)->where('id_participante','=', $id_participante)->where('iddoc','=', $id_doc)->delete();
                                $new= new Curri_docattach();
                                $new->id_curri= $id_curri;
                                $new->iddoc= $id_doc;
                                $new->nomdoc= $url;
                                $new->id_participante=  $id_participante;
                                $new->save();
        
                                $query = DB::select("SELECT id FROM usr_part_curri_docattach WHERE id_curri= $id_curri and id_participante=$id_participante and iddoc=$id_doc");
                                foreach ($query as $res)
                                {   $id= $res->id;}
                                $salidaJson=array("url"=>$url,"id"=>$id);
                                echo(json_encode($salidaJson));
                            }
                        }
                    }
                }                
            }
        }
        else{   return view('auth.login');}
    }



}