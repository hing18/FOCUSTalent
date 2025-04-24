<!DOCTYPE html>
@extends('layouts.plantilla')

@section('title','Maestro de Unidades')

@section('content')

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
<!-- Button trigger modal -->
<div class="card">
  <div class="card-header pb-0">
    <h4><i class="fas fa-project-diagram"></i> Maestro de Unidades</h4>
  </div>
  <div class="card-body">
    <small>
      <div id="preload" class="align-items-center justify-content-center text-center"><div class="spinner-border spinner-border-sm text-primary" role="status"></div></div>
    </small>
      <div id="iframe" style="display: none;">  
        <div class="row mt-2">

          <div class="d-grid gap-2 d-md-flex justify-content-md-end" onclick="call_estruc_modal(6,0,this)">
              <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-bs-toggle="modal" data-bs-target="#Modal">
                <span class="text fw-bold"> <i class="fas fa-plus pr-2"></i> Nueva Unidad</span>
              </a>
          </div>
        </div>
        <div id="div_tabla">
          <table id="MyTable" class="display compact table table-striped shadow table-bordered bg-white table-sm" style="width:100%">
            <thead class="bg-secondary">
                <tr>
                    <th class="text-light text-center">CODIGO</th>
                    <th class="text-light text-center">NOMBRE DE UNIDAD</th>
                    <th class="text-light text-center">UND. PADRE</th>
                    <th class="text-light text-center">TIPO</th>
                    <th class="text-light text-center">ESTATUS</th>
                    <th class="text-light text-center" width='6%'><i class="fas fa-cog"></i></th>
                </tr>
            </thead>
            <tbody class="text-dark" id="bodyMyTable">
                @foreach( $data_vestruc as $vestruc )                
                @php
                if( $vestruc->STATUS=='true' ){ $status='<i class="fa-solid fa-circle-check text-success fa-lg"></i>';}else{ $status='<i class="fa-solid fa-triangle-exclamation text-warning fa-lg"></i>';}
                @endphp
                <tr>
                    <td>{{ $vestruc->CODUND }}</td>
                    <td>{{ $vestruc->UND }}</td>
                    <td>{{ $vestruc->UNDSUP }}</td>
                    <td>{{ $vestruc->NTIPO }}</td>
                    <td> 
                      <div class="row d-flex align-items-center justify-content-center text-center">
                        <div class="col">@php echo $status; @endphp</div>
                      </div>
                    </td>
                    <td>
                      <div class="row d-flex align-items-center justify-content-center text-center">
                          <div class="col-md-2 col-xs-6 text-secondary">
                              <i class="fa-solid fa-pencil fa-lg edit" onclick="call_estruc_modal(3,{{ $vestruc->IDUND }},this)" data-bs-toggle="modal" data-bs-target="#Modal"></i>
                            </div>
                            <div class="col-md-2 col-xs-6 text-secondary">
                                <i class="fa-solid fa-trash-can fa-lg dell" onclick="call_estruc_modal(5,{{ $vestruc->IDUND }},this)"></i>
                            </div>
                        </div>
                    </td>
                </tr>  
                @endforeach
            </tbody>
          </table>

        </div>

      </div>
    </div>
  </div>

      <!-- Modal -->
      <div class="modal fade" id="Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header bg-light">
              <h6 class="modal-title text-primary fw-bold" id="ModalLabel">Modal title</h6>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="frm_unidades">
                @csrf
                <div class="mb-3">
                  <label for="codigo" class="col-form-label col-form-label-sm">Código:</label>
                  <input type="text" class="form-control form-control-sm" name="codigo" id="codigo">
                  <input type="hidden" id="idund" value="0">
                </div>
                <div class="mb-3">
                  <label for="nameund" class="col-form-label col-form-label-sm">Nombre:</label>
                  <input type="text" class="form-control form-control-sm" name="nameund" id="nameund">
                  <input type="hidden" id="idund" value="0">
                </div>
                
                <div class="mb-3">
                  <input class="form-check-input" type="checkbox" id="chk_tienda" name="chk_tienda">
                  <label class="form-check-label" for="chk_tienda">
                    Tienda
                  </label>
                </div>

                <div class="mb-3">                
                  <label for="id_tipo" class="col-form-label col-form-label-sm">Tipo de Unidad</label>
                 
                  <select class="form-select form-select-sm" name="id_tipo" id="id_tipo" aria-label="Default select example">
                    <option value='0' selected>Seleccione</option>               
                      @foreach( $data_tipos as $tipo )
                        <option value="{{ $tipo->id }}">{{ $tipo->id }} - {{ $tipo->name }}</option>
                      @endforeach
                  </select>
                </div>

                <div class="mb-3">
                  <label for="id_sup" class="col-form-label col-form-label-sm">Unidad Padre</label>
                    <span id='div_lista_unid'>
                      <select class="form-select form-select-sm" name="id_sup" id="id_sup" aria-label="Default select example">
                        <option value='0' selected>Seleccione</option>
                          @foreach( $data_sups as $sup )
                            <option value="{{ $sup->id }}">{{ $sup->nameund }}</option>
                            {{ select_tree_cat_id($sup->id,1) }}
                          @endforeach
                      </select>
                    </span>
                </div>

                <div class="mb-3">
                  <input class="form-check-input" type="checkbox" id="status" name="status" checked>
                  <label class="form-check-label" for="status">
                    Habilitado
                  </label>
                </div>
              </form>
            </div>
            <div class="modal-footer bg-light">
              <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cancelar</button>
              <button type="button" class="btn btn-primary btn-sm" onclick="crud_unidad(6)"  tabindex="-1" id="bto_guarda" style="display: block"><i class="fas fa-save pr-2"></i> Guardar</button>
              <button type="button" class="btn btn-success btn-sm" onclick="crud_unidad(4)"  tabindex="-1" id="bto_actualiza" style="display: none"><i class="fa-solid fa-arrows-rotate pr-2"></i> Actualizar</button>
            </div>
          </div>
        </div>
      </div>
  @endsection

