<!DOCTYPE html>
@extends('layouts.plantilla')
@section('title','GAP de Desarrollo')
<script src="{{ asset('assets/js/code/highcharts.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.highcharts.com/highcharts-3d.js"></script>

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
</style>
    <small>
      <div id="preload" class="align-items-center justify-content-center text-center p-4 mt-4"><div class=" mt-4 spinner-border text-primary" role="status"></div></div>
    </small>
    <div id="iframe" style="display: none;">
      @csrf
      @php
        $ci=0;$na=0;$com=0;$hab=0;$gap=0;$cump_ci=0; $cump_na=0; $cump_com=0; $cump_hab=0; $cump_gap=0;
        $ano=0;
      @endphp
  
      @foreach($gap_global as $data)
        @php
          $ci=$data->ci; $na=$data->na; $com=$data->com; $hab=$data->hab; $gap=$data->gap;
          $cump_ci=100-$data->ci; $cump_na=100-$data->na; $cump_com=100-$data->com; $cump_hab=100-$data->hab; $cump_gap=100-$data->gap;
          $ano=$data->year_ano_corresp;
        @endphp
      @endforeach

      @php
          // Inicializamos los arrays
          $grupos = [];
          $g_ci = [];
          $g_na = [];
          $g_com = [];
          $g_hab = [];
          
          $jer_tot = [];
          $gap_jer_tot = [];
      @endphp
      
      @foreach ($gap_grupos as $data)
          @php
              $grupos[] = $data->grupo;
              $g_ci[] = $data->COEFICIENTE_INTELECTUAL;
              $g_na[] = $data->NIVEL_ACADEMICO;
              $g_com[] = $data->COMPETENCIAS;
              $g_hab[] = $data->HABILIDADES;
              $g_hc[] = $data->HC;
          @endphp
      @endforeach

      @foreach ($gap_total_jer as $data)
        @php
          $jer_tot[] = $data->jerarquia;
          $gap_jer_tot[] = $data->gap;
        @endphp
      @endforeach

      @php
          $escala_excelente = 0;
          $escala_muybueno = 0;
          $escala_bueno = 0;
          $escala_regular = 0;
          $escala_deficiente = 0;
      @endphp

      @foreach ($data_escalas as $escala)
          @php
              if ($escala->categoria == 'Excelente') {
                  $escala_excelente = $escala->porcentaje;
              } elseif ($escala->categoria == 'Muy Bueno') {
                  $escala_muybueno = $escala->porcentaje;
              } elseif ($escala->categoria == 'Bueno') {
                  $escala_bueno = $escala->porcentaje;
              } elseif ($escala->categoria == 'Regular') {
                  $escala_regular = $escala->porcentaje;
              } elseif ($escala->categoria == 'Deficiente') {
                  $escala_deficiente = $escala->porcentaje;
              }
          @endphp
      @endforeach
      


@php
    $escalas = [
        1 => [],
        93 => [],
        106 => [],
    ];    
    $escalas_grp = [
      
    ];
@endphp

@foreach ($data_escalas_grp as $escalagr)
    @php
        $id = $escalagr->idgrupo;
        $categoria = $escalagr->categoria;
        $porcentaje = $escalagr->porcentaje;

        if (isset($escalas[$id])) {
            $escalas[$id][$categoria] = $porcentaje;
        }
    @endphp
@endforeach

@foreach ($prom_desemp_grp as $item)
    @php
        $idgrupo_grp = $item->idgrupo;
        $categoria_grp = $item->categoria;
        $pormedio_grp = $item->promedio;
        $color_grp = $item->color;

       
        
            $escalas_grp[$idgrupo_grp]["categoria"] = $categoria_grp;
            $escalas_grp[$idgrupo_grp]["promedio"] = $pormedio_grp;
            $escalas_grp[$idgrupo_grp]["color"] = $color_grp;
       
    @endphp
