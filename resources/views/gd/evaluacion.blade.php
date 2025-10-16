<!DOCTYPE html>
@extends('layouts.plantilla')

@section('title','Evaluación de Desempeño')
<script src="{{ asset('assets/js/code/highcharts.js')}}"></script>
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
    div#iframe { display: none; }
    div#preload { cursor: wait; }
  </style> 

<style>
  .highcharts-figure,
  .highcharts-data-table table {
      min-width: 320px;
      max-width: 660px;
      margin: 1em auto;
  }

  .highcharts-data-table table {
      font-family: Verdana, sans-serif;
      border-collapse: collapse;
      border: 1px solid #ebebeb;
      margin: 10px auto;
      text-align: center;
      width: 100%;
      max-width: 500px;
  }

  .highcharts-data-table caption {
      padding: 1em 0;
      font-size: 1.2em;
      color: #555;
  }

  .highcharts-data-table th {
      font-weight: 600;
      padding: 0.5em;
  }

  .highcharts-data-table td,
  .highcharts-data-table th,
  .highcharts-data-table caption {
      padding: 0.5em;
  }

  .highcharts-data-table thead tr,
  .highcharts-data-table tr:nth-child(even) {
      background: #f8f8f8;
  }

  .highcharts-data-table tr:hover {
      background: #f1f7ff;
  }

  .highcharts-description {
      margin: 0.3rem 10px;
  }

</style>

