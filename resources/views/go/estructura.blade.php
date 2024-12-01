<!DOCTYPE html>
@extends('layouts.plantilla')

@section('title','Consulta Estructuras')


<!-- JavaScript -->
<script type="text/javascript">
  // <![CDATA[
   function preloader(){
      document.getElementById("preload").style.display = "none";
      document.getElementById("iframe").style.display = "block";
 // <!     document.getElementById("div_2").style.display = "block";
   }
   //preloader
   window.onload = preloader;
  // ]]>
  </script>
  
  <!-- Estilo -->
  <style>
    div#iframe {  display: none; }
    div#preload {  cursor: wait; }
  </style>
@section('content')
<div class="card">
  <div class="card-header pb-0">
    <h4><i class="fa-solid fa-sitemap"></i> Estructuras</h4>
  </div>
  <div class="card-body">
    <small>
      <div id="preload" class="align-items-center justify-content-center text-center"><div class="spinner-border spinner-border-sm text-primary" role="status"></div></div>
    </small>
    <div id="iframe" style="display: none;">
      <!-- Button trigger modal -->
      <div class="row mt-4">
        <div class="col-4">        
          <select class="form-select form-select-sm" name="sel_grp" id="sel_grp" aria-label="Default select example" onchange="muestra_estructura(1)">
            <option value='0' selected>Seleccione Grupo</option>
            @foreach( $data_sups as $sup )
            <option value="{{ $sup->id }}">{{ $sup->nameund }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-4" id="div_ue" >        
          <select class="form-select form-select-sm" name="sel_ue" id="sel_ue" aria-label="Default select example" onchange="muestra_estructura(2)" style="display:none">
            <option value='0' selected>Seleccione Unidad</option>
          </select>
        </div>
      </div>
      <hr>
      <small>
        <div id="tabla_estructura" class="d-flex align-items-center justify-content-center">  </div>
      </small>
    </div>
  </div>
      </div>
@endsection

<script type='text/javascript'>

function muestra_estructura(opt)
{
  var _token = $('input[name="_token"]').val();
  
  if(opt==1)
  { document.getElementById("tabla_estructura").innerHTML='';
    sel_grp = document.getElementById('sel_grp').value;
    if(sel_grp>0)
    {
      var parametros = {
        "sel_grp" : sel_grp,
        "opt" : opt,
        "_token" : _token};
      $.ajax({
        data:  parametros,
        url:   "{{ route('procedimientos.show') }}", 
        type:  'POST', 
        dataType: "json",
        cache: true, 

        beforeSend: function () {
          $("#sel_ue").hide();
        },
        success:  function (data) { 
        $("#sel_ue").show();
        $("#sel_ue").empty();
        $('#sel_ue').append("<option value='0' selected>Seleccione Unidad Económica</option>");
          jQuery(data).each(function(i, item){  $('#sel_ue').append("<option value='"+ item.id+"'>"+ item.nameund+ "</option>"); });
        }
      });
    }
  }
  if(opt==2)
  {
    sel_ue = document.getElementById('sel_ue').value;
 
    if(sel_grp>0)
    {
      var parametros = {
      "sel_ue" : sel_ue,
      "opt":opt,
      "_token":_token};
      $.ajax({
        data:  parametros, 
        url:   "{{ route('procedimientos.show') }}",
        type:  'POST', 
        cache: true, 

        beforeSend: function () {
          document.getElementById("tabla_estructura").innerHTML='<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
        },
        success:  function (data) { document.getElementById("tabla_estructura").innerHTML=data;
        }
      });
    }
  }
}
</script>