@endforeach
                              
      
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
      
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span class="text-sm-end fw-bold text-primary">  Qué es el GAP <i class="ps-1 fas fa-question-circle"></span></i>
            </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body bg-light">
                

                <div class="alert alert-primary d-flex align-items-center" role="alert">
                  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                  <div>
                    GAP es la brecha de desviación del perfil del puesto vs. perfil de la persona.
                  </div>
                </div>




                <div class="row mb-0 pb-0 ">
                  <div class="col-1"></div>
                    <div class="col-10 text-center" style="color: #4B6EAD">
                      <h5>Peso % de cada variable</h5>
                    <p class="text-start text-secondary"> En la Organización, el GAP esta compuesto de las siguientes variables con sus respectivos pesos en porcentajes.</p>
                      
                  <img src="{{ asset('assetsw/img/variables.jpg')}}" width="100%" >
                  
                  <p class="text-start text-secondary mt-2">La medida estandar del % de GAP en la industria de Retail es menor o igual a 20%</p>
                </div>
                <div class="col-1"></div>
                </div>


                
              

              <hr>
                <div class="pagetitle">
                  <nav>
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item" style="color: #4B6EAD">CONSIDERACIONES CLAVES</li>
                    </ol>
                  </nav>
                </div><!-- End Page Title -->

                <div class="row small">
                  <div class="col-sm-6 d-flex">
                    <div class="card p-1 flex-fill">
                      <div class="card-body py-1">
                        <h5 class="mb-2" style="color: #4B6EAD">
                          <i class="bi bi-1-circle-fill pe-2 text-primary"></i> Impacto en el servicio en el Cliente
                        </h5>
                        <ul class="list-unstyled ms-3 text-justify">
                          <li><i class="bi bi-check-circle text-primary"></i> <span class="text-secondary">Un GAP mayor puede significar que el empleado no está completamente preparado para cumplir con las expectativas del puesto, lo que podría afectar negativamente la experiencia del cliente.</span></li>
                          <li><i class="bi bi-check-circle text-primary"></i> <span class="text-secondary">En retail, la atención al cliente, el conocimiento del producto y la eficiencia en las operaciones son cruciales.</span></li>
                        </ul>
                      </div>    
                    </div>  
                  </div>  
                
                  <div class="col-sm-6 d-flex">
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
                  <div class="col-sm-6 d-flex">
                    <div class="card p-1 flex-fill">
                      <div class="card-body py-1">
                        <h5 class="mb-2" style="color: #4B6EAD">
                          <i class="bi bi-3-circle-fill pe-2 text-primary"></i> Adaptabilidad y Potencial para el crecimiento
                        </h5>
                        <ul class="list-unstyled ms-3 text-justify">
                          <li><i class="bi bi-check-circle text-primary"></i> <span class="text-secondary">Evaluar no solo el GAP actual, sino también el potencial del empleado para aprender y adaptarse.</span></li>
                          <li><i class="bi bi-check-circle text-primary"></i> <span class="text-secondary">Un empleado con un GAP ligeramente mayor, pero con alto potencial de desarrollo podría ser una mejor inversión a largo plazo.</span></li>
                        </ul>
                      </div>    
                    </div>   
                  </div> 
                
                  <div class="col-6 d-flex">
                    <div class="card p-sm-1 flex-fill">
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
      
        <div class="pagetitle">
          <h1 class="text-secondary">Gap de Desarrollo - {{ $ano }}</h1>
          <span style="cursor: pointer; float: right;" class="text-sm-end fw-bold text-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Qué es el GAP <i class="ps-1 fas fa-question-circle fa-lg"></i>
          </span>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"style="font-weight: normal;">Evaluación y Desarrollo</li>
              <li class="breadcrumb-item" style="color: #4B6EAD">GAP - TOTAL COMPAÑIA</li>
            </ol>
          </nav>
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
                    <div class="mt-1 col text-secondary text-left py-0"><span class="h4 fw-bold">@php echo $ci; @endphp%</span><div style="font-size: 9px">GAP</div></div>              
                    <div class="text-primary text-center py-0" style="font-size: 12px">COEF. INTELECTUAL - 20%</div>       
                </div>         
                    <div class="progress" style="height: 5px;">
                      <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: @php echo $cump_ci; @endphp%"></div>
                    </div>
                    <div class="text-center text-secondary" style="font-size: 10px">@php echo $cump_ci; @endphp% Cumplimiento</div>
              </div>
            </div>
          </div>
       
          <!--- NIVEL ACADÉMIDO-->
          <div class="col pe-1">
            <div class="card ps-1 pe-1">
              <div class="card-body py-1">
                <div class="row">
                  <div class=" mt-1 circle rounded-circle bg-success">
                    <i class="fas fa-user-graduate fa-lg"></i>
                  </div>
                    <div class="mt-1 col text-secondary text-left py-0"><span class="h4 fw-bold">@php echo $na; @endphp%</span><div style="font-size: 9px">GAP</div></div>              
                    <div class="text-success text-center py-0" style="font-size: 12px">NIVEL ACADÉMICO - 20%</div>       
                </div>         
                    <div class="progress" style="height: 5px;">
                      <div class="bg-success progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: @php echo $cump_na; @endphp%"></div>
                    </div>
                    <div class="text-center text-secondary" style="font-size: 9px">@php echo $cump_na; @endphp% Cumplimiento</div>
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
                    <div class="mt-1 col text-secondary text-left py-0"><span class="h4 fw-bold">@php echo $com; @endphp%</span><div style="font-size: 9px">GAP</div></div>              
                    <div class="text-info text-center py-0" style="font-size: 12px">COMPETENCIAS - 30%</div>       
                </div>         
                    <div class="progress" style="height: 5px;">
                      <div class="bg-info progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: @php echo $cump_com; @endphp%"></div>
                    </div>
                    <div class="text-center text-secondary" style="font-size: 9px">@php echo $cump_com; @endphp% Cumplimiento</div>
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
                    <div class="mt-1 col text-secondary text-left py-0"><span class="h4 fw-bold">@php echo $hab; @endphp% </span><div style="font-size: 9px">GAP</div></div>              
                    <div class="text-warning text-center py-0" style="font-size: 12px">HABILIDADES - 30%</div>       
                </div>         
                    <div class="progress" style="height: 5px;">
                      <div class="bg-warning progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: @php echo $cump_hab; @endphp%"></div>
                    </div>
                    <div class="text-center text-secondary" style="font-size: 9px">@php echo $cump_hab; @endphp% Cumplimiento</div>
              </div>
            </div>
          </div> 
       
          <!--- GAP TOTAL-->
          <div class="col pe-1">
            <div class="card ">
              <div class="card-body py-1">
                <div class="row">
                  <div class=" mt-1 circle rounded-circle bg-danger">
                    <i class="fas fa-user-cog fa-lg"></i>
                  </div>
                    <div class="mt-1 col text-secondary text-left py-0"><span class="h4 fw-bold">@php echo $gap; @endphp%</span><div style="font-size: 9px">GAP</div></div>              
                    <div class="text-danger text-center py-0" style="font-size: 12px">GAP TOTAL</div>       
                </div>         
                    <div class="progress" style="height: 5px;">
                      <div class="bg-danger progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: @php echo $cump_gap; @endphp%"></div>
                    </div>
                    <div class="text-center text-secondary" style="font-size: 9px">@php echo $cump_gap; @endphp% Cumplimiento</div>
              </div>
            </div>
          </div> 
        </div>
      
    
      <div class="row m-0 p-0">
        <div class="col-8 m-0 p-0">
          <div class="card m-0">
            <div class="card-body p-0">
              <h5 class="card-title text-secondary ms-4 text-uppercase"style="font-size: 15px">Cumplimiento vs. GAP por segmento del negocio</h5>
              <div id="container" style="height: 300px;"></div>
              <div class="col ps-4 pe-4 ">
                <small>
                  <table class="table table-sm small table-striped-columns table-hover table-auto" >
                    <thead>
                      <tr class="fw-bold">
                        <td class="table-primary text-center" style="color: #4B6EAD; width: 22%">GAP - Segmentos</td>
                        <td class="table-primary text-center" style="color: #4B6EAD; width: 8%">Pers.</td>
                        <td class="table-primary text-center" style="color: #4B6EAD; width: 12%">Coef. Intelectual</td>
                        <td class="table-primary text-center" style="color: #4B6EAD; width: 12%">Niv. Académico</td>
                        <td class="table-primary text-center" style="color: #4B6EAD; width: 12%">Competencias</td>
                        <td class="table-primary text-center" style="color: #4B6EAD; width: 12%">Habilidades</td>
                        <td class="table-primary text-center fw-bold" style="color: #4B6EAD; width: 10%">GAP TOTAL</td>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $grupos = []; $g_tot = []; $g_cum = [];
                        $s_ci=0;$s_na=0;$s_com=0;$s_hab=0;$s_tot=0;$tot_hc=0
                      @endphp
                      @foreach ($gap_grupos as $data)
                        @php
                            $grupos[] = $data->grupo;                      
                            $g_tot[] = $data->TOTAL;
                            $g_cum[] = 100-$data->TOTAL; 

                            $s_ci+=$data->COEFICIENTE_INTELECTUAL;
                            $s_na+=$data->NIVEL_ACADEMICO;
                            $s_com+=$data->COMPETENCIAS;
                            $s_hab+=$data->HABILIDADES;
                            $s_tot+=$data->TOTAL;
                            $tot_hc+=$data->HC;

                        @endphp
                      <tr>
                        <td class="ps-2">{{ $data->grupo }}</td>
                        <td class="text-center">{{ $data->HC}}</td>
                        <td class="text-center">{{ $data->COEFICIENTE_INTELECTUAL }}%</td>
                        <td class="text-center">{{ $data->NIVEL_ACADEMICO }}%</td>
                        <td class="text-center">{{ $data->COMPETENCIAS }}%</td>
                        <td class="text-center">{{ $data->HABILIDADES }}%</td>
                        <td class="text-center">{{ $data->TOTAL }}%</td>
                      </tr>
                    @endforeach  
                    </tbody>
                    <thead>
                      <tr class="text-center table-primary">
                        <th class="table-primary" style="color: #4B6EAD">GAP TOTAL</th>
                        <th style="color: #4B6EAD">{{ $tot_hc}}</th>
                        <th style="color: #4B6EAD">@php echo $ci; @endphp%</th>
                        <th style="color: #4B6EAD">@php echo $na; @endphp%</th>
                        <th style="color: #4B6EAD">@php echo $com; @endphp%</th>
                        <th style="color: #4B6EAD">@php echo $hab; @endphp%</th>
                        <th style="color: #4B6EAD">@php echo $gap; @endphp%</th>
                      </tr>
                    </thead>
                  </table>
                </small>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-4 m-0 ">
          <div class="card">
            <div class="card-body p-0">              
              <small>
                <h5 class="card-title text-secondary ms-3 text-uppercase"style="font-size: 15px">Distribución del GAP por Jerarquía</h5>
                <div id="container_jer" style="height: 450px;font-size: 10px"></div>
              </small>
            </div>
          </div>
        </div>
      </div>
      <!---------------Resultados Total Compañia Clasificados Según Escala de Desempeño----------------->
              <div class="row">
                <div class="col-6 h-100">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title text-secondary text-uppercase"style="font-size: 14px">Distribución del Talento, según escala de desempeño</h5>

                        <div id="container-escala" style="height: 360px;">

                          <div class="row w-100" class=" d-flex align-items-center" style="height: 280px;">

                            <div class="col">
                              
                              <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="col-10">
                                  <div class="row border bg-white" 
                                      style="border-color: #2F526F; height: 34px; position: relative; 
                                              border-bottom-left-radius: 50px; border-top-left-radius: 50px; 
                                              border-bottom-right-radius: 20px; border-top-right-radius: 20px;">
                                    
                                    <div class="col-2 ms-0 ps-0">
                                      <div class="rounded-circle d-flex justify-content-center align-items-center fw-semibold" 
                                          style="background-color: #2F526F; width: 32px; height: 32px; color: white; position: absolute; top: 0px;">
                                        05
                                      </div>
                                    </div>

                                    <div class="col-10 d-flex justify-content-center align-items-center fw-bold">
                                      <div class="col-8 ps-0" style="font-size: 12px; color: #2F526F;">
                                        Excelentes
                                      </div>
                                      <div class="col-4 text-secondary text-end" style="font-size: 14px;">
                                        <span style="color: #2F526F;" >{{ $escala_excelente }}%</span>
                                      </div>
                                    </div>

                                  </div>  
                                </div>
                              </div>
                            
                              <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="col-10">
                                  <div class="row border bg-white" 
                                      style="border-color: #366A9A; height: 34px; position: relative; 
                                              border-bottom-left-radius: 50px; border-top-left-radius: 50px; 
                                              border-bottom-right-radius: 20px; border-top-right-radius: 20px;">
                                    
                                    <div class="col-2 ms-0 ps-0">
                                      <div class="rounded-circle d-flex justify-content-center align-items-center fw-semibold" 
                                          style="background-color: #366A9A; width: 32px; height: 32px; color: white; position: absolute; top: 0px;">
                                        04
                                      </div>
                                    </div>

                                    <div class="col-10 d-flex justify-content-center align-items-center fw-bold">
                                      <div class="col-8 ps-0" style="font-size: 12px; color: #366A9A;">
                                        Muy Buenos
                                      </div>
                                      <div class="col-4 text-secondary text-end" style="font-size: 14px;">
                                        <span style="color: #366A9A;">{{ $escala_muybueno }}%</span>
                                      </div>
                                    </div>

                                  </div>  
                                </div>
                              </div>                          
                          
                              <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="col-10">
                                  <div class="row border bg-white" 
                                      style="border-color: #447BAC; height: 34px; position: relative; 
                                              border-bottom-left-radius: 50px; border-top-left-radius: 50px; 
                                              border-bottom-right-radius: 20px; border-top-right-radius: 20px;">
                                    
                                    <div class="col-2 ms-0 ps-0">
                                      <div class="rounded-circle d-flex justify-content-center align-items-center fw-semibold" 
                                          style="background-color: #447BAC; width: 32px; height: 32px; color: white; position: absolute; top: 0px;">
                                        03
                                      </div>
                                    </div>

                                    <div class="col-10 d-flex justify-content-center align-items-center fw-bold">
                                      <div class="col-8 ps-0" style="font-size: 12px; color: #447BAC;">
                                        Buenos
                                      </div>
                                      <div class="col-4 text-secondary text-end" style="font-size: 14px;">
                                        <span  style="color: #447BAC;">{{ $escala_bueno }}%</span>
                                      </div>
                                    </div>

                                  </div>  
                                </div>
                              </div>                          
                            
                              <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="col-10">
                                  <div class="row border bg-white" 
                                      style="border-color: #538CBF; height: 34px; position: relative; 
                                              border-bottom-left-radius: 50px; border-top-left-radius: 50px; 
                                              border-bottom-right-radius: 20px; border-top-right-radius: 20px;">
                                    
                                    <div class="col-2 ms-0 ps-0">
                                      <div class="rounded-circle d-flex justify-content-center align-items-center fw-semibold" 
                                          style="background-color: #538CBF; width: 32px; height: 32px; color: white; position: absolute; top: 0px;">
                                        02
                                      </div>
                                    </div>

                                    <div class="col-10 d-flex justify-content-center align-items-center fw-bold">
                                      <div class="col-8 ps-0" style="font-size: 12px; color: #538CBF;">
                                        Regulares
                                      </div>
                                      <div class="col-4 text-secondary text-end" style="font-size: 14px;">
                                        <span style="color: #538CBF;">{{ $escala_regular }}%</span>
                                      </div>
                                    </div>

                                  </div>  
                                </div>
                              </div>                          
                            
                              <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="col-10">
                                  <div class="row border bg-white" 
                                      style="border-color: #629DD1 ; height: 34px; position: relative; 
                                              border-bottom-left-radius: 50px; border-top-left-radius: 50px; 
                                              border-bottom-right-radius: 20px; border-top-right-radius: 20px;">
                                    
                                    <div class="col-2 ms-0 ps-0">
                                      <div class="rounded-circle d-flex justify-content-center align-items-center fw-semibold" 
                                          style="background-color: #629DD1 ; width: 32px; height: 32px; color: white; position: absolute; top: 0px;">
                                        01
                                      </div>
                                    </div>

                                    <div class="col-10 d-flex justify-content-center align-items-center fw-bold">
                                      <div class="col-9 ps-0" style="font-size: 12px; color: #629DD1;">
                                        Deficientes
                                      </div>
                                      <div class="col-3 text-secondary text-end" style="font-size: 14px;">
                                        <span style="color: #629DD1;">{{ $escala_deficiente }}%</span>
                                      </div>
                                    </div>

                                  </div>  
                                </div>
                              </div>

                            </div>
                            <div class="col text-end">
                              <img src="{{ asset('assets/img/escala.jpg') }}" style="height: 90%;">
                            </div>
                          </div>  
                          <h6 class=" text-secondary text-uppercase"style="font-size: 14px">Desempeño Global de la Compañía Según Escala</h6>

                          <div class="row border px-4 border-primary bg-light rounded-pill d-flex justify-content-between align-items-center mb-2 fw-bold  text-secondary" style=" height: 40px; font-size: 16px;">
                            <div class="col d-flex justify-content-center">
                              Promedio
                            </div>
                            <div class="col d-flex justify-content-center" style="font-size: 16px;">
                              {{ $prom_desemp->promedio }}%
                            </div>
                            <div class="col d-flex justify-content-center">
                              <i class="fa-solid fa-arrow-right-long fa-lg"></i>
                            </div>
                            <div class="col d-flex justify-content-center" style="color: {{ $prom_desemp->color }};">
                              {{ $prom_desemp->categoria }}
                            </div>
                          </div>
                        </div>

                    </div>
                  </div>
                </div>
                <div class="col-6 h-100">
                  <div class="card">
                    <div class="card-body">   
                      <h5 class="card-title text-secondary text-uppercase"style="font-size: 15px">CUMPLIMIENTO VS. GAP total compañia<br></h5>
                      <div id="container-donuts" style="height: 360px;"></div>
                    </div>
                  </div>
                </div>
              </div>
      <!-------------------------------------------------->
        <hr>
        
        <div class="pagetitle">
          <h1 class="text-secondary">Gap de Desarrollo - {{ $ano }}</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"style="font-weight: normal;">Evaluación y Desarrollo</li>
              <li class="breadcrumb-item" style="color: #4B6EAD">GAP - <span id="nom_seccion_1"></span></li>
            </ol>
          </nav>
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
                      <div class="mt-1 col text-secondary text-left py-0"><span class="h4 fw-bold" id="gap_sec_ci_1"></span><div style="font-size: 9px">GAP</div></div>              
                      <div class="text-primary text-center py-0" style="font-size: 12px">COEF. INTELECTUAL - 20%</div>       
                  </div>         
                      <div class="progress" style="height: 5px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100" id="barra_ci_1"></div>
                      </div>
                      <div class="text-center text-secondary" style="font-size: 10px"><span id="gap_sec_cump_ci_1"></span>% Cumplimiento</div>
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
                    <div class="mt-1 col text-secondary text-left py-0"><span class="h4 fw-bold" id="gap_sec_na_1"></span><div style="font-size: 9px">GAP</div></div>             
                      <div class="text-success text-center py-0" style="font-size: 12px">NIVEL ACADÉMICO - 20%</div>       
                  </div>         
                      <div class="progress" style="height: 5px;">
                        <div class="bg-success progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100" id="barra_na_1"></div>
                      </div>
                      <div class="text-center text-secondary" style="font-size: 9px"><span id="gap_sec_cump_na_1"></span>% Cumplimiento</div>
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
                      <div class="mt-1 col text-secondary text-left py-0"><span class="h4 fw-bold" id="gap_sec_com_1"></span><div style="font-size: 9px">GAP</div></div>              
                      <div class="text-info text-center py-0" style="font-size: 12px">COMPETENCIAS - 30%</div>       
                  </div>         
                      <div class="progress" style="height: 5px;">
                        <div class="bg-info progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" id="barra_com_1"></div>
                      </div>
                      <div class="text-center text-secondary" style="font-size: 9px"><span id="gap_sec_cump_com_1"></span>% Cumplimiento</div>
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
                      <div class="mt-1 col text-secondary text-left py-0"><span class="h4 fw-bold" id="gap_sec_hab_1"></span><div style="font-size: 9px">GAP</div></div>               
                      <div class="text-warning text-center py-0" style="font-size: 12px">HABILIDADES - 30%</div>       
                  </div>         
                      <div class="progress" style="height: 5px;">
                        <div class="bg-warning progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" id="barra_hab_1"></div>
                      </div>
                      <div class="text-center text-secondary" style="font-size: 9px"><span id="gap_sec_cump_hab_1"></span>% Cumplimiento</div>
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
                      <div class="mt-1 col text-secondary text-left py-0"><span class="h4 fw-bold" id="gap_sec_gap_1"></span><div style="font-size: 9px">GAP</div></div>              
                      <div class="text-danger text-center py-0" style="font-size: 12px">GAP TOTAL</div>       
                  </div>         
                      <div class="progress" style="height: 5px;">
                        <div class="bg-danger progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" id="barra_gap_1"></div>
                      </div>
                      <div class="text-center text-secondary" style="font-size: 9px"><span id="gap_sec_cump_gap_1"></span>% Cumplimiento</div>
                </div>
              </div>
            </div>
          </div>



        <div class="row m-0 p-0">
          <div class="col-8 m-0 p-0">
            <div class="card">
              <div class="card-body p-0">  
                <small>
                  <h5 class="card-title text-secondary ms-3 text-uppercase"style="font-size: 15px" id="tit_1"></h5>
                  <div id="container_1" style="height: 400px;font-size: 10px"></div>
                </small>
              </div>
            </div>
          </div>                
                  
          <div class="col-4 mb-0">
            <div class="card">
              <div class="card-body p-0"> 
                <h5 class=" mt-0 card-title text-secondary ms-3 text-start text-uppercase"style="font-size: 13px" id="tit_jer_1"></h5>
                <small>
                  <div  class=" mt-0" id="container_jer_1" style="font-size: 9px"></div>
                </small>
              </div>
            </div>
          </div>
        </div>

        <div class="card pt-4">
          <div class="card-body small"> 
            <table class="table table-sm small table-striped-columns table-hover mx-auto" style="width: 90%">
              <thead>
                <tr class="fw-bold">
                  <td class="table-primary text-center" style="color: #4B6EAD; width: 40%">GAP - <span id="nom_grp_1"><span></td>
                  <td class="table-primary text-center" style="color: #4B6EAD; width: 10%">Personas</td>
                  <td class="table-primary text-center" style="color: #4B6EAD; width: 10%">Coef. Intelectual</td>
                  <td class="table-primary text-center" style="color: #4B6EAD; width: 10%">Niv. Académico</td>
                  <td class="table-primary text-center" style="color: #4B6EAD; width: 10%">Competencias</td>
                  <td class="table-primary text-center" style="color: #4B6EAD; width: 10%">Habilidades</td>
                  <td class="table-primary text-center fw-bold" style="color: #4B6EAD; width: 10%">GAP TOTAL</td>
                </tr>
              </thead>
              <tbody id="tbody_1"> </tbody>
              <thead>
                <tr class="text-center table-primary">
                  <th class="table-primary" style="color: #4B6EAD">GAP TOTAL</th>
                  <th style="color: #4B6EAD"><span id="tothc_1"></span></th>
                  <th style="color: #4B6EAD"><span id="totci_1"></span>%</th>
                  <th style="color: #4B6EAD"><span id="totna_1"></span>%</th>
                  <th style="color: #4B6EAD"><span id="totcom_1"></span>%</th>
                  <th style="color: #4B6EAD"><span id="tothab_1"></span>%</th>
                  <th style="color: #4B6EAD"><span id="tot_1"></span>%</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>


      <!-------------------------------->
              <div class="row">
                <div class="col-6 h-100">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title text-secondary text-uppercase"style="font-size: 14px">Distribución del Talento, según escala de desempeño</h5>
                        <div id="container-escala" style="height: 360px;">
                          <div class="row w-100" class=" d-flex align-items-center" style="height: 280px;">
                            <div class="col">                              
                              <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="col-10">
                                  <div class="row border bg-white" 
                                      style="border-color: #2F526F; height: 34px; position: relative; 
                                              border-bottom-left-radius: 50px; border-top-left-radius: 50px; 
                                              border-bottom-right-radius: 20px; border-top-right-radius: 20px;">
                                    
                                    <div class="col-2 ms-0 ps-0">
                                      <div class="rounded-circle d-flex justify-content-center align-items-center fw-semibold" 
                                          style="background-color: #2F526F; width: 32px; height: 32px; color: white; position: absolute; top: 0px;">
                                        05
                                      </div>
                                    </div>

                                    <div class="col-10 d-flex justify-content-center align-items-center fw-bold">
                                      <div class="col-8 ps-0" style="font-size: 12px; color: #2F526F;">
                                        Excelentes
                                      </div>
                                      <div class="col-4 text-secondary text-end" style="font-size: 14px;">
                                        <span style="color: #2F526F;" >{{ $escalas[1]['Excelente'] ?? 0 }}%</span>
                                      </div>
                                    </div>

                                  </div>  
                                </div>
                              </div>
                            
                              <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="col-10">
                                  <div class="row border bg-white" 
                                      style="border-color: #366A9A; height: 34px; position: relative; 
                                              border-bottom-left-radius: 50px; border-top-left-radius: 50px; 
                                              border-bottom-right-radius: 20px; border-top-right-radius: 20px;">
                                    
                                    <div class="col-2 ms-0 ps-0">
                                      <div class="rounded-circle d-flex justify-content-center align-items-center fw-semibold" 
                                          style="background-color: #366A9A; width: 32px; height: 32px; color: white; position: absolute; top: 0px;">
                                        04
                                      </div>
                                    </div>

                                    <div class="col-10 d-flex justify-content-center align-items-center fw-bold">
                                      <div class="col-8 ps-0" style="font-size: 12px; color: #366A9A;">
                                        Muy Buenos
                                      </div>
                                      <div class="col-4 text-secondary text-end" style="font-size: 14px;">
                                        <span style="color: #366A9A;">{{ $escalas[1]['Muy Bueno'] ?? 0 }}%</span>
                                      </div>
                                    </div>

                                  </div>  
                                </div>
                              </div>                          
                          
                              <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="col-10">
                                  <div class="row border bg-white" 
                                      style="border-color: #447BAC; height: 34px; position: relative; 
                                              border-bottom-left-radius: 50px; border-top-left-radius: 50px; 
                                              border-bottom-right-radius: 20px; border-top-right-radius: 20px;">
                                    
                                    <div class="col-2 ms-0 ps-0">
                                      <div class="rounded-circle d-flex justify-content-center align-items-center fw-semibold" 
                                          style="background-color: #447BAC; width: 32px; height: 32px; color: white; position: absolute; top: 0px;">
                                        03
                                      </div>
                                    </div>

                                    <div class="col-10 d-flex justify-content-center align-items-center fw-bold">
                                      <div class="col-8 ps-0" style="font-size: 12px; color: #447BAC;">
                                        Buenos
                                      </div>
                                      <div class="col-4 text-secondary text-end" style="font-size: 14px;">
                                        <span  style="color: #447BAC;">{{ $escalas[1]['Bueno'] ?? 0 }}%</span>
                                      </div>
                                    </div>

                                  </div>  
                                </div>
                              </div>                          
                            
                              <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="col-10">
                                  <div class="row border bg-white" 
                                      style="border-color: #538CBF; height: 34px; position: relative; 
                                              border-bottom-left-radius: 50px; border-top-left-radius: 50px; 
                                              border-bottom-right-radius: 20px; border-top-right-radius: 20px;">
                                    
                                    <div class="col-2 ms-0 ps-0">
                                      <div class="rounded-circle d-flex justify-content-center align-items-center fw-semibold" 
                                          style="background-color: #538CBF; width: 32px; height: 32px; color: white; position: absolute; top: 0px;">
                                        02
                                      </div>
                                    </div>

                                    <div class="col-10 d-flex justify-content-center align-items-center fw-bold">
                                      <div class="col-8 ps-0" style="font-size: 12px; color: #538CBF;">
                                        Regulares
                                      </div>
                                      <div class="col-4 text-secondary text-end" style="font-size: 14px;">
                                        <span style="color: #538CBF;">{{ $escalas[1]['Regular'] ?? 0 }}%</span>
                                      </div>
                                    </div>

                                  </div>  
                                </div>
                              </div>                          
                            
                              <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="col-10">
                                  <div class="row border bg-white" 
                                      style="border-color: #629DD1 ; height: 34px; position: relative; 
                                              border-bottom-left-radius: 50px; border-top-left-radius: 50px; 
                                              border-bottom-right-radius: 20px; border-top-right-radius: 20px;">
                                    
                                    <div class="col-2 ms-0 ps-0">
                                      <div class="rounded-circle d-flex justify-content-center align-items-center fw-semibold" 
                                          style="background-color: #629DD1 ; width: 32px; height: 32px; color: white; position: absolute; top: 0px;">
                                        01
                                      </div>
                                    </div>

                                    <div class="col-10 d-flex justify-content-center align-items-center fw-bold">
                                      <div class="col-9 ps-0" style="font-size: 12px; color: #629DD1;">
                                        Deficientes
                                      </div>
                                      <div class="col-3 text-secondary text-end" style="font-size: 14px;">
                                        <span style="color: #629DD1;">{{ $escalas[1]['Deficiente'] ?? 0 }}%</span>
                                      </div>
                                    </div>

                                  </div>  
                                </div>
                              </div>
                            </div>
                            <div class="col text-end">
                              <img src="{{ asset('assets/img/escala.jpg') }}" style="height: 90%;">
                            </div>
                          </div>  
                          <h6 class=" text-secondary text-uppercase"style="font-size: 14px">Desempeño <span id="desempeno_seccion_1"></span> Según Escala</h6>

                          <div class="row border px-4 border-primary bg-light rounded-pill d-flex justify-content-between align-items-center mb-2 fw-bold  text-secondary" style=" height: 40px; font-size: 16px;">
                            <div class="col d-flex justify-content-center">
                              Promedio
                            </div>
                            <div class="col d-flex justify-content-center" style="font-size: 16px;">
                              {{ $escalas_grp[1]['promedio'] ?? 0 }}%
                            </div>
                            <div class="col d-flex justify-content-center">
                              <i class="fa-solid fa-arrow-right-long fa-lg"></i>
                            </div>
                            <div class="col d-flex justify-content-center" style="color: {{ $escalas_grp[1]['color'] ?? '#2F526F' }};">
                              {{ $escalas_grp[1]['categoria'] ?? 0 }}
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="col-6 h-100">
                  <div class="card">
                    <div class="card-body">   
                      <h5 class="card-title text-secondary text-uppercase"style="font-size: 15px">CUMPLIMIENTO VS. GAP Corporativo<br></h5>
                      <div id="container-donuts_1" style="height: 360px;"></div>
                    </div>
                  </div>
                </div>
              </div>
      <!--------------------------------->




        <hr>
        <div class="pagetitle">
          <h1 class="text-secondary">Gap de Desarrollo - {{ $ano }}</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"style="font-weight: normal;">Evaluación y Desarrollo</li>
              <li class="breadcrumb-item" style="color: #4B6EAD">GAP - <span id="nom_seccion_2"></span></li>
            </ol>
          </nav>
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
                    <div class="mt-1 col text-secondary text-left py-0"><span class="h4 fw-bold" id="gap_sec_ci_2"></span><div style="font-size: 9px">GAP</div></div>              
                    <div class="text-primary text-center py-0" style="font-size: 12px">COEF. INTELECTUAL - 20%</div>       
                </div>         
                    <div class="progress" style="height: 5px;">
                      <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100" id="barra_ci_2"></div>
                    </div>
                    <div class="text-center text-secondary" style="font-size: 10px"><span id="gap_sec_cump_ci_2"></span>% Cumplimiento</div>
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
                  <div class="mt-1 col text-secondary text-left py-0"><span class="h4 fw-bold" id="gap_sec_na_2"></span><div style="font-size: 9px">GAP</div></div>             
                    <div class="text-success text-center py-0" style="font-size: 12px">NIVEL ACADÉMICO - 20%</div>       
                </div>         
                    <div class="progress" style="height: 5px;">
                      <div class="bg-success progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100" id="barra_na_2"></div>
                    </div>
                    <div class="text-center text-secondary" style="font-size: 9px"><span id="gap_sec_cump_na_2"></span>% Cumplimiento</div>
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
                    <div class="mt-1 col text-secondary text-left py-0"><span class="h4 fw-bold" id="gap_sec_com_2"></span><div style="font-size: 9px">GAP</div></div>              
                    <div class="text-info text-center py-0" style="font-size: 12px">COMPETENCIAS - 30%</div>       
                </div>         
                    <div class="progress" style="height: 5px;">
                      <div class="bg-info progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" id="barra_com_2"></div>
                    </div>
                    <div class="text-center text-secondary" style="font-size: 9px"><span id="gap_sec_cump_com_2"></span>% Cumplimiento</div>
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
                    <div class="mt-1 col text-secondary text-left py-0"><span class="h4 fw-bold" id="gap_sec_hab_2"></span><div style="font-size: 9px">GAP</div></div>               
                    <div class="text-warning text-center py-0" style="font-size: 12px">HABILIDADES - 30%</div>       
                </div>         
                    <div class="progress" style="height: 5px;">
                      <div class="bg-warning progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" id="barra_hab_2"></div>
                    </div>
                    <div class="text-center text-secondary" style="font-size: 9px"><span id="gap_sec_cump_hab_2"></span>% Cumplimiento</div>
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
                    <div class="mt-1 col text-secondary text-left py-0"><span class="h4 fw-bold" id="gap_sec_gap_2"></span><div style="font-size: 9px">GAP</div></div>              
                    <div class="text-danger text-center py-0" style="font-size: 12px">GAP TOTAL</div>       
                </div>         
                    <div class="progress" style="height: 5px;">
                      <div class="bg-danger progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" id="barra_gap_2"></div>
                    </div>
                    <div class="text-center text-secondary" style="font-size: 9px"><span id="gap_sec_cump_gap_2"></span>% Cumplimiento</div>
              </div>
            </div>
          </div>
        </div>

        <div class="row m-0 p-0">
          <div class="col-8 m-0 p-0">
            <div class="card">
              <div class="card-body p-0">  
                <small>
                  <h5 class="card-title text-secondary ms-3 text-uppercase"style="font-size: 15px" id="tit_2"></h5>
                  <div id="container_2" style="height: 400px;font-size: 10px"></div>
                </small>
              </div>
            </div>
          </div>                
                  
          <div class="col-4 mb-0">
            <div class="card">
              <div class="card-body p-0"> 
                <h5 class=" mt-0 card-title text-secondary ms-3 text-start text-uppercase"style="font-size: 13px" id="tit_jer_2"></h5>
                <small>
                  <div  class=" mt-0" id="container_jer_2" style="font-size: 9px"></div>
                </small>
              </div>
            </div>
          </div>
        </div>

        <div class="card pt-4">
          <div class="card-body small"> 
            <table class="table table-sm small table-striped-columns table-hover mx-auto" style="width: 90%">
              <thead>
                <tr class="fw-bold">
                  <td class="table-primary text-center" style="color: #4B6EAD; width: 40%">GAP - <span id="nom_grp_2"><span></td>
                  <td class="table-primary text-center" style="color: #4B6EAD; width: 10%">Personas</td>
                  <td class="table-primary text-center" style="color: #4B6EAD; width: 10%">Coef. Intelectual</td>
                  <td class="table-primary text-center" style="color: #4B6EAD; width: 10%">Niv. Académico</td>
                  <td class="table-primary text-center" style="color: #4B6EAD; width: 10%">Competencias</td>
                  <td class="table-primary text-center" style="color: #4B6EAD; width: 10%">Habilidades</td>
                  <td class="table-primary text-center fw-bold" style="color: #4B6EAD; width: 10%">GAP TOTAL</td>
                </tr>
              </thead>
              <tbody id="tbody_2"> </tbody>
              <thead>
                <tr class="text-center table-primary">
                  <th class="table-primary" style="color: #4B6EAD">GAP TOTAL</th>
                  <th style="color: #4B6EAD"><span id="tothc_2"></span></th>
                  <th style="color: #4B6EAD"><span id="totci_2"></span>%</th>
                  <th style="color: #4B6EAD"><span id="totna_2"></span>%</th>
                  <th style="color: #4B6EAD"><span id="totcom_2"></span>%</th>
                  <th style="color: #4B6EAD"><span id="tothab_2"></span>%</th>
                  <th style="color: #4B6EAD"><span id="tot_2"></span>%</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>    
        
        

      <!-------------------------------->
              <div class="row">
                
                <div class="col-6 h-100">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title text-secondary text-uppercase"style="font-size: 14px">Distribución del Talento, según escala de desempeño</h5>
                        <div id="container-escala" style="height: 360px;">
                          <div class="row w-100" class=" d-flex align-items-center" style="height: 280px;">
                            <div class="col">                              
                              <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="col-10">
                                  <div class="row border bg-white" 
                                      style="border-color: #2F526F; height: 34px; position: relative; 
                                              border-bottom-left-radius: 50px; border-top-left-radius: 50px; 
                                              border-bottom-right-radius: 20px; border-top-right-radius: 20px;">
                                    
                                    <div class="col-2 ms-0 ps-0">
                                      <div class="rounded-circle d-flex justify-content-center align-items-center fw-semibold" 
                                          style="background-color: #2F526F; width: 32px; height: 32px; color: white; position: absolute; top: 0px;">
                                        05
                                      </div>
                                    </div>

                                    <div class="col-10 d-flex justify-content-center align-items-center fw-bold">
                                      <div class="col-8 ps-0" style="font-size: 12px; color: #2F526F;">
                                        Excelentes
                                      </div>
                                      <div class="col-4 text-secondary text-end" style="font-size: 14px;">
                                        <span style="color: #2F526F;" >{{ $escalas[93]['Excelente'] ?? 0 }}%</span>
                                      </div>
                                    </div>

                                  </div>  
                                </div>
                              </div>
                            
                              <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="col-10">
                                  <div class="row border bg-white" 
                                      style="border-color: #366A9A; height: 34px; position: relative; 
                                              border-bottom-left-radius: 50px; border-top-left-radius: 50px; 
                                              border-bottom-right-radius: 20px; border-top-right-radius: 20px;">
                                    
                                    <div class="col-2 ms-0 ps-0">
                                      <div class="rounded-circle d-flex justify-content-center align-items-center fw-semibold" 
                                          style="background-color: #366A9A; width: 32px; height: 32px; color: white; position: absolute; top: 0px;">
                                        04
                                      </div>
                                    </div>

                                    <div class="col-10 d-flex justify-content-center align-items-center fw-bold">
                                      <div class="col-8 ps-0" style="font-size: 12px; color: #366A9A;">
                                        Muy Buenos
                                      </div>
                                      <div class="col-4 text-secondary text-end" style="font-size: 14px;">
                                        <span style="color: #366A9A;">{{ $escalas[93]['Muy Bueno'] ?? 0 }}%</span>
                                      </div>
                                    </div>

                                  </div>  
                                </div>
                              </div>                          
                          
                              <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="col-10">
                                  <div class="row border bg-white" 
                                      style="border-color: #447BAC; height: 34px; position: relative; 
                                              border-bottom-left-radius: 50px; border-top-left-radius: 50px; 
                                              border-bottom-right-radius: 20px; border-top-right-radius: 20px;">
                                    
                                    <div class="col-2 ms-0 ps-0">
                                      <div class="rounded-circle d-flex justify-content-center align-items-center fw-semibold" 
                                          style="background-color: #447BAC; width: 32px; height: 32px; color: white; position: absolute; top: 0px;">
                                        03
                                      </div>
                                    </div>

                                    <div class="col-10 d-flex justify-content-center align-items-center fw-bold">
                                      <div class="col-8 ps-0" style="font-size: 12px; color: #447BAC;">
                                        Buenos
                                      </div>
                                      <div class="col-4 text-secondary text-end" style="font-size: 14px;">
                                        <span  style="color: #447BAC;">{{ $escalas[93]['Bueno'] ?? 0 }}%</span>
                                      </div>
                                    </div>

                                  </div>  
                                </div>
                              </div>                          
                            
                              <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="col-10">
                                  <div class="row border bg-white" 
                                      style="border-color: #538CBF; height: 34px; position: relative; 
                                              border-bottom-left-radius: 50px; border-top-left-radius: 50px; 
                                              border-bottom-right-radius: 20px; border-top-right-radius: 20px;">
                                    
                                    <div class="col-2 ms-0 ps-0">
                                      <div class="rounded-circle d-flex justify-content-center align-items-center fw-semibold" 
                                          style="background-color: #538CBF; width: 32px; height: 32px; color: white; position: absolute; top: 0px;">
                                        02
                                      </div>
                                    </div>

                                    <div class="col-10 d-flex justify-content-center align-items-center fw-bold">
                                      <div class="col-8 ps-0" style="font-size: 12px; color: #538CBF;">
                                        Regulares
                                      </div>
                                      <div class="col-4 text-secondary text-end" style="font-size: 14px;">
                                        <span style="color: #538CBF;">{{ $escalas[93]['Regular'] ?? 0 }}%</span>
                                      </div>
                                    </div>

                                  </div>  
                                </div>
                              </div>                          
                            
                              <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="col-10">
                                  <div class="row border bg-white" 
                                      style="border-color: #629DD1 ; height: 34px; position: relative; 
                                              border-bottom-left-radius: 50px; border-top-left-radius: 50px; 
                                              border-bottom-right-radius: 20px; border-top-right-radius: 20px;">
                                    
                                    <div class="col-2 ms-0 ps-0">
                                      <div class="rounded-circle d-flex justify-content-center align-items-center fw-semibold" 
                                          style="background-color: #629DD1 ; width: 32px; height: 32px; color: white; position: absolute; top: 0px;">
                                        01
                                      </div>
                                    </div>

                                    <div class="col-10 d-flex justify-content-center align-items-center fw-bold">
                                      <div class="col-9 ps-0" style="font-size: 12px; color: #629DD1;">
                                        Deficientes
                                      </div>
                                      <div class="col-3 text-secondary text-end" style="font-size: 14px;">
                                        <span style="color: #629DD1;">{{ $escalas[93]['Deficiente'] ?? 0 }}%</span>
                                      </div>
                                    </div>

                                  </div>  
                                </div>
                              </div>
                            </div>
                            <div class="col text-end">
                              <img src="{{ asset('assets/img/escala.jpg') }}" style="height: 90%;">
                            </div>
                          </div>  
                          <h6 class=" text-secondary text-uppercase"style="font-size: 14px">Desempeño <span id="desempeno_seccion_2"></span> Según Escala</h6>

                          <div class="row border px-4 border-primary bg-light rounded-pill d-flex justify-content-between align-items-center mb-2 fw-bold  text-secondary" style=" height: 40px; font-size: 16px;">
                            <div class="col d-flex justify-content-center">
                              Promedio
                            </div>
                            <div class="col d-flex justify-content-center" style="font-size: 16px;">
                              {{ $escalas_grp[93]['promedio'] ?? 0 }}%
                            </div>
                            <div class="col d-flex justify-content-center">
                              <i class="fa-solid fa-arrow-right-long fa-lg"></i>
                            </div>
                            <div class="col d-flex justify-content-center" style="color: {{ $escalas_grp[93]['color'] ?? '#2F526F' }};">
                              {{ $escalas_grp[93]['categoria'] ?? 0 }}
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="col-6 h-100">
                  <div class="card">
                    <div class="card-body">   
                      <h5 class="card-title text-secondary text-uppercase"style="font-size: 15px">CUMPLIMIENTO VS. GAP Unidades de Negocios<br></h5>
                      <div id="container-donuts_2" style="height: 360px;"></div>
                    </div>
                  </div>
                </div>
              </div>
      <!--------------------------------->


        <hr>
        <div class="pagetitle">
          <h1 class="text-secondary">Gap de Desarrollo - {{ $ano }}</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"style="font-weight: normal;">Evaluación y Desarrollo</li>
              <li class="breadcrumb-item" style="color: #4B6EAD">GAP - <span id="nom_seccion_3"></span></li>
            </ol>
          </nav>
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
                    <div class="mt-1 col text-secondary text-left py-0"><span class="h4 fw-bold" id="gap_sec_ci_3"></span><div style="font-size: 9px">GAP</div></div>              
                    <div class="text-primary text-center py-0" style="font-size: 12px">COEF. INTELECTUAL - 20%</div>       
                </div>         
                    <div class="progress" style="height: 5px;">
                      <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100" id="barra_ci_3"></div>
                    </div>
                    <div class="text-center text-secondary" style="font-size: 10px"><span id="gap_sec_cump_ci_3"></span>% Cumplimiento</div>
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
                  <div class="mt-1 col text-secondary text-left py-0"><span class="h4 fw-bold" id="gap_sec_na_3"></span><div style="font-size: 9px">GAP</div></div>             
                    <div class="text-success text-center py-0" style="font-size: 12px">NIVEL ACADÉMICO - 20%</div>       
                </div>         
                    <div class="progress" style="height: 5px;">
                      <div class="bg-success progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100" id="barra_na_3"></div>
                    </div>
                    <div class="text-center text-secondary" style="font-size: 9px"><span id="gap_sec_cump_na_3"></span>% Cumplimiento</div>
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
                    <div class="mt-1 col text-secondary text-left py-0"><span class="h4 fw-bold" id="gap_sec_com_3"></span><div style="font-size: 9px">GAP</div></div>              
                    <div class="text-info text-center py-0" style="font-size: 12px">COMPETENCIAS - 30%</div>       
                </div>         
                    <div class="progress" style="height: 5px;">
                      <div class="bg-info progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" id="barra_com_3"></div>
                    </div>
                    <div class="text-center text-secondary" style="font-size: 9px"><span id="gap_sec_cump_com_3"></span>% Cumplimiento</div>
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
                    <div class="mt-1 col text-secondary text-left py-0"><span class="h4 fw-bold" id="gap_sec_hab_3"></span><div style="font-size: 9px">GAP</div></div>               
                    <div class="text-warning text-center py-0" style="font-size: 12px">HABILIDADES - 30%</div>       
                </div>         
                    <div class="progress" style="height: 5px;">
                      <div class="bg-warning progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" id="barra_hab_3"></div>
                    </div>
                    <div class="text-center text-secondary" style="font-size: 9px"><span id="gap_sec_cump_hab_3"></span>% Cumplimiento</div>
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
                    <div class="mt-1 col text-secondary text-left py-0"><span class="h4 fw-bold" id="gap_sec_gap_3"></span><div style="font-size: 9px">GAP</div></div>              
                    <div class="text-danger text-center py-0" style="font-size: 12px">GAP TOTAL</div>       
                </div>         
                    <div class="progress" style="height: 5px;">
                      <div class="bg-danger progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" id="barra_gap_3"></div>
                    </div>
                    <div class="text-center text-secondary" style="font-size: 9px"><span id="gap_sec_cump_gap_3"></span>% Cumplimiento</div>
              </div>
            </div>
          </div>
        </div>
          
        <div class="row m-0 p-0">
          <div class="col-8 m-0 p-0">
            <div class="card">
              <div class="card-body p-0">  
                <small>
                  <h5 class="card-title text-secondary ms-3 text-uppercase"style="font-size: 15px" id="tit_3"></h5>
                  <div id="container_3" style="height: 400px;font-size: 10px"></div>
                </small>
              </div>
            </div>
          </div>                
                  
          <div class="col-4 mb-0">
            <div class="card">
              <div class="card-body p-0"> 
                <h5 class=" mt-0 card-title text-secondary ms-3 text-start text-uppercase"style="font-size: 13px" id="tit_jer_3"></h5>
                <small>
                  <div  class=" mt-0" id="container_jer_3" style="font-size: 9px"></div>
                </small>
              </div>
            </div>
          </div>
        </div>

        <div class="card pt-4">
          <div class="card-body small"> 
            <table class="table table-sm small table-striped-columns table-hover mx-auto" style="width: 90%">
              <thead>
                <tr class="fw-bold">
                  <td class="table-primary text-center" style="color: #4B6EAD; width: 40%">GAP - <span id="nom_grp_3"><span></td>
                  <td class="table-primary text-center" style="color: #4B6EAD; width: 10%">Personas</td>
                  <td class="table-primary text-center" style="color: #4B6EAD; width: 10%">Coef. Intelectual</td>
                  <td class="table-primary text-center" style="color: #4B6EAD; width: 10%">Niv. Académico</td>
                  <td class="table-primary text-center" style="color: #4B6EAD; width: 10%">Competencias</td>
                  <td class="table-primary text-center" style="color: #4B6EAD; width: 10%">Habilidades</td>
                  <td class="table-primary text-center fw-bold" style="color: #4B6EAD; width: 10%">GAP TOTAL</td>
                </tr>
              </thead>
              <tbody id="tbody_3"> </tbody>
              <thead>
                <tr class="text-center table-primary">
                  <th class="table-primary" style="color: #4B6EAD">GAP TOTAL</th>
                  <th style="color: #4B6EAD"><span id="tothc_3"></span></th>
                  <th style="color: #4B6EAD"><span id="totci_3"></span>%</th>
                  <th style="color: #4B6EAD"><span id="totna_3"></span>%</th>
                  <th style="color: #4B6EAD"><span id="totcom_3"></span>%</th>
                  <th style="color: #4B6EAD"><span id="tothab_3"></span>%</th>
                  <th style="color: #4B6EAD"><span id="tot_3"></span>%</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>        

        
      <!-------------------------------->
              <div class="row">
                <div class="col-6 h-100">

                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title text-secondary text-uppercase"style="font-size: 14px">Distribución del Talento, según escala de desempeño</h5>
                        <div id="container-escala" style="height: 360px;">
                          <div class="row w-100" class=" d-flex align-items-center" style="height: 280px;">
                            <div class="col">                              
                              <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="col-10">
                                  <div class="row border bg-white" 
                                      style="border-color: #2F526F; height: 34px; position: relative; 
                                              border-bottom-left-radius: 50px; border-top-left-radius: 50px; 
                                              border-bottom-right-radius: 20px; border-top-right-radius: 20px;">
                                    
                                    <div class="col-2 ms-0 ps-0">
                                      <div class="rounded-circle d-flex justify-content-center align-items-center fw-semibold" 
                                          style="background-color: #2F526F; width: 32px; height: 32px; color: white; position: absolute; top: 0px;">
                                        05
                                      </div>
                                    </div>

                                    <div class="col-10 d-flex justify-content-center align-items-center fw-bold">
                                      <div class="col-8 ps-0" style="font-size: 12px; color: #2F526F;">
                                        Excelentes
                                      </div>
                                      <div class="col-4 text-secondary text-end" style="font-size: 14px;">
                                        <span style="color: #2F526F;" >{{ $escalas[106]['Excelente'] ?? 0 }}%</span>
                                      </div>
                                    </div>

                                  </div>  
                                </div>
                              </div>
                            
                              <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="col-10">
                                  <div class="row border bg-white" 
                                      style="border-color: #366A9A; height: 34px; position: relative; 
                                              border-bottom-left-radius: 50px; border-top-left-radius: 50px; 
                                              border-bottom-right-radius: 20px; border-top-right-radius: 20px;">
                                    
                                    <div class="col-2 ms-0 ps-0">
                                      <div class="rounded-circle d-flex justify-content-center align-items-center fw-semibold" 
                                          style="background-color: #366A9A; width: 32px; height: 32px; color: white; position: absolute; top: 0px;">
                                        04
                                      </div>
                                    </div>

                                    <div class="col-10 d-flex justify-content-center align-items-center fw-bold">
                                      <div class="col-8 ps-0" style="font-size: 12px; color: #366A9A;">
                                        Muy Buenos
                                      </div>
                                      <div class="col-4 text-secondary text-end" style="font-size: 14px;">
                                        <span style="color: #366A9A;">{{ $escalas[106]['Muy Bueno'] ?? 0 }}%</span>
                                      </div>
                                    </div>

                                  </div>  
                                </div>
                              </div>                          
                          
                              <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="col-10">
                                  <div class="row border bg-white" 
                                      style="border-color: #447BAC; height: 34px; position: relative; 
                                              border-bottom-left-radius: 50px; border-top-left-radius: 50px; 
                                              border-bottom-right-radius: 20px; border-top-right-radius: 20px;">
                                    
                                    <div class="col-2 ms-0 ps-0">
                                      <div class="rounded-circle d-flex justify-content-center align-items-center fw-semibold" 
                                          style="background-color: #447BAC; width: 32px; height: 32px; color: white; position: absolute; top: 0px;">
                                        03
                                      </div>
                                    </div>

                                    <div class="col-10 d-flex justify-content-center align-items-center fw-bold">
                                      <div class="col-8 ps-0" style="font-size: 12px; color: #447BAC;">
                                        Buenos
                                      </div>
                                      <div class="col-4 text-secondary text-end" style="font-size: 14px;">
                                        <span  style="color: #447BAC;">{{ $escalas[106]['Bueno'] ?? 0 }}%</span>
                                      </div>
                                    </div>

                                  </div>  
                                </div>
                              </div>                          
                            
                              <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="col-10">
                                  <div class="row border bg-white" 
                                      style="border-color: #538CBF; height: 34px; position: relative; 
                                              border-bottom-left-radius: 50px; border-top-left-radius: 50px; 
                                              border-bottom-right-radius: 20px; border-top-right-radius: 20px;">
                                    
                                    <div class="col-2 ms-0 ps-0">
                                      <div class="rounded-circle d-flex justify-content-center align-items-center fw-semibold" 
                                          style="background-color: #538CBF; width: 32px; height: 32px; color: white; position: absolute; top: 0px;">
                                        02
                                      </div>
                                    </div>

                                    <div class="col-10 d-flex justify-content-center align-items-center fw-bold">
                                      <div class="col-8 ps-0" style="font-size: 12px; color: #538CBF;">
                                        Regulares
                                      </div>
                                      <div class="col-4 text-secondary text-end" style="font-size: 14px;">
                                        <span style="color: #538CBF;">{{ $escalas[106]['Regular'] ?? 0 }}%</span>
                                      </div>
                                    </div>

                                  </div>  
                                </div>
                              </div>                          
                            
                              <div class="d-flex justify-content-center align-items-center mb-3">
                                <div class="col-10">
                                  <div class="row border bg-white" 
                                      style="border-color: #629DD1 ; height: 34px; position: relative; 
                                              border-bottom-left-radius: 50px; border-top-left-radius: 50px; 
                                              border-bottom-right-radius: 20px; border-top-right-radius: 20px;">
                                    
                                    <div class="col-2 ms-0 ps-0">
                                      <div class="rounded-circle d-flex justify-content-center align-items-center fw-semibold" 
                                          style="background-color: #629DD1 ; width: 32px; height: 32px; color: white; position: absolute; top: 0px;">
                                        01
                                      </div>
                                    </div>

                                    <div class="col-10 d-flex justify-content-center align-items-center fw-bold">
                                      <div class="col-9 ps-0" style="font-size: 12px; color: #629DD1;">
                                        Deficientes
                                      </div>
                                      <div class="col-3 text-secondary text-end" style="font-size: 14px;">
                                        <span style="color: #629DD1;">{{ $escalas[106]['Deficiente'] ?? 0 }}%</span>
                                      </div>
                                    </div>

                                  </div>  
                                </div>
                              </div>
                            </div>
                            <div class="col text-end">
                              <img src="{{ asset('assets/img/escala.jpg') }}" style="height: 90%;">
                            </div>
                          </div>  
                          <h6 class=" text-secondary text-uppercase"style="font-size: 14px">Desempeño <span id="desempeno_seccion_3"></span> Según Escala</h6>

                          <div class="row border px-4 border-primary bg-light rounded-pill d-flex justify-content-between align-items-center mb-2 fw-bold  text-secondary" style=" height: 40px; font-size: 16px;">
                            <div class="col d-flex justify-content-center">
                              Promedio
                            </div>
                            <div class="col d-flex justify-content-center" style="font-size: 16px;">
                              {{ $escalas_grp[106]['promedio'] ?? 0 }}%
                            </div>
                            <div class="col d-flex justify-content-center">
                              <i class="fa-solid fa-arrow-right-long fa-lg"></i>
                            </div>
                            <div class="col d-flex justify-content-center" style="color: {{ $escalas_grp[106]['color'] ?? '#2F526F' }};">
                              {{ $escalas_grp[106]['categoria'] ?? 0 }}
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="col-6 h-100">
                  <div class="card">
                    <div class="card-body">   
                      <h5 class="card-title text-secondary text-uppercase"style="font-size: 15px">CUMPLIMIENTO VS. GAP Centro de Distribución<br></h5>
                      <div id="container-donuts_3" style="height: 360px;"></div>
                    </div>
                  </div>
                </div>
              </div>
      <!--------------------------------->

    </div>
