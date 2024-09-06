<!DOCTYPE html>
@extends('layouts.plantilla')

@section('content')

<!-- JavaScript -->
<script type="text/javascript">
  // <![CDATA[
   function preloader(){
      document.getElementById("preload").style.display = "none";
      document.getElementById("iframe").style.display = "block";
  // <!    document.getElementById("div_2").style.display = "block";
   }
   //preloader
   window.onload = preloader;
  // ]]>
  </script>
  
  <!-- Estilo -->
  <style>
    div#iframe {
      display: none;
    }
    div#preload {
      cursor: wait;
    }
  </style>
<!-- Button trigger modal -->
      <h5> Maestro de Descriptivos de Funciones</h5>
      <div class="card card-primary card-outline">
        <div class="card-header text-primary">     
    
     
    <span id="ModalLabel"><i class="fas fa-list"></i> Listado de Descriptivos de Funciones</span>
    
  </div>
  <div class="card-body">
    <small>
      <div id="preload" class="align-items-center justify-content-center text-center"><div class="spinner-border spinner-border-sm text-primary" role="status"></div></div>
    </small>

<!-- TABLA PRINCIPAL -->
    <div id="div_tabla">     
      <small>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-2">            
          
          
        <button type="button" class="btn btn-primary btn-sm" onclick="modalcrud(1,0)"><i class="fas fa-plus pe-2"></i> Nuevo Descriptivo de Funciones</button>
        </div>
        <div id="iframe" style="display: none;">
          <table id="MyTable" class="display compact table table-striped shadow table-bordered bg-white table-sm" style="width:100%">
            <thead class="bg-secondary">
              <tr>
                <th class="text-light text-center">NOMBRE DE DESCRIPTIVO</th>
                <th class="text-light text-center">JERARQUÍA</th>
                <th class="text-light text-center">TIPO</th>
                <th class="text-light text-center">ESTATUS</th>
                <th class="text-light text-center" width='6%'><i class="fas fa-cog"></i></th>
              </tr>
            </thead>
            <tbody class="text-dark" id="bodyMyTable">
              @foreach( $data_df as $df )
                @php if($df->status=='true'){ $status='<i class="fa-solid fa-circle-check text-success fa-lg"></i>';}else{ $status='<i class="fa-solid fa-triangle-exclamation text-warning fa-lg"></i>';}
                @endphp
                <tr>
                  <td>{{$df->nombredesc}}</td>
                  <td>{{$df->nombrejer}}</td>
                  <td>{{$df->nombretipojer}}</td>
                  <td><div class="row d-flex align-items-center justify-content-center text-center"> <div class="col">@php echo $status; @endphp</div></div></td>
                  <td>
                    <div class="row d-flex align-items-center justify-content-center text-center">
                      <div class="col-md-2 col-xs-6 text-secondary">
                        <i class="fa-solid fa-pencil fa-lg edit" onclick="modalcrud(2,{{$df->id}})" data-bs-toggle="modal" data-bs-target="#Modal"></i>  
                      </div>
                      <div class="col-md-2 col-xs-6 text-secondary">
                        <i class="fa-solid fa-trash-can fa-lg dell" onclick="modalcrud(3,{{$df->id}})" ></i>
                      </div>
                    </div>
                  </td>
              @endforeach
            </tbody>
          </table>
        </div>
      </small>
    </div>

    <!-- TABLA PRINCIPAL -->
    <div id="div_nuevo_df" style="display: none" class="mt-2 text-secondary">
      
      <div  class="d-grid gap-2 d-md-flex justify-content-md-end">
        <button type="button" class="btn btn-secondary btn-sm" onclick="canceladf()"><i class="fa-solid fa-arrow-left pr-2"></i> Cancelar</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="su(1)"  tabindex="-1" id="bto_guarda" style="display: block"><i class="fas fa-save pr-2"></i> Guardar</button>
        <button type="button" class="btn btn-success btn-sm" onclick="su(2)"  tabindex="-1" id="bto_actualiza" style="display: none"><i class="fa-solid fa-arrows-rotate pr-2"></i> Actualizar</button>
      </div>
      <small>
      <div class="accordion mt-2" id="accordionPanelsStayOpenExample">
          <!--I. INFORMACIÓN GENERAL -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="panel_1-heading">
              <button class="accordion-button collapsed text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#panel_1" aria-expanded="true" aria-controls="panel_1">
                <i class="fas fa-file-signature fa-lg me-2 text-primary"></i> I. Información General
                <span id="msg_panel_1" class="text-warning" style="display: none"> <small><small><i class="fas fa-exclamation-triangle ps-2"></i> Incompleto</small></small></span>
              </button>
            </h2>
            <div id="panel_1" class="accordion-collapse collapse" aria-labelledby="panel_1-heading">
              <div class="accordion-body">
                <div class="row mb-3">
                  <div class="col-4">
                    <label for="namedf" class="col-form-label col-form-label-sm">Nombre de la posición:</label>
                    <input type="text" class="form-control form-control-sm" name="namedf" id="namedf">
                      <input type="hidden" id="iddf" value="0">
                      <input type="hidden" id="ad_up" value="-">
                              @csrf  
                          </div>
                          <div class="col-4">
                              <label for="idjer" class="col-form-label col-form-label-sm">Jerarquía:</label>
                              <select class="form-select form-select-sm" name="idjer" id="idjer" aria-label="Default select example">
                                  <option value='0' selected>Seleccione</option>
                                  @php
                                      $grupo='';$band=0;
                                  @endphp
                                  @foreach( $data_jer as $jer )
                                      @php
                                          if($grupo=='')
                                          {   echo'<optgroup label="'.$jer->tipo.'">';
                                              $grupo=$jer->tipo;
                                          }
                                          else {
                                          if($grupo!=$jer->tipo)
                                              {   echo'</optgroup><optgroup label="'.$jer->tipo.'">';
                                              $grupo=$jer->tipo;
                                              }
                                          }
                                      @endphp
                                  <option value="{{ $jer->id }}">{{ $jer->nombrejer }}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="col-4">
                              <label for="cargojefe" class="col-form-label col-form-label-sm">Cargo del jefe inmediato:</label>
                              <input type="text" class="form-control form-control-sm" name="cargojefe" id="cargojefe">
                          </div>
                      </div>

                      <div class="row mb-3">
                          <div class="col-4">
                              <label for="nameareadf" class="col-form-label col-form-label-sm">Área o departamento al que pertenece:</label>
                              <input type="text" class="form-control form-control-sm" name="nameareadf" id="nameareadf">
                              
                          </div>
                          <div class="col-2">
                              <label for="numreportedir" class="col-form-label col-form-label-sm">Reportes directos: </label>
                              <input type="number" class="form-control form-control-sm" name="numreportedir" id="numreportedir" min="0">
                          </div>
                          <div class="col-4 pt-4 mt-2 text-center">
                              <input class="form-check-input" type="checkbox" id="status" name="status" checked>
                              <label class="form-check-label" for="status">
                                  Habilitado
                              </label>
                          </div>
                      </div>

              </div>
            </div>
          </div>

          <!--II. PROPÓSITO GENERAL DEL CARGO -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="panel_2-heading">
              <button class="accordion-button collapsed text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#panel_2" aria-expanded="false" aria-controls="panel_2">
                <i class="fas fa-bullseye fa-lg me-2 text-primary"></i> II. Propósito General del Cargo 
                <span id="msg_panel_2" class="text-warning" style="display: none"> <small><small><i class="fas fa-exclamation-triangle ps-2"></i> Incompleto</small></small></span>
              </button>
            </h2>
            <div id="panel_2" class="accordion-collapse collapse" aria-labelledby="panel_2-heading">
              <div class="accordion-body">
                <div class="text-secondary mb-3"><small>Razón de ser, misión de la posición</small></div>              
                <div class="mb-3">
                    <label for="txtproposito" class="form-label">Propósito del cargo:</label>
                    <textarea class="form-control  form-control-sm" id="txtproposito" rows="3"></textarea>
                </div>
              </div>
            </div>
          </div>

          <!--III. PRINCIPALES RESPONSABILIDADES DEL CARGO panel_3 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="panel_3-heading">
              <button class="accordion-button collapsed text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#panel_3" aria-expanded="false" aria-controls="panel_3">
                <i class="fas fa-list-ol fa-lg me-2 text-primary"></i> III. Principales Responsablebilidades del Cargo
                <span id="msg_panel_3" class="text-warning" style="display: none"> <small><small><i class="fas fa-exclamation-triangle ps-2"></i> Incompleto</small></small></span>
              </button>
            </h2>
            <div id="panel_3" class="accordion-collapse collapse" aria-labelledby="panel_3-heading">
              <div class="accordion-body">
                <div class="text-secondary mb-3">
                  <small>Describa los resultados específicos que deben lograrse, debe de estar relacionado al Propósito General del Cargo: Verbo-Acción-Resultado</small>
                </div>
                <span  class="d-grid gap-2 d-md-flex justify-content-md-end mb-2">
                  <button type="button" class="btn btn-sm btn-outline-info" onclick="modal_add_areas_respon()"> <i class="far fa-plus-square fa-lg me-2"></i>Agregar</button>
                </span> 
                <div class="row">
                  <small>
                    <table id="table_respon" class="display compact table table-striped shadow table-bordered table-sm " style="width:100%">
                      <thead>
                        <tr>
                          <th class="text-light text-center align-middle bg-info">Áreas de Responsabilidad</th>
                          <th class="text-light text-center align-middle bg-info">Tareas</th>
                          <th class="text-light text-center align-middle bg-info">Nivel de Criticidad<br><small><small>(Alto, Medio, Bajo)</small></small></th>
                          <th class="text-light text-center align-middle bg-info">KPI<br><small><small>(Criterios de Medición)</small></small></th>
                          <th class="text-light text-center align-middle bg-info" width='6%'><i class="fas fa-cog"></i></th>
                        </tr>
                      </thead>
                      <tbody class="text-secondary" id="body_respon">
                        
                        <!-- Listado de responsabilidades -->

                      </tbody>
                    </table>
                  </small>
                </div>
              </div>
            </div>
          </div>
          
          <!--IV. RELACIÓN DE INTERACCIÓN -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="panel_4-heading">
              <button class="accordion-button collapsed text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#panel_4" aria-expanded="false" aria-controls="panel_4">
                <i class="fas fa-people-arrows fa-lg me-2 text-primary"></i> IV. Relación de Interacción
                <span id="msg_panel_4" class="text-warning" style="display: none"> <small><small><i class="fas fa-exclamation-triangle ps-2"></i> Incompleto</small></small></span>
              </button>
            </h2>
            <div id="panel_4" class="accordion-collapse collapse" aria-labelledby="panel_4-heading">
              <div class="accordion-body">
                <div class="row">      
                    <div class="col-sm-6">                     
                      <label for="txt_interno" class="form-label pb-0 mb-0">Interno:</label>
                      <div class="text-secondary">
                        <small>Departamentos, Jefes y Clientes internos</small>
                      </div>
                      <textarea class="form-control form-control-sm" id="txt_interno" rows="3"></textarea>
                    </div>
                    <div class="col-sm-6">         
                      <label for="txt_externo" class="form-label pb-0 mb-0">Externo:</label>
                      <div class="text-secondary">
                        <small>Entidades, Proveedores, Instituciones y Clientes</small>
                      </div>
                      <textarea class="form-control form-control-sm" id="txt_externo" rows="3"></textarea>
                    </div>                
                </div>  
              </div>
            </div>
          </div>
                      
          <!--V. SEGURIDAD DEL PUESTO -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="panel_5-heading">
              <button class="accordion-button collapsed text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#panel_5" aria-expanded="false" aria-controls="panel_5">
                <i class="fas fa-user-shield fa-lg me-2 text-primary"></i> V. Seguridad del Puesto
                <span id="msg_panel_5" class="text-warning" style="display: none"> <small><small><i class="fas fa-exclamation-triangle ps-2"></i> Incompleto</small></small></span>
              </button>
            </h2>
            <div id="panel_5" class="accordion-collapse collapse" aria-labelledby="panel_5-heading">
              <div class="accordion-body">
                <div class="text-secondary mb-3">
                  <small>Nivel de riesgo al que esta espuesta la posición de trabajo. Ej: Media Baja (60% Oficiana / 40% Campo)</small>
                </div>
                <div class="row">
                  <div class="col-sm-4">
                    <div class="mb-3">                
                      <div class="form-group">
                        <label for="sel_riesgo" class="col-form-label">Oficina / Campo</label>
                        <select class="form-select form-select-sm" style="width: 100%;"  id="sel_riesgo">
                          <option value="1" selected>Baja (100% Oficina / 0% Campo)</option>
                          <option value="2" >Media Baja (60% Oficina / 40% Campo)</option>
                          <option value="3" >Media (50% Oficina / 50% Campo)</option>
                          <option value="4" >Media Alta (40% Oficina / 60% Campo)</option>
                          <option value="5" >Alta (0% Oficina / 100% Campo)</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-8">          
                    <div class="mb-3">
                      <label for="txt_epp" class="col-form-label">Equipo de Protección</label>
                      <input type="text" class="form-control form-control-sm" max="250" id="txt_epp" placeholder="...">
                    </div>
                  </div>  
                </div>  

              </div>
            </div>
          </div>
                      
          <!--VI. REQUISITOS DEL PUESTO -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="panel_6-heading">
              <button class="accordion-button collapsed text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#panel_6" aria-expanded="false" aria-controls="panel_6">
                <i class="fas fa-tasks fa-lg me-2 text-primary"></i> VI. Requisitos del Puesto
                <span id="msg_panel_6" class="text-warning" style="display: none"> <small><small><i class="fas fa-exclamation-triangle ps-2"></i> Incompleto</small></small></span>
              </button>
            </h2>
            <div id="panel_6" class="accordion-collapse collapse" aria-labelledby="panel_6-heading">
              <div class="accordion-body">            
                <div class="text-secondary mb-3">
                  <small>Nivel académico requerido para la posición, tomando en cuenta que Bachiller es el nivel más bajo y Maestría el más álto.</small>
                </div>              
                <div class="row align-items-center justify-content-center text-center">
                  <div class="col-sm-10 align-items-center justify-content-center text-center">
                    <small>
                    <table id="table_nivel_academico" class="display compact table table-sm" style="width:100%">
                      <thead>
                        <tr>
                          <th class="text-light text-center align-middle bg-info" colspan="5">Formación Académica</th>
                        </tr>
                      </thead>
                      <tbody class="text-light" id="tbody_nivel_academico">
                        <tr>
                          <td class="text-secondary text-center align-middle bg-light fw-bold"  width='30%'>Escolaridad</td>
                          <td class="text-secondary text-center align-middle bg-light fw-bold" width='8%'>Parcial</td>
                          <td class="text-secondary text-center align-middle bg-light fw-bold" width='8%'>Completo</td>     
                          <td class="text-secondary text-center align-middle bg-light fw-bold">Estudios Requeridos para el Puesto</td>                   
                        </tr>
                        <tr>
                          <td class="text-secondary align-middle text-start ps-2">     
                            <select class="form-select form-select-sm" style="width: 100%;"  id="sel_escolaridad">
                              <option value="0" selected>Seleccione</option>
                              <option value="1">1- Bachiller</option>
                              <option value="2">2- Técnico</option>
                              <option value="3">3- Licenciatura / Ingeniería</option>
                              <option value="4">4- Posgrado / Maestría</option>
                            </select>                     
                          </td>
                          <td class="text-center align-middle"><input class="form-check-input" type="radio" name="formacion_estatus_escolaridad" style="cursor: pointer;" id="formacion_estatus_escolaridad_p" ></td>
                          <td class="text-center align-middle"><input class="form-check-input" type="radio" name="formacion_estatus_escolaridad" style="cursor: pointer;" id="formacion_estatus_escolaridad_c" ></td>
                          <td><textarea class="form-control  form-control-sm" id="txt_escolaridad" rows="2" placeholder="Detallar..."></textarea></td>
                        </tr>
                        
                      </tbody>
                    </table>
                  </small>
                  </div>
                </div>
                <hr>
                <div class="row align-items-start text-secondary mb-3">
                  <h6>Experiencia</h6>
                </div>
                <div class="row align-items-center justify-content-center text-center ps-4">
                  
                  <div class="col-sm-4 text-start">
                    <div class="form-check form-switch">
                      <label class="form-check-label" for="exper_chk_norequiere" style="cursor: pointer;">
                        <input class="form-check-input" type="checkbox" id="exper_chk_norequiere" style="cursor: pointer;">No requiere
                      </label>
                    </div>
                    <div class="form-check form-switch">
                      <label class="form-check-label" for="exper_chk_aux_asis" style="cursor: pointer;">
                        <input class="form-check-input" type="checkbox" id="exper_chk_aux_asis" style="cursor: pointer;">Auxiliar/Asistente
                      </label>
                    </div>
                  </div>
                  
                  <div class="col-sm-4 text-start">
                    <div class="form-check form-switch">
                      <label class="form-check-label" for="exper_chk_ana_esp" style="cursor: pointer;">
                        <input class="form-check-input" type="checkbox" id="exper_chk_ana_esp" style="cursor: pointer;">Analista/Especialista
                      </label>
                    </div>
                    <div class="form-check form-switch">
                      <label class="form-check-label" for="exper_chk_sup_coor" style="cursor: pointer;">
                        <input class="form-check-input" type="checkbox" id="exper_chk_sup_coor" style="cursor: pointer;">Supervisor/Coordinador
                      </label>
                    </div>
                  </div>
                  
                  <div class="col-sm-4 text-start">
                    <div class="form-check form-switch">
                      <label class="form-check-label" for="exper_chk_jef_dep" style="cursor: pointer;">
                        <input class="form-check-input" type="checkbox" id="exper_chk_jef_dep" style="cursor: pointer;">Jefe de Área/Departamento
                      </label>
                    </div>
                    <div class="form-check form-switch">
                      <label class="form-check-label" for="exper_chk_jef_ge_dir" style="cursor: pointer;">
                        <input class="form-check-input" type="checkbox" id="exper_chk_jef_ge_dir" style="cursor: pointer;">Gerente/Director
                      </label>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="text-secondary mb-3">
                  <small>Indique la cantidad total de años de experiencia laboral y si requiere que sea de un sector o área específica ( retail, ventas, manejo del personal y clientes,  administración, etc.)</small>
                </div>
                
                <div class="row mb-3">
                  <div class="col">
                    <input type="text" class="form-control form-control-sm" max="200" id="txt_anos_experiencia" placeholder="Ej: Mínimo de 1-2 años de experiencia en el sector retail.">
                  </div>
                </div>

                 <hr>

                <div class="row">      
                  <div class="col-sm-6">      
                                   
                    <div class="row align-items-center justify-content-center text-center">
                      <div class="col-sm-10 align-items-center justify-content-center text-center">
                        <div class="row align-items-center justify-content-center mb-1">
                          <div class="col-sm-5">       
                              <input type="text" class="form-control form-control-sm" id="txt_programa" placeholder="Otro programa">
                          </div>        
              
                          <div class="col-sm-auto text-end">
                            <button type="button" class="btn btn-sm btn-outline-info" onclick="addrow('programa')"> <i class="far fa-plus-square fa-lg me-2"></i>Añadir</button>
                          </div>
                        </div>
                        <small>
                        <table id="table_programa" class="display compact table table-sm" style="width:100%">
                          <thead>
                            <tr>
                              <th class="text-light text-center align-middle bg-info" colspan="6">Conocimientos Informáticos</th>
                            </tr>
                            <tr>
                              <td class="text-secondary text-center align-middle bg-light fw-bold"  width='30%'>Programa</td>
                              <td class="text-secondary text-center align-middle bg-light fw-bold" width='8%'>N/A</td>
                              <td class="text-secondary text-center align-middle bg-light fw-bold" width='8%'>Básico</td>
                              <td class="text-secondary text-center align-middle bg-light fw-bold" width='8%'>Intermedio</td>     
                              <td class="text-secondary text-center align-middle bg-light fw-bold" width='8%'>Avanzado</td>   
                              <th class="text-secondary text-center align-middle bg-light fw-bold" width='5%'><i class="fas fa-cog"></i></th>                  
                            </tr>
                          </thead>
                          <tbody class="text-light" id="tbody_programa">
                            <tr>
                              <td class="text-secondary align-middle text-start ps-2">Word</td>
                              <td class="text-center align-middle"><input class="form-check-input" type="radio" name="programas_nivel_1" style="cursor: pointer;" id="programas_nivel_na_1" checked ></td>
                              <td class="text-center align-middle"><input class="form-check-input" type="radio" name="programas_nivel_1" style="cursor: pointer;" id="programas_nivel_b_1"></td>
                              <td class="text-center align-middle"><input class="form-check-input" type="radio" name="programas_nivel_1" style="cursor: pointer;" id="programas_nivel_i_1"></td>
                              <td class="text-center align-middle"><input class="form-check-input" type="radio" name="programas_nivel_1" style="cursor: pointer;" id="programas_nivel_a_1"></td>
                              <td class="text-center align-middle"><i class="fa-solid fa-trash-can dell" onclick="delrow(this,'programa')" title="Eliminar programa"></i></td>
                            </tr>
                            <tr>
                              <td class="text-secondary align-middle text-start ps-2">Excel</td>
                              <td class="text-center align-middle"><input class="form-check-input" type="radio" name="programas_nivel_2" style="cursor: pointer;" id="programas_nivel_na_2" checked ></td>
                              <td class="text-center align-middle"><input class="form-check-input" type="radio" name="programas_nivel_2" style="cursor: pointer;" id="programas_nivel_b_2"></td>
                              <td class="text-center align-middle"><input class="form-check-input" type="radio" name="programas_nivel_2" style="cursor: pointer;" id="programas_nivel_i_2"  ></td>
                              <td class="text-center align-middle"><input class="form-check-input" type="radio" name="programas_nivel_2" style="cursor: pointer;" id="programas_nivel_a_2"  ></td>
                              <td class="text-center align-middle"><i class="fa-solid fa-trash-can dell" onclick="delrow(this,'programa')" title="Eliminar programa"></i></td>
                            </tr>
                            <tr>
                              <td class="text-secondary align-middle text-start ps-2">Power Point</td>
                              <td class="text-center align-middle"><input class="form-check-input" type="radio" name="programas_nivel_3" style="cursor: pointer;" id="programas_nivel_na_3" checked></td>
                              <td class="text-center align-middle"><input class="form-check-input" type="radio" name="programas_nivel_3" style="cursor: pointer;" id="programas_nivel_b_3"></td>
                              <td class="text-center align-middle"><input class="form-check-input" type="radio" name="programas_nivel_3" style="cursor: pointer;" id="programas_nivel_i_3"></td>
                              <td class="text-center align-middle"><input class="form-check-input" type="radio" name="programas_nivel_3" style="cursor: pointer;" id="programas_nivel_a_3"></td>
                              <td class="text-center align-middle"><i class="fa-solid fa-trash-can dell" onclick="delrow(this,'programa')" title="Eliminar programa"></i></td>
                            </tr>
                          </tbody>
                        </table>
                      </small>
                      </div>
                    </div>              

                    
                    
                  </div>
                  <div class="col-sm-6">        
                    <div class="row align-items-center justify-content-center text-center">
                      <div class="col-sm-10 align-items-center justify-content-center text-center">
                        <div class="row align-items-center justify-content-center mb-1">
                          <div class="col-sm-5">       
                              <input type="text" class="form-control form-control-sm" id="txt_idioma" placeholder="Otro idioma">
                          </div>        
              
                          <div class="col-sm-auto text-end">
                            <button type="button" class="btn btn-sm btn-outline-info" onclick="addrow('idioma')"> <i class="far fa-plus-square fa-lg me-2"></i>Añadir</button>
                          </div>
                        </div>
                        <small>
                        <table id="table_idioma" class="display compact table table-sm" style="width:100%">
                          <thead>
                            <tr>
                              <th class="text-light text-center align-middle bg-info" colspan="6">Conocimiento de Idiomas</th>
                            </tr>
                            <tr>
                              <td class="text-secondary text-center align-middle bg-light fw-bold"  width='30%'>Idioma</td>
                              <td class="text-secondary text-center align-middle bg-light fw-bold"  width='8%'>N/A</td>
                              <td class="text-secondary text-center align-middle bg-light fw-bold" width='8%'>Básico</td>
                              <td class="text-secondary text-center align-middle bg-light fw-bold" width='8%'>Intermedio</td>     
                              <td class="text-secondary text-center align-middle bg-light fw-bold" width='8%'>Avanzado</td>   
                              <th class="text-secondary text-center align-middle bg-light fw-bold" width='5%'><i class="fas fa-cog"></i></th>               
                            </tr>
                          </thead>
                          <tbody class="text-light" id="tbody_idioma">
                            <tr>
                              <td class="text-secondary align-middle text-start ps-2">Inglés</td>
                              <td class="text-center align-middle"><input class="form-check-input" type="radio" name="idioma_nivel_1" style="cursor: pointer;" id="idioma_nivel_na_1" checked></td>
                              <td class="text-center align-middle"><input class="form-check-input" type="radio" name="idioma_nivel_1" style="cursor: pointer;" id="idioma_nivel_b_1"></td>
                              <td class="text-center align-middle"><input class="form-check-input" type="radio" name="idioma_nivel_1" style="cursor: pointer;" id="idioma_nivel_i_1"></td>
                              <td class="text-center align-middle"><input class="form-check-input" type="radio" name="idioma_nivel_1" style="cursor: pointer;" id="idioma_nivel_a_1"></td>
                              <td class="text-center align-middle"><i class="fa-solid fa-trash-can dell" onclick="delrow(this,'idioma')" title="Eliminar idioma"></i></td>
                            </tr>
                          </tbody>
                        </table>
                      </small>
                      </div>
                    </div>    
                    
                    
                  </div>                
              </div>
                
              </div>
            </div>
          </div>

          <!--VII. HABILIDADES Y OTROS CONOCIMIENTOS DEL PUESTO -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="panel_7-heading">
              <button class="accordion-button collapsed text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#panel_7" aria-expanded="false" aria-controls="panel_7">
                <i class="fas fa-lightbulb fa-lg me-2 text-primary"></i> VII. Habilidaes y Otros Conocimientos del Puesto
                <span id="msg_panel_7" class="text-warning" style="display: none"> <small><small><i class="fas fa-exclamation-triangle ps-2"></i> Incompleto</small></small></span>
              </button>
            </h2>
            <div id="panel_7" class="accordion-collapse collapse" aria-labelledby="panel_7-heading">
              <div class="accordion-body">
                <div class="text-secondary mb-3">
                  <small>Listar las habiliades y conocimientos técnicos pueden ser indispensables o deseables para la posición.</small>
                </div>              
                <div class="row align-items-center justify-content-center text-center">
                  <div class="row align-items-center justify-content-center">
                    <div class="col-sm-7">          
                      <div class="mb-3 text-start">
                        <label for="txt_habilidad" class="col-form-label pb-0">Habilidad o conocimiento</label>
                        <textarea class="form-control  form-control-sm" id="txt_habilidad" rows="2" placeholder="Detallar..."></textarea>
                      </div>
                    </div>        
        
                    <div class="col-sm-2">
                      <div class="mb-3">                
                          <label for="sel_habilidad" class="col-form-label pb-0">Nivel</label>
                          <select class="form-select form-select-sm" style="width: 100%;"  id="sel_habilidad">
                            <option value="1" selected>Deseado</option>
                            <option value="2">Indispensable</option>
                          </select>
                        </div>
                    </div>
        
                    <div class="col-sm-auto text-end pt-2">
                      <button type="button" class="btn btn-sm btn-outline-info" onclick="addrow('habilidad')"> <i class="far fa-plus-square fa-lg me-2"></i>Añadir</button>
                    </div>
                  </div>

                  <div class="col-sm-10 align-items-center justify-content-center text-center">
                    <small>
                    <table id="table_habilidad" class="display compact table shadow table-bordered table-sm table-hover" style="width:100%">
                      <thead>
                        <tr>
                          <th class="text-light text-center align-middle bg-info" width='4%'>#</th>
                          <th class="text-light text-center align-middle bg-info">Habilidades y otros conocimientos técnicos</th>
                          <th class="text-light text-center align-middle bg-info" width='20%'>Deseado o Indispensable</th>
                          <th class="text-light text-center align-middle bg-info" width='5%'><i class="fas fa-cog"></i></th>
                        </tr>
                      </thead>
                      <tbody class="text-light" id="tbody_habilidad">
                        
                      </tbody>
                    </table>
                  </small>
                  </div>
                </div>

              </div>
            </div>
          </div>
        
          <!--VIII.  AUTORIDAD DEL PUESTO -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="panel_8-heading">
              <button class="accordion-button collapsed text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#panel_8" aria-expanded="false" aria-controls="panel_8">
                <i class="fas fa-user-check fa-lg me-2 text-primary"></i> VIII.  Autoridad del Puesto
                <span id="msg_panel_8" class="text-warning" style="display: none"> <small><small><i class="fas fa-exclamation-triangle ps-2"></i> Incompleto</small></small></span>
              </button>
            </h2>
            <div id="panel_8" class="accordion-collapse collapse" aria-labelledby="panel_8-heading">
              <div class="accordion-body">
                <div class="text-secondary mb-3">
                  <small>Decisiones que pueden tomar sin consultar al jefe.</small>
                </div>              
                <div class="row align-items-center justify-content-center text-center">
                  <div class="col-sm-10 align-items-center justify-content-center text-center">
                    <div class="row align-items-center justify-content-center">
                      <div class="col-sm-9">          
                        <div class="mb-3 text-start">
                          <label for="txt_sin" class="col-form-label pb-0">Decisión que NO requiere autorización</label>
                          <textarea class="form-control  form-control-sm" id="txt_sin" rows="2" placeholder="Detallar..."></textarea>
                          
                        </div>
                      </div>        
          
                      <div class="col-sm-auto text-end pt-2">
                        <button type="button" class="btn btn-sm btn-outline-info" onclick="addrow('sin')"> <i class="far fa-plus-square fa-lg me-2"></i>Añadir</button>
                      </div>
                    </div>
                    <small>
                      <table id="table_sin" class="display compact table shadow table-bordered table-sm table-hover" style="width:100%">
                        <thead>
                          <tr>
                            <th class="text-light text-center align-middle bg-info" width='4%'>#</th>
                            <th class="text-light text-center align-middle bg-info">Decisiones</th>
                            <th class="text-light text-center align-middle bg-info" width='5%'><i class="fas fa-cog"></i></th>
                          </tr>
                        </thead>
                        <tbody class="text-light" id="tbody_sin">
                          
                        </tbody>
                      </table>
                    </small>
                  </div>
                </div>
                <hr>
                <div class="text-secondary mb-3">
                  <small>Temas que deben ser consultados con los superiores para tomas de desiciones</small>
                </div>              
                <div class="row align-items-center justify-content-center text-center">
                  <div class="col-sm-10 align-items-center justify-content-center text-center">
                    <div class="row align-items-center justify-content-center">
                      <div class="col-sm-9">          
                        <div class="mb-3 text-start">
                          <label for="txt_con" class="col-form-label pb-0">Decisión que SI requiere autorización</label>
                          <textarea class="form-control  form-control-sm" id="txt_con" rows="2" placeholder="Detallar..."></textarea>
                        </div>
                      </div>        
          
                      <div class="col-sm-auto text-end pt-2">
                        <button type="button" class="btn btn-sm btn-outline-info" onclick="addrow('con')"> <i class="far fa-plus-square fa-lg me-2"></i>Añadir</button>
                      </div>
                    </div>
                    <small>
                      <table id="table_con" class="display compact table shadow table-bordered table-sm table-hover" style="width:100%">
                        <thead>
                          <tr>
                            <th class="text-light text-center align-middle bg-info" width='4%'>#</th>
                            <th class="text-light text-center align-middle bg-info">Decisiones</th>
                            <th class="text-light text-center align-middle bg-info" width='5%'><i class="fas fa-cog"></i></th>
                          </tr>
                        </thead>
                        <tbody class="text-light" id="tbody_con">
                          
                        </tbody>
                      </table>
                    </small>
                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>
        </small>
    </div>

  </div>
