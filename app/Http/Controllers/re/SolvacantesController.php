<?php

namespace App\Http\Controllers\re;

use App\Http\Controllers\Controller;
use App\Models\re\Solvacantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SolvacantesController extends Controller
{
 
    public function index()
    {   $id_menu=3;
        $id_menu_sup=2;
        if (isset(Auth::user()->id)) 
        {   $id_user = Auth::user()->id;
            $data=0;
            $query = DB::select("SELECT rm.id_menu 
            FROM usr_rol ur INNER JOIN rol_menu rm ON (rm.id_rol=ur.id_rol AND rm.id_menu=$id_menu) 
            WHERE ur.id_usr=$id_user ");
            foreach ($query as $r)
            {   $data=$r->id_menu;}
            if($data!=0)
            {   $data_sups=DB::select("SELECT es.id, es.nameund FROM rec_usr_ue rec INNER JOIN estructuras es ON (es.id=rec.id_ue) WHERE rec.id_usr=$id_user");

                $data_vacantes_motivo=DB::select("SELECT id, motivo FROM vacantes_motivo WHERE status='true'");
                $data_vacantes_genero=DB::select("SELECT id, letra, genero FROM vacantes_genero");
                $data_vacantes_edades=DB::select("SELECT id, rango FROM vacantes_edades WHERE status='true'");
                $data_PAGADORAs=DB::select("SELECT COD_PAGADORA, PAGADORA FROM colab_planillera_ceco group by COD_PAGADORA, PAGADORA order by COD_PAGADORA");

                return view('re.solvacantes')
                ->with('data_sups',$data_sups)
                ->with('id_menu',$id_menu)
                ->with('id_menu_sup',$id_menu_sup)
                ->with('data_vacantes_motivo',$data_vacantes_motivo)
                ->with('data_vacantes_genero',$data_vacantes_genero)
                ->with('data_vacantes_edades',$data_vacantes_edades)                
                ->with('data_PAGADORAs',$data_PAGADORAs);
            }
            else{   return view('auth.login');}
        }
        else{   return view('auth.login');}
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    { if (isset(Auth::user()->id)) 
      { $data= request()->except('_token');
        $id_puesto= $data['id_puesto'];
        $codigo_puesto= $data['codigo_puesto'];
        $cantidad= $data['cantidad'];
        $genero= $data['genero'];
        $rango_edad= $data['rango_edad'];
        $comentarios= str_replace("/^[\w.\n\r\s]+$/", "", $data['comentarios']);
        $id_secc= $data['id_secc'];
        $id_ue= $data['id_ue'];
        $id_jer= $data['id_jer'];
        $id_escala= $data['id_escala'];
        $tiemporeal= $data['tiemporeal'];
        $tiempocalculado= $data['tiempocalculado'];
        $id_motivo= $data['id_motivo'];
        $fileToUpload= $data['fileToUpload'];
        $sel_PAGADORA= $data['sel_PAGADORA'];
        $sel_ceco= $data['sel_ceco'];
        $id_user_solicitante= Auth::user()->id;
        $newname='-';$sube=0;
        $newnamecompleto='-';
        if($fileToUpload!='-')
        {
            define("fileName", '');
            $fileName = '';
            $path="docs/";
            if(isset($_FILES["fileToUpload"]["type"])){
                $target_dir = $path;
                $carpeta=$target_dir;
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777, true);
                }

                $extension = explode('.',$_FILES['fileToUpload']['name']);
                $num = count($extension)-1;

                // Creamos el nombre del archivo dependiendo la opción
                $newname=fileName.time().'.'.$extension[$num];
                $newnamecompleto = $target_dir.$newname;

                $target_file = $carpeta . basename($_FILES["fileToUpload"]["name"]);
                #$target_file = $carpeta . basename($_FILES["fileToUpload"]["name"]);
                $uploadOk = 1;
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            
                // Check if file already exists
                if (file_exists($target_file)) {
                    $mensaje= ' El archivo ya existe.';$sube=2;
                    $uploadOk = 0;
                }
                // Check file size
            /*  if ($_FILES["fileToUpload"]["size"] > 92000000000) {
                    echo ' El archivo es demasiado grande. Tamaño máximo admitido: 4 MB.';$sube=2;
                    $uploadOk = 0;
                }*/
                // Allow certain file formats
            /* if($imageFileType != "xls" && $imageFileType != "xlsx" ) {
                    echo ' Solamente archivos xls, xlsx, .csv';$sube=2;
                    $uploadOk = 0;
                }*/
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    $mensaje= ' El archivo no fue adjuntado.';$sube=2;
                // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $newnamecompleto)) {
                        $sube=1;            
                    } else {
                        $mensaje= ' Hubo un error subiendo el archivo.';$sube=2;
                    }
                }
            }
        }
        $totcantidad=0;
        if($sube==0||$sube==1)
        {   $fecha_actual = date("Y-m-d");
            
            $fecha_hasta= date("Y-m-d",strtotime($fecha_actual."+ ".$tiempocalculado." days"));
            
            $new = new Solvacantes();
            $new->id_puesto = $id_puesto;
            $new->codigo_puesto = $codigo_puesto;
            $new->cantidad =  $cantidad;
            $new->proceso= 0;
            $new->contratados= 0;
            $new->genero =  $genero;
            $new->rango_edad =  $rango_edad;
            $new->comentarios =  $comentarios;
            $new->id_secc =  $id_secc;
            $new->id_ue =  $id_ue;
            $new->id_jer =  $id_jer;
            $new->id_estatus =  1;
            $new->id_escala =  $id_escala;
            $new->tiemporeal =  $tiemporeal;
            $new->tiempocalculado =  $tiempocalculado;
            $new->hasta =  $fecha_hasta;
            $new->id_motivo =  $id_motivo;
            $new->autorizacion =  $newnamecompleto;
            $new->id_user_solicitante =  $id_user_solicitante;
            $new->COD_PAGADORA =  $sel_PAGADORA;
            $new->cod_cia =  $sel_ceco;
            $new->save();

            $query = DB::select("SELECT  `vacsol`.`id_puesto`,sum(`vacsol`.`cantidad`) as `totcantidad`
			FROM `vacantes_solicitudes` `vacsol` WHERE vacsol.id_puesto=$id_puesto and `id_estatus`<4 and `vacsol`.`contratados`<`vacsol`.`cantidad`");
            foreach ($query as $r)
            {   $totcantidad=$r->totcantidad;}
        }
        $salidaJson=array(
            "totcantidad"=>$totcantidad,
            "sube"=>$sube,
        );
        echo(json_encode($salidaJson));
      }
      else{   return view('auth.login');}
    }

    public function show(Solvacantes $solvacantes)
    {   if (isset(Auth::user()->id)) 
        {   $data= request()->except('_token');
            $id_pue= $data['id_pue'];
            $proposito='-';$id_jer='0';$idue='0';
            $query = DB::select("SELECT df.proposito, df.idjer, po.idue, po.iduni
            FROM posiciones po INNER JOIN descriptivos df ON (po.iddf=df.id) 
            WHERE po.id=$id_pue");
            foreach ($query as $r)
            {   $proposito=$r->proposito;
                $id_jer=$r->idjer;
                $id_ue=$r->idue;
                $id_secc=$r->iduni;}
            $tiempo=0;
            $query = DB::select("SELECT esc.id_escala, esc.tiempo
            FROM 
            escalas_unidades_rel rel INNER JOIN 
            escalas_jeraquias esc ON (esc.id_escala=rel.id_escala and esc.id_jerarquia=$id_jer) 
            
            WHERE rel.id_unidad=$id_ue");
            foreach ($query as $r)
            {   $tiempo=$r->tiempo;
                $id_escala=$r->id_escala;}

            $salidaJson=array(
                "proposito"=>$proposito,
                "tiempo"=>$tiempo,
                "id_jer"=>$id_jer,
                "id_ue"=>$id_ue,
                "id_secc"=>$id_secc,
                "id_escala"=>$id_escala,
                );

            echo(json_encode($salidaJson));

        }
        else{   return view('auth.login');}
    }

    public function viewmotivo(Request $request)
    {
        $data= request()->except('_token');
        $id_motivo= $data['id_motivo'];
        $data_vacantes_motivo=DB::select("SELECT necesita_autorizacion FROM vacantes_motivo WHERE id=$id_motivo");
        foreach ($data_vacantes_motivo as $r)
        {   $necesita=$r->necesita_autorizacion;}
        $salidaJson=array("necesita"=>$necesita);
        echo(json_encode($salidaJson));
    }

    public function ceco(Solvacantes $solvacantes)
    {
        $data= request()->except('_token');
        $COD_PAGADORA= $data['COD_PAGADORA'];           
        $data_cecos = DB::select("SELECT cod_cia,nom_cia FROM colab_planillera_ceco WHERE COD_PAGADORA='$COD_PAGADORA' order by cod_cia");
        echo (json_encode($data_cecos));
    }

    public function update(Request $request, Solvacantes $solvacantes)
    {
        //
    }

    public function destroy(Solvacantes $solvacantes)
    {
        //
    }
}
