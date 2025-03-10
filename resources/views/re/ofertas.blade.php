<!DOCTYPE html>
@extends('layouts.plantilla')



@section('content')

<!-- JavaScript -->

<script type="text/javascript">
  // <![CDATA[
   function preloader(){
      document.getElementById("preload").style.display = "none";
      document.getElementById("iframe").style.display = "block";
   }
   //preloader
   window.onload = preloader;
  // ]]>
</script>

        <!-- Javascript -->
        <script src="{{ asset('assetsw/js/jquery-1.11.1.min.js')}}"></script>
        <script src="{{ asset('assetsw/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{ asset('assetsw/js/jquery.backstretch.min.js')}}"></script>
        <script src="{{ asset('assetsw/js/retina-1.1.0.min.js')}}"></script>
        <script src="{{ asset('assetsw/js/scripts.js')}}"></script>
  <!-- Estilo -->


  <style>
    

      
    button.btn { color: #f8f9fa; }
    button.btn:hover { opacity: 0.6; color: #212529; }
    button.btn:active { outline: 0; opacity: 0.6; color: #fff; -moz-box-shadow: none; -webkit-box-shadow: none; box-shadow: none; }
    button.btn:focus,
    button.btn:active:focus,
    button.btn.active:focus { outline: 0; opacity: 0.6; color: #fff; }

    button.btn.btn-next,
    button.btn.btn-next:focus,
    button.btn.btn-next:active:focus, button.btn.btn-next.active:focus { background: #f35b3f; }

    button.btn.btn-submit,
    button.btn.btn-submit:focus,
    button.btn.btn-submit:active:focus, button.btn.btn-submit.active:focus { background: #f35b3f; }

    button.btn.btn-previous,
    button.btn.btn-previous:focus,
    button.btn.btn-previous:active:focus, button.btn.btn-previous.active:focus { background: #bbb; }



    .f1 {
      padding: 25px; background: #fff;
      -moz-border-radius: 4px; -webkit-border-radius: 4px; border-radius: 4px;
    }
    .f1 h3 { margin-top: 0; margin-bottom: 5px; text-transform: uppercase; }

    .f1-steps { overflow: hidden; position: relative; margin-top: 20px; }

    .f1-progress { position: absolute; top: 24px; left: 0; width: 100%; height: 1px; background: #ddd; }
    .f1-progress-line { position: absolute; top: 0; left: 0; height: 1px; background: #f35b3f; }

    .f1-step { position: relative; float: left; width: 20%; padding 0px;}

    .f1-step-icon {
      display: inline-block; width: 40px; height: 40px; margin-top: 4px; background: #ddd;
      font-size: 16px; color: #fff; line-height: 40px;
      -moz-border-radius: 50%; -webkit-border-radius: 50%; border-radius: 50%;
    }
    .f1-step.activated .f1-step-icon {
      background: #fff; border: 1px solid #f35b3f; color: #f35b3f; line-height: 38px;
    }
    .f1-step.active .f1-step-icon {
      width: 48px; height: 48px; margin-top: 0; background: #f35b3f; font-size: 22px; line-height: 48px;
    }

    .f1-step p { color: #ccc; }
    .f1-step.activated p { color: #f35b3f; }
    .f1-step.active p { color: #f35b3f; }
    .f1 fieldset { display: none; text-align: left; }
    .f1 fieldset { text-align: left; }

    .mayusc{
        text-transform: uppercase;
    }
  </style>
  
<style>
    div#iframe {
      display: none;
    }
    div#preload {
      cursor: wait;
    }
</style>
<!-- <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
<link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">-->
<div class="card">
  <div class="card-header pb-0">
    <h4><i class="fas fa-users-cog"></i> Ofertas Laborales</h4>
  </div>
  <div class="card-body">
    <small>
      <div id="preload" class="align-items-center justify-content-center text-center"><div class="spinner-border spinner-border-sm text-primary" role="status"></div></div>
    </small>
      <!-- LISTADO PRINCIPAL OFERTAS LABORALES-->
      <div id="iframe" style="display: none;">


        @foreach($data_ofertas as $ofertas)
          @php
            $fsol=explode("-", $ofertas->fecha_sol);
            $fcie=explode("-", $ofertas->fecha_tope);
            $hoy = date("Y-m-d"); 
             $mensaje='';
            
            if($ofertas->fecha_tope<$hoy)
            { $mensaje='<span class="text-danger"><i class="far fa-clock fa-spin"></i> Solicitud vencida</span>';  }

            $boder="border-primary";
            if($ofertas->id_estatus==1)
            { $link='
              <div class="dropdown py-0">
                <button class="btn btn-warning text-dark btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                  Acciones  
                </button>
                <ul class="dropdown-menu p-0" aria-labelledby="dropdownMenu2">
                  <li><button class="dropdown-item" type="button"  onclick="busca_ofl('.$ofertas->id.')" data-bs-toggle="modal" data-bs-target="#modalsoli">'.$ofertas->icono.' Ver Solicitud</button></li>
                </ul>
              </div>';
              $boder="border-warning";
              }
            if($ofertas->id_estatus==2)
            { $link='
              <div class="dropdown py-0">
                <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                  Acciones  
                </button>
                <ul class="dropdown-menu p-0" aria-labelledby="dropdownMenu2">
                  <li><button class="dropdown-item" type="button" onclick="mod_prospectos('.$ofertas->id.')" data-bs-toggle="modal" data-bs-target="#modalprooectos">'.$ofertas->icono.' Ver Candidatos</button></li>
                  <li><button class="dropdown-item" type="button" onclick="newpart()" data-bs-toggle="modal" data-bs-target="#modalnuevoprooectos"><i class="fas fa-user-plus text-success"></i> Nuevo Candidato</button></li>
                </ul>
              </div>';
            }
          @endphp

        <div class="row border @php echo $boder @endphp my-2 p-2 rounded oflinfo">
          
          <div class="row">
            <div class="col-11">
              <h6 class="mb-0 text-primary">
                <small><b>#{{$ofertas->id}} <span id="despue_{{$ofertas->id}}">{{$ofertas->descpue}}</span></b>, 
                <small> {{$ofertas->unidad_economica}}</small></small>
              </h6>
            </div>
            <div class="col-1 d-grid gap-4 d-md-flex justify-content-md-end">
              <input id="name_{{$ofertas->id}}" value="{{$ofertas->name}}" type="hidden">                    
                <span id="divico_{{$ofertas->id}}">
                      @php echo $link; @endphp
                </span>              
            </div>
            <span class="text-secondary">
              <small>
                <small> Fecha de solicitud: <span id="fech_sol_{{$ofertas->id}}">{{$fsol[2].'-'.$fsol[1].'-'.$fsol[0]}} </span>
                        <span class="ps-3">Fecha de vencimiento: <span id="fech_tope_{{$ofertas->id}}">{{$fcie[2].'-'.$fcie[1].'-'.$fcie[0]}}</span>
                        <span class="ps-3"> @php echo $mensaje; @endphp</span>
                </small>
              </small>
            </span>
            </span>
          </div>
  
          <hr class="my-0">
          <small><small>
            <div class="row text-secondary mt-1" id="div_status_ofl">
              <div class="col">
                <div class="text-center">
                  <b><span id="cantsol_{{$ofertas->id}}">{{$ofertas->cantidad}}</span></b>
                </div>
                <div class="text-center">Vacantes</div>
              </div>
              <div class="col text-center">
                <div class="">
                  <b><span id="cantpart_{{$ofertas->id}}">{{$ofertas->proceso}}</span></b>
                </div>
                <div class="text-center">Candidatos</div>
              </div>
 
              <div class="col text-center">                
                  <b><div id="cantinicial_{{$ofertas->id}}">{{$ofertas->incial}}</div></b>                
                <div class="badge bg-secondary"><i class="fas fa-street-view"></i> Ent. Inicial</div>                
              </div>

              <div class="col text-center">
                <b><div id="cantfuncional_{{$ofertas->id}}">{{$ofertas->funcional}}</div></b>
                <div class="badge bg-info"><i class="fas fa-user-tie"></i> Ent. Funcional</div>
              </div>

              <div class="col text-center">
                <div class="text-center">
                  <b><span id="cantofertalaboral_{{$ofertas->id}}">{{$ofertas->ofertalaboral}}</span></b>
                </div>
                <div class="badge bg-primary"><i class="fas fa-user-clock"></i> Oferta Laboral</div>
              </div>
              
              <div class="col text-center">
                  <b><div id="cantdocumentacion_{{$ofertas->id}}">{{$ofertas->documentacion}}</div></b>
                <div class="badge bg-warning text-dark"><i class="far fa-address-book"></i> Documentación</div>
              </div>

              <div class="col text-center">
                  <b><div id="cantfirma_{{$ofertas->id}}">{{$ofertas->firma}}</div></b>
                <div class="badge bg-success"><i class="fas fa-user-check"></i> Firma de Contrato</div>
              </div>
              
              <div class="col text-center">
                  <b><div id="cantcont_{{$ofertas->id}}">{{$ofertas->contratado}}</div></b>
                <div><span style="background-color:#0BC114;" class="badge"><i class="fas fa-check-double"></i>Contratados</div>

              </div>
            </div>
          </small></small>

        </div>
          @endforeach

          <!-- -->
      </div>
  </div>
</div> 

    <!-- Modal solicitudes de vacantes-->
    <div class="modal fade" id="modalsoli" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg  modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header bg-light">
            <h5 class="modal-title text-primary" id="staticBackdropLabel"><i class="fa-solid fa-users-viewfinder fa-lg text-secondary"></i> Detalle de la Solicitud</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">        
            <div class="form-group row mb-2">      
              <label for="sel_status" class="col-sm-3 col-form-label-sm">Estatus:</label>
              <div class="col-sm-3"> 
                <select id="sel_status" class="form-select form-select-sm">
                  @foreach( $data_vacstatus as $vacstatus )
                    <option value="{{ $vacstatus->id }}">{{ $vacstatus->estatus}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group row mb-2">
              <label class="col-sm-3 col-form-label-sm"># de solicitud: </label>            
              <div class="col-sm-2"> 
                <label id="lb_id_sol" class="col-sm-4 col-form-label"></label>
                <input type="hidden" id="id_ofl_txt" value=""> 
              </div>
            </div>

              <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label-sm">Fecha de solicitud: </label>   
                <div class="col-sm-2">  
                  <input  id="lb_f_sol" class="form-control form-control-sm" type="text" value="" aria-label="Disabled input example" disabled readonly> 
                </div>
              </div>

              <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label-sm">Fecha de límite: </label>   
                <div class="col-sm-2">  
                  <input  id="lb_f_lim" class="form-control form-control-sm" type="text" value="" aria-label="Disabled input example" disabled readonly>          
                </div>
              </div>

              <div class="form-group row mb-2">          
                <label class="col-sm-3 col-form-label-sm">PAGADORA:</label>            
                <div class="col-sm-8"> 
                    <input  id="lb_PAGADORA" class="form-control form-control-sm" type="text" value="" aria-label="Disabled input example" disabled readonly>
                </div>
              </div>

              <div class="form-group row mb-2">          
                <label class="col-sm-3 col-form-label-sm">Centro de costo:</label>            
                <div class="col-sm-8"> 
                    <input  id="lb_ceco" class="form-control form-control-sm" type="text" value="" aria-label="Disabled input example" disabled readonly>
                </div>
              </div>

              <div class="form-group row mb-2">          
                <label class="col-sm-3 col-form-label-sm">Unidad económica:</label>            
                <div class="col-sm-8"> 
                    <input  id="lb_ue" class="form-control form-control-sm" type="text" value="" aria-label="Disabled input example" disabled readonly>
                </div>
              </div>

              <div class="form-group row mb-2">        
                  <label class="col-sm-3 col-form-label-sm">Sección:</label>         
                  <div class="col-sm-8">    
                    <input  id="lb_secc" class="form-control form-control-sm" type="text" value="" aria-label="Disabled input example" disabled readonly>
                </div>
              </div>

              <div class="form-group row mb-2">      
                  <label class="col-sm-3 col-form-label-sm">Posición:</label>        
                  <div class="col-sm-8">            
                    <input  id="lb_nom_posicion_sol" class="form-control form-control-sm" type="text" value="" aria-label="Disabled input example" disabled readonly>
                </div>
              </div>

              <div class="form-group row mb-2">
                  <label class="col-sm-3 col-form-label-sm">Cantidad solicitada:</label>
                  <div class="col-sm-1">   
                    <label id="lb_cant" class="col-sm col-form-label text-danger fw-bold"></label>            
                  </div>
                  <label class="col-sm-auto col-form-label-sm">Aprobado:</label>
                  <label  id="lb_aprobado" class="col-sm col-form-label fw-bold"></label>
                  <label class="col-sm-auto col-form-label-sm">Real:</label>
                  <label  id="lb_real" class="col-sm col-form-label fw-bold"></label>
              </div>

              

              <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label-sm">Género:</label>
                <div class="col-sm-3">
                  <input  id="lb_genero" class="form-control form-control-sm" type="text" value="" aria-label="Disabled input example" disabled readonly>
                </div>        
              </div>

              <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label-sm">Rango de edad:</label>
                <div class="col-sm-3">
                  <input  id="lb_edad" class="form-control form-control-sm" type="text" value="" aria-label="Disabled input example" disabled readonly>
                </div>          
              </div>
            
              <div class="form-group row mb-2">          
                <label class="col-sm-3 col-form-label-sm">Motivo de la solicitud:</label>
                <div class="col-sm-6">
                  <input  id="lb_motivo" class="form-control form-control-sm" type="text" value="" aria-label="Disabled input example" disabled readonly>
                  <label id="lb_doc_aut" class="col-sm col-form-label col-form-label-sm">autorización</label>
                </div>
              </div>

              <div class="col-sm-12 mb-2">
                <label  class="form-label col-form-label-sm">Comentarios adicionales:</label>
                <textarea class="form-control form-control-sm" id="lb_coment" rows="3" disabled readonly></textarea>
              </div>        
              <div class="col-sm-6">
                <label class="form-label col-form-label-sm">Solicitado por: </label>
                <label id="lb_por" class="col-sm col-form-label col-form-label-sm"></label>
              </div>
          </div>
          <div class="modal-footer bg-light">        
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cancelar</button>
            <button type="button" class="btn btn-primary btn-sm" onclick="su()" id="bto_guarda" style="display: block"><i class="fas fa-save"></i> Guardar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Rechaza vacantes-->
    <div class="modal fade" id="Modal_del" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-light">
            <h5 class="modal-title text-primary" id="staticBackdropLabel"><i class="fas fa-ban fa-lg text-danger"></i> Rechazar Solicitud</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label-sm"># de solicitud: </label>            
                <div class="col-sm-2"> 
                  <label id="lb_id_sol_rech" class="col-sm-4 col-form-label fw-bold"></label>
                </div>
              </div>
              <div class="form-group row mb-2">      
                <label class="col-sm-3 col-form-label-sm">Posición:</label>        
                <div class="col-sm-8">            
                  <input  id="lb_nom_posicion_sol_rech" class="form-control form-control-sm" type="text" value="" aria-label="Disabled input example" disabled readonly>
                </div>
              </div>  

              <div class="form-group row mb-2">
                <label class="col-sm-3 col-form-label-sm">Cantidad solicitada:</label>
                <div class="col-sm-2">              
                  <input  id="lb_cant_rech" class="form-control form-control-sm" type="text" value="" aria-label="Disabled input example" disabled readonly>
                </div>
              </div>
              <div class="mb-3">
                <label class="col-sm-auto col-form-label-sm">Explicar el motivo por la cual se esta rechazando la solicitud</label>
    
                <textarea class="form-control" id="txt_area_observacion" name="txt_area_observacion" tabindex="-2"></textarea>
              </div>
              
              <div class="mb-3">
                <label class="col-sm-auto col-form-label-sm"><b>Nota:</b> El solicitante será notificado.</label>
              </div>
            </form>
          </div>
          <div class="modal-footer bg-light">        
            <button type="button" onclick="$('#Modal_del').modal('hide');$('#modalsoli').modal('show');" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cancelar</button>
            <button type="button" class="btn btn-danger btn-sm" onclick="re()" id="bto_guarda" style="display: block"><i class="fas fa-ban fa-lg pr-2"></i> Rechazar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal prospectos-->
    <div class="modal fade" id="modalprooectos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header bg-light">
            <h5 class="modal-title text-primary" id="staticBackdropLabel"><i class="fas fa-users fa-lg text-secondary"></i> <span id="lb_numofl"></span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="form-group row">      
              <label id="lb_posicion" class="col-sm-6 col-form-label-sm"></label>  
              <label id="lb_por_part" class="col-sm-6 col-form-label-sm"></label>
              <label id="lb_fech_sol" class="col-sm-6 col-form-label-sm"></label>  
              <label id="lb_fech_tope" class="col-sm-6 col-form-label-sm"></label>
              <label id="lb_cant_part" class="col-sm-4 col-form-label-sm"></label>
              <label id="lb_proceso_part" class="col-sm-4 col-form-label-sm"></label> 
              <label id="lb_cont_part" class="col-sm-4 col-form-label-sm"></label>
            </div> 
            <hr>
            <div class="card">
            <!-- ------------------- -->
              <div class="card-header" id="id_card_parti_list">
                <div class="row mb-2">
                  <div class="col-6"><h5 class="text-primary mb-2 mr-2"><b>Candidatos</b></h5></div>
                  <div class="col-4 text-end">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal"><i class="far fa-address-book pr-2"></i> Buscar en BD</button>
                  </div>

                </div>

                <small>
                  <table class="table table-hover table-sm table-striped table-bordered" id="table_prospectos">
                    <thead>
                      <tr>
                        <th class="text-light text-center bg-info">Cédula/Pasaporte</th>
                        <th class="text-light text-center bg-info">Nombre</th>
                        <th class="text-light text-center bg-info">Tel.</th>
                        <th class="text-light text-center bg-info">Correo</th>
                        <th class="text-light text-center bg-info">Estatus</th>
                        <th class="text-light text-center bg-info"><i class="fas fa-cog"></i></th>
                      </tr>
                    </thead>
                    <tbody id="tbody_aspirantes">
                        
                    </tbody>
                  </table>
                </small>
              </div>
              <!-- ------------------- -->
            </div>
          </div>
          <div class="modal-footer bg-light"> 
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cerrar</button>
          </div>
        </div>
      </div>
    </div>


<!-- Modal etapas contratación -->
   <div class="modal fade" id="modaletapas_cont" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header bg-light py-1">
          <h5 class="modal-title text-primary" id="staticBackdropLabel"><i class="fas fa-user-cog fas-lg text-secondary"></i> <span id="lb_numofl_etapa_contra"></span></h5>
          <div class="d-grid gap-4 d-md-flex justify-content-md-end">
              <button type="button" class="btn btn-sm btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#modalprooectos"><i class="fas fa-times"></i> Cerrar</button>
          </div>
        </div>
          
          
        <div class="modal-body bg-light">
            <!-- ------------------- -->
                <small>   
                  <div class="border bg-secondary bg-opacity-10 border border-info rounded p-2">
                    <div class="form-group row">      
                      <label id="lb_nom_completo" class="col-sm-5 col-form-label-sm"></label>  
                      <label id="lb_cedula" class="col-sm-3 col-form-label-sm"></label> 
                      <label id="lb_f_nacimiento" class="col-sm-4 col-form-label-sm"></label>
                      <label id="lb_mail" class="col-sm-5 col-form-label-sm"></label>
                      <label id="lb_tel" class="col-sm-3 col-form-label-sm"></label>  
                      <label id="lb_nacionalidad" class="col-sm-4 col-form-label-sm"></label>
                      <label id="lb_dir" class="col-sm-8 col-form-label-sm"></label>                     
                      <label id="lb_desc_cv" class="col-sm-4 col-form-label-sm"></label>
                    </div>

                    <span id="ls_secc_docpermiso_trab">
                      <div class="form-group row mt-2">
                        <div class="fw-bold">Permiso de Trabajo</div>
                        <label id="lb_tipo_permiso" class="col-sm-5 col-form-label-sm"></label>  
                        <label id="lb_f_venci_permiso" class="col-sm-3 col-form-label-sm"></label>
                        <label id="lb_desc_permiso" class="col-sm-4 col-form-label-sm"></label>
                      </div>
                    </span>
                  </div>
                  <!-- Etapas del proceso -->
                <small>
                <div class="form-group row text-dark">                    
                      <form role="form" action="" method="post" class="f1  bg-light">
                        <input id="txt_paso" type="hidden" value='1'></input>
                        <div class="f1-steps" id="div_pasos">
                          <div class="f1-progress">
                              <div id="line_progress" class="f1-progress-line" data-now-value="10" data-number-of-steps="5" style="width: 10%;"id="firstline"></div>
                          </div>
                          <div class="f1-step text-center active" id="paso_1">
                            <div class="f1-step-icon"><i class="fas fa-street-view"></i></div>
                            <p>1. Entrevista Inicial</p>
                          </div>
                          <div class="f1-step text-center" id="paso_2">
                            <div class="f1-step-icon"><i class="fas fa-people-arrows"></i></div>
                            <p>2. Entrevista Funcional</p>
                          </div>
                          <div class="f1-step text-center" id="paso_3">
                            <div class="f1-step-icon"><i class="fas fa-comments-dollar"></i></div>
                            <p>3. Presentación de oferta laboral</p>
                          </div>
                          <div class="f1-step text-center" id="paso_4">
                            <div class="f1-step-icon"><i class="fas fa-file-import"></i></div>
                            <p>4. Documentación</p>
                          </div>
                          <div class="f1-step text-center" id="paso_5">
                            <div class="f1-step-icon"><i class="fas fa-file-contract"></i></div>
                            <p>5. Firma de contrato</p>
                          </div>
                        </div>
                        <!-- Entrevista Inicial -->
                        <fieldset id="div_2">
                          <div class="my-3">     
    
                            <div class="modal-header bg-light py-1">
                              <h5 class="text-primary">1. Entrevista Inicial</h5>
                              <div class="d-grid gap-4 d-md-flex justify-content-md-end">
                                  <button type="button" class="btn btn-sm btn-danger" onclick="noprocede(2)" translate><i class="fas fa-user-times fa-lg"></i>  Descartar Candidato </button>                                  
                              </div>
                            </div>
                              
                                <div class="card">
                                  <div class="card-header py-2 pb-0">
                                    <h6 class="text-secondary fw-bold"><i class="fa-solid fa-user-check text-info fa-lg"></i> Validación de referencias laborales</h6>
                                  </div>
                                  <div class="card-body">
                                    <div class="row mb-3">
    
                                      <div class="col-md-3 mb-3 mt-2">
                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="ref_sino[]" id="ref_N" value="N" checked  onclick="showval_ref()">
                                          <label class="form-check-label" for="ref_N">No tiene referencias, es el primer trabajo.</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="ref_sino[]" id="ref_S" value="S" onclick="showval_ref()">
                                          <label class="form-check-label" for="ref_S">Si tiene referencias laborales.</label>
                                        </div>
                                      </div>
                                    </div>
                                    <div id="div_referencias_val" style="display: none">
                                      <div class="form-group row mb-3">
                                        <p class="text-secondary fw-bold">Registrar validación de las referencias contactadas</p>
                                        <div class="col-sm-2">
                                          <input type="text" class="form-control form-control-sm" id="valida_exp_entidad" placeholder="Entidad">
                                        </div>                   
                                        <div class="col-sm-2">
                                          <input type="text" class="form-control form-control-sm" id="valida_exp_nombre" placeholder="Nombre">
                                        </div>                        
                                        <div class="col-sm-2">
                                          <input type="text" class="form-control form-control-sm" id="valida_exp_puesto" placeholder="Puesto">
                                        </div>
                                        <div class="col-sm-2">
                                          <input type="text" class="form-control form-control-sm" id="valida_exp_contacto" placeholder="Contacto">
                                        </div>
                                        <div class="col-sm-3">
                                          <textarea class="form-control form-control-sm" id="valida_exp_comentario" placeholder="Comentarios"></textarea>
                                        </div>
                                        <span class="col-sm-1 text-end">
                                          <i class="fas fa-plus-square fa-2x activar mt-1" title="Agregar"  onclick="addrow('valreflaboral')"></i>
                                        </span>
                                      </div>
    
                                      <table class="table table-sm table-striped table-hover table-bordered" id="table_valreflaboral">
                                        <thead>
                                          <tr>
                                            <th class="text-center text-light bg-primary" width="17%">Entidad</th>
                                            <th class="text-center text-light bg-primary" width="17%">Nombre</th>
                                            <th class="text-center text-light bg-primary" width="17%">Puesto</th>
                                            <th class="text-center text-light bg-primary" width="17%">Contacto</th>
                                            <th class="text-center text-light bg-primary" width="30%">Comentarios</th>
                                            <th class="text-center text-light bg-primary" width="2%"><i class="fas fa-cog"></i></th>
                                          </tr>
                                        </thead>
                                        <tbody id="tbody_valreflaboral">
                                          
                                          
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                </div>
                              
                                <div class="card">
                                  <div class="card-header py-2 pb-0">
                                    <h6 class="text-secondary fw-bold"><i class="fas fa-brain text-success fa-lg"></i> Prueba Psicométrica</h6>
                                  </div>
                                  <div class="card-body">
                                    <div class="form-group row my-3">
                                      <label for="sel_evaluacion_aplicada" class="col-sm-auto col-form-label-sm">Evaluación a aplicar: </label>
                                      <div class="col-sm-3"> 
                                        <select id="sel_evaluacion_aplicada" class="form-select form-select-sm" onchange="find_respsico(this.value,'')">
                                         
                                        </select>
                                      </div>
                                      <label class="col-sm-auto col-form-label-sm">Fecha de envío: </label>   
                                      <div class="col-sm-2">  
                                        <input  id="f_envio_prueba" name="f_envio_prueba" class="form-control form-control-sm" type="date"> 
                                      </div>
    
                                      <label class="col-sm-auto col-form-label-sm">Resultado: </label>            
                                      <div class="col-sm-2" id="iddiv_resul_psico"> 
                                        <input type="text" class="form-control form-control-sm" max="30" id="pruebapsico_resultado" value="" disabled> 
                                      </div>
                                      
                                      <span class="col-sm-1 text-end">
                                        <i class="fas fa-plus-square fa-2x activar mt-1" title="Agregar"  onclick="addrow('pruebaspsico')"></i>
                                      </span>
                                    </div>
                                    <div class="row">
                                      <div class="col-2">  </div>
                                      <div class="col"> 
                                        <table class="table table-sm table-striped table-hover table-bordered" id="table_pruebaspsico">
                                          <thead>
                                            <tr>
                                              <th class="text-center text-light bg-primary" width="17%">Prueba</th>
                                              <th class="text-center text-light bg-primary" width="17%">Fecha de envío</th>
                                              <th class="text-center text-light bg-primary" width="17%">Resultado</th>
                                              <th class="text-center text-light bg-primary" width="2%"><i class="fas fa-cog"></i></th>
                                            </tr>
                                          </thead>
                                          <tbody id="tbody_pruebaspsico">
                                          </tbody>
                                        </table>
                                      </div>
                                      <div class="col-2">  </div>
                                    </div>
                                  </div>     
                                </div>                          
                              
                                <div class="card">
                                  <div class="card-header py-2 pb-0">
                                    <h6 class="text-secondary fw-bold"><i class="fas fa-shield-alt text-danger fa-lg"></i> Validación de documentos de seguridad</h6>
                                  </div>
                                  <div class="card-body">
                                    <div class="form-group row mb-3">
                                      <legend class="col-form-label col-sm-2 pt-0"></legend>
                                        <div class="row mb-2">                    
                                          <div class="col-6">
                                            <label for="filerecord" class="form-label form-label-sm">Adjuntar récord policivo:</label>
                                            <span id="div_record">
                                              <input class="form-control form-control-sm file" name="filerecord" id="filerecord" type="file" accept=".doc,.pdf,image/*"  onchange="sube_file('record')">
                                            </span>
                                            <span id="divdesc_record">
                                            </span>
                                          </div> 
                                            
                                        </div>
                                    </div>
                                  </div>
                                </div>
                            
                          </div>    
                          <div class="f1-buttons d-grid gap-4 d-md-flex justify-content-md-end">
                            <span class="text-danger pt-2"> <h6> <span id="msn_sig_p_1"></span></h6></span>
                            <button type="button" class="btn btn-sm btn-next" id="step_2"><i class="fa-solid fa-arrow-right pr-2"></i> Siguiente</button>
                          </div>
                        </fieldset>
                        <!-- Entrevista funcional -->
                        <fieldset id="div_3">
                          <div class="my-3">
                             
                            <div class="modal-header bg-light py-1">
                              <h5 class="text-primary">2. Entrevista Funcional</h5>
                              <div class="d-grid gap-4 d-md-flex justify-content-md-end">
                                  <button type="button" class="btn btn-sm btn-danger" onclick="noprocede(3)" translate><i class="fas fa-user-times fa-lg"></i>  Descartar Candidato </button>                                  
                              </div>
                            </div>
                            <div class="card">

                              <div class="card-header py-2 pb-0">    
                                <h6 class="text-secondary fw-bold"><i class="fas fa-user-clock text-primary fa-lg"></i> Planificación de entrevistas</h6>             
                              </div>
                              <div class="card-body">
                                <div class="row mb-3">
                                  <div class="col-md-3 mb-3 mt-2">
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="entre_sino[]" id="entre_N" value="N" checked  onclick="showentre()">
                                      <label class="form-check-label" for="entre_N">No aplica para entrevistas funcionales.</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="entre_sino[]" id="entre_S" value="S" onclick="showentre()">
                                      <label class="form-check-label" for="entre_S">Si aplica entrevitas funcionales</label>
                                    </div>
                                  </div>
                                </div>
                                <div id="div_entrevistas" style="display: none">

                                  <div class="form-group row mt-3 mb-3">
                                    <label for="sel_entrevista_por" class="col-sm-auto col-form-label-sm">Entrevista por:</label>
                                    <div class="col-sm-4"> 
                                      <select class="form-select form-select-sm" aria-label=".form-select-sm example"  name="sel_entrevistador" id="sel_entrevistador">
                                        <option selected>Seleccione</option>
                                        @foreach( $data_users_entrevistas as $users_entrevistas)                
                                            <option value="{{ $users_entrevistas->id}}">{{ $users_entrevistas->name}} - {{ $users_entrevistas->puesto}}</option>                                       
                                          @endforeach 
                                      </select>
                                    </div>                        
                                    <label for="sel_fecha" class="col-sm-auto col-form-label-sm">Fecha:</label>
                                    <div class="col-sm-auto">
                                      <input type="date" class="form-control form-control-sm" id="sel_fecha">
                                    </div>
                                    <label for="sel_hora" class="col-sm-auto col-form-label-sm">Hora:</label>
                                    <div class="col-sm-auto">
                                      <input type="time" class="form-control form-control-sm" id="sel_hora">
                                    </div>
                                    <span class="col-sm-2 text-end">
                                      <i class="fas fa-plus-square fa-2x activar mt-1" title="Agregar" onclick="addrow_entrevista()"></i>
                                    </span>
                                  </div>
                           
                                  <div class="justify-content-center" id="div_entrvistas_funcionales" style="display: none"> 
                                    <div class="col-4 alert alert-warning" >                          
                                      <i class="fa-solid fa-triangle-exclamation fa-lg"></i> Es necesario llenar todos los campos.                        
                                    </div>
                                  </div>

                                  <div class="row mt-3 mb-3">
                                    <div class="col">
                                      <table class="table table-sm table-striped table-hover"  id="table_entrefuncional">
                                        <thead>
                                          <tr>
                                            <th class="text-center text-light bg-primary">Entrevista por</th>
                                            <th class="text-center text-light bg-primary">Email</th>
                                            <th class="text-center text-light bg-primary">Puesto</th>
                                            <th class="text-center text-light bg-primary">Fecha y hora</th>
                                            <th class="text-center text-light bg-primary">Notificar</th>
                                            <th class="text-center text-light bg-primary"><i class="fas fa-cog"></i></th>
                                          </tr>
                                        </thead>
                                        <tbody id="tbody_entrefuncional">                            
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>

                                </div>
                              </div>
                            </div>
                          </div>
                          
                          <div class="f1-buttons d-grid gap-4 d-md-flex justify-content-md-end">
                            <span class="text-danger pt-2"> <h6> <span id="msn_sig_p_3"></span></h6></span>
                            <button type="button" class="btn btn-sm btn-previous"><i class="fa-solid fa-arrow-left pr-2"></i> Anterior</button>
                            <button type="button" class="btn btn-sm btn-next"id="step_3"><i class="fa-solid fa-arrow-right pr-2"></i> Siguiente</button>
                          </div>

                        </fieldset>
                        <!-- Presentación de oferta laboral -->
                        <fieldset id="div_4">
                          <div class="my-3">
                            
                            <div class="modal-header bg-light py-1">
                              <h5 class="text-primary">3. Presentación de oferta laboral</h5>
                              <div class="d-grid gap-4 d-md-flex justify-content-md-end">
                                  <button type="button" class="btn btn-sm btn-danger" onclick="noprocede(4)" translate><i class="fas fa-user-times fa-lg"></i>  Descartar Candidato </button>                                  
                              </div>
                            </div>
                            
                              <div class="card">
                                <div class="card-header py-2 pb-0">
                                  <h6 class="text-secondary fw-bold"><i class="fas fa-hand-holding-usd text-success fa-lg"></i> Propuesta Salarial</h6>   
                                </div>
                                <div class="card-body">

                                  <h6 class="text-secondary fw-bold pt-4"> Remuneraciones </h6>
                                  <div class="row my-3">      
                                    <div class="form-group row mt-3 mb-3">
                                      <label class="col-sm-auto col-form-label-sm">Salario Mensual: </label>   
                                      <div class="col-sm-2">  
                                        <input  id="txt_salario"name="txt_salario" class="form-control form-control-sm" type="number" placeholder="0.00"> 
                                      </div>
                                      <label for="sel_tipo_salario" class="col-sm-auto col-form-label-sm">Tipo de Salario: </label>
                                      <div class="col-sm-3"> 
                                        <select id="sel_tipo_salario" class="form-select form-select-sm">
                                          <option value="0" selected>Seleccione</option>
                                          <option value="B" >Sueldo Base</option>
                                          <option value="H" >Sueldo por Hora</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="row my-3">                                    
                                      <label for="sel_tipo_contrato" class="col-sm-auto col-form-label-sm">Tipo de contrato: </label>
                                      <div class="col-sm-3"> 
                                        <select id="sel_tipo_contrato" class="form-select form-select-sm" onchange="hab_f_terminacion(this.value)" >
                                          <option value="P" selected>Indefinido</option>
                                          <option value="T" >Definido</option>
                                        </select>
                                      </div>
                                      <label class="col-sm-auto col-form-label-sm">Fecha de ingreso: </label>   
                                      <div class="col-sm-2">  
                                        <input  id="f_ingreso" name="f_ingreso" class="form-control form-control-sm" type="date"> 
                                      </div>
                                        <label class="col-sm-auto col-form-label-sm" id="lb_f_terminacion" style="display: none">Fecha de terminación: </label>   
                                        <div class="col-sm-2">  
                                          <input  id="f_terminacion" name="f_terminacion" class="form-control form-control-sm" type="date" style="display: none"> 
                                        </div>
                                    </div>
                                    <!-- <div class="form-group row mt-3 mb-3"> 
                                          
                                          <div class="quill-editor-full mb-3">                                
                                          
                                          </div>
                                          End Quill Editor Full 
                                        </div>-->
                                  </div>

                                  
                                  <div class="row my-3" style="display: none">
                                    <h6 class="text-secondary fw-bold pt-4">Compensación y Beneficios</h6>
                                    <div class="row mb-3">              
                                      <div class="col-md-3 mb-3 mt-2">
                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="compen_sino[]" id="compen_N" value="N" checked  onclick="showcompen()">
                                          <label class="form-check-label" for="compen_N">No aplica compensación y beneficios.</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="compen_sino[]" id="compen_S" value="S" onclick="showcompen()">
                                          <label class="form-check-label" for="compen_S">Si aplica compensación y beneficios.</label>
                                        </div>
                                      </div>
                                    </div>
                                    <div id="div_compensaciones" style="display: none">
    
                                      <div class="form-group row mt-3 mb-3  justify-content-md-center">
                                        <label for="sel_compensacion" class="col-sm-auto col-form-label-sm">Tipo de compensación:</label>
                                        <div class="col-sm-4"> 
                                          <select class="form-select form-select-sm" aria-label=".form-select-sm example"  name="sel_compensacion" id="sel_compensacion">
                                            <option selected>Seleccione</option>

                                          </select>
                                        </div>                        
                                      
                                        
                                        <span class="col-sm-2 text-end">
                                          <i class="fas fa-plus-square fa-2x activar mt-1" title="Agregar" onclick="addrow_compensaciones()"></i>
                                        </span>
                                      </div>
                              
                                      <div class="justify-content-center" id="div_msn_compensaciones" style="display: none"> 
                                        <div class="col-4 alert alert-warning" >                          
                                          <i class="fa-solid fa-triangle-exclamation fa-lg"></i> Es necesario llenar todos los campos.                        
                                        </div>
                                      </div>
                                      <div class="row mt-3 mb-3 justify-content-md-center">
                                        <div class="col-8">
                                          <table class="table table-sm table-striped table-hover"  id="table_compensaciones">
                                            <thead>
                                              <tr>
                                                <th class="text-center text-light bg-primary">Tipo de compensación</th>
                                                <th class="text-center text-light bg-primary">condiciones</th>
                                                
                                                <th class="text-center text-light bg-primary"><i class="fas fa-cog"></i></th>
                                              </tr>
                                            </thead>
                                            <tbody id="tbody_compensaciones">                            
                                            </tbody>
                                          </table>
                                        </div>
                                      </div>  
                                    </div>
                                        
                                    <hr>
                                    
                                  </div>  
                                  <div class="row my-3">

                                    <div id="idformulario"></div>
                                    <div class="row mt-3 mb-3 justify-content-md-center">
                                      <div class="col-6">
                                        <div class="row  pt-3 justify-content-md-left">
                                      <div class="col col-lg-auto text-left">
                                        <button type="button" class="btn btn-success btn-sm mb-2" target="_blank" onclick="genera_cartaol()"><span id="div_bto_generacarta"><i class="fas fa-plus"></i> Nueva oferta laboral</span></button>
                                      </div>
                                    </div>
                                        <table class="table table-sm table-hover"  id="table_cartasofl">
                                          <thead>
                                            <tr>
                                              <th class="text-center text-light bg-primary">#</th>
                                              <th class="text-center text-light bg-primary">Salario</th>
                                              <th class="text-center text-light bg-primary">F. Inicio</th>
                                              <th class="text-center text-light bg-primary">F. Terminación</th>
                                              <th class="text-center text-light bg-primary">Descargar Carta Oferta</th>  
                                      <!--        <th class="text-center text-light bg-primary">Descargado por</th>    
                                              <th class="text-center text-light bg-primary" width='30'><i class="fas fa-cog"></i>     -->                    
                                            </tr>
                                          </thead>
                                          <tbody id="tbody_cartasofl">                            
                                          </tbody>
                                        </table>
                                      </div>
                                    </div> 
                                      <div class="form-group row mb-3">
                                        <div class="row mb-2 justify-content-md-center">    
                                        @csrf                
                                          <div class="col-6">
                                            <span id="div_autorizacioncarta_ofl">
                                              <label for="fileaprobacionpropuesta" class="form-label form-label-sm">Adjuntar <b><u>aprobación</u></b> de la propuesta por parte del jefe:</label>
                                              <input class="form-control form-control-sm file" name="fileaprobacionpropuesta" id="fileaprobacionpropuesta" type="file" onchange="sube_file('aprob')" accept=".doc,.pdf,image/*">
                                            </span>
                                            <span id="divdesc_autorizacioncarta_ofl">
                                            </span>
                                          </div>
                                        </div>
                                      </div>
                                      <input id="tipo_archi" type="hidden" value="-">
                                      <input id="num_aprob_ofl" type="hidden" value="0">

                                      <div class="row mb-2 justify-content-md-center">
                                        <div class="col-6">      
                                          <span id="div_propuesta_aceptada">                  
                                            <label for="filepropuesta" class="form-label form-label-sm">Adjuntar <b><u>aceptación</u></b> de propuesta por parte del candidato:</label>
                                            <input class="form-control form-control-sm file" name="filepropuestaaceptada" id="filepropuestaaceptada" type="file" onchange="sube_file('oflacept')" accept=".doc,.pdf,image/*">
                                          </span>

                                          <span id="divdesc_propuesta_aceptada">
                                          </span>
                                          
                                        </div>
                                      </div>
                                    </div>

                                  
                                </div>
                              </div>
 

                          </div>    

                          <div class="f1-buttons d-grid gap-4 d-md-flex justify-content-md-end">                            
                            <span class="text-danger pt-2"> <h6> <span id="msn_sig_p_4"></span></h6></span>
                            <button type="button" class="btn btn-sm btn-previous"><i class="fa-solid fa-arrow-left pr-2"></i> Anterior</button>
                            <button type="button" class="btn btn-sm btn-next" id="step_4"><i class="fa-solid fa-arrow-right pr-2"></i> Siguiente</button>
                          </div>
                        </fieldset>
                        <!-- Documentación -->
                        <fieldset id="div_5">
                          <div class="my-3">
                            
                            <div class="modal-header bg-light py-1">
                              <h5 class="text-primary">4. Documentación</h5>
                              <div class="d-grid gap-4 d-md-flex justify-content-md-end">
                                  <button type="button" class="btn btn-sm btn-danger" onclick="noprocede(5)" translate><i class="fas fa-user-times fa-lg"></i>  Descartar Candidato </button>                                  
                              </div>
                            </div>
                              <div class="card">
                                <div class="card-header py-2 pb-0">
                                  <h6 class="text-secondary fw-bold"><i class="fas fa-file-upload text-warning fa-lg"></i> Documentación</h6>
                                </div>   
                                <div class="card-body mt-3">

                                  <div class="form-group row mb-3">
                                    <div class="row mb-2">                    
                                      <div class="col-6">
                                          <label for="fileced" class="form-label form-label-sm">Copia de cédula:</label>
                                        <span id="div_ced">
                                          <input class="form-control form-control-sm file" name="fileced" id="fileced" type="file" accept=".doc,.pdf,image/*" onchange="sube_file('ced')">
                                        </span>
                                        <span id="divdesc_ced">
                                        </span>
                                      </div>                   
                                      <div class="col-6">
                                          <label for="filecarnet_css" class="form-label form-label-sm">Copia de Carné de S.S. o Ficha de S.S.:</label>
                                        <span id="div_carnet_css">
                                          <input class="form-control form-control-sm file" name="filecarnet_css" id="filecarnet_css" type="file" accept=".doc,.pdf,image/*" onchange="sube_file('carnet_css')">
                                        </span>
                                        <span id="divdesc_carnet_css">
                                        </span>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="form-group row mb-3">
                                    <div class="row mb-2">                    
                                      <div class="col-6">
                                          <label for="filecertificado_nacimiento" class="form-label form-label-sm">Certificado de Nacimiento:</label>
                                        <span id="div_certificado_nacimiento">
                                          <input class="form-control form-control-sm file" name="filecertificado_nacimiento" id="filecertificado_nacimiento" type="file" accept=".doc,.pdf,image/*" onchange="sube_file('certificado_nacimiento')">
                                        </span>
                                        <span id="divdesc_certificado_nacimiento">
                                        </span>
                                      </div>             
                                      <div class="col-6">
                                          <label for="fileconstancia_dir" class="form-label form-label-sm">Constancia de Dirección (recibido de agua luz y teléfono):</label>
                                        <span id="div_constancia_dir">
                                          <input class="form-control form-control-sm file" name="fileconstancia_dir" id="fileconstancia_dir" type="file" accept=".doc,.pdf,image/*" onchange="sube_file('constancia_dir')">
                                        </span>
                                        <span id="divdesc_constancia_dir">
                                        </span>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="form-group row mb-3">
                                    <div class="row mb-2">                  
                                      <div class="col-6">
                                          <label for="filedimploma" class="form-label form-label-sm">Copia de último diploma:</label>
                                        <span id="div_dimploma">
                                          <input class="form-control form-control-sm file" name="filedimploma" id="filedimploma" type="file" accept=".doc,.pdf,image/*" onchange="sube_file('dimploma')">
                                        </span>
                                        <span id="divdesc_dimploma">
                                        </span>
                                      </div>               
                                      <div class="col-6">
                                          <label for="filefoto" class="form-label form-label-sm">Foto tamaño Carnet:</label>
                                        <span id="div_foto">
                                          <input class="form-control form-control-sm file" name="filefoto" id="filefoto" type="file" accept=".doc,.pdf,image/*" onchange="sube_file('foto')">
                                        </span>
                                        <span id="divdesc_foto">
                                        </span>
                                      </div>
                                    </div>
                                  </div>
                                  <hr>
                                  <div class="form-group row mb-3">
                                    <div class="row mb-2">                  
                                      <div class="col-6">                                      
                                        <h6 class="text-secondary fw-bold pt-4">Validación SIPE</h6>
                                        <div class="form-check form-switch">
                                          <input class="form-check-input" type="checkbox" id="chk_val_sipe" onchange="valsipe()">
                                          <label class="form-check-label" for="chk_val_sipe">Validación de registro en SIPE</label>
                                        </div>  
                                      </div>
                
                                      <div class="col-6">                                      
                                        <h6 class="text-secondary fw-bold pt-4">Marcación de Reloj</h6>
                                        <div class="form-check form-switch">
                                          <input class="form-check-input" type="checkbox" id="chk_val_marcacion" onchange="valmarcacion()">
                                          <label class="form-check-label" for="chk_val_marcacion">El candidato marcará en el reloj</label>
                                        </div>  
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
          
                            
                                <div class="card">
                                  <div class="card-header py-2 pb-0">
                                    <h6 class="text-secondary fw-bold"><i class="fas fa-users text-danger fa-lg"></i> Dependientes</h6>
                                  </div>   
                                  <div class="card-body"> 
                                    <div class="row my-3  ">
                                      <div class="form-group row mt-3 mb-3 d-grid gap-4 d-md-flex justify-content-md-center">                  
                                        <label for="inputDate" class="col-sm-auto col-form-label-sm">Nombre:</label>
                                        <div class="col-sm-2">
                                          <input id="nombre_dependiente" type="text" class="form-control form-control-sm">
                                        </div>
                                      
                                        <label for="sel_parentesco" class="col-sm-auto col-form-label-sm">Parentesco:</label>
                                        <div class="col-sm-2"> 
                                          <select id="sel_parentesco" class="form-select form-select-sm">
                                            <option value="0" selected>Seleccione</option>
                                              @foreach( $data_tipo_parentesco as $tipo_parentesco)                
                                                <option value="{{ $tipo_parentesco->id}}">{{ $tipo_parentesco->parentesco}}</option>                                       
                                              @endforeach 
                                          </select>
                                          </select>
                                        </div>   
                                      
                                        <label for="inputDate" class="col-sm-auto col-form-label-sm">Fecha de Nacimiento:</label>
                                        <div class="col-sm-2">
                                          <input id="fech_nac_dependiente" type="date" class="form-control form-control-sm">
                                        </div>


                                        <span class="col-sm-auto text-end">
                                          <i class="fas fa-plus-square fa-2x activar mt-1" title="Agregar" onclick="addrow_dependientes()"></i>
                                        </span>
                                      </div>
                                    </div>
                                    <div class="justify-content-center" id="div_msg_dependientes" style="display: none"> 
                                      <div class="col-4 alert alert-warning" >                          
                                        <i class="fa-solid fa-triangle-exclamation fa-lg"></i> Es necesario llenar todos los campos.                        
                                      </div>
                                    </div>
                                    <div class="row justify-content-center">
                                      <div class="col-8">
                                        <table class="table table-sm table-striped table-hover" id="table_dependientes"> 
                                          <thead>
                                            <tr>
                                              <th class="text-center table-primary">Nombre</th>
                                              <th class="text-center table-primary">Parentesco</th>
                                              <th class="text-center table-primary">Fecha de Nacimiento</th>
                                              <th class="text-center table-primary"><i class="fas fa-cog"></i></th>
                                            </tr>
                                          </thead>
                                          <tbody id="tbody_dependientes"> 
                                            
                                          </tbody>
                                        </table>
                                      
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            
                            <div class="card">
                              <div class="card-header py-2 pb-0">
                                <h6 class="text-secondary fw-bold"><i class="far fa-address-book text-info fa-lg"></i> Contacto en caso de urgencia</h6> 
                              </div>   
                              <div class="card-body">
                                <div class="row my-3">
                                  <div class="form-group row mt-3 mb-3 d-grid gap-4 d-md-flex justify-content-md-center"> 
                                    <label for="inputDate" class="col-sm-auto col-form-label-sm">Nombre:</label>
                                    <div class="col-sm-2">
                                      <input id="nombre_contacto" type="text" class="form-control form-control-sm">
                                    </div>
                                                                            
                                    <label for="sel_entrevista_por" class="col-sm-auto col-form-label-sm">Teléfono:</label>
                                    <div class="col-sm-2"> 
                                      <input id="tel_contacto" type="text" class="form-control form-control-sm">
                                      </select>
                                    </div> 
                                        
                                    <span class="col-sm-auto text-end">
                                      <i class="fas fa-plus-square fa-2x activar mt-1" title="Agregar" onclick="addrow_contacto()"></i>
                                    </span>
                                  </div>
                                </div>
                                
                                <div class="justify-content-center" id="div_msg_contactos" style="display: none"> 
                                  <div class="col-4 alert alert-warning" >                          
                                    <i class="fa-solid fa-triangle-exclamation fa-lg"></i> Es necesario llenar todos los campos.                        
                                  </div>
                                </div>

                                <div class="row justify-content-center">
                                  <div class="col-8">
                                    <table class="table table-sm table-striped table-hover" id="table_contactos"> 
                                      <thead>
                                        <tr>
                                          <th class="text-center table-primary">Nombre</th>
                                          <th class="text-center table-primary">Teléfono</th>
                                          <th class="text-center table-primary"><i class="fas fa-cog"></i></th>
                                        </tr>
                                      </thead>
                                      <tbody id="tbody_contactos"> 
                                      
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="f1-buttons d-grid gap-4 d-md-flex justify-content-md-end">               
                            <span class="text-danger pt-2"> <h6> <span id="msn_sig_p_5"></span></h6></span>
                            <button type="button" class="btn btn-sm btn-previous"><i class="fa-solid fa-arrow-left pr-2"></i> Anterior</button>
                            <button type="button" class="btn btn-sm btn-next bg-primary" id="step_5" ><i class="fa-solid fa-arrow-right pr-2"></i> Pasar para firma de contrato</button>
                          </div>
                        </fieldset>
                        <!-- Contratación -->
                        <fieldset id="div_6">                            
                          <div class="my-3">
                          
                            <div class="modal-header bg-light py-1">
                              <h5 class="text-primary">5. Firma de contrato</h5>
                              <div class="d-grid gap-4 d-md-flex justify-content-md-end">
                                  <button type="button" class="btn btn-sm btn-danger" style="display: none"> onclick="noprocede(6)" translate><i class="fas fa-user-times fa-lg"></i>  Descartar Candidato </button>                                  
                              </div>
                            </div>
                            
                              <div class="card">
                                <div class="card-header py-2 pb-0">                              
                                  <h6 class="text-secondary fw-bold"><i class="fas fa-file-contract text-primary fa-lg"></i> Firma de Contrato</h6>
                                </div>   
                                <div class="card-body">
                                   
                                  <div class="row">
                                    <div class="col-3">
                                    </div>
                                      <div class="col mt-2"> 
                                        <div class="row">     
                                          <label class="col-form-label-sm">PAGADORA: 
                                          <span id="lb_contrato_PAGADORA" class="text-primary"></span></label>
                                        </div>
                                        <div class="row">
                                          <label class="col-sm col-form-label-sm">Centro de Costo: 
                                          <span id="lb_nom_cia" class="text-primary"></span></label>
                                        </div>
                                        <div class="row">
                                          <label class="col-sm col-form-label-sm">Unidad Económica: 
                                          <span id="lb_contrato_unidad" class="text-primary"></span></label>
                                        </div>
    
                                        <div class="row">       
                                          <label class="col-sm col-form-label-sm">Posición: 
                                          <span id="lb_pos" class="text-primary"></span></label>
                                        </div>
                                        <div class="row">
                                          <label class="col-sm col-form-label-sm">Nombre: 
                                          <span id="lb_nombre" class="text-primary mayusc"></span></label>
                                        </div>
                                        <div class="row">
                                          <label class="col-sm col-form-label-sm">Salario: 
                                          <span id="lb_salario" class="text-primary"></span></label>
                                        </div>
                                        <div class="row">
                                          <label class="col-sm col-form-label-sm">Tipo de Salario: 
                                          <span id="lb_tipo_sal" class="text-primary"></span></label>
                                        </div>
     
                                      
                                        <div class="row">
                                          <label class="col-sm col-form-label-sm">Tipo de Contrato: 
                                          <span id="lb_tipo_contrato_contrato" class="text-primary"></span></label>
                                        </div>
                                        <div class="row">
                                          <label class="col-sm col-form-label-sm">Fecha de Inicio: 
                                          <span id="lb_finicio" class="text-primary"></span></label>
                                        </div>
                                        <div class="row">
                                          <label class="col-sm col-form-label-sm">Fecha de Terminación: 
                                          <span id="lb_fterminacion" class="text-primary"></span></label>
                                        </div>
                                      </div>
                                    </div>
                                    <div id="idformulariocontrato"></div>
  
                                  <div class="row py-4 justify-content-md-left" style="display: none">
                                    <div class="col col-lg-auto text-center">
                                      <button type="button" class="btn btn-sm btn-success"  onclick="gererapdfcontrato()" ><i class="fas fa-file-pdf fa-xl"></i> Generar Contrato de Trabajo</button>
                                    </div>
                                    
                                    <div class="row my-4">                    
                                      <div class="col-4">
                                        <label for="filecv" class="form-label form-label-sm">Adjuntar contrato firmado:</label>
                                          <input class="form-control form-control-sm file" name="contword_frim" id="contword_frim" type="file" accept=".doc,.pdf,image/*">
                                      </div>
                                    </div>
                                      <div class="row my-4"> 
                                        <div class="col col-lg-auto text-center">
                                          <button type="button" class="btn btn-sm btn-primary"  onclick="finaliza_contratacion()" ><i class="fas fa-user-tie fa-xl"></i> Finalizar Proceso de Contratación</button>
                                        </div>
                                      </div>
                                      <div class="row my-2">
                                        <div class="col col-lg-auto text-center">
                                          <ul id="list_error" class="text-danger lead">

                                          </ul>
                                        </div>
                                      </div>
                                  </div>
                                </div>
                              </div>
                                      
                            </div>

                          <div class="f1-buttons text-end" >
                            <button type="button" class="btn btn-sm btn-previous" id="step_6"><i class="fa-solid fa-arrow-left pr-2"></i> Anterior</button>
                          </div>
                          </div>
                        </fieldset>

                        <fieldset id="div_7" style="display: none">
                          <div class="my-3">
                            <div class="card">
                                
                              <div class="modal-header bg-light py-1">
                                <h5 class="text-danger">Descartar Candidato</h5>
                                <div class="d-grid gap-4 d-md-flex justify-content-md-end"  >
                                    <button id="bto_volver_descarte" type="button" class="btn btn-sm btn-secondary" onclick="volver_noprocede()" translate><i class="fas fa-arrow-left fa-lg"></i>  Volver </button>                                  
                                </div>
                              </div>
                              <div class="card-body">
                                <input id="txt_noprocede" value="" type="hidden">
                                <div class="form-group row my-3">
                                  <div class="col-3">
                                  </div>
                                  <div class="col">
                                  
                                  <div class="row my-3">
                                    <label for="inputPassword" class="col-sm-auto col-form-label">Explicar la razón por la cual el candidato será descartado:</label>
                                      <textarea id="txt_area_descarte" class="form-control" style="height: 70px"></textarea>
                                  </div>
                                  </div>
                                  <div class="col-3">
                                  </div>
                                </div>
                                <div class="row mb-2">    
                                  
                                  <div class="col-3">
                                  </div>              
                                  <div class="col-6">                                      
                                    
                                    <div class="form-check form-switch">
                                      <input class="form-check-input" type="checkbox" id="chk_descarte" >
                                      <label class="form-check-label text-danger" for="chk_descarte">Habilidar para NO tomar en cuenta para futuras contrataciones.</label>
                                    </div>  
                                  </div>
                                </div>
                                <div class="d-grid gap-4 d-md-flex justify-content-md-center">
                                  <button id="bto_guarda_descarte" type="button" class="btn btn-sm btn-warning text-dark" onclick="guardar_noprocede()" translate><i class="fas fa-save fa-lg"></i>  Guardar </button>                                  
                                </div>

                              </div>
                            </div>
                          </div>
                        </fieldset>
                        <div id="div_8" style="display: block">
                          <div class="d-grid gap-4  justify-content-md-center">
                            <h2><i class="fas fa-check-double fa-1x text-success"></i><span class="text-success"> Contratado</span></h2>
                          </div>  
                          <div class="d-grid gap-4  justify-content-md-center">                      
                            <span id="f_ingreso_contrato"> Fecha de ingreso:</span>
                          </div>
                        </div>

                      </form>         
                </div>
                </small>
              </small>
          <!-- ------------------- -->
        </div>
      </div>
    </div>
  </div>

<!-- Modal NUEVO prospectos-->
  <div class="modal fade" id="modalnuevoprooectos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog  modal-fullscreen modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header bg-light">
            <h5 class="modal-title text-primary" id="staticBackdropLabel"><i class="fas fa-user-plus fa-lg text-secondary"></i> Nuevo Candidato</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body bg-light">        
            <small>
              <form id="form_new_prospecto" method="post">
                <div class="card">
                  <div class="card-body pt-3">      
                    <div class="accordion" id="accordionFlushExample">
                      <!-- INFOMRACIÓN PERSONAL -->      
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSix">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                            <b><i class="fas fa-user-tag text-success fa-lg"></i> Información personal</b>
                          </button>
                        </h2>
                        <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body">
                            <div class="mb-4">
                              <div class="row mb-3">
                                <div class="col-md-2">
                                  <label for="prinombre" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Primer nombre:</label>
                                  <input type="text" class="form-control form-control-sm" id="prinombre" name="prinombre" value="">
                                </div>
                                <div class="col-md-2">
                                  <label for="segnombre" class="form-label form-label-sm">Segundo nombre:</label>
                                  <input type="text" class="form-control form-control-sm" id="segnombre" name="segnombre" value="">
                                </div>
                                <div class="col-md-2">
                                  <label for="priapellido" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Primer apellido:</label>
                                  <input type="text" class="form-control form-control-sm" id="priapellido" name="priapellido" value="">
                                </div>
                                <div class="col-md-2">
                                  <label for="segapellido" class="form-label form-label-sm">Segundo apellido:</label>
                                  <input type="text" class="form-control form-control-sm" id="segapellido" name="segapellido" value="">
                                </div>
                                <div class="col-md-auto mt-4 pt-2">
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sel_genero[]" id="genero_M" value="M" checked>
                                    <label class="form-check-label" for="genero_M">Masculino</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sel_genero[]" id="genero_F" value="F">
                                    <label class="form-check-label" for="genero_F">Femenino</label>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- DOMICILIO -->
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSeven">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                            <b><i class="fas fa-address-book text-info fa-lg"></i> Domicilio</b> 
                          </button>
                        </h2>
                        <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body">
                            <div class="mb-4">
                              <div class="row mb-3">
                                <div class="col-md-2">
                                  <label for="sel_provincias" class="form-label form-label-sm"> Província:</label>
                                  <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="sel_provincias" id="sel_provincias" onchange="buscarlugar('distrito',this.value)">
                                    <option selected value='0'>Seleccionar</option>
                                    @foreach( $data_provincias as $provincias )
                                      <option value="{{ $provincias->id }}">{{ $provincias->provincia}}</option>
                                    @endforeach
                                  </select>
                                </div>
                                <div class="col-md-2">
                                  <label for="sel_distrito" class="form-label form-label-sm"> Distrito:</label>
                                  <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="sel_distrito" id="sel_distrito"  onchange="buscarlugar('corregimiento',this.value)" disabled>
                                  </select>
                                </div>
                                <div class="col-md-2">
                                  <label for="sel_corregimiento" class="form-label form-label-sm"> Corregimiento:</label>
                                  <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="sel_corregimiento" id="sel_corregimiento" disabled>
                                  </select>
                                </div>
                                <div class="col-md-4">
                                  <label for="direc" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Dirección específica:</label>
                                  <input type="text" class="form-control form-control-sm" aria-label=".form-select-sm example" id="direc" name="direc">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- DOCUMENTOS -->
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="headingEight">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                            <b><i class="far fa-id-card text-warning fa-lg"></i> Documentos</b>
                          </button>
                        </h2>
                        <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body">
                            <div class="mb-4">
                              <div class="row mb-3">
                                <div class="col-md-3 mb-3 mt-4 pt-2">
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="nacext[]" id="nacext_N" value="N" checked  onclick="showpermiso()">
                                    <label class="form-check-label" for="nacext_N">Nacional</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="nacext[]" id="nacext_E" value="E" onclick="showpermiso()">
                                    <label class="form-check-label" for="nacext_E">Extranjero </label>
                                  </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                  <label for="f_nacimiento" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Fecha de nacimiento:</label>
                                  <input type="date" class="form-control form-control-sm" id="f_nacimiento" name="f_nacimiento">
                                </div>
                                <div class="col-md-3 mb-3">
                                  <label for="sel_nacionalidad" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Pais de nacimiento:</label>
                                  <select class="form-select form-select-sm" name="sel_nacionalidad" id="sel_nacionalidad">
                                    <option selected value='0'>Seleccionar</option>
                                      @foreach( $data_nacionalidades as $nacionalidades )
                                        <option value="{{ $nacionalidades->id }}">{{ $nacionalidades->pais}}</option>
                                      @endforeach
                                  </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                  <label for="sel_estadocivil" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Estado civil:</label>
                                  <select class="form-select form-select-sm" name="sel_estadocivil" id="sel_estadocivil">
                                    <option selected value='-'>Seleccionar</option>
                                    <option value="casado">CASADO (A)</option>
                                    <option value="soltero">SOLTERO (A)</option>
                                    <option value="unido">UNIDO (A)</option>
                                    <option value="divorciado">DIVORCIADO (A)</option>
                                    <option value="separado">SEPARADO (A)</option>
                                    <option value="viudo">VIUDO (A)</option>
                                  </select>
                                </div>
                              </div>
                              <div class="row mb-3">
                                <div class="col-md-3  mb-3">
                                  <label for="sel_tipodoc" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Tipo de documento:</label>
                                  <select class="form-select form-select-sm" name="sel_tipodoc" id="sel_tipodoc">
                                      @foreach( $data_tipo_documento as $tipo_documento )
                                        <option value="{{ $tipo_documento->letra }}">{{ $tipo_documento->tipodoc}}</option>
                                      @endforeach
                                  </select>
                                </div>
                                <div class="col-md-3  mb-3">
                                    <label for="num_docip" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Número de documento:</label>
                                    <input type="text" class="form-control form-control-sm" id="num_docip" name="num_docip" value="">
                                </div>
                                <div class="col-md-3  mb-3">
                                    <label for="f_vencimiento_docip" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Fecha de vencimiento:</label>
                                    <input type="date" class="form-control form-control-sm" id="f_vencimiento_docip" name="f_vencimiento_docip">
                                </div>
                              </div>
                              <div class="row mb-3">
                                
                                <div class="col-md-3  mb-3">
                                  <label for="num_ss" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Número de seguro social:</label>
                                  <input type="text" class="form-control form-control-sm" id="num_ss" name="num_ss" value="">
                                </div>
                                <div class="col-md-3  mb-3">
                                    <label for="telefono" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Teléfono:</label>
                                    <input type="tel" class="form-control form-control-sm" id="telefono" name="telefono" value="">
                                </div>
                                <div class="col-md-3  mb-3">
                                    <label for="mail" class="form-label form-label-sm">Correo electrónico:</label>
                                    <input type="email" class="form-control form-control-sm" id="mail" name="mail" value="">
                                </div>
                              </div>
                              <div id="div_permiso_trab" style="display:none">
                                <div class="row mb-3">
                                  <div class="col-md-3 align-middle">
                                    <label for="sel_tipopermiso" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Permiso de trabajo:</label>
                                    <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="sel_tipopermiso" id="sel_tipopermiso">
                                      <option selected value='0'>Seleccionar</option>
                                        @foreach( $data_tipo_permiso as $tipo_permiso )
                                          <option value="{{ $tipo_permiso->id }}">{{ $tipo_permiso->tipopermiso}}</option>
                                        @endforeach
                                    </select>
                                  </div>
                                  
                                  <div class="col-md-auto mt-4 pt-2">
                                    <a href="info/PERMISOS DE TRABAJO AUTORIZADOS POR MITRADEL.pdf" download="PERMISOS DE TRABAJO AUTORIZADOS POR MITRADEL.pdf"><i class="far fa-file-pdf fa-2x editlink" title="Descargar documento de permisos de trabajo"></i></a>
                                    
                                  </div>
                                  <div class="col-md-3">
                                      <label for="f_vence_permiso" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Vencimiento del permiso:</label>
                                      <input type="date" class="form-control form-control-sm" id="f_vence_permiso" name="f_vence_permiso">
                                  </div>                    
                                  <div class="col-4">
                                      <label for="filepermiso" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Adjuntar permiso de trabajo:</label>
                                      <input class="form-control form-control-sm" name="filepermiso" id="filepermiso" type="file" accept=".doc,.pdf,image/*">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- DISCAPACIDAD -->        
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="headingNine">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                            <b><i class="fas fa-wheelchair text-primary fa-lg"></i> Discapacidad</b>
                          </button>
                        </h2>
                        <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine" data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body">
                            <div class="mb-4">    
                              <div class="row mb-3">
                                <div class="col-md-2 align-middle">
                                  <label for="sel_discapacidad" class="form-label form-label-sm" id="lb_docip"> Posee alguna discapacidad?</label>
                                  <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="sel_discapacidad" id="sel_discapacidad">
                                    <option selected value='NO'>NO</option>
                                        @foreach( $data_listdiscapacidad as $listdiscapacidad )
                                          <option value="{{ $listdiscapacidad->id }}">{{ $listdiscapacidad->discapacidad}}</option>
                                        @endforeach
                                  </select>
                                </div>
                                <div class="col-md-4">
                                  <label for="explique_disc" class="form-label form-label-sm"> Especifique en caso de ser necesario:</label>
                                  <input class="form-control form-control-sm" type="text" id="explique_disc" name="explique_disc">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- EXPERIENCIA LABORAL -->
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            <b><i class="fa-solid fa-user-check text-dark fa-lg"></i> Experiencia laboral</b>
                          </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body">
                              <div class="mb-4">
                                
                                <div class="row mb-2">                    
                                  <div class="col-md-2">
                                      <label for="empresa_experiencia" class="form-label form-label-sm">Empresa:</label>
                                      <input type="text" class="form-control form-control-sm" id="empresa_experiencia" name="empresa_experiencia" required>
                                  </div>
                                  <div class="col-md-3">
                                      <label for="puesto_experiencia" class="form-label form-label-sm">Puesto:</label>
                                      <input type="text" class="form-control form-control-sm" id="puesto_experiencia" name="puesto_experiencia">
                                  </div>
                                  <div class="col-md-3">
                                      <label for="sel_subarea_experiencia" class="form-label form-label-sm">Área:</label>
                                      <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="sel_subarea_experiencia" id="sel_subarea_experiencia">
                                        <option selected value='0'>Seleccione</option>
                                        @php  $grupo=0;$opt='';@endphp
                                        @foreach( $data_areas_sub as $areas_sub )
                                          @php  
                                            if($grupo!=$areas_sub->id_area)
                                            { $grupo=$areas_sub->id_area;
                                              echo'<optgroup label="'.$areas_sub->area.'">';}
                                          @endphp
                                          <option value="{{ $areas_sub->id_sub }}">{{ $areas_sub->subarea}}</option>
                                        @endforeach
                                        <optgroup label="Otras">
                                          <option value="1000">Otra</option>
                                      </select>
                                  </div>
                                  <div class="col-auto">
                                      <label for="desde_experiencia" class="form-label form-label-sm">Desde:</label>
                                      <input type="date" class="form-control form-control-sm" id="desde_experiencia" name="desde_experiencia" required>
                                  </div>
                                  <div class="col-auto">
                                      <label for="hasta_experiencia" class="form-label form-label-sm">Hasta:</label>
                                      <input type="date" class="form-control form-control-sm" id="hasta_experiencia" name="hasta_experiencia">
                                  </div>
                                  <div class="col-auto text-end">
                                    <i class="fas fa-plus-square fa-2x activar mt-4 pt-2" title="Agregar" onclick="addrow('experiencia')"></i>
                                  </div>
                                </div>
                                <div class="justify-content-center" id="div_experiencia" style="display: none"> 
                                  <div class="col-4 alert alert-warning" >                          
                                    <i class="fa-solid fa-triangle-exclamation fa-lg"></i> Es necesario llenar todos los campos.                        
                                  </div>
                                </div>
                                <small>
                                  <table id="table_experiencia" class="table table-sm table-bordered table-striped table-hover">
                                    <thead>
                                      <tr class="table-primary">
                                        <th class="text-secondary text-center">EMPRESA</th>
                                        <th class="text-secondary text-center">PUESTO</th>
                                        <th class="text-secondary text-center">AREA</th>
                                        <th class="text-secondary text-center">DESDE</th>
                                        <th class="text-secondary text-center">HASTA</th>
                                        <th class="text-secondary text-center" width='30'><i class="fas fa-cog"></i></th>
                                      </tr>
                                    </thead>
                                    <tbody id="tbody_experiencia">
                                    </tbody>
                                  </table>
                                </small>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- EDUCACIÓN -->
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingTwo">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            <b><i class="fas fa-graduation-cap text-info fa-lg"></i> Educación</b>
                          </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body">
                            <div class="mb-4">
                              <div class="row mb-2">                    
                                <div class="col-sm-4 mb-2">
                                    <label for="entidad_educ" class="form-label form-label-sm">Entidad:</label>
                                    <input type="text" class="form-control form-control-sm" id="entidad_educ" name="entidad_educ" required>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <label for="titulo_educ" class="form-label form-label-sm">Titulo:</label>
                                    <input type="text" class="form-control form-control-sm" id="titulo_educ" name="titulo_educ">
                                </div>
                                <div class="col-3 mb-2">
                                    <label for="sel_niveleduc" class="form-label form-label-sm">Nivel:</label>                  
                                    <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="sel_niveleduc" id="sel_niveleduc">
                                        <option selected value='0'>Seleccione</option>
                                      @foreach( $data_nivel_educ as $nivel_educ )
                                        <option value="{{ $nivel_educ->id }}">{{ $nivel_educ->nivel_educ}}</option>
                                      @endforeach
                                  </select>
                                </div>
                                <div class="col-2 mb-2">
                                    <label for="sel_estatuseduc" class="form-label form-label-sm">Estatus:</label>
                                    <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="sel_estatuseduc" id="sel_estatuseduc">
                                        <option selected value='0'>Seleccione</option>
                                      @foreach( $data_estatus_educ as $estatus_educ )
                                        <option value="{{ $estatus_educ->id }}">{{ $estatus_educ->estatuseduc}}</option>
                                      @endforeach
                                  </select>
                                </div>
                                <div class="col-2 mb-2">
                                    <label for="desde_educ" class="form-label form-label-sm">Desde:</label>
                                    <input type="date" class="form-control form-control-sm" id="desde_educ" name="desde_educ">
                                </div>
                                <div class="col-2 mb-2">
                                    <label for="hasta_educ" class="form-label form-label-sm">Hasta:</label>
                                    <input type="date" class="form-control form-control-sm" id="hasta_educ" name="hasta_educ">
                                </div>
                                <div class="col text-end">
                                  <i class="fas fa-plus-square fa-2x activar mt-4 pt-2" title="Agregar" onclick="addrow('educacion')"></i>
                                </div>
                              </div>
                              <div class="justify-content-center" id="div_educacion" style="display: none"> 
                                <div class="col-4 alert alert-warning" >                          
                                  <i class="fa-solid fa-triangle-exclamation fa-lg"></i> Es necesario llenar todos los campos.                        
                                </div>
                              </div>
                              <small>
                                <table id="table_educacion" class="table table-sm table-bordered table-striped table-hover">
                                  <thead>
                                    <tr class="table-primary">
                                      <th class="text-secondary text-center">ENTIDAD</th>
                                      <th class="text-secondary text-center">TITULO</th>
                                      <th class="text-secondary text-center">NIVEL</th>
                                      <th class="text-secondary text-center">ESTATUS</th>
                                      <th class="text-secondary text-center">DESDE</th>
                                      <th class="text-secondary text-center">HASTA</th>
                                      <th class="text-secondary text-center" width='30'><i class="fas fa-cog"></i></th>
                                    </tr>
                                  </thead>
                                  <tbody id="tbody_educacion">
                                  </tbody>
                                </table>
                              </small>
                            </div>  
                          </div>
                        </div>
                      </div>
                      <!-- CURSOS / SEMINARIOS -->
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingThree">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                            <b><i class="fas fa-certificate text-warning fa-lg"></i> Cursos / Seminarios</b>
                          </button>
                        </h2>
                        <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body">
                            <div class="mb-4">
                              <div class="row mb-2">            
                                <div class="col-md-3">
                                    <label for="entidad_curso" class="form-label form-label-sm">Entidad:</label>
                                    <input type="text" class="form-control form-control-sm" id="entidad_curso" name="entidad_curso" required>
                                </div>                    
                                <div class="col-md-3">
                                    <label for="nombre_curso" class="form-label form-label-sm">Nombre del curso / seminario:</label>
                                    <input type="text" class="form-control form-control-sm" id="nombre_curso" name="nombre_curso" required>
                                </div>
                                <div class="col-2">
                                    <label for="desde_curso" class="form-label form-label-sm">Desde:</label>
                                    <input type="date" class="form-control form-control-sm" id="desde_curso" name="desde_curso" required>
                                </div>
                                <div class="col-2">
                                    <label for="hasta_curso" class="form-label form-label-sm">Hasta:</label>
                                    <input type="date" class="form-control form-control-sm" id="hasta_curso" name="hasta_curso">
                                </div>
                                <div class="col text-end">
                                  <i class="fas fa-plus-square fa-2x activar mt-4 pt-2" title="Agregar" onclick="addrow('cursos')"></i>
                                </div>
                              </div>
                              <div class="justify-content-center" id="div_cursos" style="display: none"> 
                                <div class="col-4 alert alert-warning" >                          
                                  <i class="fa-solid fa-triangle-exclamation fa-lg"></i> Es necesario llenar todos los campos.                        
                                </div>
                              </div>
                              <small>
                                <table id="table_cursos" class="table table-sm table-bordered table-striped table-hover">
                                  <thead>
                                    <tr class="table-primary">
                                      <th class="text-secondary text-center">ENTIDAD</th>
                                      <th class="text-secondary text-center">CURSO / SEMINARIO</th>
                                      <th class="text-secondary text-center">DESDE</th>
                                      <th class="text-secondary text-center">HASTA</th>
                                      <th class="text-secondary text-center" width='30'><i class="fas fa-cog"></i></th>
                                    </tr>
                                  </thead>
                                  <tbody id="tbody_cursos">
                                  </tbody>
                                </table>
                              </small>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- REFERENCIAS -->
                      <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingFour">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                            <b><i class="fas fa-people-arrows text-primary fa-lg"></i> Referencias</b>
                          </button>
                        </h2>
                        <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body">
                            <div class="mb-4">
                              <div class="row mb-2">                    
                                <div class="col-4">
                                    <label for="nombre_referencia" class="form-label form-label-sm">Nombre:</label>
                                    <input type="text" class="form-control form-control-sm" id="nombre_referencia" name="nombre_referencia" required>
                                </div>
                                <div class="col-2">
                                    <label for="cargo_referencia" class="form-label form-label-sm">Cargo:</label>
                                    <input type="text" class="form-control form-control-sm" id="cargo_referencia" name="cargo_referencia" required>
                                </div>
                                <div class="col-2">
                                    <label for="sel_rela_ref" class="form-label form-label-sm">Tipo de relación:</label>
                                    <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="sel_rela_ref" id="sel_rela_ref">
                                        <option selected value='0'>Seleccione</option>
                                      @foreach( $data_rela_ref as $rela_ref )
                                        <option value="{{ $rela_ref->id }}">{{ $rela_ref->rela_ref}}</option>
                                      @endforeach
                                  </select>
                                </div>
                                <div class="col-2">
                                    <label for="contacto_referencia" class="form-label form-label-sm">contacto:</label>
                                    <input type="text" class="form-control form-control-sm" id="contacto_referencia" name="contacto_referencia">
                                </div>
                                <div class="col-2 text-end">
                                  <i class="fas fa-plus-square fa-2x activar mt-4 pt-2" title="Agregar" onclick="addrow('referencias')"></i>
                                </div>
                              </div>
                              <div class="justify-content-center" id="div_referencias" style="display: none"> 
                                <div class="col-4 alert alert-warning" >                          
                                  <i class="fa-solid fa-triangle-exclamation fa-lg"></i> Es necesario llenar todos los campos.                        
                                </div>
                              </div>
                              <small>
                                <table id="table_referencias" class="table table-sm table-bordered table-striped table-hover">
                                  <thead>
                                    <tr class="table-secondary">
                                      <th class="text-secondary text-center">NOMBRE</th>
                                      <th class="text-secondary text-center">CARGO</th>
                                      <th class="text-secondary text-center">RELACIÓN</th>
                                      <th class="text-secondary text-center">CONTACTO</th>
                                      <th class="text-secondary text-center" width='30'><i class="fas fa-cog"></i></th>
                                    </tr>
                                  </thead>
                                  <tbody id="tbody_referencias">
                                  </tbody>
                                </table>
                              </small>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- HOJA DE VIDA -->
                        <div class="accordion-item">
                          <h2 class="accordion-header" id="flush-headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                              <b><i class="fas fa-user-tie text-danger fa-lg"></i> Hoja de vida</b>
                            </button>
                          </h2>
                          <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                              <div class="mb-4">
                                <div class="row mb-2">                    
                                  <div class="col-4">
                                    <label for="filecv" class="form-label form-label-sm">Adjuntar hoja de vida:</label>
                                      <input class="form-control form-control-sm file" name="filecv" id="filecv" type="file" accept=".doc,.pdf,image/*">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div><!-- End Accordion without outline borders -->
                  </div>
                </div>
              </form>
            </small>
          </div>
          <div class="modal-footer bg-light">  
            <div class="alert alert-danger align-items-center py-1 fade visually-hidden" role="alert" id="div_alert">
              <i class="fa-solid fa-triangle-exclamation"> </i> <span class="pl-2" id="msg_alert"> </span>
            </div>    
            <div class="align-items-left py-1 mr-4 pr-4 fade visually-hidden text-primary" role="alert" id="div_success">
              <div class="spinner-border spinner-border-sm" role="status"></div>
              <span class="show"> Enviando...</span>
            </div> 
          
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cancelar</button>
            <button type="button" onclick="valida()" class="btn btn-primary btn-sm" id="bto_guarda" style="display: block"><i class="fas fa-save pr-2"></i> Agregar</button>
          </div>
        </div>
      </div>
    </div>
@endsection

<script src="assets/vendor/quill/quill.min.js"></script>
<script type='text/javascript'>

// ----- GUARDA DESCARTAR CANDIDATO
  function guardar_noprocede()
  { var txt_area_descarte= document.getElementById('txt_area_descarte').value;
    if(txt_area_descarte.length>10)
    { encuenta=0;
      
      quest="El candidato será descartado de este proceso de contratación, desea continuar?";
      if(document.getElementById('chk_descarte').checked)
      { encuenta=1;
        quest="El candidato será descartado de este y FUTUROS PROCESOS de contratación, desea continuar?";
      }
      
      id_curri= $('#id_curri').val();
      id_participante= $('#id_participante').val();
      var _token = $('input[name="_token"]').val();
      Swal.fire({
        text: quest,
        icon: "question",
        showCancelButton: true,
        cancelButtonText:  '<i class="fas fa-arrow-left"></i> Cancelar',
        confirmButtonText: '<i class="fas fa-user-times"></i> Si, descartar canditado',
        confirmButtonColor: "#d33",
      }).then((result) => {
        if (result.isConfirmed) 
        {
          var parametros = {
          "encuenta": encuenta,
          "id_curri":id_curri,
          "id_participante":id_participante,
          "txt_area_descarte":txt_area_descarte,
          "_token": _token};
          $.ajax({
            data:  parametros, 
            url:   "{{ route('ofertas.descarte') }}",
            type:  'POST', 
            dataType: "json",
            cache: false,          
            success:  function (data) { 
              
              document.getElementById("div_banges_"+$('#id_curri').val()).innerHTML=data.banges;
              document.getElementById('lb_proceso_part').innerHTML= 'Candidatos: <span class="text-secondary"><b>'+data.cant_proceso+'</b></span>';
              document.getElementById('lb_cont_part').innerHTML='Contratados: <span class="text-secondary"><b>'+data.cant_contratado+'</b></span>';

              document.getElementById('cantpart_'+data.id_ofl).innerHTML= data.cant_proceso;
              document.getElementById('cantinicial_'+data.id_ofl).innerHTML=  data.cant_inicial;
              document.getElementById('cantfuncional_'+data.id_ofl).innerHTML=  data.cant_funcional;
              document.getElementById('cantofertalaboral_'+data.id_ofl).innerHTML=  data.cant_ofertalaboral;
              document.getElementById('cantdocumentacion_'+data.id_ofl).innerHTML=  data.cant_documentacion;
              document.getElementById('cantfirma_'+data.id_ofl).innerHTML=  data.cant_firma;

              document.getElementById('cantcont_'+data.id_ofl).innerHTML= data.cant_contratado;
              bien("El caldidato ha sido descartado.");
              $('#modaletapas_cont').modal('hide');
              $('#modalprooectos').modal('show');
            }
          });
        };
      });
    }else
    {
      maldescarte("Es necesario explicar un poco más la razón del descarte del candidato.");
    }
  }

// ----- NOR PROCEDE EL CANDIDATO
  function noprocede(id_div)
  { document.getElementById('div_'+id_div).style.display='none';
    document.getElementById('div_7').style.display='block';
    document.getElementById('txt_noprocede').value=id_div;
    document.getElementById('txt_area_descarte').value="";
    document.getElementById('txt_area_descarte').focus();
    $('#chk_descarte').prop('checked', false);
  }

  function volver_noprocede()
  { id_div= document.getElementById('txt_noprocede').value;
    document.getElementById('div_'+id_div).style.display='block';
    document.getElementById('div_7').style.display='none';
    document.getElementById('txt_noprocede').value="";
 
    $('#chk_descarte').prop('checked', false);
  }

  //---- FINALIZA CONTRATACIÓN
  function finaliza_contratacion()
  { 
    alert("llega");
    nuevaFila='-';
      var ref_sino=''; 
      checked = $('input[name="ref_sino"]:checked');
        $('[name="ref_sino[]"]:checked').map(function(){
        if (this.checked) {
          ref_sino=$(this).val();
        }
      });

      if(ref_sino=='S')
      { nrows = $("#tbody_valreflaboral tr").length;
        if(nrows>0)
        {

        }
        else
        { nuevaFila='<li><i class="fas fa-exclamation-triangle"></i> Debe agregar las validaciones de las referencias.</li>';
          contendor  = $("#list_error").html();
          $("#list_error").html(contendor+nuevaFila); }
      }
  }

  //----- GENERAL CARTA OFERTA
  function genera_cartaol()
  { band=0;
    var _token = $('input[name="_token"]').val();

    var id_participante = $('#id_participante').val(); 
    var salario = $('#txt_salario').val(); 
    var sel_tipo_salario = $('#sel_tipo_salario').val(); 
    var finicio = $('#f_ingreso').val(); 
    var fterminacion = $('#f_terminacion').val(); 
    var sel_tipo_contrato = $('#sel_tipo_contrato').val(); 
alert(finicio);
  if(sel_tipo_contrato=='P'){ fterminacion ='1900-01-01';}
  
  if(salario>0)
  {
    if(sel_tipo_salario!=0)
    { alert()
      if(finicio!='')
      { var parametros = {

          "id_participante" : id_participante,
          "salario": salario,
          "finicio": finicio,
          "fterminacion": fterminacion,
          "sel_tipo_contrato":sel_tipo_contrato,
          "sel_tipo_salario":sel_tipo_salario,
          "_token":_token};
          $.ajax({
          data:  parametros, 
          url:   "{{ route('ofertas.pdf') }}",
          type:  'post', 
          dataType: "json",
          cache: true,       
          beforeSend: function () {
            document.getElementById("div_bto_generacarta").innerHTML='<div class="spinner-border spinner-border-sm text-primary" role="status"></div> Generando Carta Oferta';
          }, 
          success:  function (data) { 
            document.getElementById("div_bto_generacarta").innerHTML='<i class="fas fa-plus"></i> Nueva oferta laboral';
          
            // document.getElementById('div_propuesta_espera').style.display='none';
          //  document.getElementById('div_cartaoferta_aprobacion').style.display='none';
            document.getElementById('div_autorizacioncarta_ofl').style.display='none';
            $("#tbody_cartasofl").html('');
            jQuery(data).each(function(i, item){   
              fterminacion='-';class_texto="text-center text-primary";
                icono_descarga='<span id="ico_'+item.id+'"><i class="fas fa-download fa-lg activar" onclick="gererapdf('+item.id+')"></i></span>';
                $('#num_aprob_ofl').val(item.id);
                icono_dell='<i class="fa-solid fa-trash-can dell" onclick=delrow(this,'+item.id+',"cartasofl")></i>';
                por="-";
                if(item.descargada_por!=null){  por=item.descargada_por;}
                if(item.estado==2)
                { class_texto="text-center text-decoration-line-through text-secondary";
                  icono_descarga='<i class="fas fa-download fa-lg text-secondary"></i>';
                  icono_dell='<i class="fa-solid fa-trash-can text-secondary"></i>';
                }
                    contendor  = $("#tbody_cartasofl").html();
                    nuevaFila   = '<tr>'+
                  '<td><div class="'+class_texto+'">'+item.id+'</div></td>'+
                  '<td><div class="'+class_texto+'">'+item.salario+'</div></td>'+
                  '<td><div class="'+class_texto+'">'+item.finicio+'</div></td>'+
                  '<td><div class="'+class_texto+'">'+fterminacion+'</div></td>'+
                  '<td><div class="'+class_texto+'">'+icono_descarga+'</div></td>'+
                    //--      '<td><div class="'+class_texto+'">'+por+'</div></td>'+
                    //--      '<td><div class="text-center">'+icono_dell+'</div></td>'+
                  '</tr>';
                  $("#tbody_cartasofl").html(contendor+nuevaFila); 
              });
            },
            error: function() {
                console.log("Error");
            }
            });
        }else
        { document.getElementById('f_ingreso').focus();}
      }
      else
      { document.getElementById('sel_tipo_salario').focus();}
    }
    else
    { document.getElementById("txt_salario").focus();}
  }

  //----- SUBRE ARCHIVOS A STORAGE
  function sube_file(optarchi)
  { var _token = $('input[name="_token"]').val();

    $("#tipo_archi").val(optarchi);
    if(optarchi=='aprob')
    {    
      var file= document.getElementById('fileaprobacionpropuesta').files;
      fileapropuesta = file[0];
      var data = new FormData();    
      data.append("_token", _token); 
      data.append("optarchi", optarchi);
      data.append("filedoc", fileapropuesta);
      data.append("num_aprob_ofl", $('#num_aprob_ofl').val());
      $.ajax({
        data:  data, 
        url:   "{{ route('ofertas.subir') }}",
        type:  'POST',//método de envio
        contentType: false,       // The content type used when sending data to the server.
        cache: false,             // To unable request pages to be cached
        processData:false,			// To send DOMDocument or non processed data file it is set to false+
        beforeSend: function () {
          document.getElementById('div_autorizacioncarta_ofl').style.display="none";
          document.getElementById('divdesc_autorizacioncarta_ofl').style.display="block";
          $('divdesc_autorizacioncarta_ofl').html('<div class="spinner-border spinner-border-sm text-primary" role="status"></div>');
        }, 
        success:  function (data) {

          //  document.getElementById('div_cartaoferta_aprobacion').style.display='block';
            document.getElementById('div_autorizacioncarta_ofl').style.display='block';
            document.getElementById('divdesc_autorizacioncarta_ofl').style.display='none';
            document.getElementById('fileaprobacionpropuesta').value="";
            document.getElementById('div_propuesta_aceptada').style.display="none";
          if(data!='-')
          {
            document.getElementById('div_autorizacioncarta_ofl').style.display="none";
            document.getElementById('divdesc_autorizacioncarta_ofl').style.display="block";
            document.getElementById('div_propuesta_aceptada').style.display="block";
            $('#divdesc_autorizacioncarta_ofl').html('<a href="'+data+'" download="Aprobacion"><i class="fas fa-download"></i> Descargar <b>aprobación</b> del jefe de la oferta laboral.</a> <i title="eliminar archivo de aprobación" class="fa-solid fa-trash-can dell" onclick=deldocofl("aprob",'+$('#num_aprob_ofl').val()+')></i>');
          }
        }
      });
    }
    else
    {
      if(optarchi=='oflacept')
      { 
        var file= document.getElementById('filepropuestaaceptada').files;
        fileapropuesta = file[0];
        var data = new FormData();    
        data.append("_token", _token); 
        data.append("optarchi", optarchi);
        data.append("filedoc", fileapropuesta);
        data.append("num_aprob_ofl", $('#num_aprob_ofl').val());
        $.ajax({
          data:  data, 
          url:   "{{ route('ofertas.subir') }}",
          type:  'POST',//método de envio
          contentType: false,       // The content type used when sending data to the server.
          cache: false,             // To unable request pages to be cached
          processData:false,			// To send DOMDocument or non processed data file it is set to false+
          dataType: "json",
          beforeSend: function () {
            document.getElementById('divdesc_propuesta_aceptada').style.display="block";
            $('divdesc_propuesta_aceptada').html('<div class="spinner-border spinner-border-sm text-primary" role="status"></div>');
            document.getElementById('div_propuesta_aceptada').style.display="none";
          }, 
          success:  function (data) {
            if(data.url!='-')
            { fecha= data.faceptacion.split('-');
              $('#divdesc_propuesta_aceptada').html('<a href="'+data.url+'" download="CartaAceptada"><i class="fas fa-download"></i> Descargar <b>aceptación</b> por parte del candidato.</a> <i title="eliminar archivo de aceptación" class="fa-solid fa-trash-can dell" onclick=deldocofl("oflacept",'+$('#num_aprob_ofl').val()+')></i> '+fecha[2]+'-'+fecha[1]+'-'+fecha[0]);
            }
            else
            {
              document.getElementById('divdesc_propuesta_aceptada').style.display="none";
              $('divdesc_propuesta_aceptada').html('');
              document.getElementById('filepropuestaaceptada').value="";
              document.getElementById('div_propuesta_aceptada').style.display="block";
            }
          }
        });
      }
      else{
          var file= document.getElementById('file'+optarchi).files;
          filedoc = file[0];
          var data = new FormData();    
          data.append("_token", _token); 
          data.append("optarchi", optarchi);
          data.append("filedoc", filedoc);
          data.append("id_curri", $('#id_curri').val());
          data.append("id_participante", $('#id_participante').val());
          $.ajax({
            data:  data, 
            url:   "{{ route('ofertas.subir') }}",
            type:  'POST',  //método de envio
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,			// To send DOMDocument or non processed data file it is set to false+
            dataType: "json",

            beforeSend: function () {
              document.getElementById('divdesc_'+optarchi).style.display="block";
              $('#divdesc_'+optarchi).html('<div class="spinner-border spinner-border-sm text-primary" role="status"></div>');
              document.getElementById('div_'+optarchi).style.display="none";
            }, 
            success:  function (data) {
              
              jQuery(data).each(function(i, item){ 
                if(item.url!='-')
                {
                  $('#divdesc_'+optarchi).html('<a href="'+item.url+'" download="Docum_'+optarchi+'"><i class="fas fa-download"></i> Descargar documento.</a> <i title="Eliminar documento" class="fa-solid fa-trash-can dell" onclick=deldocofl("'+optarchi+'",'+item.id+')></i>');
                }
                else
                {
                  document.getElementById('divdesc_'+optarchi).style.display="none";
                  $('#divdesc_'+optarchi).html('');
                  document.getElementById('file'+optarchi).value="";
                  document.getElementById('div_'+optarchi).style.display="block";
                }
              });
            }
          });
        
      }
    }

  }
  //----- MUESTRA MENSAJE DE VALDIDACIÓN
  function mensaje_alert(msn)
  {
    $('#msn_sig_p_1').html(msn);
    setTimeout(function(){ $('#msn_sig_p_1').html(''); }, 4000);
  }

  //----- ACTIVA EL CARD PARA MOSTRAR EL DETALLE DE UN PARTICIPANTE
  function edit_etapa_part(id_curri,id_participante)
  {  $('.f1 fieldset:first').fadeIn('slow');
    document.getElementById('ls_secc_docpermiso_trab').style.display='none'
    
    document.getElementById('chk_descarte').checked = false;
    document.getElementById('chk_descarte').disabled = false;
    document.getElementById('txt_area_descarte').disabled = false;
    document.getElementById('bto_volver_descarte').style.display='block';
    document.getElementById('bto_guarda_descarte').style.display='block';
    document.getElementById('div_7').style.display='none';
    document.getElementById('div_8').style.display='none';

    var _token = $('input[name="_token"]').val();
    var parametros = {
      "_token":_token,
      "id_curri" : id_curri,
      "id_participante" : id_participante};
      $.ajax({
        data:  parametros, 
        url:   "{{ route('ofertas.findidcurri') }}",
        type:  'POST', 
        dataType: "json",
        cache: true,  
        success:  function (data) { 
        // DATOS GENERALES
          var nombre_completo="";
          jQuery(data.participante).each(function(i, item){   
            var tel='No tiene'; var email='No tiene'; var provincia=''; var distrito=''; var corregimiento=''; var direccion=''; var nacionalidad=''; 
            var permiso_trab=''; var f_vence_permiso_trab=''; var permiso_doc=''; var f_nacimiento='';
            var segnombre='';  var segapellido=''; 
            if(item.segnombre!=null){segnombre=item.segnombre;}   
            if(item.segapellido!=null){segapellido=item.segapellido;}  
            nombre_completo=item.prinombre+' '+segnombre+' '+item.priapellido+' '+segapellido;
            if(item.tel!=null){tel=item.tel;}  
            if(item.email!=null){email=item.email;} 
            if(item.provincia!=null){provincia=item.provincia+', ';} 
            if(item.distrito!=null){distrito=item.distrito+', ';} 
            if(item.corregimiento!=null){corregimiento=item.corregimiento+' -';} 
            if(item.direccion!=null){direccion=item.direccion;} 
            if(item.nacionalidad!=null){nacionalidad=item.nacionalidad;} 
            if(item.permiso_trab!=null){permiso_trab=item.permiso_trab;}             
            f_nacimiento=item.f_nacimiento.split('-');
            $('#ld_nom_participante').html(nombre_completo);
            $('#lb_nom_completo').html('<span class="text-dark">Nombre completo:</span> <span class="text-primary fw-bold"><span id="spnombre_completo">'+nombre_completo+'</span></span><input type="hidden" value="'+id_curri+'" id="id_curri" name="id_curri"><input type="hidden" value="'+id_participante+'" id="id_participante" name="id_participante">');
            $('#lb_nombre').html(nombre_completo);
            $('#lb_cedula').html('<span class="text-dark"># DIP:</span> <span class="text-secondary"> '+item.num_doc+'</span>');
            $('#lb_f_nacimiento').html('<span class="text-dark">Fecha de nacimiento:</span> <span class="text-secondary">'+f_nacimiento[2]+'-'+f_nacimiento[1]+'-'+f_nacimiento[0]+'</span>');
            $('#lb_tel').html('<span class="text-dark ">Teléfono:</span>  <span class="text-secondary">'+tel+'</span>');
            $('#lb_mail').html('<span class="text-dark ">Correo electrónico:</span>  <span class="text-secondary">'+email+'</span>');
            $('#lb_dir').html('<span class="text-dark ">Domicilio:</span>  <span class="text-secondary">'+provincia+' '+distrito+' '+corregimiento+' '+direccion+'</span>');
            $('#lb_nacionalidad').html('<span class="text-dark ">Nacionalidad:</span>  <span class="text-secondary">'+nacionalidad+'</span>');
            $('#lb_desc_cv').html('<a href="'+item.cv_doc+'" download="CV-'+nombre_completo+'"><i class="fas fa-download"></i> Descargar hoja de vida</a>');
            if(item.nacio_extran=='E')
            { document.getElementById('ls_secc_docpermiso_trab').style.display='block';
              $('#lb_tipo_permiso').html('<span class="text-dark">Tipo de permiso:</span> <span class="text-secondary">'+item.permiso_trab+'</span>');
              if(item.f_vence_permiso_trab!='1900-01-01'&&item.f_vence_permiso_trab!=null)
              { f_vence_permiso_trab=item.f_vence_permiso_trab.split('-');
                $('#lb_f_venci_permiso').html('<span class="text-dark">Fecha de vencimiento:</span> <span class="text-secondary">'+f_vence_permiso_trab[2]+'-'+f_vence_permiso_trab[1]+'-'+f_vence_permiso_trab[0]+'</span>');
              }
              if(item.permiso_doc!='-')
              {  
                $('#lb_desc_permiso').html('<a href="'+item.permiso_doc+'" download="PT-'+nombre_completo+'"><i class="fas fa-download"></i> Descargar permiso de trabajo</a>');
              } 
            }
          });
            document.getElementById('div_2').style.display='none';
            document.getElementById('div_3').style.display='none';
            document.getElementById('div_4').style.display='none';
            document.getElementById('div_5').style.display='none';
            document.getElementById('div_6').style.display='none';
            document.getElementById('div_7').style.display='none';
            document.getElementById('div_pasos').style.display='block';

            $('#paso_1').removeClass('active').removeClass('activated').removeClass('f1-step.active');
            $('#paso_2').removeClass('active').removeClass('activated').removeClass('f1-step.active');
            $('#paso_3').removeClass('active').removeClass('activated').removeClass('f1-step.active');
            $('#paso_4').removeClass('active').removeClass('activated').removeClass('f1-step.active');
            $('#paso_5').removeClass('active').removeClass('activated').removeClass('f1-step.active');
          if(data.paso<7)
          { $('#txt_paso').val(data.paso);

            $('#paso_1').addClass('active');
            $('#paso_1').addClass('f1-step.active');

            //document.getElementById('div_2').style.display='block';
            $('#line_progress').attr('style', 'width: 10%;').data('now-value', 10);
          

            for (var x = 2; x < data.paso; x++) 
            { var parent_fieldset = $('#step_'+x).parents('fieldset');
              var next_step = true;
              var current_active_step = $('#step_'+x).parents('.f1').find('.f1-step.active');
              var progress_line = $('#step_'+x).parents('.f1').find('.f1-progress-line');
              
              current_active_step.removeClass('active').addClass('activated').next().addClass('active'); 
              
              parent_fieldset.fadeOut(50, function() {
                // progress bar
                bar_progress(progress_line, 'right');
                // show next step
                // $(this).next().fadeIn();
                // scroll window to beginning of the form
                // scroll_to_class( $('.f1'), 20 );
              });      
            }
            paso=data.paso;
            if(data.paso<=1)
            { paso=2;}
          
            document.getElementById('div_'+paso).style.display='block';

            // PASO DE ENTREVISTA INICIAL
            $("#tbody_valreflaboral").html('');            
            $('#valida_exp_entidad').val('');
            $('#valida_exp_nombre').val('');
            $('#valida_exp_puesto').val('');
            $('#valida_exp_contacto').val('');
            $('#valida_exp_comentario').val('');
            $("#ref_N").prop("checked", true);
            $("#ref_S").prop("checked", false);
            showval_ref();
            if(data.ref_val=='S'){   
            $("#ref_S").prop("checked", true);
              showval_ref();
              jQuery(data.valida_refres).each(function(i, item){ 
                var contendor  = $("#tbody_valreflaboral").html();
                var nuevaFila   = '<tr>';
                nuevaFila  += '<td>'+item.entidad+'</td>';
                nuevaFila  += '<td>'+item.nombre+'</td>';
                nuevaFila  += '<td>'+item.puesto+'</td>';
                nuevaFila  += '<td>'+item.contacto+'</td>';
                nuevaFila  += '<td class="small">'+item.comentarios+'</td>';
                nuevaFila  += '<td class="text-center"><i class="fa-solid fa-trash-can dell" onclick=delrow(this,"valreflaboral")></i></td>';
                nuevaFila  += '</tr>';
                $("#tbody_valreflaboral").html(contendor+nuevaFila);
              });
            }

            $('#sel_evaluacion_aplicada').empty();
            $('#sel_evaluacion_aplicada').append("<option value='0' selected>Seleccionar</option>"); 
            jQuery(data.pruebaspsico).each(function(i, item){  
              $('#sel_evaluacion_aplicada').append("<option value='"+ item.id+"'>"+ item.nom_prueba+ "</option>"); 
            });

            $("#tbody_pruebaspsico").html('');

              jQuery(data.prueba_psico).each(function(i, item){   
                  resultado=item.resultado;
                  fecha= item.f_prueba.split('-');

                  if(item.respuesta!=null)
                  { resultado=item.respuesta;}
                  var contendor  = $("#tbody_pruebaspsico").html();
                  var nuevaFila   = '<tr>';
                  nuevaFila  += '<td>'+item.nom_prueba+'</td>';
                  nuevaFila  += '<td>'+fecha[2]+'-'+fecha[1]+'-'+fecha[0]+'</td>';
                  nuevaFila  += '<td>'+resultado+'</td>';
                  nuevaFila  += '<td class="text-center"><i class="fa-solid fa-trash-can dell" onclick=delrowpruebaspsico(this,"'+item.id_prueba+'")></i></td>';
                  nuevaFila  += '</tr>';
                  
                  $("#tbody_pruebaspsico").html(contendor+nuevaFila);
                });
                $('#sel_evaluacion_aplicada').val(0);
                $('#f_envio_prueba').val('');
                $('#iddiv_resul_psico').html('<input type="text" class="form-control form-control-sm" id="pruebapsico_resultado" max="30" value="">');
          
            // PASO DE ENTREVISTAS FUNCIONALES
              
              $("#tbody_entrefuncional").html('');            
                $('#sel_entrevistador').val('0');
                $('#sel_fecha').val('');
                $('#sel_hora').val('');
                $("#entre_N").prop("checked", true);
                $("#entre_S").prop("checked", false);
                showentre();
                if(data.aplica_entrevistas=='S'){   
                $("#entre_S").prop("checked", true);
                showentre();
                  jQuery(data.entrevistas).each(function(i, item){ 
                    fecha= item.fecha.split('-');
                    icono='<i class="fas fa-envelope fa-lg msnwarning" onclick="notificar_entrevista('+item.id_entrevista+')" title="Enviar notificación"></i> ';
                    if(item.notificado==1)
                    { icono='<i class="fas fa-envelope fa-lg msnwarningactivo" onclick="notificar_entrevista('+item.id_entrevista+')" title="Notificado"></i> ';}
                    

                    var contendor  = $("#tbody_entrefuncional").html();
                    var nuevaFila   = '<tr>';
                    nuevaFila  += '<td><span id="entrevistador_'+item.id_entrevista+'">'+item.nom_entrevistador+'</span></td>';
                    nuevaFila  += '<td>'+item.email+'</td>';
                    nuevaFila  += '<td>'+item.puesto+'</td>';
                    nuevaFila  += '<td>'+fecha[2]+'-'+fecha[1]+'-'+fecha[0]+' '+item.hora+'</td>';
                    nuevaFila  += '<td class="text-center">';
                    nuevaFila  +=   '<span id="ico_noti_'+item.id_entrevista+'">'+icono+'</span>';
                    nuevaFila  +=   '<input type="hidden" value="'+item.notificado+'" id="notifi_'+item.id_entrevista+'"></td>';
                    nuevaFila  += '<td class="text-center"><i class="fa-solid fa-trash-can fa-lg dell" onclick=delrowentref(this,'+item.id_entrevista+') title="Eliminar entrevista"></i></td>';
                    nuevaFila  += '</tr>';
                    $("#tbody_entrefuncional").html(contendor+nuevaFila);
                  });
                }
                        
            // PASO DE PRESENTACIÓN DE OFERTAS LABORALES
              $('#txt_salario').val(''); 
              $('#sel_tipo_salario').val(0); 
              $('#f_ingreso').val(''); 
              $('#f_terminacion').val(''); 
              $('#sel_tipo_contrato').val('P'); 
              $("#tbody_cartasofl").html('');
              document.getElementById('divdesc_autorizacioncarta_ofl').innerHTML='';
              document.getElementById('div_autorizacioncarta_ofl').style.display='none';
              document.getElementById('divdesc_propuesta_aceptada').innerHTML='';
              document.getElementById('div_propuesta_aceptada').style.display='none';
                jQuery(data.cartas).each(function(i, item){   
                  fechai= item.finicio.split('-');
                  fterminacion="-";
                  if(item.fterminacion!='1900-01-01')
                  {
                    fechat= item.fterminacion.split('-');
                    fterminacion=fechat[2]+'-'+fechat[1]+'-'+fechat[0];
                  }
                  class_texto="text-center text-primary";
                  icono_descarga='<span id="ico_'+item.id+'"><i class="fas fa-download fa-lg activar" onclick="gererapdf('+item.id+')"></i></span>';
                  icono_dell='<i class="fa-solid fa-trash-can dell" onclick=delrow(this,'+item.id+',"cartasofl")></i>';
                  por="-";
                  if(item.descargada_por!=null){  por=item.descargada_por;}
                  if(item.estado==2)
                  { class_texto="text-center text-decoration-line-through text-secondary";
                    icono_descarga='<i class="fas fa-download fa-lg text-secondary"></i>';
                    icono_dell='-';
                  }              
                  if(item.estado==5||item.estado==3)
                  { 
                    icono_descarga='<span id="ico_'+item.id+'"><i class="fas fa-download fa-lg activar" onclick="gererapdf('+item.id+')"></i></span>';
                    $('#num_aprob_ofl').val(item.id);
                    icono_dell='-';

                  //  document.getElementById('div_cartaoferta_aprobacion').style.display='block';
                    document.getElementById('div_autorizacioncarta_ofl').style.display='block';
                    document.getElementById('divdesc_autorizacioncarta_ofl').style.display='none';
                    document.getElementById('div_propuesta_aceptada').style.display='none';
                  
                    if(item.aprobacion_ofl!=null)
                    {
                      document.getElementById('div_autorizacioncarta_ofl').style.display='none';
                      document.getElementById('divdesc_autorizacioncarta_ofl').style.display='block';
                      document.getElementById('div_propuesta_aceptada').style.display='block';
                      $('#divdesc_autorizacioncarta_ofl').html('<a href="'+item.aprobacion_ofl+'" download="Aprobacion"><i class="fas fa-download"></i> Descargar aprobación del jefe de la oferta laboral.</a> <i title="eliminar archivo de aprobación" class="fa-solid fa-trash-can dell" onclick=deldocofl("aprob",'+item.id+')></i>');
                    }                
                    if(item.aceptacion_ofl!=null)
                    { fecha= item.faceptacion.split('-');
                      document.getElementById('div_propuesta_aceptada').style.display="none";                
                      document.getElementById('divdesc_propuesta_aceptada').style.display="block";
                      $('#divdesc_propuesta_aceptada').html('<a href="'+data+'" download="CartaAceptada"><i class="fas fa-download"></i> Descargar aceptación por parte del candidato.</a> <i title="eliminar archivo de aceptación" class="fa-solid fa-trash-can dell" onclick=deldocofl("oflacept",'+$('#num_aprob_ofl').val()+')></i> '+fecha[2]+'-'+fecha[1]+'-'+fecha[0]);
                    }
                  }
                      contendor  = $("#tbody_cartasofl").html();
                      nuevaFila   = '<tr>'+
                    '<td><div class="'+class_texto+'">'+item.id+'</div></td>'+
                    '<td><div class="'+class_texto+'">'+item.salario+'</div></td>'+
                    '<td><div class="'+class_texto+'">'+fechai[2]+'-'+fechai[1]+'-'+fechai[0]+'</div></td>'+
                    '<td><div class="'+class_texto+'">'+fterminacion+'</div></td>'+
                    '<td><div class="'+class_texto+'">'+icono_descarga+'</div></td>'+
                    '</tr>';
                    $("#tbody_cartasofl").html(contendor+nuevaFila); 
                    if((item.estado==1)||(item.estado==5))
                    {
                      $('#txt_salario').val(item.salario); 
                      $('#sel_tipo_salario').val(item.sel_tipo_salario); 
                      $('#f_ingreso').val(item.finicio); 
                      $('#sel_tipo_contrato').val(item.sel_tipo_contrato);
                      $('#f_terminacion').val('');
                      if(item.sel_tipo_contrato=='T')
                      {
                        $('#f_terminacion').val(item.fterminacion);
                      }  
                      hab_f_terminacion(item.sel_tipo_contrato);
                    }
                  });
            // PASO DE DOCUMENTACIÓN, DEPENDIENTES Y CONTACTOS DE URGENCIA
                  document.getElementById('divdesc_record').innerHTML='';
                  document.getElementById('divdesc_ced').innerHTML='';
                  document.getElementById('divdesc_carnet_css').innerHTML=''; 
                  document.getElementById('divdesc_certificado_nacimiento').innerHTML=''; 
                  document.getElementById('divdesc_constancia_dir').innerHTML=''; 
                  document.getElementById('divdesc_dimploma').innerHTML=''; 
                  document.getElementById('divdesc_foto').innerHTML='';
                  
                  document.getElementById('divdesc_record').style.display='none';
                  document.getElementById('divdesc_ced').style.display='none';
                  document.getElementById('divdesc_carnet_css').style.display='none';
                  document.getElementById('divdesc_certificado_nacimiento').style.display='none';
                  document.getElementById('divdesc_constancia_dir').style.display='none';
                  document.getElementById('divdesc_dimploma').style.display='none';
                  document.getElementById('divdesc_foto').style.display='none';

                  document.getElementById('filerecord').value='';
                  document.getElementById("fileced").value='';
                  document.getElementById("filecarnet_css").value=''; 
                  document.getElementById("filecertificado_nacimiento").value=''; 
                  document.getElementById("fileconstancia_dir").value=''; 
                  document.getElementById("filedimploma").value=''; 
                  document.getElementById("filefoto").value='';

                  document.getElementById("div_record").style.display='block';
                  document.getElementById("div_ced").style.display='block';
                  document.getElementById("div_carnet_css").style.display='block';
                  document.getElementById("div_certificado_nacimiento").style.display='block';
                  document.getElementById("div_constancia_dir").style.display='block';
                  document.getElementById("div_dimploma").style.display='block';
                  document.getElementById("div_foto").style.display='block';
                  jQuery(data.docatach).each(function(i, item){  

                    optarchi='-';
                    if(item.iddoc==1){  optarchi='record';}
                    if(item.iddoc==2){  optarchi='ced';}
                    if(item.iddoc==3){  optarchi='certificado_nacimiento';}
                    if(item.iddoc==4){  optarchi='carnet_css';}
                    if(item.iddoc==5){  optarchi='constancia_dir';}
                    if(item.iddoc==6){  optarchi='dimploma';}
                    if(item.iddoc==7){  optarchi='foto';}

                    if(optarchi!='-')
                    {  
                      $('#divdesc_'+optarchi).html('<a href="'+item.nomdoc+'" download="Docum_'+optarchi+'"><i class="fas fa-download"></i> Descargar documento.</a> <i title="Eliminar documento" class="fa-solid fa-trash-can dell" onclick=deldocofl("'+optarchi+'",'+item.id+')></i>');
                      document.getElementById('divdesc_'+optarchi).style.display="block";
                      document.getElementById('div_'+optarchi).style.display="none";}
                  });
                  
                  document.getElementById('nombre_dependiente').value="";
                  document.getElementById('sel_parentesco').value="0";
                  document.getElementById('fech_nac_dependiente').value="";
                  $("#tbody_dependientes").html('');
                  jQuery(data.dependientes).each(function(i, item)
                  { fecha= item.f_nacimiento.split('-');
                    contendor  = $("#tbody_dependientes").html();
                    nuevaFila   = '<tr>'+
                      '<td>'+item.nombre+'</td>'+
                      '<td><span class="text-center">'+item.parentesco+'</span></td>'+
                      '<td><span style="text-align:center">'+fecha[2]+'-'+fecha[1]+'-'+fecha[0]+'</span></td>'+
                      '<td style="text-align:center"><i class="fa-solid fa-trash-can fa-lg dell" onclick=delrowdepend(this,'+item.id+') title="Eliminar dependiente"></i></td>'+
                      '</tr>';
                    $("#tbody_dependientes").html(contendor+nuevaFila); 
                  });

                  document.getElementById('nombre_contacto').value="";
                  document.getElementById('tel_contacto').value="";
                  $("#tbody_contactos").html('');
                
                  jQuery(data.contactos).each(function(i, item){   
                  
                    contendor  = $("#tbody_contactos").html();
                    nuevaFila   = '<tr>'+
                    '<td>'+item.nombre+'</td>'+
                    '<td><span class="text-center">'+item.contacto+'</span></td>'+
                    '<td style="text-align:center"><i class="fa-solid fa-trash-can fa-lg dell" onclick=delrowcontactos(this,'+item.id+') title="Eliminar contacto"></i></td>'+
                    '</tr>';
                    $("#tbody_contactos").html(contendor+nuevaFila); 
                  });
                  jQuery(data.valida_sipe).each(function(i, item){  
                    document.getElementById('chk_val_sipe').checked=''; 
                    document.getElementById('chk_val_marcacion').checked=''; 
                  if(item.valida_sipe==1)
                  {  document.getElementById('chk_val_sipe').checked='checked';}
                  if(item.marcacion==1)
                  {  document.getElementById('chk_val_marcacion').checked='checked';}
                  
                });
            // GENERAR CONTRATO DE TRABAJO
              jQuery(data.info_contrato).each(function(i, item){
                $('#lb_contrato_PAGADORA').html(item.PAGADORA);
                $('#lb_nom_cia').html(item.nom_cia);
                $('#lb_contrato_unidad').html(item.nameund);
                
                $('#lb_pos').html(item.descpue);     
                $('#lb_salario').html(item.salario);
                if(item.sel_tipo_salario='H'){ tiposalario="POR HORA";}    
                if(item.sel_tipo_salario='B'){ tiposalario="BASE";}     
                $('#lb_tipo_sal').html(tiposalario);

                ticocont='-';
                if(item.sel_tipo_contrato=='T') { ticocont="DEFINIDO";}
                if(item.sel_tipo_contrato=='P') { ticocont="INDEFINIDO";}
                $('#lb_tipo_contrato_contrato').html(ticocont);       
                
                fechai_cont= item.finicio.split('-');
                $('#lb_finicio ').html(fechai_cont[2]+'-'+fechai_cont[1]+'-'+fechai_cont[0]);

                fechaf_cont="-";
                if(item.fterminacion!='1900-01-01')
                {
                  fechat= item.fterminacion.split('-');
                  fechaf_cont=fechat[2]+'-'+fechat[1]+'-'+fechat[0];
                }


              });
          
            }
            else{
              if(data.paso==7)
              {   fecha= data.contrato_finicio.split('-');
              
                document.getElementById('div_7').style.display='none';
                document.getElementById('div_8').style.display='block';
                  document.getElementById('bto_volver_descarte').style.display='none';
                  document.getElementById('bto_guarda_descarte').style.display='none';
                  document.getElementById('div_pasos').style.display='none';
                  
                  document.getElementById('f_ingreso_contrato').innerHTML="Fecha de ingreso: "+fecha[2]+'-'+fecha[1]+'-'+fecha[0]
                }
              else
              {
                if(data.paso==8)
                { document.getElementById('div_7').style.display='block';
                  document.getElementById('div_8').style.display='none';
                  document.getElementById('div_pasos').style.display='none';
                  document.getElementById('txt_area_descarte').disabled = true;
                  document.getElementById('bto_volver_descarte').style.display='none';
                  document.getElementById('bto_guarda_descarte').style.display='none';
                  document.getElementById('chk_descarte').checked = false;
                  document.getElementById('chk_descarte').disabled = true;
                  document.getElementById('txt_area_descarte').value=data.motivo_descarte;
                  if(data.estado_registro==2)
                  { document.getElementById('chk_descarte').checked = true; }
                }
              }
            }
          }
      });
  }
 
  //----- GENERA PDF CARTA OFERTA
  function gererapdf(id){
    
    $("#idformulario").html('');
        var form = $("<form/>", 
        {   action:"{{ route('ofertas.cartapdf') }}" , 
            method : 'POST',
            id:'from_cart'}
          );
        form.append( $("<input>", { type :'hidden', id  :  'txtid',  name :'txtid',  value: id } ));
        form.append( $("<input>", { type  :'hidden', id   :'tok', name  :'tok', value : $('input[name="_token"]').val() }));
        form.append( $("<input>", { type :'hidden', id  :  'opt',  name :'opt',  value: 0 } ));
        form.append('@csrf');
        $("#idformulario").append(form);

        var _token = $('input[name="_token"]').val();
        var parametros = {
        "txtid" : id,
        "opt" : 1 ,
        "_token":_token};
        $.ajax({
          data:  parametros, 
          url:   "{{ route('ofertas.cartapdf') }}",
          type:  'POST', 
          cache: true,       
          beforeSend: function () {
              document.getElementById("ico_"+id).innerHTML='<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
              from_cart.submit();
            }, 
          success:  function (data) {  
            if(data==1)        
            {  
              document.getElementById('div_autorizacioncarta_ofl').style.display='block';
              document.getElementById("ico_"+id).innerHTML='<i class="fas fa-download fa-lg activar" onclick="gererapdf('+id+')"></i>';
            }
          }
        });
  }

  // ----- GENERA PDF DE CONTRATO DE TRABAJO
  function gererapdfcontrato()
  { 
    $("#idformulariocontrato").html('');
        var form = $("<form/>", 
        {   action:"{{ route('ofertas.cartapdfcontrato') }}" , 
            method : 'POST',
            id:'from_contwork'}
          );
        form.append( $("<input>", { type :'hidden', id  :  'id_curri_cont',  name :'id_curri_cont',  value: $('#id_curri').val() } ));
        form.append( $("<input>", { type :'hidden', id  :  'id_participante_cont',  name :'id_participante_cont',  value: $('#id_participante').val() } ));
        form.append( $("<input>",  { type  :'hidden', id   :'tok_cont', name  :'tok_cont', value : $('input[name="_token"]').val() }));
        form.append( $("<input>", { type :'hidden', id  :  'opt_cont',  name :'opt_cont',  value: 0 } ));
        form.append('@csrf');
        $("#idformulariocontrato").append(form);

        var _token = $('input[name="_token"]').val();
        var parametros = {
        "id_participante_cont" : $('#id_participante').val(),
        "opt_cont" : 1 ,
        "_token":_token};
        $.ajax({
          data:  parametros, 
          url:   "{{ route('ofertas.cartapdfcontrato') }}",
          type:  'POST', 
          cache: true,       
          beforeSend: function () {
              from_contwork.submit();
            }, 
          success:  function (data) {  
            if(data==1)        
            {  
              document.getElementById('div_autorizacioncarta_ofl').style.display='block';
              document.getElementById("ico_"+id).innerHTML='<i class="fas fa-download fa-lg activar" onclick="gererapdf('+id+')"></i>';
            }
          }
        });
  }

  //----- ELIMINA DOCUMENTO DE APROBACIÓN
  function deldocofl(optdoc,id)
  {  quest="Desea eliminar este documento?";
    if(optdoc=='aprob'){  quest="Desea eliminar el documento de aprobación de la oferta laboral?";}
    if(optdoc=='oflacept'){ quest="Desea eliminar el documento de aceptación de la oferta laboral por parte del candidato?";}
    
    var _token = $('input[name="_token"]').val();
    Swal.fire({
      text: quest,
      icon: "question",
      showCancelButton: true,
      cancelButtonText:  '<i class="fas fa-arrow-left"></i> Cancelar',
      confirmButtonText: '<i class="fas fa-trash-alt"></i> Si, eliminar',
      confirmButtonColor: "#d33",
      }).then((result) => {
        if (result.isConfirmed) 
        {
          var parametros = {
          "id": id,
          "optdoc": optdoc,
          "_token": _token};
          $.ajax({
            data:  parametros, 
            url:   "{{ route('ofertas.deldoc') }}",
            type:  'POST', 
            dataType: "json",
            cache: false,          
            success:  function (data) { 
              if(optdoc=='aprob'){
                if(data.resp==1)
                { document.getElementById('div_autorizacioncarta_ofl').style.display='block';
                  document.getElementById('divdesc_autorizacioncarta_ofl').style.display='none';
                  document.getElementById('div_propuesta_aceptada').style.display='none';
                  document.getElementById('divdesc_autorizacioncarta_ofl').innerHTML='';    
                  document.getElementById('fileaprobacionpropuesta').value="";                  
                  document.getElementById("div_banges_"+$('#id_curri').val()).innerHTML=data.banges;
                  $('#txt_paso').val(data.paso);
                }else
                { mal('No fue posible eliminar el archivo de aprobación, debido a que existe una aceptación adjunta por parte del candidato'); }
              }
              else
              { if(optdoc=='oflacept'){
                  if(data.resp==1)
                  { document.getElementById('divdesc_propuesta_aceptada').style.display='none';
                    document.getElementById('divdesc_propuesta_aceptada').innerHTML='';    
                    document.getElementById('div_propuesta_aceptada').style.display="block";
                    document.getElementById('filepropuestaaceptada').value="";
                    document.getElementById("div_banges_"+$('#id_curri').val()).innerHTML=data.banges;
                    $('#txt_paso').val(data.paso);
                  }
                    else
                  { mal('No fue posible eliminar el archivo de aceptación por parte del candidato'); }
                }
                else
                {
                  document.getElementById('divdesc_'+optdoc).style.display="none";
                  $('#divdesc_'+optdoc).html('');
                  document.getElementById('file'+optdoc).value="";
                  document.getElementById('div_'+optdoc).style.display="block";
                  document.getElementById("div_banges_"+$('#id_curri').val()).innerHTML=data.banges;
                  $('#txt_paso').val(data.paso);
                }
              }
            }
          });
        };
      });
  }

    //----- BUSCA RESPUESTAS DE PRUEBA PSICOMÉTRICAS
  function find_respsico(sel_prueba,id_rep)
  { 
    if(sel_prueba!=0)
    { var _token = $('input[name="_token"]').val();
        var parametros = {
        "sel_prueba" : sel_prueba,
        "_token":_token};
        $.ajax({
          data:  parametros, 
          url:   "{{ route('ofertas.fin_respsico') }}",
          type:  'POST', 
          dataType: "json",
          cache: true,       
          beforeSend: function () {
              document.getElementById("iddiv_resul_psico").innerHTML='<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
            }, 
          success:  function (data) { 
            if(data.resp==1)
            { var cadena='';var sel="";
              jQuery(data.resppruebaspsico).each(function(i, item){
                sel="";
                if(id_rep==item.id){ sel="selected";}
                cadena+="<option value='"+ item.id+"' "+sel+">"+ item.respuesta+ "</option>"; 
              });
              document.getElementById("iddiv_resul_psico").innerHTML='<select id="pruebapsico_resultado" class="form-select form-select-sm">'+
                  '<option value="0">Seleccionar</option>'+cadena+'</select>';
            }
            else{
              $('#iddiv_resul_psico').html('<input type="text" class="form-control form-control-sm" id="pruebapsico_resultado" max="30" value="'+id_rep+'">');
            }
          }
        });
    }
    else
    { $('#iddiv_resul_psico').html('<input type="text" class="form-control form-control-sm" id="pruebapsico_resultado" max="30" value="" disabled>');}
  }

  //----- MUESTRA EL DETALLE DE UNA OFERTA LABORAL
  function busca_ofl(id_ofl)
  { 
    var _token = $('input[name="_token"]').val();
    limpiar();
    
    var parametros = {
      "id_ofl" : id_ofl,
      "_token":_token};
      $.ajax({
        data:  parametros, 
        url:   "{{ route('ofertas.show') }}",
        type:  'POST', 
        dataType: "json",
        cache: true,       
        beforeSend: function () {
            document.getElementById("lb_id_sol").innerHTML='<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
          }, 
        success:  function (data) { 
          jQuery(data).each(function(i, item){
            document.getElementById("sel_status").style.display='block';
            document.getElementById("sel_status").value=item.id_estatus;
            document.getElementById('lb_id_sol').innerHTML=id_ofl;
            document.getElementById("id_ofl_txt").value=item.id;
            document.getElementById("lb_f_sol").value=item.fecha_sol;
            document.getElementById("lb_f_lim").value=item.fecha_tope;
            document.getElementById("lb_ue").value=item.unidad_economica;
            document.getElementById("lb_PAGADORA").value=item.PAGADORA;
            document.getElementById("lb_ceco").value=item.ceco;
            document.getElementById("lb_secc").value=item.seccion;
            document.getElementById("lb_nom_posicion_sol").value=item.descpue;
            document.getElementById("lb_cant").innerHTML=item.cantidad;
            document.getElementById("lb_genero").value=item.genero;
            document.getElementById("lb_edad").value=item.rango_edad;
            document.getElementById("lb_motivo").value=item.motivo;
            document.getElementById("lb_doc_aut").innerHTML="";
            document.getElementById("lb_aprobado").innerHTML=item.aprobado;
            document.getElementById("lb_real").innerHTML=item.countreal;
            if(item.autorizacion!='-')
            { document.getElementById("lb_doc_aut").innerHTML='<a href="docs/'+item.autorizacion+'" download="'+item.autorizacion+'"><i class="fas fa-download"></i> Descargar autorización</a>'}
            document.getElementById("lb_coment").value=item.comentarios;
            document.getElementById("lb_por").innerHTML=item.usrname;

            document.getElementById('lb_id_sol_rech').innerHTML=id_ofl;
            document.getElementById("lb_nom_posicion_sol_rech").value=item.descpue;
            document.getElementById("lb_cant_rech").value=item.cantidad;
            
          });
       }
      });
  }
  
  //----PARA CAMBIAR EL ESTADO DE LA OFERTE LABORAL
  function su()
  {
    var _token = $('input[name="_token"]').val();
    id_estatus=document.getElementById("sel_status").value;
    id_ofl_txt=document.getElementById("id_ofl_txt").value;

    if(id_estatus=='2')
    { var parametros = {
      "_token":_token,
      "id_estatus" : id_estatus,
      "id_ofl" : id_ofl_txt};
      $.ajax({
        data:  parametros, 
        url:   "{{ route('ofertas.update') }}",
        type:  'POST', 
        dataType: "json",
        cache: true,  
        success:  function (data) { 
          jQuery(data).each(function(i, item){             
            document.getElementById('divico_'+id_ofl_txt).innerHTML=
              '<div class="dropdown py-0">'+
                '<button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">Acciones</button>'+
                '<ul class="dropdown-menu p-0" aria-labelledby="dropdownMenu2">'+
                  '<li><button class="dropdown-item" type="button" onclick="mod_prospectos('+id_ofl_txt+')" data-bs-toggle="modal" data-bs-target="#modalprooectos">'+item.icono+' Ver Candidatos</button></li>'+
                  '<li><button class="dropdown-item" type="button" onclick="newpart()" data-bs-toggle="modal" data-bs-target="#modalnuevoprooectos"><i class="fas fa-user-plus text-success"></i> Nuevo Candidato</button></li>'+
                '</ul>'+
              '</div>';
            
            
            limpiar();  
            $('#modalsoli').modal('hide');
            bien("El estado de la solicitud ha cambiado.");
          });
        }
      });
    }
    if(id_estatus=='4')
    { $('#modalsoli').modal('hide');
      $('#Modal_del').modal('show');
    }
  }
  
  //---- RECHAZANDO UNA OFERTA LABORAL ------ AQUI SE DEBE ENVIA LA NOTIFICACIÓN DE RECHAZO AL SOLICITANTE
  function re()
  {
    var _token = $('input[name="_token"]').val();
    var txt_area_observacion= document.getElementById("txt_area_observacion").value;
    var id_estatus= document.getElementById("sel_status").value;
    var id_ofl_txt= document.getElementById("id_ofl_txt").value;
    Swal.fire({
      text: "Se rechazará la solicitud, desea continuar?",
      showCancelButton: true,
      cancelButtonText:  '<i class="fas fa-arrow-left"></i> Cancelar',
      confirmButtonText: '<i class="fas fa-trash-alt"></i> Si, rechazar',
      confirmButtonColor: "#d33",
      }).then((result) => {
  
        if (result.isConfirmed) 
        {
          if(txt_area_observacion.length>='10')
          { 
            var parametros = {
            "_token":_token,
            "txt_area_observacion" : txt_area_observacion,
            "id_estatus" : id_estatus,
            "id_ofl" : id_ofl_txt};
            $.ajax({
              data:  parametros, 
              url:   "{{ route('ofertas.update') }}",
              type:  'POST', 
              dataType: "json",
              cache: true,      
              beforeSend: function () {
                  document.getElementById("lb_id_sol_rech").innerHTML='<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
              }, 
              success:  function (data) { 
            const table = new DataTable('#MyTable');
            table.clear().draw();      
            jQuery(data).each(function(i, item){           
              fsol=item.fecha_sol.split('-');
              fcie=item.fecha_tope.split('-');
              table.row.add([
              '<div class="text-center">'+item.id+'</div>',
              '<div class="text-center">'+fsol[0].substring(0,2)+'-'+fsol[1]+'-'+fsol[0]+'</div>',
              '<div class="text-center">'+fcie[2]+'-'+fcie[1]+'-'+fcie[0]+'</div>',
              item.unidad_economica,
              item.seccion,
              item.descpue,
              '<div class="text-center">'+item.cantidad+'</div>',
              '<div class="text-center">'+item.proceso+'</div>',
              '<div class="text-center">'+item.contratados+'</div>',
              '<div class="text-center"><div onclick="busca_ofl('+item.id+')" data-bs-toggle="modal" data-bs-target="#modalsoli">'+item.icono+'</div></div>'
              ]).draw(false);
            });
                limpiar();  
                $('#Modal_del').modal('hide');
                $('#modalsoli').modal('hide');
                bien("La solicitud de contraración ha sido rechazada.")
            }
            });
          }
          else{
            Swal.fire({
              icon: "warning",
              text: "Por favor detallar un poco más el motivo del rechazo.",
            });
          }
        } 
      });
  }

  //----- LIMPIA FORMULARIO DE DETALLE DE LA SOLICITUD
  function limpiar()
  {
    document.getElementById("sel_status").style.display='none';
    document.getElementById("sel_status").value=1;  
    document.getElementById("id_ofl_txt").value='';
    document.getElementById("lb_f_sol").value='';
    document.getElementById("lb_f_lim").value='';
    document.getElementById("lb_ue").value='';
    document.getElementById("lb_secc").value='';
    document.getElementById("lb_nom_posicion_sol").value='';
    document.getElementById("lb_cant").value='';
    document.getElementById("lb_genero").value='';
    document.getElementById("lb_edad").value='';
    document.getElementById("lb_motivo").value='';
    document.getElementById("lb_doc_aut").innerHTML='';
    document.getElementById("lb_doc_aut").innerHTML='';
    document.getElementById("lb_coment").value='';
    document.getElementById("lb_por").innerHTML='';

    document.getElementById('lb_id_sol').innerHTML='';
    document.getElementById("txt_area_observacion").value='';

    document.getElementById('lb_posicion').innerHTML='';
    document.getElementById('lb_cant_part').innerHTML='';
    document.getElementById('lb_proceso_part').innerHTML='';
    document.getElementById('lb_cont_part').innerHTML='';
    document.getElementById('lb_numofl').innerHTML='';
    document.getElementById("lb_por_part").innerHTML='';
    document.getElementById("lb_fech_sol").innerHTML='';
    document.getElementById("lb_fech_tope").innerHTML='';



  }

  //----- LIMPIA FORMULARIO DE NUEVO PARTICIPANTE
  function limpia_frm()
  {
    
    document.getElementById("prinombre").value='';
    document.getElementById("segnombre").value='';
    document.getElementById("priapellido").value='';
    document.getElementById("segapellido").value='';
    document.getElementById("sel_provincias").value=0;
    document.getElementById("sel_distrito").value=0;
    document.getElementById("sel_corregimiento").value=0;
    document.getElementById("direc").value='';
    
    document.getElementById("f_nacimiento").value='';
    document.getElementById("sel_nacionalidad").value=0;
    document.getElementById("num_docip").value='';
    document.getElementById("f_vencimiento_docip").value='';
    document.getElementById("telefono").value='';
    document.getElementById("mail").value='';

    document.getElementById("sel_tipopermiso").value=0;
    document.getElementById("f_vence_permiso").value='';
    document.getElementById("filepermiso").value='';
    
    document.getElementById("sel_discapacidad").value='NO';
    document.getElementById("explique_disc").value='';
    
    document.getElementById('tbody_experiencia').innerHTML='';
    document.getElementById('tbody_educacion').innerHTML='';
    document.getElementById('tbody_cursos').innerHTML='';
    document.getElementById('tbody_referencias').innerHTML='';

    document.getElementById("filecv").value='';

    document.getElementById('filecv').style="border-color:none;";
    document.getElementById('nombre_referencia').style="border-color:none;";
    document.getElementById('entidad_educ').style="border-color:none;";
    document.getElementById('mail').style="border-color:none;";
    document.getElementById('telefono').style="border-color:none;";
    document.getElementById('f_vencimiento_docip').style="border-color:none;";
    document.getElementById('num_docip').style="border-color:none;";
    document.getElementById('sel_nacionalidad').style="border-color:none;";
    document.getElementById('f_nacimiento').style="border-color:none;";
    document.getElementById('direc').style="border-color:none;";
    document.getElementById('priapellido').style="border-color:none;";
    document.getElementById('prinombre').style="border-color:none;";
    document.getElementById('filepermiso').style="border-color:none;";
    document.getElementById('f_vence_permiso').style="border-color:none;";
    document.getElementById('sel_tipopermiso').style="border-color:none;";

    document.getElementById('div_autorizacioncarta_ofl').style.display="none";
    document.getElementById('divdesc_autorizacioncarta_ofl').style.display="none";
  


  }
  
  //----- LISTADO DE PARTICIPANTES
  function mod_prospectos(id_ofl)
  { 
    limpia_frm();

    var _token = $('input[name="_token"]').val();
    document.getElementById('lb_numofl').innerHTML='SOLICITUD # <span class="fw-bold">'+id_ofl+'</span><input type="hidden" id="id_ofl" value="'+id_ofl+'"></input>';
    document.getElementById('lb_posicion').innerHTML='Posición: <span class="text-secondary"><b>'+document.getElementById('despue_'+id_ofl).innerHTML+'</b></span>';
    document.getElementById('lb_por_part').innerHTML='Solicitado por: <span class="text-secondary"><b>'+document.getElementById('name_'+id_ofl).value+'</b></span>';
    document.getElementById('lb_cant_part').innerHTML='Cantidad Solicitada:</b> <span class="text-secondary"><b>'+document.getElementById('cantsol_'+id_ofl).innerHTML+'</b></span>';
    document.getElementById('lb_proceso_part').innerHTML='Candidatos: <span class="text-secondary"><b>'+document.getElementById('cantpart_'+id_ofl).innerHTML+'</b></span>';
    document.getElementById('lb_cont_part').innerHTML='Contratados: <span class="text-secondary"><b>'+document.getElementById('cantcont_'+id_ofl).innerHTML+'</b></span>';
    document.getElementById("lb_fech_sol").innerHTML='Fecha de Solicitud: <span class="text-secondary"><b>'+document.getElementById('fech_sol_'+id_ofl).innerHTML+'</b></span>';
    document.getElementById("lb_fech_tope").innerHTML='Fecha de cierre: <span class="text-secondary"><b>'+document.getElementById('fech_tope_'+id_ofl).innerHTML+'</b></span>';

    document.getElementById('lb_numofl_etapa_contra').innerHTML= ' '+document.getElementById('despue_'+id_ofl).innerHTML;
  
    var parametros = {
      "_token":_token,
      "id_ofl" : id_ofl};
    $.ajax({
      data:  parametros, 
      url:   "{{ route('ofertas.edit') }}",
      type:  'POST', 
      dataType: "json",
      cache: true, 
      success:  function (data) { 
    //    jQuery(data).each(function(i, item){           
          document.getElementById("tbody_aspirantes").innerHTML="";
          i=0;
          var nuevaFila   = '';
          jQuery(data).each(function(i, item){
            i++;
            if(item.prinombre!=null){
          var segnombre='';  var segapellido=''; 
          if(item.segnombre!=null){segnombre=item.segnombre;}   
          if(item.segapellido!=null){segapellido=item.segapellido;}  
          nombre_completo=item.prinombre+' '+segnombre+' '+item.priapellido+' '+segapellido;
              nuevaFila  += '<tr>';
              nuevaFila  += '<td>'+item.num_doc+'</td>';
              nuevaFila  += '<td>'+nombre_completo+'</td>'; 
              nuevaFila  += '<td>'+item.tel+'</td>';
              nuevaFila  += '<td>'+item.email+'</td>';
              nuevaFila  += '<td class="text-center"><span id="div_banges_'+item.id_curri+'">'+item.banges+'</span></td>';
              nuevaFila  += '<td class="text-center"><i class="fas fa-search edit pr-2" data-bs-toggle="modal" data-bs-target="#modaletapas_cont" onclick=edit_etapa_part('+item.id_curri+','+item.id_participante+')></i><span class="p-1"> </span><i class="fas fa-trash-alt dell" onclick=delprospecto(this,"prospectos",'+item.id_participante+')></i></td>';
              nuevaFila  += '</tr>';
            }
          });
          $("#tbody_aspirantes").html(nuevaFila);
      //  });
      }
    });
  }

  //----- ELIMINA FILA DEL PARTICIPANTE SIN ELIMINAR EL REGISTRO DE LA HOJA DE VIDA
  function delprospecto(thisrow,nomtable,idparti)
  {
    var _token = $('input[name="_token"]').val();
    var id_ofl=$('input[id="id_ofl"]').val();
    Swal.fire({
      text: "Se eliminará el candidato de la solicitud; sin embargo, la hoja de vida querará almacenada en la base de datos.",
      showCancelButton: true,
      icon: "info",
      confirmButtonText: '<i class="fas fa-trash-alt"></i> Eliminar',
      cancelButtonText:  '<i class="fas fa-arrow-left"></i> Cancelar',
      confirmButtonColor: "#d33",
    }).then((result) => {
        if (result.isConfirmed) {
          var parametros = {
            "_token":_token,
            "id_ofl":id_ofl,
            "idparti":idparti};
          $.ajax({
            data:  parametros, 
            url:   "{{ route('ofertas.destroy') }}",
            type:  'POST', 
            dataType: "json",
            cache: true, 
            success:  function (data) { 
              jQuery(data).each(function(i, item){       
                //document.getElementById('lb_proceso_part').innerHTML= 'Candidatos: <span class="text-secondary"><b>'+data.conteos+'</b></span>';
                //document.getElementById('cantpart_'+id_ofl).innerHTML= data.conteos;
                //document.getElementById('lb_cont_part').innerHTML='Contratados: <span class="text-secondary"><b>'+data.conteoscontratados+'</b></span>';
                //document.getElementById('cantcont_'+id_ofl).innerHTML= data.conteoscontratados;


                document.getElementById('lb_proceso_part').innerHTML= 'Candidatos: <span class="text-secondary"><b>'+data.cant_proceso+'</b></span>';
                document.getElementById('lb_cont_part').innerHTML='Contratados: <span class="text-secondary"><b>'+data.cant_contratado+'</b></span>';

                document.getElementById('cantpart_'+data.id_ofl).innerHTML= data.cant_proceso;
                document.getElementById('cantinicial_'+data.id_ofl).innerHTML=  data.cant_inicial;
                document.getElementById('cantfuncional_'+data.id_ofl).innerHTML=  data.cant_funcional;
                document.getElementById('cantofertalaboral_'+data.id_ofl).innerHTML=  data.cant_ofertalaboral;
                document.getElementById('cantdocumentacion_'+data.id_ofl).innerHTML=  data.cant_documentacion;
                document.getElementById('cantfirma_'+data.id_ofl).innerHTML=  data.cant_firma;

                document.getElementById('cantcont_'+data.id_ofl).innerHTML= data.cant_contratado;

                if(data.eliminado==0){  delrow(thisrow,nomtable);}
                if(data.eliminado==1){  mal("Imposoble eliminar el candidato, debido al estatus que mantiene");}
              });
            }
          });
        } 
      });
  }

  //----- MUESTRA MODAL DE NUEVO PARTICIPANTE
  function newpart()
  {
    $('#modalprooectos').modal('hide');
    $('#modalnuevoprooectos').modal('show');
  }

  //-----BUSCADOR DE DISTRITO Y CORREGIMIENTO
  function buscarlugar(opt_find,sel)
  { 
    var _token = $('input[name="_token"]').val();
    var parametros = {
    "_token":_token,
    "opt_find" : opt_find,
    "sel" : sel};
    $.ajax({
      data:  parametros, 
      url:   "{{ route('ofertas.finddistcor') }}",
      type:  'POST', 
      dataType: "json",
      cache: true, 
      success:  function (data) { 
                  
        $('#sel_'+opt_find).empty();
        $('#sel_'+opt_find).append("<option value='0'>Seleccionar</option>"); 
          jQuery(data).each(function(i, item){  
            $('#sel_'+opt_find).append("<option value='"+ item.id+"'>"+ item.lugar+ "</option>"); 
          });
          $('#sel_'+opt_find).removeAttr("disabled");
      }
    });
  }

 

  //----- MUESTRA SECCIÓN PARA ADJUNTAR EL PERMISO
  function showpermiso()
  {   
    if(document.getElementById('nacext_N').checked)
    { document.getElementById("div_permiso_trab").style.display="none";}
    if(document.getElementById('nacext_E').checked)
    { document.getElementById("div_permiso_trab").style.display="block";}
  }
  
  //----- MUESTRA SECCIÓN PARA VALIDACIÓN DE REFERENCIAS
  function showval_ref()
  {   
    if(document.getElementById('ref_N').checked)
    { document.getElementById("div_referencias_val").style.display="none";}
    if(document.getElementById('ref_S').checked)
    { document.getElementById("div_referencias_val").style.display="block";}
  }
    
  //----- MUESTRA FECHA DE TERMINACIÓN
  function hab_f_terminacion(opt)
  { 
    if(opt=='T'){  document.getElementById('lb_f_terminacion').style.display='block'; document.getElementById('f_terminacion').style.display='block';}
    if(opt=='P'){   document.getElementById('lb_f_terminacion').style.display='none'; document.getElementById('f_terminacion').style.display='none';}
  }

  //----- MUESTRA SECCIÓN PARA VALIDACIÓN DE REFERENCIAS
  function showentre()
  {   
    if(document.getElementById('entre_N').checked)
    { document.getElementById("div_entrevistas").style.display="none";}
    if(document.getElementById('entre_S').checked)
    { document.getElementById("div_entrevistas").style.display="block";}
  }

  //----- MUESTRA SECCIÓN PARA COMPENSACIÓN Y BENEFICIOS
  function showcompen()
  {   
    if(document.getElementById('compen_N').checked)
    { document.getElementById("div_compensaciones").style.display="none";}
    if(document.getElementById('compen_S').checked)
    { document.getElementById("div_compensaciones").style.display="block";}
  }

  //-----AGREGA NUEVO PARTICIPANTE
  function valida()
  {
    var validEmail =  /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
    var _token = $('input[name="_token"]').val();
    var id_ofl=$('input[id="id_ofl"]').val();
    var prinombre = $('input[id="prinombre"]').val();
    var segnombre = $('input[id="segnombre"]').val();
    var priapellido = $('input[id="priapellido"]').val();
    var segapellido = $('input[id="segapellido"]').val();
    var num_ss = $('input[id="num_ss"]').val();
    var sel_estadocivil = $('#sel_estadocivil').val();
    var f_nacimiento = $('#f_nacimiento').val();
    var sel_nacionalidad = $('#sel_nacionalidad').val();
    var sel_tipodoc = $('#sel_tipodoc').val();
    var num_docip = $('#num_docip').val();
    var f_vencimiento_docip = $('#f_vencimiento_docip').val();
    var telefono = $('#telefono').val();
    var mail = $('#mail').val();
    var sel_provincias = 0; 
        if($('#sel_provincias').val()>0){ sel_provincias=$('#sel_provincias').val();}
    var sel_distrito = 0; 
        if($('#sel_distrito').val()>0){ sel_distrito=$('#sel_distrito').val();}
    var sel_corregimiento = 0; 
        if($('#sel_corregimiento').val()>0){ sel_corregimiento=$('#sel_corregimiento').val();}
    var dir = $('#direc').val();
    var sel_discapacidad = $('#sel_discapacidad').val();
    var explique_disc = $('#explique_disc').val();
    var cv_doc= document.getElementById("filecv").files;  

    var dsel_tipopermiso = $('select[id="sel_tipopermiso"] option:selected').text();
    var df_vence_permiso = $('#f_vence_permiso').val();
    var dfilepermiso = document.getElementById("filepermiso").files;
    var genero = '';
    let checked = $('input[name="sel_genero"]:checked');
      $('[name="sel_genero[]"]:checked').map(function(){
        if (this.checked) {
          //secciones.push($(this).val());
          genero=$(this).val();
        }
    });
    var nacio_extran = '';
     checked = $('input[name="nacext"]:checked');
      $('[name="nacext[]"]:checked').map(function(){
        if (this.checked) {
          //secciones.push($(this).val());
          nacio_extran=$(this).val();
        }
    });


    var empresa_exp= new Array();var puesto_exp= new Array();var area_exp= new Array();var desde_exp= new Array();var hasta_exp= new Array();
    var nrows_exp = $("#tbody_experiencia tr").length;
    var datos_exp  = [];
    var objeto_exp = {};
    for (var x = 0; x < nrows_exp; x++) 
    { 
      empresa_exp[x] = document.getElementById('tbody_experiencia').getElementsByTagName("tr")[x].getElementsByTagName("td")[0].innerHTML;
      puesto_exp[x] = document.getElementById('tbody_experiencia').getElementsByTagName("tr")[x].getElementsByTagName("td")[1].innerHTML;
      area_exp[x] = document.getElementById('tbody_experiencia').getElementsByTagName("tr")[x].getElementsByTagName("td")[2].innerHTML;
      desde_exp[x] = document.getElementById('tbody_experiencia').getElementsByTagName("tr")[x].getElementsByTagName("td")[3].innerHTML;
      hasta_exp[x] = document.getElementById('tbody_experiencia').getElementsByTagName("tr")[x].getElementsByTagName("td")[4].innerHTML;

      datos_exp.push({ 
      "empresa_exp" : empresa_exp[x],
      "puesto_exp"  : puesto_exp[x],
      "area_exp"    : area_exp[x],
      "desde_exp"   : desde_exp[x],
      "hasta_exp"   : hasta_exp[x]
      });
    }

    //objeto_exp.rows = nrows_exp;
    objeto_exp.datos_exp = datos_exp;
    datajson_exp=JSON.stringify(objeto_exp);
    //console.log(JSON.stringify(objeto_exp));

    var entidad_edu= new Array(); var titulo_edu= new Array(); var nivel_edu= new Array(); var estatus_edu= new Array(); var desde_edu= new Array(); var hasta_edu= new Array();
    var nrows_edu = $("#tbody_educacion tr").length;
    var datos_edu  = [];
    var objeto_edu = {};
    for (var x = 0; x < nrows_edu; x++) 
    { entidad_edu[x] = document.getElementById('tbody_educacion').getElementsByTagName("tr")[x].getElementsByTagName("td")[0].innerHTML;
      titulo_edu[x] = document.getElementById('tbody_educacion').getElementsByTagName("tr")[x].getElementsByTagName("td")[1].innerHTML;
      nivel_edu[x] = document.getElementById('tbody_educacion').getElementsByTagName("tr")[x].getElementsByTagName("td")[2].innerHTML;
      estatus_edu[x] = document.getElementById('tbody_educacion').getElementsByTagName("tr")[x].getElementsByTagName("td")[3].innerHTML;
      desde_edu[x] = document.getElementById('tbody_educacion').getElementsByTagName("tr")[x].getElementsByTagName("td")[4].innerHTML;
      hasta_edu[x] = document.getElementById('tbody_educacion').getElementsByTagName("tr")[x].getElementsByTagName("td")[5].innerHTML;

      datos_edu.push({ 
      "entidad_edu" : entidad_edu[x],
      "titulo_edu"  : titulo_edu[x],
      "nivel_edu"  : nivel_edu[x],
      "estatus_edu"  : estatus_edu[x],
      "desde_edu"   : desde_edu[x],
      "hasta_edu"   : hasta_edu[x]
      });
    }

    //objeto_edu.rows = nrows_edu;
    objeto_edu.datos_edu = datos_edu;
    datajson_edu=JSON.stringify(objeto_edu);

    var entidad_cur= new Array(); var curso_cur= new Array(); var desde_cur= new Array(); var hasta_cur= new Array();
    var nrows_cur = $("#tbody_cursos tr").length;
    var datos_cur  = [];
    var objeto_cur = {};
    for (var x = 0; x < nrows_cur; x++) 
    { entidad_cur[x] = document.getElementById('tbody_cursos').getElementsByTagName("tr")[x].getElementsByTagName("td")[0].innerHTML;
      curso_cur[x] = document.getElementById('tbody_cursos').getElementsByTagName("tr")[x].getElementsByTagName("td")[1].innerHTML;
      desde_cur[x] = document.getElementById('tbody_cursos').getElementsByTagName("tr")[x].getElementsByTagName("td")[2].innerHTML;
      hasta_cur[x] = document.getElementById('tbody_cursos').getElementsByTagName("tr")[x].getElementsByTagName("td")[3].innerHTML;

      datos_cur.push({ 
      "entidad_cur" : entidad_cur[x],
      "curso_cur"  : curso_cur[x],
      "desde_cur"   : desde_cur[x],
      "hasta_cur"   : hasta_cur[x]
      });
    }

    //objeto_cur.rows = nrows_cur;
    objeto_cur.datos_cur = datos_cur;
    datajson_cur=JSON.stringify(objeto_cur);

    var nombre_ref= new Array(); var cargo_ref= new Array(); var rela_ref= new Array(); var contact_ref= new Array();
    var nrows_ref = $("#tbody_referencias tr").length;
    var datos_ref  = [];
    var objeto_ref = {};
    for (var x = 0; x < nrows_ref; x++) 
    { nombre_ref[x] = document.getElementById('tbody_referencias').getElementsByTagName("tr")[x].getElementsByTagName("td")[0].innerHTML;
      cargo_ref[x] = document.getElementById('tbody_referencias').getElementsByTagName("tr")[x].getElementsByTagName("td")[1].innerHTML;
      rela_ref[x] = document.getElementById('tbody_referencias').getElementsByTagName("tr")[x].getElementsByTagName("td")[2].innerHTML;
      contact_ref[x] = document.getElementById('tbody_referencias').getElementsByTagName("tr")[x].getElementsByTagName("td")[3].innerHTML;

      datos_ref.push({ 
      "nombre_ref" : nombre_ref[x],
      "cargo_ref"  : cargo_ref[x],
      "rela_ref"   : rela_ref[x],
      "contact_ref"   : contact_ref[x]
      });
    }

    //objeto_ref.rows = nrows_ref;
    objeto_ref.datos_ref = datos_ref;
    datajson_ref=JSON.stringify(objeto_ref);

    if(prinombre.length>=2)
    { if(priapellido.length>=2)
      { if(dir.length>=10)
        { if(f_nacimiento.length>0)
          { if(sel_nacionalidad>0)
            { if(sel_estadocivil!='-')
              { if(num_docip.length>3)
                { if(f_vencimiento_docip.length>0)
                  { if(num_ss.length>3)
                    { if(telefono.length>0)
                      { if( validEmail.test(mail) )
                        { if(nrows_edu>0)
                          { if(nrows_ref>0)
                            { var valperm =validapermiso(nacio_extran);
                              if(valperm==1)
                              { if(dsel_tipopermiso.length<=2){dsel_tipopermiso='-'};
                                if(df_vence_permiso.length<=2){df_vence_permiso='1900-01-01'};
                                if(dfilepermiso.length<1)
                                { file_dfilepermiso='-'} 
                                else 
                                { file_dfilepermiso = dfilepermiso[0];};

                                if(explique_disc.length==0)
                                { explique_disc='-';}
                                if(cv_doc.length>0)
                                { file_cv_doc = cv_doc[0];
                                  var data = new FormData();    
                                    data.append("id_ofl",id_ofl);   
                                    data.append("_token", _token); 
                                    data.append("prinombre", prinombre); 
                                    data.append("segnombre", segnombre); 
                                    data.append("priapellido", priapellido); 
                                    data.append("segapellido", segapellido); 
                                    data.append("genero", genero);
                                    data.append("cv_doc", file_cv_doc);
                                    data.append("permiso_trab", dsel_tipopermiso);
                                    data.append("f_vence_permiso_trab", df_vence_permiso); 
                                    data.append("permiso_doc", file_dfilepermiso);
                                    data.append("sel_provincias", sel_provincias); 
                                    data.append("sel_distrito", sel_distrito); 
                                    data.append("sel_corregimiento", sel_corregimiento); 
                                    data.append("dir", dir);
                                    data.append("nacio_extran", nacio_extran); 
                                    data.append("f_nacimiento", f_nacimiento); 
                                    data.append("sel_nacionalidad", sel_nacionalidad); 
                                    data.append("sel_tipodoc", sel_tipodoc); 
                                    data.append("num_docip", num_docip); 
                                    data.append("sel_estadocivil", sel_estadocivil); 
                                    data.append("num_ss", num_ss); 
                                    data.append("f_vencimiento_docip", f_vencimiento_docip); 
                                    data.append("telefono", telefono); 
                                    data.append("mail", mail);
                                    data.append("sel_discapacidad", sel_discapacidad); 
                                    data.append("explique_disc", explique_disc);
                                    data.append("datajson_exp",datajson_exp);
                                    data.append("datajson_edu",datajson_edu);
                                    data.append("datajson_cur",datajson_cur);
                                    data.append("datajson_ref",datajson_ref); 
                                    $.ajax({
                                      data:  data, 
                                      url:   "{{ route('ofertas.store') }}",
                                      type:  'POST',//método de envio
                                      contentType: false,       // The content type used when sending data to the server.
                                      cache: false,             // To unable request pages to be cached
                                      processData:false,			// To send DOMDocument or non processed data file it is set to false+
                                      dataType: "json",
                                      beforeSend: function () {
                                      var mElemento = document.getElementById("div_success");
                                        mElemento.classList.remove('visually-hidden');
                                        mElemento.className += " show";
                                      }, 
                                      success:  function (data) { 
                                        if(data.uploadOk==1)
                                        {
                                          //document.getElementById('lb_proceso_part').innerHTML= 'Candidatos: <span class="text-secondary"><b>'+data.conteos+'</b></span>';
                                          //document.getElementById('cantpart_'+id_ofl).innerHTML= data.conteos;
                                          //document.getElementById('lb_cont_part').innerHTML='Contratados: <span class="text-secondary"><b>'+data.cant_contratado+'</b></span>';
                                          //document.getElementById('cantcont_'+id_ofl).innerHTML= data.cant_contratado;


                                          document.getElementById('lb_proceso_part').innerHTML= 'Candidatos: <span class="text-secondary"><b>'+data.cant_proceso+'</b></span>';
                                          document.getElementById('lb_cont_part').innerHTML='Contratados: <span class="text-secondary"><b>'+data.cant_contratado+'</b></span>';

                                          document.getElementById('cantpart_'+data.id_ofl).innerHTML= data.cant_proceso;
                                          document.getElementById('cantinicial_'+data.id_ofl).innerHTML=  data.cant_inicial;
                                          document.getElementById('cantfuncional_'+data.id_ofl).innerHTML=  data.cant_funcional;
                                          document.getElementById('cantofertalaboral_'+data.id_ofl).innerHTML=  data.cant_ofertalaboral;
                                          document.getElementById('cantdocumentacion_'+data.id_ofl).innerHTML=  data.cant_documentacion;
                                          document.getElementById('cantfirma_'+data.id_ofl).innerHTML=  data.cant_firma;

                                          document.getElementById('cantcont_'+data.id_ofl).innerHTML= data.cant_contratado;



                                          document.getElementById("tbody_aspirantes").innerHTML="";
                                          i=0;
                                          var nuevaFila   = '';
                                          jQuery(data.participantes).each(function(i, item){
                                            i++;
                                            if(item.prinombre!=null){
                                            nuevaFila   += '<tr>';
                                            nuevaFila  += '<td>'+item.num_doc+'</td>';
                                            nuevaFila  += '<td>'+item.prinombre+' '+item.priapellido+'</td>';
                                            nuevaFila  += '<td>'+item.tel+'</td>';
                                            nuevaFila  += '<td>'+item.email+'</td>';
                                            nuevaFila  += '<td class="text-center">'+item.banges+'</td>';
                                            nuevaFila  += '<td class="text-center"><i class="fas fa-search edit" onclick=edit_etapa_part('+item.id_curri+','+item.id_participante+')></i><span class="p-1"> </span><i class="fas fa-trash-alt dell" onclick=delprospecto(this,"prospectos",'+item.id_participante+')></i></td>';
                                            nuevaFila  += '</tr>';}
                                          });
                                          $("#tbody_aspirantes").html(nuevaFila);
                                          mElemento = document.getElementById("div_success");
                                          mElemento.classList.remove('show');
                                          mElemento.className += " visually-hidden";
                                          bien('La información ha sido almacenada.');
                                          $('#modalnuevoprooectos').modal('hide');
                                          limpia_frm();
                                        }
                                        else
                                        { mElemento = document.getElementById("div_success");
                                          mElemento.classList.remove('show');
                                          mElemento.className += " visually-hidden";
                                          mal_alert(data.mensaje);
                                        }
                                      }
                                    });
                                }
                                else
                                { mal_alert('Adjuntar hoja de vida.');
                                  document.getElementById('filecv').style="border-color:#dc3545;";
                                  var myElemento = document.getElementById("flush-collapseFive");   
                                  myElemento.className += " show";
                                  document.getElementById('filecv').focus();
                                }
                              }
                              else
                              { mal_alert(valperm);}
                            }
                            else
                            { mal_alert('Agregar referencias');
                              document.getElementById('nombre_referencia').style="border-color:#dc3545;";
                            var myElemento = document.getElementById("flush-collapseFour");   
                            myElemento.className += " show";
                              document.getElementById('nombre_referencia').focus();
                            }
                          }
                          else
                          { mal_alert('Agregar estudios');
                            document.getElementById('entidad_educ').style="border-color:#dc3545;";
                            var myElemento = document.getElementById("flush-collapseTwo");   
                            myElemento.className += " show";
                            document.getElementById('entidad_educ').focus();
                          }
                        }
                        else
                        { mal_alert('Validar el correo electrónico.');
                          document.getElementById('mail').style="border-color:#dc3545;";
                          var myElemento = document.getElementById("collapseEight");   
                          myElemento.className += " show";
                          document.getElementById('mail').focus();
                        } 
                      }
                      else
                      { mal_alert('Indicar numero telefónico.');
                        document.getElementById('telefono').style="border-color:#dc3545;";
                        var myElemento = document.getElementById("collapseEight");   
                        myElemento.className += " show";
                        document.getElementById('telefono').focus();
                      } 
                    }
                    else
                    { mal_alert('Indicar numero seguro social.');
                      document.getElementById('num_ss').style="border-color:#dc3545;";
                      var myElemento = document.getElementById("collapseEight");   
                      myElemento.className += " show";
                      document.getElementById('num_ss').focus();
                    } 
                  }
                  else
                  { mal_alert('Indicar la fecha de vencimiento del documento de identificación personal.');
                    document.getElementById('f_vencimiento_docip').style="border-color:#dc3545;";
                    var myElemento = document.getElementById("collapseEight");   
                    myElemento.className += " show";
                    document.getElementById('f_vencimiento_docip').focus();
                  }
                }
                else
                { mal_alert('Indicar el número de documento de identificación personal.');
                  document.getElementById('num_docip').style="border-color:#dc3545;";
                  var myElemento = document.getElementById("collapseEight");   
                  myElemento.className += " show";
                  document.getElementById('num_docip').focus();
                }
              }
              else
              { mal_alert('Seleccionar estado civil.');
                document.getElementById('sel_estadocivil').style="border-color:#dc3545;";
                var myElemento = document.getElementById("collapseEight");   
                myElemento.className += " show";
                document.getElementById('sel_estadocivil').focus();
              }
            }
            else
            { mal_alert('Seleccionar el país de nacimiento.');
              document.getElementById('sel_nacionalidad').style="border-color:#dc3545;";
              var myElemento = document.getElementById("collapseEight");   
              myElemento.className += " show";
              document.getElementById('sel_nacionalidad').focus();
            }
          }
          else
          { mal_alert('Especificar la fecha de nacimiento.');
            document.getElementById('f_nacimiento').style="border-color:#dc3545;";
            var myElemento = document.getElementById("collapseEight");   
            myElemento.className += " show";
            document.getElementById('f_nacimiento').focus(); 
          } 
        }
        else
        { mal_alert('Detallar un poco en la dirección específica.');
          document.getElementById('direc').style="border-color:#dc3545;";
          var myElemento = document.getElementById("collapseSeven");   
          myElemento.className += " show";
          document.getElementById('direc').focus();     
        } 
      }
      else
      { mal_alert('El primer apellido es obligatorio.');
        document.getElementById('priapellido').style="border-color:#dc3545;";
        var myElemento = document.getElementById("collapseSix");   
        myElemento.className += " show";
        document.getElementById('priapellido').focus();     
      } 
    }
    else
    { mal_alert('El primer nombre es obligatorio.');
      document.getElementById('prinombre').style="border-color:#dc3545;";
      var myElemento = document.getElementById("collapseSix");   
      myElemento.className += " show";
      document.getElementById('prinombre').focus();      
    } 
  }

  //----- AGREGA FILAS EN EL FORMULARIO DE PARTICIANTES
  //----- EDUCACIÓN, EXPERIENCIA, CURSOS, REFERENCIAS
  function addrow(opt_table)
  { 
    var contendor  = $("#tbody_"+opt_table).html();
    var band=0;
    if(opt_table=='experiencia')
    { var empresa_experiencia = $('#empresa_experiencia').val();
      var puesto_experiencia = $('#puesto_experiencia').val();
      var sel_subarea_experiencia = $('select[id="sel_subarea_experiencia"] option:selected').text();
      var desde_experiencia = $('#desde_experiencia').val();
      var hasta_experiencia = $('#hasta_experiencia').val();
      
      if((empresa_experiencia.length==0)||(puesto_experiencia.length==0)||(desde_experiencia.length==0)||( $('#sel_subarea_experiencia').val()==0))
      { document.getElementById('div_experiencia').style.display='block';
        setTimeout(function(){ document.getElementById('div_experiencia').style.display='none';}, 2000);
      }
      else
      {  if(hasta_experiencia.length==0){hasta_experiencia='Hasta la fecha';}
         var nuevaFila   = '<tr>';
          nuevaFila  += '<td>'+empresa_experiencia+'</td>';
          nuevaFila  += '<td>'+puesto_experiencia+'</td>';
          nuevaFila  += '<td>'+sel_subarea_experiencia+'</td>';
          nuevaFila  += '<td class="text-center">'+desde_experiencia+'</td>';
          nuevaFila  += '<td class="text-center">'+hasta_experiencia+'</td>';
          nuevaFila  += '<td class="text-center"><i class="fa-solid fa-trash-can dell" onclick=delrow(this,"'+opt_table+'")></i></td>';
          nuevaFila  += '</tr>';
          $('#empresa_experiencia').val('');
          $('#puesto_experiencia').val('');
          $('#sel_subarea_experiencia').val(0);
          $('#desde_experiencia').val('');
          $('#hasta_experiencia').val('');
          $('#empresa_experiencia').focus();
          band=1;
      }
    }
    
    if(opt_table=='educacion')
    { var entidad_educ = $('#entidad_educ').val();
      var titulo_educ = $('#titulo_educ').val();
      var sel_niveleduc = $('select[id="sel_niveleduc"] option:selected').text();
      var sel_estatuseduc = $('select[id="sel_estatuseduc"] option:selected').text();
      var desde_educ = $('#desde_educ').val();
      var hasta_educ = $('#hasta_educ').val();
      if(hasta_educ.length==0){hasta_educ='Hasta la fecha';}
      
      if((entidad_educ.length==0)||(titulo_educ.length==0)||(sel_niveleduc.length==0)||(sel_estatuseduc.length==0)||(desde_educ.length==0))
      { document.getElementById('div_educacion').style.display='block';
        setTimeout(function(){ document.getElementById('div_educacion').style.display='none';}, 2000);
      }
      else
      { 
        var nuevaFila   = '<tr>';
        nuevaFila  += '<td>'+entidad_educ+'</td>';
        nuevaFila  += '<td>'+titulo_educ+'</td>';
        nuevaFila  += '<td>'+sel_niveleduc+'</td>';
        nuevaFila  += '<td>'+sel_estatuseduc+'</td>';
        nuevaFila  += '<td class="text-center">'+desde_educ+'</td>';
        nuevaFila  += '<td class="text-center">'+hasta_educ+'</td>';
        nuevaFila  += '<td class="text-center"><i class="fa-solid fa-trash-can dell" onclick=delrow(this,"'+opt_table+'")></i></td>';
        nuevaFila  += '</tr>';
        $('#entidad_educ').val('');
        $('#titulo_educ').val('');
        $('#sel_niveleduc').val(0);
        $('#sel_estatuseduc').val(0);
        $('#desde_educ').val('');
        $('#hasta_educ').val('');
        $('#entidad_educ').focus();        
        band=1;
      }
    }

    if(opt_table=='cursos')
    { var entidad_curso = $('#entidad_curso').val();
      var nombre_curso = $('#nombre_curso').val();
      var desde = $('#desde_curso').val();
      var hasta = $('#hasta_curso').val();
      if(hasta.length==0){hasta='Hasta la fecha';}
      
      if((entidad_curso.length==0)||(nombre_curso.length==0)||(desde.length==0))
      { document.getElementById('div_cursos').style.display='block';
        setTimeout(function(){ document.getElementById('div_cursos').style.display='none';}, 2000);
      }
      else
      { 
        var nuevaFila   = '<tr>';
        nuevaFila  += '<td>'+entidad_curso+'</td>';
        nuevaFila  += '<td>'+nombre_curso+'</td>';
        nuevaFila  += '<td class="text-center">'+desde+'</td>';
        nuevaFila  += '<td class="text-center">'+hasta+'</td>';
        nuevaFila  += '<td class="text-center"><i class="fa-solid fa-trash-can dell" onclick=delrow(this,"'+opt_table+'")></i></td>';
        nuevaFila  += '</tr>';
        $('#entidad_curso').val('');
        $('#nombre_curso').val('');
        $('#desde_curso').val('');
        $('#hasta_curso').val('');
        $('#entidad_curso').focus();
        band=1;
      }
    }

    if(opt_table=='referencias')
    { var nombre_referencia = $('#nombre_referencia').val();
      var cargo_referencia = $('#cargo_referencia').val();
      var sel_rela_ref = $('select[id="sel_rela_ref"] option:selected').text();
      var contacto_referencia = $('#contacto_referencia').val();
      
      if((nombre_referencia.length==0)||(cargo_referencia.length==0)||(sel_rela_ref.length==0)||(contacto_referencia.length==0))
      { document.getElementById('div_referencias').style.display='block';
        setTimeout(function(){ document.getElementById('div_referencias').style.display='none';}, 2000);
      }
      else
      { 
        var nuevaFila   = '<tr>';
        nuevaFila  += '<td>'+nombre_referencia+'</td>';
        nuevaFila  += '<td>'+cargo_referencia+'</td>';
        nuevaFila  += '<td>'+sel_rela_ref+'</td>';
        nuevaFila  += '<td>'+contacto_referencia+'</td>';
        nuevaFila  += '<td class="text-center"><i class="fa-solid fa-trash-can dell" onclick=delrow(this,"'+opt_table+'")></i></td>';
        nuevaFila  += '</tr>';
        $('#nombre_referencia').val('');
        $('#cargo_referencia').val('');
        $('#sel_rela_ref').val(0);
        $('#contacto_referencia').val('');
        band=1;
      }
    }
       
    if(opt_table=='valreflaboral')
    { var valida_exp_entidad = $('#valida_exp_entidad').val();
      var valida_exp_nombre = $('#valida_exp_nombre').val();
      var valida_exp_puesto = $('#valida_exp_puesto').val();
      var valida_exp_contacto = $('#valida_exp_contacto').val();
      var valida_exp_comentario = $('#valida_exp_comentario').val();
      
      if((valida_exp_entidad.length==0)||(valida_exp_nombre.length==0)||(valida_exp_puesto.length==0)||(valida_exp_contacto.length==0)||(valida_exp_comentario.length==0))
      { document.getElementById('div_valida_referencias').style.display='block';
        setTimeout(function(){ document.getElementById('div_valida_referencias').style.display='none';}, 2000);
      }
      else
      { 
        var nuevaFila   = '<tr>';
        nuevaFila  += '<td>'+valida_exp_entidad+'</td>';
        nuevaFila  += '<td>'+valida_exp_nombre+'</td>';
        nuevaFila  += '<td>'+valida_exp_puesto+'</td>';
        nuevaFila  += '<td>'+valida_exp_contacto+'</td>';
        nuevaFila  += '<td class="small">'+valida_exp_comentario+'</td>';
        nuevaFila  += '<td class="text-center"><i class="fa-solid fa-trash-can dell" onclick=delrow(this,"'+opt_table+'")></i></td>';
        nuevaFila  += '</tr>';
        $('#valida_exp_entidad').val('');
        $('#valida_exp_nombre').val('');
        $('#valida_exp_puesto').val('');
        $('#valida_exp_contacto').val('');
        $('#valida_exp_comentario').val('');
        band=1;
      }
    }
    
    
    if(opt_table=='pruebaspsico')
    { 
      var sel_evaluacion_aplicada = $('#sel_evaluacion_aplicada').val();
    
      var f_envio_prueba = $('#f_envio_prueba').val();
      pruebapsico_resultado ="";
      if(sel_evaluacion_aplicada==1||sel_evaluacion_aplicada==2)
      { pruebapsico_resultado = $('select[id="pruebapsico_resultado"] option:selected').text();}
      else
      { pruebapsico_resultado = $('#pruebapsico_resultado').val();}


      if((sel_evaluacion_aplicada.length!=0)||(f_envio_prueba.length!=0)||(pruebapsico_resultado.length!=0))
      { 


        var _token = $('input[name="_token"]').val();
        var id_curri = $('#id_curri').val(); 
        var id_participante = $('#id_participante').val(); 

         
            var parametros = {
            "id_curri": id_curri,
            "id_participante" : id_participante,
            "sel_evaluacion_aplicada" : sel_evaluacion_aplicada,
            "pruebapsico_resultado" : pruebapsico_resultado,
            "f_envio_prueba": f_envio_prueba,
            "_token":_token};
          $.ajax({
            data:  parametros, 
            url:   "{{ route('ofertas.pruebaspsico') }}",
            type:  'POST',//método de envio
            dataType: "JSON",           
            cache: true,  // To unable request pages to be cached
            beforeSend: function () 
            { },
            success:  function (response) {
              $("#tbody_"+opt_table).html('');
              jQuery(response.prueba_psico).each(function(i, item){   
                resultado=item.resultado;
                fecha= item.f_prueba.split('-');

                if(item.respuesta!=null)
                { resultado=item.respuesta;}
                var contendor  = $("#tbody_"+opt_table).html();
                var nuevaFila  = '<tr>';
                nuevaFila  += '<td>'+item.nom_prueba+'</td>';
                nuevaFila  += '<td>'+fecha[2]+'-'+fecha[1]+'-'+fecha[0]+'</td>';
                nuevaFila  += '<td>'+resultado+'</td>';
                nuevaFila  += '<td class="text-center"><i class="fa-solid fa-trash-can dell" onclick=delrowpruebaspsico(this,"'+item.id_prueba+'")></i></td>';
                nuevaFila  += '</tr>';
                band=0;
                $("#tbody_"+opt_table).html(contendor+nuevaFila);
              });
              $('#sel_evaluacion_aplicada').val(0);
              $('#f_envio_prueba').val('');
              $('#iddiv_resul_psico').html('<input type="text" class="form-control form-control-sm" id="pruebapsico_resultado" max="30" value="">');
            }
          }); 


      }
    }

    if(band==1){ $("#tbody_"+opt_table).html(contendor+nuevaFila);}
    
  }

  //----- AGREGAR PLANIFICACIÓN DE ENTREVISTAS
  function addrow_entrevista()
  {   var sel_entrevistador = document.getElementById('sel_entrevistador').value;
      var sel_fecha = document.getElementById('sel_fecha').value;     
      var paso=$('#txt_paso').val();
      
      if((sel_entrevistador.length==0)||(sel_fecha.length==0)||($('#sel_hora').val().length==0))
      { document.getElementById('div_entrvistas_funcionales').style.display='block';
        setTimeout(function(){ document.getElementById('div_entrvistas_funcionales').style.display='none';}, 2000);
      }
      else
      {  var sel_hora = $('#sel_hora').val();
        var hora24, hora12, pm;
        var ampm='';
        var horamilitar= sel_hora.split(':');
        var hora24=horamilitar[0];
        var minutos=horamilitar[1];        

        if (hora24 > 12) {
            hora12= (hora24 - 12);
            ampm='p.m.';
        } else {
          hora12=hora24;
          if(hora24==12)
          { ampm='p.m.'; }
          else{ ampm='a.m.';}
        }
        var horasnormales=hora12+":"+minutos+" "+ampm;

        var _token = $('input[name="_token"]').val();
        var id_curri = $('#id_curri').val(); 
        var id_participante = $('#id_participante').val(); 
         
        var parametros = {
            "sel_entrevistador" : sel_entrevistador,
            "id_curri": id_curri,
            "id_participante" : id_participante,
            "sel_fecha" : sel_fecha,
            "sel_hora" : horasnormales,
            "paso": paso,
            "_token":_token};
          $.ajax({
            data:  parametros, 
            url:   "{{ route('ofertas.fentrevist') }}",
            type:  'POST',//método de envio
            dataType: "JSON",           
            cache: true,  // To unable request pages to be cached
            beforeSend: function () 
            { },
            success:  function (response) {
              jQuery(response).each(function(i, item){   


                fecha= sel_fecha.split('-');

                  contendor  = $("#tbody_entrefuncional").html();
                  nuevaFila   = '<tr>'+
                '<td><span id="entrevistador_'+item.id_entrevista+'">'+item.nombre+'</span></td>'+
                '<td>'+item.mail+'</td>'+
                '<td>'+item.puesto+'</td>'+
                '<td class="text-center">'+fecha[2]+'-'+fecha[1]+'-'+fecha[0]+' '+horasnormales+'</td>'+
                '<td class="text-center">'+
                  '<span id="ico_noti_'+item.id_entrevista+'"> <i class="fas fa-envelope fa-lg msnwarning" onclick="notificar_entrevista('+item.id_entrevista+')" title="Enviar notificación"></i> </span>'+
                  '<input type="hidden" value="0" id="notifi_'+item.id_entrevista+'"></td>'+
                '<td class="text-center"><i class="fa-solid fa-trash-can fa-lg dell" onclick=delrowentref(this,'+item.id_entrevista+') title="Eliminar entrevista"></i></td>'+
                '</tr>';
              $("#tbody_entrefuncional").html(contendor+nuevaFila); 
              $('#sel_entrevistador').val(0);
              $('#sel_fecha').val('');
              $('#sel_hora').val('');
              });
              document.getElementById("div_banges_"+$('#id_curri').val()).innerHTML=response.banges;
            }
          });   
      }
              
  }

  // AGREGAR CONTACTOS DE URGENCIA
  function addrow_contacto()
  {
    var nombre_contacto  = document.getElementById('nombre_contacto').value;
    var tel_contacto    = document.getElementById('tel_contacto').value;          
      if((nombre_contacto.length==0)||(tel_contacto.length==0))
      { document.getElementById('div_msg_contactos').style.display='block';
        setTimeout(function(){ document.getElementById('div_msg_contactos').style.display='none';}, 2000);
      }
      else
      {  

        var _token = $('input[name="_token"]').val();
        var id_curri = $('#id_curri').val(); 
        var parametros = {
            "nombre_contacto" : nombre_contacto,
            "tel_contacto": tel_contacto,
            "id_curri": id_curri,
            "_token":_token};
          $.ajax({
            data:  parametros, 
            url:   "{{ route('ofertas.contactos') }}",
            type:  'POST',//método de envio
            dataType: "JSON",           
            cache: true,  // To unable request pages to be cached
            beforeSend: function () 
            { $("#tbody_contactos").html(''); },
            success:  function (response) {
              jQuery(response).each(function(i, item){   
               
                contendor  = $("#tbody_contactos").html();
                nuevaFila   = '<tr>'+
                '<td>'+item.nombre+'</td>'+
                '<td><span class="text-center">'+item.contacto+'</span></td>'+
                '<td style="text-align:center"><i class="fa-solid fa-trash-can fa-lg dell" onclick=delrowcontactos(this,'+item.id+') title="Eliminar contacto"></i></td>'+
                '</tr>';
                $("#tbody_contactos").html(contendor+nuevaFila); 
              });
              document.getElementById('nombre_contacto').value="";
              document.getElementById('tel_contacto').value="";
            }
          });         
      }    
  }

  //----- AGREGAR DEPENDIENTES
  function addrow_dependientes()
  { var nombre_dependiente  = document.getElementById('nombre_dependiente').value;
    var sel_parentesco   = document.getElementById('sel_parentesco').value;
    var fech_nac_dependiente    = document.getElementById('fech_nac_dependiente').value;          
      if((nombre_dependiente.length==0)||(sel_parentesco.length==0)||(fech_nac_dependiente.length==0))
      { document.getElementById('div_msg_dependientes').style.display='block';
        setTimeout(function(){ document.getElementById('div_msg_dependientes').style.display='none';}, 2000);
      }
      else
      {  

        var _token = $('input[name="_token"]').val();
        var id_curri = $('#id_curri').val(); 
        var parametros = {
            "nombre_dependiente" : nombre_dependiente,
            "sel_parentesco": sel_parentesco,
            "fech_nac_dependiente": fech_nac_dependiente,
            "id_curri": id_curri,
            "_token":_token};
          $.ajax({
            data:  parametros, 
            url:   "{{ route('ofertas.dependientes') }}",
            type:  'POST',//método de envio
            dataType: "JSON",           
            cache: true,  // To unable request pages to be cached
            beforeSend: function () 
            { $("#tbody_dependientes").html(''); },
            success:  function (response) {
              jQuery(response).each(function(i, item){   
                fecha="";
                fecha= item.f_nacimiento.split('-');
                contendor  = $("#tbody_dependientes").html();
                nuevaFila   = '<tr>'+
                '<td>'+item.nombre+'</td>'+
                '<td><span class="text-center">'+item.parentesco+'</span></td>'+
                '<td><span style="text-align:center">'+fecha[2]+'-'+fecha[1]+'-'+fecha[0]+'</span></td>'+
                '<td style="text-align:center"><i class="fa-solid fa-trash-can fa-lg dell" onclick=delrowdepend(this,'+item.id+') title="Eliminar dependiente"></i></td>'+
                '</tr>';
                $("#tbody_dependientes").html(contendor+nuevaFila); 
              });
              document.getElementById('nombre_dependiente').value="";
              document.getElementById('sel_parentesco').value="0";
              document.getElementById('fech_nac_dependiente').value="";
            }
          });         
      }    
  }

  //----- NOTIFICACIONES DE ENTREVISTAS
  function notificar_entrevista(id_entrevista)
  {
    var _token = $('input[name="_token"]').val();


    if(($('#notifi_'+id_entrevista).val()==0))
    { preg="Desea enviar notificación de la entrevista a "+$('#entrevistador_'+id_entrevista).html();+"?";}
    else
    { preg="Esta persona ya fué notificada anteriormente. Desea enviar la notificación nuevamente a "+$('#entrevistador_'+id_entrevista).html();+"?";}


    Swal.fire({
      text: preg,
      icon: "question",
      showCancelButton: true,
      cancelButtonText:  '<i class="fas fa-arrow-left"></i> Cancelar',
      confirmButtonText: '<i class="fas fa-paper-plane"></i> Si, enviar',
      confirmButtonColor: "#d33",
      }).then((result) => {
        if (result.isConfirmed) 
        {
          var parametros = {
          "id_entrevista": id_entrevista,          
          "_token":_token};
          $.ajax({
            data:  parametros, 
            url:   "{{ route('ofertas.notientre') }}",
            dataType: "JSON",           
            type:  'POST', 
            cache: false,       
            beforeSend: function () {
               document.getElementById("ico_noti_"+id_entrevista).innerHTML='<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Enviando...</span></div>';
              }, 
            success:  function (data) { 
              if(data.envio==1)
              {
                bien(data.msn);
                document.getElementById("ico_noti_"+id_entrevista).innerHTML='<i class="fas fa-envelope fa-lg msnwarningactivo" onclick="notificar_entrevista('+id_entrevista+')" title="Notificado"></i>';
                $('#notifi_'+id_entrevista).val(1);
              }
              else
              {
                mal(data.msn);
              }
            }
          });
        };
      });
  }

  //--- ELIMINA UNA FILA DE CUALQUIER TABLA, SE PASA LA FILA CON THIS Y EL NOMBRE DE TABLA "table_NOMBRETABLA"
  function delrowentref(id,id_entrevista) 
  { 
    var _token = $('input[name="_token"]').val();
    var id_participante = $('#id_participante').val(); 
    Swal.fire({
      text: "Desea eliminar la entrevista funcional del candidato con "+$('#entrevistador_'+id_entrevista).html(),
      showCancelButton: true,
      icon: "question",
      confirmButtonText: '<i class="fas fa-trash-alt"></i> Eliminar',
      cancelButtonText:  '<i class="fas fa-arrow-left"></i> Cancelar',
      confirmButtonColor: "#d33",
    }).then((result) => {
        if (result.isConfirmed) {
          var parametros = {
            "_token":_token,
            "id_entrevista":id_entrevista,
            "id_participante":id_participante,};
          $.ajax({
            data:  parametros, 
            url:   "{{ route('ofertas.destroyentre') }}",
            type:  'POST', 
            dataType: "JSON",
            cache: true, 
            success:  function (data) { 
                    
              let row = id.parentNode.parentNode;
              let table = document.getElementById("table_entrefuncional"); 
              table.deleteRow(row.rowIndex);

              if(data.cant==0){ 
                document.getElementById("div_banges_"+$('#id_curri').val()).innerHTML=data.banges;
              };
            }
          });
        } 
      });
  }

  //--- ELIMINA UNA FILA DE CUALQUIER TABLA, SE PASA LA FILA CON THIS Y EL NOMBRE DE TABLA "table_NOMBRETABLA"
  function delrowdepend(id,id_depend) 
  { 
    var _token = $('input[name="_token"]').val();
    var id_curri = $('#id_curri').val(); 
    Swal.fire({
      text: "Desea eliminar el dependiente indicado?",
      showCancelButton: true,
      icon: "question",
      confirmButtonText: '<i class="fas fa-trash-alt"></i> Eliminar',
      cancelButtonText:  '<i class="fas fa-arrow-left"></i> Cancelar',
      confirmButtonColor: "#d33",
    }).then((result) => {
        if (result.isConfirmed) {
          var parametros = {
            "_token":_token,
            "id_curri":id_curri,
            "id_depend":id_depend,};
          $.ajax({
            data:  parametros, 
            url:   "{{ route('ofertas.destroydepend') }}",
            type:  'POST', 
            cache: true, 
            success:  function (data) { 
                    
              let row = id.parentNode.parentNode;
              let table = document.getElementById("table_dependientes"); 
              table.deleteRow(row.rowIndex);


            }
          });
        } 
      });
  }
  
  //--- ELIMINA UNA FILA DE CUALQUIER TABLA, SE PASA LA FILA CON THIS Y EL NOMBRE DE TABLA "table_NOMBRETABLA"
    function delrowpruebaspsico(id,id_prueba) 
  { 
    var _token = $('input[name="_token"]').val();
    var id_curri = $('#id_curri').val(); 
    Swal.fire({
      text: "Desea eliminar el registro indicado?",
      showCancelButton: true,
      icon: "question",
      confirmButtonText: '<i class="fas fa-trash-alt"></i> Eliminar',
      cancelButtonText:  '<i class="fas fa-arrow-left"></i> Cancelar',
      confirmButtonColor: "#d33",
    }).then((result) => {
        if (result.isConfirmed) {
          var parametros = {
            "_token":_token,
            "id_curri":id_curri,
            "id_prueba":id_prueba,};
          $.ajax({
            data:  parametros, 
            url:   "{{ route('ofertas.destroypruebapsico') }}",
            type:  'POST', 
            dataType: "json",
            cache: true, 
            success:  function (data) { 
              if(data.resp>=1)
              { let row = id.parentNode.parentNode;
                let table = document.getElementById("table_pruebaspsico"); 
                table.deleteRow(row.rowIndex);
                if(data.resp==1)
                { document.getElementById("div_banges_"+$('#id_curri').val()).innerHTML=data.banges;  
                  $('#txt_paso').val(2);
                }
              }
            }
          });
        } 
      });
  }

  //--- ELIMINA UNA FILA DE CUALQUIER TABLA, SE PASA LA FILA CON THIS Y EL NOMBRE DE TABLA "table_NOMBRETABLA"
  function delrowcontactos(id,id_contacto) 
  { 
    var _token = $('input[name="_token"]').val();
    var id_curri = $('#id_curri').val(); 
    Swal.fire({
      text: "Desea eliminar el contacto indicado?",
      showCancelButton: true,
      icon: "question",
      confirmButtonText: '<i class="fas fa-trash-alt"></i> Eliminar',
      cancelButtonText:  '<i class="fas fa-arrow-left"></i> Cancelar',
      confirmButtonColor: "#d33",
    }).then((result) => {
        if (result.isConfirmed) {
          var parametros = {
            "_token":_token,
            "id_curri":id_curri,
            "id_contacto":id_contacto,};
          $.ajax({
            data:  parametros, 
            url:   "{{ route('ofertas.destroycontacto') }}",
            type:  'POST', 
            dataType: "json",
            cache: true, 
            success:  function (data) { 
          //    jQuery(data).each(function(i, item){
              if(data.resp==1)
              { let row = id.parentNode.parentNode;
                let table = document.getElementById("table_contactos"); 
                table.deleteRow(row.rowIndex);
                document.getElementById("div_banges_"+$('#id_curri').val()).innerHTML=data.banges;  
                $('#txt_paso').val(5);
              }
         //     });
            }
          });
        } 
      });
  }

  //--- ELIMINA UNA FILA DE CUALQUIER TABLA, SE PASA LA FILA CON THIS Y EL NOMBRE DE TABLA "table_NOMBRETABLA"
  function delrow(id,opt_table) 
  { 
    let row = id.parentNode.parentNode;
    let table = document.getElementById("table_"+opt_table); 
    table.deleteRow(row.rowIndex);
  }

  //----- VERIDICA CAMPOS DE LA SECCIÓN DEL PERMISO
  function validapermiso(tipo)
  { 
    if(tipo=='E')
    { 
      var sel_tipopermiso = $('#sel_tipopermiso').val();
      var f_vence_permiso = $('#f_vence_permiso').val();
      var filepermiso = $('#filepermiso').val();
    
      if(sel_tipopermiso>0)
      { if(f_vence_permiso.length>0)
        { if(filepermiso.length>0)
          { return 1;}
          else
          { document.getElementById('filepermiso').style="border-color:#dc3545;";
            var myElemento = document.getElementById("collapseEight");   
            myElemento.className += " show";
            document.getElementById('filepermiso').focus();
            return 'Adjuntar el permiso de trabajo.';}}
        else
        { document.getElementById('f_vence_permiso').style="border-color:#dc3545;";
          var myElemento = document.getElementById("collapseEight");   
          myElemento.className += " show";
          document.getElementById('f_vence_permiso').focus();
          return 'Indicar la fecha de vencimiento del permiso de trabajo.';}
      }
      else{
        document.getElementById('sel_tipopermiso').style="border-color:#dc3545;";
        var myElemento = document.getElementById("collapseEight");   
        myElemento.className += " show";
        document.getElementById('sel_tipopermiso').focus();
        return 'Seleccionar el tipo de permiso de trabajo.';}
    }
    else
    { return 1;}
  }

  //----- MENSAJE GENERICO SI ALGO SALE MAL, SE ENVIA EL MENSAJE EN EL PARAMETRO
  function mal(msn)
  {
      Swal.fire({
        position: 'center',
        icon: 'warning',
        text: msn,
      })
  }
    //----- MENSAJE GENERICO SI ALGO SALE BIEN, SE ENVIA EL MENSAJE EN EL PARAMETRO
  function bien(msn)
  {
    Swal.fire({
    position: 'center',
    icon: 'success',
    text: msn,
    showConfirmButton: false,
    timer: 2000
    })
  }
  function maldescarte(msn)
  {
      Swal.fire({
        position: 'center',
        icon: 'error',
        text: msn,
      })
  }


  // MENSAJE DE ADVETENCIA EN EL LLENADO DEL FORMULARIO DE NUEVO Candidato
  function mal_alert(msn)
  { 
    document.getElementById("msg_alert").innerHTML=msn;
    var myElemento = document.getElementById("div_alert");
    myElemento.classList.remove('visually-hidden');
    myElemento.className += " show";
    
      myElemento = document.getElementById("div_alert");
    setTimeout(function(){ 
      myElemento.classList.remove('show');
      myElemento.className += " visually-hidden";
    }, 4000);
  }

 function valsipe()
  { val=0; 
    
    var _token = $('input[name="_token"]').val();
    var id_participante= $('#id_participante').val();
    var id_curri= $('#id_curri').val();
    if(document.getElementById('chk_val_sipe').checked) 
    { val=1;}
    var parametros = {
      "_token":_token,
      "val":val,
      "id_participante":id_participante,
      "id_curri":id_curri,};
      $.ajax({
        data:  parametros, 
        url:   "{{ route('ofertas.valsipe') }}",
        type:  'POST', 
        dataType: "json",
        cache: true, 
        success:  function (data) {                   
          //document.getElementById("div_banges_"+$('#id_curri').val()).innerHTML=data.banges;  
          //$('#txt_paso').val(4);
        }
      });
  }
  
  function valmarcacion()
  {
    var _token = $('input[name="_token"]').val();
    var id_participante= $('#id_participante').val();
    var id_curri= $('#id_curri').val();
    if(document.getElementById('chk_val_marcacion').checked) 
    { val=1;}
    var parametros = {
      "_token":_token,
      "val":val,
      "id_participante":id_participante,
      "id_curri":id_curri,};
      $.ajax({
        data:  parametros, 
        url:   "{{ route('ofertas.valmarcacion') }}",
        type:  'POST', 
        dataType: "json",
        cache: true, 
        success:  function (data) {                   
          //document.getElementById("div_banges_"+$('#id_curri').val()).innerHTML=data.banges;  
          //$('#txt_paso').val(4);
        }
      });
  }

  function nextstep(data)
  { next_step = true;
    var _token = $('input[name="_token"]').val();
    var id_curri= $('#id_curri').val();
    var id_participante= $('#id_participante').val();
		var paso=$('#txt_paso').val();

    //-- ENTREVISTA INICIAL
    if(paso<=2)
    {
      var ref_sino=''; datajson_val_ref='-'; f_envio_prueba='1900-01-01'; pruebapsico_resultado=0; file_record='-';
      checked = $('input[name="ref_sino"]:checked');
        $('[name="ref_sino[]"]:checked').map(function(){
        if (this.checked) {
          //secciones.push($(this).val());
          ref_sino=$(this).val();
        }
      });

      if(ref_sino=='S')
      { nrows = $("#tbody_valreflaboral tr").length;
        if(nrows>0)
        {
          var entidad_val_ref= new Array();var nombre_val_ref= new Array();var puesto_val_ref= new Array();var contacto_val_ref= new Array();var comentarios_val_ref= new Array();
          nrows = $("#tbody_valreflaboral tr").length;
          var datos_val_ref  = [];
          var objeto_val_ref = {};
          for (var x = 0; x < nrows; x++) 
          { 
            entidad_val_ref[x] = document.getElementById('tbody_valreflaboral').getElementsByTagName("tr")[x].getElementsByTagName("td")[0].innerHTML;
            nombre_val_ref[x] = document.getElementById('tbody_valreflaboral').getElementsByTagName("tr")[x].getElementsByTagName("td")[1].innerHTML;
            puesto_val_ref[x] = document.getElementById('tbody_valreflaboral').getElementsByTagName("tr")[x].getElementsByTagName("td")[2].innerHTML;
            contacto_val_ref[x] = document.getElementById('tbody_valreflaboral').getElementsByTagName("tr")[x].getElementsByTagName("td")[3].innerHTML;
            comentarios_val_ref[x] = document.getElementById('tbody_valreflaboral').getElementsByTagName("tr")[x].getElementsByTagName("td")[4].innerHTML;
        
            datos_val_ref.push({ 
            "entidad_val_ref" : entidad_val_ref[x],
            "nombre_val_ref"  : nombre_val_ref[x],
            "puesto_val_ref"    : puesto_val_ref[x],
            "contacto_val_ref"   : contacto_val_ref[x],
            "comentarios_val_ref"   : comentarios_val_ref[x]
            });
            objeto_val_ref.datos_val_ref = datos_val_ref;
            datajson_val_ref=JSON.stringify(objeto_val_ref);
          
          }
        }
        else
        {	$('#msn_sig_p_1').html('');
          $('#msn_sig_p_1').html('<i class="fas fa-exclamation-triangle"></i> Debe agregar las validaciones de las referencias');
          $('#valida_exp_entidad').focus();
          setTimeout(function(){ $('#msn_sig_p_1').html(''); }, 4000);
          next_step = false;
        }
      }




      nrowsprueba = $("#tbody_pruebaspsico tr").length;
        if(nrowsprueba<=0)
        {
        /*  var prueba= new Array();var fenvio= new Array();var resp_prueba= new Array();;
          nrowsprueba = $("#tbody_pruebaspsico tr").length;
          var datos_val_pruebapsico  = [];
          var objeto_val_pruebapsico = {};
          for (var x = 0; x < nrowsprueba; x++) 
          { 
            prueba[x] = document.getElementById('tbody_pruebaspsico').getElementsByTagName("tr")[x].getElementsByTagName("td")[0].innerHTML;
            fenvio[x] = document.getElementById('tbody_pruebaspsico').getElementsByTagName("tr")[x].getElementsByTagName("td")[1].innerHTML;
            resp_prueba[x] = document.getElementById('tbody_pruebaspsico').getElementsByTagName("tr")[x].getElementsByTagName("td")[2].innerHTML;

            datos_val_pruebapsico.push({ 
            "prueba" : prueba[x],
            "fenvio"  : fenvio[x],
            "resp_prueba"    : resp_prueba[x],
            });
            objeto_val_pruebapsico.datos_val_pruebapsico = datos_val_pruebapsico;
            datajson_val_pruebapsico=JSON.stringify(objeto_val_pruebapsico);
          
          }
        }
        else
        {	*/
          $('#msn_sig_p_1').html('');
          $('#msn_sig_p_1').html('<i class="fas fa-exclamation-triangle"></i> Debe agregar las pruebas psicológicas aplicadas.');
          $('#sel_evaluacion_aplicada').focus();
          setTimeout(function(){ $('#msn_sig_p_1').html(''); }, 4000);
          next_step = false;
        }
        





		
      if(next_step) 
      {	if((document.getElementById('divdesc_record').style.display=='none'))
          {	$('#msn_sig_p_1').html('');
            $('#msn_sig_p_1').html('<i class="fas fa-exclamation-triangle"></i> Adjuntar record policivo');
            setTimeout(function(){ $('#msn_sig_p_1').html(''); }, 4000);
            next_step = false;
          }
          else
          {	
            var filerecord= document.getElementById("filerecord").files;
            file_record = filerecord[0];
                
            var data = new FormData();    
            data.append("paso",paso); 
            data.append("id_curri", id_curri); 
            data.append("id_participante", id_participante); 
            data.append("ref_sino" , ref_sino);
            data.append("datajson_val_ref" , datajson_val_ref);
            //            data.append("datajson_val_pruebapsico", datajson_val_pruebapsico);
            //            data.append("f_envio_prueba", f_envio_prueba);
            //            data.append("pruebapsico_resultado", pruebapsico_resultado);
            data.append("filerecord", file_record);
                
            data.append("_token", _token);

            $.ajax({
              data:  data,
              url:   "{{ route('ofertas.sigpaso') }}",
              type:  'POST', 
              contentType: false,       // The content type used when sending data to the server.
              cache: false,             // To unable request pages to be cached
              processData:false,			// To send DOMDocument or non processed data file it is set to false+
              dataType: "json",       
              beforeSend: function () {
                document.getElementById("div_banges_"+$('#id_curri').val()).innerHTML='<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
              }, 
              success:  function (data) { 									
                document.getElementById("div_banges_"+$('#id_curri').val()).innerHTML=data.banges;
                if(ref_sino=='N')
                { $("#tbody_valreflaboral").html();}
                  nombre_completo=document.getElementById('spnombre_completo').innerHTML;
                  $('#txt_paso').val(3);
              }
            });
          }
      //      }
      }
    }
    if(paso==3)
    {
      checked = $('input[name="entre_sino"]:checked');
        $('[name="entre_sino[]"]:checked').map(function(){
        if (this.checked) {
          //secciones.push($(this).val());
          entre_sino=$(this).val();
        }
      });

      if(entre_sino=='S')
      {
        nrows = $("#tbody_entrefuncional tr").length;
        if(nrows>0)
        { id_participante=$('#id_participante').val()
          var parametros = {
            "_token":_token,
            "paso":paso,
            "id_participante":id_participante,
            "id_curri":id_curri,};
          $.ajax({
            data:  parametros, 
            url:   "{{ route('ofertas.sigpaso') }}",
            type:  'POST', 
            dataType: "json",
            cache: true, 
            success:  function (data) {                   
                document.getElementById("div_banges_"+$('#id_curri').val()).innerHTML=data.banges;  
                $('#txt_paso').val(4);
            }
          });
        }        
        else
        {	$('#msn_sig_p_3').html('');
          $('#msn_sig_p_3').html('<i class="fas fa-exclamation-triangle"></i> Debe programar las entrevistas funcionales');
          $('#sel_entrevistador').focus();
          setTimeout(function(){ $('#msn_sig_p_3').html(''); }, 4000);
          next_step = false;
        }
      }
    }
    if(paso==4)
    {
      
      len_desc_autorizacioncarta_ofl=document.getElementById('divdesc_autorizacioncarta_ofl').innerHTML.length;
      len_desc_propuesta_aceptada=document.getElementById('divdesc_propuesta_aceptada').innerHTML.length;

        nrows = $("#table_cartasofl tr").length;
        if((nrows>0)&&(len_desc_autorizacioncarta_ofl>0)&&(len_desc_propuesta_aceptada>0))
        { id_participante=$('#id_participante').val()
          var parametros = {
            "_token":_token,
            "paso":paso,
            "id_participante":id_participante,
            "id_curri":id_curri,};
          $.ajax({
            data:  parametros, 
            url:   "{{ route('ofertas.sigpaso') }}",
            type:  'POST', 
            dataType: "json",
            cache: true, 
            success:  function (data) {                   
                document.getElementById("div_banges_"+$('#id_curri').val()).innerHTML=data.banges;  
                $('#txt_paso').val(5);
            }
          });
        }        
        else
        {	$('#msn_sig_p_4').html('');
          $('#msn_sig_p_4').html('<i class="fas fa-exclamation-triangle"></i> Adjuntar documentos de aprobación y aceptación de la oferta laboral.');
          $('#sel_entrevistador').focus();
          setTimeout(function(){ $('#msn_sig_p_4').html(''); }, 4000);
          next_step = false;
        }
      
    }
    if(paso==5)
    {/* var lb_nombre=$('#lb_nombre').html();
      Swal.fire({
      text: "El candidato "+lb_nombre+" pasará a la firma de contrato, desea continuar?",
      icon: "question",
      showCancelButton: true,
      cancelButtonText:  '<i class="fas fa-arrow-left"></i> Cancelar',
      confirmButtonText: '<i class="fas fa-trash-alt"></i> Si, eliminar',
      confirmButtonColor: "#d33",
      }).then((result) => {
        if (result.isConfirmed) 
        {*/
          nrows_dependientes=$("#tbody_dependientes tr").length;
          nrows_contact = $("#tbody_contactos tr").length;

          if((document.getElementById('divdesc_ced').style.display=='none'))
          { msn='<i class="fas fa-exclamation-triangle"></i> Es necesario adjuntar una copia de la cédula.';
            next_step = false;}
          else
          { if((document.getElementById('divdesc_carnet_css').style.display=='none'))
            { msn='<i class="fas fa-exclamation-triangle"></i> Es necesario adjuntar una copia de Carné de S.S. o Ficha de S.S.';
              next_step = false;}
            else
            { if((document.getElementById('divdesc_certificado_nacimiento').style.display=='none'))
              { msn='<i class="fas fa-exclamation-triangle"></i> Es necesario adjuntar una copia del certificado de nacimiento';
                next_step = false;}
              else
              { if((document.getElementById('divdesc_constancia_dir').style.display=='none'))
                { msn='<i class="fas fa-exclamation-triangle"></i> Es necesario adjuntar una constancia de dirección (recibido de agua luz y teléfono)';
                  next_step = false;}
                else
                { if((document.getElementById('divdesc_dimploma').style.display=='none'))
                  { msn='<i class="fas fa-exclamation-triangle"></i> Es necesario adjuntar una copia del último diploma';
                    next_step = false;}
                  else
                  { if((document.getElementById('divdesc_foto').style.display=='none'))
                    { msn='<i class="fas fa-exclamation-triangle"></i> Es necesario adjuntar una foto tamaño Carnet';
                      next_step = false;}
                    else
                    { 
                      if(!document.getElementById('chk_val_sipe').checked)                    
                      { msn='<i class="fas fa-exclamation-triangle"></i> Es necesario validar el registro en SIPE';
                        next_step = false;}
                      else
                      { 
                        if(nrows_contact<=0)
                          { msn='<i class="fas fa-exclamation-triangle"></i> Es necesario agregar a los contactos en caso de urgencia';
                            next_step = false;}                      
                      }                      
                    }
                  }
                }
              }
            }
          }
          
          


          if(next_step==false)
          {
            $('#msn_sig_p_5').html('');
            $('#msn_sig_p_5').html(msn);
            setTimeout(function(){ $('#msn_sig_p_5').html(''); }, 4000);
            
          }
          else{
            var parametros = {
            "_token":_token,
            "paso":paso,
            "id_participante":id_participante,
            "id_curri":id_curri,};
            $.ajax({
              data:  parametros, 
              url:   "{{ route('ofertas.sigpaso') }}",
              type:  'POST', 
              dataType: "json",
              cache: true, 
              success:  function (data) {                   
                document.getElementById("div_banges_"+$('#id_curri').val()).innerHTML=data.banges;  
                $('#txt_paso').val(6);
                        }
            });
          }
        /*}
      });*/

    }
    

    return(next_step);
  }

</script>