<!-- GAP GLOBAL -->
<div class="visually-hidden" id="resp_gap"> 
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
<!-- GAP GLOBAL HASTA AQUI -->
  <div class="card mb-3">
    <div class="card-header pb-0">
      <h4><i class="fas fa-tasks"></i> Evaluación de Desempeño</h4>
    </div>
    <div class="card-body">
      <small>
        <div id="preload" class="align-items-center justify-content-center text-center p-4 mt-4"><div class=" mt-4 spinner-border text-primary" role="status"></div></div>
      </small>        
          <div id="iframe" style="display: none;">

            <!-- TABLA PRINCIPAL -->
            <div id="div_tabla"  style="display: block"> 
              @csrf
              @if ($eval_id==0)
                <div class="alert alert-warning d-flex align-items-center mt-4" role="alert">
                  <i class="fas fa-exclamation-triangle fa-lg pe-2"></i> No hay evaluaciones habilitadas en este momento.
                </div>
              @else          
                <div class="row mb-2 mt-4 small">
                  <div class="col-auto label fw-bold text-secondary">Periodo de evaluación:</div>
                  <div class="col-lg-9 col-md-8 text-secondary"> <span class="text-uppercase">{{ $eval_desde }}</span>  al  <span class="text-uppercase">{{ $eval_hasta }}</span></div>
                </div>
                  
                <div class="row mb-2 small">
                  <div class="col-auto label fw-bold text-secondary">Evaluador:</div>
                  <div class="col-lg-9 col-md-8 text-secondary text-uppercase"> {{ $nom_evaluador }}                    
                    <input type="hidden" id="eval_id" value="{{ $eval_id }}">
                    <input type="hidden" id="cod_evaluador" value="{{ $codigo_evaluador }}"></div>
                </div>

                
                  
                <div class="row mb-4 small">
                  <div class="col-auto label fw-bold text-secondary">Puesto:</div>
                  <div class="col-lg-9 col-md-8 text-secondary text-uppercase"> {{ $nom_pue_evaluador }}</div>
                </div>

                <table id="MyTable" class="table table-striped table-hover table-sm" style="width:100%">
                  <thead class="bg-info">
                    <tr>
                      <th class="text-light text-center" >CODIGO</th>
                      <th class="text-light text-center" >NOMBRE</th>
                      <th class="text-light text-center" >PUESTO</th>
                      <th class="text-light text-center" >DEPARTAMENTO</th>
                      <th class="text-light text-center" >RESULTADO</th>
                      <th class="text-light text-center" width='10%'><i class="fas fa-cog"></i></th>
                    </tr>
                  </thead>
                  <tbody class="text-dark" id="bodyMyTable_empleados">
                    @foreach($evaluados as $evaluado )
                    @php
                    $link_evaluar=''; $resultado='';
                      if($evaluado->status==3)
                      { $resultado=round(($evaluado->resultado),1).'%';
                        $link_evaluar='<span class="text-primary fw-bold"><i class="fas fa-search fa-lg pe-2"></i>Evaluado</span>';
                      }
                      else
                      { if($evaluado->status<=1)
                        { $resultado='';
                          $link_evaluar='<span class="text-secondary fw-bold"><i class="far fa-edit fa-lg pe-2"></i>Evaluar</span>';
                        }
                        else {
                          {
                            if($evaluado->status==2)
                            { $resultado='';
                              $link_evaluar='<span class=" fw-bold" style="color:#ff7700"><i class="far fa-edit fa-lg pe-2"></i>Continuar</span>';
                            }
                            else {
                              if($evaluado->status==4)
                              { $resultado='';
                                $link_evaluar='<span class="text-danger  fw-bold"><i class="fas fa-exclamation-triangle fa-lg pe-2"></i>No Evaluado</span>';
                              }
                            }
                          }
                        }
                      }
                    @endphp
                      <tr>
                        <td class=" text-center">{{$evaluado->id_evaluado}}</td>
                        <td class="text-uppercase">{{$evaluado->prinombre}} {{$evaluado->priapellido}}</td>
                        <td class="text-uppercase">{{$evaluado->descpue}}</td>
                        <td class="text-uppercase">{{$evaluado->nameund}}</td>
                        <td class="text-uppercase fw-bold text-center"><span id="div_res_{{$evaluado->id_evaluado}}">{{$resultado}}</span></td>
                        <td>
                          <div class="row d-flex align-items-center justify-content-center text-center" id="link_eval_{{$evaluado->id_evaluado}}">
                            <div class="edit"  onclick="eval({{$evaluado->id_evaluado}},{{ $evaluado->status }})">
                              @php echo $link_evaluar; @endphp
                            </div>
                          </div>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              @endif
            </div>
        
            <!-- FORMULARIO DE EVALUACIÓN --> 
            <div id="div_formulario" class="small" style="display: none">

                  <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-2">
                    <a href="#" class="btn btn-sm btn-danger me-4" id="bto_no_evalua" data-bs-toggle="modal" data-bs-target="#modal_no_evaluado" onclick="noevaluador()"><i class="fa-solid fa-ban pe-2 fa-lg"></i>No será evaluado</a>           
                    <a href="#" class="btn btn-sm btn-secondary" onclick="back()"><i class="fas fa-arrow-left pe-2 fa-lg"></i>Volver</a>
                    <a href="#" class="btn btn-sm btn-success visually-hidden" id="bto_print" onclick="print()"><i class="fas fa-file-pdf pe-2 fa-lg"></i>Imprimir</a>
                    <a href="#" class="btn btn-sm btn-warning" id="bto_continuar" onclick="save(2)"><i class="fas fa-save pe-2 fa-lg"></i>Guardar y continuar luego</a>
                    <a href="#" class="btn btn-sm btn-primary" id="bto_guarda" onclick="save(3)"><i class="fas fa-save pe-2 fa-lg"></i>Guardar y finalizar</a>
                  </div>

              <div class="alert alert-danger d-flex align-items-center mt-4 visually-hidden" role="alert" id="alert_noasignado">
                <i class="fas fa-exclamation-circle fa-lg pe-2"></i> El colaborador no esta asignado para ser evaluado por usted.
              </div>
              <div class="row mb-0">
                <section class="section profile">
                  <div class="row">
                    <div class="col-3">
                      <div class="card-body profile-card d-flex flex-column align-items-center mb-0">
                        <span class="align-items-center justify-content-center text-center" id="space_photo"><img src="/FOCUSTalent/public/storage/profiles/photo/el.png" alt="Profile" class="rounded-circle" id="img_photo"></span>
                        <h6 id="lb_nombre" class="text-primary fw-bold pt-2"></h6>
                      </div>
                    </div>
                    <div class="col-xl-8">
                      <div class="pt-4">
                        <div class="card-body  profile-card">
                          <div class="row mb-2 visually-hidden" id="div_f_evaluacion">
                            <div class="col-auto label fw-bold text-secondary">F. Evaluación:</div>
                            <div id="lb_f_evaluacion" class="col-lg-9 col-md-8 text-secondary text-uppercase"> </div>
                          </div>
                          <div class="row mb-2">
                            <div class="col-auto label fw-bold text-secondary">Código:</div>
                            <div id="lb_code_evaluado" class="col-lg-9 col-md-8 text-secondary text-uppercase"> </div>
                          </div>
                            
                          <div class="row mb-2">
                            <div class="col-auto label fw-bold text-secondary">Puesto:</div>
                            <div id="lb_nom_puesto_evaluado" class="col-lg-9 col-md-8 text-secondary text-uppercase"></div>
                          </div>   
        
                          <div class="row mb-2">
                            <div class="col-auto label fw-bold text-secondary">Departamento:</div>
                            <div id="lb_nom_depto_evaluado" class="col-lg-9 col-md-8 text-secondary text-uppercase"></div>
                          </div>

                          <div class="row mb-2 visually-hidden">
                            <div class="col-auto label fw-bold text-secondary">Fecha de Ingreso:</div>
                            <div id="lb_finicio" class="col-lg-9 col-md-8 text-secondary text-uppercase"> </div>
                          </div>

                          <div class="row mb-2 visually-hidden" id="div_resultado">
                            <div class="col-auto label fw-bold text-secondary">Resultado:</div>
                            <div id="lb_resultado" class="col-lg-9 col-md-8 text-primary text-uppercase fw-bold"> </div>
                            <input type="hidden" id="estatus" value="">
                          </div>

                          <div class="row mb-2 visually-hidden" id="div_calificacion">
                            <div class="col-auto label fw-bold text-secondary">Categoría:</div>
                            <div id="lb_calificacion" class="col-lg-9 col-md-8 text-primary fw-bold"> </div>
                          </div>
                          <div id="lb_comet__noevaluado" class="col-lg-9 col-md-8 visually-hidden text-secondary"> </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="row  d-flex justify-content-center visually-hidden" id="alert_cursos">
                    <div class=" col-10 alert alert-warning alert-dismissible fade show" role="alert">
                      <strong>Nota:</strong> La persona evaluada está en proceso de finalizar los cursos asignados en UBITS. <br>Puede continuar la evaluación sin ningún problema. Una vez que la persona termine los cursos, podrá finalizar el proceso y obtener el resultado total.
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
  </div>
  
  <form action="">
    @csrf
    <input type="hidden" id="id_escala" value="0">

      <!-- RESPUESTAS COMPETENCIAS -->
      <div class="card shadow mb-3 visually-hidden" id="resp_comp"> 
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
      
      <!-- FORMULARIO DE COMPETENCIAS -->
      <div class="accordion shadow mb-3" id="div_competencias" style="display: none">
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              <i class="fas fa-list-ol pe-2"></i> COMPETENCIAS ORGANIZACIONALES
            </button>
          </h2>
          <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="accordion-body">       
              <div class="row align-items-center justify-content-center">
                <div class="col-9 alert alert-info  text-justify small" role="alert">              
                      <i class="fas fa-info-circle fa-lg text-primary"></i> Por favor, evalúa cada una de las competencias organizacionales en una escala del <b>1</b> al <b>10</b>. La columna de la derecha, <b>NIVEL ESPERADO</b>, indica el perfil óptimo necesario para lograr un desempeño eficaz en el puesto de trabajo.              </div>
                </div>
              <table id="table_competencias" class="table table-hover table-sm small" style="width:100%">
                <thead>
                  <tr>
                    <th class="text-info text-center">COMPETENCIAS</th>
                    <th class="text-info text-center" width="23%" >EVALUAR</th>
                    <th class="text-info text-center" width="8%" >NIVEL ESPERADO</th>
                  </tr>
                </thead>
                <tbody class="text-dark" id="tbody_competencias">            
                </tbody>
              </table>
              <input type="hidden" id="countcomp" value="0">
            </div>
          </div>
        </div>
      </div>

      <!-- FORMULARIO DE TAREAS Y FUNCIONES -->
      <div class="accordion shadow mb-3" id="div_respon" style="display: none">
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingtareas">
            <button class="accordion-button fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetareas" aria-expanded="true" aria-controls="collapsetareas">
              <i class="fas fa-user-check pe-2"></i> TAREAS Y FUNCIONES
            </button>
          </h2>
          <div id="collapsetareas" class="accordion-collapse collapse show" aria-labelledby="headingtareas" data-bs-parent="#accordionExample">
            <div class="accordion-body">  
              <div class="row mb-2 align-items-center justify-content-center">  
                  <div class="col-9 alert alert-info small mb-0" role="alert">                
                      <i class="fas fa-info-circle fa-lg text-primary"></i> A continuación, debe evaluar las tareas correspondientes a cada área de responsabilidad. Por favor, califica cada tarea en una escala del <b>1</b> al <b>5</b>, de acuerdo con las siguientes definiciones:
                      <ol>
                        <li> <u>Muy Deficiente:</u> No realiza la tarea o la lleva a cabo de manera insatisfactoria.</li>
                        <li> <u>Regular:</u> Realiza la tarea con calidad aceptable, pero con entregas tardías.</li>
                        <li> <u>Buena:</u> Cumple con la tarea dentro del plazo establecido, aunque ocasionalmente presenta</li>
                        <li> <u>Muy Buena:</u> Realiza la tarea de manera efectiva y siempre cumple con los plazos requeridos.</li>
                        <li> <u>Excelente:</u> Supera las expectativas en cuanto a calidad y entrega, realizando la tarea de manera sobresaliente.</li>
                      </ol>
                  </div>
              </div>     
              <table id="table_respon" class="table table-sm show small table-hover" style="width:100%">
                <thead>
                  <tr>
                    <th class="text-info text-center" width="20%">ÁREA DE RESPONSABILDIAD</th>
                    <th class="text-info text-center" width="66%" >TAREAS</th>
                    <th class="text-info text-center"  width="14%">EVALUAR</th>
                  </tr>
                </thead>
                <tbody class="text-dark" id="tbody_respon">            
                </tbody>
              </table>
              <input type="hidden" id="counttar" value="0">
            </div>
          </div>
        </div>
      </div>

        <!-- FORMULARIO DE HABILIDADES -->
      <div class="accordion shadow mb-3" id="div_habilidades" style="display: none">
        <div class="accordion-item">
          <h2 class="accordion-header" id="headinghabilidades">
            <button class="accordion-button fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapsehabilidades" aria-expanded="true" aria-controls="collapsehabilidades">
              <i class="fas fa-street-view pe-2"></i> HABILIDADES Y CONOCIMIENTOS
            </button>
          </h2>
          <div id="collapsehabilidades" class="accordion-collapse collapse show" aria-labelledby="headinghabilidades" data-bs-parent="#accordionExample">
            <div class="accordion-body">       

              <div class="row mb-3 pb-0 align-items-center justify-content-center">  
                <div class="col-9 alert alert-info small" role="alert">                     
                    <i class="fas fa-info-circle fa-lg text-primary"></i> A continuación, se presenta un listado de habilidades y conocimientos que debe tener el colaborador para un buen desempeño en el puesto de trabajo. Por favor, evalúa en cada habilidad según las siguientes opciones:
                    <ul>
                      <li> <b>No la Tiene:</b> Si el colaborador no posee esta habilidad.</li>
                      <li> <b>Esta en Desarrollo:</b> Si el colaborador está trabajando en mejorar esta habilidad, pero aún no la domina.</li>
                      <li> <b>Si la Tiene:</b> Si el colaborador tiene esta habilidad y la aplica de manera efectiva en su puesto de trabajo.</li>
                    </ul>
                </div>
              </div>          
              <div class="row d-flex align-items-center justify-content-center text-center text-secondary">
              <table id="table_habilidades" class="table table-sm small table-hover" style="width:90%">
                <thead>
                  <tr>
                    <th class="text-info text-center" width="50%">HABILIDADES</th>
                    <th class="text-info text-center" width="50%" >EVALUAR</th>
                  </tr>
                </thead>
                <tbody class="text-dark" id="tbody_habilidad">            
                </tbody>
              </table>
              <input type="hidden" id="counthab" value="0">
              </div>
        
            </div>
          </div>
        </div>
      </div>

      <!--- CUMPLIMIENTO KPI -->
      <div class="accordion shadow mb-3" id="div_cumplimiento_kpi" style="display: none">
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingcumplimientokpi">
            <button class="accordion-button fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapsecumplimientokpi" aria-expanded="true" aria-controls="collapsecumplimientokpi">
              <i class="fa-solid fa-chart-line pe-2"></i> CUMPLIMIENTO DE METAS
            </button>
          </h2>
          <div id="collapsecumplimientokpi" class="accordion-collapse collapse show" aria-labelledby="headingcumplimientokpi" data-bs-parent="#accordionExample">
            <div class="accordion-body">           
              <div class="col small  d-flex justify-content-center">
                <table id="table_cumplimiento_metas" class="table table-sm" style="width:60%">
                  <thead>
                    <tr>
                      <th class="text-info text-center" width="80%">INDICADOR</th>
                      <th class="text-info text-center" width="20%" >% RESULTADO</th>
                    </tr>
                  </thead>
                  <tbody class="text-secondary" id="tbody_cumplimiento_kpi">
                  </tbody>
                  <thead>
                    <tr>
                      <th class="text-info text-center" >Promedio de cumplimiento de metas</th>
                      <th class="text-info text-center" ><span id="promedio_kpi_cumpli"></span></th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!--- CUMPLIMIENTO PID -->
      <div class="accordion shadow mb-3" id="div_cumplimiento_pid" style="display: none">
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingcumplimientopid">
            <button class="accordion-button fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapsecumplimientopid" aria-expanded="true" aria-controls="collapsecumplimientopid">
              <i class="fas fa-user-graduate pe-2"></i> CUMPLIMIENTO DE PLAN INDIVIDUAL DE DESARROLLO
            </button>
          </h2>
          <div id="collapsecumplimientopid" class="accordion-collapse collapse show" aria-labelledby="headingcumplimientopid" data-bs-parent="#accordionExample">
            <div class="accordion-body"> 
              <div class="col small  d-flex justify-content-center">

                <table id="table_cumplimiento_pid" class="table table-sm" style="width:60%">
                  <thead>
                    <tr>
                      <th class="text-info text-center" width="80%">NOMBRE DE CURSOS ASIGNADOS ANTERIORMENTE</th>
                      <th class="text-info text-center" width="20%" >RESULTADO</th>
                    </tr>
                  </thead>
                  <tbody class="text-secondary" id="tbody_cumplimiento_pid">
                  </tbody>
                </table>
                <input type="hidden" id="countcursos" value="0">
              </div>
            </div>
          </div>
        </div>
      </div>

      <!--- NUEVO PID -->
      <div class="accordion shadow mb-3" id="div_pid" style="display: none">
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingpid">
            <button class="accordion-button fw-bold text-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapsepid" aria-expanded="true" aria-controls="collapsepid">
              <i class="fas fa-chalkboard-teacher pe-2"></i> NUEVO PLAN INDIVIDUAL DE DESARROLLO
            </button>
          </h2>
          <div id="collapsepid" class="accordion-collapse collapse show" aria-labelledby="headingpid" data-bs-parent="#accordionExample">
            <div class="accordion-body">           
                  <div class="row" id="instrucc_compe">
                      <div class="row mb-2 pb-0 align-items-center justify-content-center">  
                        <div class="col-10 alert alert-info info small" role="alert">                     
                            <i class="fas fa-info-circle fa-lg text-primary"></i>
                            Con base en la evaluación en curso, se ha identificado GAP en competencias con alto nivel de criticidad según el perfil del puesto. 
                            Por favor seleccionar un curso del listado disponible en cada una de las competencias.
                        </div>
                      </div>
                  </div>
                  <div class="col small">
                    <table id="table_desarrollo" class="table table-hover table-sm" style="width:100%">
                      <thead>
                        <tr>
                          <th class="text-primary text-center" width="30%">COMPETENCIAS DE MAYOR GAP<input type="hidden" id="cant_curso_asig_comp" value="0"></th>
                          <th class="text-primary text-center" width="50%" >CURSO RELACIONADO</th>
                          <th class="text-primary text-center" width="10%" >FECHA</th>
                        </tr>
                      </thead>
                      <tbody class="text-dark" id="tbody_pid_comp">
                      <tr>
                        <td colspan="2" class="text-center text-secondary">No mantiene GAP en las competencias organizacionales</td>
                        </td>
                      </tr>
                      </tbody>
                    </table>
                  </div>
            

              <div class="row" id="instrucc_hab">
                <div class="row mb-2 pb-0 align-items-center justify-content-center">  
                  <div class="col-8 alert alert-info info small" role="alert">                     
                      <i class="fas fa-info-circle fa-lg text-primary"></i>
                      Seleccionar al menos <span id="cant_curso_hab">3</span> cursos de habilidades funcionales según las tareas requeridas en el puesto.
                  </div>
                </div>
              </div>
              <div class="col small">
                <table id="table_habilidadespid" class="table table-hover table-sm" style="width:100%">
                  <thead>
                    <tr>
                      <th class="text-primary text-center" >ASIGNACIÓN DE CURSOS PARA HABILIDADES FUNCIONALES<input type="hidden" id="cant_curso_asig_hab" value="0"></th>
                      <th class="text-primary text-center" width="10%" >FECHA</th>
                      <th width="5%"></th>
                    </tr>
                    
                  </thead>
                  <tbody class="text-dark" id="tbody_pid_hab">
                    <tr><td  colspan="3" class="text-center"><span class="editlink_naranja fw-bold small"  onclick="selcoursehab()"><i class="far fa-edit fa-lg"></i> Seleccionar cursos</span></td></tr>
                  </tbody>
                </table>
              </div>
              
            
              
              <div class="row" id="instrucc_hab_adicional">
                <div class="row mb-2 pb-0 align-items-center justify-content-center">  
                  <div class="col-8 alert alert-info info small" role="alert">                     
                      <i class="fas fa-info-circle fa-lg text-primary"></i>
                      Opcional. Si desea añadir un curso relacionado con habilidades funcionales que no esté mencionado en la sección anterior, le invitamos a hacerlo en el espacio que se encuentra a continuación.
                  </div>
                </div>
              </div>

              
              <div class="col small">
                <div class="row small">
                  <div class="col small">
                    <input class="form-control form-control-sm" type="text" placeholder="Área de desarrollo" aria-label=".form-control-sm" id="txt_area_desa">
                  </div>
                  <div class="col small">
                    <input class="form-control form-control-sm" type="text" placeholder="Nombre de curso" aria-label=".form-control-sm" id="txt_area_desa_curso">
                  </div>
                  <div class="col small">
                    <input class="form-control form-control-sm" type="text" placeholder="Otras Acciones específicas" aria-label=".form-control-sm" id="txt_area_desa_acciones">
                  </div>
                  <div class="col-auto small">
                    <button type="button" class="btn btn-sm btn-outline-info" onclick="add_otro()"> <i class="far fa-plus-square fa-lg me-2"></i>Agregar</button>
                  </div>
                </div>
                <table id="table_habilidadespid_adicional" class="table table-hover table-sm table-striped mt-4" style="width:100%">
                  <thead>
                    <tr>
                      <td class="text-primary text-center" >ÁREA DE DESARROLLO</td><td class="text-primary text-center" >CURSO RELACIONADO</td><td colspan="2" class="text-primary text-center" >OTRAS ACCIONES ESPECÍFICAS</td>
                    </tr>
                    
                  </thead>
                  <tbody class="text-dark" id="tbody_pid_hab_adicional">
                  </tbody>
                </table>
              </div>

            </div>
          </div>
        </div>
      </div>

      <!-- FORMULARIO DE DESARROLLO class="card-title py-2" style="color: #778DB2"-->
      <div class="card shadow mb-3" id="div_desarrollo" style="display: none">

        <div class="card-body my-3">
          <div class="my-3 pt-3">
            <label for="txtlogros" class="form-label card-title py-0 text-primary"><i class="fas fa-user-tag pe-2"></i> LOGROS DEL COLABORADOR</label>
            <textarea class="form-control  form-control-sm" id="txtlogros" rows="3"></textarea>
          </div>


          <hr>
          <div class="my-3">
              <label class="form-label card-title py-0 text-primary"><i class="fas fa-user-tie pe-2"></i> PROYECCIÓN DE DESARROLLO DE CARRERA</label>
              <div class="col ps-4 small">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="promo" id="promo1">
                  <label class="form-check-label" for="promo1"> Promoverlo de forma inmediata </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="promo" id="promo2">
                  <label class="form-check-label" for="promo2"> Promoverlo a mediano plazo (1 a 2 años) </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="promo" id="promo3" checked>
                  <label class="form-check-label" for="promo3"> Promoverlo a largo plazo (3 a 5 años) </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="promo" id="promo4" checked>
                  <label class="form-check-label" for="promo4"> No se contempla actualmente </label>
                </div>
              </div>
          </div>

          <hr>      
          
          <div class="my-3">
            <label for="txtcoment" class="form-label card-title py-0 text-primary"><i class="fas fa-comment-dots pe-2"></i> COMENTARIOS DEL EVALUADOR</label>
            <textarea class="form-control  form-control-sm" id="txtcoment" rows="3"></textarea>
          </div>

        </div>
      </div>


      <div class="modal fade" id="solcursoModal" tabindex="-1" aria-labelledby="solcursoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-light text-primary">
              <h5 class="modal-title" id="solcursoModalLabel"><i class="fas fa-chalkboard-teacher pe-2"></i> Plan Individual de Desarrollo</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form>
                <div class="mb-3">
                  <input id="tipo_curso" value="" type="hidden">
                  <input id="num_c_comp" value="0" type="hidden">
                  <label for="sel_curso_pid" class="col-form-label">Seleccionar curso:</label>
                  <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="sel_curso_pid">
                  </select>
                </div>
              </form>
            </div>
            <div class="modal-footer bg-light">
              <button type="button" class="btn btn-secondary btn-small" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pe-2"></i>Cancelar</button>
              <button type="button" class="btn btn-primary btn-small" onclick="add_curso()"><i class="fas fa-plus pe-2"></i>Agregar</button>
            </div>
          </div>
        </div>
      </div>

  </form>
  <div id="rpt"></div>
  