<script type='text/javascript'>
  function call_estruc_modal(opt_estruc,id_uni,tr)
  {   var _token = $('input[name="_token"]').val();       
      document.getElementById('codigo').value="";     
      document.getElementById('nameund').value="";
      document.getElementById('id_tipo').value=0; 
      document.getElementById('id_sup').value=0; 
      document.getElementById('status').checked=false;
      document.getElementById('chk_tienda').checked=false;
      document.getElementById('idund').value=0;

      document.getElementById('bto_guarda').style.display="none";
      document.getElementById('bto_actualiza').style.display="none";
      if(opt_estruc==6){
        document.getElementById('ModalLabel').innerHTML ='<i class="fas fa-plus pr-2 fa-lg"></i> Nueva Unidad';
        document.getElementById('bto_guarda').style.display="block";
      document.getElementById('status').checked=true;
      }
      //CONSULTA UNIDAD
      if(opt_estruc==3){
          document.getElementById('ModalLabel').innerHTML ='<i class="fa-solid fa-pen-to-square  fa-lg"></i> Editar Unidad';
          document.getElementById('bto_actualiza').style.display="block";
          var parametros = {
              "opt" : opt_estruc,
              "id_uni": id_uni,
              "_token" : _token};
        $.ajax({
          data:  parametros,
          url:   "{{ route('procedimientos.show') }}", 
          type:  'POST', 
          dataType: "json",
          cache: true, 
          success:  function (data) { 
              jQuery(data).each(function(i, item){ 
                  document.getElementById('idund').value=item.id; 
                  document.getElementById('codigo').value=item.codigo; 
                  document.getElementById('nameund').value=item.nameund; 
                  document.getElementById('id_tipo').value=item.id_tipo; 
                  document.getElementById('id_sup').value=item.id_sup; 
                  if(item.status!='true'){  document.getElementById('status').checked=false;}else{document.getElementById('status').checked=true;}
                  if(item.chk_tienda==1){ document.getElementById('chk_tienda').checked=true;}
              });
          }
        });
      }

      // ELIMINA UNIDAD
      if(opt_estruc==5){
          Swal.fire({
          title: "Eliminar Unidad",
          text: "Se eliminará todas las unidades asociadas a la misma!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#d33",
          cancelButtonText:  '<i class="fas fa-arrow-left"></i> Cancelar',
          confirmButtonText: '<i class="fas fa-trash-alt"></i> Si, eliminar',
          }).then((result) => {
            if (result.isConfirmed) {
              var parametros = {
              "opt" : opt_estruc,
              "id_uni": id_uni,
              "_token" : _token};
              $.ajax({
                  data:  parametros,
                  url:   "{{ route('procedimientos.show') }}", 
                  type:  'POST', 
                  dataType:'JSON',
                  cache: true, 
                  success:  function (data) {  
                    createtable(data);  
                    bien('success','La Unidad ha sido eliminada.');
                  }
              });
            }
          });
      }
  }

  function crud_unidad(opt)
  {    var _token = $('input[name="_token"]').val();  
      // NUEVA UNIDAD
      if(opt==6){
        
        var parametros = {
              "opt" : opt,
              "codigo": document.getElementById('codigo').value,
              "nameund": document.getElementById('nameund').value,
              "id_tipo": document.getElementById('id_tipo').value, 
              "id_sup": document.getElementById('id_sup').value,
              "status": document.getElementById('status').checked,
              "chk_tienda": document.getElementById('chk_tienda').checked,
              "_token" : _token};
              $.ajax({
                  data:  parametros,
                  url:   "{{ route('procedimientos.show') }}", 
                  type:  'POST', 
                  dataType: "json",
                  cache: true, 
                  success:  function (data) { 
                    createtable(data);
                    bien('success','La Unidad ha sido creada.');
                    document.getElementById('codigo').value="";
                    document.getElementById('nameund').value="";
                    document.getElementById('id_tipo').value=0; 
                    document.getElementById('id_sup').value=0; 
                    document.getElementById('status').checked=false;
                    document.getElementById('chk_tienda').checked=false;
                    document.getElementById('idund').value=0;
                    $('#Modal').modal('hide');
                  }
              });
      }
      // ACTUALIZA UNIDAD
      if(opt==4)
      {
          idund= document.getElementById('idund').value;
          var parametros = {
              "opt" : opt,
              "idund": idund,
              "codigo": document.getElementById('codigo').value,
              "nameund": document.getElementById('nameund').value,
              "id_tipo": document.getElementById('id_tipo').value, 
              "id_sup": document.getElementById('id_sup').value,
              "status": document.getElementById('status').checked,
              "chk_tienda": document.getElementById('chk_tienda').checked,
              "_token" : _token};
        $.ajax({
          data:  parametros,
          url:   "{{ route('procedimientos.show') }}", 
          type:  'POST', 
          dataType: "json",
          cache: true, 
          success:  function (data) { 
            createtable(data);
                bien('success','La Unidad ha sido actualizada.');
                  document.getElementById('codigo').value="";
                  document.getElementById('nameund').value="";
                  document.getElementById('id_tipo').value=0; 
                  document.getElementById('id_sup').value=0; 
                  document.getElementById('status').checked=true;
                  document.getElementById('chk_tienda').checked=false;
                  document.getElementById('idund').value=0;
                  $('#Modal').modal('hide');
          }
          });
      }
  }

  function createtable(data)
  {
    const table = new DataTable('#MyTable');
    table.clear().draw(); 
    jQuery(data).each(function(i, item){ 
      var status="";
      if(item.STATUS=='true'){ status='<i class="fa-solid fa-circle-check text-success fa-lg"></i>';}else{ status='<i class="fa-solid fa-triangle-exclamation text-warning fa-lg"></i>';}
      table.row.add([
        item.CODUND,
        item.UND,
        item.UNDSUP,
        item.NTIPO,
        '<div class="row d-flex align-items-center justify-content-center text-center"><div class="col">'+status+'</div></div>',
          '<div class="row d-flex align-items-center justify-content-center text-center">'+
            '<div class="col-md-2 col-xs-6 text-secondary">'+
              '<i class="fa-solid fa-pencil fa-lg edit" onclick="call_estruc_modal(3,'+item.IDUND+',this)" data-bs-toggle="modal" data-bs-target="#Modal"></i>'+  
            '</div>'+
          '<div class="col-md-2 col-xs-6 text-secondary">'+
            '<i class="fa-solid fa-trash-can fa-lg dell" onclick="call_estruc_modal(5,'+item.IDUND+',this)" ></i>'+
          '</div>'+
        '</div>'
      ]).draw(false);                  
    });
    lista_unid();
  }

  function lista_unid()
  { var _token = $('input[name="_token"]').val(); 
    var parametros = {

        "opt": 'lista',
        "_token" : _token};
        $.ajax({
          data:  parametros,
          url:   "{{ route('procedimientos.show') }}", 
          type:  'POST', 
          cache: true, 
          success:  function (data) { 
            document.getElementById('div_lista_unid').innerHTML=data;
          }
          });
  }

  function bien(icono,msn)
  {
      Swal.fire({
          position: 'center',
          icon: icono,
          text: msn,
          showConfirmButton: false,
          timer: 2000
    })
  }
  function mal()
  {
      Swal.fire({
          position: 'center',
          icon: 'warning',
          text: 'Algo salio mal al momento de actualizar la unidad',
    })
  }

 
</script>