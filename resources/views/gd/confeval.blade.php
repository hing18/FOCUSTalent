<!DOCTYPE html>
@extends('layouts.plantilla')
@section('title','Administración de Evaluaciones')
<script src="{{ asset('assets/js/code/highcharts.js')}}"></script>


@section('content')
<!-- JavaScript -->
<script type="text/javascript">
    function preloader(){
        document.getElementById("preload").style.display = "none";
        document.getElementById("iframe").style.display = "block";
    }
     window.onload = preloader;
</script>

  


<div class="card mb-3" id="div_conf_eval">
    <div class="card-header pb-0">
      <h4><i class="fas fa-cogs fa-lg"></i> Configuración de Evaluación del Desempeño</h4>
    </div>
    <div class="card-body">
      <small>
        <div id="preload" class="align-items-center justify-content-center text-center p-4 mt-4"><div class=" mt-4 spinner-border text-primary" role="status"></div></div>
      </small>
          <div id="iframe" style="display: none;">
            @csrf
            <!-- LISTADO DE EVALUACIONES-->
            <div id="lista_eval" class="mt-4">
              <div class="row mb-2 ms-4">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end" onclick="modalcrud()">
                  <div class="col text-start h5 text-info "> <i class="fas fa-th-list pe-2"></i> Listado de Evaluaciones</div>
                    <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-bs-toggle="modal" data-bs-target="#Modal">
                      <span class="text fw-bold"> <i class="fas fa-plus pr-2"></i> Nueva Evaluación</span>
                    </a>
                </div>
              </div>

              <div class="row">
                <div class="col">
                  <table  id="MyTable_eval" class="table small table-sm table-striped table-hover" style="width:100%">
                    <thead class="bg-info">
                      <tr>
                        <th class="text-light text-center bg-info" width="20%" >NOMBRE</th>
                        <th class="text-light text-center bg-info" width="10%" >ESTATUS</th>
                        <th class="text-light text-center bg-info" width="10%" >DESDE</th>
                        <th class="text-light text-center bg-info" width="10%" >HASTA</th>
                        <th class="text-light text-center bg-info" width="10%" ><span class="badge bg-secondary">Pendientes</span></th>
                        <th class="text-light text-center bg-info" width="10%" ><span class="badge bg-warning">En Proceso</span></th>
                        <th class="text-light text-center bg-info" width="10%" ><span class="badge bg-primary">Evaluados</span></th>
                        <th class="text-light text-center bg-info" width="10%" ><span class="badge bg-danger">Rechazados</span></th>
                        <th class="text-light text-center bg-info" width="10%" ><span class="badge bg-success">Avances</span></th>
                        <th class="text-light text-center bg-info" width="10%" ><i class="fas fa-cogs fa-lg"></i></th>
                      </tr>
                    </thead>
                    <tbody class="text-dark" id="tbody_list_eval">
                      @foreach( $evaluaciones as $pos )
                        @php if($pos->status==1){ $status='<span class="border border-success rounded text-success py-1 ps-2 pe-2 fw-bold"><i class="fas fa-check-circle fa-lg pe-2"></i>Activa </span>';}
                        if(($pos->activo + $pos->proceso + $pos->finalizado + $pos->rechazado)>0)
                        { $cumplimiento=round((($pos->finalizado + $pos->rechazado)/($pos->activo + $pos->proceso + $pos->finalizado + $pos->rechazado))*100);}
                        else{ $cumplimiento=0;}
                        @endphp
                        <tr>
                          <td style="text-align: center; vertical-align: middle;" id="eval_sel_{{ $pos->id }}">{{ $pos->observacion }}</td>
                          <td style="text-align: center; vertical-align: middle;">@php echo $status; @endphp</td>
                          <td style="text-align: center; vertical-align: middle;">{{ $pos->desde }}</td>
                          <td style="text-align: center; vertical-align: middle;">{{ $pos->hasta }}</td>
                          <td style="text-align: center; vertical-align: middle;">{{ $pos->activo }}</td>
                          <td style="text-align: center; vertical-align: middle;">{{ $pos->proceso }}</td>
                          <td style="text-align: center; vertical-align: middle;">{{ $pos->finalizado }}</td>
                          <td style="text-align: center; vertical-align: middle;">{{ $pos->rechazado }}</td>
                          <td style="text-align: center; vertical-align: middle;">{{ $cumplimiento }}%</td>
                          <td style="text-align: center; vertical-align: middle;">
                            <div class="dropdown py-0">
                              <button class="btn btn-sm dropdown-toggle btn-outline-info" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">Acciones</button>
                              <ul class="dropdown-menu p-0" aria-labelledby="dropdownMenu2">
                                <li><button class="dropdown-item pb-0 edit" type="button" onclick="mod_prospectos('+id_ofl_txt+')"><i class="fas fa-cogs pe-1"></i> Configuración</button></li>
                                <li><button class="dropdown-item pb-0 edit" type="button" onclick="mod_avances({{ $pos->id }})"><i class="fas fa-tachometer-alt pe-1"></i> Avances</button></li>
                                <li><button class="dropdown-item pb-0 edit" type="button" onclick="levaldores({{ $pos->id }})"><i class="fas fa-user-tie pe-1"></i> Evaluadores</button></li>
                                <li><button class="dropdown-item pb-0 edit" type="button" onclick="levaldos({{ $pos->id }})"><i class="fas fa-user-check pe-1"></i> Evaluados</button></li>
                              </ul>
                            </div>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <!-- LISTADO DE EVALUADOS -->
            <div id="div_evaluados" class="visually-hidden mt-4">
              <div class="row mb-2 ms-4">

                <div class="d-grid gap-2 d-md-flex justify-content-md-end pt-2">
                  <div class="col text-start h5 text-primary"><i class="fas fa-users pe-2"></i> Listado de Evaluados - <span class="text-secondary" id="nom_eval_evaldo"></span></div>
                    <a href="#" class="btn btn-sm btn-secondary" onclick="back()"><i class="fas fa-arrow-left pe-2 fa-lg"></i>Volver</a>
                </div>
              </div>

              <div class="row">
                <div class="col">
                  <table  id="MyTable" class="display compact table table-sm table-striped table-hover" style="width:100%">
                    <thead class="bg-primary">
                      <tr>
                        <th class="text-light text-center bg-primary" width="25%" >EVALUADO</th>
                        <th class="text-light text-center bg-primary" width="25%" >PUESTO</th>
                        <th class="text-light text-center bg-primary" width="25%" >EVALUADOR</th>
                        <th class="text-light text-center bg-primary" width="10%" >RESULTADO</th>
                        <th class="text-light text-center bg-primary" width="5%" >ESTADO</th>
                        <th class="text-light text-center bg-primary" width="10%" ><i class="fas fa-cogs fa-lg"></i></th>
                      </tr>
                    </thead>
                    <tbody class="text-dark" id="tbody_list_evaluados">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>


            <!-- LISTADO DE EVALUADORES -->
            <div id="div_evaluadores" class="visually-hidden mt-4">
              <div class="row mb-2 ms-4">

                <div class="d-grid gap-2 d-md-flex justify-content-md-end pt-2">
                  <div class="col text-start h5 text-primary"><i class="fa-solid fa-user-tie pe-2"></i> Listado de Evaluadores - <span class="text-secondary" id="nom_eval_evaldores"></span></div>
                    <a href="#" class="btn btn-sm btn-secondary" onclick="back()"><i class="fas fa-arrow-left pe-2 fa-lg"></i>Volver</a>
                </div>
              </div>

              <div class="row">
                <div class="col small">
                  <table  id="MyTable2" class="display MyTable compact table table-sm table-striped table-hover" style="width:100%">
                    <thead>
                      <tr>
                        <th class="text-light text-center bg-primary" width="25%" >EVALUADOR</th>
                        <th class="text-light text-center bg-primary" width="25%" >PUESTO</th>
                        <th class="text-light text-center bg-primary" width="25%" >UNIDAD</th>
                        <th class="text-light text-center bg-primary" width="5%" >POR EVALUAR</th>
                        <th class="text-light text-center bg-primary" width="5%" >EVALUADOS</th>
                        <th class="text-light text-center bg-primary" width="5%" >%</th>
                        <th class="text-light text-center bg-primary" width="10%" ><i class="fas fa-cogs fa-lg"></i></th>
                      </tr>
                    </thead>
                    <tbody class="text-dark" id="tbody_list_evaluadores">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <!-- AVANCES -->
            <div id="div_avances" class="visually-hidden mt-4">
              <div class="row mb-2 ms-4">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end pt-2">
                <div class="col text-start h5 text-primary"><i class="fas fa-tachometer-alt pe-2"></i> Avances </div>
                  <a href="#" class="btn btn-sm btn-secondary" onclick="back()"><i class="fas fa-arrow-left pe-2 fa-lg"></i>Volver</a>
                </div>
              </div><hr>
              <div class="row">                
                <div class="col-8 text-center" style="text-align: center">
                    <div id="container" style="text-align: center"></div>
                </div>
                <div class="col-4">
                  
                    <div id="container-pie"  class="text-center mt-0 me-0"  style="text-align: center"></div>
                  
                </div>
              </div>
              <div class="row small" id="tbl_avances"> </div>
            </div>
          </div>
        </div>
      </div>


  <!-- Modal CAMBIA ESTATUS-->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header py-2 bg-light">
          <h6 class="modal-title fs-5 text-secondary" id="staticBackdropLabel"><i class="fas fa-sync fa-lg pe-2"></i>  <span class="text-primary">Cambiar Estado</span></h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body small">
          <span id="lb_nombre_estatus"></span>
          <input type="hidden" value="0" id="fil">
          <input type="hidden" value="0" id="ideval">
          <div class="form-group row text-center mt-4">
            <label for="sel_estatus" class="col-sm-2 col-form-label">Estado: </label>
            <div class="col-sm-8">
              <select class="form-select form-select-sm" id="sel_estatus">
                <option value="1">Pendiente</option>
                <option value="2">En proceso</option>
                <option value="3">Evaluado</option>
                <option value="4">Rechazado</option>
              </select>
            </div>
          </div>
        </div>

        <div class="modal-footer py-2 bg-light">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cancelar</button>
          <button type="button" class="btn btn-primary btn-sm" onclick="cambiast()"  tabindex="-1" id="bto_guarda" style="display: block"><i class="fas fa-save pr-2"></i> Guardar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal CAMBIA PASS-->
  <div class="modal fade" id="cambia-pass" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header py-2 bg-light">
          <h6 class="modal-title fs-5 text-secondary" id="staticBackdropLabel"><i class="fas fa-sync fa-lg pe-2"></i> <span class="text-primary">Cambiar contraseña de evaluador</span> </h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body small">
          <form>
          <input type="hidden" value="0" id="filr">
          <input type="hidden" value="0" id="idevalr">
          
            <div class="form-group py-2">
              @csrf
                <label id="lb_nombre_estatusr" class="form-label pb-2"></label>
                <br>
                <label id="passEmail" class="form-label pb-2 ">Correo</label>
                <br>
                <label for="password" class="form-label">Nueva contraseña</label>
                <div class="input-group  pb-2">
                  <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-lock text-secondary"></i></span>
                  <input type="text" id="password" name="password" class="form-control">
                </div>

                <div class="form-check py-2">
                  <input type="checkbox" class="form-check-input" id="resetpass" name="resetpass">
                  <label class="form-check-label" for="resetpass">Restablecer cuando ingresa</label>
                </div>
            </div>     
          </form>
        </div>

        <div class="modal-footer py-2 bg-light">
          <span id="lb_msn" class="text-danger small visually-hidden"><i class="fas fa-unlock-alt"></i> Colocar la nueva contraseña.</span>
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cancelar</button>
          <button type="button" class="btn btn-primary btn-sm" onclick="restpass()"  tabindex="-1" id="bto_guarda" style="display: block"><i id="ico_refresh" class="fas fa-sync"></i> Cambiar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal  CAMBIA EVALUADOR-->
  <div class="modal fade" id="cambiaevaldor" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg  modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header py-2 bg-light">
          <h6 class="modal-title fs-5 text-secondary" id="staticBackdropLabel"><i class="fas fa-people-arrows fa-lg pe-2"></i>  <span class="text-primary">Cambiar Evaluador</span></h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body small">
          <span id="lb_nombre_evaluado"></span>
          <input type="hidden" value="0" id="fil_evaldor">
          <input type="hidden" value="0" id="ideval_evaldor">
          <div class="row">
            <div class="col">            
              <!-- Table with stripped rows -->
              <table id="table_evaluadores" class="table MyTable table-sm table-striped table-hover" style="width:100%">
                <thead>
                  <tr>
                    <th class="text-light text-center bg-secondary" width="4%">SEL.</th>
                    <th class="text-light text-center bg-secondary" width="10%">CÓDIGO</th>
                    <th class="text-light text-center bg-secondary" width="36%">NOMBRE</th>
                    <th class="text-light text-center bg-secondary" width="50%">PUESTO</th>
                  </tr>
                </thead>
                <tbody id="tbody_evaluadores">                 
                  
                </tbody>
              </table>           
              <!-- End Table with stripped rows -->
            </div>
          </div>
        </div>

        <div class="modal-footer py-2 bg-light">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cancelar</button>
          <button type="button" class="btn btn-primary btn-sm" onclick="guardaevaldor()"  tabindex="-1" id="bto_guarda" style="display: block"><i class="fas fa-save pr-2"></i> Guardar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal CAMBIA PUESTO-->
  <div class="modal fade" id="cambiarpuesto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header py-2 bg-light">
          <h6 class="modal-title fs-5 text-secondary" id="staticBackdropLabel"><i class="fa-solid fa-person-circle-check fa-lg pe-2"></i>  <span class="text-primary">Cambiar Puesto a Evaluar</span></h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body small">
          <span id="lb_nombre_puesto"></span>
          <input type="hidden" value="0" id="fil_puesto">
          <input type="hidden" value="0" id="ideval_puesto">
          <div class="form-group row text-center mt-4">
            <label for="sel_unidad" class="col-sm-auto col-form-label">Unidad: </label>
            <div class="col-sm-8">
              <select class="form-select form-select-sm" id="sel_unidad" onchange="lista_puestos()">  
              </select>
            </div>
          </div>
          <div class="form-group row text-center mt-4">
            <label for="sel_puesto" class="col-sm-auto col-form-label">Puesto Evaluado: </label>
            <div class="col-sm">
              <select class="form-select form-select-sm" id="sel_puesto">
              </select>
            </div>
          </div>
        </div>

        <div class="modal-footer py-2 bg-light">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cancelar</button>
          <button type="button" class="btn btn-primary btn-sm" onclick="cambianewpuesto()"  tabindex="-1" id="bto_guarda" style="display: block"><i class="fas fa-save pr-2"></i> Guardar</button>
        </div>
      </div>
    </div>
  </div>


  <div id="div_informe"  class="visually-hidden" >
    <div id="resp_gap"> 
      <div class="row row-cols-5">  
        <div class="col p-1">
          <div class="card border border-bottom-0 border-end-0 border-top-0 border-3 shadow  border-primary">
            <div class="card-body py-2">
              <div class="row align-items-center">
                <div class="col p-0">
                  <div class="m-0 text-secondary text-center"><span class="h4 fw-bold" id="tot_gap_coef"></span></div>
                  <div class="text-primary fw-bold mb-1 text-center"><small><small>20% COEF. INTELECTUAL</small></small></div>                
                </div>
                <div class="col-auto m-0 pe-1">
                  <i class="fas fa-brain fa-lg text-secondary p-0"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
    
        <div class="col p-1">
          <div class="card border border-bottom-0 border-end-0 border-top-0 border-3 shadow  border-success">
            <div class="card-body py-2">
              <div class="row align-items-center">
                <div class="col p-0">
                  <div class="m-0 text-secondary text-center"><span class="h4 fw-bold" id="tot_gap_niv"></span></div>
                  <div class="text-success fw-bold mb-1 text-center"><small><small>20% NIV. ACADÉMICO</small></small></div>
                </div>
                <div class="col-auto m-0 pe-1">
                  <i class="fas fa-user-graduate fa-lg text-secondary p-0"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
    
        <div class="col p-1">
          <div class="card border border-bottom-0 border-end-0 border-top-0 border-3 shadow  border-info">
            <div class="card-body py-2">
              <div class="row align-items-center">
                <div class="col p-0">
                  <div class="m-0 text-secondary text-center"><span class="h4 fw-bold" id="tot_gap_com"></span></div>
                  <div class="text-info fw-bold mb-1 text-center"><small><small>30% COMPETENCIAS</small></small></div>
                </div>
                <div class="col-auto m-0 pe-1">
                  <i class="fas fa-list-ol fa-lg text-secondary p-0"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col p-1">
          <div class="card border border-bottom-0 border-end-0 border-top-0 border-3 shadow  border-warning">
            <div class="card-body py-2">
              <div class="row align-items-center">
                <div class="col p-0">
                  <div class="m-0 text-secondary text-center"><span class="h4 fw-bold" id="tot_gap_hab"></span></div>
                  <div class="text-warning fw-bold mb-1 text-center"><small><small>30% HABILIDADES</small></small></div>
                </div>
                <div class="col-auto m-0 pe-1">
                  <i class="fas fa-user-tag fa-lg text-secondary p-0"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col p-1">
          <div class="card border border-bottom-0 border-end-0 border-top-0 border-3 shadow  border-danger">
            <div class="card-body py-2">
              <div class="row align-items-center">
                <div class="col p-0">
                  <div class="m-0 text-secondary text-center"><span class="h4 fw-bold" id="tot_gap"></span></div>
                  <div class="text-danger fw-bold mb-1 text-center"><small><small>GAP TOTAL</small></small></div>
                </div>
                <div class="col-auto m-0 pe-1">
                  <i class="fas fa-user-cog fa-lg text-secondary p-0"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- GAP GLOBAL HASTA AQUI-->

    <!-- GENERALES DEL COLABORADOR-->    
    <div class="card mb-3">
      <div class="card-header pb-0">
        <h4><i class="fas fa-tasks"></i> Evaluación de Desempeño</h4>
      </div>
      <div class="card-body">  
        <div id="div_formulario" class="small">
          <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-2">           
            <a href="#" class="btn btn-sm btn-secondary" onclick="back_list()"><i class="fas fa-arrow-left pe-2 fa-lg"></i>Volver</a>
            <!--<a href="#" class="btn btn-sm btn-danger" onclick="no_evaluar()"><i class="fa-solid fa-ban pe-2 fa-lg"></i>No se evaluará</a>--> 
            <a href="#" class="btn btn-sm btn-success" id="bto_print" onclick="print()"><i class="fas fa-file-pdf pe-2 fa-lg"></i>Imprimir</a>
          </div>
          <div class="row mb-0">
            <section class="section profile">
              <div class="row">
                <div class="col-3 mt-4 pt-4">
                  <div class="card-body profile-card d-flex flex-column align-items-center mb-0">
                    <span class="align-items-center justify-content-center text-center" id="space_photo"><img src="/FOCUSTalent/public/storage/profiles/photo/el.png" alt="Profile" class="rounded-circle" id="img_photo"></span>
                    <h6 id="lb_nombre" class="text-primary fw-bold pt-2"></h6>
                  </div>
                </div>
                <div class="col-xl-8">
                  <div class="pt-4">
                    <div class="card-body  profile-card">

                      <div class="row mb-2" id="div_f_evaluacion">
                        <div class="col-auto label fw-bold text-secondary">F. Evaluación:</div>
                        <div id="lb_f_evaluacion" class="col-lg-9 col-md-8 text-secondary text-uppercase"> </div>
                      </div>

                      <div class="row mb-2">
                        <div class="col-auto label fw-bold text-secondary">Código:</div>
                        <div id="lb_code_evaluado" class="col-lg-9 col-md-8 text-secondary text-uppercase"> </div>
                      </div>                 

                      <div class="row mb-2">
                        <div class="col-auto label fw-bold text-secondary">Posición:</div>
                        <div id="lb_nom_puesto_evaluado" class="col-lg-9 col-md-8 text-secondary text-uppercase"></div>
                      </div>   

                      <div class="row mb-2">
                        <div class="col-auto label fw-bold text-secondary">Departamento:</div>
                        <div id="lb_nom_depto_evaluado" class="col-lg-9 col-md-8 text-secondary text-uppercase"></div>
                      </div>

                      <div class="row mb-2">
                        <div class="col-auto label fw-bold text-secondary">Fecha de Ingreso:</div>
                        <div id="lb_finicio" class="col-lg-9 col-md-8 text-secondary text-uppercase"> </div>
                      </div>

                      <div class="row mb-2" id="div_resultado">
                        <div class="col-auto label fw-bold text-secondary">Resultado:</div>
                        <div id="lb_resultado" class="col-lg-9 col-md-8 text-primary text-uppercase fw-bold"> </div>
                        <input type="hidden" id="estatus" value="">
                      </div>

                      <div class="row mb-2" id="div_calificacion">
                        <div class="col-auto label fw-bold text-secondary">Categoría:</div>
                        <div id="lb_calificacion" class="col-lg-9 col-md-8 text-primary fw-bold"> </div>
                      </div>

                      <div class="row mb-2">
                        <div class="col-auto label fw-bold text-secondary">Evaluador:</div>
                        <div id="lb_code_evaluador" class="col-lg-9 col-md-8 text-secondary text-uppercase"> </div>
                      </div>
                      
                      <div class="row mb-2">
                        <div class="col-auto label fw-bold text-secondary">Puesto Evaluador:</div>
                        <div id="lb_puesto_evaluador" class="col-lg-9 col-md-8 text-secondary text-uppercase"> </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section> 
          </div>
          <div id="resp_resumen" class="mt-0"> 
            <div class="row">
              <div class="col-6 text-center align-items-center">
                <div style="margin-top: 20%">
                  <table id="table_resp_cumpli_pid" class="table table-sm small table-striped" style="width:100%">
                    <thead>
                      <tr>
                        <th width="55%"></th>
                        <th class="text-primary text-center" width="15%" >VALOR</th>
                        <th class="text-primary text-center" width="15%" >PERSONA</th>
                        <th class="text-primary text-center" width="15%" >GAP</th>
                      </tr>
                    </thead>
                    <tbody class="text-dark" id="tbody_resp_eval">
                    </tbody>
                    <thead>
                      <tr>
                        <th class="text-primary text-center" >TOTAL</th>
                        <th class="text-primary text-center" ><span id="total_valor_eval"></span></th>
                        <th class="text-primary text-center" ><span id="total_cumpli_eval"></span></th>
                        <th class="text-primary text-center" ><span id="total_gap_eval"></span></th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
              <div class="col-6">
                <figure class="highcharts-figure">
                  <div id="container-graf"></div>
                </figure>
              </div>
            </div>
            <div id="div_pid_titulo" class="rounded-3 visually-hidden py-2 border border-info" style="background-color: #F3F8FF">
              <label class="card-title py-0 text-primary ps-4" ><i class="fas fa-address-card pe-2"></i> Plan Individual de Desarrollo</label> 

              <!-- PID DE COMPETENCIAS-->
              <div class="row visually-hidden" id="div_pid_cursos_com">
                <div class="col-1"></div>
                <div class="col">
                  <table id="table_resp_curcomp" class="table table-sm small table-borderless" style="width:90%">
                    <thead>
                      <tr>
                        <th class="text-primary text-sm" style="text-align: left; vertical-align: middle;background-color: #F3F8FF;"width="40%">COMPETENCIAS DE MAYOR GAP</th>
                        <th class="text-primary text-sm" style="text-align: left; vertical-align: middle;background-color: #F3F8FF;"width="40%">CURSOS ASIGNADOS</th>
                        <th class="text-primary text-sm" style="text-align: left; vertical-align: middle;background-color: #F3F8FF;"width="20%">FECHA</th>
                      </tr>
                    </thead>
                    <tbody class="text-dark" id="tbody_resp_curcomp"></tbody>            
                  </table>
                </div>
                <div class="col-1"></div>
              </div>
        
              <!-- PID DE HABILIDADES-->          
              <div class="row pt-4 visually-hidden" id="div_pid_cursos_hab">
                <div class="col-1"></div>
                <div class="col">
                  <table id="table_resp_curhab" class="table table-sm small pt-4 table-borderless" style="width:80%">
                    <thead>
                      <tr>
                        <th class="text-primary text-sm" style="text-align: left; vertical-align: middle;background-color: #F3F8FF;">CURSOS ASIGNADOS PARA HABILIDADES FUNCIONALES</th>       
                        <th class="text-primary text-sm" style="text-align: left; vertical-align: middle;background-color: #F3F8FF;">FECHA</th>        
                      </tr>
                    </thead>
                    <tbody class="text-dark" id="tbody_resp_curhab"></tbody>            
                  </table>
                </div>
                <div class="col-1"></div>
              </div>
        
              <!-- PID DE ADICIONALES-->  
              <div class="row pt-4 visually-hidden" id="div_pid_cursos_adi">
                <div class="col-1"></div>
                <div class="col">
                  <table id="table_resp_curadic" class="table table-sm small pt-4 table-borderless" style="width:90%">
                    <thead>
                      <tr>
                        <th colspan="3" class="text-primary text-sm" style="text-align: left; vertical-align: middle;background-color: #F3F8FF;">CURSOS ADICIONALES</th>               
                      </tr>
                      <tr>
                        <th class="text-secondary text-sm" style="text-align: left; vertical-align: middle;background-color: #F3F8FF;">ÁREA DE DESARROLLO</th> 
                        <th class="text-secondary text-sm" style="text-align: left; vertical-align: middle;background-color: #F3F8FF;">CURSO ASIGNADO</th>         
                        <th class="text-secondary text-sm" style="text-align: left; vertical-align: middle;background-color: #F3F8FF;">OTRAS ACCIONES ESPECÍFICAS</th>          
                      </tr>
                    </thead>
                    <tbody class="text-dark" id="tbody_resp_curadic"></tbody>            
                  </table>
                </div>
                <div class="col-1"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- GENERALES DEL COLABORADOR HASTA AQUI-->


      <!-- RESPUESTAS COMPETENCIAS -->
      <div class="card shadow mb-3 " id="resp_comp"> 
        <div class="card-header text-info">
          <i class="fas fa-list-ol fa-lg pe-2"></i> Competencias Organizacionales
        </div>
        <div class="card-body justify-content-center">
          <div class="row justify-content-center align-items-center text-center pt-4">
            <div class="col-11 text-center">       
              <table id="table_resp_competencias" class="table table-sm small" style="width:100%">
                <thead>
                  <tr>
                    <th class="text-primary text-center"width="50%" colspan="4">COMPETENCIAS</th>
                    <th class="text-primary text-center" width="10%" ></th>
                    <th class="text-primary text-center" width="10%" >VALOR</th>
                    <th class="text-primary text-center" width="10%" >PERSONA</th>
                    <th class="text-primary text-center" width="10%" >GAP</th>
                  </tr>
                </thead>
                <thead>
                  <tr class="table-primary">
                    <th class="text-primary text-center" colspan="4" width="50%"><small>VALORACIÓN</small></th>
                    <th class="text-primary text-center" width="20%" ></th>
                    <th class="text-primary text-center" width="10%" ><span id="tot_pts_comp"></span></th>
                    <th class="text-primary text-center" width="10%" ><span id="tot_cumpli_comp"></span></th>
                    <th class="text-primary text-center" width="10%" ><span id="tot_gap_comp"></span></th>
                  </tr>
                </thead>
                <tbody class="text-dark" id="tbody_resp_competencias"></tbody>

              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- RESPUESTAS TAREAS Y FUNCIONES -->
      <div class="card shadow mb-3 visually-hidden" id="resp_tar"> 
        <div class="card-header text-info">
          <i class="fas fa-user-check pe-2"></i> Tareas y Funciones
        </div>
        <div class="card-body justify-content-center">
          <div class="row justify-content-center align-items-center text-center pt-4">
            <div class="col-11 text-center">       
              <table id="table_resp_tar" class="table table-sm small" style="width:100%">
                <thead>
                  <tr>
                    <th class="text-primary text-center"width="52%">ÁREAS DE RESPONSABILIDAD</th>
                    <th class="text-primary text-center" width="18%" >VALOR</th>
                    <th class="text-primary text-center" width="12%" >PERSONA</th>
                    <th class="text-primary text-center" width="21%" >GAP</th>
                  </tr>

                  <tr class="table-primary">
                    <th class="text-primary text-center" ></th>
                    <th class="text-primary text-center" ><span id="tot_pts_tar"></span></th>
                    <th class="text-primary text-center" ><span id="tot_cumpli_tar"></span></th>
                    <th class="text-primary text-center" ><span id="tot_gap_tar"></span></th>
                  </tr>
                </thead>
                <tbody class="text-dark" id="tbody_resp_tar">
                  

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    
      <!-- RESPUESTAS HABILIDADES -->
      <div class="card shadow mb-3 visually-hidden" id="resp_hab"> 
        <div class="card-header text-info">
          <i class="fas fa-street-view pe-2"></i> Habilidades y Conocimientos
        </div>
        <div class="card-body justify-content-center">
          <div class="row justify-content-center align-items-center text-center pt-4">
            <div class="col-11 text-center">       
              <table id="table_resp_hab" class="table table-sm small" style="width:100%">
                <thead>
                  <tr>
                    <th class="text-primary text-center"width="55%">HABILIDADES</th>
                    <th class="text-primary text-center"width="15%">EVALUACIÓN</th>
                    <th class="text-primary text-center" width="10%" >VALOR</th>
                    <th class="text-primary text-center" width="10%" >PERSONA</th>
                    <th class="text-primary text-center" width="20%" >GAP</th>
                  </tr>

                  <tr class="table-primary">
                    <th class="text-primary text-center" ></th>
                    <th class="text-primary text-center" ></th>
                    <th class="text-primary text-center" ><span id="tot_pts_habi"></span></th>
                    <th class="text-primary text-center" ><span id="tot_cumpli_habi"></span></th>
                    <th class="text-primary text-center" ><span id="tot_gap_habi"></span></th>
                  </tr>
                </thead>
                <tbody class="text-dark" id="tbody_resp_hab">
                  

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    
      <!--- RESPUESTAS CUMPLIMIENTO KPI -->
      <div class="card shadow mb-3 visually-hidden" id="resp_cumplimiento_kpi">
        <div class="card-header text-info">
          <i class="fa-solid fa-chart-line pe-2"></i> Cumplimiento de Metas
        </div>
        <div class="card-body justify-content-center">
          <div class="row justify-content-center align-items-center text-center pt-4">
            <div class="col-11 text-center">       
              <table class="table table-sm small" style="width:100%">
                <thead>
                  <tr>
                    <th class="text-primary text-center"width="50%"></th>
                    <th class="text-primary text-center"width="20%">% PROMEDIO</th>
                    <th class="text-primary text-center" width="10%" >VALOR</th>
                    <th class="text-primary text-center" width="10%" >PERSONA</th>
                    <th class="text-primary text-center" width="10%" >GAP</th>
                  </tr>
                </thead>              
                <tbody class="text-dark" id="tbody_resp_cumpli_kpi_total">

                </tbody>
              </table>
            </div>      
            <div class="col-8 text-center small">       
              <table id="table_resp_cumpli_kpi" class="table table-striped table-sm small" style="width:100%">
                <thead>
                  <tr>
                    <th class="text-secondary text-center table-info" width="80%">INDICADOR</th>
                    <th class="text-secondary text-center table-info" width="20%" >% CUMPLIMIENTO</th>
                  </tr>
                </thead>
                <tbody class="text-dark" id="tbody_resp_cumpli_kpi">
                   
                </tbody>
              </table>
            </div>
          </div> 
        </div>
      </div>

      <!-- RESPUESTAS CUMPLIMIENTO PID -->
      <div class="card shadow mb-3 visually-hidden" id="resp_cumpli_pid"> 
        <div class="card-header text-info">
          <i class="fas fa-user-graduate pe-2"></i> Cumplimiento de Plan Individual de Desarrollo
        </div>
        <div class="card-body justify-content-center">
          <div class="row justify-content-center align-items-center text-center pt-4">
            <div class="col-11 text-center">       
              <table id="table_resp_cumpli_pid" class="table table-sm small" style="width:100%">
                <thead>
                  <tr>
                    <th class="text-primary text-center"width="60%">CURSOS</th>
                    <th class="text-primary text-center"width="10%">NOTA</th>
                    <th class="text-primary text-center" width="10%" >VALOR</th>
                    <th class="text-primary text-center" width="10%" >PERSONA</th>
                    <th class="text-primary text-center" width="10%" >GAP</th>
                  </tr>

                  <tr class="table-primary">
                    <th class="text-primary text-center" ></th>
                    <th class="text-primary text-center" ></th>
                    <th class="text-primary text-center" ><span id="tot_pts_cumpli_pid"></span></th>
                    <th class="text-primary text-center" ><span id="tot_cumpli_cumpli_pid"></span></th>
                    <th class="text-primary text-center" ><span id="tot_gap_cumpli_pid"></span></th>
                  </tr>
                </thead>
                <tbody class="text-dark" id="tbody_resp_cumpli_pid">
                  

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    
      <!-- RESPUESTAS LOGROS, PROYECCION DE CARRERA Y COMETARIOS DEL JEFE -->
      <div class="card shadow mb-3 visually-hidden" id="resp_desarrollo"> 
        <div class="card-body">
          <div class="my-3 ">
            <label class="card-title py-0 text-info"><i class="fas fa-user-tag pe-2"></i> Logros del Colaborador</label>
            <div class="col ps-4 small">

              <span id="resp_txtlogros"></span>
                
            </div>
          </div>

          <hr>

          <div class="my-3">
            <label class="card-title py-0 text-info"><i class="fas fa-user-tie pe-2"></i> Proyección de Desarrollo de Carrera</label>
            <div class="col ps-4 small">

              <span id="resp_promo">  </span>
                
            </div>
          </div>
          <hr>      
          
          <div class="my-3">
            <label class="card-title py-0 text-info"><i class="fas fa-comment-dots pe-2"></i> Comentarios del Evaluador</label>
            <div class="col ps-4 small">

              <span id="resp_txtcoment" ></span>
                
            </div>
          </div>
          
        </div>
      </div>

      </div>
