<!DOCTYPE html>
@extends('layouts.plantilla')

@section('title','Maestro de Jerarquías')

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
        <span class="text fw-bold"> <i class="fas fa-plus pr-2"></i> Nueva Jerarquía</span>
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
            <th class="text-light text-center">TIPO</th>
            <th class="text-light text-center">ORDEN</th>
            <th class="text-light text-center">JERARQUÍAS</th>
            <th class="text-light text-center">COMPETENCIAS ASIGNADAS</th>
            <th class="text-light text-center">ESTATUS</th>
            <th class="text-light text-center" width='6%'><i class="fas fa-cog"></i></th>
          </tr>
        </thead>
        <tbody class="text-dark" id="bodyMyTable">
        @foreach( $data_jer as $tipojer )
          @php
          if($tipojer->status=='true' ){ $status='<i class="fa-solid fa-circle-check text-success fa-lg"></i>';}else{ $status='<i class="fa-solid fa-triangle-exclamation text-warning fa-lg"></i>';}
          $cantcomp=' <i class="fas fa-cog fa-lg edit" onclick="asig_comp('.$tipojer->id.')" data-bs-toggle="modal" data-bs-target="#Modal_comp"></i>';
          @endphp
          <tr>
            <td><div id="div_tipo{{ $tipojer->id }}">{{ $tipojer->tipo }}</div></td>
            <td><div class="text-center">{{ $tipojer->orden }}</div></td>
            <td><div id="div_jer{{ $tipojer->id }}">{{ $tipojer->nombrejer }}</div></td>
            <td>
              <div class="row d-flex align-items-center justify-content-center text-center">
                <div class="col-md-1 col-xs-6 text-secondary" id="div_cant{{ $tipojer->id }}">
                  {{ $tipojer->cantcomp }}   
                </div>
                <div class="col-md-1 col-xs-6 text-secondary">
                  @php echo $cantcomp @endphp
                </div>
              </div>
            </td>
            <td> 
              <div class="row d-flex align-items-center justify-content-center text-center">
                <div class="col">@php echo $status; @endphp</div>
              </div>
            </td>
            <td>
              <div class="row d-flex align-items-center justify-content-center text-center">
                <div class="col-md-2 col-xs-6 text-secondary">
                  <i class="fa-solid fa-pencil fa-lg edit" onclick="modalcrud(2,{{ $tipojer->id }})" data-bs-toggle="modal" data-bs-target="#Modal"></i>  
                </div>
                <div class="col-md-2 col-xs-6 text-secondary">
                  <i class="fa-solid fa-trash-can fa-lg dell" onclick="modalcrud(3,{{ $tipojer->id }})" ></i>
                </div>
              </div>
            </td>
          </tr>  
        @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal ASIGNAR COMPETENCIAS -->
  <div class="modal fade" id="Modal_comp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
      <div class="modal-content">
        <div class="modal-header bg-light">
          <h5 class="modal-title text-primary" id="ModalLabel_comp">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="frm_unidades">
      
            <div class="row">
              <div class="col-8">
                <label class="col-form-label col-form-label-sm text-secondary"><b>Nombre de Jerarquía: </b><span class="text-primary" id="nom_jer_asig_comp"></span></label>
              </div>
              <div class="col-4">
                <label class="col-form-label col-form-label-sm text-secondary" ><b>Tipo: </b><span class="text-primary" id="nom_tipo_asig_comp"></span></label>
              </div>
            </div>
          <hr>
            <label class="text-secondary"><b>Seleccionar Competencias</b></label>   

             <div class='row d-flex align-items-center justify-content-center pb-4'>
              
              <div class="col-4" id="sel_list_comp">
                <label for="selcomp" class="col-form-label col-form-label-sm">Competencias:</label>
                <select class="form-select form-select-sm" name="selcomp" id="selcomp" aria-label="Default select example">
                  
                </select>
              </div>
              <div class="col-4">
                <label for="tipo_comp" class="col-form-label col-form-label-sm">Tipo de Competencia:</label>
                <select class="form-select form-select-sm" name="tipo_comp" id="tipo_comp" aria-label="Default select example">
                  <option value='0' selected>Seleccione</option>
                  @foreach( $data_tipocomp as $tipocomp )
                    <option value="{{ $tipocomp->id }}">{{ $tipocomp->nombretipocompetencia }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-1">
                <label for="esperado" class="col-form-label col-form-label-sm">Nivel:</label>
                <input type="number" class="form-control form-control-sm" name="esperado" id="esperado" max="10" min="1" value='10'>
              </div>
              <div class="col-2 d-flex align-items-right justify-content-center pt-4">
                <button type="button" class="btn btn-success btn-sm mb-0" onclick="agregarFila()"><i class="fas fa-plus-circle"></i> Agregar</button>
              </div>
            </div>
            <small>
              <div class="row d-flex align-items-center justify-content-center">
                <table class="table table-hover table-sm shadow table-bordered " style="width:80%" id="tabla_rel" name="tabla_rel">
                  <thead class="bg-primary">
                    <tr class="text-center">
                      <th class="text-light bg-primary">#</th>
                      <th class="text-light bg-primary">COMPETENCIA</th>
                      <th class="text-light bg-primary">TIPO DE COMPETENCIA</th>
                      <th class="text-light bg-primary">NIVEL</th>
                      <th class="text-light bg-primary">ACCIONES</th>
                    </tr>
                  </thead>
                  <tbody id="tbody">

                  </tbody>
                </table>
              </div>
            </small>
          </form>  
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fas fa-times pr-2"></i> Cerrar</button>
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
              <label for="nombrejer" class="col-form-label col-form-label-sm">Nombre de Jerarquía:</label>
              <input type="text" class="form-control form-control-sm" name="nombrejer" id="nombrejer">
              <input type="hidden" name="idjer" id="idjer" value="0">
            </div>
            <div class="mb-3">
              <div class="row">
                <div class="col-8">
                  <label for="tipojer" class="col-form-label col-form-label-sm">Tipo:</label>
                  <select class="form-select form-select-sm" name="tipojer" id="tipojer" aria-label="Default select example">
                    <option value='0' selected>Seleccione</option>
                    @foreach( $data_tipojer as $tipojer )
                      <option value="{{ $tipojer->id }}">{{ $tipojer->nombretipojer }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-4">
                  <label for="orden" class="col-form-label col-form-label-sm">Orden:</label>
                  <input type="number" class="form-control form-control-sm" name="orden" id="orden" max="24" min="1" value='1'>
                </div>
              </div>
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
    var _token = $('input[name="_token"]').val();
    document.getElementById('bto_guarda').style.display="none";
    document.getElementById('bto_actualiza').style.display="none";
    document.getElementById('idjer').value=0;
    if(opt==1){
      document.getElementById('ModalLabel').innerHTML ='<i class="fas fa-plus pr-2 fa-lg"></i> Nueva Jerarquía';
      document.getElementById('nombrejer').value='';
      document.getElementById('bto_guarda').style.display="block";
      document.getElementById('status').checked=true;
    }
    
    //EDITA
    if(opt==2)
    { document.getElementById('ModalLabel').innerHTML ='<i class="fa-solid fa-pen-to-square  fa-lg"></i> Edita Jerarquía';
      document.getElementById('nombrejer').value='';
      document.getElementById('bto_actualiza').style.display="block";
      document.getElementById('idjer').value=id;
      var parametros = {
      "id": id,
      "_token" : _token,};
      $.ajax({
        data:  parametros,
        url:   "{{ route('jerarquias.edit') }}", 
        type:  'POST', 
        dataType: "json",
        cache: true, 
        success:  function (data) { 
          jQuery(data).each(function(i, item){ 
            document.getElementById('nombrejer').value=item.nombrejer; 
            document.getElementById('tipojer').value=item.tipo; 
            document.getElementById('orden').value=item.orden; 
            if(item.status!='true'){document.getElementById('status').checked=false;}else{document.getElementById('status').checked=true;} 
          });
        }
      });
    }
    if(opt==3)
    { document.getElementById('idjer').value=id;
      document.getElementById('nombrejer').value='...'; 
      document.getElementById('tipojer').value=0;
      Swal.fire({
        title: "Eliminar Jerarquía",
        text: "Se procederá a eliminar la jerarquía y su vinculación a las campetencias en caso de tenerlas, Desea Continuar?",
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
    var nombre = $("#nombrejer" ).val();    
    var tipojer = $("#tipojer" ).val();    
    var id = $('#idjer').val();
    var orden = $('#orden').val();
    var status = document.getElementById('status').checked; 
    if(opt==1)
    { var urls="{{ route('jerarquias.store') }}";}
    if(opt==2)
    { var urls="{{ route('jerarquias.update') }}";}
    if(opt==3)
    { var urls="{{ route('jerarquias.destroy') }}";tipojer=1;}
    if(nombre.length>0)
    { if(tipojer>0)
      { var parametros = {
        "nombre" : nombre,
        "tipojer" : tipojer,
        "status" : status,
        "orden" : orden,
        "id": id,
        "opt" : opt,
        "_token":_token};
        $.ajax({
          data:  parametros, 
          url:   urls,
          type:  'POST', 
          dataType: "json",
          cache: true, 
          success:  function (data) { 
            const table = new DataTable('#MyTable');
            table.clear().draw(); 
            jQuery(data).each(function(i, item){ 
              var status="";
              if(item.status=='true'){ status='<i class="fa-solid fa-circle-check text-success fa-lg"></i>';}else{ status='<i class="fa-solid fa-triangle-exclamation text-warning fa-lg"></i>';}
              table.row.add([
                '<div id="div_tipo'+item.id+'">'+item.tipo+'</div>',
                '<div class="text-center">'+item.orden+'</div>',
                '<div id="div_jer'+item.id+'">'+item.nombrejer+'</div>',
                '<div class="row d-flex align-items-center justify-content-center text-center">'+
                  '<div class="col-md-1 col-xs-6 text-secondary" id="div_cant'+item.id+'">'+item.cantcomp+'</div>'+
                  '<div class="col-md-1 col-xs-6 text-secondary">'+
                    '<i class="fas fa-cog fa-lg edit" onclick="asig_comp('+item.id+')" data-bs-toggle="modal" data-bs-target="#Modal_comp"></i>'+
                  '</div></div>',
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
            document.getElementById('nombrejer').value="";
            document.getElementById('tipojer').value=0;
            document.getElementById('orden').value="1";
            document.getElementById('status').checked=true;
            if(opt==1)
            { bien('La jerarquía ha sido creada');}
            if(opt==2)
            { bien('La jerarquía ha sido actualizada');}
            if(opt==3)
            { bien('La jerarquía ha sido eliminada');}
            $('#Modal').modal('hide');
          }
        });
      }
      else
      { mal('Por favor seleccionar el tipo de Jerarquía');}
    }
    else
    { mal('Por favor colocar el nombre de la jerarquía');}
  }

  function asig_comp(id)
  { 
    var _token = $('input[name="_token"]').val();
    carga_comp(id);
    document.getElementById('idjer').value=id;
    document.getElementById('ModalLabel_comp').innerHTML ='<i class="fas fa-plus pr-2 fa-lg"></i> Competencias Asignadas';
    document.getElementById('nom_jer_asig_comp').innerHTML =document.getElementById('div_jer'+id).innerHTML;
    document.getElementById('nom_tipo_asig_comp').innerHTML =document.getElementById('div_tipo'+id).innerHTML;
    var parametros = {"id": id,"_token" : _token};
    $.ajax({
      data:  parametros,
      url:   "{{ route('jerarquias.show') }}", 
      type:  'POST', 
      dataType: "json",
      cache: true, 
      
      beforeSend: function () {
        $("#tabla_rel tbody tr").remove();
        document.getElementById('tbody').insertRow(-1).innerHTML='<tr><td colspan="5" class="text-center"><div class="spinner-border spinner-border-sm text-primary" role="status">'+
        '<span class="visually-hidden">Loading...</span></div></td></tr>';
      },
      success:  function (data) { 
        x=0;   
        $("#tabla_rel tbody tr").remove();
        jQuery(data).each(function(i, item){ 
          x++;
          var nuevaFila   = '<tr>';
          nuevaFila  += '<th class="text-center">'+x+'</th>';
          nuevaFila  += '<td>'+item.nomcomp+'</td>';
          nuevaFila  += '<td class="text-center">'+item.nomtipocomp+'</td>';
          nuevaFila  += '<td class="text-center">'+item.perfil+'</td>';
          nuevaFila  += '<td class="text-center"><i class="fa-solid fa-trash-can fa-lg dell" onclick="delrow('+item.idcomp+')" ></i></td>';
          nuevaFila  += '</tr>';
          document.getElementById('tbody').insertRow(-1).innerHTML =nuevaFila;
          document.getElementById('nombrejer').value=item.nombrejer; 
          document.getElementById('tipojer').value=item.tipo; 
          document.getElementById('orden').value=item.orden; 
          if(item.status!='true'){document.getElementById('status').checked=false;}else{document.getElementById('status').checked=true;} 
        });
        document.getElementById('div_cant'+id).innerHTML=x;
      } 
    });
  }

  function agregarFila() 
  {
    var _token = $('input[name="_token"]').val();
    id = document.getElementById('idjer').value;
    id_comp = document.getElementById('selcomp').value;
    id_tipo_comp = document.getElementById('tipo_comp').value;
    esperado = document.getElementById('esperado').value;
    if(id_comp>0)
    { if(id_tipo_comp>0)
      { if(esperado>0 && esperado<=10)
        { var parametros = {
          "id": id,
          "id_comp": id_comp,
          "id_tipo_comp": id_tipo_comp,
          "esperado": esperado,
          "_token" : _token};
          $.ajax({
              data:  parametros, 
              url:   "{{ route('jerarquias.create') }}",
              type:  'POST', 
              dataType: "json",
              cache: true, 

              success:  function (data) { 
                var n=0;
                x=0;
                $("#tabla_rel tbody tr").remove();
                jQuery(data).each(function(i, item){ 
                  x++;
                  $("#selcomp option[value='"+item.idcomp+"']").remove();
                  var nuevaFila   = '<tr>';
                  nuevaFila  += '<th class="text-center">'+x+'</th>';
                  nuevaFila  += '<td>'+item.nomcomp+'</td>';
                  nuevaFila  += '<td class="text-center">'+item.nomtipocomp+'</td>';
                  nuevaFila  += '<td class="text-center">'+item.perfil+'</td>';
                  nuevaFila  += '<td class="text-center"><i class="fa-solid fa-trash-can fa-lg dell" onclick="delrow('+item.idcomp+')" ></i></td>';
                  nuevaFila  += '</tr>';
                  document.getElementById('tbody').insertRow(-1).innerHTML =nuevaFila;
                  document.getElementById('nombrejer').value=item.nombrejer; 
                  document.getElementById('tipojer').value=item.tipo; 
                  document.getElementById('orden').value=item.orden; 
                  if(item.status!='true'){document.getElementById('status').checked=false;}else{document.getElementById('status').checked=true;} 
                });
                document.getElementById('div_cant'+id).innerHTML=x; 
              }
            });
              document.getElementById('selcomp').value=0;
              document.getElementById('tipo_comp').value=0;
              document.getElementById('esperado').value=10;
              bien('Competencia asignada');
        }
        else
        { mal("El nivel esperado debe ser entre 1 y 10.");}
      }
      else
      { mal("Debe seleccionar un tipo de competencia.");}
    }
    else
    { mal("Debe seleccionar una competencia.");}
  }

  function carga_comp(id)
  {
    var _token = $('input[name="_token"]').val();
    var parametros = {"id": id,"_token" : _token};

    $("#selcomp").empty().append("<option value='0' selected>Seleccione</option>");
    $.ajax({
      data:  parametros,
      url:   "{{ route('jerarquias.showcomp') }}", 
      type:  'POST', 
      dataType: "json",
      cache: true, 
      success:  function (data) {   
        jQuery(data).each(function(i, item){ 
          $("#selcomp").append("<option value='"+item.idcomp+"'>"+item.nomcomp+"</option>");
        });
      } 
    });
  }

  function delrow(idcomp)
  { 
    var id = document.getElementById('idjer').value;
    var _token = $('input[name="_token"]').val();
    var parametros = {"id": id,"idcomp": idcomp,"_token" : _token};
    Swal.fire({
      title: "Eliminar Asignación",
      text: "Se desvinculará la competencia de la jerarquía, Desea Continuar?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, Eliminar!"
    }).then((result) => { 
      if (result.isConfirmed) 
      { $.ajax({
        data:  parametros,
        url:   "{{ route('jerarquias.destroycomp') }}", 
        type:  'POST', 
        dataType: "json",
        cache: true, 
        success:  function (data) { 
          var n=0;
          x=0;
          $("#tabla_rel tbody tr").remove();
          jQuery(data).each(function(i, item){ 
            x++;
            $("#selcomp option[value='"+item.idcomp+"']").remove();
            var nuevaFila   = '<tr>';
            nuevaFila  += '<th class="text-center">'+x+'</th>';
            nuevaFila  += '<td>'+item.nomcomp+'</td>';
            nuevaFila  += '<td class="text-center">'+item.nomtipocomp+'</td>';
            nuevaFila  += '<td class="text-center">'+item.perfil+'</td>';
            nuevaFila  += '<td class="text-center"><i class="fa-solid fa-trash-can fa-lg dell" onclick="delrow('+item.idcomp+')" ></i></td>';
            nuevaFila  += '</tr>';
            document.getElementById('tbody').insertRow(-1).innerHTML =nuevaFila;
            document.getElementById('nombrejer').value=item.nombrejer; 
            document.getElementById('tipojer').value=item.tipo; 
            document.getElementById('orden').value=item.orden; 
            if(item.status!='true'){document.getElementById('status').checked=false;}else{document.getElementById('status').checked=true;} 
          });
          document.getElementById('div_cant'+id).innerHTML=x; 
        }
      });
    }});
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