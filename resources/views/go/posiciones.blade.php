<!DOCTYPE html>
@extends('layouts.plantilla')

@section('title','Maestro de Posiciones')

@section('content')

<!-- JavaScript -->
<script type="text/javascript">
  // <![CDATA[
   function preloader(){
      document.getElementById("preload").style.display = "none";
      document.getElementById("iframe").style.display = "block";
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
  <div class="row">

        <div class="d-grid gap-2 d-md-flex justify-content-md-end" onclick="modalcrud(1,0)">
            <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-bs-toggle="modal" data-bs-target="#Modal">
              <span class="text fw-bold"> <i class="fas fa-plus pr-2"></i> Nueva Posición</span>
            </a>
        </div>
      
  </div>

<hr>
  <small>
    <div id="preload" class="align-items-center justify-content-center text-center"><div class="spinner-border spinner-border-sm text-primary" role="status"></div></div>
  </small>
    <div id="iframe" style="display: none;">
      <div id="div_tabla">
        <table id="MyTable" class="display compact table table-striped shadow table-bordered bg-white table-sm" style="width:100%">
          <thead class="bg-secondary">
            <tr>
              <th class="text-light text-center">POSICIÓN</th>
              <th class="text-light text-center">DESCRIPTIVO</th>
              <th class="text-light text-center">UNIDAD</th>
              <th class="text-light text-center">JEFE INMEDIATO</th>
              <th class="text-light text-center" width='8%'>ESTATUS</th>
              <th class="text-light text-center" width='6%'><i class="fas fa-cog"></i></th>
            </tr>
          </thead>
          <tbody class="text-dark" id="bodyMyTable">
            @foreach( $data_pos as $pos )
              
              
            @php if($pos->status=='true'){ $status='<i class="fa-solid fa-circle-check text-success fa-lg"></i>';}else{ $status='<i class="fa-solid fa-triangle-exclamation text-warning fa-lg"></i>';}
            @endphp
            <tr>
              <td>{{$pos->id}} - {{$pos->descpue}}</td>
              <td>{{$pos->descrip}}</td>
              <td>{{$pos->nomue}}</td>
              <td>{{$pos->descpuej}}</td>
              <td><div class="row d-flex align-items-center justify-content-center text-center"> <div class="col">@php echo $status; @endphp</div></div></td>
              <td>
                  <div class="row d-flex align-items-center justify-content-center text-center">
                    <div class="col-md-2 col-xs-6 text-secondary">
                      <i class="fa-solid fa-pencil fa-lg edit" onclick="modalcrud(2,{{$pos->id}})" data-bs-toggle="modal" data-bs-target="#Modal"></i>  
                    </div>
                    <div class="col-md-2 col-xs-6 text-secondary">
                      <i class="fa-solid fa-trash-can fa-lg dell" onclick="modalcrud(3,{{$pos->id}})" ></i>
                    </div>
                  </div>
              </td>

          @endforeach
          </tbody>
        </table>
      </div>
    </div>


  <!-- Modal -->
  <div class="modal fade" id="Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-light">
          <h6 class="modal-title text-primary fw-bold" id="ModalLabel">Modal title</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="frm_unidades">
            @csrf
            <div class=" row mb-3">
              <div class="col-2">
              <label for="codpue" class="col-form-label col-form-label-sm">Código:</label>
              <input type="text" class="form-control form-control-sm" name="codpue" id="codpue">
              <input type="hidden" id="idund" value="0">
            </div>
            <div class="col-4">
              <label for="namepue" class="col-form-label col-form-label-sm">Nombre de la posición:</label>
              <input type="text" class="form-control form-control-sm" name="namepue" id="namepue">
              <input type="hidden" id="idpue" value="0">
            </div>
            
            <div class="col-4">            
              <label for="id_df" class="col-form-label col-form-label-sm">Descriptivo de funciones:</label>              
              <select class="form-select form-select-sm" name="id_df" id="id_df" aria-label="Default select example">
                <option value='0' selected>Seleccione</option>
                @foreach( $data_df as $df )              
                  <option value='{{$df->id}}'>{{$df->nombredesc}}</option>   
                @endforeach
              </select>
            </div>

            <div class="col-2">
              <label for="hcaprobado" class="col-form-label col-form-label-sm">Head Count Aprobado:</label>
              <input type="number" class="form-control form-control-sm" name="hcaprobado" id="hcaprobado" min='0' value='0'>
            </div>
            
            <div class="col-2 pt-4 mt-2">
              <input class="form-check-input" type="checkbox" id="status" name="status" checked>
              <label class="form-check-label" for="status">
                Habilitado
              </label>
            </div>
          </div>
          <hr>
          
          <div class="text-primary"><b>UBICACIÓN DE LA POSICIÓN</b></div> <div class="text-secondary mb-3"><small>Seleccione la unidad y luego la <b>sección en donde estará ubicada la posición a crear</b></small></div>
            <div class="mb-3 col-4">            
              <label for="sel_ue" class="col-form-label col-form-label-sm">Unidad:</label>              
              <select class="form-select form-select-sm" name="sel_ue" id="sel_ue" aria-label="Default select example" onchange="showsecc('pue',0)">
                <option value='0' selected>Seleccione</option>
                  @foreach( $data_est as $est )              
                    <option value='{{$est->id}}'>{{$est->nameund}}</option>   
                  @endforeach
              </select>
            </div>

            <small>
              <div class="d-flex align-items-center justify-content-center" >
              <div id="tabla_estructura" class="col-10">  
                <table class="table table-sm table-bordered" id="MyTable_unidad">
                  <thead class="bg-primary">
                    <tr>
                      <th scope="col" class="text-center text-light bg-primary">DEPARTAMENTO</th>
                      <th scope="col" class="text-center text-light bg-primary">SECCIÓN</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
            </small>
            <hr>
          
            <div class="text-primary"><b>POSICIÓN DEL JEFE INMEDIATO</b></div> <div class="text-secondary mb-3"><small>Seleccione la unidad económica y luego la <b>posición del jefe inmediato</b></small></div>
            <div class="mb-3 col-4">            
              <label for="sel_ue_jefe" class="col-form-label col-form-label-sm">Unidad Económica:</label>              
              <select class="form-select form-select-sm" name="sel_ue_jefe" id="sel_ue_jefe" aria-label="Default select example" onchange="showsecc('jefe',0)">
                <option value='0' selected>Seleccione</option>
                  @foreach( $data_est as $est )              
                    <option value='{{$est->id}}'>{{$est->nameund}}</option>   
                  @endforeach
              </select>
            </div>
            <small>
              <div class="d-flex align-items-center justify-content-center" >
              <div id="tabla_estructura_jefe" class="col-12">  
                <table class="table table-sm table-bordered" id="MyTable_jefe">
                  <thead class="bg-primary">
                    <tr>
                      <th scope="col" class="text-center text-light bg-primary">DEPARTAMENTO</th>
                      <th scope="col" class="text-center text-light bg-primary">SECCIÓN</th>
                      <th scope="col" class="text-center text-light bg-primary">POSICIÓN DEL JEFE</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
            </small>
          </form>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cancelar</button>
          <button type="button" class="btn btn-primary btn-sm" onclick="su(1)"  tabindex="-1" id="bto_guarda" style="display: block"><i class="fas fa-save pr-2"></i> Guardar</button>
          <button type="button" class="btn btn-success btn-sm" onclick="su(2)"  tabindex="-1" id="bto_actualiza" style="display: none"><i class="fa-solid fa-arrows-rotate pr-2"></i> Actualizar</button>
        </div>
      </div>
    </div>
  </div>
@endsection

<script type='text/javascript'>

function modalcrud(opt,id)
{ 
  limpiaform();
  var _token = $('input[name="_token"]').val();
  
  document.getElementById('bto_guarda').style.display="none";
  document.getElementById('bto_actualiza').style.display="none";
  //NUEVO
    if(opt==1){
        document.getElementById('ModalLabel').innerHTML ='<i class="fas fa-plus pr-2 fa-lg"></i> Nueva Posición';
        document.getElementById('bto_guarda').style.display="block";
    }
    //EDITA
    if(opt==2)
      { document.getElementById('ModalLabel').innerHTML ='<i class="fa-solid fa-pen-to-square  fa-lg"></i> Edita Posición';
        document.getElementById('bto_actualiza').style.display="block";
        document.getElementById('idpue').value=id;
        var parametros = {
        "id": id,
        "_token" : _token};
        $.ajax({
          data:  parametros,
          url:   "{{ route('posiciones.edit') }}", 
          type:  'POST', 
          dataType: "json",
          cache: true, 
          success:  function (data) { 
            jQuery(data).each(function(i, item){ 
              
              document.getElementById('codpue').value = item.codigo;
              document.getElementById('namepue').value = item.descpue;
              document.getElementById('id_df').value = item.iddf;
              document.getElementById('hcaprobado').value = item.aprobado;
              if(item.status!='true'){document.getElementById('status').checked=false;}else{document.getElementById('status').checked=true;}
              document.getElementById('sel_ue').value = item.idue;
              document.getElementById('sel_ue_jefe').value = item.iduej;
              showsecc('pue',item.iduni);
              showsecc('jefe',item.idpuejefe);
              if ( $('chk_'+item.idue).length>0 )
              {
                document.getElementById('chk_'+item.idue).checked='checked';
              }
            });
          }
        });
      }
    // ELIMINA POSICIÓN
    if(opt==3)
    { document.getElementById('idpue').value=id;
      document.getElementById('namepue').value='...'; 
      document.getElementById('id_df').value=0;
      Swal.fire({
        title: "Eliminar Posición",
        text: "Se procederá a eliminar la posición. Si esta posición, tiene posiciones a cargo, debe validar las posiciones que quedarán sin jefatura. Desea Continuar?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Si, Eliminar!"
      }).then((result) => { if (result.isConfirmed) {su(opt);} });
    }
}

function su(opt)
{ 
  var _token = $('input[name="_token"]').val();
  var codpue = document.getElementById('codpue').value;
  var namepue = document.getElementById('namepue').value;
  var id_df = document.getElementById('id_df').value;
  var sel_ue = document.getElementById('sel_ue').value;
  var status = document.getElementById('status').checked;
  var hcaprobado = document.getElementById('hcaprobado').value;
  var id = document.getElementById('idpue').value;
  var secciones=0;
  var idpuejefe=0;
  band_secciones=0;
  band_jefe=0;
  if(opt!=3)
  {
    if (sel_ue>0) {     
      let checked = $('input[name="chk"]:checked');
      $('[name="chk[]"]:checked').map(function(){
        if (this.checked) {
          //secciones.push($(this).val());
          secciones=$(this).val();
          band_secciones=1;
        }
    });
    }
    else
    {  mal('Seleccione la unidad económica y luego la sección en donde estará ubicada la posición a crear');}
    if ( $('[name="chkjefe[]"]').length>0 )
    { $('[name="chkjefe[]"]:checked').map(function()
      {
        if (this.checked) {
          idpuejefe=$(this).val();
        }
      });
    }
  }

  

    if(opt==1)
    { var urls="{{ route('posiciones.store') }}";}
    if(opt==2)
    { var urls="{{ route('posiciones.update') }}";}
    if(opt==3)
    { var urls="{{ route('posiciones.destroy') }}";id_df=1;band_secciones=1;}


   if(namepue.length>0)
    { if(id_df>0)
      { if(band_secciones>0)
        {
          var parametros = {
          "codpue" : codpue,
          "namepue" : namepue,
          "hcaprobado" : hcaprobado,
          "sel_ue" : sel_ue,
          "secciones" : secciones,
          "id_df" : id_df,
          "idpuejefe" : idpuejefe,
          "status" : status,
          "opt" : opt,
          "id" : id,
          "_token":_token};
          $.ajax({
            data:  parametros, 
            url:   urls,
            type:  'POST', 
            cache: true, 
            dataType: "json",
            success:  function (data) { 
              const table = new DataTable('#MyTable');
              table.clear().draw(); 
              jQuery(data).each(function(i, item){ 
                var status="";
                if(item.status=='true'){ status='<i class="fa-solid fa-circle-check text-success fa-lg"></i>';}else{ status='<i class="fa-solid fa-triangle-exclamation text-warning fa-lg"></i>';}
                table.row.add([
                  item.descpue,
                  item.descrip,
                  item.nomue,
                  item.descpuej,
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
             
              if(opt==1)
              { bien('La posición ha sido creada');}
              if(opt==2)
              { bien('La posición ha sido actualizada');}
              if(opt==3)
              { bien('La posición ha sido eliminada');}
              limpiaform();
              $('#Modal').modal('hide');
            }
          });
        }
        else
        { mal('Seleccione la sección en donde estará ubicada la posición a crear');}
      }
      else
      { mal('Seleccionar descriptivo de funciones');}
    }
    else
    { mal('Colocar el nombre de la posición');}
  
}

function limpiaform()
{
  
  document.getElementById('codpue').value='';
  document.getElementById('namepue').value='';
  document.getElementById('id_df').selectedIndex=0;
  document.getElementById('hcaprobado').value=0;
  document.getElementById('status').checked=true;
  document.getElementById('sel_ue').selectedIndex=0;
  document.getElementById('sel_ue_jefe').value=0;

  var n=0;
  $("#MyTable_unidad tbody tr").each(function () 
  { n++;});
    for(i=n;i>=0;i--)
     { $("#MyTable_unidad tbody tr:eq('"+i+"')").remove();};

  n=0;
  $("#MyTable_jefe tbody tr").each(function () 
  { n++;});
  for(i=n;i>=0;i--)
  { $("#MyTable_jefe tbody tr:eq('"+i+"')").remove();};

}

function showsecc(opt,id_unisecc)
{ var _token = $('input[name="_token"]').val();
    if(opt=='pue')
    {
      sel_ue = document.getElementById('sel_ue').value;
  
      if(sel_ue>0)
      {
        var parametros = {
        "sel_ue" : sel_ue,
        "opt":opt,
        "id_unisecc":id_unisecc,
        "_token":_token};
        $.ajax({
          data:  parametros, 
          url:   "{{ route('procedimientos.show') }}",
          type:  'POST', 
          cache: true, 

          beforeSend: function () {
            document.getElementById("tabla_estructura").innerHTML='<div class="text-center"><div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
          },
          success:  function (data) { document.getElementById("tabla_estructura").innerHTML=data;
          }
        });
      }
      else{
        document.getElementById("tabla_estructura").innerHTML='<table class="table table-sm table-bordered">'+
                    '<thead class="bg-primary">'+
                      '<tr>'+
                        '<th scope="col" class="text-center text-light bg-primary">DEPARTAMENTO</th>'+
                        '<th scope="col" class="text-center text-light bg-primary">SECCIÓN</th>'+
                      '</tr>'+
                    '</thead>'+
                  '</table>';
      }
    }
    if(opt=='jefe')
    {
      sel_ue = document.getElementById('sel_ue_jefe').value;
  
      if(sel_ue>0)
      {
        var parametros = {
        "sel_ue" : sel_ue,
        "opt":opt,
        "id_unisecc":id_unisecc,
        "_token":_token};
        $.ajax({
          data:  parametros, 
          url:   "{{ route('procedimientos.show') }}",
          type:  'POST', 
          cache: true, 

          beforeSend: function () {
            document.getElementById("tabla_estructura_jefe").innerHTML='<div class="text-center"><div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
          },
          success:  function (data) { document.getElementById("tabla_estructura_jefe").innerHTML=data;
          }
        });
      }
      else{
        document.getElementById("tabla_estructura_jefe").innerHTML='<table class="table table-sm table-bordered">'+
                    '<thead class="bg-primary">'+
                      '<tr>'+
                        '<th scope="col" class="text-center text-light bg-primary">DEPARTAMENTO</th>'+
                        '<th scope="col" class="text-center text-light bg-primary">SECCIÓN</th>'+
                        '<th scope="col" class="text-center text-light bg-primary">POSICIÓN DEL JEFE</th>'+
                      '</tr>'+
                    '</thead>'+
                  '</table>';
      }
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
</script>