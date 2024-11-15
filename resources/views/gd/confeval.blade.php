<!DOCTYPE html>
@extends('layouts.plantilla')
@section('title','Administración de Evaluaciones')
@section('content')
<!-- JavaScript -->
<script type="text/javascript">
    function preloader(){
        document.getElementById("preload").style.display = "none";
        document.getElementById("iframe").style.display = "block";
    }     
     window.onload = preloader;
</script>

<div class="card mb-3">
    <div class="card-header pb-0">
      <h4><i class="fas fa-cogs fa-lg"></i> Configuración de Evaluación del Desempeño</h4>
    </div>
    <div class="card-body">
      <small>
        <div id="preload" class="align-items-center justify-content-center text-center p-4 mt-4"><div class=" mt-4 spinner-border text-primary" role="status"></div></div>
      </small>        
          <div id="iframe" style="display: none;">
            
            <!-- LISTADO DE EVALUACIONES-->
            <div id="lista_eval" class="mt-4"style="text-align: center; vertical-align: middle;">
              <div class="row">

                <div class="d-grid gap-2 d-md-flex justify-content-md-end" onclick="modalcrud()">
                    <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-bs-toggle="modal" data-bs-target="#Modal">
                      <span class="text fw-bold"> <i class="fas fa-plus pr-2"></i> Nueva Evaluación</span>
                    </a>
                </div>
          </div>
        <hr>
              <div class="row">                
                <div class="col">
                  <table  id="MyTable_eval" class="table small table-sm table-striped table-hover" style="width:100%">
                    <thead class="bg-info">
                      <tr>
                        <th class="text-light text-center bg-info" width="25%" >NOMBRE</th>
                        <th class="text-light text-center bg-info" width="15%" >ESTATUS</th>
                        <th class="text-light text-center bg-info" width="15%" >DESDE</th>
                        <th class="text-light text-center bg-info" width="15%" >HASTA</th>
                        <th class="text-light text-center bg-info" width="15%" >POBLACIÓN</th>
                        <th class="text-light text-center bg-info" width="15%" ><i class="fas fa-cogs fa-lg"></i></th>
                      </tr>
                    </thead>
                    <tbody class="text-dark" id="tbody_list_eval">  
                      @foreach( $evaluaciones as $pos )
                        @php if($pos->status==1){ $status='<span class="border border-success rounded text-success py-1 ps-2 pe-2 fw-bold"><i class="fas fa-check-circle fa-lg pe-2"></i>Activa </span>';}
                        @endphp
                        <tr>
                          <td style="text-align: center; vertical-align: middle;">{{ $pos->observacion }}</td>
                          <td style="text-align: center; vertical-align: middle;">@php echo $status; @endphp</td>
                          <td style="text-align: center; vertical-align: middle;">{{ $pos->desde }}</td>
                          <td style="text-align: center; vertical-align: middle;">{{ $pos->hasta }}</td>
                          <td style="text-align: center; vertical-align: middle;">{{ $pos->total }}</td>
                          <td style="text-align: center; vertical-align: middle;"> 
                            <div class="dropdown py-0">
                              <button class="btn btn-sm dropdown-toggle btn-outline-primary" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">Acciones</button>
                              <ul class="dropdown-menu p-0" aria-labelledby="dropdownMenu2">
                                <li><button class="dropdown-item pb-0 edit" type="button" onclick="mod_prospectos('+id_ofl_txt+')" data-bs-toggle="modal" data-bs-target="#modalprooectos"><i class="fas fa-cogs pe-1"></i> Configuración</button></li>
                                <li><button class="dropdown-item pb-0 edit" type="button" onclick="mod_prospectos('+id_ofl_txt+')" data-bs-toggle="modal" data-bs-target="#modalprooectos"><i class="fas fa-tachometer-alt pe-1"></i> Avances</button></li>
                                <li><button class="dropdown-item pb-0 edit" type="button" onclick="newpart()" data-bs-toggle="modal" data-bs-target="#modalnuevoprooectos"><i class="fas fa-user-tie pe-1"></i> Evaluadores</button></li>
                                <li><button class="dropdown-item pb-0 edit" type="button" onclick="levaldos({{ $pos->id }})" data-bs-toggle="modal" data-bs-target="#modalnuevoprooectos"><i class="fas fa-user-check pe-1"></i> Evaluados</button></li>
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

            <!-- NUEVA EVALUACIÓN-->
            <div id="div_evaluados">        
              <div class="row">                
                <div class="col">
                  <table  id="MyTable" class="table small table-sm table-striped table-hover" style="width:100%">
                    <thead class="bg-info">
                      <tr>
                        <th class="text-light text-center bg-info" width="25%" >C+ODIGO</th>
                        <th class="text-light text-center bg-info" width="15%" >NOMBRE</th>
                        <th class="text-light text-center bg-info" width="15%" >PUESTO</th>
                        <th class="text-light text-center bg-info" width="15%" >COD EVALUADOR</th>
                        <th class="text-light text-center bg-info" width="15%" >EVALUADOR</th>
                        <th class="text-light text-center bg-info" width="15%" ><i class="fas fa-cogs fa-lg"></i></th>
                      </tr>
                    </thead>
                    <tbody class="text-dark" id="tbody_list_evaluados">  
                     
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
    </div>
</div>

@endsection