<script>
    // Verificar los valores pasados desde PHP a JavaScript
    // Convertir los valores de las series a números si es necesario
    let g_tot = @php echo json_encode($g_tot); @endphp;
    let g_cum = @php echo json_encode($g_cum); @endphp;
    let gap_jer_tot = @php echo json_encode($gap_jer_tot); @endphp;

    // Convertir cada valor a un número
    g_tot = g_tot.map(item => Number(item));
    g_cum = g_cum.map(item => Number(item));
    gap_jer_tot = gap_jer_tot.map(item => Number(Number(item).toFixed(3)));
    Highcharts.setOptions({
            accessibility: {
                enabled: false  // Deshabilitar la accesibilidad
            }
        });
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: null
        },
        subtitle: {
            text: null
        },
        xAxis: {
            categories: @php echo json_encode($grupos); @endphp,
            
            labels: {
              style: {
                  fontSize: '11px',  // Ajusta el tamaño de la fuente aquí
                  fontFamily: 'Arial',  // Opcional: cambia la familia de la fuente si lo deseas
                  fontWeight: 'normal'  // Opcional: cambia el peso de la fuente
              }}
        },
        yAxis: {
            min: 0,
            title: {
                text: null
            },
                  labels: {
                      style: {
                          fontSize: '10px',
                          fontFamily: 'Arial',
                          fontWeight: 'normal'
                      }
                  }
        },
        tooltip: {
            //pointFormat: '<span style="color:{series.color}">{series.name}</span>' + ': ({point.percentage:.1f}%)<br/>',
                
            shared: true,
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: {point.y}<br/>',
            
        },
        plotOptions: {
            column: {
                stacking: 'percent',
            }
        },
        legend: {
            align: 'center',
            backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || 'white',
            borderColor: '#CCC',
            borderWidth: 0,
            shadow: false
        },
        series: [{
            name: 'GAP',
            data: g_tot,
            color: '#C2C2C2',
            dataLabels: {
                enabled: true,
                format: '{point.percentage:.1f}%'
            }
        }, {
            name: 'Cumplimiento',
            data: g_cum,
            color: '#4B6EAD', // Colores para cada barra de esta serie
            dataLabels: {
                enabled: true,
                format: '{point.percentage:.1f}%'
            }
        }, {
            type: 'line',
            step: 'center',
            name: 'Objetivo',
            data: [80, 80, 80],
            color: '#47a423',
            marker: {
                lineWidth: 2,
                lineColor: Highcharts.getOptions().colors['#47a423'],
                fillColor: 'white'
            },
            dataLabels: {
                enabled: false  // Desactivar las etiquetas de datos en la serie "Objetivo"
            }
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
          categories: @php echo json_encode($jer_tot); @endphp,
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
          data: gap_jer_tot

      }]
    });

    var Gap_PASTEL = @php echo $gap; @endphp;
    var Cumplimiento_PASTEL = @php echo $cump_gap; @endphp;

    Cumplimiento_PASTEL = parseFloat(Cumplimiento_PASTEL.toFixed(1));
    Gap_PASTEL = parseFloat(Gap_PASTEL.toFixed(1));

    Highcharts.chart('container-donuts', {
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 40,
                beta: 0
            }
        },
        title: {
            text: null,
            style: {
                color: '#aaaaaa',
                fontSize: '16px'
            }
        },
        tooltip: {
            pointFormat: '<b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                innerSize: 100,
                depth: 45,
                allowPointSelect: true,
                cursor: 'pointer',
                slicedOffset: 30,
                dataLabels: {
                    enabled: true,
                    distance: -10, // dentro de la rebanada
                    format: '<div class="text-center" style="text-align:center;font-size:18px; font-weight:bold;">{point.y}%</div><br><div class="text-center" style="text-align:center;font-size:13px; color:#fff;">{point.name}</div>',
                    style: {
                        color: '#fff',
                        fontWeight: 'bold',
                        fontSize: '14px'
                    }
                }
            }
        },
        series: [{
            name: 'Porcentaje',
            data: [
                {
                    name: 'GAP',
                    y: Gap_PASTEL,
                    color: '#909D8E',
                    sliced: true,
                    selected: true
                },
                {
                    name: 'Cumplimiento',
                    y: Cumplimiento_PASTEL,
                    color: '#0267CC',
                    sliced: true,
                    selected: true
                }
            ]
        }]
    });


    

    