<!-- Modal -->
    <div class="modal fade" id="leermas" tabindex="-1" aria-labelledby="leermas_competencia" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-light text-primary py-1">
            <h5 class="modal-title" id="leermas_competencia"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form>
              <div class="mb-3 small">
                <span class="fw-bold">Definición:</span>
                <p id="leermas_definicion"></p>
                <span class="fw-bold">Niveles Altos:</span>
                <p id="leermas_nivel_alto"></p>
                <span class="fw-bold">Niveles Bajos:</span>
                <p id="leermas_nivel_bajo"></p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!--Modal no EVALUADO-->
 
    <div class="modal fade" id="modal_no_evaluado" data-bs-backdrop="static" aria-labelledby="exampleModalLongTitle" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-light">
            <h5 class="modal-title text-danger" id="exampleModalLongTitle"><i class="fa-solid fa-ban pe-2 fa-lg"></i>No será evaluado</h5>
          </div>
          <div class="modal-body small">                  
            <div class="my-2">
               Por favor indicar la razón por la cual el colaborador no será evaluado.
            </div>
            <div class="form-check ms-2">
              <input class="form-check-input" type="radio" name="opt" id="opt1" onchange="destalle_noeval()" style="cursor: pointer" checked>
              <label class="form-check-label" for="opt1" style="cursor: pointer">
                Ya no labora en la organización.
              </label>
            </div>
            <div class="form-check ms-2">
              <input class="form-check-input" type="radio" name="opt" id="opt2" onchange="destalle_noeval()" style="cursor: pointer">
              <label class="form-check-label" for="opt2" style="cursor: pointer">
                Es nuevo en la organización (menos de 6 meses).
              </label>
            </div>
            <div class="form-check ms-2">
              <input class="form-check-input" type="radio" name="opt" id="opt3" onchange="destalle_noeval()" style="cursor: pointer">
              <label class="form-check-label" for="opt3" style="cursor: pointer">
                No pertenece a este departamento.
              </label>
            </div>    
            <div class="form-check ms-2">
              <input class="form-check-input" type="radio" name="opt" id="opt4" onchange="destalle_noeval()" style="cursor: pointer">
              <label class="form-check-label" for="opt4" style="cursor: pointer">
                Otra.
              </label>
            </div>         
            <div class="my-3 visually-hidden" id="coment_noeval">
              <label for="txtdet_noevalua" class="form-label py-0 text-secondary"> Especificar</label>
              <textarea class="form-control  form-control-sm" id="txtdet_noevalua" rows="2"></textarea>
            </div>
            <div class="text-center visually-hidden text-danger" id="div_msn_detallar">
              <i class="fas fa-exclamation-triangle"></i> Por favor detallar un poco más.
           </div>
          </div>
          <div class="modal-footer bg-light">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pe-2"></i>Cancelar</button>
            <button type="button" class="btn btn-primary btn-sm"  onclick="noeval(4)"><i class="fas fa-save pe-2 fa-lg"></i>Guardar</button>
          </div>
        </div>
      </div>
    </div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