</div>


<!--- MODAL RESPONSABILIDADES  -->
<div class="modal fade" id="Modal-respon" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static">
  <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-light py-2">
        <h5 class="modal-title text-secondary" id="exampleModalLabel"><i class="fas fa-list-ol fa-lg me-2 text-info"></i>Principales Responsabilidades del Cargo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <small>
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-4">          
              <div class="mb-3">
                <label for="txt_arearespon" class="col-form-label">Área de Responsabilidad</label>
                <input type="text" class="form-control form-control-sm" id="txt_arearespon">
              </div>
            </div>        
            <div class="col-md-4">
              <div class="mb-3">
                <label for="txt_kpi" class="col-form-label">KPI <small><small>(Criterios de Medición)</small></small></label>
                <input type="text" class="form-control form-control-sm" id="txt_kpi">
              </div>
            </div>
          </div>
          <hr>

          <div class="text-secondary mb-1">
            Listar todas las tareas correspondiente al área de responsabilidad que desea agregar, indicando su nivel de criticidad.
          </div>
          
          <div class="row align-items-center justify-content-center">
            <div class="col-sm-7">          
              <div class="mb-3">
                <label for="txt_tarea" class="col-form-label">Tarea</label>
                <input type="text" class="form-control form-control-sm" id="txt_tarea" placeholder="...">
              </div>
            </div>        

            <div class="col-sm-2">
              <div class="mb-3">                
                <div class="form-group">
                  <label for="sel_critricidad" class="col-form-label">Nivel de Criticidad</label>
                  <select class="form-select form-select-sm" style="width: 100%;"  id="sel_critricidad">
                    <option value="1" selected>Bajo</option>
                    <option value="2">Medio</option>
                    <option value="3">Alto</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="col-sm-auto text-end pt-4">
              <button type="button" class="btn btn-sm btn-outline-success" onclick="addrow('tareas')"> <i class="far fa-plus-square fa-lg me-2"></i>Añadir</button>
            </div>

          </div>
          <div class="row align-items-center justify-content-center text-center">
            <div class="col-sm-10 align-items-center justify-content-center text-center">
              <table id="table_tareas" class="display compact table table-striped shadow table-bordered table-sm " style="width:100%">
                <thead>
                  <tr>
                    <th class="text-light text-center align-middle bg-info" width='3%'>#</th>
                    <th class="text-light text-center align-middle bg-info" width='70%'>Tarea</th>
                    <th class="text-light text-center align-middle bg-info" width='20%'>Nivel de Criticidad</th>
                    <th class="text-light text-center align-middle bg-info" width='6%'><i class="fas fa-cog"></i></th>
                  </tr>
                </thead>
                <tbody class="text-secondary" id="tbody_tareas">
                  
                  <!-- Listado de responsabilidades -->

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </small>
      </div>
      <div class="modal-footer bg-light py-1"> 
        <div class="alert alert-danger align-items-center py-1 fade visually-hidden" role="alert" id="div_alert">
          <i class="fa-solid fa-triangle-exclamation pe-2"> </i> <span id="msg_alert"> </span>
        </div>    
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pe-2"></i> Cancelar</button>
        <button type="button" class="btn btn-sm btn-info" onclick="add_respon('tareas')"><i class="fas fa-save pe-2"></i>Agregar</button>
      </div>
    </div>
  </div>