</script>



<script>
  // La función crea el gráfico para un grupo determinado
  function crea(x, grupo, unidades, gaps, g_cum, obj,gap_unidades) {
      // Aseguramos que los datos sean convertidos a números (esto puede ser importante si los datos no son numéricos)
      gaps = gaps.map(item => Number(item));
      g_cum = g_cum.map(item => Number(item));
      obj = obj.map(item => Number(item));

      let color = ['#3D84C4','#8CA9DC','#0960AE','#668BD0','#B8D1E7','#79A8D5'];
      
      // Crear las filas de la tabla dinámicamente
      let fila = "";
      let totalCoefInt = 0, totalNivelAcad = 0, totalCompetencias = 0, totalHabilidades = 0, totalGap = 0; totalCumplimiento = 0; totalGap_donuts = 0;tot_hc=0;

      jQuery(gap_unidades).each(function(i, item){
          if(grupo === item.grupo) {
              fila += `<tr>
                          <td class="ps-2">${item.unidad}</td>                          
                          <td class="text-center">${item.HC}</td>
                          <td class="text-center">${parseFloat(item.COEFICIENTE_INTELECTUAL).toFixed(1)}%</td>
                          <td class="text-center">${parseFloat(item.NIVEL_ACADEMICO).toFixed(1)}%</td>
                          <td class="text-center">${parseFloat(item.COMPETENCIAS).toFixed(1)}%</td>
                          <td class="text-center">${parseFloat(item.HABILIDADES).toFixed(1)}%</td>
                          <td class="text-center fw-bold"  style="color: #4B6EAD">${parseFloat(item.GAP).toFixed(1)}%</td>
                        </tr>`;
              
              // Sumar los valores para los totales
              tot_hc+=item.HC;
              totalCoefInt += parseFloat(item.COEFICIENTE_INTELECTUAL);
              totalNivelAcad += parseFloat(item.NIVEL_ACADEMICO);
              totalCompetencias += parseFloat(item.COMPETENCIAS);
              totalHabilidades += parseFloat(item.HABILIDADES);
              totalGap += parseFloat(item.GAP);
              totalCumplimiento 
          }
      });

      // Actualizar el contenido de la tabla con las filas generadas
      $("#tbody_" + x).html(fila);

      // Actualizar los totales de la tabla
      let totalRows = jQuery(gap_unidades).filter(function(i, item) { return grupo === item.grupo }).length;
      $('#tothc_' + x).html(tot_hc); // Promedio de Coef. Intelectual
      $('#totci_' + x).html((totalCoefInt / totalRows).toFixed(1)); // Promedio de Coef. Intelectual
      $('#totna_' + x).html((totalNivelAcad / totalRows).toFixed(1)); // Promedio de Nivel Académico
      $('#totcom_' + x).html((totalCompetencias / totalRows).toFixed(1)); // Promedio de Competencias
      $('#tothab_' + x).html((totalHabilidades / totalRows).toFixed(1)); // Promedio de Habilidades
      $('#tot_' + x).html((totalGap / totalRows).toFixed(1)); // Promedio de GAP
      
                  

      $('#gap_sec_ci_' + x).html((totalCoefInt / totalRows).toFixed(1)+'%'); // Promedio de Coef. Intelectual
      $('#gap_sec_na_' + x).html((totalNivelAcad / totalRows).toFixed(1)+'%'); // Promedio de Coef. Intelectual
      $('#gap_sec_com_' + x).html((totalCompetencias / totalRows).toFixed(1)+'%'); // Promedio de Coef. Intelectual
      $('#gap_sec_hab_' + x).html((totalHabilidades / totalRows).toFixed(1)+'%'); // Promedio de Coef. Intelectual
      $('#gap_sec_gap_' + x).html((totalGap / totalRows).toFixed(1)+'%'); // Promedio de Coef. Intelectual

      $('#gap_sec_cump_ci_' + x).html((100 - (totalCoefInt / totalRows).toFixed(1)));
      $('#gap_sec_cump_na_' + x).html((100 - (totalNivelAcad / totalRows).toFixed(1)));
      $('#gap_sec_cump_com_' + x).html((100 - (totalCompetencias / totalRows).toFixed(1)));
      $('#gap_sec_cump_hab_' + x).html((100 - (totalHabilidades / totalRows).toFixed(1)));
      $('#gap_sec_cump_gap_' + x).html((100 - (totalGap / totalRows).toFixed(1)));

      $('#barra_ci_' + x).css("width", (100 - (totalCoefInt / totalRows).toFixed(1)) + '%');
      $('#barra_na_' + x).css("width", (100 - (totalNivelAcad / totalRows).toFixed(1)) + '%');
      $('#barra_com_' + x).css("width", (100 - (totalCompetencias / totalRows).toFixed(1)) + '%');
      $('#barra_hab_' + x).css("width", (100 - (totalHabilidades / totalRows).toFixed(1)) + '%');
      $('#barra_gap_' + x).css("width", (100 - (totalGap / totalRows).toFixed(1)) + '%');
      totalGap_donuts += parseFloat(( (totalGap / totalRows).toFixed(1)));
      totalCumplimiento += parseFloat((100 - (totalGap / totalRows).toFixed(1)));

      // Título del gráfico
      document.getElementById('tit_' + x).innerHTML = 'Cumplimiento vs. GAP - ' + grupo;
      document.getElementById('nom_grp_' + x).innerHTML = grupo;
      document.getElementById('nom_seccion_' + x).innerHTML = grupo;
      document.getElementById('desempeno_seccion_' + x).innerHTML = grupo;
      

      Highcharts.setOptions({
          accessibility: {
              enabled: false  // Deshabilitar la accesibilidad
          }
      });

      // Crear el gráfico con Highcharts
      Highcharts.chart('container_' + x, {
          chart: {
              type: 'column'  // Tipo de gráfico de columnas
          },
          title: {
              text: null
          },
          xAxis: {
              categories: unidades,  // Las unidades como categorías del eje X
              title: {
                  text: null
              },
              labels: {
                  style: {
                      fontSize: '10px',
                      fontFamily: 'Arial',
                      fontWeight: 'normal'
                  }
              }
          },
          yAxis: {
              min: 0,
              title: {
                  text: null
              },
              labels: {
                  style: {
                      fontSize: '10px',
                      fontFamily: 'Arial',
                      fontWeight: 'normal'
                  }
              }
          },
          tooltip: {
              pointFormat: '<span style="color:{series.color}">{series.name}</span>: {point.y:.1f}<br/>',
              shared: true
          },
          plotOptions: {
              column: {
                  stacking: 'percent',
              }
          },
          legend: {
              align: 'center',
              backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || 'white',
              borderColor: '#CCC',
              borderWidth: 0,
              shadow: false
          },
          series: [{
              name: 'GAP',
              data: gaps,
              color: '#C2C2C2',
              dataLabels: {
                  enabled: true,
                  format: '{point.percentage:.1f}%'
              }
          }, {
              name: 'Cumplimiento',
              data: g_cum,
              color: '#8CA9DC',
              dataLabels: {
                  enabled: true,
                  format: '{point.percentage:.1f}%'
              }
          }, {
              type: 'line',
              step: 'center',
              name: 'Objetivo',
              data: obj,
              color: '#47a423',
              marker: {
                  lineWidth: 2,
                  lineColor: Highcharts.getOptions().colors['#47a423'],
                  fillColor: 'white'
              },
              dataLabels: {
                  enabled: false
              }
          }]
      });




    Highcharts.chart('container-donuts_' + x, {
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 40,
                beta: 0
            }
        },
        title: {
            text: null,
            style: {
                color: '#aaaaaa',
                fontSize: '16px'
            }
        },
        tooltip: {
            pointFormat: '<b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                innerSize: 100,
                depth: 45,
                allowPointSelect: true,
                cursor: 'pointer',
                slicedOffset: 30,
                dataLabels: {
                    enabled: true,
                    distance: -10, // dentro de la rebanada
                    format: '<div class="text-center" style="text-align:center;font-size:18px; font-weight:bold;">{point.y}%</div><br><div class="text-center" style="text-align:center;font-size:13px; color:#fff;">{point.name}</div>',
                    style: {
                        color: '#fff',
                        fontWeight: 'bold',
                        fontSize: '14px'
                    }
                }
            }
        },
        series: [{
            name: 'Porcentaje',
            data: [
                {
                    name: 'GAP',
                    y: totalGap_donuts,
                    color: '#909D8E',
                    sliced: true,
                    selected: true
                },
                {
                    name: 'Cumplimiento',
                    y: totalCumplimiento,
                    color: '#0267CC',
                    sliced: true,
                    selected: true
                }
            ]
        }]
    });

  }