@endsection
<script type='text/javascript'>
  function noevaluador()
  { $('#coment_noeval').addClass('visually-hidden');
    $('#opt1').prop('checked', true); 
    $('#txtdet_noevalua').val('');
  }
    function destalle_noeval()
    { $('#txtdet_noevalua').val('');
      if ($('#opt4').is(':checked')) {
        $('#coment_noeval').removeClass('visually-hidden'); // Muestra el div
        $('#txtdet_noevalua').focus();
      } else {
        $('#coment_noeval').addClass('visually-hidden'); // Oculta el div
      }
    }

    function noeval(estatus)
    { if ($('#opt1').is(':checked')) { comentarios='Ya no labora en la organización.';}
      if ($('#opt2').is(':checked')) { comentarios='Es nuevo en la organización (menos de 6 meses).';}
      if ($('#opt3').is(':checked')) { comentarios='No pertenece a este departamento.';}
      if ($('#opt4').is(':checked')) { comentarios='Otra. '+$('#txtdet_noevalua').val();}
      
      if(comentarios.length>10)
      {
        Swal.fire({
        text: "Se procederá a cerrar la evaluación indicando que el colaborador no será evaluado. ¿Desea continuar? ",
        showCancelButton: true,
          cancelButtonText:  '<i class="fas fa-arrow-left"></i> Cancelar',
          confirmButtonText: '<i class="fas fa-save pr-2"></i> Si, continuar',
          confirmButtonColor: "#d33",
          icon: "warning",
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) 
          {  cod_evaluado=$("#lb_code_evaluado").html();
              var parametros = {
              "cod_evaluado": cod_evaluado,
              "cod_evaluador": $("#cod_evaluador").val(),
              "comentarios": comentarios,
              "eval_id": $("#eval_id").val(),
              "estatus": estatus,
              "_token": $('input[name="_token"]').val()};

            $.ajax({
              data:  parametros, 
              url:   "{{ route('evaluacion.save') }}",
              type:  'POST', 
              cache: false,    
              dataType: "json",      
              success:  function (data) {               
                $('#modal_no_evaluado').modal('hide');
                $('#link_eval_'+cod_evaluado).html('<div class="edit"  onclick="eval('+cod_evaluado+','+estatus+')">'+                    
                '<span class="text-danger  fw-bold"><i class="fas fa-exclamation-triangle fa-lg pe-2"></i>No Evaluado</span>'); 
                document.getElementById("div_tabla").style.display='block';
                document.getElementById("div_formulario").style.display='none';
                document.getElementById('div_competencias').style.display="none";
                document.getElementById('div_respon').style.display="none";
                document.getElementById('div_habilidades').style.display="none";
                document.getElementById('div_desarrollo').style.display="none";
                document.getElementById('div_cumplimiento_pid').style.display="none";
                document.getElementById("div_pid").style.display='none';
                document.getElementById('div_cumplimiento_kpi').style.display="none";
                bien('La evaluación ha sido finalizada.');               
              } 
            });
          }
          })
      }
      else
      {
        $('#div_msn_detallar').removeClass('visually-hidden');
        setTimeout(function(){ $('#div_msn_detallar').addClass('visually-hidden')}, 3000);        
        $('#txtdet_noevalua').focus();
      }
    }

    function save(estatus)
    { 
      var msn="";
      if(estatus==3) { msn="Se enviará la evaluación y finalizará el proceso. ¿Desea continuar?";}
      else  { msn="Se guardará la evaluación y podrá continuar luego. ¿Desea continuar?";}
      Swal.fire({
      text: msn,

      showCancelButton: true,
        cancelButtonText:  '<i class="fas fa-arrow-left"></i> Cancelar',
        confirmButtonText: '<i class="fas fa-save pr-2"></i> Si, guardar',
        icon: "question",
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) 
        {
          var _token = $('input[name="_token"]').val();
          cod_evaluado= $("#lb_code_evaluado").html();
          cod_evaluador= $("#cod_evaluador").val();
          eval_id= $("#eval_id").val();
          var p=0; var countkpi_cumpli=0;
          const competencias = [];
          const tareas = [];
          const hab = [];
          const pid_cursos_cumpli = [];
          const pid_comp_cursos = [];
          const pid_hab_cursos = [];
          const pid_adic_cursos = [];
          
          band_comp=0;
          var countcomp=$("#countcomp").val();
          for (var p = 1; p <= countcomp; p++) 
          { perfil=$("#perfil_"+p).html()-3;
            comp=$("#p_"+p).val();     
            if ($("input[name='comp_"+p+"']").is(':checked')) 
            { for (var i = 1; i <= 10; i++)
              { if(document.getElementById('comp_'+p+'_'+i).checked) 
                { competencias.push({'id':comp,'nom_comp':$("#nomcomp_"+p).html() , 'valor': $("input[id='comp_"+p+"_"+i+"']").val(), 'perf':perfil});}
              }
            }else
            {
              $('#msg_'+p).removeClass('visually-hidden');
              band_comp=1;
            }
          }

          band_tar=0;
          var counttar=$("#counttar").val();
          for (var p = 1; p <= counttar; p++) 
          {    
            if ($("input[name='tar_"+p+"']").is(':checked')) 
            { idtar=$("#tar_"+p).val();
              for (var i = 1; i <= 5; i++)
              { if(document.getElementById('tar_'+p+'_'+i).checked) 
                { tareas.push({'idrespon':+$("#idrespon_"+p).val(),'respon':$("#respon_"+$("#idrespon_"+p).val()).html(),'idtar':$("#tar_"+p+'_'+i).val(),'tar':$("#desctar_"+p).html() , 'valor': i});}
              }
            }else
            { $('#msg_tar_'+p).removeClass('visually-hidden');
              band_tar=1;
            }
          }

          band_hab=0;
          var counthab=$("#counthab").val();
          for (var p = 1; p <= counthab; p++) 
          {    
            if ($("input[name='hab_"+p+"']").is(':checked')) 
            { idhab=$("#hab_"+p).val();
              for (var i = 1; i <= 3; i++)
              { if(document.getElementById('hab_'+p+'_'+i).checked) 
                { hab.push({'idhab':$("#hab_"+p+'_'+i).val(),'hab':$("#deschab_"+p).html() , 'valor': i});}
              }
            }else
            {
              $('#msg_hab_'+p).removeClass('visually-hidden');
              band_hab=1;
            }
          }


          countpid_comp=$("#tbody_pid_comp tr").length;
          for (var p = 1; p <= countpid_comp; p++) 
          { if ($("#id_curso_com_"+p).length) 
            {  pid_id_curso_comp=$("#id_curso_com_"+p).val();
              pid_nom_curso_comp=$("#nom_curso_com_"+p).html();
              pid_fecha_curso_comp=$("#fecha_curso_"+p).val();
            } 
            else {  
              pid_id_curso_comp=0; 
              pid_nom_curso_comp='-';
              pid_fecha_curso_comp='-';
            }
            pid_comp_cursos.push({"pid_id_comp": $("#pid_id_comp_"+p).val(), "pid_comp": $("#pid_comp_"+p).html(), "id_curso_com": pid_id_curso_comp, "nom_curso_com": pid_nom_curso_comp,"fecha":pid_fecha_curso_comp})
          }

          if(countpid_comp==0){pid_comp_cursos.push({"pid_id_comp": 0, "pid_comp": '-', "id_curso_com": 0, "nom_curso_com": '-'})}

          asig_curso_comp=0;
          if((estatus==3) && (countpid_comp > 0))
          {
            if($("#cant_curso_asig_comp").val() < countpid_comp)
            { asig_curso_comp=1;}
          }

          countpid_hab=$("#tbody_pid_hab tr").length;
          for (var p = 1; p < countpid_hab; p++) 
          { 
            if ( $("#id_curso_hab_"+p).length) 
            { pid_id_curso_hab= $("#id_curso_hab_"+p).val();
              pid_nom_curso_hab= $("#nom_curso_hab_"+p).html();
              pid_fecha_curso_hab= $("#fecha_curso_hb_"+p).val();
            } 
            else {  
              pid_id_curso_hab=0; 
              pid_nom_curso_hab='-';
              pid_fecha_curso_hab='-';
            }
            pid_hab_cursos.push({ "id_curso_hab": pid_id_curso_hab, "nom_curso_hab": pid_nom_curso_hab, "fecha": pid_fecha_curso_hab })
          }

          if(countpid_hab<=1){pid_hab_cursos.push({ "id_curso_hab": 0, "nom_curso_hab": '-' })}


          count_pid_adic=$('#tbody_pid_hab_adicional').length;
          var nrows = $("#tbody_pid_hab_adicional tr").length;
          for (var p = 0; p < nrows; p++) 
          { area= document.getElementById('tbody_pid_hab_adicional').getElementsByTagName("tr")[p].getElementsByTagName("td")[0].innerHTML;
            nom_curso= document.getElementById('tbody_pid_hab_adicional').getElementsByTagName("tr")[p].getElementsByTagName("td")[1].innerHTML;
            accion= document.getElementById('tbody_pid_hab_adicional').getElementsByTagName("tr")[p].getElementsByTagName("td")[2].innerHTML;
            pid_adic_cursos.push({ "area": area, "nom_curso": nom_curso, "accion": accion })
          }
          if(nrows==0){ pid_adic_cursos.push({ "area": '-', "nom_curso": '-', "accion": '-' })}

          countpid_cumpli=$("#tbody_cumplimiento_pid tr").length;
          for (var p = 1; p <= countpid_cumpli; p++) 
          {
            pid_cursos_cumpli.push({ "id_curso_cumpli": $("#id_curso_cumpli_"+p).val(), "nom_curso_cumpli": $("#nom_curso_cumpli_"+p).html(), "nota_curso_cumpli": $("#nota_curso_cumpli_"+p).html()})
          }


    
          countkpi_cumpli=$("#tbody_cumplimiento_kpi tr").length;
        

          if(document.getElementById('promo1').checked) { desarrollo=0;}
          if(document.getElementById('promo2').checked) { desarrollo=1;}
          if(document.getElementById('promo3').checked) { desarrollo=2;}
          if(document.getElementById('promo4').checked) { desarrollo=3;}

          // GUARDANDO EVALUACIÓN
          if( band_comp==0 && band_tar==0 && band_hab==0 && asig_curso_comp==0)
          {
              var parametros = {
              "cod_evaluado":cod_evaluado,
              "cod_evaluador": cod_evaluador,
              "eval_id":eval_id,
              "id_escala":$("#id_escala").val(),
              "countcomp":countcomp,
              "counthab":counthab,
              "counttar":counttar,
              "countpid_cumpli":countpid_cumpli,
              "competencias":competencias,
              "tareas":tareas,
              "hab":hab,
              "pid_cursos_cumpli":pid_cursos_cumpli,
              "countkpi_cumpli": countkpi_cumpli,
              "pid_comp_cursos":pid_comp_cursos,
              "pid_hab_cursos":pid_hab_cursos,
              "pid_adic_cursos":pid_adic_cursos,
              "logros":$("#txtlogros").val(),
              "comentarios":$("#txtcoment").val(),
              "desarrollo":desarrollo,
              "estatus":estatus,
              "_token": _token};
            $.ajax({
              data:  parametros, 
              url:   "{{ route('evaluacion.save') }}",
              type:  'POST', 
              cache: false,    
              dataType: "json",      
              success:  function (data) { 
                if(estatus==3)
                {  resultado=Number(data.resultado);
                  $('#div_res_'+cod_evaluado).html(resultado.toFixed(1)+"% ");
                  $('#link_eval_'+cod_evaluado).html('<div class="edit"  onclick="eval('+cod_evaluado+','+estatus+')">'+
                  '<span class="text-primary fw-bold"><i class="fas fa-search fa-lg pe-2"></i>Evaluado</span></div>'); 
                  document.getElementById("div_tabla").style.display='block';
                  document.getElementById("div_formulario").style.display='none';
                  document.getElementById('div_competencias').style.display="none";
                  document.getElementById('div_respon').style.display="none";
                  document.getElementById('div_habilidades').style.display="none";
                  document.getElementById('div_desarrollo').style.display="none";
                  document.getElementById('div_cumplimiento_pid').style.display="none";
                  document.getElementById("div_pid").style.display='none';
                  document.getElementById('div_cumplimiento_kpi').style.display="none";
                
                  bien('La evaluación ha sido almacenada.');}
                if(estatus==2)
                { 
                  $('#link_eval_'+cod_evaluado).html('<div class="edit"  onclick="eval('+cod_evaluado+','+estatus+')">'+
                  '<span class=" fw-bold" style="color:#ff7700"><i class="far fa-edit fa-lg pe-2"></i>Continuar</span></div>'); 
                  document.getElementById("div_tabla").style.display='block';
                  document.getElementById("div_formulario").style.display='none';
                  document.getElementById('div_competencias').style.display="none";
                  document.getElementById('div_respon').style.display="none";
                  document.getElementById('div_habilidades').style.display="none";
                  document.getElementById('div_desarrollo').style.display="none";
                  document.getElementById('div_cumplimiento_pid').style.display="none";
                  document.getElementById("div_pid").style.display='none';
                  document.getElementById('div_cumplimiento_kpi').style.display="none";
                
                  bien('La evaluación ha sido almacenada.');}                

                
              }
            });
          }
          else
          { if( asig_curso_comp==1)
            { mal('Por favor, asignar un curso y fecha a cada competencia en el Nuevo Plan Individual de Desarrollo.');}
            else
            { mal('Por favor evaluar cada una de las opciones del formulario.');
              if(band_comp==1)
              { window.location.href = "#div_competencias";}
              else
              { if(band_tar==1)
                { window.location.href = "#div_respon";}
                else
                { if(band_hab==1)
                  { window.location.href = "#div_habilidades";}
                }
              }
            }
          }
        }
      });      
    }
 
    function eval(id_evdo,status)
    { clean();
      document.getElementById("div_tabla").style.display='none';
      document.getElementById("div_formulario").style.display='block';
      document.getElementById('div_competencias').style.display="none";
      document.getElementById('div_respon').style.display="none";
      document.getElementById('div_habilidades').style.display="none";
      document.getElementById('div_desarrollo').style.display="none";
      document.getElementById('div_cumplimiento_pid').style.display="none";
      document.getElementById('div_cumplimiento_kpi').style.display="none";
      $('#lb_comet__noevaluado').addClass('visually-hidden');
      $('#lb_comet__noevaluado').html('');
      
      var _token = $('input[name="_token"]').val();
      var parametros = {
      "id_evdo": id_evdo,
      "_token":_token};
      $.ajax({
        data:  parametros, 
        url:   "{{ route('evaluacion.evaluado') }}",
        type:  'POST', 
        dataType: "json",
        cache: true, 
        beforeSend: function () {
          //$('#div_competencias').html('<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');
        }, 
        success:  function (data) { 
          if(data.status!=0)
          { genero='M';
            $('#lb_code_evaluado').html(id_evdo);
            $('#lb_nombre').html(data.nom_evaluado);

            jQuery(data.evaluado).each(function(i, item){
              $('#lb_nom_puesto_evaluado').html(item.descpue);
              $('#lb_finicio').html(data.finicio);
              $('#lb_nom_depto_evaluado').html(item.nameund);
              
              genero=item.genero
            });
            showfoto(id_evdo,genero);
            
            nrows=0;
            if(status<3)
            { $('#estatus').val(status);
              $('#bto_print').addClass('visually-hidden');
              $('#bto_no_evalua').removeClass('visually-hidden');
              // LISTANDO COMPETENCIAS A EVALUAR
              if(data.competencias.length>0)
              { document.getElementById('div_competencias').style.display="block";  
                jQuery(data.competencias).each(function(i, item){
                  nrows++;
                  contendor  = $("#tbody_competencias").html();
                  nuevaFila   = '<tr>'+
                  '<td style="text-align: justify; vertical-align: middle;"><span class="fw-bold text-primary">'+nrows+'- </span><span class="fw-bold text-primary" id="nomcomp_'+nrows+'">'+item.nomcomp+'</span> '+item.definicion_resumen+'        <small><span class="text-primary" style="cursor:pointer" onclick="leermas('+item.idcomp+')")><u>Leer más</u></span></small><input type="hidden" id="p_'+nrows+'" value="'+item.idcomp+'"></td>'+
                  '<td class="align-middle"><small>'+
                    '<div class="likertt-scale align-items-center justify-content-center text-center my-1">';
                  for (var i = 1; i <= 10; i++) {                
                    bg="bg-light";
                    if(item.perfil==8){ if(i==6){ bg="green-8";} if(i==7){ bg="green-9";} if(i==8){ bg="green-10";} }      
                    if(item.perfil==9){ if(i==7){ bg="green-8";} if(i==8){ bg="green-9";} if(i==9){ bg="green-10";} }      
                    if(item.perfil==10){ if(i==8){ bg="green-8";} if(i==9){ bg="green-9";} if(i==10){ bg="green-10";} }
                    habilitado="";
                    if(item.opt==i)
                    { habilitado='checked';}
                    nuevaFila+= '<div class="likertt-item '+bg+'">'+
                    '    <input type="radio" id="comp_'+nrows+'_'+i+'" name="comp_'+nrows+'" value="'+i+'" onchange="pid()" '+habilitado+'>'+
                    '    <label for="comp_'+nrows+'_'+i+'" >'+i+'</label>'+
                    '</div>';
                    }
                  nuevaFila+= '</div>'+
                  '<div class="text-danger text-center visually-hidden" id="msg_'+nrows+'"><i class="fas fa-exclamation-triangle pe-2"></i>Evaluar</div>'+
                  '<td class="text-center h6" style="vertical-align: middle;"><span id="perfil_'+nrows+'" class="nivel">'+item.perfil+'</span></small></td></tr>';
                  $("#tbody_competencias").html(contendor+nuevaFila); 
                }); 
              }
              $("#countcomp").val(nrows); 

              // LISTANDO TAREAS Y HABILDIADES A EVALUAR
              if(data.respons.length>0)
              { document.getElementById('div_respon').style.display="block";   
                x=0;cont_respon=0;
                jQuery(data.respons).each(function(i, item){ 
                  contendor  = $("#tbody_respon").html();
                  cont_respon++;
                  nuevaFila  ="";
                  nuevaFila   += '<tr>';
                  nuevaFila  += '<td class="align-middle text-uppercase small text-secondary fw-bold" style="background-color:#FFFFFF" rowspan="'+item.cant_tarea+'"><span id="respon_'+cont_respon+'">'+item.area_respon+'</span></th>';     
                  jQuery(data.tareas).each(function(i, item2){
                      if(item.id_respon===item2.idarearespon)
                      { x++;
                        nuevaFila  += '<td class="align-middle"><span id="desctar_'+x+'">'+item2.tarea.slice(3)+'</span><input type="hidden" id="idrespon_'+x+'" value="'+cont_respon+'"></td>';
                        nuevaFila  += '<td class="align-middle"><small>'+
                          '<div class="likertt-scale align-items-center justify-content-center text-center my-1">';
                        for (var i = 1; i <= 5; i++) {                
                          bg="bg-light";   
                          habilitado="";
                          if(item2.opt==i)  
                          { habilitado='checked';}        
                          nuevaFila+= '<div class="likertt-item green-'+i+'">'+
                          '    <input type="radio" id="tar_'+x+'_'+i+'" name="tar_'+x+'" value="'+item2.id+'" onchange="tar()" '+habilitado+'>'+
                          '    <label for="tar_'+x+'_'+i+'">'+i+'</label>'+
                          '</div>';
                        }
                        nuevaFila+= '</div>'+
                        '<div class="text-danger text-center visually-hidden" id="msg_tar_'+x+'"><i class="fas fa-exclamation-triangle pe-2"></i>Evaluar</div>'+
                        '</td></tr>';                   
                      }
                    });
                    $("#tbody_respon").html(contendor+nuevaFila);
                });
                $("#counttar").val(x);
              }

              // LISTANDO HABILIDADES Y CONOCIMIENTOS A EVALUAR
              if(data.habilidades.length>0)
              {
                document.getElementById('div_habilidades').style.display="block";
                x=0;
                jQuery(data.habilidades).each(function(i, item){ 
                  contendor  = $("#tbody_habilidad").html();
                  x++;
                  habilitado0="";habilitado3="";habilitado5="";
                  if(item.opt==0) { habilitado0='checked';}  
                  if(item.opt==3) { habilitado3='checked';}  
                  if(item.opt==5) { habilitado5='checked';}  
                  nuevaFila   = '<tr>'+
                  '<td class="ps-2 text-start align-middle"><span id="deschab_'+x+'">'+item.habilidad.slice(3)+'</span></td><td class="align-middle">';
                    nuevaFila  += 
                        '<ul class="likert small">'+
                        '  <li>'+
                        '    <input type="radio" name="hab_'+x+'" id="hab_'+x+'_1" value="'+item.id+'" onchange="hab()" '+habilitado0+'>'+
                        '    <label for="hab_'+x+'_1">No la tiene</label>'+
                        '  </li>'+
                        '  <li>'+
                        '    <input type="radio" name="hab_'+x+'" id="hab_'+x+'_2" value="'+item.id+'" onchange="hab()" '+habilitado3+'>'+
                        '    <label for="hab_'+x+'_2">Esta en Desarrollo</label>'+
                        '  </li>'+
                        '  <li>'+
                        '    <input type="radio" name="hab_'+x+'" id="hab_'+x+'_3" value="'+item.id+'" onchange="hab()" '+habilitado5+'>'+
                        '    <label for="hab_'+x+'_3">Si la tiene</label>'+
                        '  </li>'+
                        '</ul>'+
                        '<div class="text-danger text-center visually-hidden" id="msg_hab_'+x+'"><i class="fas fa-exclamation-triangle pe-2"></i>Evaluar</div>'+                    
                  '</td></tr>';
                  $("#tbody_habilidad").html(contendor+nuevaFila); 
                }); 
                $("#counthab").val(x);
              }

              // LISTADO CURSOS OPTENIDOS EN UBITS 
              if(data.res_cursos.length>0)
                {
                     

                    $("#tbody_cumplimiento_pid").html('');
                    x=0;
                    jQuery(data.res_cursos).each(function(i, item){ 
                    contendor  = $("#tbody_cumplimiento_pid").html();
                    x++;
                    nuevaFila   = '<tr><td class="ps-4 text-secondary text-start align-middle"><span id="nom_curso_cumpli_'+x+'">'+item.nom_curso+'</span><input type="hidden" id="id_curso_cumpli_'+x+'" value="'+item.id_curso+'"></td><td class="align-middle text-center"><span id="nota_curso_cumpli_'+x+'">'+item.nota+'</span></td></tr>';
                    $("#tbody_cumplimiento_pid").append(nuevaFila);
                    });
                    $("#countcursos").val(x);
                  if(data.cursos_stand==0)
                  { $('#alert_cursos').addClass('visually-hidden');
                    $('#bto_guarda').removeClass('visually-hidden');
                    document.getElementById('div_cumplimiento_pid').style.display="block"; 
                  }
                  else{ $('#alert_cursos').removeClass('visually-hidden');
                    $('#bto_guarda').addClass('visually-hidden');
                    document.getElementById('div_cumplimiento_pid').style.display="none"; 
                  }
                }

              // LISTANDO KPI SI LOS TIENE
              $("#promedio_kpi_cumpli").html('');
              if(data.res_kpi.length>0)
              {
                  document.getElementById('div_cumplimiento_kpi').style.display="block";  
   
                  $("#tbody_cumplimiento_kpi").html('');
                  x=0;
                  jQuery(data.res_kpi).each(function(i, item){ 
                  contendor  = $("#tbody_cumplimiento_kpi").html();
                  x++;
                  nuevaFila   = '<tr><td class="ps-4 text-secondary text-start align-middle"><span id="nom_kpi_'+x+'">'+item.nom_kpi+'</span><input type="hidden" id="id_kpi_cumpli_'+x+'" value="'+item.id+'"></td><td class="align-middle text-center"><span id="kpi_cumpli_'+x+'">'+item.real+'</span></td></tr>';
                  $("#tbody_cumplimiento_kpi").append(nuevaFila);
                  });
                  $("#promedio_kpi_cumpli").html(data.prom_metas);
              }
              
              $("#tbody_pid_comp").html('');
              // Iterar sobre los resultados para agregar filas a la tabla de los PID de  las competencias              
              //  NUEVO PID
              if(data.resp_curcomp.length>0)
              { $("#cant_curso_asig_comp").val(0);
                  jQuery(data.resp_curcomp).each(function(i, item){
                    contendor  = $("#tbody_pid_comp").html();
                    fila=$("#tbody_pid_comp tr").length+1;
                    curso='<span class="editlink_naranja fw-bold small ps-4" onclick="selcourse('+ item.id_comp +','+fila+')"><i class="far fa-edit fa-lg"></i> Seleccionar Curso ';
                    if(item.curso!=null)
                    { curso='<span id="nom_curso_com_'+fila+'">'+item.curso+ '</span><span class="editlink_naranja fw-bold small ps-4" onclick="selcourse('+ item.id_comp +','+fila+')"><i class="far fa-edit fa-lg"></i> Cambiar </span><input type="hidden" id="id_curso_com_'+fila+'" value="'+item.id_curso+'">';}
                    const nuevaFila = '<tr>' +
                    '<td class="ps-4"><span id="pid_comp_'+fila+'">'+item.comp+ '</span><input type="hidden" id="pid_id_comp_'+fila+'" value="'+ item.id_comp +'"></td>' +
                    '<td class="text-center"><span id="curso_comp_'+fila+'">'+curso+'</span></td>' +
                    '<td class="text-center"><input class="form-control form-control-sm" type="date" id="fecha_curso_'+fila+'" value="'+ item.fecha +'"/></td>' +
                    '</tr>';
                    $("#tbody_pid_comp").html(contendor+nuevaFila); 
                    if(item.curso!=null)
                    { $("#cant_curso_asig_comp").val(parseInt($("#cant_curso_asig_comp").val())+1);}
                  }); 
                $("#table_desarrollo").removeClass('visually-hidden');
                $('#instrucc_compe').removeClass('visually-hidden');
              }

              $("#tbody_pid_hab").html('<tr><td colspan="3" class="text-center"><span class="editlink_naranja fw-bold small"  onclick="selcoursehab()"><i class="far fa-edit fa-lg"></i> Seleccionar cursos</span></td></tr>');contendor  ="";nuevaFila   = "";
              x=0;
              jQuery(data.resp_resp_curhab).each(function(i, item){
                x++;
                contendor  = $("#tbody_pid_hab").html();
                nuevaFila   = '<tr>'+
                  '<td  class="ps-4" style=" vertical-align: middle;"><span id="nom_curso_hab_'+x+'">'+item.curso+' </span><input type="hidden" id="id_curso_hab_'+x+'" value="'+item.id_curso+'"></td>'+ 
                  '<td class="text-center"><input class="form-control form-control-sm" type="date" id="fecha_curso_hb_'+x+'" value="'+ item.fecha +'"/></td>' +
                  '<td class="text-center align-middle"><i class="fa-solid fa-trash-can dell" onclick=delrow(this,"programa") title="Eliminar Curso"></i></td></tr>';
                  $("#tbody_pid_hab").html(contendor+nuevaFila); 
                  $("#cant_curso_asig_hab").val(x);
              }); 
                
                x=0;
                jQuery(data.resp_curadic).each(function(i, item){
                  x++;
                  contendor=$("#tbody_pid_hab_adicional").html();
                  nuevaFila   = '<tr>'+
                    '<td class="ps-4" style="text-align: justify; vertical-align: middle;">'+item.area+'</td>'+
                    '<td class="ps-4" style="text-align: justify; vertical-align: middle;">'+item.curso+'</td>'+
                    '<td class="ps-4" style="text-align: justify; vertical-align: middle;">'+item.accion+'</td>'+
                    '<td class="text-center align-middle"><i class="fa-solid fa-trash-can dell" onclick=delrowadd(this) title="Eliminar Curso"></i></td></tr>';
                    
                    $("#tbody_pid_hab_adicional").html(contendor+nuevaFila); 
                }); 
              
              
              if(data.logros!=null)
              { $('#txtlogros').val(data.logros);}
              if(data.comentarios!=null)
              { $('#txtcoment').val(data.comentarios);}
              if(data.carrera!=null)
              { if(data.carrera==0){ document.getElementById('promo1').checked='checked';}
                if(data.carrera==1){ document.getElementById('promo2').checked='checked';}
                if(data.carrera==2){ document.getElementById('promo3').checked='checked';}
                if(data.carrera==3){ document.getElementById('promo4').checked='checked';}
              }

              $("#id_escala").val(data.escala);
              document.getElementById('div_desarrollo').style.display="block";              
              document.getElementById("div_pid").style.display='block';
            }
            else
            { if(status<4)
              {
                // INFORME DE COLABORADOR EVALUADO
                band_competencias=0; band_tareas=0; band_habilidades=0; band_kpi=0; band_pid=0;
                $('#estatus').val(status);
                $("#tbody_resp_eval").html('');
                $('#resp_gap').removeClass('visually-hidden');

                $('#resp_comp').removeClass('visually-hidden');
                $('#resp_tar').removeClass('visually-hidden');
                $('#resp_hab').removeClass('visually-hidden');
                $('#resp_cumpli_pid').removeClass('visually-hidden');
                $('#resp_desarrollo').removeClass('visually-hidden');
                $('#resp_resumen').removeClass('visually-hidden');
                $('#div_resultado').removeClass('visually-hidden');
                $('#div_calificacion').removeClass('visually-hidden');
                $('#div_f_evaluacion').removeClass('visually-hidden');
                $('#bto_continuar').addClass('visually-hidden');
                $('#bto_print').removeClass('visually-hidden');
                $('#bto_no_evalua').addClass('visually-hidden');
                $('#bto_guarda').addClass('visually-hidden');
                $('#lb_resultado').html(data.resultado+"%");
                $('#lb_calificacion').html("<div style=color:"+data.color+">"+data.categoria+"</div>");
                $('#lb_f_evaluacion').html(data.feval);
  
                //-------------- RESP TABLA GAB
                $("#tbody_resp_gap").html('');contendor  ="";nuevaFila   = "";
                jQuery(data.resp_gap).each(function(i, item){
                  contendor  = $("#tbody_resp_gap").html();

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

                  nuevaFila   = '<tr>'+
                    '<td class="fw-bold" style="text-align: center; vertical-align: middle;"><h6>'+numero_gap_ci+' %</h6></td>'+
                    '<td class="fw-bold" style="text-align: center; vertical-align: middle;"><h6>'+numero_gap_na+' %</h6></td>'+
                    '<td class="fw-bold" style="text-align: center; vertical-align: middle;"><h6>'+numero_gap_comp+' %</h6></td>'+
                    '<td class="fw-bold" style="text-align: center; vertical-align: middle;"><h6>'+numero_gap_conhab+' %</h6></td>'+
                    '<td class="fw-bold" style="text-align: center; vertical-align: middle;"><h6>'+numero_gap+' %</h6></td></tr>';
                    $("#tbody_resp_gap").html(contendor+nuevaFila); 
                }); 

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
                    nrows++;
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
              else{
                
                if(data.comentarios.slice(0,5)=='Otra.')
                { comentarios=data.comentarios.slice(6)}
                else{ comentarios=data.comentarios}
                $('#lb_comet__noevaluado').removeClass('visually-hidden');
                $('#lb_comet__noevaluado').html("<b>Observación:</b> <span class='text-danger'> <i class='fas fa-exclamation-triangle'></i> No será evaluado.</span><br> "+comentarios.replace(/\n/g, "<br>"));
                $('#bto_continuar').addClass('visually-hidden');
                $('#bto_print').addClass('visually-hidden');
                $('#bto_no_evalua').addClass('visually-hidden');
                $('#bto_guarda').addClass('visually-hidden');
              }
            }
          }
          else{
            $('#alert_noasignado').removeClass('visually-hidden');
          }
        }
      });
    }

  
    function delrow(id)
    {
        let row = id.parentNode.parentNode;
        let table = document.getElementById("table_habilidadespid"); 
        table.deleteRow(row.rowIndex);   
        fila=$("#tbody_pid_hab tr").length;
        $("#cant_curso_asig_hab").val(fila-1);
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
              
              document.getElementById('img_photo').setAttribute("src", "/FOCUSTalent/public/storage/profiles/photo/ella.png");}
              else { document.getElementById('img_photo').setAttribute("src", "/FOCUSTalent/public/storage/profiles/photo/el.png");}}
          }
        });
    }

    function back()
    {
      document.getElementById("div_tabla").style.display='block';
      document.getElementById("div_formulario").style.display='none';
      document.getElementById('div_competencias').style.display="none";
      document.getElementById('div_respon').style.display="none";
      document.getElementById('div_habilidades').style.display="none";
      document.getElementById('div_desarrollo').style.display="none";      
      document.getElementById("div_pid").style.display="none";
      document.getElementById('div_cumplimiento_pid').style.display="none"; 
      document.getElementById('div_cumplimiento_kpi').style.display="none"; 
      clean();
    }
  
    function tar()
    {
      counttar=$("#counttar").val();
      for (var p = 1; p <= counttar; p++) 
      {    
        if ($("input[name='tar_"+p+"']").is(':checked')) 
        {  $('#msg_tar_'+p).addClass('visually-hidden');}
      } 
    }
    
    function hab()
    {
      counthab=$("#counthab").val();
      for (var p = 1; p <= counthab; p++) 
      {    
        if ($("input[name='hab_"+p+"']").is(':checked')) 
        {  $('#msg_hab_'+p).addClass('visually-hidden');}
      } 
    }
    
    function pid()
    {
      var countcomp=$("#countcomp").val();
      var p=0;
      const valcriti = [];
      const valmimport = [];
      const valimport = [];

      for (var p = 1; p <= countcomp; p++) 
      { perfil=$("#perfil_"+p).html()-3;
        comp=$("#p_"+p).val();     
        if ($("input[name='comp_"+p+"']").is(':checked')) 
        { for (var i = 1; i <= perfil; i++)
          { if(document.getElementById('comp_'+p+'_'+i).checked) 
            { if(perfil==7) { valcriti.push({'id':comp, 'valor': $("input[id='comp_"+p+"_"+i+"']").val(), 'tipo':3,'p':p}); }
              if(perfil==6) { valmimport.push({'id':comp, 'valor': $("input[id='comp_"+p+"_"+i+"']").val(), 'tipo':2,'p':p}); }
              if(perfil==5) { valimport.push({'id':comp, 'valor': $("input[id='comp_"+p+"_"+i+"']").val(), 'tipo':1,'p':p}); }
            }
          }
          $('#msg_'+p).addClass('visually-hidden');
        }
      }
      
      // Ordenar de manera ascendente por el campo 'valor'
      const compcriticas = valcriti.sort((a, b) => a.valor - b.valor);
      const compmimport = valmimport.sort((a, b) => a.valor - b.valor);
      const compimport = valimport.sort((a, b) => a.valor - b.valor);

      // Combinar registros, priorizando categoría 3, luego 2 y luego 1
      const resultados = [];
      resultados.push(...compcriticas.slice(0, 3)); // Tomar hasta 3 de categoría 3
      if (resultados.length < 3) {
        resultados.push(...compmimport.slice(0, 3 - resultados.length)); // Completar con categoría 2
      }
      if (resultados.length < 3) {
        resultados.push(...compimport.slice(0, 3 - resultados.length)); // Completar con categoría 1
      }
      console.log(resultados);
          
      // Limpiar el contenido del tbody
      $("#tbody_pid_comp").html('');

      // Iterar sobre los resultados para agregar filas a la tabla
      $("#cant_curso_asig_comp").val(0);
      if(resultados.length>=1)
      { $("#table_desarrollo").removeClass('visually-hidden');
        $('#instrucc_compe').removeClass('visually-hidden');
      
        resultados.forEach(dato => {
        fila=$("#tbody_pid_comp tr").length+1;
        const nuevaFila = '<tr>' +
        '<td class="ps-4"><span id="pid_comp_'+fila+'">'+$("#nomcomp_"+dato.p).html()+ '</span><input type="hidden" id="pid_id_comp_'+fila+'" value="'+ dato.id +'"></td>' +
        '<td class="text-center">' +
          '<span id="curso_comp_'+fila+'">' +
          '<span class="editlink_naranja fw-bold small ps-4" onclick="selcourse('+ dato.id +','+fila+')"> <i class="far fa-edit fa-lg"></i> Seleccionar curso </span></span>' +
          
          '<td class="text-center"><input class="form-control form-control-sm" type="date" id="fecha_curso_'+fila+'"/></td>' +
        '</td>' +
        '</tr>';
        $("#tbody_pid_comp").append(nuevaFila); // Agregar nueva fila        
      });
      }
      else
      { $("#table_desarrollo").addClass('visually-hidden');
        $('#instrucc_compe').addClass('visually-hidden');
        $("#tbody_pid_comp").append('<td colspan="2" class="text-center text-secondary">No mantiene GAP en las competencias organizacionales</td>');}
    }

    function selcourse(id,n)
    {
      var _token = $('input[name="_token"]').val();
      evaluado= $("#lb_code_evaluado").html();
      eval_id= $("#eval_id").val();
      var parametros = {
        "id":id,
        "tipo":"comp",
        "evaluado":evaluado,
        "eval_id":eval_id,
        "_token": _token};
        $.ajax({
          data:  parametros, 
          url:   "{{ route('evaluacion.compcursos') }}",
          type:  'POST', 
          cache: false,    
          dataType: "json",      
          success:  function (data) { 
            $('#sel_curso_pid').empty();
            $('#sel_curso_pid').append('<option value="0">Seleccione</option>');
            jQuery(data).each(function(i, item){ 
              $('#sel_curso_pid').append('<option value="'+item.id_curso+'">'+item.curso+'</option>');
          });  
          $('#tipo_curso').val('comp');
          $('#num_c_comp').val(n);
          }
        });
        $("#solcursoModal").modal('toggle');
    }
    
    function selcoursehab()
    {
      var _token = $('input[name="_token"]').val();
      evaluado= $("#lb_code_evaluado").html();
      eval_id= $("#eval_id").val();
      var parametros = {
        "tipo":"hab",
        "evaluado":evaluado,
        "eval_id":eval_id,
        "_token": _token};
        $.ajax({
          data:  parametros, 
          url:   "{{ route('evaluacion.compcursos') }}",
          type:  'POST', 
          cache: false,    
          dataType: "json",      
          success:  function (data) { 
            $('#sel_curso_pid').empty();
            $('#sel_curso_pid').append('<option value="0">Seleccione</option>');
            var area="";cad_1="";
            jQuery(data).each(function(i, item){
              if(area=="")
              { area=item.area;
                cad_1+='<optgroup label="'+area+'">';  
              }
              else{
                if(area!=item.area)
                { area=item.area;
                  $('#sel_curso_pid').append(cad_1);
                  $('#sel_curso_pid').append('</optgroup>');
                  cad_1="";
                  cad_1+='</optgroup><optgroup label="'+area+'"><option value="'+item.id_curso+'">'+item.curso+'</option>';                  
                  }
                  else{
                    cad_1+='<option value="'+item.id_curso+'">'+item.curso+'</option>';
                  }
              }
              
          }); 
          $('#sel_curso_pid').append(cad_1);
          $('#sel_curso_pid').append('</optgroup>');
          $('#tipo_curso').val('hab');
          }
        });
        $("#solcursoModal").modal('toggle');
    }

    function add_curso()
    { 
      fila=$("#tbody_pid_"+$("#tipo_curso").val()+" tr").length;
      if($("#sel_curso_pid").val()!=0)
      {  if($("#tipo_curso").val()=='hab')
        { nuevaFila   = '<tr>'+
          '<td class="ps-4" style="text-align: justify; vertical-align: middle;"><span id="nom_curso_hab_'+fila+'">'+$('select[id="sel_curso_pid"] option:selected').text()+'</span><input type="hidden" id="id_curso_hab_'+fila+'" value="'+$("#sel_curso_pid").val()+'"></td>'+
          '<td class="text-center"><input class="form-control form-control-sm" type="date" id="fecha_curso_hb_'+fila+'"/></td>' +
          '<td class="text-center align-middle"><i class="fa-solid fa-trash-can dell" onclick=delrow(this) title="Eliminar Curso"></i></td></tr>';
          $('#tbody_pid_'+$("#tipo_curso").val()+' tr:last').after(nuevaFila);
          $("#cant_curso_asig_hab").val(fila);
        }else
        { var fila=$("#num_c_comp").val();
          $('#curso_comp_'+fila).html(
            '<span id="nom_curso_com_'+fila+'">'+$('select[id="sel_curso_pid"] option:selected').text()+'</span>'+
            '<span class="editlink_naranja fw-bold small ps-4" onclick="selcourse('+ $("#pid_id_comp_"+fila).val() +','+fila+')"><i class="far fa-edit fa-lg"></i> Cambiar </span>' +
            '<input type="hidden" id="id_curso_com_'+fila+'" value="'+$("#sel_curso_pid").val()+'">');
          $("#cant_curso_asig_comp").val(parseInt($("#cant_curso_asig_comp").val())+1);
          $("#table_desarrollo").removeClass('visually-hidden');
          $('#instrucc_compe').removeClass('visually-hidden');
        } 
        $("#solcursoModal").modal('toggle');
      }
    }

    function add_otro()
    { $('#txt_area_desa').removeClass("border-danger");
      $('#txt_area_desa_curso').removeClass("border-danger");
      
      if($('#txt_area_desa').val().length==0){  $('#txt_area_desa').addClass("border-danger");}
      if($('#txt_area_desa_curso').val().length==0){  $('#txt_area_desa_curso').addClass("border-danger");}

      if(($('#txt_area_desa').val().length>0)&&($('#txt_area_desa_curso').val().length>0))
      { contenedor=$('#tbody_pid_hab_adicional').html();
        nuevaFila   = '<tr>'+
          '<td class="ps-4" style="text-align: justify; vertical-align: middle;">'+$('#txt_area_desa').val()+'</td>'+
          '<td class="ps-4" style="text-align: justify; vertical-align: middle;">'+$('#txt_area_desa_curso').val()+'</td>'+
          '<td class="ps-4" style="text-align: justify; vertical-align: middle;">'+$('#txt_area_desa_acciones').val()+'</td>'+
          '<td class="text-center align-middle"><i class="fa-solid fa-trash-can dell" onclick=delrowadd(this) title="Eliminar Curso"></i></td></tr>';
        $('#tbody_pid_hab_adicional').html(contenedor+nuevaFila);
        $('#txt_area_desa').val('');
        $('#txt_area_desa_curso').val('');
        $('#txt_area_desa_acciones').val('');
        $('#txt_area_desa').focus();
      }
    }

    function delrowadd(id)
    {
        let row = id.parentNode.parentNode;
        let table = document.getElementById("table_habilidadespid_adicional"); 
        table.deleteRow(row.rowIndex);   
        $('#txt_area_desa').removeClass("border-danger");
        $('#txt_area_desa_curso').removeClass("border-danger");
    }

    function clean()
    {
      document.getElementById('img_photo').setAttribute("src", "/FOCUSTalent/public/storage/profiles/photo/el.png");
      document.getElementById('alert_noasignado').style.display="none";
      document.getElementById('div_desarrollo').style.display="none";
      document.getElementById('div_cumplimiento_pid').style.display="none";
      $('#div_resultado').addClass('visually-hidden');    
      $('#div_calificacion').addClass('visually-hidden');  
      $('#div_f_evaluacion').addClass('visually-hidden');
      $('#alert_noasignado').addClass('visually-hidden');
      $('#bto_guarda').removeClass('visually-hidden');
      $('#bto_continuar').removeClass('visually-hidden');
      $('#resp_gap').addClass('visually-hidden');

      $('#resp_comp').addClass('visually-hidden');      
      $('#resp_tar').addClass('visually-hidden');      
      $('#resp_hab').addClass('visually-hidden');      
      $('#resp_cumpli_pid').addClass('visually-hidden');
      $('#resp_cumplimiento_kpi').addClass('visually-hidden');
      $("#tbody_resp_cumpli_kpi").html('');
      $("#tbody_resp_cumpli_kpi_total").html('');
      $('#resp_desarrollo').addClass('visually-hidden');
      $('#div_pid_titulo').addClass('visually-hidden');
      $('#resp_resumen').addClass('visually-hidden');
      $('#lb_code_evaluado').html('');
      $('#lb_nombre').html('');
      $('#lb_nom_puesto_evaluado').html('');
      $('#lb_finicio').html('');
      $('#lb_nom_depto_evaluado').html('');
      $('#countcomp').val(0);
      $("#tbody_competencias").html('');  
      $("#tbody_respon").html('');
      $("#tbody_habilidad").html('');
      $("#tbody_cumplimiento_pid").html('');
      $("#tbody_cumplimiento_kpi").html('');
      $("#tbody_pid_comp").html('<tr><td colspan="3" class="text-center text-secondary">No mantiene GAP en las competencias organizacionales</td></td></tr>');
      $("#tbody_pid_hab").html('<tr><td colspan="3" class="text-center"><span class="editlink_naranja fw-bold small"  onclick="selcoursehab()"><i class="far fa-edit fa-lg"></i> Seleccionar cursos</span></td></tr>');
      $("#txtlogros").val('');
      $("#txtcoment").val('');
      $('#instrucc_compe').addClass('visually-hidden');
      $("#table_desarrollo").addClass('visually-hidden');
      $("#tbody_pid_hab_adicional").html('');
      $('#txt_area_desa').removeClass("border-danger");
      $('#txt_area_desa_curso').removeClass("border-danger");        
      $('#txt_area_desa').val('');
      $('#txt_area_desa_curso').val('');
      $('#txt_area_desa_acciones').val('');
      $('#div_pid_cursos_com').addClass('visually-hidden');
      $('#div_pid_cursos_hab').addClass('visually-hidden');
      $('#div_pid_cursos_adi').addClass('visually-hidden');
      
      $('#alert_cursos').addClass('visually-hidden');
      $('#coment_noeval').addClass('visually-hidden');
      $('#div_msn_detallar').addClass('visually-hidden');
      $('#txtdet_noevalua').html('');
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

    function mal(msn)
    {
        Swal.fire({
          position: 'center',
          icon: 'warning',
          text: msn,
        })
    }

    function print()
    { 
        $("#rpt").html('');
        var form = $("<form/>", 
        {   action:"{{ route('evaluacion.print') }}" , 
            method : 'POST',
            target:'_blank',
            id:'from_rpt'}
          );
          html2canvas(document.querySelector("#container-graf")).then(function(canvas) {
          var imgData = canvas.toDataURL('image/png');
       // form.append('image', imgData);
        form.append( $("<input>", { type :'hidden', id  :  'image',  name :'image',  value:  imgData }));
        form.append( $("<input>", { type :'hidden', id  :  'id_evdo_rpt',  name :'id_evdo_rpt',  value:  $("#lb_code_evaluado").html() } ));
        form.append( $("<input>", { type :'hidden', id  :  'eval_id_rpt',  name :'eval_id_rpt',  value:  $("#eval_id").val() } ));
        form.append( $("<input>", { type :'hidden', id  :  'estatus_rpt',  name :'estatus_rpt',  value:  $('#estatus').val() } ));
        form.append('@csrf');
        $("#rpt").append(form);
        from_rpt.submit();
      });
      
    }
   /* function generarPdf() {
            // Capturar la imagen de la gráfica con html2canvas
            html2canvas(document.querySelector("#container-graf")).then(function(canvas) {
                // Convertir el canvas a una imagen base64
                var imgData = canvas.toDataURL('image/png');

                // Enviar la imagen al servidor para generar el PDF
                var formData = new FormData();
                formData.append('image', imgData);
                formData.append('id_evdo_rpt', $("#lb_code_evaluado").html());
                formData.append('eval_id_rpt', $("#eval_id").val());
                formData.append('estatus_rpt', $('#estatus').val());

                // Enviar la solicitud al servidor
                fetch("{{ route('evaluacion.print') }}", {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.blob())
                .then(blob => {
                    // Crear un enlace para descargar el PDF
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement("a");
                    a.href = url;
                    a.download = "grafica.pdf";
                    a.click();
                });
            });
        }*/
  function leermas(idcomp)
  { $('#leermas_competencia').html('');
    $('#leermas_definicion').html('');
    $('#leermas_nivel_alto').html('');
    $('#leermas_nivel_bajo').html('');
    var _token = $('input[name="_token"]').val();
    var parametros = {
    "idcomp":idcomp,
    "_token": _token};
        $.ajax({
          data:  parametros, 
          url:   "{{ route('evaluacion.leermas') }}",
          type:  'POST', 
          cache: false,    
          dataType: "json",      
          success:  function (data) { 
            jQuery(data).each(function(i, item){
              $('#leermas_competencia').html(item.nombre);
              $('#leermas_definicion').html(item.definicion);
              $('#leermas_nivel_alto').html(item.nivel_alto);
              $('#leermas_nivel_bajo').html(item.nivel_bajo);
             }); 
          }
        });
        $("#leermas").modal('toggle');
    }

    function nuevoAjax(xmlhttp){
 
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (e) {
            xmlhttp = false;
        }
    }
    if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
    }
    
</script>
