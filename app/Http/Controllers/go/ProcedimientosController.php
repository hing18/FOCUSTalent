<?php

namespace App\Http\Controllers\go;

use App\Http\Controllers\Controller;
use App\Models\go\Estructura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcedimientosController extends Controller
{
    public function show(Request $request)
    {   $data= request()->except('_token');
        $opt= $data["opt"];
        if($opt==1)
        {   $sel_grp=$data['sel_grp'];
            $result = DB::select("SELECT est.id, est.codigo, est.nameund FROM estructuras est WHERE est.id_sup=$sel_grp and est.status='true' order by est.nameund");            
            echo(json_encode($result));
        }

        if($opt==2)
        {
            $sel_ue=$data['sel_ue'];
            $result= DB::table('vestructuraspos')
                ->select( 'COD_GRUPO','CODIGO_GRP','NOM_GRUPO','COD_UNI','CODIGO_UNI','NOM_UNI','COD_DEPTO_SUC','CODIGO_DEPTO_SUC','NOM_DEPTO_SUC','COD_SECC','CODIGO_SECC','NOM_SECC','COD_PUE','CODIGO_PUE','DESC_PUE','CONT_UNI','CONT_DEPTO_SUC','CONT_SECC')
                ->where('COD_UNI', '=', $sel_ue)
                ->orderBy('NOM_UNI', 'asc')
                ->get();

            echo '<table class="table table-sm table-hover table-bordered">
                <thead class="bg-primary">
                    <tr>
                    <th scope="col" class="text-center text-light bg-primary">UNIDAD</th>
                    <th scope="col" class="text-center text-light bg-primary">ÁREA / CADENA</th>
                    <th scope="col" class="text-center text-light bg-primary">DEPARTAMENTO / SUCURSAL</th>
                    <th scope="col" class="text-center text-light bg-primary">POSICIONES</th>
                    </tr>
                </thead>
                <tbody><tr>';
                        $unidad = "";
                        $colspan = 0;
                        $dato_comb="";
                        $depto= "";
                        $secc= "";
                foreach( json_decode($result) as $vestruc )
                {     
                    #UNIDAD ECONÓMICA
                            if($unidad==""){  
                            $unidad = $vestruc->NOM_UNI;
                            $colspan = $vestruc->CONT_UNI;
                            echo "<td class='align-middle bg-white' rowspan='".$colspan."'><small>".$unidad."<small></td>";
                            }
                            else {
                            if($unidad!=$vestruc->NOM_UNI){  
                                $unidad = $vestruc->NOM_UNI;
                                $colspan = $vestruc->CONT_UNI;
                                echo "<td class='align-middle bg-white' rowspan='".$colspan."'><small>".$unidad."</small></td>";
                            }
                            }
                    #DEPARTAMENTO
                            if($depto==""){  
                            $depto = $vestruc->NOM_DEPTO_SUC;
                            $colspan = $vestruc->CONT_DEPTO_SUC;
                            echo "<td class='align-middle bg-white' rowspan='".$colspan."'><small>".$depto."<small></td>";
                            }
                            else {
                            if($depto!=$vestruc->NOM_DEPTO_SUC){  
                                $depto = $vestruc->NOM_DEPTO_SUC;
                                $colspan = $vestruc->CONT_DEPTO_SUC;
                                echo "<td class='align-middle bg-white' rowspan='".$colspan."'><small>".$depto."</small></td>";
                            }
                            }
                    #SECCION
                    /*        if($vestruc->NOM_SECC!=null)
                            {   echo '<td><small>'.$vestruc->NOM_SECC.'</small></td> </tr>';}
                            else {
                                echo '<td><small>-</small></td> </tr>';
                            }*/
                    #SECCION
                            if($secc==""){  
                            $secc = $vestruc->NOM_SECC;
                            $colspan = $vestruc->CONT_SECC;  
                            echo "<td class='align-middle bg-white' rowspan='".$colspan."'><small>".$secc."<small></td>";
                            }
                            
                            else {
                                if($secc!=$vestruc->NOM_SECC){  
                                $secc = $vestruc->NOM_SECC;
                                $colspan = $vestruc->CONT_SECC;                     

                                echo "<td class='align-middle bg-white' rowspan='".$colspan."'><small>".$secc."</small></td>";
                                }
                            }
                    # PPSICIONES
                            $check='';
                                    if($vestruc->COD_PUE!=null){ 
                                    echo' <td class="align-middle bg-white"><small>'.$vestruc->DESC_PUE.'</small></td></tr>';
                                    }
                                    else {
                                    echo' <td><small>-</small></td></tr>';
                                    }
                }
                echo '</tbody>
                </table>'; 
        }

        #### CONSULTA UNIDAD
        if($opt==3)
        {   $id_uni=$data['id_uni'];
            $result= DB::table('estructuras')
                ->select( 'id','codigo','nameund','id_sup','id_tipo','status')
                ->where('id', '=', $id_uni)
                ->orderby('nameund')
                ->get();
                echo(json_encode($result));
        }

    #### ACTUALIZANDO UNIDAD
    if($opt==4)
    {   $idund=$data['idund'];
        $codigo=$data['codigo'];
        $nameund=$data['nameund'];
        $id_tipo=$data['id_tipo'];
        $id_sup=$data['id_sup'];
        
        $status='true';
        if($data['status']=='false')
        { $status='false';}



        DB::table('estructuras')
        ->where('id','=', $idund)
        ->update(['codigo' => $codigo,'nameund' => $nameund,'id_sup' => $id_sup,'id_tipo' => $id_tipo,'status' => $status]);

            $result= DB::table('estructuras as est')
                ->select('est.id AS IDUND', 
                'est.codigo AS CODUND', 
                'est.nameund AS UND', 
                'est.id_sup AS IDSUP', 
                'estsup.codigo AS CODUNDSUP',
                'estsup.nameund AS UNDSUP', 
                'est.id_tipo AS IDTIPO', 
                'tipos.name as NTIPO', 
                'est.status AS STATUS')
                
                ->leftjoin('tipoestructuras as tipos','tipos.id','=','est.id_tipo')
                ->leftjoin('estructuras as estsup','estsup.id','=','est.id_sup')     
                
                
                ->get();
            echo($result);
    }

    #### ELIMINAR UNIDAD
    if($opt==5)
    {   $id_uni=$data['id_uni'];
        DB::beginTransaction();
        try {
            DB::table('estructuras')
                ->where('id','=', $id_uni)
                ->delete();
                
                $result= DB::table('estructuras as est')
                ->select('est.id AS IDUND', 
                'est.codigo AS CODUND', 
                'est.nameund AS UND', 
                'est.id_sup AS IDSUP', 
                'estsup.codigo AS CODUNDSUP',
                'estsup.nameund AS UNDSUP', 
                'est.id_tipo AS IDTIPO', 
                'tipos.name as NTIPO', 
                'est.status AS STATUS')
                
                ->leftjoin('tipoestructuras as tipos','tipos.id','=','est.id_tipo')
                ->leftjoin('estructuras as estsup','estsup.id','=','est.id_sup')                
                ->get();
            echo($result);

        DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            echo 2;
        }
    }

    ### INSERTANDO NUEVA UNIDAD
    if($opt==6)
    {   $data= request()->except('opt');

        DB::beginTransaction();
        try {
           /* $data['codigo'] = $data["codigo"];
            $data['nameund'] = $data["nameund"];
            $data['id_sup'] = $data["id_sup"];
            $data['id_tipo'] = $data["id_tipo"];
            $data['status'] = $data["status"];
            DB::table('estructuras')->insert($data);*/

        $new = new Estructura();
                    $new->codigo = $data["codigo"];
                    $new->nameund = trim($data["nameund"]);
                    $new->id_sup	=  $data["id_sup"];
                    $new->id_tipo	=  $data["id_tipo"];
                    $new->status	=  $data["status"];
                    $new->save();

            $result= DB::table('estructuras as est')
                ->select('est.id AS IDUND', 
                'est.codigo AS CODUND',
                'est.nameund AS UND', 
                'estsup.codigo AS CODUNDSUP', 
                'estsup.nameund AS UNDSUP', 
                'tipos.name as NTIPO', 
                'est.status AS STATUS')            
                ->leftjoin('tipoestructuras as tipos','tipos.id','=','est.id_tipo')
                ->leftjoin('estructuras as estsup','estsup.id','=','est.id_sup')
                ->get();
            echo $result;

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            echo 2;
        }
    }

    if($opt=='lista')
    {
        $data_sups= DB::table('estructuras')->where('id_sup','=','0')->get();
        echo '<select class="form-select form-select-sm" name="id_sup" id="id_sup" aria-label="Default select example">
        <option value="0" selected>Seleccione</option>';
        foreach( $data_sups as $sup )
        { echo '<option value="'.$sup->id.'">'.$sup->nameund .'</option>';
            select_tree_cat_id($sup->id,1);
        }
        echo'</select>';
    }

    if($opt=='pue')
    {
        $sel_ue=$data['sel_ue'];
        $id_unisecc=$data['id_unisecc'];
        $data_vestruc= DB::table('vestructuras')->get();

        $result= DB::table('vestructuras')
            ->select( 'COD_GRUPO','NOM_GRUPO','COD_UNI','NOM_UNI','COD_DEPTO_SUC','NOM_DEPTO_SUC','COD_SECC','NOM_SECC','CONT_UNI','CONT_DEPTO_SUC','CONT_SECC')
            ->where('COD_UNI', '=', $sel_ue)
            ->orderBy('NOM_UNI', 'asc')
            ->get();

        echo '<table class="table table-sm table-bordered" id="MyTable_unidad">
            <thead class="bg-primary">
                <tr>

                <th scope="col" class="text-center text-light bg-primary">DEPARTAMENTO</th>
                <th scope="col" class="text-center text-light bg-primary">SECCIÓN</th>
                </tr>
            </thead>
            <tbody><tr>';
                    $unidad = "";
                    $colspan = 0;
                    $dato_comb="";
                    $depto= "";

            foreach( json_decode($result) as $vestruc )
            {     
                #UNIDAD ECONÓMICA
                /*        if($unidad==""){  
                        $unidad = $vestruc->NOM_UNI;
                        $colspan = $vestruc->CONT_UNI;
                        echo "<td class='align-middle bg-white' rowspan='".$colspan."'><small>".$unidad."<small></td>";
                        }
                        else {
                        if($unidad!=$vestruc->NOM_UNI){  
                            $unidad = $vestruc->NOM_UNI;
                            $colspan = $vestruc->CONT_UNI;
                            echo "<td class='align-middle bg-white' rowspan='".$colspan."'><small>".$unidad."</small></td>";
                        }
                        }*/

                #DEPARTAMENTO
                        if($depto==""){  
                        $depto = $vestruc->NOM_DEPTO_SUC;
                        $colspan = $vestruc->CONT_DEPTO_SUC;
                        echo "<td class='align-middle bg-white' rowspan='".$colspan."'><small>".$depto."<small></td>";
                        }
                        else {
                            if($depto!=$vestruc->NOM_DEPTO_SUC){  
                                $depto = $vestruc->NOM_DEPTO_SUC;
                                $colspan = $vestruc->CONT_DEPTO_SUC;

                                

                                echo "<td class='align-middle bg-white' rowspan='".$colspan."'><small>".$depto."</small></td>";
                            }
                        }

                #SECCION
                $check='';
                if($id_unisecc==$vestruc->COD_SECC){ $check='checked';}
                        if($vestruc->NOM_SECC!=null)
                        { echo '<td class=" bg-light"><small><input style="cursor: pointer" class="form-check-input" type="radio" value="'.$vestruc->COD_SECC.'" name="chk[]" id="chk_'.$vestruc->COD_SECC.'" '.$check.'>
                                    <label style="cursor: pointer" class="form-check-label" for="chk_'.$vestruc->COD_SECC.'">'.$vestruc->NOM_SECC.'</label>
                                    </small>
                                </td> </tr>';
                        }
                        else {
                            echo '<td><small>-</small></td> </tr>';
                        }
            }
            echo '</tbody>
            </table>'; 
    }

    if($opt=='jefe')
    {
        $sel_ue=$data['sel_ue'];
        $id_unisecc=$data['id_unisecc'];
        //$data_vestruc= DB::table('vestructuras')->get();

        $result= DB::table('vestructuraspos as est' )
            ->select( 'est.COD_GRUPO','est.NOM_GRUPO','est.COD_UNI','est.NOM_UNI','est.COD_DEPTO_SUC','est.NOM_DEPTO_SUC','est.COD_SECC','est.NOM_SECC','est.COD_PUE','est.DESC_PUE','est.CONT_UNI','est.CONT_DEPTO_SUC','est.CONT_SECC')
            ->where('est.COD_UNI', '=', $sel_ue)
            ->orderBy('est.NOM_UNI', 'asc')
            ->get();

        echo '<table class="table table-sm table-bordered" id="MyTable_jefe">
            <thead class="bg-primary">
                <tr>
                <th scope="col" class="text-center text-light bg-primary">DEPARTAMENTO</th>
                <th scope="col" class="text-center text-light bg-primary">SECCIÓN</th>
                <th scope="col" class="text-center text-light bg-primary">POSICIÓN DEL JEFE</th>
                </tr>
            </thead>
            <tbody><tr>';
                    $unidad = "";
                    $colspan = 0;
                    $dato_comb="";
                    $depto= "";
                    $secc= "";

            foreach( json_decode($result) as $vestruc )
            {     
                #UNIDAD ECONÓMICA
                /*        if($unidad==""){  
                        $unidad = $vestruc->NOM_UNI;
                        $colspan = $vestruc->CONT_UNI;
                        echo "<td class='align-middle bg-white' rowspan='".$colspan."'><small>".$unidad."<small></td>";
                        }
                        else {
                        if($unidad!=$vestruc->NOM_UNI){  
                            $unidad = $vestruc->NOM_UNI;
                            $colspan = $vestruc->CONT_UNI;
                            echo "<td class='align-middle bg-white' rowspan='".$colspan."'><small>".$unidad."</small></td>";
                        }
                        }*/

                #DEPARTAMENTO
                        if($depto==""){  
                        $depto = $vestruc->NOM_DEPTO_SUC;
                        $colspan = $vestruc->CONT_DEPTO_SUC;
                        echo "<td class='align-middle bg-white' rowspan='".$colspan."'><small>".$depto."<small></td>";
                        }
                        else {
                        if($depto!=$vestruc->NOM_DEPTO_SUC){  
                            $depto = $vestruc->NOM_DEPTO_SUC;
                            $colspan = $vestruc->CONT_DEPTO_SUC;                     

                            echo "<td class='align-middle bg-white' rowspan='".$colspan."'><small>".$depto."</small></td>";
                        }
                        }

                #SECCION
                        if($secc==""){  
                        $secc = $vestruc->NOM_SECC;
                        $colspan = $vestruc->CONT_SECC;  
                        echo "<td class='align-middle bg-white' rowspan='".$colspan."'><small>".$secc."<small></td>";
                        }
                        
                        else {
                            if($secc!=$vestruc->NOM_SECC){  
                            $secc = $vestruc->NOM_SECC;
                            $colspan = $vestruc->CONT_SECC;                     

                            echo "<td class='align-middle bg-white' rowspan='".$colspan."'><small>".$secc."</small></td>";
                            }
                        }
                # PPSICIONES
                        $check='';
                        if($id_unisecc==$vestruc->COD_PUE){ $check='checked';}

                                if($vestruc->COD_PUE!=null){ 
                                echo' <td class=" bg-light">
                                    <small><input style="cursor: pointer" class="form-check-input" type="radio" value="'.$vestruc->COD_PUE.'" name="chkjefe[]" id="chkjefe_'.$vestruc->COD_PUE.'" '.$check.'>
                                    <label style="cursor: pointer" class="form-check-label" for="chkjefe_'.$vestruc->COD_PUE.'">'.$vestruc->DESC_PUE.'</label>
                                    </small>
                                    </td></tr>';
                                }
                                else {
                                echo' <td><small>-</small></td></tr>';
                                }

            }
            echo '</tbody>
            </table>'; 
    }

    if($opt=='sol_vac')
    {
        $sel_ue=$data['sel_ue'];
        $data_CODIGO_UNI= DB::table('estructuras')
        ->select('CODIGO')
        ->where('id','=',$sel_ue)->get();
        $cod_uni='-';
        foreach( $data_CODIGO_UNI as $CODIGO_UNI )
        { $cod_uni=$CODIGO_UNI->CODIGO;}

        $result= DB::select('CALL HC (?)',array($sel_ue));

        echo '<table class="table table-sm table-hover table-bordered">
            <thead class="bg-primary">
                <tr>
                <th class="text-center text-light bg-primary align-middle"><small>DEPARTAMENTO</small></th>
                <th class="text-center text-light bg-primary align-middle"><small>SECCIÓN</small></th>
                <th class="text-center text-light bg-primary align-middle"><small>POSICIONES</small></th>
                <th class="text-center text-light bg-primary align-middle"><small>APRO.</small></th>
                <th class="text-center text-light bg-primary align-middle"><small>REAL</small></th>
                <th class="text-center text-light bg-primary align-middle"><small>SOLICITAR</small></th>
                <th class="text-center text-light bg-primary align-middle"><small>VACANTES</small></th>
                </tr>
            </thead>
            <tbody><tr>';
                    $unidad = "";
                    $colspan = 0;
                    $dato_comb="";
                    $depto= "";
                    $secc= "";
        //var_dump($result);
            $sum_apro=0;
            $sum_real=0;
            foreach( $result as $vestruc )
            {     
                #UNIDAD ECONÓMICA
                #        if($unidad==""){  
                #          $unidad = $vestruc->NOM_UNI;
                #          $colspan = $vestruc->CONT_UNI;
                #          echo "<td class='align-middle bg-white' rowspan='".$colspan."'><small>".$unidad."<small></td>";
                #        }
                #        else {
                #          if($unidad!=$vestruc->NOM_UNI){  
                #            $unidad = $vestruc->NOM_UNI;
                #            $colspan = $vestruc->CONT_UNI;
                #            echo "<td class='align-middle bg-white' rowspan='".$colspan."'><small>".$unidad."</small></td>";
                #          }
                #        }

                #DEPARTAMENTO
                        if($depto==""){  
                        $depto = $vestruc->NOM_DEPTO_SUC;
                        $colspan = $vestruc->CONT_DEPTO_SUC;
                        echo "<td class='align-middle' rowspan='".$colspan."'><small>".$depto."<small></td>";
                        }
                        else {
                        if($depto!=$vestruc->NOM_DEPTO_SUC){  
                            $depto = $vestruc->NOM_DEPTO_SUC;
                            $colspan = $vestruc->CONT_DEPTO_SUC;
                            echo "<td class='align-middle' rowspan='".$colspan."'><small>".$depto."</small></td>";
                        }
                        }

                #SECCION
                #        if($vestruc->NOM_SECC!=null)
                #        {   echo '<td><small>'.$vestruc->NOM_SECC.'</small></td> </tr>';}
                #        else {
                #            echo '<td><small>-</small></td> </tr>';
                #        }
                #SECCION
                        if($secc==""){  
                        $secc = $vestruc->NOM_SECC;
                        $colspan = $vestruc->CONT_SECC;  
                        echo "<td class='align-middle' rowspan='".$colspan."'><small>".$secc."<small></td>";
                        }
                        
                        else {
                            if($secc!=$vestruc->NOM_SECC){  
                            $secc = $vestruc->NOM_SECC;
                            $colspan = $vestruc->CONT_SECC;                     

                            echo "<td class='align-middle' rowspan='".$colspan."'><small>".$secc."</small></td>";
                            }
                        }
                // PPSICIONES
                        $check='';

                                if($vestruc->COD_PUE!=null){ $ver="";
                                $sum_apro=$sum_apro + $vestruc->APROBADO;
                                $sum_real=$sum_real + $vestruc->REAL;
                                
                                echo' <td class="align-middle"><small><span id="div_nom_puest_'.$vestruc->CODIGO_PUE.'">'.$vestruc->DESC_PUE.'</span></small></td>
                                        <td class="text-center align-middle bg-light text-secondary"><b>'.$vestruc->APROBADO.'</b></td>
                                        <td class="align-middle bg-light">
                                            <div class="position-relative editlink" style="width: 100%" onclick=modalcolab("'.$cod_uni.'","'.$vestruc->CODIGO_PUE.'") data-bs-toggle="modal" data-bs-target="#modalcolab">
                                            <div class="position-absolute top-50 start-50 translate-middle"><b>'.$vestruc->REAL.'</b></div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle bg-light"><i class="fas fa-plus-circle fa-lg activar"  onclick=modalsolicitud("'.$cod_uni.'","'.$vestruc->CODIGO_PUE.'","'.$vestruc->COD_PUE.'") data-bs-toggle="modal" data-bs-target="#modalsoli"></i></td>
                                        <td class="text-center align-middle bg-light text-secondary"><b><span id="id_totcant_'.$vestruc->COD_PUE.'">'.$vestruc->TOTCANTIDAD.'</span></b></td>
                                        </tr>';
                                }
                                else {
                                echo' <td><small>-</small></td>
                                        <td class="text-center align-middle bg-light"><small>-</small></td>
                                        <td class="text-center align-middle bg-light"><small>-</small></td>
                                        <td class="text-center align-middle bg-light"><small>-</small></td>
                                        <td class="text-center align-middle bg-light"><small>-</small></td>
                                        </tr>';
                                }

            }
            echo '
            
            </tbody>
                <tr class="bg-primary">
                <th scope="col" class="text-center text-light bg-primary" colspan="3">TOTAL</th>
                <th scope="col" class="text-center text-light bg-primary"><b>'.$sum_apro.'</b></th>
                <th scope="col" class="text-center text-light bg-primary"><b>'.$sum_real.'</b></th>
                <th class="bg-primary"></th>
                <th class="bg-primary"></th>
                </tr>
            </table>'; 
        }

        if($opt=='sol_vac_listcolab')
        {
        $cod_pue="-";
        $sel_ue=$data['sel_ue'];
        if(isset($data['cod_pue']))
        { $cod_pue=$data['cod_pue'];}

            $result= DB::table('colab_pl_rh as col')
                ->select( 'col.NO_EMPLE','col.CEDULA','col.NOMBRE_SEP','col.APELLIDO_SEP')
                ->where('col.COD_PUESTO_RH', '=', $cod_pue)
                ->where('col.COD_UE', '=', $sel_ue)
                ->orderBy('col.NOMBRE_SEP', 'asc')
                ->orderBy('col.APELLIDO_SEP', 'asc')
                ->get();
                echo '<small><table class="table table-striped table-sm table-bordered" id="MyTable_unidad">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center bg-light" >#</th>
                                <th scope="col" class="text-center bg-light">Código</th>
                                <th scope="col" class="text-center bg-light">Cédula</th>
                                <th scope="col" class="text-center bg-light">Nombre</th>
                            </tr>
                            </thead>
                            <tbody id="body_colab">';
                $i=0;
                foreach( $result as $vestruc )
                {
                $i++;  
                echo '<tr>
                        <td class="text-center align-middle bg-light"><small>'.$i.'</small></td>
                        <td class="text-left align-middle bg-white"><small>'.$vestruc->NO_EMPLE.'</small></td>
                        <td class="text-left align-middle bg-white"><small>'.$vestruc->CEDULA.'</small></td>
                        <td class="text-left align-middle bg-white"><small>'.$vestruc->NOMBRE_SEP.' '.$vestruc->APELLIDO_SEP.'</small></td>
                    </tr>';
                }
                echo '</tbody>
                </table></small>';

        }
    }
}