</script>


@php
    // Inicializamos las variables
    $unidades = [];
    $gaps = [];
    $g_cum = [];
    $obj = [];
    $idgrupo = "";
    $grupo = "";
    $x = 0;
@endphp

@foreach ($gap_unidades as $row) 
    @php
        if ($idgrupo == "") {
            // Si es el primer grupo
            $idgrupo = $row->idgrupo;  
            $grupo = $row->grupo;     
            $x++;
        } else {
            // Si es un nuevo grupo
            if ($idgrupo != $row->idgrupo) {  
                // Generamos el gráfico para el grupo anterior

                echo "<script>crea(".$x.", " . json_encode($grupo) . ", " . json_encode($unidades) . ", " . json_encode($gaps) . ", " . json_encode($g_cum) . ", " . json_encode($obj) . ", " . json_encode($gap_unidades) . ");</script>";

                // Reiniciamos las variables para el nuevo grupo
                $unidades = [];
                $gaps = [];
                $g_cum = [];
                $obj = [];
                $idgrupo = $row->idgrupo;  
                $grupo = $row->grupo;     
                $x++;
            }
        }

        // Agregamos los datos del grupo actual al array
        $unidades[] = $row->unidad;  
        $gaps[] = $row->GAP;        
        $g_cum[] = 100 - $row->GAP; // Cumplimiento es 100 - GAP
        $obj[] = 80;
    @endphp