</div>

@endsection

<script type='text/javascript'>
  function habrad()
  { if(document.getElementById('sel_escolaridad').value!=0)
    { document.getElementById('formacion_estatus_escolaridad_c').checked='checked';
      document.getElementById('formacion_estatus_escolaridad_p').checked='';    
      document.getElementById('txt_escolaridad').focus();
    }
    else{
      document.getElementById('formacion_estatus_escolaridad_c').checked='';
      document.getElementById('formacion_estatus_escolaridad_p').checked='';    
      document.getElementById('txt_escolaridad').value='';
    }
  }

  function addrow(opt_table)
  { if(opt_table=="tareas")
    { var nrows = $("#tbody_tareas tr").length;
      var txt = document.getElementById("txt_tarea").value;
      var sel = $("#sel_critricidad  option:selected").text();

      if(txt.length>5)
      { 
        contendor  = $("#tbody_tareas").html();
        nuevaFila   = '<tr>'+
        '<td>'+(nrows+1)+'</td>'+
        '<td class="ps-2 text-start">'+txt+'</td>'+
        '<td>'+sel+'</td>'+
        '<td class="text-center"><i class="fa-solid fa-trash-can dell" onclick=delrow(this,"tareas") title="Eliminar tarea"></i></td>'+
        '</tr>';
        $("#tbody_tareas").html(contendor+nuevaFila); 
        document.getElementById("txt_tarea").value="";
      }
      document.getElementById("txt_tarea").focus();
    }

    if(opt_table=='habilidad')
    {
      var nrows = $("#tbody_habilidad tr").length;
      var txt = document.getElementById("txt_habilidad").value;
      var sel = $("#sel_habilidad  option:selected").text();
      
      if(txt.length>5)
      { 
        contendor  = $("#tbody_habilidad").html();
        nuevaFila   = '<tr>'+
        '<td>'+(nrows+1)+'</td>'+
        '<td class="ps-2 text-start">'+txt+'</td>'+
        '<td>'+sel+'</td>'+
        '<td class="text-center"><i class="fa-solid fa-trash-can dell" onclick=delrow(this,"habilidad") title="Eliminar habilidad"></i></td>'+
        '</tr>';
        $("#tbody_habilidad").html(contendor+nuevaFila); 
        document.getElementById("txt_habilidad").value="";
      }
      document.getElementById("txt_habilidad").focus();
    }
    
    if(opt_table=='programa')
    {
      var nrows = $("#tbody_programa tr").length;
      var txt = document.getElementById("txt_programa").value;
      
      if(txt.length>2)
      { 
        contendor  = $("#tbody_programa").html();
        nuevaFila   = '<tr>'+
          '<td class="text-secondary align-middle text-start ps-2">'+txt+'</td>'+
          '<td class="text-center align-middle"><input class="form-check-input" type="radio" name="programas_nivel_'+(nrows+1)+'" style="cursor: pointer;" id="programas_nivel_na_'+(nrows+1)+'" checked ></td>'+
          '<td class="text-center align-middle"><input class="form-check-input" type="radio" name="programas_nivel_'+(nrows+1)+'" style="cursor: pointer;" id="programas_nivel_b_'+(nrows+1)+'"></td>'+
          '<td class="text-center align-middle"><input class="form-check-input" type="radio" name="programas_nivel_'+(nrows+1)+'" style="cursor: pointer;" id="programas_nivel_i_'+(nrows+1)+'"></td>'+
          '<td class="text-center align-middle"><input class="form-check-input" type="radio" name="programas_nivel_'+(nrows+1)+'" style="cursor: pointer;" id="programas_nivel_a_'+(nrows+1)+'"></td>'+
          '<td class="text-center align-middle"><i class="fa-solid fa-trash-can dell" onclick=delrow(this,"programa") title="Eliminar programa"></i></td>'+
        '</tr>';
        $("#tbody_programa").html(contendor+nuevaFila); 
        document.getElementById("txt_programa").value="";
      }
      document.getElementById("txt_programa").focus();
    }
    
    if(opt_table=='idioma')
    {
      var nrows = $("#tbody_idioma tr").length;
      var txt = document.getElementById("txt_idioma").value;
      
      if(txt.length>2)
      { 
        contendor  = $("#tbody_idioma").html();
        nuevaFila   = '<tr>'+
          '<td class="text-secondary align-middle text-start ps-2">'+txt+'</td>'+
          '<td class="text-center align-middle"><input class="form-check-input" type="radio" name="idioma_nivel_'+(nrows+1)+'" style="cursor: pointer;" id="idioma_nivel_na_'+(nrows+1)+'" checked ></td>'+
          '<td class="text-center align-middle"><input class="form-check-input" type="radio" name="idioma_nivel_'+(nrows+1)+'" style="cursor: pointer;" id="idioma_nivel_b_'+(nrows+1)+'"></td>'+
          '<td class="text-center align-middle"><input class="form-check-input" type="radio" name="idioma_nivel_'+(nrows+1)+'" style="cursor: pointer;" id="idioma_nivel_i_'+(nrows+1)+'"></td>'+
          '<td class="text-center align-middle"><input class="form-check-input" type="radio" name="idioma_nivel_'+(nrows+1)+'" style="cursor: pointer;" id="idioma_nivel_a_'+(nrows+1)+'"></td>'+
          '<td class="text-center align-middle"><i class="fa-solid fa-trash-can dell" onclick=delrow(this,"idioma") title="Eliminar idioma"></i></td>'+
        '</tr>';
        $("#tbody_idioma").html(contendor+nuevaFila); 
        document.getElementById("txt_idioma").value="";
      }
      document.getElementById("txt_idioma").focus();
    }

    if((opt_table=='sin')||(opt_table=='con'))
    {
      var nrows = $("#tbody_"+opt_table+" tr").length;
      var txt = document.getElementById("txt_"+opt_table).value;      
      if(txt.length>5)
      { 
        contendor  = $("#tbody_"+opt_table).html();
        nuevaFila   = '<tr>'+
        '<td>'+(nrows+1)+'</td>'+
        '<td class="ps-2 text-start">'+txt+'</td>'+
        '<td class="text-center"><i class="fa-solid fa-trash-can dell" onclick=delrow(this,"'+opt_table+'") title="Eliminar registro"></i></td>'+
        '</tr>';
        $("#tbody_"+opt_table).html(contendor+nuevaFila); 
        document.getElementById("txt_"+opt_table).value="";
      }
      document.getElementById("txt_"+opt_table).focus();
    }
  }

  function add_respon(opt_table)
  { var _token = $('input[name="_token"]').val();
    var iddf=$("#iddf").val();
    var ad_up=$("#ad_up").val();

    if(opt_table=="tareas")
    { var txt_arearespon=$("#txt_arearespon").val();
      var txt_kpi=$("#txt_kpi").val();
      var nrows = $("#tbody_tareas tr").length;
      var namedf = $("#namedf" ).val();
      var idjer = $("#idjer" ).val();
      datajson='-';
      msg='-';
      if(txt_arearespon.length>5)
      {
        if(txt_kpi.length>2)
        {
          if(nrows>0)
          {
            var tareas= new Array();var criticidad= new Array();        
            var datos  = [];
            var objeto = {};
            for (var x = 0; x < nrows; x++) 
            { 
              tareas[x] = (x+1)+". "+document.getElementById('tbody_tareas').getElementsByTagName("tr")[x].getElementsByTagName("td")[1].innerHTML;
              criticidad[x] = document.getElementById('tbody_tareas').getElementsByTagName("tr")[x].getElementsByTagName("td")[2].innerHTML;          
              datos.push({ 
              "tareas" : tareas[x],
              "criticidad"  : criticidad[x]
              });
              objeto.datos = datos;
              datajson=JSON.stringify(objeto);
            }
            var data = new FormData();    
            data.append("txt_arearespon",txt_arearespon); 
            data.append("txt_kpi", txt_kpi); 
            data.append("datajson" , datajson);
            data.append("iddf",iddf);
            data.append("ad_up",ad_up);   
            data.append("namedf",namedf);   
            data.append("idjer",idjer);      
            data.append("nrows",nrows);         
            data.append("_token", _token);

            $.ajax({
              data:  data,
              url:   "{{ route('descriptivos.addtarea') }}",
              type:  'POST', 
              contentType: false,       // The content type used when sending data to the server.
              cache: false,             // To unable request pages to be cached
              processData:false,			// To send DOMDocument or non processed data file it is set to false+
              dataType: "json",       
              success:  function (data) { 
                $("#iddf").val(data.iddf);		
                
                contendor  = $("#body_respon").html();	
                var nrows = $("#body_respon tr").length;
                nuevaFila  =""

                    nuevaFila   += '<tr>';
                    nuevaFila  += '<td class="ps-2 align-middle" rowspan="'+data.cant_tarea+'">'+data.area_respon+'</td>';      
                      x=0;
                    jQuery(data.tareas).each(function(i, item){
                      x++;
                      nuevaFila  += '<td class="align-middle">'+item.tarea+'</td>';
                          nuevaFila  += '<td class="text-center  align-middle">'+item.criticidad+'</td>';
                        if(x==1){
                          nuevaFila  += '<td class="ps-2 align-middle" rowspan="'+data.cant_tarea+'">'+data.kpi+'</td>'; 
                          nuevaFila  += '<td rowspan="'+data.cant_tarea+'" class="text-center align-middle"><i class="fas fa-search edit" onclick=edit_respon('+data.id_respon+')></i><span class="p-1"> </span><i class="fas fa-trash-alt dell" onclick=delrespon(this,"respon",'+data.id_respon+')></i></td></tr>';
                        }
                        else
                        { nuevaFila  += '</tr>';}
                    });
                    $("#body_respon").html(contendor+nuevaFila); 
                    $("#tbody_tareas").html(''); 
                    $("#txt_kpi").val('');
                    $("#txt_arearespon").val('');
                    $("#txt_arearespon").val('');
                    $("#txt_tarea").val('');
                    $("#Modal-respon").modal('toggle');
              }
            });
          }
          else
          { mal_alert('Agregar las tareas correspondientes al área de respondabilidad');
            $("#txt_tarea").focus();
          }
        }
        else
        { mal_alert('Indicar el criterio de medición');
        $("#txt_kpi").focus();
        }
      }
      else
      { mal_alert('Detallar más el área de responsabilidad');
        $("#txt_arearespon").focus();
      }
    }


  }

  function modal_add_areas_respon()
  {
    if((document.getElementById("namedf").value.length<=2)||($("#idjer" ).val()==0)){
      mal("Colocar antes el nombre de la posición y la jerarquía")
      var elemento = document.getElementById("panel_1");
      elemento.className += " show";
    }
    else{
      $("#Modal-respon").modal("show");
    }
  }

  function delrow(id,opt_table)
  {
      let row = id.parentNode.parentNode;
      let table = document.getElementById("table_"+opt_table); 
      table.deleteRow(row.rowIndex);   
      nrows = $("#tbody_"+opt_table+" tr").length; 
      if(opt_table!='programa'&&opt_table!='idioma')
      { for (var x = 0; x < nrows; x++) 
        { document.getElementById('tbody_'+opt_table).getElementsByTagName("tr")[x].getElementsByTagName("td")[0].innerHTML=(x+1);}
      }
  }

  function delrespon(id,opt_table,id_repon)
  { var _token = $('input[name="_token"]').val();
    var iddf=$("#iddf").val();
    Swal.fire({
        text: "Seguro desea eliminar el área de responsabilidad indicada?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Si, Eliminar!"
        }).then((result) => {
          if (result.isConfirmed) {
            var parametros = {
          "id_repon": id_repon,
          "iddf":iddf,
          "_token":_token};
          $.ajax({
            data:  parametros, 
            url:   "{{ route('descriptivos.destroyres') }}",
            type:  'POST', 
            dataType: "json",
            cache: true, 
            success:  function (data) { 

            if(data.resp==1)
            {
              const table = new DataTable('#table_opt_table');
              table.clear().draw(); 
              jQuery(data).each(function(i, item){ 
                
                table.row.add([
                  item.nombredesc,
                  item.nombrejer,
                  item.nombretipojer,
                  '<div class="row d-flex align-items-center justify-content-center text-center"> <div class="col">'+status+'</div></div>',
                  '<div class="row d-flex align-items-center justify-content-center text-center">'+
                  '<div class="col-md-2 col-xs-6 text-secondary">'+
                  '<i class="fa-solid fa-pencil fa-lg edit" onclick="modalcrud(2,'+item.id+')" data-bs-toggle="modal" data-bs-target="#Modal"></i>'+  
                  '</div>'+
                  '<div class="col-md-2 col-xs-6 text-secondary">'+
                  '<i class="fa-solid fa-trash-can fa-lg dell" onclick="modalcrud(3,'+item.id+')" ></i>'+
                  '</div>'+
                  '</div>'
                ]).draw(false);
              }); 
              
              bien('Área de responsabildiad eliminada.');
            }
            else{
              mal("No fue posible eliminar el área de responabildiad.")
            }

             
            }
          });            
          }
        });
  }

  function canceladf()
  {
    document.getElementById('div_nuevo_df').style.display="none";
    document.getElementById('div_tabla').style.display="block";
    document.getElementById('ModalLabel').innerHTML ='<i class="fas fa-plus-circle"></i> Listado de Descriptivos de Funciones';
  }

  
  function modalcrud(opt,id)
  { 
    var _token = $('input[name="_token"]').val();
    document.getElementById('bto_guarda').style.display="none";
    document.getElementById('bto_actualiza').style.display="none";
    document.getElementById('iddf').value=0;
    //NUEVA
    if(opt==1)
    { document.getElementById('ModalLabel').innerHTML ='<i class="far fa-plus-square"></i> Nuevo Descriptivo de Funciones';
      document.getElementById('bto_guarda').style.display="block";
      document.getElementById('namedf').value="";
      document.getElementById('idjer').value=0;
      document.getElementById('cargojefe').value="";
      document.getElementById('nameareadf').value="";
      document.getElementById('numreportedir').value=0;
      document.getElementById('txtproposito').value="";
      document.getElementById('status').checked=true;
      document.getElementById('div_nuevo_df').style.display="block";
      document.getElementById('div_tabla').style.display="none";
      //var ahora = new Date().toISOString();
      document.getElementById('iddf').value=0;
      document.getElementById('ad_up').value="ad";
    }
    //EDITA
    if(opt==2)
    { document.getElementById('ModalLabel').innerHTML ='<i class="fa-solid fa-pen-to-square  fa-lg"></i> Edita Descriptivo de Funciones';
      document.getElementById('bto_actualiza').style.display="block";
      document.getElementById('div_nuevo_df').style.display="block";
      document.getElementById('div_tabla').style.display="none";
      document.getElementById('iddf').value=id;
      document.getElementById('ad_up').value="up";
      var parametros = {
      "id": id,
      "_token" : _token};
      $.ajax({
        data:  parametros,
        url:   "{{ route('descriptivos.edit') }}", 
        type:  'POST', 
        dataType: "json",
        cache: true, 
        success:  function (data) { 
          jQuery(data).each(function(i, item){ 
            document.getElementById('namedf').value=item.nombredesc; 
            document.getElementById('idjer').value=item.idjer; 
            document.getElementById('cargojefe').value=item.cargojefe; 
            document.getElementById('nameareadf').value=item.area_depto; 
            document.getElementById('numreportedir').value=item.reportes; 
            document.getElementById('txtproposito').value=item.proposito; 
            if(item.status!='true'){document.getElementById('status').checked=false;}else{document.getElementById('status').checked=true;}
          });
        }
      });
    }
    if(opt==3)
    { document.getElementById('iddf').value=id;
      document.getElementById('namedf').value='...'; 
      document.getElementById('idjer').selectedIndex=1;
      Swal.fire({
        title: "Eliminar descriptivo de funciones",
        text: "Al eliminar este descriptivo de funciones, se eliminará también su relación con las posiciones. Desea Continuar?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Si, Eliminar!"
        }).then((result) => {
          if (result.isConfirmed) {
            var parametros = {
          "id": id,
          "_token":_token};
          $.ajax({
            data:  parametros, 
            url:   "{{ route('descriptivos.destroy') }}",
            type:  'POST', 
            dataType: "json",
            cache: true, 
            success:  function (data) { 
              const table = new DataTable('#MyTable');
              table.clear().draw(); 
              jQuery(data).each(function(i, item){ 
                
                table.row.add([
                  item.nombredesc,
                  item.nombrejer,
                  item.nombretipojer,
                  '<div class="row d-flex align-items-center justify-content-center text-center"> <div class="col">'+status+'</div></div>',
                  '<div class="row d-flex align-items-center justify-content-center text-center">'+
                  '<div class="col-md-2 col-xs-6 text-secondary">'+
                  '<i class="fa-solid fa-pencil fa-lg edit" onclick="modalcrud(2,'+item.id+')" data-bs-toggle="modal" data-bs-target="#Modal"></i>'+  
                  '</div>'+
                  '<div class="col-md-2 col-xs-6 text-secondary">'+
                  '<i class="fa-solid fa-trash-can fa-lg dell" onclick="modalcrud(3,'+item.id+')" ></i>'+
                  '</div>'+
                  '</div>'
                ]).draw(false);
              });
               bien('El descriptivo de funciones ha sido eliminado');
                $('#Modal').modal('hide');
            }
          });            
          }
        });
    }
  }
  
  function su(opt)
  { band=0;

    // ------ para actualizar
    var id = $('#iddf').val();  

    // ------------  Información General
    var namedf = $("#namedf" ).val();
    var idjer = $("#idjer" ).val();
    var cargojefe = $("#cargojefe" ).val();
    var nameareadf = $("#nameareadf" ).val();
    var numreportedir = $("#numreportedir" ).val();
    var status = document.getElementById('status').checked; 

    // ------------  Propósito general del cargo
    var txtproposito = $("#txtproposito" ).val();

    // ------------  Principales Responsabilidades del Cargo
    var nrows = $("#body_respon tr").length;
    if(nrows<1)
    { document.getElementById('msg_panel_3').style.display='block'; band=1;}

    // ------------  Relación de interacción    
    var txt_interno = $("#txt_interno" ).val();    
    var txt_externo = $("#txt_externo" ).val();
    if((txt_externo.length<1)||(txt_interno.length<1))
    { document.getElementById('msg_panel_4').style.display='block'; band=1;}

    // ------------  Seguridad del puesto 
    var sel_riesgo = $("#sel_riesgo  option:selected").text();   
    var txt_epp = $("#txt_epp" ).val();
    
    // ------------  Requisitos del puesto  p es parcial   c es completo
    opt_nivel_aca=document.getElementById('sel_escolaridad').value;


    if(opt_nivel_aca!=0)
    { if(document.getElementById('formacion_estatus_escolaridad_p').checked) 
      { estatus_nivel_aca='p';}
      if(document.getElementById('formacion_estatus_escolaridad_c').checked) 
      { estatus_nivel_aca='c';}
      txt_nivel_aca= document.getElementById('txt_escolaridad').value;
    }
    else    
    { document.getElementById('msg_panel_6').style.display='block'; band=1;}

    // ------------  Requisitos del puesto EXPERIENCIA
    experiencia_norequiere=0; experiencia_aux_asis=0; experiencia_ana_esp=0; experiencia_sup_coor=0; experiencia_jef_dep=0; experiencia_ge_dir=0;
    if(document.getElementById('exper_chk_norequiere').checked) { experiencia_norequiere=1;}
    if(document.getElementById('exper_chk_aux_asis').checked) { experiencia_aux_asis=1;}
    if(document.getElementById('exper_chk_ana_esp').checked) { experiencia_ana_esp=1;}
    if(document.getElementById('exper_chk_sup_coor').checked) { experiencia_sup_coor=1;}
    if(document.getElementById('exper_chk_jef_dep').checked) { experiencia_jef_dep=1;}
    if(document.getElementById('exper_chk_jef_ge_dir').checked) { experiencia_ge_dir=1;}
    if(experiencia_norequiere==0 && experiencia_aux_asis==0 && experiencia_ana_esp==0 && experiencia_sup_coor==0 && experiencia_jef_dep==0 && experiencia_ge_dir==0)
    { document.getElementById('msg_panel_6').style.display='block'; band=1;}

    // ------------- AÑOS DE EXPERIENCIA
    anos_experiencia=document.getElementById('txt_anos_experiencia').value;
    if((anos_experiencia.length<1)||(txt_interno.length<1))
    { document.getElementById('msg_panel_6').style.display='block';band=1;}
                  
    // ---------- HABILIDADES Y OTROS CONOCIMIENTOS DEL PUESTO
    var datajson_habilidades='';
    var nrows_habilidad = $("#tbody_habilidad tr").length;
    if(nrows_habilidad<1)
    { document.getElementById('msg_panel_7').style.display='block'; band=1;}
    else
    {
      var habilidades= new Array();var nivel_habilidades= new Array();        
      var datos_habilidades  = [];
      var objeto_habilidades = {};
      for (var x = 0; x < nrows_habilidad; x++) 
      { habilidades[x] = (x+1)+". "+document.getElementById('tbody_habilidad').getElementsByTagName("tr")[x].getElementsByTagName("td")[1].innerHTML;
        nivel_habilidades[x] = document.getElementById('tbody_habilidad').getElementsByTagName("tr")[x].getElementsByTagName("td")[2].innerHTML;          
        datos_habilidades.push({ 
          "habilidades" : habilidades[x],
          "nivel_habilidades"  : nivel_habilidades[x]
        });
        objeto_habilidades.datos_habilidades = datos_habilidades;
        datajson_habilidades=JSON.stringify(objeto_habilidades);
      }
    }

    // ---------- Decisión que NO requiere autorización
    var datajson_decisiones ='-';     
    var datos_decisiones  = [];
    var objeto_decisiones = {};
    var nrows_decisiones_sin = $("#tbody_sin tr").length;
    if(nrows_decisiones_sin>0)
    {
      for (var x = 0; x < nrows_decisiones_sin; x++) 
      { 
        var decisiones= new Array();var tipo_decisiones= new Array();   
        decisiones[x] = (x+1)+". "+document.getElementById('tbody_sin').getElementsByTagName("tr")[x].getElementsByTagName("td")[1].innerHTML;
        tipo_decisiones[x] = 0;          
        datos_decisiones.push({ 
          "decisiones" : decisiones[x],
          "tipo_decisiones"  : tipo_decisiones[x]
        });
        objeto_decisiones.datos_decisiones = datos_decisiones;
      }
    }

    // ---------- Decisión que SI requiere autorización
    var nrows_decisiones_con = $("#tbody_con tr").length;
    if(nrows_decisiones_con>0)
    { for (var x = 0; x < nrows_decisiones_con; x++) 
      { 
        var decisiones= new Array();var tipo_decisiones= new Array();   
        decisiones[x] = (x+1)+". "+document.getElementById('tbody_con').getElementsByTagName("tr")[x].getElementsByTagName("td")[1].innerHTML;
        tipo_decisiones[x] = 1;          
        datos_decisiones.push({ 
          "decisiones" : decisiones[x],
          "tipo_decisiones"  : tipo_decisiones[x]
        });
        objeto_decisiones.datos_decisiones = datos_decisiones;
      }
    }
    if (nrows_decisiones_sin>0||nrows_decisiones_con>0)
    { datajson_decisiones=JSON.stringify(objeto_decisiones); }      

      if(band==1)
      {
        Swal.fire({
        text: "Existen campos en blancos y que son necesarios para completar el Descriptivo de Funciones, Desea guardar y continuar en otro momento?",
        icon: "question",
        showCancelButton: true,              
        cancelButtonText:  '<i class="fas fa-arrow-left"></i> Cancelar',
        confirmButtonText: '<i class="fas fa-save pr-2"></i> Si, guardar',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {        
          var _token = $('input[name="_token"]').val();
      if(id==0)
      { var urls="{{ route('descriptivos.store') }}";}
      if(id>0)
      { var urls="{{ route('descriptivos.update') }}";}
      /*if(opt==3)
      { var urls="{{ route('descriptivos.destroy') }}";tipojer=1;idjer=1;}*/
      if(namedf.length>0)
      { if(idjer>0)
        { var parametros = {
          "opt" : opt,
          "id": id,
          "status" : status,
          "namedf" : namedf,
          "idjer" : idjer,
          "cargojefe" : cargojefe,
          "nameareadf" : nameareadf,
          "numreportedir" : numreportedir,
          "txtproposito" : txtproposito,
          "txt_interno" : txt_interno,
          "txt_externo" : txt_externo,
          "sel_riesgo" : sel_riesgo,
          "txt_epp" : txt_epp,
          "opt_nivel_aca" : opt_nivel_aca,  
          "estatus_nivel_aca" :estatus_nivel_aca,
          "txt_nivel_aca" : txt_nivel_aca,

          "experiencia_norequiere" : experiencia_norequiere,
          "experiencia_aux_asis" : experiencia_aux_asis,
          "experiencia_ana_esp" : experiencia_ana_esp,
          "experiencia_sup_coor" : experiencia_sup_coor,
          "experiencia_jef_dep" : experiencia_jef_dep,
          "experiencia_ge_dir" : experiencia_ge_dir,
          "anos_experiencia" : anos_experiencia,

          "nrows_habilidad" : nrows_habilidad,
          "datajson_habilidades" : datajson_habilidades,
          "nrows_decisiones_sin" : nrows_decisiones_sin,
          "nrows_decisiones_con" : nrows_decisiones_con,
          "datajson_decisiones" : datajson_decisiones,
          "_token":_token};
          $.ajax({
            data:  parametros, 
            url:   urls,
            type:  'POST', 
            dataType: "json",
            cache: true, 
            success:  function (data) { 
              const table = new DataTable('#MyTable');
              table.clear().draw(); 
              jQuery(data).each(function(i, item){ 
                var status="";
                if(item.status=='true'){ status='<i class="fa-solid fa-circle-check text-success fa-lg"></i>';}else{ status='<i class="fa-solid fa-triangle-exclamation text-warning fa-lg"></i>';}
                table.row.add([
                  item.nombredesc,
                  item.nombrejer,
                  item.nombretipojer,
                  '<div class="row d-flex align-items-center justify-content-center text-center"> <div class="col">'+status+'</div></div>',
                  '<div class="row d-flex align-items-center justify-content-center text-center">'+
                  '<div class="col-md-2 col-xs-6 text-secondary">'+
                  '<i class="fa-solid fa-pencil fa-lg edit" onclick="modalcrud(2,'+item.id+')" data-bs-toggle="modal" data-bs-target="#Modal"></i>'+  
                  '</div>'+
                  '<div class="col-md-2 col-xs-6 text-secondary">'+
                  '<i class="fa-solid fa-trash-can fa-lg dell" onclick="modalcrud(3,'+item.id+')" ></i>'+
                  '</div>'+
                  '</div>'
                ]).draw(false);
              });
              document.getElementById('namedf').value="";
              document.getElementById('idjer').value=0;
              document.getElementById('cargojefe').value="";
              document.getElementById('nameareadf').value="";
              document.getElementById('numreportedir').value=0;
              document.getElementById('txtproposito').value="";
              document.getElementById('status').checked=true;
              if(opt==1)
              { bien('El descriptivo de funciones ha sido creado');}
              if(opt==2)
              { bien('El descriptivo de funciones ha sido actualizado');}
              if(opt==3)
              { bien('El descriptivo de funciones ha sido eliminado');}
                $('#Modal').modal('hide');
            }
          });
        }
        else
        { mal('Por favor seleccionar la Jerarquía');}
      }
      else
      { mal('Por favor colocar el nombre de la posición del descriptivo de funciones');}
        }
      });
      }
      else{
        var _token = $('input[name="_token"]').val();
      if(id==0)
      { var urls="{{ route('descriptivos.store') }}";}
      if(id>0)
      { var urls="{{ route('descriptivos.update') }}";}
      /*if(opt==3)
      { var urls="{{ route('descriptivos.destroy') }}";tipojer=1;idjer=1;}*/
      if(namedf.length>0)
      { if(idjer>0)
        { var parametros = {
          "opt" : opt,
          "id": id,
          "status" : status,
          "namedf" : namedf,
          "idjer" : idjer,
          "cargojefe" : cargojefe,
          "nameareadf" : nameareadf,
          "numreportedir" : numreportedir,
          "txtproposito" : txtproposito,
          "txt_interno" : txt_interno,
          "txt_externo" : txt_externo,
          "sel_riesgo" : sel_riesgo,
          "txt_epp" : txt_epp,
          "opt_nivel_aca" : opt_nivel_aca,  
          "estatus_nivel_aca" :estatus_nivel_aca,
          "txt_nivel_aca" : txt_nivel_aca,

          "experiencia_norequiere" : experiencia_norequiere,
          "experiencia_aux_asis" : experiencia_aux_asis,
          "experiencia_ana_esp" : experiencia_ana_esp,
          "experiencia_sup_coor" : experiencia_sup_coor,
          "experiencia_jef_dep" : experiencia_jef_dep,
          "experiencia_ge_dir" : experiencia_ge_dir,
          "anos_experiencia" : anos_experiencia,

          "nrows_habilidad" : nrows_habilidad,
          "datajson_habilidades" : datajson_habilidades,
          "nrows_decisiones_sin" : nrows_decisiones_sin,
          "nrows_decisiones_con" : nrows_decisiones_con,
          "datajson_decisiones" : datajson_decisiones,
          "_token":_token};
          $.ajax({
            data:  parametros, 
            url:   urls,
            type:  'POST', 
            dataType: "json",
            cache: true, 
            success:  function (data) { 
              const table = new DataTable('#MyTable');
              table.clear().draw(); 
              jQuery(data).each(function(i, item){ 
                var status="";
                if(item.status=='true'){ status='<i class="fa-solid fa-circle-check text-success fa-lg"></i>';}else{ status='<i class="fa-solid fa-triangle-exclamation text-warning fa-lg"></i>';}
                table.row.add([
                  item.nombredesc,
                  item.nombrejer,
                  item.nombretipojer,
                  '<div class="row d-flex align-items-center justify-content-center text-center"> <div class="col">'+status+'</div></div>',
                  '<div class="row d-flex align-items-center justify-content-center text-center">'+
                  '<div class="col-md-2 col-xs-6 text-secondary">'+
                  '<i class="fa-solid fa-pencil fa-lg edit" onclick="modalcrud(2,'+item.id+')" data-bs-toggle="modal" data-bs-target="#Modal"></i>'+  
                  '</div>'+
                  '<div class="col-md-2 col-xs-6 text-secondary">'+
                  '<i class="fa-solid fa-trash-can fa-lg dell" onclick="modalcrud(3,'+item.id+')" ></i>'+
                  '</div>'+
                  '</div>'
                ]).draw(false);
              });
              document.getElementById('namedf').value="";
              document.getElementById('idjer').value=0;
              document.getElementById('cargojefe').value="";
              document.getElementById('nameareadf').value="";
              document.getElementById('numreportedir').value=0;
              document.getElementById('txtproposito').value="";
              document.getElementById('status').checked=true;
              if(opt==1)
              { bien('El descriptivo de funciones ha sido creado');}
              if(opt==2)
              { bien('El descriptivo de funciones ha sido actualizado');}
              if(opt==3)
              { bien('El descriptivo de funciones ha sido eliminado');}
                $('#Modal').modal('hide');
            }
          });
        }
        else
        { mal('Por favor seleccionar la Jerarquía');}
      }
      else
      { mal('Por favor colocar el nombre de la posición del descriptivo de funciones');}
      }
  }

  function mal(msn)
    {
      Swal.fire({
        position: 'center',
        icon: 'warning',
        text: msn,
      })
    }
  
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

  
</script>