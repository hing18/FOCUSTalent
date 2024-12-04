<!DOCTYPE html>
@extends('layouts.plantilla')

@section('title','Dashboard')

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
<div class="card">
   <div class="card-header pb-0">
     <h4><i class="fas fa-chart-pie"></i> Indicadores</h4>
   </div>
   <div class="card-body">
     <small>
       <div id="preload" class="align-items-center justify-content-center text-center mt-4"><div class="spinner-border text-primary" role="status"></div></div>
     </small>
       <!-- LISTADO PRINCIPAL OFERTAS LABORALES-->
       <div id="iframe" style="display: none;">
           <!-- TABLA PRINCIPAL LISTADO DE EMPLEADOS-->
           <div id="div_tabla_listado"> 
            <div id="resp_gap"> 
                <div class="row pt-4">
              
                  <div class="col">
                    <div class="card border border-bottom-0 border-end-0 border-top-0 border-3 shadow border-info">
                      <div class="card-body py-2">
                        <div class="row align-items-center">
                          <div class="col p-0">
                            <div class="m-0 text-secondary text-center"><span class="h4 fw-bold" id="tot_gap_coef"></span></div>
                            <div class="text-info fw-bold mb-1 text-center"><small><small>Personal Activo</small></small></div>                
                          </div>
                          <div class="col-auto m-0 pe-1">
                            <i class="fas fa-users fa-2xl text-secondary p-0"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              
                  <div class="col">
                    <div class="card border border-bottom-0 border-end-0 border-top-0 border-3 shadow  border-primary">
                      <div class="card-body py-2">
                        <div class="row align-items-center">
                          <div class="col p-0">
                            <div class="m-0 text-secondary text-center"><span class="h4 fw-bold" id="tot_gap_coef"></span></div>
                            <div class="text-primary fw-bold mb-1 text-center"><small><small>Hombres</small></small></div>                
                          </div>
                          <div class="col-auto m-0 pe-1">
                            <i class="fas fa-male fa-2xl text-secondary p-0"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              
                  <div class="col">
                    <div class="card border border-bottom-0 border-end-0 border-top-0 border-3 shadow  border-danger">
                      <div class="card-body py-2">
                        <div class="row align-items-center">
                          <div class="col p-0">
                            <div class="m-0 text-secondary text-center"><span class="h4 fw-bold" id="tot_gap_coef"></span></div>
                            <div class="text-danger fw-bold mb-1 text-center"><small><small>Mujeres</small></small></div>                
                          </div>
                          <div class="col-auto m-0 pe-1">
                            <i class="fas fa-female fa-2xl text-secondary p-0"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col">
                    <div class="card border border-bottom-0 border-end-0 border-top-0 border-3 shadow  border-warning">
                      <div class="card-body py-2">
                        <div class="row align-items-center">
                          <div class="col p-0">
                            <div class="m-0 text-secondary text-center"><span class="h4 fw-bold" id="tot_gap_coef"></span></div>
                            <div class="text-warning fw-bold mb-1 text-center"><small><small>Jubilados</small></small></div>                
                          </div>
                          <div class="col-auto m-0 pe-1">
                            <i class="fas fa-user-check fa-2xl text-secondary p-0"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
           </div>
        </div>
    </div>
</div>

@endsection