@endforeach

@php
    // Al finalizar el ciclo, generamos el gráfico para el último grupo
    echo "<script>crea(".$x.", " . json_encode($grupo) . ", " . json_encode($unidades) . ", " . json_encode($gaps) . ", " . json_encode($g_cum) . ", " . json_encode($obj) . ", " . json_encode($gap_unidades) . ");</script>";
@endphp

<script>
    // Función que genera el gráfico
    function creajer(x, grupo, jerarquias, gap_jer) {
       // Título del gráfico
        document.getElementById('tit_jer_' + x).innerHTML = 'GAP por Jerarquía - ' + grupo;
        // Convertir los valores de gap_jer a números
        gap_jer = gap_jer.map(item => Number(item));
        Highcharts.setOptions({
          accessibility: {
              enabled: false  // Deshabilitar la accesibilidad
          }
      });
        // Crear el gráfico con Highcharts
        Highcharts.chart('container_jer_' + x, {
            chart: {
                type: 'bar'  // Tipo de gráfico de barras
            },
            title: {
                text: null  // Sin título
            },
            subtitle: {
                text: null  // Sin subtítulo
            },
            xAxis: {
                categories: jerarquias,  // Asignar las categorías de las jerarquías
                title: {
                    text: null  // Sin título en el eje X
                },
                gridLineWidth: 1,  // Estilo de las líneas de la cuadrícula
                lineWidth: 0,  // Sin línea en el eje
                labels: {
                    style: {
                        fontSize: '11px',  // Ajustar el tamaño de la fuente
                        fontFamily: 'Arial',  // Fuente de la etiqueta
                        fontWeight: 'normal'  // Peso de la fuente
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: null  // Sin título en el eje Y
                },
                labels: {
                    overflow: 'justify'  // Para asegurarnos que las etiquetas no se desborden
                },
                gridLineWidth: 0  // Sin líneas de cuadrícula en el eje Y
            },
            tooltip: {
                valueSuffix: '%'  // Agregar el símbolo de porcentaje en el tooltip
            },
            plotOptions: {
                bar: {
                    borderRadius: '30%',  // Redondear las barras
                    dataLabels: {
                        enabled: true,  // Habilitar las etiquetas de datos en las barras
                        formatter: function() {
                            return this.y.toFixed(1) + '%';  // Mostrar los valores con un decimal
                        },
                        style: {
                            color: '#000000'  // Color del texto de las etiquetas de datos
                        }
                    },
                    groupPadding: 0.1  // Ajustar el espacio entre las barras
                }
            },
            credits: {
                enabled: false  // Deshabilitar los créditos de Highcharts
            },
            series: [{
                name: 'GAP',  // Nombre de la serie de datos
                data: gap_jer  // Los datos de la serie (valores de GAP)
            }]
        });
    }
</script>


@php
    // Inicializamos las variables
    $jerarquias = [];
    $gap_jer = [];
    $idgrupo = "";
    $grupo = "";
    $x = 0;
@endphp

@foreach ($gap_jer_unidades as $row) 
    @php
        if ($idgrupo == "") {
            // Si es el primer grupo
            $idgrupo = $row->idgrupo;  
            $grupo = $row->grupo;     
            $x++;
        } else {
            // Si es un nuevo grupo
            if ($idgrupo != $row->idgrupo) {  
                // Generamos el gráfico para el grupo anterior
                echo "<script>creajer(".$x.", " . json_encode($grupo) . ", " . json_encode($jerarquias) . ", " . json_encode($gap_jer) . ");</script>";

                // Reiniciamos las variables para el nuevo grupo
                $jerarquias = [];
                $gap_jer = [];
                $idgrupo = $row->idgrupo;  
                $grupo = $row->grupo;     
                $x++;
            }
        }

        // Agregamos los datos del grupo actual al array
        $jerarquias[] = $row->jerarquia;  
        $gap_jer[] = $row->gap_jer;         
    @endphp
@endforeach

@php
    // Al finalizar el ciclo, generamos el gráfico para el último grupo
 echo "<script>creajer(".$x.", " . json_encode($grupo) . ", " . json_encode($jerarquias) . ", " . json_encode($gap_jer) . ");</script>";
@endphp



@endsection