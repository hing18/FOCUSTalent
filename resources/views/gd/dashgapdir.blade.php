<!DOCTYPE html>
@extends('layouts.plantilla')
@section('title','GAP de Desarrollo por Dirección')
<script src="{{ asset('assets/js/code/highcharts.js')}}"></script>
<script src="{{ asset('assets/js/code/highcharts-more.js')}}"></script>
<script src="https://code.highcharts.com/modules/polar.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

@section('content')
<!-- JavaScript -->
    <script type="text/javascript">
        function preloader(){
            document.getElementById("preload").style.display = "none";
            document.getElementById("iframe").style.display = "block";
        }
        window.onload = preloader;
    </script>

<style>
    .circle {
        width: 35px; /* Tamaño del círculo */
        height: 35px; /* Tamaño del círculo */
        display: flex; /* Usar Flexbox para centrar el contenido */
        justify-content: center; /* Centrar horizontalmente */
        align-items: center; /* Centrar verticalmente */
        color: white; /* Color del icono */
    } 
        /* Estilo específico solo para las tarjetas con la clase 'card-hover-effect' */
    .card-hover-effect:hover {
        transform: scale(1.05); /* Agranda la tarjeta un 5% */
        transition: transform 0.3s ease; /* Transición suave */
        cursor: pointer; /* Cambia el cursor a puntero */
    }

    /* Si deseas también cambiar la sombra al pasar el mouse */
    .card-hover-effect:hover {
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.15); /* Aumenta la sombra al pasar el mouse */
    }
