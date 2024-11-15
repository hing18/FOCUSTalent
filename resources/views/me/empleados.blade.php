<!DOCTYPE html>
@extends('layouts.plantilla')

@section('title','empleados')

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
      <h4><i class="fas fa-users"></i> Maestro de Empleados</h4>
    </div>
    <div class="card-body">
      <small>
        <div id="preload" class="align-items-center justify-content-center text-center"><div class="spinner-border spinner-border-sm text-primary" role="status"></div></div>
      </small>
        <!-- LISTADO PRINCIPAL OFERTAS LABORALES-->
        <div id="iframe" style="display: none;">
            <!-- TABLA PRINCIPAL -->
            <div id="div_tabla">     
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-2">            
                    
                    
                <button type="button" class="btn btn-primary btn-sm" onclick="modalcrud(1,0)"><i class="fas fa-plus pe-2"></i> Nuevo</button>
                </div>
                <div id="iframe" style="display: block;">
                    <table id="MyTable" class="table table-striped table-hover shadow table-bordered bg-white table-sm" style="width:100%">
                    <thead class="bg-info">
                        <tr>
                        <th class="text-light text-center" >CODIGO</th>
                        <th class="text-light text-center" >NOMBRE</th>
                        <th class="text-light text-center" >POSICIÓN</th>
                        <th class="text-light text-center" >DEPARTAMENTO</th>
                        <th class="text-light text-center" >UNIDAD</th>
                        <th class="text-light text-center" width='10%'><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody class="text-dark" id="bodyMyTable_empleados">
                        @foreach($empleados as $empleado )
                        <tr>
                            <td class=" text-center">{{$empleado->id}}</td>
                            <td class="text-uppercase">{{$empleado->prinombre}} {{$empleado->priapellido}}</td>
     
                            <td class="text-uppercase">{{$empleado->descpue}}</td>
                            <td class="text-uppercase">{{$empleado->uni}}</td>
                            <td class="text-uppercase">{{$empleado->ue}}</td>
                            <td>
                                <div class="row d-flex align-items-center justify-content-center text-center">
                                    <div class="col-sm-1 text-secondary">
                                        <i class="fas fa-search fa-lg edit" title="Editar" onclick="veo(2,{{$empleado->id}})"></i>  
                                    </div>
                                </div>
                            </td>
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection