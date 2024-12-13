<!doctype html>
<html lang="en">
    <head>
        <title>Evaluación de Desempeño</title>
        <!-- Required meta tags -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport"  content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    </head>

  <style> .rounded-circle {  border-radius: 50% !important;}
    /* Barra de progreso principal */
    .progress {
        width: 100%;
        height: 15px;  
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        overflow: hidden; /* Asegura que los elementos flotantes no se desborden */
    }

    /* Cada segmento de la barra de progreso */
    .progress-segment {
        height: 100%;
        line-height: 15px;
        text-align: center;
        float: left; /* alinear horizontalmente */      
    }
    @page{
      margin: 2cm 0.5cm 2cm 0.5cm;
    }
    #header{
      position: fixed;
      top: -1.5cm;
      left: 0cm;
      width: 100%;
    }
    .imgheader{
      width: 5cm;
    }

    #footer{
      position: fixed;
      text-align: center;
      font-size: 10px;
      bottom: -1.5cm;
      left: 0cm;
      width: 100%;
      color: #a7a8aa;
    }
    .textfooter{
      text-align: center;
      width: 100%; 
    }
  </style>
   @php    $array[] =  json_decode($data);@endphp
   @foreach ($array as $item)
    @php
        $feval= $item->feval;
        $id_evdo= $item->id_evdo;
        $nom_evaluado= $item->nom_evaluado;
        $photo= $item->photo;
        $finicio= $item->finicio;
        $resultado= $item->resultado;
        $categoria= $item->categoria;
        $color= $item->color;
        $evaluado= $item->evaluado;   
        $logros= $item->logros;
        $comentarios= $item->comentarios;
        $carrera= $item->carrera;

        $resp_curcomp = $item->resp_curcomp;    
        $resp_curhab  = $item->resp_resp_curhab;
        $resp_curadic  = $item->resp_curadic;
        $resp_comp = $item->resp_comp;

        $resp_kpi = $item->res_kpi;
        $resp_kpi_cumpli = $item->resp_kpi_cumpli;

        $resp_respon = $item->resp_respon;
        $resp_tar = $item->resp_tar;
        $resp_hab = $item->resp_hab;
        $resp_cursos = $item->resp_cursos;
        $imgData = $item->imgData;

    @endphp
   @endforeach
    @foreach ($evaluado as $array2 )
      @php
        $despue= $array2->descpue;
        $nameund= $array2->nameund;
      @endphp
    @endforeach
    
      <body>
        
        <div id="header">
          <img class="imgheader" src="{{ public_path('assets/img/Ft2.png') }}" >
        <hr>
        </div>
        <div id="footer">
          {{ $nom_evaluado }}
        </div>
        
        <div id="container"> 
                     
          <div class="card mb-3">
            <div class="card-header py-0 text-secondary">
              <h5> Evaluación de Desempeño</h5>              
            </div>
            <div class="card-body">
              <table>
                <tr>
                  <td style="text-align: justify; vertical-align: middle;text-align: center;" width="35%">
                    <span> @php echo $photo; @endphp</span>
                    <h6 class="text-primary small pt-2"><b>{{ $nom_evaluado }}</b></h6>
                  </td>
                  <td style="text-align: justify; vertical-align: middle;" width="65%">
                    <div class="row">
                      <div class="col text-secondary small ml-2"><b>F. Evaluación:</b><span class="text-uppercase ml-2">{{ $feval }} </span></div>  
                      <div class="col text-secondary small ml-2"><b>Código:</b><span class="text-uppercase ml-2">{{ $id_evdo }} </span></div>            
                      <div class="col text-secondary small ml-2"><b>Posición:</b><span class="text-uppercase ml-2">{{ $despue }}</span></div>
                      <div class="col text-secondary small ml-2"><b>Departamento:</b><span class="text-uppercase ml-2">{{ $nameund }}</span></div>
                      <div class="col text-secondary small ml-2"><b>Fecha de Ingreso:</b><span class="text-uppercase ml-2"> {{ $finicio }}</span></div>
                      <div class="col text-secondary small ml-2"><b>Resultado:</b><span class="text-uppercase ml-2 text-primary"> {{ $resultado }}%</span></div>
                      <div class="col text-secondary small ml-2"><b>Categoría:</b><span style="color:{{ $color }}" class="ml-2"> {{ $categoria }}</span></div>
                    </div>
                  </td>
                </tr>
              </tr>
            </table>
            <table>
                <tr>
                  <td width="50%">
                    <small>
                    <table id="table_resp_cumpli_pid" class="table table-sm small" style="width:100%">
                        <tr>
                          <th width="55%"></th>
                          <th class="text-primary text-center" width="15%" >VALOR</th>
                          <th class="text-primary text-center" width="15%" >PERSONA</th>
                          <th class="text-primary text-center" width="15%" >GAP</th>
                        </tr>
                      <tbody class="text-dark" id="tbody_resp_eval">
                        @php $band= 0; $total_peso=0; $total_pts=0; $total_gap=0; $total_comp=0; @endphp

                        @if (count($resp_comp)>0)
                          @php                      
                            $tot_peso= 0; $tot_pts = 0; $tot_gap= 0; $band= 1;
                          @endphp
                          @foreach ($resp_comp as $array3 )
                            @php                            
                              $tipo="";                     
                              $total_comp= $total_comp + $array3->obtenido;
                              $tot_peso= $tot_peso + $array3->peso;
                              $tot_pts= $tot_pts + $array3->obtenido;
                              $tot_gap= $tot_gap + $array3->gap;
                              $total_peso= $total_peso + $array3->peso;
                              $total_pts= $total_pts + $array3->obtenido;
                              $total_gap= $total_gap + $array3->gap;
                            @endphp
                          @endforeach
                        @endif
                        
                        @if ($band==1)
                          <tr><td class="text-left">Competencias Organizacionales </td>
                          <td class="text-center">{{ round($tot_peso,0) }}% </td>
                          <td class="text-center">{{ round($tot_pts,1) }}%</td>
                          <td class="text-center">{{ round($tot_gap,1) }}%</td></tr>
                        @endif
                        
                        @php $band= 0; @endphp
                        @if (count($resp_respon)>0)
                          @php                      
                            $tot_peso= 0; $tot_pts = 0; $tot_gap= 0; $band= 1;
                          @endphp
                          @foreach ($resp_respon as $array3 )
                            @php                            
                              $tipo="";                            
                              $tot_peso= $tot_peso + $array3->peso;
                              $tot_pts= $tot_pts + $array3->obtenido;
                              $tot_gap= $tot_gap + $array3->gap;
                              $total_peso= $total_peso + $array3->peso;
                              $total_pts= $total_pts + $array3->obtenido;
                              $total_gap= $total_gap + $array3->gap;
                            @endphp
                          @endforeach
                        @endif
                        
                        @if ($band==1)
                          <tr><td class="text-left">Tareas y Funciones </td>
                          <td class="text-center">{{ round($tot_peso,0) }}% </td>
                          <td class="text-center">{{ round($tot_pts,1) }}%</td>
                          <td class="text-center">{{ round($tot_gap,1) }}%</td></tr>
                        @endif
                    
                        @php $band= 0; @endphp
                        @if (count($resp_hab)>0)
                          @php                      
                            $tot_peso= 0; $tot_pts = 0; $tot_gap= 0; $band= 1;
                          @endphp
                          @foreach ($resp_hab as $array3 )
                            @php                            
                              $tipo="";                            
                              $tot_peso= $tot_peso + $array3->peso;
                              $tot_pts= $tot_pts + $array3->obtenido;
                              $tot_gap= $tot_gap + $array3->gap;
                              $total_peso= $total_peso + $array3->peso;
                              $total_pts= $total_pts + $array3->obtenido;
                              $total_gap= $total_gap + $array3->gap;
                            @endphp
                          @endforeach
                        @endif
                        
                        @if ($band==1)
                          <tr><td class="text-left">Habilidades y Conocimientos </td>
                          <td class="text-center">{{ round($tot_peso,0) }}% </td>
                          <td class="text-center" style="vertical-align: middle; text-center">{{ round($tot_pts,1) }}%</td>
                          <td class="text-center">{{ round($tot_gap,1) }}%</td></tr>
                        @endif





                    
                        @php $band= 0; @endphp
                        @if (count($resp_kpi_cumpli)>0)
                          @php                      
                            $tot_peso= 0; $tot_pts = 0; $tot_gap= 0; $band= 1;
                          @endphp
                          @foreach ($resp_kpi_cumpli as $array3 )
                            @php                            
                              $tipo="";                            
                              $tot_peso= $tot_peso + $array3->peso;
                              $tot_pts= $tot_pts + $array3->obtenido;
                              $tot_gap= $tot_gap + ($array3->peso-$array3->obtenido);
                              
                              $total_peso= $total_peso + $array3->peso;
                              $total_pts= $total_pts + $array3->obtenido;
                              $total_gap= $total_gap + ($array3->peso-$array3->obtenido);
                            @endphp
                          @endforeach
                        @endif
                        
                        @if ($band==1)
                          <tr><td class="text-left">Cumplimiento de KPI </td>
                          <td class="text-center">{{ round($tot_peso,0) }}% </td>
                          <td class="text-center" style="vertical-align: middle; text-center">{{ round($tot_pts,1) }}%</td>
                          <td class="text-center">{{ round($tot_gap,1) }}%</td></tr>
                        @endif



                    
                        @php $band= 0; @endphp
                        @if (count($resp_cursos)>0)
                          @php                      
                            $tot_peso= 0; $tot_pts = 0; $tot_gap= 0; $band= 1;
                          @endphp
                          @foreach ($resp_cursos as $array3 )
                            @php                            
                              $tipo="";                            
                              $tot_peso= $tot_peso + $array3->peso;
                              $tot_pts= $tot_pts + $array3->obtenido;
                              $tot_gap= $tot_gap + $array3->gap;
                              $total_peso= $total_peso + $array3->peso;
                              $total_pts= $total_pts + $array3->obtenido;
                              $total_gap= $total_gap + $array3->gap;
                            @endphp
                          @endforeach
                        @endif
                        
                        @if ($band==1)
                          <tr><td class="text-left">Cumplimiento de PID </td>
                          <td class="text-center">{{ round($tot_peso,0) }}% </td>
                          <td class="text-center" style="vertical-align: middle; text-center">{{ round($tot_pts,1) }}%</td>
                          <td class="text-center">{{ round($tot_gap,1) }}%</td></tr>
                        @endif

                      </tbody>
                      <tr>
                        <th class="text-center text-primary" >TOTAL</th>
                        <th class="text-center text-primary" >{{ round($total_peso,1) }}%</th>
                        <th class="text-center text-primary" >{{ round($total_pts,1) }}%</th>
                        <th class="text-center text-primary" >{{ round($total_gap,1) }}%</th>
                      </tr>
                    </table>
                    </small>
                  </td>
                  <td width="50%"> 
                        
                          <div id="graf">@php echo $imgData; @endphp</div>             
                        
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <small>
          <div class="card mb-3 border border-info" style="background-color: #F3F8FF">
            <div class="card-body p-0">                         
              <label class="card-title text-primary pl-2 h6" > Plan Individual de Desarrollo</label>
                <!-- PID DE COMPETENCIAS-->
                @if (count($resp_curcomp)>0)
                    <table id="table_resp_curcomp" class="table table-sm small table-borderless pl-2 pt-0" >
                      <thead>
                        <tr>
                          <td class="text-primary text-sm" style="text-align: left; background-color: #F3F8FF;"width="30%">COMPETENCIAS DE MAYOR GAP</td>
                          <td class="text-primary text-sm" style="text-align: left; background-color: #F3F8FF;"width="40%">CURSOS ASIGNADOS</td>
                          <td class="text-primary text-sm" style="text-align: left; background-color: #F3F8FF;"width="20%">FECHA</td>
                        </tr>
                      </thead>
                      <tbody class="text-dark" id="tbody_resp_curcomp">
                        @foreach ($resp_curcomp as $array3 )  
                        @php 
                        $fecha='';
                        if($array3->fecha!=null)
                        {
                          $fecha=explode("-", $array3->fecha);
                          $fecha=$fecha[2].'-'.$fecha[1].'-'.$fecha[0];
                        }
                        @endphp
                        <tr>
                          <td class="pl-4"><li>{{ $array3->comp }}</li></td>
                          <td class="pl-4"><li>{{ $array3->curso }}</li></td>
                          <td class="pl-4"><li>{{ $fecha }}</li></td>
                        </tr>
                        @endforeach  
                      </tbody>            
                    </table>
                @endif                    

                <!-- PID DE HABILIDADES-->   
                  @if (count($resp_curhab)>0)
                    <table id="table_resp_curhab" class="table table-sm small table-borderless pl-2 pt-0" >
                      <thead>
                        <tr>
                          <td class="text-primary text-sm" style="text-align: left; background-color: #F3F8FF;">CURSOS ASIGNADOS PARA HABILIDADES FUNCIONALES</td>  
                          <td class="text-primary text-sm" style="text-align: left; background-color: #F3F8FF;"width="40%">FECHA</td>              
                        </tr>
                      </thead>
                      <tbody class="text-dark" id="tbody_resp_curhab">
                        @foreach ($resp_curhab as $array3 )                        
                        @php 
                        $fecha='';
                        if($array3->fecha!=null)
                        {
                          $fecha=explode("-", $array3->fecha);
                          $fecha=$fecha[2].'-'.$fecha[1].'-'.$fecha[0];
                        }
                        @endphp
                          <tr>
                            <td class="pl-4"><li>{{ $array3->curso }}</li></td>
                            <td class="pl-4"><li>{{ $fecha }}</li></td>
                          </tr>
                        @endforeach 
                      </tbody>        
                    </table>
                  @endif                  

                <!-- PID DE ADICIONALES-->  
                  @if (count($resp_curadic)>0)    
                              
                    <table id="table_resp_curadic" class="table table-sm small table-borderless pl-2 pt-0" >
                      <thead>
                        <tr>
                          <td colspan="3" class="text-primary text-sm" style="text-align: left; background-color: #F3F8FF;">CURSOS ADICIONALES</td>               
                        </tr>
                        <tr>
                          <th class="text-secondary text-sm" style="text-align: left; background-color: #F3F8FF;">ÁREA DE DESARROLLO</th> 
                          <th class="text-secondary text-sm" style="text-align: left; background-color: #F3F8FF;">CURSO ASIGNADO</th>         
                          <th class="text-secondary text-sm" style="text-align: left; background-color: #F3F8FF;">OTRAS ACCIONES ESPECÍFICAS</th>          
                        </tr>
                      </thead>
                      <tbody class="text-dark" id="tbody_resp_curadic">
                        @foreach ($resp_curadic as $array3 )
                          <tr>
                            <td class="pl-4"><li>{{ $array3->area }}</li></td>
                            <td class="pl-4"><li>{{ $array3->curso }}</li></td>
                            <td class="pl-4"><li>{{ $array3->accion }}</li></td>
                          </tr>
                        @endforeach </tbody>            
                    </table>
                  @endif
            </div>
          </div>
          @if (count($resp_comp)>0)     
            <div class="card shadow mb-3 p-0"> 
              <div class="card-header text-info pl-2 p-1">
                <i class="fas fa-list-ol fa-lg"></i> Competencias Organizacionales
              </div>
              <div class="card-body justify-content-center p-1">
                <div class="row justify-content-center align-items-center text-center">
                  <div class="col-auto text-center">       
                    <table class="table table-sm small" style="width:100%">
                        <tr>
                          <th class="text-primary text-center" width="55%">VALORACIÓN</th>
                          <th class="text-primary text-center" width="15%" ></th>
                          <th class="text-primary text-center" width="10%" >VALOR</th>
                          <th class="text-primary text-center" width="10%" >PERSONA</th>
                          <th class="text-primary text-center" width="10%" >GAP</th>
                        </tr>
                      <tbody class="text-dark">
                        @php                            
                            $tot_pts_comp = 0;
                            $tot_peso_comp= 0;
                            $tot_gap_comp= 0;
                        @endphp
                        @foreach ($resp_comp as $array3 )
                          @php                            
                            $tipo="";                            
                            $numero_peso=round($array3->peso,1);
                            $numero_pts=round($array3->obtenido,1);
                            $numero_gap=round($array3->gap,1);
                          @endphp         
                          @if($array3->prf==8)@php $tipo="Crítica";@endphp @endif
                          @if($array3->prf==7)@php $tipo="Muy Importante";@endphp @endif
                          @if($array3->prf==6)@php $tipo="Importante";@endphp @endif
                          @php
                            $extinf_min= 0;
                            $extsup_max= 0;                    
                            $extesperado= $array3->prf * 10;
                            $val_obtenido= $array3->opt * 10;

                            $tot_pts_comp = $tot_pts_comp + $array3->obtenido;
                            $tot_peso_comp= $tot_peso_comp + $array3->peso;
                            $tot_gap_comp= $tot_gap_comp + $array3->gap;
                          @endphp
                          @if($val_obtenido <= ($array3->prf)*10)
                            @php $extinf_min= (($array3->prf)*10)-$val_obtenido;@endphp
                          @else
                            @php $extinf_min= 0;@endphp
                          @endif
                          @if(($val_obtenido + $extinf_min) >= ($array3->prf)*10)
                            @php $extesperado=20-(($val_obtenido + $extinf_min)-($array3->prf*10));@endphp
                          @endif
                        <tr>
                          <td class="pb-2">{{ $array3->comp }}                            
                            <div class="progress">
                              <div class="progress-segment bg-primary" role="progressbar" style="width: {{ $val_obtenido }}%; border-radius: 5px; color:#fff" aria-valuenow="{{ $val_obtenido }}" aria-valuemin="0" aria-valuemax="10"><b>{{ $array3->opt }}</b></div>
                              <div class="progress-segment text-dark" role="progressbar" style="width: {{ $extinf_min }}%; background: #E9ECEF; float: left;" aria-valuenow="{{ $extinf_min }}" aria-valuemin="0" aria-valuemax="10"></div>
                              <div class="progress-segment" role="progressbar" style="width: {{ $extesperado }}%; background: #ADB8C3; float: left;" aria-valuenow="{{ $extesperado }}" aria-valuemin="0" aria-valuemax="10"></div>
                            </div>
                          </td>
                          <td style="text-align: center; vertical-align: middle;">{{ $tipo }}</td>
                          <td style="text-align: center; vertical-align: middle;">{{ $numero_peso }}</td>
                          <td style="text-align: center; vertical-align: middle;">{{ $numero_pts }}</td>
                          <td style="text-align: center; vertical-align: middle;">{{ $numero_gap }}</td>
                        </tr>
                        @endforeach
                      </tbody>
                      <tr class="table-primary">
                        <th class="text-primary text-center" colspan="2" ><small>TOTAL</small></th>
                        <th class="text-primary text-center" ><span id="tot_pts_comp">{{ round($tot_peso_comp,0) }}</span></th>
                        <th class="text-primary text-center" ><span id="tot_cumpli_comp">{{ round($tot_pts_comp,1) }}</span></th>
                        <th class="text-primary text-center" ><span id="tot_gap_comp">{{ round($tot_gap_comp,1) }}</span></th>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            @endif
            @if (count($resp_respon)>0)     
              <div class="card shadow mb-3"> 
                <div class="card-header text-info pl-2 p-1">
                  <i class="fas fa-list-ol fa-lg"></i> Tareas y Funciones
                </div>
                <div class="card-body justify-content-center p-1">
                  
                  <div class="row justify-content-center align-items-center text-center">
                    <div class="col-auto text-center">       
                      <table class="table table-sm small" style="width:100%">
                          <tr>
                            <th class="text-primary text-center"width="70%">ÁREAS DE RESPONSABILIDAD</th>
                            <th class="text-primary text-center" width="10%" >VALOR</th>
                            <th class="text-primary text-center" width="10%" >PERSONA</th>
                            <th class="text-primary text-center" width="10%" >GAP</th>
                          </tr>
                        <tbody class="text-dark">
                          @php                            
                            $tot_pts = 0;
                            $tot_peso= 0;
                            $tot_gap= 0;
                          @endphp
                          @foreach ($resp_respon as $array3 )
                          @php
                              $tot_pts = $tot_pts + $array3->obtenido;
                              $tot_peso = $tot_peso + $array3->peso;
                              $tot_gap = $tot_gap + $array3->gap;
                          @endphp
                          <tr>
                            <td class="text-left">{{ $array3->respon }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ round($array3->peso,1) }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ round($array3->obtenido,1) }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ round($array3->gap,1) }}</td>
                          </tr>
                          @endforeach
                        </tbody>
                        <tr class="table-primary">
                          <th class="text-primary text-center" ><small>TOTAL</small></th>
                          <th class="text-primary text-center" >{{ round($tot_peso,0) }}</th>
                          <th class="text-primary text-center" >{{ round($tot_pts,1) }}</th>
                          <th class="text-primary text-center" >{{ round($tot_gap,1) }}</th>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            @endif
            @if (count($resp_hab)>0)     
              <div class="card shadow mb-3"> 
                <div class="card-header text-info pl-2 p-1">
                  <i class="fas fa-list-ol fa-lg"></i> Habilidades y Conocimientos
                </div>
                <div class="card-body justify-content-center p-1">
                  
                  <div class="row justify-content-center align-items-center text-center">
                    <div class="col-auto text-center">       
                      <table class="table table-sm small" style="width:100%">
                          <tr>
                            <th class="text-primary text-center"width="55%">HABILIDADES</th>
                            <th class="text-primary text-center" width="15%" >EVALUACIÓN</th>
                            <th class="text-primary text-center" width="10%" >VALOR</th>
                            <th class="text-primary text-center" width="10%" >PERSONA</th>
                            <th class="text-primary text-center" width="10%" >GAP</th>
                          </tr>
                        <tbody class="text-dark">
                          @php                            
                            $tot_pts = 0;
                            $tot_peso= 0;
                            $tot_gap= 0;
                          @endphp
                          @foreach ($resp_hab as $array3 )
                          @php
                              $tot_pts = $tot_pts + $array3->obtenido;
                              $tot_peso = $tot_peso + $array3->peso;
                              $tot_gap = $tot_gap + $array3->gap;
                          @endphp
                          @php $dato="";@endphp
                          @if($array3->opt==0)@php $dato="No la tiene"; @endphp @endif
                          @if($array3->opt==3)@php $dato="Esta en Desarrollo"; @endphp @endif
                          @if($array3->opt==5)@php $dato="Si la tiene"; @endphp @endif
                          <tr>
                            <td class="text-left">{{ $array3->hab }}</td>
                            <td style="text-align: center; vertical-align: middle;" class="text-primary text-small">{{ $dato }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ round($array3->peso,1) }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ round($array3->obtenido,1) }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ round($array3->gap,1) }}</td>
                          </tr>
                          @endforeach
                        </tbody>
                        <tr class="table-primary">
                          <th class="text-primary text-center" colspan="2"><small>TOTAL</small></th>
                          <th class="text-primary text-center" >{{ round($tot_peso,0) }}</th>
                          <th class="text-primary text-center" >{{ round($tot_pts,1) }}</th>
                          <th class="text-primary text-center" >{{ round($tot_gap,1) }}</th>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            @endif

            @if (count($resp_kpi_cumpli)>0)     
              <!--- RESPUESTAS CUMPLIMIENTO KPI -->
              <div class="card shadow mb-3">  
                <div class="card-header text-info pl-2 p-1">
                  <i class="fa-solid fa-chart-line pe-2"></i> Cumplimiento de Metas
                </div>
                <div class="card-body justify-content-center p-1">
                  
                  <div class="row justify-content-center align-items-center text-center">
                    <div class="col-auto text-center">             
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
                          @foreach ($resp_kpi_cumpli as $array3 )
                            @php
                                $tot_pts = $tot_pts + $array3->obtenido;
                                $tot_peso = $tot_peso + $array3->peso;
                                $tot_gap = $tot_gap + ($array3->peso - $array3->obtenido);
                            @endphp
                            <tr class="table-primary">
                              <td class="text-center text-primary fw-bold">PROMEDIO DE CUMPLIMIENTO DE METAS</td>
                              <td style="text-align: center; vertical-align: middle;" class="text-primary text-small fw-bold">{{ $array3->cumplimiento_promedio }}</td>
                              <td style="text-align: center; vertical-align: middle;" class="text-primary text-small fw-bold">{{ round($array3->peso,1) }}</td>
                              <td style="text-align: center; vertical-align: middle;" class="text-primary text-small fw-bold">{{ round($array3->obtenido,1) }}</td>
                              <td style="text-align: center; vertical-align: middle;" class="text-primary text-small fw-bold">{{ round($tot_gap,1) }}</td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>      
  
                    
                      <table class="table table-striped table-sm small" style="width:60%; margin-left:20%;">
                        <thead>
                          <tr>
                            <th class="text-secondary text-center table-info" width="70%" style="padding:1;">INDICADOR</th>
                            <th class="text-secondary text-center table-info" width="30%" style="padding:1;">% CUMPLIMIENTO</th>
                          </tr>
                        </thead>
                        <tbody >
                          @foreach ($resp_kpi as $array3 )
                          <tr>
                            <td class="text-center" style="padding:1;">{{ $array3->nom_kpi }}</td>
                            <td style="text-align: center; vertical-align: middle; padding:0; margin:0" class="text-primary text-small">{{ round($array3->real,1) }}</td>
                            
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    
                    
                  </div> 
                </div>
              </div>
            @endif


            @if (count($resp_cursos)>0)     
              <div class="card shadow mb-3">  
                <div class="card-header text-info pl-2 p-1">
                  <i class="fas fa-list-ol fa-lg"></i> Cumplimiento de Plan Individual de Desarrollo
                </div>
                <div class="card-body justify-content-center p-1">
                  
                  <div class="row justify-content-center align-items-center text-center">
                    <div class="col-auto text-center">       
                      <table class="table table-sm small" style="width:100%">
                          <tr>
                            <th class="text-primary text-center"width="55%">CURSOS</th>
                            <th class="text-primary text-center" width="15%" >NOTA</th>
                            <th class="text-primary text-center" width="10%" >VALOR</th>
                            <th class="text-primary text-center" width="10%" >PERSONA</th>
                            <th class="text-primary text-center" width="10%" >GAP</th>
                          </tr>
                        <tbody class="text-dark">
                          @php                            
                            $tot_pts = 0;
                            $tot_peso= 0;
                            $tot_gap= 0;
                          @endphp
                          @foreach ($resp_cursos as $array3 )
                          @php
                              $tot_pts = $tot_pts + $array3->obtenido;
                              $tot_peso = $tot_peso + $array3->peso;
                              $tot_gap = $tot_gap + $array3->gap;
                          @endphp
                          @php $dato="";@endphp
                          @if($array3->opt==0)@php $dato="No la tiene"; @endphp @endif
                          @if($array3->opt==3)@php $dato="Esta en Desarrollo"; @endphp @endif
                          @if($array3->opt==5)@php $dato="Si la tiene"; @endphp @endif
                          <tr>
                            <td class="text-left">{{ $array3->curso }}</td>
                            <td style="text-align: center; vertical-align: middle;" class="text-primary text-small">{{ $array3->opt }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ round($array3->peso,1) }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ round($array3->obtenido,1) }}</td>
                            <td style="text-align: center; vertical-align: middle;">{{ round($array3->gap,1) }}</td>
                          </tr>
                          @endforeach
                        </tbody>
                        <tr class="table-primary">
                          <th class="text-primary text-center" colspan="2"><small>TOTAL</small></th>
                          <th class="text-primary text-center" >{{ round($tot_peso,0) }}</th>
                          <th class="text-primary text-center" >{{ round($tot_pts,1) }}</th>
                          <th class="text-primary text-center" >{{ round($tot_gap,1) }}</th>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            @endif

            <div class="card shadow mb-3 " id="resp_desarrollo"> 
              <div class="card-body p-0">
                <div class="mb-3 ">
                  <label class="card-title pl-2 text-info"><i class="fas fa-user-tag pe-2"></i> Logros del Colaborador</label>
                  <div class="col pl-4 small">
      
                    @if(strlen($logros)>0)
                      @php echo nl2br(e($logros)) @endphp
                    @endif
                      
                  </div>
                </div>

                <hr>
      
                <div>
                  <label class="card-title pl-2 text-info"><i class="fas fa-user-tie pl-2"></i> Proyección de Desarrollo de Carrera</label>
                  <div class="col pl-4 small mb-3">
                    @php $cad="";@endphp
                    @if(strlen($carrera)==0)  @php $cad="Promoverlo de forma inmediata";@endphp @endif
                    @if(strlen($carrera)==1)  @php $cad="Promoverlo a mediano plazo (1 a 2 años)";@endphp @endif
                    @if(strlen($carrera)==2)  @php $cad="Promoverlo a largo plazo (3 a 5 años)";@endphp @endif
                    @if(strlen($carrera)==3)  @php $cad="No se contempla actualmente";@endphp @endif
                      {{ $cad }}
                  </div>
                </div>


                <hr>      
                
                <div class="mb-3">
                  <label class="card-title pl-2 text-info"><i class="fas fa-comment-dots pe-2"></i> Comentarios del Evaluador</label>
                  <div class="col pl-4 small">
      
                    @if(strlen($comentarios)>0)
                      @php echo nl2br(e($comentarios)) @endphp
                    @endif
                      
                  </div>
                </div>
                

              </div>
            </div>
          </small>
 </div>

      </body>        
 
      </html>