@endsection


<script src="{{ asset('assets/js/code/modules/drilldown.js')}}"></script>
<script>
  function levaldos(cod)
  { $('#div_evaluados').removeClass('visually-hidden');
    $('#nom_eval_evaldo').html($('#eval_sel_'+cod).html());
    $('#lista_eval').addClass('visually-hidden');
      var parametros = {
        "id_eval":cod,
        "_token": $('input[name="_token"]').val()};
        $.ajax({
          data:  parametros,
          url:   "{{ route('evaluacion.levaldos') }}",
          type:  'POST',
          cache: false,
          dataType: "json",
          beforeSend: function () {
            $('#tbody_list_evaluados').html('<tr><td colspan="6"><div class="text-center  text-primary"><div class="spinner-border spinner-border-sm" role="status"></div><span class="ps-2">Cargando...</span></div></td></tr>');
          },
          success:  function (data) {
              const table = new DataTable('#MyTable');
              table.clear().draw();
              x=0;
              jQuery(data.evaluados).each(function(i, item){
                var status=""; var resultado="";var estado_eval="";
                x++;
                link_evaluado='';
                if(item.status==1){
                  status='<span class="badge bg-secondary">Pendiente</span>';
                  estado_eval='';
                }
                if(item.status==2){ status='<span class="badge bg-warning">En Proceso</span>';}
                if(item.status==3){ status='<span class="badge bg-primary">Evaluado</span>';
                  resultado=Number(item.resultado).toFixed(1)+ "%";
                  //link_evaluado='<span class="text-primary fw-bold"><i class="fas fa-search fa-lg pe-2"></i>Evaluado</span>';
                  link_evaluado='<li><button class="dropdown-item pb-0 edit" type="button" onclick="eval('+cod+','+item.id_evaluado+','+item.id_evaluador+')"><i class="fas fa-search pe-1 text-primary  fa-lg "></i> Ver Informe</button></li>';
                }

                if(item.status==4){ status='<span class="badge bg-danger">Rechazado</span>';}
                var nombre=item.prinombre + " " + item.priapellido;
                var evaldor=item.nom_evaldor + " " + item.ape_evaldor;

                table.row.add([
                  '<span id="code_evaldo_'+x+'">'+item.id_evaluado+ '</span> - <span id="nom_evaldo_'+x+'">'+nombre+ "</span>",
                  '<span id="descpue_'+x+'">'+item.descpue+'</span><input type="hidden"  id="code_puestoevaldo_'+x+'" value="'+item.id_posicion_evaluado+'"><input type="hidden"  id="code_ueevaldo_'+x+'" value="'+item.idue+'">',
                  '<span id="code_evaldor_'+x+'">'+item.id_evaluador+ "</span> - " + '<span id="nom_evaldor_'+x+'">'+evaldor+ "</span>",
                  '<div  class="fw-bold text-center" style="text-align: center; vertical-align: middle;"  id="res_'+x+'">'+resultado+'</div>',
                  '<div class="row d-flex align-items-center justify-content-center text-center"> <div class="col" id="st_'+x+'">'+status+'</div></div>',
                  '<div class="dropdown py-0">'+
                    '<button class="btn btn-sm btn-sm dropdown-toggle btn-outline-primary" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">Acciones</button>'+
                      '<ul class="dropdown-menu p-0" aria-labelledby="dropdownMenu2">'+
                        link_evaluado+
                        '<li><button class="dropdown-item pb-0 edit" data-bs-toggle="modal" data-bs-target="#cambiarpuesto" type="button" onclick="cambiapuesto('+cod+','+x+')"><i class="fa-solid fa-person-circle-check pe-1 text-primary  fa-lg "></i> Cambiar Puesto</button></li>'+
                        '<li><button class="dropdown-item pb-0 edit" data-bs-toggle="modal" data-bs-target="#staticBackdrop" type="button" onclick="cambiaestado('+cod+','+item.status+','+x+')"><i class="fas fa-sync pe-1 text-primary  fa-lg "></i> Cambiar Estado</button></li>'+
                        '<li><button class="dropdown-item pb-0 edit" data-bs-toggle="modal" data-bs-target="#cambiaevaldor" type="button" onclick="cambiaevaldor('+cod+','+x+')"><i class="fas fa-people-arrows pe-1 text-primary  fa-lg "></i> Cambiar Evaluador</button></li>'+
                      '</ul>'+
                  '</div>'
                ]).draw(false);
              });
          }
        });
  }
  
  function levaldores(cod)
  { $('#div_evaluadores').removeClass('visually-hidden');
    $('#nom_eval_evaldores').html($('#eval_sel_'+cod).html());
    $('#lista_eval').addClass('visually-hidden');
      var parametros = {
        "id_eval":cod,
        "_token": $('input[name="_token"]').val()};
        $.ajax({
          data:  parametros,
          url:   "{{ route('evaluacion.levaldores') }}",
          type:  'POST',
          cache: false,
          dataType: "json",
          beforeSend: function () {
            $('#tbody_list_evaluadores').html('<tr><td colspan="7"><div class="text-center  text-primary"><div class="spinner-border spinner-border-sm" role="status"></div><span class="ps-2">Cargando...</span></div></td></tr>');
          },
          success:  function (data) {
              const table = new DataTable('#MyTable2');
              table.clear().draw();
              x=0;
              jQuery(data.evaluadores).each(function(i, item){

                x++;

                var nombre=item.prinombre + " " + item.priapellido;  

                table.row.add([
                  '<span id="code_evaldor_'+x+'">'+item.id_evaluador+ '</span> - <span id="nom_evaldor_'+x+'">'+nombre+ "</span>",
                  item.descpue,
                  '<div id="res_'+x+'">'+item.nameund+'</div>',
                  '<div class="text-center" id="res_'+x+'">'+item.por_evaluar+'</div>',
                  '<div class="text-center" id="res_'+x+'">'+item.por_evaluados+'</div>',
                  '<div class="text-center" id="res_'+x+'">'+Number((item.por_evaluados/(item.por_evaluar+item.por_evaluados))*100).toFixed(0)+'%</div>',
                  '<div class="dropdown py-0">'+
                    '<button class="btn btn-sm btn-sm dropdown-toggle btn-outline-primary" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">Acciones</button>'+
                      '<ul class="dropdown-menu p-0" aria-labelledby="dropdownMenu2">'+

                        '<li><button class="dropdown-item pb-0 edit" data-bs-toggle="modal" data-bs-target="#cambia-pass" type="button" onclick="cambiapass('+cod+','+x+')"><i class="fas fa-sync pe-1"></i> Cambiar Contraseña</button></li>'+
                      '</ul>'+
                  '</div>'
                ]).draw(false);
              });
          }
        });
  }

  function cambiaestado(eval,st,x)
  {
    $('#lb_nombre_estatus').html($('#code_evaldo_'+x).html()+ ' - '+$('#nom_evaldo_'+x).html());
    $('#fil').val(x);
    $('#ideval').val(eval);
    $('#sel_estatus').val(st);
  }

  function cambiapuesto(eval,x)
  { $('#lb_nombre_puesto').html($('#code_evaldo_'+x).html()+ ' - '+$('#nom_evaldo_'+x).html());
    $('#fil_puesto').val(x);
    $('#ideval_puesto').val(eval);
    
    var parametros = {
    "eval_id": eval,
    "evaldo_id": $('#code_evaldo_'+x).html(),
    "code_puestoevaldo": $('#code_puestoevaldo_'+x).val(),
    "_token" : $('input[name="_token"]').val()}
    $.ajax({
      data:  parametros,
      url:   "{{ route('evaluacion.cambiapuesto') }}",
      type:  'POST', 
      cache: true, 
      dataType: "json",
      success:  function (data) {
        $('#sel_unidad').empty();
        $('#sel_puesto').empty();
        jQuery(data.unidades).each(function(i, item){ 
          if($('#code_ueevaldo_'+x).val()==item.id)
          { $('#sel_unidad').append('<option value="'+item.id+'" selected>'+item.nameund+'</option>');}
          else
          { $('#sel_unidad').append('<option value="'+item.id+'">'+item.nameund+'</option>');}
        });
        jQuery(data.puestos).each(function(i, item){ 
          if($('#code_puestoevaldo_'+x).val()==item.id)
          { $('#sel_puesto').append('<option value="'+item.id+'" selected>'+item.descpue+'</option>');}
          else
          { $('#sel_puesto').append('<option value="'+item.id+'">'+item.descpue+'</option>');}
        });
      }
    });
  }

  function lista_puestos()
  { var x=$('#fil_puesto').val();
    var parametros = {
    "sel_unidad": $('#sel_unidad').val(),
    "_token" : $('input[name="_token"]').val()}
    $.ajax({
      data:  parametros,
      url:   "{{ route('evaluacion.cambiaunidad') }}",
      type:  'POST', 
      cache: true, 
      dataType: "json",
      success:  function (data) {
        $('#sel_puesto').empty();
        $('#sel_puesto').append('<option value="0">Seleccione</option>');
        jQuery(data.puestos).each(function(i, item){ 
          if($('#code_puestoevaldo_'+x).val()==item.id)
          { $('#sel_puesto').append('<option value="'+item.id+'" selected>'+item.descpue+'</option>');}
          else
          { $('#sel_puesto').append('<option value="'+item.id+'">'+item.descpue+'</option>');}
          
        });
      }
    });
  }

  function cambianewpuesto()
  {
    var x=$('#fil_puesto').val();
    var parametros = {
    "id_eval": $('#ideval_puesto').val(),
    "cod_evaluado": $('#code_evaldo_'+x).html(),
    "sel_puesto": $('#sel_puesto').val(),
    "_token" : $('input[name="_token"]').val()}
    $.ajax({
      data:  parametros,
      url:   "{{ route('evaluacion.cambianewpuesto') }}",
      type:  'POST', 
      cache: false, 
      success:  function (data) {
        if(data==1)
        {
          $('#descpue_'+x).html($('#sel_puesto option:selected').text());
          $('#code_puestoevaldo_'+x).val($('#sel_puesto option:selected').val());
          bien('El puesto a evaluar ha sido modificado.');
        }
        else
        {
          mal('No se actualizó el puesto a evaluar. Intente cambiar el estado a "Pendiente" y luego modifique el puesto.');
        }
        $("#cambiarpuesto").modal('toggle')
      }
    });
  }

  function cambiapass(eval,x)
  { $('#passEmail').html('');
    $("#resetpass").prop("checked", true);
    $('#lb_nombre_estatusr').html("Evaluador: "+$('#code_evaldor_'+x).html()+ ' - '+$('#nom_evaldor_'+x).html());
    $('#filr').val(x);
    $('#idevalr').val(eval);
    var parametros = {
    "id_evaldor": $('#code_evaldor_'+x).html(),
    "_token" : $('input[name="_token"]').val()}
    $.ajax({
      data:  parametros,
      url:   "{{ route('evaluacion.mailevaluador') }}",
      type:  'POST',
          cache: true,
          dataType: "json",
      
      success:  function (data) {
        jQuery(data).each(function(i, item){ 
        $('#passEmail').html("Correo: <span id='mail'>"+item.mail+"</span>");
      });
      }
    });
  }

  function restpass()
  { $('#lb_msn').addClass('visually-hidden');
    chk=0;
    if ($("input[name='resetpass']").is(':checked')) 
    { chk=1;}
    pass=$('#password').val();
    if(pass.length < 3) {
      $('#lb_msn').removeClass('visually-hidden');
      setTimeout(function(){ $('#lb_msn').addClass('visually-hidden')}, 2000);
      $('#password').focus();
    }
    else{
      var parametros = {
    "id_evaldor" : $('#code_evaldor_'+$('#filr').val()).html(),
    "mail" : $('#mail').html(),
    "newpass":pass,
    "chk": chk,
    "_token" : $('input[name="_token"]').val()}
    $.ajax({
      data:  parametros,
      url:   "{{ route('evaluacion.resetpass') }}",
      type:  'POST',
      beforeSend: function () { $('#ico_refresh').addClass('fa-pulse'); },
      cache: true,      
      success:  function (data) {
        if(data==0)
        { mal("Contraseña no restablecida, por favor validar los datos del usuario");}
        else
        { bien("Contraseña restablecida.");}
        $('#ico_refresh').removeClass('fa-pulse');
        $('#cambia-pass').modal('hide');
      }
    });
    }
  }


  function cambiaevaldor(eval,x)
  { $('#lb_nombre_evaluado').html($('#code_evaldo_'+x).html()+ ' - '+$('#nom_evaldo_'+x).html());
    $('#fil_evaldor').val(x);
    $('#ideval_evaldor').val(eval);
    var parametros = {
    "eval_id": eval,
    "_token" : $('input[name="_token"]').val()}
    $.ajax({
      data:  parametros,
      url:   "{{ route('evaluacion.evaluadores') }}",
      type:  'POST', 
      cache: true, 
      dataType: "json",
      success:  function (data) {
        const table = new DataTable('#table_evaluadores');
        table.clear().draw();
        i=0;
        jQuery(data).each(function(i, item){ 
          i++;
          var nombre=item.prinombre + " " + item.priapellido;
          var sel="";
          if(item.id_evaluador==$('#code_evaldor_'+x).html())
          { sel="checked";}
           table.row.add([
            '<div style="text-align: center; vertical-align: middle;"><input class="form-check-input" style="width: 15px; height: 15px; cursor: pointer;" value="'+item.id_evaluador+'" type="radio" name="chk[]" id="chk_'+i+'" '+sel+'></div>',
            '<div style="text-align: center; vertical-align: middle;">'+item.id_evaluador+'</div>',
            nombre,
            item.descpue,
          ]).draw(false);
        });
      }
    });
  }

  function guardaevaldor()
  { band=0;
    $('[name="chk[]"]:checked').map(function(){
        if (this.checked) {
          //secciones.push($(this).val());
          new_cod_evaluador=$(this).val();
          band=1;
        }
    });

    if(band==1)
    {
      Swal.fire({
        text: 'Se cambiará el evaluador para el colaborador. ¿Desea continuar?',

        showCancelButton: true,
        cancelButtonText:  '<i class="fas fa-arrow-left"></i> Cancelar',
        confirmButtonText: '<i class="fas fa-save pr-2"></i> Si, continuar',
        confirmButtonColor: "#d33",
        icon: "warning",
      }).then((result) => {

        if (result.isConfirmed)
        { 
            
          var parametros = {
          "cod_evaluado": $('#code_evaldo_'+$('#fil_evaldor').val()).html(),
          "cod_evaluador": $('#code_evaldor_'+$('#fil_evaldor').val()).html(),
          "new_cod_evaluador": new_cod_evaluador,
          "eval_id": $('#ideval_evaldor').val(),
          "_token" : $('input[name="_token"]').val()}
          $.ajax({
            data:  parametros,
            url:   "{{ route('evaluacion.updateevaldor') }}",
            type:  'POST', 
            cache: true, 
            dataType: "json",
            success:  function (data) {
              
              jQuery(data).each(function(i, item){ 
                var nombre=item.prinombre + " " + item.priapellido;
                $('#code_evaldor_'+$('#fil_evaldor').val()).html(item.id);
                $('#nom_evaldor_'+$('#fil_evaldor').val()).html(nombre);
                bien("El evaluador ha sido actualizado.");
                $('#cambiaevaldor').modal('hide');
              });
            }
          });
        }
      });
    }else{
      mal('Debe seleccionar un evaluador.');
    }



    
  }

  function back()
  { $('#div_evaluados').addClass('visually-hidden');
    $('#div_conf_eval').removeClass('visually-hidden');
    $('#div_evaluadores').addClass('visually-hidden');
    $('#lista_eval').removeClass('visually-hidden');
    $('#div_informe').addClass('visually-hidden');
    $('#div_avances').addClass('visually-hidden');
  }

  function back_list()
  { $('#div_evaluados').removeClass('visually-hidden');
    $('#div_conf_eval').removeClass('visually-hidden');
    $('#div_evaluadores').addClass('visually-hidden');
    $('#lista_eval').addClass('visually-hidden');
    $('#div_informe').addClass('visually-hidden');
    $('#div_avances').addClass('visually-hidden');
  }

  function cambiast()
  {
    var st = $('#sel_estatus').val();

    var msn="";
      if(st==1) { msn="Se reiniciará la evaluación del colaborador. ¿Desea continuar?";}
      if(st==2) { msn="Se abrirá la evaluación del colaborador permitiendo al evaluador editar la misma. ¿Desea continuar?";}
      if(st==3) { msn="Finalizará la evaluación del colaborador. ¿Desea continuar?";}
      if(st==4) { msn="El colaborador no será evaluado. ¿Desea continuar?";}

      Swal.fire({
        text: msn,

        showCancelButton: true,
        cancelButtonText:  '<i class="fas fa-arrow-left"></i> Cancelar',
        confirmButtonText: '<i class="fas fa-save pr-2"></i> Si, continuar',
        confirmButtonColor: "#d33",
        icon: "warning",
      }).then((result) => {

        if (result.isConfirmed)
        {   var parametros = {
            "cod_evaluado": $('#code_evaldo_'+$('#fil').val()).html(),
            "cod_evaluador": $('#code_evaldor_'+$('#fil').val()).html(),
            "eval_id": $('#ideval').val(),
            "st": $('#sel_estatus').val(),
            "_token" : $('input[name="_token"]').val()}
            $.ajax({
              data:  parametros,
              url:   "{{ route('evaluacion.editstatus') }}",
              type:  'POST',
              cache: true,
              success:  function (data) {
                if(st==1){ $('#res_'+$('#fil').val()).html('');}
                $('#st_'+$('#fil').val()).html(data);
                bien("El estado ha sido actualizado.");
                $('#staticBackdrop').modal('hide');
              }
            });
          }
        });
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

  function eval(eval,evaldo,evaldor)
  { 
    $('#div_informe').removeClass('visually-hidden');
    $('#div_evaluados').addClass('visually-hidden');
    $('#div_conf_eval').addClass('visually-hidden');
    band_competencias=0; band_tareas=0; band_habilidades=0; band_kpi=0; band_pid=0;
    var _token = $('input[name="_token"]').val();
    var parametros = {
    "eval": eval,
    "evaldo": evaldo,
    "evaldor": evaldor,
    "_token":_token};
    $.ajax({
      data:  parametros, 
      url:   "{{ route('evaluacion.informe') }}",
      type:  'POST', 
      dataType: "json",
      cache: true, 
      beforeSend: function () {
        $('#space_photo').html('<div class="spinner-border text-primary mt-4" role="status"><span class="visually-hidden">Loading...</span></div>');
      }, 
      success:  function (data) {
        $('#resp_comp').removeClass('visually-hidden');
        $('#resp_tar').removeClass('visually-hidden');
        $('#resp_hab').removeClass('visually-hidden');
        $('#resp_cumpli_pid').addClass('visually-hidden');
        $('#resp_desarrollo').removeClass('visually-hidden');
        $('#resp_cumplimiento_kpi').addClass('visually-hidden');
        //-------------- RESP TABLA GAB
        jQuery(data.resp_gap).each(function(i, item){
          genero='M';
          $('#lb_code_evaluado').html(evaldo);
          $('#lb_nombre').html(data.nom_evaluado);
          $('#lb_code_evaluador').html(data.nom_evaldor);
          $('#lb_puesto_evaluador').html(data.puesto_evaldor);

          jQuery(data.evaluado).each(function(i, item){
            $('#lb_nom_puesto_evaluado').html(item.descpue);
            $('#lb_finicio').html(data.finicio);
            $('#lb_nom_depto_evaluado').html(item.nameund);
            genero=item.genero
          });
          showfoto(evaldo,genero);
          
          $('#lb_resultado').html(data.resultado+"%");
          $('#lb_calificacion').html("<div style=color:"+data.color+">"+data.categoria+"</div>");
          $('#lb_f_evaluacion').html(data.feval);
          numero_gap_ci=Number(item.gap_ci).toFixed(1);
          numero_gap_na=Number(item.gap_na).toFixed(1);
          numero_gap_comp=Number(item.gap_comp).toFixed(1);
          numero_gap_conhab=Number(item.gap_conhab).toFixed(1);
          numero_gap=Number(item.gap).toFixed(1);


          $('#tot_gap_coef').html(numero_gap_ci+"%");
          $('#tot_gap_niv').html(numero_gap_na+"%");
          $('#tot_gap_com').html(numero_gap_comp+"%");
          $('#tot_gap_hab').html(numero_gap_conhab+"%");
          $('#tot_gap').html(numero_gap+"%");
        }); 
        
        $("#tbody_resp_eval").html('');
        //-------------- RESP TABLA PID COMPETENCIAS
        $("#tbody_resp_curcomp").html('');contendor  ="";nuevaFila   = "";
        if(data.resp_curcomp.length>0){ $('#div_pid_cursos_com').removeClass('visually-hidden'); $('#div_pid_titulo').removeClass('visually-hidden');}
        jQuery(data.resp_curcomp).each(function(i, item){
          nueva_fecha='';
          if(item.fecha!=null)
          {
            fecha= item.fecha.split('-');
            nueva_fecha='<i class="fas fa-caret-right fa-xs pe-2"></i>'+fecha[2]+'-'+fecha[1]+'-'+fecha[0];
          }
          contendor  = $("#tbody_resp_curcomp").html();
          nuevaFila   = '<tr>'+
          '<td class="ps-4 text-secondary" style=" vertical-align: middle;background-color: #F3F8FF;"><i class="fas fa-caret-right fa-xs pe-2"></i>'+item.comp+' </td>'+
          '<td class="ps-4 text-secondary" style=" vertical-align: middle;background-color: #F3F8FF;"><i class="fas fa-caret-right fa-xs pe-2"></i>'+item.curso+' </td>'+
          '<td class="ps-4 text-secondary" style=" vertical-align: middle;background-color: #F3F8FF;">'+nueva_fecha+'</td></tr>';
          $("#tbody_resp_curcomp").html(contendor+nuevaFila); 
        }); 

        $("#tbody_resp_curhab").html('');contendor  ="";nuevaFila   = "";
        if(data.resp_resp_curhab.length>0){ $('#div_pid_cursos_hab').removeClass('visually-hidden'); $('#div_pid_titulo').removeClass('visually-hidden');}
        jQuery(data.resp_resp_curhab).each(function(i, item){
          nueva_fecha='';
          if(item.fecha!=null)
          {
            fecha= item.fecha.split('-');
            nueva_fecha='<i class="fas fa-caret-right fa-xs pe-2"></i>'+fecha[2]+'-'+fecha[1]+'-'+fecha[0];
          }
                
          contendor  = $("#tbody_resp_curhab").html();
          nuevaFila   = '<tr>'+
          '<td class="ps-4 text-secondary" style=" vertical-align: middle;background-color: #F3F8FF;"><i class="fas fa-caret-right fa-xs pe-2"></i>'+item.curso+' </td>'+
          '<td class="ps-4 text-secondary" style=" vertical-align: middle;background-color: #F3F8FF;">'+nueva_fecha+'</td>'+
          '</tr>';
          $("#tbody_resp_curhab").html(contendor+nuevaFila); 
        }); 

        $("#tbody_resp_curadic").html('');contendor  ="";nuevaFila   = "";
        if(data.resp_curadic.length>0){ $('#div_pid_cursos_adi').removeClass('visually-hidden'); $('#div_pid_titulo').removeClass('visually-hidden');}
        jQuery(data.resp_curadic).each(function(i, item){
          contendor  = $("#tbody_resp_curadic").html();
          nuevaFila   = '<tr>'+
          '<td class="ps-4 text-secondary" style=" vertical-align: middle;background-color: #F3F8FF;"><i class="fas fa-caret-right fa-xs pe-2"></i>'+item.area+' </td>'+
          '<td class="ps-4 text-secondary" style=" vertical-align: middle;background-color: #F3F8FF;"><i class="fas fa-caret-right fa-xs pe-2"></i>'+item.curso+' </td>'+
          '<td class="ps-4 text-secondary" style=" vertical-align: middle;background-color: #F3F8FF;"><i class="fas fa-caret-right fa-xs pe-2"></i>'+item.accion+' </td></tr>';
          $("#tbody_resp_curadic").html(contendor+nuevaFila); 
        }); 


        // DETALLE DE EVALUACIÓN
        $("#tbody_resp_competencias").html('');contendor  ="";nuevaFila   = "";
        var tot_gap_comp=0;
        var tot_pts_comp=0;
        var tot_peso_comp=0; 
        var tot_cumpli_comp=0;

        tot_obtenido_cumpli_pid= 0;tot_gap_cumpli_pid =0;
        if(data.resp_comp.length>0)
        {
          band_competencias=1;

          jQuery(data.resp_comp).each(function(i, item){
                    
            contendor  = $("#tbody_resp_competencias").html();
            tipo=""
            if(item.prf==8){tipo="Crítica";}
            if(item.prf==7){tipo="Muy Importante";}
            if(item.prf==6){tipo="Importante";}
            rango_inf=item.prf;
            rango_sup=item.prf+2;
            tot_pts_comp = tot_pts_comp + Number(item.obtenido);
            tot_peso_comp= tot_peso_comp + Number(item.peso);
            tot_gap_comp= tot_gap_comp + Number(item.gap);
            numero_pts=Number(item.obtenido).toFixed(1);
            numero_peso=Number(item.peso).toFixed(1);
            numero_cumpli=Number((item.obtenido/item.peso)*100).toFixed(1);
            numero_gap=Number(item.gap).toFixed(1);

            extinf_min=0;
            extsup_max=0;                    
            extesperado=(Number(item.prf)*10);
            val_obtenido=(item.opt*10)
            if(val_obtenido<=(Number(item.prf)*10))
            { extinf_min= ((Number(item.prf)*10)-val_obtenido);}
            else
            { extinf_min= 0;}
            if((val_obtenido+extinf_min)>=(Number(item.prf)*10))
            { extesperado=20-((val_obtenido+extinf_min)-(Number(item.prf)*10));}                
            nuevaFila   = '<tr>'+
            '<td colspan="4" style="text-align: left; vertical-align: middle;">'+
            '<h4 class="small font-weight-bold">'+item.comp+' </h4>'+
            '<div class="progress mb-4">'+
            '<div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: '+val_obtenido+'%" aria-valuenow="'+val_obtenido+'" aria-valuemin="0" aria-valuemax="10"><b>'+item.opt+'</b></div>'+
            '<div class="progress-bar text-dark" role="progressbar" style="width: '+extinf_min+'%; background:#E9ECEF;" aria-valuenow="'+extinf_min+'" aria-valuemin="0" aria-valuemax="10"></div>'+                    
            '<div class="progress-bar" role="progressbar" style="width: '+extesperado+'%; background:#ADB8C3;" aria-valuenow="'+extesperado+'" aria-valuemin="0" aria-valuemax="10"></div>'+                        
            '</div></td>'+
            '<td style="text-align: center; vertical-align: middle;">'+tipo+'</td>'+
            '<td style="text-align: center; vertical-align: middle;">'+numero_peso+'</td>'+
            '<td style="text-align: center; vertical-align: middle;">'+numero_pts+'</td>'+
            '<td style="text-align: center; vertical-align: middle;">'+numero_gap+'</td></tr>';
            $("#tbody_resp_competencias").html(contendor+nuevaFila); 
          }); 
          $("#tot_pts_comp").html(tot_peso_comp.toFixed(1));
          $("#tot_cumpli_comp").html(tot_pts_comp.toFixed(1));
          $("#tot_gap_comp").html(tot_gap_comp.toFixed(1));
          $("#tbody_resp_eval").html($("#tbody_resp_eval").html()+
          '<tr><td style="vertical-align: middle;" class="ps-2 text-start">Competencias Organizacionales </td>'+
          '<td style="vertical-align: middle; text-center">'+tot_peso_comp.toFixed(0)+'%'+
          '<td style="vertical-align: middle; text-center">'+tot_pts_comp.toFixed(1)+'%'+
          '</td><td style="vertical-align: middle; text-center">'+tot_gap_comp.toFixed(1)+'%</td></tr>');
         }


         $("#tbody_resp_tar").html('');contendor  ="";nuevaFila1   = "";nuevaFila2   = "";nuevaFila3   = "";
                x=0;
                tot_peso_respon= 0;
                tot_obtenido_respon= 0;
                tot_gap_respon= 0;
                if(data.resp_respon.length>0)
                {
                  band_tareas=1;
                  jQuery(data.resp_respon).each(function(i, item){
                    x++;
                    contendor  =$("#tbody_resp_tar").html();
                    //numero_cumpli=Number((item.obtenido/item.peso)*100).toFixed(1);
                    //numero_gap=Number((item.gap/item.peso)*100).toFixed(1);
                    tot_peso_respon= tot_peso_respon + Number(item.peso);
                    tot_obtenido_respon= tot_obtenido_respon + Number(item.obtenido);
                    tot_gap_respon= tot_gap_respon + Number(item.gap);
                    peso= Number(item.peso).toFixed(1);
                    obtenido= Number(item.obtenido).toFixed(1);
                    gap= Number(item.gap).toFixed(1);
                    nuevaFila1   = '<tr>'+
                    '<td colspan="4" class=" text-center">'+
                        '<div class="accordion accordion-flush" id="accordionFlush'+x+'">'+
                          '<div class="accordion-item">'+
                            '<span class="accordion-header" id="flush-heading'+x+'">'+
                              '<button class="accordion-button collapsed m-0 p-0" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse'+x+'" aria-expanded="false" aria-controls="flush-collapse'+x+'">'+
                                
                                '<table style="width:100%" class="table table-sm small m-0 p-0  table-borderless">'+
                                  '<tr>'+
                                    '<td class="text-left"width="55%">'+item.respon+'</td>'+
                                    '<td class="text-center" width="15%" >'+peso+'</td>'+
                                    '<td class="text-center" width="15%" >'+obtenido+'</td>'+
                                    '<td class="text-center" width="15%" >'+gap+'</td>'+
                                  '</tr>'+
                                '</table>'+

                              '</button>'+
                            '</span>'+
                            '<div id="flush-collapse'+x+'" class="accordion-collapse collapse" aria-labelledby="flush-heading'+x+'" data-bs-parent="#accordionFlush'+x+'">'+
                              '<div class="accordion-body my-0 py-0"><small><div class="row my-2"><div class="col-1"></div><div class="col-10">';
                                nuevaFila2   = '<table style="width:100%" class="table small table-striped">'+'<thead><tr>'+
                                  '<th class="text-secondary text-center table-info"width="60%">TAREAS</th>'+
                                  '<th class="text-secondary text-center table-info" width="10%" >EVALUACIÓN</th>'+
                                  '<th class="text-secondary text-center table-info" width="10%" >VALOR</th>'+
                                  '<th class="text-secondary text-center table-info" width="10%" >PERSONA</th>'+
                                  '<th class="text-secondary text-center table-info" width="10%" >GAP</th>'+
                                '</tr></thead>';
                                jQuery(data.resp_tar).each(function(i, item2){
                                  if(item2.id_respon==item.id_respon)
                                  { peso2=Number(item2.peso).toFixed(1);
                                    obtenido2=Number(item2.obtenido).toFixed(1);
                                    gap2=Number(item2.gap).toFixed(1);
                                    nuevaFila2+=
                                    '<tr>'+
                                      '<td style="text-align: left; vertical-align: middle;">'+item2.tar+'</td>'+
                                      '<td style="text-align: center; vertical-align: middle;" class="text-primary">'+item2.opt+'</td>'+
                                      '<td style="text-align: center; vertical-align: middle;">'+peso2+'</td>'+
                                      '<td style="text-align: center; vertical-align: middle;">'+obtenido2+'</td>'+
                                      '<td style="text-align: center; vertical-align: middle;">'+gap2+'</td>'+
                                    '</tr>';}
                                });
                                nuevaFila2+='</table>';
                              nuevaFila3   = '</div><div class="col-1"></div></div></small></div>'+
                            '</div>'+
                          '</div>'+
                        '</div>'+
                      '</td>'+
                      '</tr>';
                      $("#tbody_resp_tar").html(contendor + nuevaFila1 + nuevaFila2 + nuevaFila3); 
                  });
                  $("#tot_pts_tar").html(Number(tot_peso_respon).toFixed(1));
                  $("#tot_cumpli_tar").html(Number(tot_obtenido_respon).toFixed(1));
                  $("#tot_gap_tar").html(Number(tot_gap_respon).toFixed(1));
                
                  $("#tbody_resp_eval").html($("#tbody_resp_eval").html()+
                  '<tr><td style="vertical-align: middle;" class="ps-2 text-start">Tareas y Funciones </td>'+
                  '<td style="vertical-align: middle; text-center">'+tot_peso_respon.toFixed(0)+'%'+
                  '<td style="vertical-align: middle; text-center">'+tot_obtenido_respon.toFixed(1)+'%'+
                  '</td><td style="vertical-align: middle; text-center">'+tot_gap_respon.toFixed(1)+'%</td></tr>');
                }

                  $("#tbody_resp_hab").html('');contendor  ="";nuevaFila= "";
                  x=0;
                  tot_peso_hab= 0;
                  tot_obtenido_hab= 0;
                  tot_gap_habi= 0;

                  if(data.resp_hab.length>0)
                  {
                    band_habilidades=1; 
                    jQuery(data.resp_hab).each(function(i, item){
                      x++;
                      contendor  =$("#tbody_resp_hab").html();
                      tot_peso_hab= tot_peso_hab + Number(item.peso);
                      tot_obtenido_hab= tot_obtenido_hab + Number(item.obtenido);
                      tot_gap_habi= tot_gap_habi + Number(item.gap);
                      peso= Number(item.peso).toFixed(1);
                      obtenido= Number(item.obtenido).toFixed(1);
                      gap= Number(item.gap).toFixed(1);
                      dato="";
                      if(item.opt==0){dato="No la tiene"}
                      if(item.opt==3){dato="Esta en Desarrollo"}
                      if(item.opt==5){dato="Si la tiene"}
                      nuevaFila   = '<tr>'+
                        '<td style="text-align: left; vertical-align: middle;">'+item.hab+'</td>'+
                        '<td style="text-align: center; vertical-align: middle;" class="text-primary text-small">'+dato+'</td>'+
                        '<td style="text-align: center; vertical-align: middle;">'+peso+'</td>'+
                        '<td style="text-align: center; vertical-align: middle;">'+obtenido+'</td>'+
                        '<td style="text-align: center; vertical-align: middle;">'+gap+'</td>'+
                        '</tr>';
                        $("#tbody_resp_hab").html(contendor + nuevaFila); 
                    });
                    $("#tot_pts_habi").html(Number(tot_peso_hab).toFixed(1));
                    $("#tot_cumpli_habi").html(Number(tot_obtenido_hab).toFixed(1));
                    $("#tot_gap_habi").html(Number(tot_gap_habi).toFixed(1));
                      
                    $("#tbody_resp_eval").html($("#tbody_resp_eval").html()+
                    '<tr><td style="vertical-align: middle;" class="ps-2 text-start">Habilidades y Conocimientos </td>'+
                    '<td style="vertical-align: middle; text-center">'+tot_peso_hab.toFixed(0)+'%'+
                    '<td style="vertical-align: middle; text-center">'+tot_obtenido_hab.toFixed(1)+'%'+
                    '</td><td style="vertical-align: middle; text-center">'+tot_gap_habi.toFixed(1)+'%</td></tr>');
                  }


                  $("#tbody_resp_cumpli_kpi_total").html('');
                  $("#tbody_resp_cumpli_kpi").html('');
                  gap_kpi= 0; 
                  obtenido_kpi= 0;tot_peso_cumpli_pid=0;
                  tot_peso_kpi= 0;
                  if(data.res_kpi.length>0)
                  { 
                    band_kpi=1;
                    $('#resp_cumplimiento_kpi').removeClass('visually-hidden'); 
                    
                    jQuery(data.resp_kpi_cumpli).each(function(i, item){
                      gap=item.peso-item.obtenido;
                      obtenido_kpi= obtenido_kpi + Number(item.obtenido);
                      tot_peso_kpi= tot_peso_kpi + Number(item.peso);
                      gap_kpi= item.peso-item.obtenido;
                      peso= Number(item.peso).toFixed(1);
                      obtenido= Number(item.obtenido).toFixed(1);
                      gap= Number(gap).toFixed(1);
                      $("#tbody_resp_cumpli_kpi_total").html('<tr class="table-primary">'+
                        '<td style="text-align: left; vertical-align: middle;" class=" text-primary fw-bold ps-4">Promedio de cumplimiento de metas</td>'+
                        '<td style="text-align: center; vertical-align: middle;" class="text-primary fw-bold text-center">'+item.cumplimiento_promedio+'</td>'+
                        '<td style="text-align: center; vertical-align: middle;" class="text-primary fw-bold text-center">'+peso+'</td>'+
                        '<td style="text-align: center; vertical-align: middle;" class="text-primary fw-bold text-center">'+obtenido+'</td>'+
                        '<td style="text-align: center; vertical-align: middle;" class="text-primary fw-bold text-center">'+gap+'</td>'+
                        '</tr>');
                    });

                    jQuery(data.res_kpi).each(function(i, item){
                      contendor  =$("#tbody_resp_cumpli_kpi").html();
                    $("#tbody_resp_cumpli_kpi").html(contendor+'<tr>'+
                        '<td style="text-align: left; vertical-align: middle;" class=" text-secondary ps-4">'+item.nom_kpi+'</td>'+
                        '<td style="text-align: center; vertical-align: middle;">'+item.real+'</td>'+
                        '</tr>');
                    });



                    $("#tbody_resp_eval").html($("#tbody_resp_eval").html()+
                    '<tr><td style="vertical-align: middle;" class="ps-2 text-start">Cumplimiento de KPI </td>'+
                    '<td style="vertical-align: middle; text-center">'+tot_peso_kpi.toFixed(0)+'%'+
                    '<td style="vertical-align: middle; text-center">'+obtenido_kpi.toFixed(1)+'%'+
                    '</td><td style="vertical-align: middle; text-center">'+gap_kpi.toFixed(1)+'%</td></tr>');

                  }




                    $("#tbody_resp_cumpli_pid").html('');contendor  ="";nuevaFila= "";
                    if(data.resp_cursos.length>0)
                    {  band_pid=1;
                      $('#resp_cumpli_pid').removeClass('visually-hidden');    
                                         
                      x=0;
                      tot_peso_cumpli_pid= 0;
                      tot_obtenido_cumpli_pid= 0;
                      tot_gap_cumpli_pid= 0;
                      jQuery(data.resp_cursos).each(function(i, item){
                        x++;
                        contendor  =$("#tbody_resp_cumpli_pid").html();
                        tot_peso_cumpli_pid= tot_peso_cumpli_pid + Number(item.peso);
                        tot_obtenido_cumpli_pid= tot_obtenido_cumpli_pid + Number(item.obtenido);
                        tot_gap_cumpli_pid= tot_gap_cumpli_pid + Number(item.gap);
                        peso= Number(item.peso).toFixed(1);
                        obtenido= Number(item.obtenido).toFixed(1);
                        gap= Number(item.gap).toFixed(1);

                        nuevaFila   = '<tr>'+
                          '<td style="text-align: left; vertical-align: middle;">'+item.curso+'</td>'+
                          '<td style="text-align: center; vertical-align: middle;" class=" text-primary">'+item.opt+'</td>'+
                          '<td style="text-align: center; vertical-align: middle;">'+peso+'</td>'+
                          '<td style="text-align: center; vertical-align: middle;">'+obtenido+'</td>'+
                          '<td style="text-align: center; vertical-align: middle;">'+gap+'</td>'+
                          '</tr>';
                          $("#tbody_resp_cumpli_pid").html(contendor + nuevaFila); 
                      });




                      
                      $("#tot_pts_cumpli_pid").html(Number(tot_peso_cumpli_pid).toFixed(1));
                      $("#tot_cumpli_cumpli_pid").html(Number(tot_obtenido_cumpli_pid).toFixed(1));
                      $("#tot_gap_cumpli_pid").html(Number(tot_gap_cumpli_pid).toFixed(1));
                      
                      $("#tbody_resp_eval").html($("#tbody_resp_eval").html()+
                      '<tr><td style="vertical-align: middle;" class="ps-2 text-start">Cumplimiento de PID </td>'+
                      '<td style="vertical-align: middle; text-center">'+tot_peso_cumpli_pid.toFixed(0)+'%'+
                      '<td style="vertical-align: middle; text-center">'+tot_obtenido_cumpli_pid.toFixed(1)+'%'+
                      '</td><td style="vertical-align: middle; text-center">'+tot_gap_cumpli_pid.toFixed(1)+'%</td></tr>');
                    }
                    else{$('#resp_cumpli_pid').addClass('visually-hidden'); }

                     

                    $('#resp_txtlogros').html(data.logros.replace(/\n/g, "<br>"));
                    $('#resp_txtcoment').html(data.comentarios.replace(/\n/g, "<br>"));
                    if(data.carrera==0){  $('#resp_promo').html('Promoverlo de forma inmediata');}
                    if(data.carrera==1){  $('#resp_promo').html('Promoverlo a mediano plazo (1 a 2 años)');}
                    if(data.carrera==2){  $('#resp_promo').html('Promoverlo a largo plazo (3 a 5 años)');}
                    if(data.carrera==3){  $('#resp_promo').html('No se contempla actualmente');}


                    $('#total_valor_eval').html((tot_peso_comp + tot_peso_respon + tot_peso_hab + tot_peso_cumpli_pid + tot_peso_kpi).toFixed(0)+'%');
                    $('#total_cumpli_eval').html((tot_pts_comp + tot_obtenido_respon + tot_obtenido_hab + tot_obtenido_cumpli_pid + obtenido_kpi).toFixed(1)+'%');
                    $('#total_gap_eval').html((tot_gap_comp + tot_gap_respon + tot_gap_habi + tot_gap_cumpli_pid + gap_kpi).toFixed(1)+'%');

                  Highcharts.chart('container-graf', {
                    chart: {
                        type: 'pie',
                        
                        custom: {},
                        events: {
                            render() {
                                const chart = this,
                                    series = chart.series[0];
                                let customLabel = chart.options.chart.custom.label;

                                if (!customLabel) {
                                    customLabel = chart.options.chart.custom.label =
                                        chart.renderer.label(
                                            
                                            '<strong>'+$('#lb_resultado').html()+'</strong><br>'+$('#lb_calificacion').html())
                                            .css({
                                                color: '#000',
                                                textAnchor: 'middle' })
                                            .add();
                                }

                                const x = series.center[0] + chart.plotLeft,
                                    y = series.center[1] + chart.plotTop -
                                    (customLabel.attr('height') / 2);

                                customLabel.attr({
                                    x,
                                    y
                                });
                                // Set font size based on chart diameter
                                customLabel.css({
                                    fontSize: `${series.center[2] / 12}px`
                                });
                            }
                        }
                    },
                    accessibility: {
                        point: {
                            valueSuffix: '%'
                        }
                        
                    },
                    title: false,
                    subtitle: false,
                    navigation: {  buttonOptions: {  enabled: false}},
                    legend: { enabled: false},
                    tooltip: { enabled: false},
                    plotOptions: {
                        series: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            borderRadius: 6,
                            dataLabels: [{
                                enabled: true,
                                distance: 20,
                                format: '{point.name}'
                            }, {
                                enabled: true,
                                distance: -15,
                                format: '{point.percentage:.1f}%',
                                style: {
                                    fontSize: '0.9em'
                                }
                            }],
                            showInLegend: true
                        }
                    },
                    series: [{
                        name: 'Registrations',
                        colorByPoint: true,
                        innerSize: '75%',

                        data: (function() {
                          // Crear un arreglo vacío para los datos de la serie
                          let seriesData = [];

                          // Agregar los datos solo si son mayores a 0 
                          if (band_competencias > 0) {
                              seriesData.push({
                                  name: 'Competencias',
                                  y: tot_pts_comp
                              });
                          }
                          if (band_tareas > 0) {
                              seriesData.push({
                                  name: 'Tareas y Funciones',
                                  y: tot_obtenido_respon
                              });
                          }
                          if (band_habilidades > 0) {
                              seriesData.push({
                                  name: 'Habilidades',
                                  y: tot_obtenido_hab
                              });
                          }
                          if (band_kpi > 0) {
                              seriesData.push({
                                  name: 'Cumplimiento KPI',
                                  y: obtenido_kpi
                              });
                          }
                          if (band_pid > 0) {
                              seriesData.push({
                                  name: 'Cumplimiento PID',
                                  y: tot_obtenido_cumpli_pid
                              });
                          }
                          if ((tot_gap_respon + tot_gap_comp + tot_gap_habi + tot_gap_cumpli_pid + gap_kpi) > 0) {
                              seriesData.push({
                                  name: 'GAP',
                                  y: (tot_gap_respon + tot_gap_comp + tot_gap_habi + tot_gap_cumpli_pid + gap_kpi),
                                  color: '#E6E6E6'
                              });
                          }

                          // Retornar el arreglo con los datos de la serie
                          return seriesData;
                      })()

                    }]
                  });
      }
    });
  }
  
  function showfoto(id_evdo,gen)
    {
      var _token = $('input[name="_token"]').val();
      var parametros = {
        "id_evdo":id_evdo,
        "_token": _token};
        $.ajax({
          data:  parametros, 
          url:   "{{ route('evaluacion.showfoto') }}",
          type:  'POST', 
          cache: false,          
          success:  function (item) { 
            if(item.length>=20)
            {  $('#space_photo').html(item);}              
            else
            { if(gen=='F'){      
              $('#space_photo').html('<img src="/FOCUSTalent/public/storage/profiles/photo/ella.png" alt="Profile" class="rounded-circle" id="img_photo">');       }   
             // document.getElementById('img_photo').setAttribute("src", "/FOCUSTalent/public/storage/profiles/photo/ella.png");}}
              else { $('#space_photo').html('<img src="/FOCUSTalent/public/storage/profiles/photo/el.png" alt="Profile" class="rounded-circle" id="img_photo">');  }
          }}
        });
    }

  function mod_avances(id_eval)
  { $('#div_avances').removeClass('visually-hidden');    
    $('#tbl_avances').html('');
    
    $('#lista_eval').addClass('visually-hidden');
    
    var _token = $('input[name="_token"]').val();
      var parametros = {
        "id_eval":id_eval,
        "_token": _token};
        $.ajax({
          data:  parametros, 
          url:   "{{ route('evaluacion.avances') }}",
          type:  'POST', 
          dataType: "json",
          cache: true,       
          
          beforeSend: function () {
            $('#tbl_avances').html('<div class="text-center"><div class="spinner-border text-primary mt-4" role="status"><span class="visually-hidden">Loading...</span></div></div>');
          },
          success:  function (data) { 
            grupo="";
            $('#tbl_avances').html('');
            contenido='';
            jQuery(data.det_grupos).each(function(i, item){
              if (grupo=="")
              { grupo=item.undsup;
                contenido+=
                    '<table class="mt-4 compact table table-sm table-striped table-hover" style="width:100%">'+
                  '<thead>'+
                    '<tr>'+
                      '<th class="text-center text-info" width="40%" >'+grupo+'</th>'+
                        '<th class="text-center text-secondary" width="10%" >TOTAL</th>'+
                        '<th class="text-center" width="10%" ><span class="badge bg-secondary">Pendientes</span></th>'+
                        '<th class="text-center" width="10%" ><span class="badge bg-warning">En Proceso</span></th>'+
                        '<th class="text-center" width="10%" ><span class="badge bg-primary">Evaluados</span></th>'+
                        '<th class="text-center" width="10%" ><span class="badge bg-danger">Rechazados</span></th>'+
                        '<th class="text-center" width="10%" ><span class="badge bg-success">Avances</span></th>'+
                    '</tr>'+
                  '</thead><tbody>';
              }
              else
              { if (grupo!=item.undsup)
                { grupo=item.undsup;
                  contenido+=
                    
                    '<table class="mt-4 compact table table-sm table-striped table-hover" style="width:100%">'+
                    '<thead>'+
                      '<tr>'+
                        '<th class="text-center text-info" width="40%" >'+grupo+'</th>'+
                        '<th class="text-center text-secondary" width="10%" >TOTAL</th>'+
                        '<th class="text-center" width="10%" ><span class="badge bg-secondary">Pendientes</span></th>'+
                        '<th class="text-center" width="10%" ><span class="badge bg-warning">En Proceso</span></th>'+
                        '<th class="text-center" width="10%" ><span class="badge bg-primary">Evaluados</span></th>'+
                        '<th class="text-center" width="10%" ><span class="badge bg-danger">Rechazados</span></th>'+
                        '<th class="text-center" width="10%" ><span class="badge bg-success">Avances</span></th>'+
                      '</tr>'+
                    '</thead><tbody>';
                }
              }
              if(grupo!=""){ 
                contenido+=
                '<tr><td class="small">'+item.und+'</td>'+
                '<td class="text-center">'+item.total+'</td>'+
                '<td class="text-center">'+item.pendiente+'</td>'+
                '<td class="text-center">'+item.en_proceso+'</td>'+
                '<td class="text-center">'+item.evaluado+'</td>'+
                '<td class="text-center">'+item.rechazado+'</td>'+
                '<td class="text-center">'+item.cumplimiento+'%</td>'+
                '</tr>';}
              
            });
            if(grupo!=""){ $("#tbl_avances").html($("#tbl_avances").html()+contenido+'</tbody></table>');}

          // Create the chart


                          

            tot_pendiente = 0;
            tot_proceso = 0;
            tot_evaluado = 0;
            tot_rechazado = 0;

            let v_pendiente = [];
            let v_en_proceso = [];
            let v_evaluados = [];
            let v_finalizados = [];
            let cat = [];  // Agregamos la declaración de 'cat'

            jQuery(data.grp_consolidado).each(function (i, item) {
              cat.push('<span style="color:blue"><strong>'+Number((Number(item.evaluado)+Number(item.rechazado))/(Number(item.pendiente)+Number(item.en_proceso)+Number(item.evaluado)+Number(item.rechazado))*100).toFixed(0)+'%</strong></span><br><small>'+item.undsup+'</small>');                // Agregar valor de 'undsup' a 'cat'
              v_pendiente.push(Number(item.pendiente));   
              v_en_proceso.push(Number(item.en_proceso)); 
              v_evaluados.push(Number(item.evaluado));    
              v_finalizados.push(Number(item.rechazado)); 
              tot_pendiente= tot_pendiente + Number(item.pendiente);
              tot_proceso= tot_proceso + Number(item.en_proceso);
              tot_evaluado= tot_evaluado + Number(item.evaluado);
              tot_rechazado= tot_rechazado + Number(item.rechazado);
            });

            Highcharts.chart('container', {
              chart: {
                type: 'column'
              },
              title: {
                text: ' ',
                align: 'left'
              },
              xAxis: {
                categories: cat,  // Ahora 'cat' está correctamente definida
              },
              yAxis: {
                min: 0,
                title: {
                  text: null
                },
                stackLabels: {
                  enabled: true
                }
              },
              legend: {
                align: 'center',
                verticalAlign: 'top',
                backgroundColor:
                  Highcharts.defaultOptions.legend.backgroundColor || 'white',
                borderColor: '#CCC',
                borderWidth: 0,
                shadow: false
              },
              tooltip: {
                headerFormat: '<b>{category}</b><br/>',
                pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
              },
              plotOptions: {
                column: {
                  stacking: 'normal',
                  dataLabels: {
                    enabled: true
                  }
                }
              },
              series: [{
                name: 'Pendientes',
                data: v_pendiente,
                color: '#64A6E3'
              }, {
                name: 'En Proceso',
                data: v_en_proceso,
                color: '#3E8FD8'
              }, {
                name: 'Evaluados',
                data: v_evaluados,
                color: '#0960AE'
              }, {
                name: 'Rechazadas',
                data: v_finalizados,
                color: '#B8D1E7'
              }]
            });



            Highcharts.chart('container-pie', {
            chart: {
                type: 'pie',
                custom: {},
                events: {
                    render() {
                        const chart = this,
                            series = chart.series[0];
                        let customLabel = chart.options.chart.custom.label;

                        if (!customLabel) {
                            customLabel = chart.options.chart.custom.label =
                            chart.renderer.label(
                                'HeadCount<br/>' +
                                '<strong>' + (new Intl.NumberFormat('es-PA').format(Number(tot_pendiente + tot_proceso + tot_evaluado + tot_rechazado))) + '</strong>'
                            )
                                    .css({
                                        color: '#000',
                                        textAnchor: 'middle'
                                    })
                                    .add();
                        }

                        const x = series.center[0] + chart.plotLeft,
                            y = series.center[1] + chart.plotTop -
                            (customLabel.attr('height') / 2);

                        customLabel.attr({
                            x,
                            y
                        });
                        // Set font size based on chart diameter
                        customLabel.css({
                            fontSize: `${series.center[2] / 12}px`
                        });
                    }
                }
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            title: {
                text: null
            },

            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.0f}%</b>'
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    borderRadius: 8,
                    dataLabels: [{
                        enabled: true,
                        distance: 10,
                        format: '{point.name}'
                    }, {
                        enabled: true,
                        distance: -10,
                        format: '{point.y:.0f}',
                        style: {
                            fontSize: '0.7em'
                        }
                    }],
                    showInLegend: false
                }
            },
 
            series: [{
                name: 'Registrations',
                colorByPoint: true,
                innerSize: '80%',
                data: [{
                    name: 'Pendientes',
                    y: tot_pendiente,
                    color: '#64A6E3'
                }, {
                    name: 'En Proceso',
                    y: tot_proceso,
                    color: '#3E8FD8'
                }, {
                    name: 'Evaluados',
                    y: tot_evaluado,
                    color: '#0960AE'
                }, {
                    name: 'Rechazados',
                    y: tot_rechazado,
                    color: '#B8D1E7'
                }]
            }]
        });



          }          
        });
  }
</script>