</style>


    <small>
      <div id="preload" class="align-items-center justify-content-center text-center p-4 mt-4"><div class=" mt-4 spinner-border text-primary" role="status"></div></div>
    </small>
    <div id="iframe" style="display: none;">        
        <div class="pagetitle pb-0 mb-0">
          <div class="row pb-0 mb-0">
            <div class="col-8 my-0 py-0">
              <h1 class="text-secondary">Gap de Desarrollo por Unidad</h1>
              <nav>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"style="font-weight: normal;">Evaluación y Desarrollo</li>
                  <li class="breadcrumb-item" style="color: #4B6EAD">GAP <span id="ano"></span></li>
                </ol>
              </nav>
            </div>
            <div class="col-4 my-0 py-0 d-flex align-items-center justify-content-end">
              <span style="cursor: pointer;" class="fw-bold text-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Qué es el GAP <i class="ps-1 fas fa-question-circle fa-lg"></i>
              </span>
            </div>
          </div>
        </div>        
        <div class="row mb-2">
            <div class="col-12 col-md-4">
                <select class="form-select form-select-sm" id="codeund" onchange="gapund(this)">
                    <option value="-" selected>Seleccionar Unidad</option>
                    @php
                        $grupo = null; // Variable para almacenar el grupo actual
                    @endphp
                    @foreach($rsdir as $data)
                        @if ($grupo != $data->grupo)
                            @if ($grupo != null)
                                </optgroup> <!-- Cierra el optgroup anterior si el grupo cambia -->
                            @endif
                            <optgroup label="{{ $data->grupo }}"> <!-- Abre un nuevo optgroup -->
                            @php
                                $grupo = $data->grupo; // Actualiza el grupo actual
                            @endphp
                        @endif
                        <option value="{{ $data->codigo }}-{{ $data->tipo }}">{{ $data->nameund }}</option> <!-- Agrega una opción -->
                    @endforeach
                    @if ($grupo != null)
                        </optgroup> <!-- Cierra el último optgroup abierto -->
                    @endif
                </select>
            </div>
        </div>
        <hr class="mt-0"> 
        <div class="d-flex justify-content-center align-items-center visually-hidden" style="height: 50vh;" id="div_spinner">
          <div class="spinner-border text-primary me-2" role="status"></div>
          <span class="small">Cargando...</span>
        </div>
        <div id="dash" class="visually-hidden">          
          <div class="pagetitle mt-4">
            <h5 class="text-secondary"><span id="nom_unidad"></span></h5>
          </div><!-- End Page Title -->
              <div class="row mb-0 pb-0 row-cols-5">
                <!--- COEFICIENTE INTELECTUAL-->
                <div class="col pe-1 py-0">
                  <div class="card ps-1 pe-1">
                    <div class="card-body py-1">
                      <div class="row">
                        <div  class=" mt-1 circle rounded-circle bg-primary">
                          <i class="fas fa-brain fa-lg"></i>
                        </div>
                          <div class="mt-1 col text-secondary text-left py-0"><span class="h4 fw-bold" id="gap_sec_ci_1">-</span><div style="font-size: 9px">GAP</div></div>              
                          <div class="text-primary text-center py-0" style="font-size: 12px">COEF. INTELECTUAL - 20%</div>       
                      </div>         
                          <div class="progress" style="height: 5px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100" id="barra_ci_1"></div>
                          </div>
                          <div class="text-center text-secondary" style="font-size: 10px"><span id="gap_sec_cump_ci_1">0</span>% Cumplimiento</div>
                    </div>
                  </div>
                </div>
             
                <!--- NIVEL ACADÉMICO-->
                <div class="col pe-1">
                  <div class="card ps-1 pe-1">
                    <div class="card-body py-1">
                      <div class="row">
                        <div class=" mt-1 circle rounded-circle bg-success">
                          <i class="fas fa-user-graduate fa-lg"></i>
                        </div>
                        <div class="mt-1 col text-secondary text-left py-0"><span class="h4 fw-bold" id="gap_sec_na_1">-</span><div style="font-size: 9px">GAP</div></div>             
                          <div class="text-success text-center py-0" style="font-size: 12px">NIVEL ACADÉMICO - 20%</div>       
                      </div>         
                          <div class="progress" style="height: 5px;">
                            <div class="bg-success progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100" id="barra_na_1"></div>
                          </div>
                          <div class="text-center text-secondary" style="font-size: 9px"><span id="gap_sec_cump_na_1">0</span>% Cumplimiento</div>
                    </div>
                  </div>
                </div>     
             
                <!--- COMPETENCIAS-->
                <div class="col pe-1">
                  <div class="card ps-1 pe-1">
                    <div class="card-body py-1">
                      <div class="row">
                        <div class=" mt-1 circle rounded-circle bg-info">
                          <i class="fas fa-list-ol fa-lg"></i>
                        </div>
                          <div class="mt-1 col text-secondary text-left py-0"><span class="h4 fw-bold" id="gap_sec_com_1">-</span><div style="font-size: 9px">GAP</div></div>              
                          <div class="text-info text-center py-0" style="font-size: 12px">COMPETENCIAS - 30%</div>       
                      </div>         
                          <div class="progress" style="height: 5px;">
                            <div class="bg-info progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" id="barra_com_1"></div>
                          </div>
                          <div class="text-center text-secondary" style="font-size: 9px"><span id="gap_sec_cump_com_1">0</span>% Cumplimiento</div>
                    </div>
                  </div>
                </div> 
             
                <!--- HABILIDADES-->
                <div class="col pe-1">
                  <div class="card ps-1 pe-1">
                    <div class="card-body py-1">
                      <div class="row">
                        <div class=" mt-1 circle rounded-circle bg-warning">
                          <i class="fas fa-user-tag fa-lg"></i>
                        </div>
                          <div class="mt-1 col text-secondary text-left py-0"><span class="h4 fw-bold" id="gap_sec_hab_1">-</span><div style="font-size: 9px">GAP</div></div>               
                          <div class="text-warning text-center py-0" style="font-size: 12px">HABILIDADES - 30%</div>       
                      </div>         
                          <div class="progress" style="height: 5px;">
                            <div class="bg-warning progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" id="barra_hab_1"></div>
                          </div>
                          <div class="text-center text-secondary" style="font-size: 9px"><span id="gap_sec_cump_hab_1">0</span>% Cumplimiento</div>
                    </div>
                  </div>
                </div> 
             
                <!--- GAP TOTAL -->
                <div class="col pe-1">
                  <div class="card ">
                    <div class="card-body py-1">
                      <div class="row">
                        <div class=" mt-1 circle rounded-circle bg-danger">
                          <i class="fas fa-user-cog fa-lg"></i>
                        </div>
                          <div class="mt-1 col text-secondary text-left py-0"><span class="h4 fw-bold" id="gap_sec_gap_1">-</span><div style="font-size: 9px">GAP</div></div>              
                          <div class="text-danger text-center py-0" style="font-size: 12px">GAP TOTAL</div>       
                      </div>         
                          <div class="progress" style="height: 5px;">
                            <div class="bg-danger progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" id="barra_gap_1"></div>
                          </div>
                          <div class="text-center text-secondary" style="font-size: 9px"><span id="gap_sec_cump_gap_1">0</span>% Cumplimiento</div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row m-0 p-0">
                <div class="col-8 m-0 p-0">
                  <div class="card m-0">
                    <div class="card-body p-0">
                      <h5 class="card-title text-secondary ms-4 text-uppercase"style="font-size: 15px">GAP de cada Variable por Jerarquías</h5>
                      <div id="container" style="height: 350px;" class="p-4"></div>
                    </div>
                  </div>
                </div>
                
                <div class="col-4 m-0 ">
                  <div class="card">
                    <div class="card-body p-0">              
                      <small>
                        <h5 class="card-title text-secondary ms-3 text-uppercase"style="font-size: 15px">Distribución del GAP por Jerarquía</h5>
                        <div id="container_jer" style="height: 350px;font-size: 10px" class="p-4"></div>
                      </small>
                    </div>
                  </div>
                </div>
              </div>


 
              <div class="card pt-4">
                <div class="card-body small"> 
                  <small>
                    <table class="table table-sm small table-striped-columns table-hover mx-auto" style="width: 90%">
                      <thead>
                        <tr class="fw-bold">
                          <td class="table-primary text-center" style="color: #4B6EAD; ">Jerarquías</td>
                          <td class="table-primary text-center" style="color: #4B6EAD; ">Coef. Intelectual</td>
                          <td class="table-primary text-center" style="color: #4B6EAD; ">Niv. Académico</td>
                          <td class="table-primary text-center" style="color: #4B6EAD; ">Competencias</td>
                          <td class="table-primary text-center" style="color: #4B6EAD; ">Habilidades</td>
                          <td class="table-primary text-center fw-bold" style="color: #4B6EAD; ">GAP TOTAL</td>
                        </tr>
                        </thead>
                        <tbody id="tbody_1"> </tbody>
                        <thead>
                          <tr class="text-center table-primary">
                            <th class="table-primary" style="color: #4B6EAD">GAP TOTAL</th>
                            <th style="color: #4B6EAD"><span id="totci_1"></span>%</th>
                            <th style="color: #4B6EAD"><span id="totna_1"></span>%</th>
                            <th style="color: #4B6EAD"><span id="totcom_1"></span>%</th>
                            <th style="color: #4B6EAD"><span id="tothab_1"></span>%</th>
                            <th style="color: #4B6EAD"><span id="tot_1"></span>%</th>
                          </tr>
                        </thead>
                    </table>
                  </small>
                </div>
              </div>

              <div class="pagetitle pt-4 pb-0 mb-0">
                <div class="row pb-0 mb-0">
                  <div class="col-8 my-0 py-0">
                    <h1 class="text-secondary">Gap Individual</h1>
                    <nav>
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"style="font-weight: normal;">Evaluación y Desarrollo</li>
                        <li class="breadcrumb-item" style="color: #4B6EAD">GAP <span id="ano2"></span></li>
                      </ol>
                    </nav>
                  </div>
                </div>
              </div> 

               <div class="pt-0 mt-0" id="list_colab">

            </div>                     
              

      </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Modal PID -->
    <div class="modal fade" id="examplepid"  aria-labelledby="exampleModalpid" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header py-1">
            <h5 class="modal-title" id="exampleModalpid">
              <span class="text-sm-end fw-bold text-secondary"><i class="fa-solid fa-id-card fa-lg text-primary"></i> GAP </span>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-4">

                <div class="card position-relative shadow mb-3"  style="border-radius: 10px; display: flex; flex-direction: column;">
                  <div class="position-absolute top-0 start-0 w-100" style="background-color: #4B6EAD; height: 50%; z-index: 0; border-top-left-radius: 10px; border-top-right-radius: 10px;"></div>
                  <div class="d-flex justify-content-center pt-3" style="z-index: 1;" id="pho_pid">
                    <img src="storage/profiles/photo/el.png" class="card-img-top rounded-circle bg-white" alt="..." style="width: 150px; height: 150px; object-fit: cover; border: 5px solid #4B6EAD;">
                  </div>     
                  <div class="card-body d-flex flex-column pt-0" style="flex-grow: 1;">
                    <!-- Información debajo de la imagen -->
                    <div class="text-center fw-bold" style="color: #4B6EAD; font-size: 14px;" id="nom_pid"></div>
                    <div class="text-center small text-secondary" id="pue_pid"></div>
                    <div class="text-center small" style="font-size: 11px; color:#4B6EAD;" id="uni_pid"></div>
                  </div>
                </div>

                <small>
                                             
                  <!--- COEF. INTELECTUAL -->
                  <div class="d-flex justify-content-center align-items-center" style="margin-top: 20px !important; margin-bottom: 20px;">  
                    <div class="col-8">
                      <div class="row  border border-primary bg-white" style="height: 34px; position: relative; border-bottom-left-radius: 50px; border-top-left-radius: 50px; border-bottom-right-radius: 20px; border-top-right-radius: 20px;">
                        <div class="col-2 ms-0 ps-0">
                          <div class="bg-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 32px; height: 32px; color: white; position: absolute;">
                            <i class="fas fa-brain fa-lg"></i>
                          </div>
                        </div>
                        <div class="col-10 d-flex justify-content-center align-items-center fw-bold">
                          <div class="col-9 text-secondary ps-0" style="font-size: 12px;">COEF. INTELECTUAL</div>
                          <div class="col-3 text-secondary text-end"  style="font-size: 16px;"><span id="ci_pid"></span></div>
                        </div>
                      </div>  
                    </div>
                  </div>
  
                  <!--- NIVEL ACADÉMICO -->
                  <div class="d-flex justify-content-center align-items-center" style="margin-top: 0 !important; margin-bottom: 20px;">  
                    <div class="col-8">
                      <div class="row  border border-success bg-white" style="height: 34px; position: relative; border-bottom-left-radius: 50px; border-top-left-radius: 50px; border-bottom-right-radius: 20px; border-top-right-radius: 20px;">
                        <div class="col-2 ms-0 ps-0">
                          <div class="bg-success rounded-circle d-flex justify-content-center align-items-center" style="width: 32px; height: 32px; color: white; position: absolute;">
                            <i class="fas fa-user-graduate fa-lg"></i>
                          </div>
                        </div>
                        <div class="col-10 d-flex justify-content-center align-items-center fw-bold">
                          <div class="col-9 text-secondary ms-0" style="font-size: 12px;">NIVEL ACADÉMICO</div>
                          <div class="col-3 text-secondary text-end" style="font-size: 16px;"><span id="na_pid"></span></div>
                        </div>
                      </div>  
                    </div>
                  </div>
  
                  <!--- COMPETENCIAS -->
                  <div class="d-flex justify-content-center align-items-center" style="margin-top: 0 !important; margin-bottom: 20px;">  
                    <div class="col-8">
                      <div class="row  border border-info bg-white" style="height: 34px; position: relative;border-bottom-left-radius: 50px; border-top-left-radius: 50px; border-bottom-right-radius: 20px; border-top-right-radius: 20px;">
                        <div class="col-2 ms-0 ps-0">
                          <div class="bg-info rounded-circle d-flex justify-content-center align-items-center" style="width: 32px; height: 32px; color: white; position: absolute;">
                            <i class="fas fa-list-ol fa-lg"></i>
                          </div>
                        </div>
                        <div class="col-10 d-flex justify-content-center align-items-center fw-bold">
                          <div class="col-9 text-secondary ms-0" style="font-size: 12px;">COMPETENCIAS</div>
                          <div class="col-3 text-secondary text-end" style="font-size: 16px;"><span id="com_pid"></span></div>
                        </div>
                      </div>         
                    </div>
                  </div>
  
                  <!--- HABILIDADES -->
                  <div class="d-flex justify-content-center align-items-center" style="margin-top: 0 !important; margin-bottom: 20px;">  
                    <div class="col-8">
                      <div class="row  border border-warning bg-white" style="height: 34px; position: relative;border-bottom-left-radius: 50px; border-top-left-radius: 50px; border-bottom-right-radius: 20px; border-top-right-radius: 20px;">
                        <div class="col-2 ms-0 ps-0">
                          <div class="bg-warning rounded-circle d-flex justify-content-center align-items-center" style="width: 32px; height: 32px; color: white; position: absolute;">
                            <i class="fas fa-user-tag fa-lg"></i>
                          </div>
                        </div>
                        <div class="col-10 d-flex justify-content-center align-items-center fw-bold">
                          <div class="col-9 text-secondary ms-0" style="font-size: 12px;">HABILIDADES</div>
                          <div class="col-3 text-secondary text-end" style="font-size: 16px;"><span id="hab_pid"></span></div>
                        </div>
                      </div>         
                    </div>
                  </div>
  
                    <!--- GAP TOTAL -->
                  <div class="d-flex justify-content-center align-items-center" style="margin-top: 0 !important; margin-bottom: 10px;">  
                    <div class="col-8">
                      <div class="row border border-danger bg-white" style="height: 34px; position: relative;border-bottom-left-radius: 50px; border-top-left-radius: 50px; border-bottom-right-radius: 20px; border-top-right-radius: 20px;">
                        <div class="col-2 ms-0 ps-0">
                          <div class="bg-danger rounded-circle d-flex justify-content-center align-items-center" style="width: 32px; height: 32px; color: white; position: absolute;">
                            <i class="fas fa-user-cog fa-lg"></i>
                          </div>
                        </div>
                        <div class="col-10 d-flex justify-content-center align-items-center fw-bold">
                          <div class="col-9 text-secondary ms-0" style="font-size: 12px;">GAP TOTAL</div>
                          <div class="col-3 text-secondary text-end" style="font-size: 16px;"><span id="gap_pid"></span></div>
                        </div>
                      </div>         
                    </div>
                  </div>
  
                </small>
  
              </div>
              <div class="col-8">           
                <div class="pagetitle pb-0 mb-0">
                  <div class="row pb-0 mb-0">
                    <div class="col-8 my-0 py-0">
                      <h5 class="text-secondary">Competencias</h5>
                      <nav>
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item"style="font-weight: normal;">Perfil del puesto vs. Perfil de persona</li>
                        </ol>
                      </nav>
                    </div>
                  </div>
                </div>
                <div class="row small pb-1">
                  <div class="col-4 text-center fw-bold"style="color: #4B6EAD">CRÍTICAS</div>
                  <div class="col-4 text-center fw-bold"style="color: #4B6EAD">MUY IMPORTANTES</div>
                  <div class="col-4 text-center fw-bold"style="color: #4B6EAD">IMPORTANTES</div>
                </div>
                <div class="row">
                  <div class="col-4" id="comp_cri"></div>
                  <div class="col-4" id="comp_imp"></div>
                  <div class="col-4" id="comp_mimp"></div>
                </div>              
                <div id="container_area"></div>
              </div>
            </div>
            <div class="row d-flex justify-content-center align-items-center pb-4">
              <div class="col-11 ">
                <small>
                  <div id="div_gap_comp" class="visually-hidden">
                    <hr>
                    <h5 class="ps-2" style="color: #4B6EAD">Competencias de mayor GAP</h5>  
                    <div class="row ps-4">               
                      <ul class="list-unstyled ps-4 text-justify" id="comp_mayorgap"></ul>
                    </div>
                  </div>
                  <div id="div_pid">
                    <hr>
                    <h5 class="ps-2" style="color: #4B6EAD">Plan Individual de Desarrollo</h5>
                    <div id="div_pid_cursos_com" class="visually-hidden">
                      <div class="row ps-4">                        
                        <div class="col-8 text-center text-secondary">
                          <b >Cursos Asignados</b>
                        </div>
                        <div class="col-4 text-center text-secondary">
                          <b >Fecha</b>
                        </div>
                      </div>
                      <div class="row ps-4" id="curso_pid"></div>
                    </div>             
  
                    <div id="div_ad" class="visually-hidden">                            
                      <div class="row ps-4 pt-2">                       
                        <div class="col-4 text-center text-secondary">
                          <b >Área de Desarrollo</b>
                        </div>
                        <div class="col-4 text-center text-secondary">
                          <b >Curso Asignado</b>
                        </div>
                        <div class="col-4 text-center text-secondary">
                          <b >Acciones Específicas</b>
                        </div>
                      </div>
                      <div class="row ps-4" id="curso_pid_ad"></div>
                    </div>
                  </div>
                </small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal que es GAP -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              <span class="text-sm-end fw-bold text-primary">¿Qué es el GAP <i class="ps-1 fas fa-question-circle"></i></span>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body bg-light">

            <!-- Alerta de información -->
            <div class="alert alert-primary d-flex align-items-center" role="alert">
              <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                <use xlink:href="#info-fill" />
              </svg>
              <div>
                GAP es la brecha de desviación del perfil del puesto vs. perfil de la persona.
              </div>
            </div>

            <!-- Imagen de variables y su peso -->
            <div class="row mb-4">
              <div class="col-12 text-center" style="color: #4B6EAD">
                <h5>Peso % de cada variable</h5>
                <p class="text-start text-secondary">En la Organización, el GAP está compuesto de las siguientes variables con sus respectivos pesos en porcentajes.</p>
                <img src="{{ asset('assetsw/img/variables.jpg') }}" width="100%" alt="Imagen que muestra las variables y su peso en el GAP">
                <p class="text-start text-secondary mt-2">La medida estándar del % de GAP en la industria de Retail es menor o igual a 20%</p>
              </div>
            </div>

            <hr>

            <!-- Consideraciones Claves -->
            <div class="pagetitle">
              <nav>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item" style="color: #4B6EAD">CONSIDERACIONES CLAVES</li>
                </ol>
              </nav>
            </div>

            <div class="row small">
              <!-- Impacto en el servicio al cliente -->
              <div class="col-sm-6 d-flex mb-3">
                <div class="card p-1 flex-fill">
                  <div class="card-body py-1">
                    <h5 class="mb-2" style="color: #4B6EAD">
                      <i class="bi bi-1-circle-fill pe-2 text-primary"></i> Impacto en el servicio al Cliente
                    </h5>
                    <ul class="list-unstyled ms-3 text-justify">
                      <li><i class="bi bi-check-circle text-primary"></i> <span class="text-secondary">Un GAP mayor puede significar que el empleado no está completamente preparado para cumplir con las expectativas del puesto, lo que podría afectar negativamente la experiencia del cliente.</span></li>
                      <li><i class="bi bi-check-circle text-primary"></i> <span class="text-secondary">En retail, la atención al cliente, el conocimiento del producto y la eficiencia en las operaciones son cruciales.</span></li>
                    </ul>
                  </div>
                </div>
              </div>

              <!-- Formación y Desarrollo -->
              <div class="col-sm-6 d-flex mb-3">
                <div class="card p-1 flex-fill">
                  <div class="card-body py-1">
                    <h5 class="mb-2" style="color: #4B6EAD">
                      <i class="bi bi-2-circle-fill pe-2 text-primary"></i> Formación y Desarrollo
                    </h5>
                    <ul class="list-unstyled ms-3 text-justify">
                      <li><i class="bi bi-check-circle text-primary"></i> <span class="text-secondary">Un GAP del 20% o menos indica que las deficiencias pueden ser abordadas con formación y desarrollo continuos.</span></li>
                      <li><i class="bi bi-check-circle text-primary"></i> <span class="text-secondary">La inversión en capacitación puede ayudar a cerrar las brechas más rápidamente.</span></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <div class="row small">
              <!-- Adaptabilidad y Potencial para el Crecimiento -->
              <div class="col-sm-6 d-flex mb-3">
                <div class="card p-1 flex-fill">
                  <div class="card-body py-1">
                    <h5 class="mb-2" style="color: #4B6EAD">
                      <i class="bi bi-3-circle-fill pe-2 text-primary"></i> Adaptabilidad y Potencial para el Crecimiento
                    </h5>
                    <ul class="list-unstyled ms-3 text-justify">
                      <li><i class="bi bi-check-circle text-primary"></i> <span class="text-secondary">Evaluar no solo el GAP actual, sino también el potencial del empleado para aprender y adaptarse.</span></li>
                      <li><i class="bi bi-check-circle text-primary"></i> <span class="text-secondary">Un empleado con un GAP ligeramente mayor, pero con alto potencial de desarrollo podría ser una mejor inversión a largo plazo.</span></li>
                    </ul>
                  </div>
                </div>
              </div>

              <!-- Monitoreo y Evaluación continua -->
              <div class="col-sm-6 d-flex mb-3">
                <div class="card p-1 flex-fill">
                  <div class="card-body py-1">
                    <h5 class="mb-2" style="color: #4B6EAD">
                      <i class="bi bi-4-circle-fill pe-2 text-primary"></i> Monitoreo y Evaluación continua
                    </h5>
                    <ul class="list-unstyled ms-3 text-justify">
                      <li><i class="bi bi-check-circle text-primary"></i> <span class="text-secondary">Realizar evaluaciones periódicas para asegurar que las brechas se estén cerrando y el rendimiento esté mejorando.</span></li>
                      <li><i class="bi bi-check-circle text-primary"></i> <span class="text-secondary">Ajustar los planes de desarrollo según sea necesario para abordar áreas específicas de mejora.</span></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
      <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
      </symbol>
      <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
      </symbol>
      <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
      </symbol>
    </svg>
    
