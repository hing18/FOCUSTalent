<?php

namespace App\Http\Controllers\rl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ContworkController extends Controller
{
    public function index()
    {
        $id_menu=18;
        $id_menu_sup=17;
        if (isset(Auth::user()->id)) 
        {   $id_user = Auth::user()->id;
            $data_parti= DB::select("SELECT parti.id id_parti,curri.id id_curri,curri.prinombre, curri.segnombre, curri.priapellido, curri.segapellido, curri.num_doc, curri.f_nacimiento,curri.tel,
            pos.descpue, est.nameund, carta.finicio
            FROM usr_participantes parti
            LEFT JOIN usr_part_curriculum curri ON (curri.id=parti.id_part_curriculum)
            LEFT JOIN posiciones pos on (pos.id=parti.id_puesto)
            LEFT JOIN estructuras est on (est.id=pos.idue)
            LEFT JOIN usr_partici_cartaofl carta on (carta.id_participante=parti.id)
            WHERE parti.id_etapa=6");
            
            return view('rl.contwork')
            ->with('id_menu',$id_menu)
            ->with('id_menu_sup',$id_menu_sup)
            ->with('data_parti',$data_parti);
        }else{
            return view('auth.login');
        }
    }

    public function showfoto(Request $request)
    {
        if (isset(Auth::user()->id)) 
        {   $data= request()->except('_token');
            $id_curri= $data['id_c']; 
            
            $query = DB::select("SELECT photo FROM usr_part_curriculum WHERE id= $id_curri");
            foreach ($query as $res)
            {   if($res->photo!=null)
                {   $dataresp= '<img src="data:image/png;base64,'.base64_encode($res->photo).'" class="rounded-circle" id="img_photo"/>';}
                else
                { $dataresp=$res->photo;  }
            }
            echo($dataresp);
        }else{
            return view('auth.login');
        }
    }

    public function show(Request $request)
    {   if (isset(Auth::user()->id)) 
        {   $data= request()->except('_token');
            $id_participante= $data['id_p']; 
            $id_curri= $data['id_c']; 
            $data_ofertas= DB::select("SELECT cart.id num_aprob_ofl, cart.salario, cart.finicio, cart.fterminacion, cart.sel_tipo_contrato, cart.sel_tipo_salario,cart.contworkfirmado, cart.f_contworkfirmado ,ceco.nom_cia centro_costo,
            pla.nombre_memb, pla.apartado, pla.email, pla.tel, pla.detalle, pla.representante, pla.det_representante, pla.ced_representante,
            curri.prinombre, curri.segnombre, curri.priapellido, curri.segapellido, curri.genero, nac.nacionalidad, curri.direccion, curri.f_nacimiento, curri.id_tipo_doc_letra, curri.num_doc, curri.num_ss, curri.estadocivil, curri.cv_doc,
            curri.permiso_trab, curri.permiso_doc, 
            prov.provincia, distri.distrito, correg.corregimiento,
            pos.descpue,descri.proposito, est.hrs_semanales,  est.hrs_mensuales, est.horarios, est.nameund, parti.marcacion
            FROM usr_participantes parti
            LEFT JOIN usr_partici_cartaofl cart  ON (parti.id= cart.id_participante and cart.estado=3)
            LEFT JOIN vacantes_solicitudes ofl ON (ofl.id=parti.id_ofl)
            LEFT JOIN colab_planillera_membretes pla ON (pla.id_planillera=ofl.cod_pagadora)
            LEFT JOIN colab_planillera_ceco ceco ON (ceco.COD_CIA=ofl.cod_cia)
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
                $hrs_mensuales=  $r->hrs_mensuales;

                $sal= number_format($salario, 2, '.', ',')." (por mes)";
                $tiposalario="BASE";
                if($sel_tipo_salario=='H'){
                    
                    $sal= number_format($salario, 2, '.', ',').' ('.number_format(($salario/$hrs_mensuales), 2, '.', ',')." por hora)";  
                    $tiposalario="POR HORA";  
                }

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
                
                    $permiso_trab= $r->permiso_trab;
                    $permiso_doc= $r->permiso_doc;

                $anios=\Carbon\Carbon::parse($r->f_nacimiento)->age;
                $f_nacimiento=$r->f_nacimiento;
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
                $cedula=$r->num_doc;
                if($r->id_tipo_doc_letra='C')
                {   $tipo_doc='de la cédula de identidad personal  No.'.$r->num_doc;
                    $tipo_doc_firma='Cédula No. '.$r->num_doc;}
                if($r->id_tipo_doc_letra='P')
                {   $tipo_doc='del pasaporte No. '.$r->num_doc;
                    $tipo_doc_firma='Pasaporte No. '.$r->num_doc;}
                
                $descpue= $r->descpue;
                $proposito=$r->proposito;
                $nameund=$r->nameund;
                $hrs_semanales=$r->hrs_semanales; 
                $hrs_mensuales=$r->hrs_mensuales; 
                $horarios=$r->horarios;
                $cv_doc=$r->cv_doc;
                $centro_costo=$r->centro_costo;
                $num_aprob_ofl=$r->num_aprob_ofl;
                $contworkfirmado=$r->contworkfirmado;
                $f_contworkfirmado=$r->f_contworkfirmado;
                $marcacion=$r->marcacion;
            }                  

            $data_dependientes= DB::select("SELECT id, nombre, parentesco, f_nacimiento
            FROM usr_part_dependientes         
            WHERE id_part_curriculum=$id_curri");
        
            $fecha_actual = \Carbon\Carbon::now()->isoFormat(' D \d\í\a\s \d\e\l\ \m\e\s\ \d\e MMMM \d\e\l Y');
            $fecha_larga_inicio = \Carbon\Carbon::parse($finicio)->isoFormat('dddd D \d\e MMMM \d\e\l Y');
            $fecha_larga_terminacion =$fterminacion;
            if($fterminacion!='1900-01-01'&&$sel_tipo_contrato!='P')
            {   $fecha_larga_terminacion = \Carbon\Carbon::parse($fterminacion)->isoFormat('dddd D \d\e MMMM \d\e\l Y');}

            echo json_encode(array(
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
                "f_nacimiento"=>$f_nacimiento,
                "direccion"=>$direccion,
                "provincia"=> $provincia,
                "distrito"=> $distrito,
                "corregimiento"=> $corregimiento,
                "tipo_doc"=>$tipo_doc,
                "cedula" => $cedula,
                "num_ss" => $num_ss,
                //"photo"=>$photo,
                "estadocivil" => $estadocivil,
                "tipo_doc_firma"=>$tipo_doc_firma,
                "salario"=>$salario,
                "sel_tipo_salario" => $sel_tipo_salario,
                "tiposalario"=>$tiposalario,
                "sal"=>$sal,
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
                "nameund"=> $nameund,
                "cv_doc"=>$cv_doc,
                "centro_costo"=>$centro_costo,
                "permiso_trab"=> $permiso_trab,
                "premiso_doc"=> $permiso_doc,
                "num_aprob_ofl"=> $num_aprob_ofl,
                "f_contworkfirmado"=>$f_contworkfirmado,
                "contworkfirmado"=>$contworkfirmado,
                "marcacion"=>$marcacion,
            ));

 
        }else{
            return view('auth.login');
        }
    }
}
        