<script>
      function gapund(selectElement) {
          var selectedValue = selectElement.value;
          $('#ano').html('');$('#ano2').html('');
          $('#nom_unidad').html('');
          $('#dash').addClass('visually-hidden');
      
          // Verificar si el valor seleccionado no es '-'
          if (selectedValue != '-') {
              var _token = $('input[name="_token"]').val();
              var parametros = {
                  "selectedValue": selectedValue,
                  "_token": _token
              };
      
              $.ajax({
                  data: parametros,
                  url: "{{ route('gapunidad.show') }}",  // Asegúrate de que esta ruta sea correcta
                  type: 'POST',
                  dataType: "json",
                  cache: true,
                  beforeSend: function () {
                      $('#div_spinner').removeClass('visually-hidden'); // Muestra el spinner
                  },
                  success: function (response) {
                      var id_eval=response.id_eval
                      // Inicializando las variables de totales
                      var totalCoefInt = 0;
                      var totalNivelAcad = 0;
                      var totalCompetencias = 0;
                      var totalHabilidades = 0;
                      var totalGap = 0;
                      var totalRows = 0;
      
                      // Ocultar el spinner cuando termine la carga
                      $('#div_spinner').addClass('visually-hidden');
      
                      // Verificar si 'response.gapund' es un arreglo válido
                      if (Array.isArray(response.gapund)) {
      
                          $('#dash').removeClass('visually-hidden'); // Mostrar los datos
                          $.each(response.gapund, function (i, item) {
                              totalCoefInt += parseFloat(item.COEFICIENTE_INTELECTUAL);
                              totalNivelAcad += parseFloat(item.NIVEL_ACADEMICO);
                              totalCompetencias += parseFloat(item.COMPETENCIAS);
                              totalHabilidades += parseFloat(item.HABILIDADES);
                              totalGap += parseFloat(item.GAP);
                              totalRows++;
                          });
      
                          // Evitar división por cero si no hay filas
                          if (totalRows > 0) {
                              $('#gap_sec_ci_1').html((totalCoefInt / totalRows).toFixed(1) + '%');  // Promedio de Coef. Intelectual
                              $('#gap_sec_na_1').html((totalNivelAcad / totalRows).toFixed(1) + '%'); // Promedio de Nivel Académico
                              $('#gap_sec_com_1').html((totalCompetencias / totalRows).toFixed(1) + '%'); // Promedio de Competencias
                              $('#gap_sec_hab_1').html((totalHabilidades / totalRows).toFixed(1) + '%'); // Promedio de Habilidades
                              $('#gap_sec_gap_1').html((totalGap / totalRows).toFixed(1) + '%'); // Promedio de GAP
      
                              // Cálculo de cumplimientos y actualización de barras
                              $('#gap_sec_cump_ci_1').html((100 - (totalCoefInt / totalRows).toFixed(1)));
                              $('#gap_sec_cump_na_1').html((100 - (totalNivelAcad / totalRows).toFixed(1)));
                              $('#gap_sec_cump_com_1').html((100 - (totalCompetencias / totalRows).toFixed(1)));
                              $('#gap_sec_cump_hab_1').html((100 - (totalHabilidades / totalRows).toFixed(1)));
                              $('#gap_sec_cump_gap_1').html((100 - (totalGap / totalRows).toFixed(1)));
      
                              // Actualización de las barras
                              $('#barra_ci_1').css("width", (100 - (totalCoefInt / totalRows)).toFixed(1) + '%');
                              $('#barra_na_1').css("width", (100 - (totalNivelAcad / totalRows)).toFixed(1) + '%');
                              $('#barra_com_1').css("width", (100 - (totalCompetencias / totalRows)).toFixed(1) + '%');
                              $('#barra_hab_1').css("width", (100 - (totalHabilidades / totalRows)).toFixed(1) + '%');
                              $('#barra_gap_1').css("width", (100 - (totalGap / totalRows)).toFixed(1) + '%');
      
                              $('#totci_1').html((totalCoefInt / totalRows).toFixed(1));  // Promedio de Coef. Intelectual
                              $('#totna_1').html((totalNivelAcad / totalRows).toFixed(1)); // Promedio de Nivel Académico
                              $('#totcom_1').html((totalCompetencias / totalRows).toFixed(1)); // Promedio de Competencias
                              $('#tothab_1').html((totalHabilidades / totalRows).toFixed(1)); // Promedio de Habilidades
                              $('#tot_1').html((totalGap / totalRows).toFixed(1)); // Promedio de GAP



                          } else {
                              // En caso de que no haya datos
                              $('#nom_unidad').html("No se han realizado evaluaciones en esta unidad.");
                              clean(); // Limpiar los valores anteriores
                          }
      
                          // Mostrar año y nombre de unidad si están disponibles en la respuesta
                          if (response.ano) {
                              $('#ano').html(response.ano);
                              $('#ano2').html(response.ano);
                          } else {
                              $('#ano').html("No disponible");
                              $('#ano2').html("No disponible");
                          }
      
                          if (response.unidad) {
                              $('#nom_unidad').html(response.unidad);
                          } else {
                              $('#nom_unidad').html("No disponible");
                          }
      
                      } else {
                          // Si 'gapund' no es un arreglo
                          $('#nom_unidad').html("No se han realizado evaluaciones en esta unidad.");
                          clean();
                      }
                    // Crear las filas de la tabla dinámicamente
                    let fila = "";
                    //let totalCoefInt = 0, totalNivelAcad = 0, totalCompetencias = 0, totalHabilidades = 0, totalGap = 0;
                    tot_pendiente = 0;
                    tot_proceso = 0;
                    tot_evaluado = 0;
                    tot_rechazado = 0;
                    let v_jer = [];
                    let v_ci = [];
                    let v_na = [];
                    let v_com = [];
                    let v_hab = [];
                    let v_gap = [];
                    jQuery(response.gapundjer).each(function(i, item){                         
                      v_jer.push(item.jerarquia);                   
                      v_ci.push(Number(item.gap_ci));   
                      v_na.push(Number(item.gap_na)); 
                      v_com.push(Number(item.gap_com));    
                      v_hab.push(Number(item.gap_hab)); 
                      v_gap.push(Number(item.tot_gap)); 

                          fila += `<tr>
                            <td class="ps-2">${item.jerarquia}</td>
                            <td class="text-center">${parseFloat(item.gap_ci).toFixed(1)}%</td>
                            <td class="text-center">${parseFloat(item.gap_na).toFixed(1)}%</td>
                            <td class="text-center">${parseFloat(item.gap_com).toFixed(1)}%</td>
                            <td class="text-center">${parseFloat(item.gap_hab).toFixed(1)}%</td>
                            <td class="text-center fw-bold"  style="color: #4B6EAD">${parseFloat(item.tot_gap).toFixed(1)}%</td>
                          </tr>`;
                          
                          // Sumar los valores para los totales
                          totalCoefInt += parseFloat(item.gap_ci);
                          totalNivelAcad += parseFloat(item.gap_na);
                          totalCompetencias += parseFloat(item.gap_com);
                          totalHabilidades += parseFloat(item.gap_hab);
                          totalGap += parseFloat(item.tot_gap);
                      });
                      $("#tbody_1").html(fila);

                      // Redondear los valores de los arrays a 1 decimal
                      v_ci = v_ci.map(item => parseFloat(item.toFixed(1)));
                      v_na = v_na.map(item => parseFloat(item.toFixed(1)));
                      v_com = v_com.map(item => parseFloat(item.toFixed(1)));
                      v_hab = v_hab.map(item => parseFloat(item.toFixed(1)));
                      v_gap = v_gap.map(item => parseFloat(item.toFixed(1)));
                                      
                      Highcharts.setOptions({
                        accessibility: {
                          enabled: false  // Disable accessibility
                        }
                      });

                      Highcharts.chart('container', {
                          title: {
                              text: null
                          },
                          xAxis: {
                              categories: v_jer
                          },
                          yAxis: {
                              title: {
                                  text: null
                              },
                              labels: {
                                  enabled: false  // Desactivar la escala del eje Y
                              }
                          },
                          tooltip: {
                              valueSuffix: null
                          },
                          plotOptions: {
                              series: {
                                  borderRadius: '25%',
                                  dataLabels: {
                                      enabled: true,
                                      format: '{point.y} {point.percentage:.1f}%',
                                      style: {
                                          fontSize: '12px',
                                          fontWeight: 'bold'
                                      }
                                  }
                              }
                          },
                          series: [{
                              type: 'column',
                              name: 'COEF. INTELECTUAL',
                              color: '#004080', // Dark blue
                              data: v_ci
                          }, {
                              type: 'column',
                              name: 'NIVEL ACADÉMICO',
                              color: '#0066cc', // Medium blue
                              data: v_na
                          }, {
                              type: 'column',
                              name: 'COMPETENCIAS',
                              color: '#3399ff', // Light blue
                              data: v_com
                          }, {
                              type: 'column',
                              name: 'HABILIDADES',
                              color: '#66ccff', // Very light blue
                              data: v_hab
                          }]
                      });
                      
                      Highcharts.chart('container_jer', {
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: null
                        },
                        subtitle: {
                            text: null
                        },
                        xAxis: {
                            categories: v_jer,
                            title: {
                                text: null
                            },
                            gridLineWidth: 1,
                            lineWidth: 0,
                            labels: {
                                style: {
                                    fontSize: '11px',  // Ajusta el tamaño de la fuente aquí
                                    fontFamily: 'Arial',  // Opcional: cambia la familia de la fuente si lo deseas
                                    fontWeight: 'normal'  // Opcional: cambia el peso de la fuente
                                }
                            }
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: null,
                            },
                            labels: {
                                overflow: 'justify'
                            },
                            gridLineWidth: 0
                        },
                        tooltip: {
                            valueSuffix: '%'
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: '30%',
                                dataLabels: {
                                    enabled: true,  // Habilitar las etiquetas de datos
                                    formatter: function() {
                                      return this.y.toFixed(1) + '%';  // Redondear a un decimal
                                    },
                                    style: {
                                        
                                        color: '#000000',  // Cambia el color del texto si lo deseas
                                    }
                                },
                                groupPadding: 0.1
                            }
                        },
                        credits: {
                            enabled: false
                        },
                        series: [{
                            name: 'GAP',
                            data: v_gap

                        }]
                      });

                      let jerarquia = ""; // Inicializar jerarquía fuera del ciclo
                      $('#list_colab').html(''); // Limpiar el contenido al inicio
                      let gr = 0; // Contador de grupos

                      jQuery(response.colab).each(function(i, item) {  
                        // Si la jerarquía cambia, cerramos la fila anterior y abrimos una nueva
                        if (jerarquia !== item.jerarquia) { 
                            jerarquia = item.jerarquia; // Actualiza la jerarquía
                            gr++; // Incrementar el grupo
                            // Agregar un nuevo título de jerarquía y la fila correspondiente
                            $('#list_colab').append('<hr><h5 class="pb-2 text-secondary">' + jerarquia + '</h5><div class="row row-cols-1 row-cols-md-4 g-3 d-flex justify-content-center" id="grupo_' + gr + '"></div>');
                        }
                        let photo;
                        jQuery(response.photos).each(function(x, item2) { 
                          if(item2.id_ivaluado==item.id_evaluado)
                          photo=item2.photo;
                        });
                        // Agregar la tarjeta dentro de la fila correspondiente
                        $('#grupo_' + gr).append(
                        '<div class="col-4 my-1">' +
                            '<div class="card position-relative shadow my-2 card-hover-effect" onclick="wpid(' + id_eval + ',' + item.id_evaluado + ')"  data-bs-toggle="modal" data-bs-target="#examplepid" style="border-radius: 20px; height: 340px; display: flex; flex-direction: column;">' +
                                '<div class="position-absolute top-0 start-0 w-100" style="background-color: #4B6EAD; height: 30%; z-index: 0; border-top-left-radius: 20px; border-top-right-radius: 20px;"></div>' +
                                '<div class="d-flex justify-content-center pt-3" style="z-index: 1;" id="pho_'+ item.id_evaluado +'">' +photo+ '</div>' +
                                '<div class="card-body d-flex flex-column pt-0" style="flex-grow: 1;">' +
                                    '<div class="text-center small fw-bold" style="color: #4B6EAD; font-size: 13px" id="nom_'+ item.id_evaluado +'">' + item.nombre + '</div>' +
                                    '<div class="text-center text-secondary fw-bold" style="font-size: 11px;" id="pue_'+ item.id_evaluado +'">' + item.puesto + '</div>' +
                                    '<div class="row pt-2" style="font-size: 12px">' +
                                        '<div class="col-8 ps-4">' +
                                            '<i class="bi bi-check-circle-fill text-info"></i> <span class="text-secondary">Coef. Intelectual</span>' +
                                        '</div>' +
                                        '<div class="col-4 text-end pe-4" id="ci_'+ item.id_evaluado +'">' +
                                            parseFloat(item.gap_ci).toFixed(1)+'%' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="row" style="font-size: 12px">' +
                                        '<div class="col-8 ps-4">' +
                                            '<i class="bi bi-check-circle-fill text-info"></i> <span class="text-secondary">Nivel Académico.</span>' +
                                        '</div>' +
                                        '<div class="col-4 text-end pe-4" id="na_'+ item.id_evaluado +'">' +
                                            parseFloat(item.gap_na).toFixed(1)+'%' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="row" style="font-size: 12px">' +
                                        '<div class="col-8 ps-4">' +
                                            '<i class="bi bi-check-circle-fill text-info"></i> <span class="text-secondary">Competencias</span>' +
                                        '</div>' +  
                                        '<div class="col-4 text-end pe-4" id="com_'+ item.id_evaluado +'">' +
                                            parseFloat(item.gap_com).toFixed(1)+'%' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="row" style="font-size: 12px">' +  
                                        '<div class="col-8 ps-4">' +
                                            '<i class="bi bi-check-circle-fill text-info"></i> <span class="text-secondary">Habilidades.</span>' +
                                        '</div>' +
                                        '<div class="col-4 text-end pe-4" id="hab_'+ item.id_evaluado +'">' +
                                            parseFloat(item.gap_hab).toFixed(1)+'%' +
                                        '</div>' +
                                    '</div>' +
                                    
                                    <!-- Último row con GAP, que debe estar al fondo -->
                                    '<div class="row fw-bold" style="margin-top: auto;">' +
                                        '<div class="col-8  d-flex justify-content-center align-items-center">' +
                                            '<span class="text-secondary"style="font-size: 16px;">Gap Total</span>' +
                                        '</div>' +
                                        '<div class="col-4 text-center text-light ">' +
                                            '<div class="bg-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 50px; height: 50px; font-size: 15px; color: white;" id="gap_'+ item.id_evaluado +'">' +
                                                parseFloat(item.gap).toFixed(1)+'%' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>'
                        );

                      });                            
                  },
                  error: function (xhr, status, error) {
                      console.error("Error en la solicitud AJAX: " + error);
                      $('#div_spinner').addClass('visually-hidden'); // Ocultar el spinner si hay error
                  }
              });
          } else {
              // Si el valor seleccionado es '-' (no se ha seleccionado una opción)
              clean();
              $('#dash').addClass('visually-hidden');
              $('#div_spinner').addClass('visually-hidden');
          }
      }
      
      function clean() {
          // Limpiar todos los valores y restablecer las barras de progreso
          $('#gap_sec_ci_1').html('-');  // Promedio de Coef. Intelectual
          $('#gap_sec_na_1').html('-'); // Promedio de Nivel Académico
          $('#gap_sec_com_1').html('-'); // Promedio de Competencias
          $('#gap_sec_hab_1').html('-'); // Promedio de Habilidades
          $('#gap_sec_gap_1').html('-'); // Promedio de GAP
      
          // Cálculo de cumplimientos y actualización de barras
          $('#gap_sec_cump_ci_1').html(0);
          $('#gap_sec_cump_na_1').html(0);
          $('#gap_sec_cump_com_1').html(0);
          $('#gap_sec_cump_hab_1').html(0);
          $('#gap_sec_cump_gap_1').html(0);
      
          // Actualización de las barras
          $('#barra_ci_1').css("width", '0%');
          $('#barra_na_1').css("width", '0%');
          $('#barra_com_1').css("width", '0%');
          $('#barra_hab_1').css("width", '0%');
          $('#barra_gap_1').css("width", '0%');
      }

  function wpid(id_eval,id_evaluado)
  {
    $('#nom_pid').html($('#nom_'+id_evaluado).html());
    $('#pue_pid').html($('#pue_'+id_evaluado).html());
    $('#pho_pid').html($('#pho_'+id_evaluado).html());
    $('#uni_pid').html($('#nom_unidad').html());
    $('#ci_pid').html($('#ci_'+id_evaluado).html());
    $('#na_pid').html($('#na_'+id_evaluado).html());
    $('#com_pid').html($('#com_'+id_evaluado).html());
    $('#hab_pid').html($('#hab_'+id_evaluado).html());
    $('#gap_pid').html($('#gap_'+id_evaluado).html());
    $('#div_gap_comp').addClass('visually-hidden');
    $('#div_pid').addClass('visually-hidden');
    $('#div_pid_cursos_com').addClass('visually-hidden');
    $('#div_ad').addClass('visually-hidden');
    var _token = $('input[name="_token"]').val();
    var parametros = {
                  "id_eval": id_eval,
                  "id_evaluado": id_evaluado,
                  "_token": _token
              };
      
              $.ajax({
                  data: parametros,
                  url: "{{ route('gapunidad.pid') }}",  // Asegúrate de que esta ruta sea correcta
                  type: 'POST',
                  dataType: "json",
                  cache: true,
 
                  success: function (response) {
                    cad='';
                    $('#curso_pid').html('');
                    $('#curso_pid_ad').html('');
                    nfecha="-";
                    jQuery(response.pidcomp).each(function(x, item) { 
                      cad+='<li><i class="bi bi-check-circle text-primary"></i> <span class="text-secondary">'+item.comp+'</span></li>';
                      $('#div_pid_cursos_com').removeClass('visually-hidden');
                      $('#div_pid').removeClass('visually-hidden');
                      if(item.fecha!=null)
                      { fecha= item.fecha.split('-');
                        nfecha=fecha[2]+'-'+fecha[1]+'-'+fecha[0];
                      }

                      $('#curso_pid').append('<div class="col-8 ps-4">'+
                        '<i class="bi bi-check-circle text-primary"></i> <span class="text-secondary">'+item.curso+'</span></div>'+
                        '<div class="col-4 text-center">'+
                        '<span class="text-secondary">'+nfecha+'</span></div>'
                      )
                    });

                    jQuery(response.pidhab).each(function(x, item) { 
                      $('#div_pid_cursos_com').removeClass('visually-hidden');    
                      $('#div_pid').removeClass('visually-hidden');                  
                      if(item.fecha!=null)
                      { fecha= item.fecha.split('-');
                        nfecha=fecha[2]+'-'+fecha[1]+'-'+fecha[0];}

                      $('#curso_pid').append('<div class="col-8 ps-4">'+
                        '<i class="bi bi-check-circle text-primary"></i> <span class="text-secondary">'+item.curso+'</span></div>'+
                        '<div class="col-4 text-center">'+
                        '<span class="text-secondary">'+nfecha+'</span></div>'
                      )
                    });

                    if(cad!='')
                    { $('#comp_mayorgap').html(cad);
                      $('#div_gap_comp').removeClass('visually-hidden');
                    }

                                      
                    band=0;                
                    jQuery(response.pidad).each(function(x, item) { 
                      band=1;           
                      if(item.accion==null){accion='-';}else{accion=item.accion;}
                      $('#curso_pid_ad').append('<div class="col-4 ps-4"><i class="bi bi-check-circle text-primary"></i> <span class="text-secondary">'+item.area+'</span></div>'+
                       '<div class="col-4 text-center"><span class="text-secondary">'+item.curso+'</span></div>'+
                       '<div class="col-4 text-center"> <span class="text-secondary">'+accion+'</span></div>'
                       )
                     });
                     if(band!=0){                      
                      $('#div_pid_cursos_com').removeClass('visually-hidden');
                      $('#div_ad').removeClass('visually-hidden');}

                      let comp = [];
                      let prf = [];
                      let prfmin = [];
                      let opt = [];
                      let colores=[];
                      $('#comp_cri').html('');
                      $('#comp_imp').html('');
                      $('#comp_mimp').html('');
                        jQuery(response.values_comp).each(function(i, item){                         
                            comp.push(item.comp);    
                            prf.push(item.prf);    
                            prfmin.push(item.prfmin); 
                            opt.push(item.opt);
                            left=0;esperado=0;div="";
                            left=(item.opt*20)+10;
                            color="bg-primary";
                            if(item.opt<item.prfmin)
                            { color="bg-danger";}
                            
                            if(item.prf==10)
                            { 
                              esperado=80;
                              div="cri";
                            } 
                            if(item.prf==9)
                            { 
                              esperado=70;
                              div="imp";
                            } 
                            if(item.prf==8)
                            { 
                              esperado=60;
                              div="mimp";
                            } 
                              $('#comp_'+div).append(
                                '<div style="font-size: 10px;" class="pb-1">'+item.comp+' </div>'+
                                '<div class="col small mb-2"style="position: relative;">'+                      
                                  '<div class="circle '+color+' text-white" style="font-size: 12px; border: 1px solid white; top:-5px; position: absolute; left: '+left+'px;  width: 20px; height: 20px; border-radius: 50%; text-align: center; line-height: 20px; z-index: 10;">'+
                                    item.opt+
                                  '</div>'+
                                  '<div class="progress" style="position: relative; height: 10px; width: 220px;">'+
                                    '<div class="progress-bar" style="background-color: #e9ecef; width: '+esperado+'%" role="progressbar" aria-valuenow='+esperado+' aria-valuemin="0" aria-valuemax="100"></div>'+
                                    '<div class="progress-bar bg-secondary" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>'+
                                  '</div>'+
                                '</div>'
                              );
                           
                        });

                      Highcharts.chart('container_area', {
                            chart: {
                                polar: true, // Se usa el gráfico polar para crear el radar
                                type: 'line', // Tipo de gráfico
                            },

                            title: {
                                text: null,
                                style: {
                                    fontSize: '20px',
                                    fontWeight: 'bold',
                                }
                            },

                            subtitle: {
                                text: null,
                            },

                            xAxis: {
                                categories: comp,
                                tickInterval: 1,
                                labels: {
                                    style: {
                                        fontSize: '9px',
                                        color: '#666' // Color más suave para las etiquetas del eje X
                                    }
                                },
                                lineWidth: 0, // No líneas en el eje X
                                maxPadding: 0.1 // Espaciado adicional en el eje X para etiquetas
                            },

                            yAxis: {
                                min: 0,
                                max: 10,
                                title: null,
                                labels: {
                                    formatter: function () {
                                        // Solo mostrar etiquetas para el valor mínimo y máximo
                                        if (this.value === 0 || this.value === 10) {
                                            return this.value; // Mostrar solo 0 y 10
                                        } else {
                                            return ''; // No mostrar ninguna etiqueta en los valores intermedios
                                        }
                                    }
                                },
                                gridLineWidth: 1, // Líneas de la cuadrícula para el radar
                                gridLineColor: '#ccc', // Color de las líneas de la cuadrícula
                                gridLineDashStyle: 'Dot', // Estilo de las líneas punteadas
                                lineWidth: 0
                            },

                            plotOptions: {
                                series: {
                                    pointStart: 0,
                                    pointInterval: 1,
                                    marker: {               
                                      radius: 0, // Ajustamos el tamaño de los puntos para mejorar la visibilidad
                                        symbol: null,
                                        lineWidth: 2, // Ancho de la línea del marcador
                                        lineColor: '#ffffff' // Color blanco para el borde de los puntos
                                    },
                                    lineWidth: 2 // Aumentamos el grosor de las líneas para mejorar la visibilidad
                                },
                                area: {
                                    fillOpacity: 0.4 // Transparencia del área para hacerlo menos intrusivo
                                }
                            },

                            series: [
                                {
                                  name: 'Perfil del Puesto',
                                  type: 'line',
                                  data: prf.map(value => value > 5 ? value : 0), // Establece los valores menores a 5 en 0 para no marcar color
                                  color: '#47D45A', // Color verde solo para los valores de prf por encima de 5
                                    marker: {
                                        lineColor: '#47D45A',
                                        radius: 1, // Ajustamos el tamaño de los puntos para mejorar la visibilidad
                                        symbol: 'circle',
                                        lineWidth: 2, // Ancho de la línea del marcador
                                    },
                                  zIndex: 1
                                },
                                {
                                    name: 'Perfil de persona',
                                    type: 'line', // Tipo de gráfico para la serie de línea
                                    data: opt, // Datos de la evaluación real
                                    color: '#066CFD', // Azul para la competencia real
                                    marker: {
                                        lineColor: '#066CFD',
                                        radius: 3, // Ajustamos el tamaño de los puntos para mejorar la visibilidad
                                        symbol: 'circle',
                                        lineWidth: 2, // Ancho de la línea del marcador
                                    },
                                    zIndex: 2, // Asegura que la línea quede encima del área
                                    dashStyle: 'Solid' // Estilo sólido para la línea
                                }
                            ],

                            legend: {
                                enabled: true,
                                borderWidth: 1,
                                borderColor: '#ddd', // Color más suave para el borde de la leyenda
                                borderRadius: 5,
                                align: 'center', // Alinea la leyenda al centro
                                verticalAlign: 'top', // Coloca la leyenda en la parte superior
                                layout: 'horizontal', // Establece la leyenda de forma horizontal
                                symbolHeight: 8,
                                symbolWidth: 17,
                                symbolRadius: 3,
                                squareSymbol: false,
                                itemStyle: {
                                    fontSize: '12px',
                                    fontWeight: 'bold',
                                    color: '#333' // Color consistente con el título
                                },
                                itemHoverStyle: {
                                    color: '#066CFD' // Color de la leyenda cuando se pasa el ratón
                                }
                            },
                        });
                      }
                    });

  }
</script>
      

@endsection