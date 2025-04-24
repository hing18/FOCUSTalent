<!DOCTYPE html>
@extends('layouts.plantilla')

@section('title','Maestro de Competencias')


@section('content')

<!-- JavaScript -->
<script type="text/javascript">
  // <![CDATA[
   function preloader(){
      document.getElementById("preload").style.display = "none";
      document.getElementById("iframe").style.display = "block";
  // <!      document.getElementById("div_2").style.display = "block";
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
<style>
      /* Ajustar el tamaño del editor */
      trix-editor {
            width: 100%;           /* Ancho del editor (puedes ajustarlo según tu necesidad) */
            height: 80px;         /* Altura reducida */
            border: 1px solid #ccc; /* Puedes agregar borde si lo deseas */
            padding: 10px;          /* Espaciado dentro del editor */
            font-size: 14px;        /* Tamaño de fuente más pequeño */
        }

        /* Opción para ocultar el área de entrada (input hidden) */
        #x {
            display: none;
        }
</style>
<!-- Button trigger modal -->
  <div class="row">
    <div class="d-grid gap-2 d-md-flex justify-content-md-end" onclick="modalcrud(1,0)">
      <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-bs-toggle="modal" data-bs-target="#Modal">
        <span class="text fw-bold"> <i class="fas fa-plus pr-2"></i> Nueva Competencia</span>
      </a>
    </div>
  </div>

<hr>
<small>
  <div id="preload" class="align-items-center justify-content-center text-center p-4 mt-4"><div class=" mt-4 spinner-border text-primary" role="status"></div></div>
</small> 
<div id="iframe" style="display: none;">
    <div id="div_tabla">
        <table id="MyTable" class="display compact table table-striped shadow table-bordered bg-white table-sm" style="width:100%">
            <thead class="bg-secondary">
                <tr>
                    <th class="text-light text-center">COMPETENCIAS</th>
                    <th class="text-light text-center">DEFINICIÓN</th>
                    <th class="text-light text-center">ESTATUS</th>
                    <th class="text-light text-center" width='6%'><i class="fas fa-cog"></i></th>
                </tr>
            </thead>
            <tbody class="text-dark" id="bodyMyTable">
              @foreach( $resultcomp as $competencia )
                @php
                if( $competencia->status=='true' ){ $status='<i class="fa-solid fa-circle-check text-success fa-lg"></i>';}else{ $status='<i class="fa-solid fa-triangle-exclamation text-warning fa-lg"></i>';}
                @endphp
              <tr>
                <td>{{ $competencia->nombre }}</td>
                <td>{{ $competencia->definicion }}</td>
                <td> 
                  <div class="row d-flex align-items-center justify-content-center text-center">
                    <div class="col">@php echo $status; @endphp</div>
                  </div>
                </td>
                <td>
                  <div class="row d-flex align-items-center justify-content-center text-center">
                    <div class="col-md-2 col-xs-6 text-secondary">
                      <i class="fa-solid fa-pencil fa-lg edit" onclick="modalcrud(2,{{ $competencia->id }})" data-bs-toggle="modal" data-bs-target="#Modal"></i>  
                    </div>
                    <div class="col-md-2 col-xs-6 text-secondary">
                      <i class="fa-solid fa-trash-can fa-lg dell" onclick="modalcrud(3,{{ $competencia->id }})" ></i>
                    </div>
                  </div>
                </td>
              </tr>
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
            <div class="mb-3 row">
            <div class="col-6">
              <label for="namecomp" class="col-form-label col-form-label-sm fw-bold">Nombre de Competencia:</label>
              <input type="text" class="form-control form-control-sm" name="namecomp" id="namecomp">
              <input type="hidden" id="idcomp" value="0">
            </div>
            <div class="col-6 pt-4">
              <input class="form-check-input" type="checkbox" id="status" name="status" checked>
              <label class="form-check-label col-form-label-sm" for="status">
                Habilitado
              </label>
            </div>
          </div>
                       
              <div class="mb-3">
                <label for="definicion" class="form-label col-form-label-sm fw-bold">Definición:</label>
                <textarea class="form-control form-control-sm" name="definicion" id="definicion" rows="3"></textarea>
              </div>
                 
              <div class="mb-3">
                
                <label for="definicion_resumen" class="form-label col-form-label-sm fw-bold">Definición Resumen <span class="text-primary small">(Esta definición saldrá en la evaluación del desempeño)</span>:</label>
                  <small>
                    <input id="definicion_resumen" type="hidden" name="content">
                    <trix-editor input="definicion_resumen"></trix-editor>
                  </small>
              </div>

              <div class="mb-3">
                <label for="nivelalto" class="form-label col-form-label-sm fw-bold">Niveles Alto:</label>
                <textarea class="form-control form-control-sm" name="nivelalto" id="nivelalto" rows="3"></textarea>
              </div>

              <div class="mb-3">
                <label for="nivelbajo" class="form-label col-form-label-sm fw-bold">Niveles Bajo:</label>
                <textarea class="form-control form-control-sm" name="nivelbajo" id="nivelbajo" rows="3"></textarea>
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
    document.getElementById('idcomp').value=0;
    let trixEditor = document.querySelector("trix-editor");
    trixEditor.value = '';

    //NUEVA
    if(opt==1)
    { document.getElementById('ModalLabel').innerHTML ='<i class="fas fa-plus pr-2 fa-lg"></i> Nueva Competencia';
      document.getElementById('bto_guarda').style.display="block";
      document.getElementById('namecomp').value="";
      document.getElementById('definicion').value="";
      document.getElementById('definicion_resumen').value="";

      document.getElementById('nivelalto').value="";
      document.getElementById('nivelbajo').value="";
      document.getElementById('status').checked=true;
    }
    //EDITA
    if(opt==2)
    { 
      document.getElementById('ModalLabel').innerHTML ='<i class="fa-solid fa-pen-to-square  fa-lg"></i> Edita Competencia';
      document.getElementById('bto_actualiza').style.display="block";
      document.getElementById('idcomp').value=id;

      var parametros = {
      "id": id,
      "_token" : _token};
      $.ajax({
        data:  parametros,
        url:   "{{ route('competencias.edit') }}", 
        type:  'POST', 
        dataType: "json",
        cache: true, 
        success:  function (data) { 
          jQuery(data).each(function(i, item){ 

            document.getElementById('namecomp').value=item.nombre; 
            document.getElementById('definicion').value=item.definicion; 
            document.getElementById('definicion_resumen').value=item.definicion_resumen; 
            trixEditor.editor.insertHTML(item.definicion_resumen)
            document.getElementById('nivelalto').value=item.nivel_alto; 
            document.getElementById('nivelbajo').value=item.nivel_bajo; 
            if(item.status!='true'){document.getElementById('status').checked=false;}else{document.getElementById('status').checked=true;} 
          });
        }
      });
    }
    if(opt==3)
    { document.getElementById('idcomp').value=id;
      document.getElementById('namecomp').value='...'; 
      document.getElementById('definicion').value='...';
      document.getElementById('definicion_resumen').value='...';
      Swal.fire({
        title: "Eliminar Competencia",
        text: "Se procederá a eliminar la competencia, Desea Continuar?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",

        cancelButtonText:  '<i class="fas fa-arrow-left"></i> Cancelar',
        confirmButtonText: '<i class="fas fa-trash-alt"></i> Si, eliminar',
        }).then((result) => {
          if (result.isConfirmed) {su(opt);}
        });
    }
  }
  

  function su(opt)
  { var _token = $('input[name="_token"]').val();
    var nombre = $("#namecomp" ).val();    
    var status = document.getElementById('status').checked; 
    var definicion = $("#definicion" ).val();
    var definicion_resumen = $("#definicion_resumen" ).val();
    var nivelalto = $("#nivelalto" ).val();
    var nivelbajo = $("#nivelbajo" ).val();
    var id = $('#idcomp').val();
    
    if(opt==1)
    { var urls="{{ route('competencias.store') }}";}
    if(opt==2)
    { var urls="{{ route('competencias.update') }}";}
    if(opt==3)
    { var urls="{{ route('competencias.destroy') }}";}

      if(nombre.length>0)
      { if(definicion.length>0)
        {
          var parametros = {
          "nombre" : nombre,
          "status" : status,
          "definicion" : definicion,
          "definicion_resumen" : definicion_resumen,
          "nivelalto" : nivelalto,
          "nivelbajo" : nivelbajo,
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
                    item.nombre,
                    item.definicion,
                    '<div class="row d-flex align-items-center justify-content-center text-center"> <div class="col-md-2 col text-secondary">'+status+'</div></div>',
                    '<div class="row d-flex align-items-center justify-content-center text-center">'+
                    '<div class="col-md-2 col-xs-6 text-secondary">'+
                      '<i class="fa-solid fa-pencil fa-lg edit" onclick="modalcrud(2,'+item.id+')" data-bs-toggle="modal" data-bs-target="#Modal"></i>'+  
                    '</div>'+
                    '<div class="col-md-2 col-xs-6 text-secondary">'+
                      '<i class="fa-solid fa-trash-can fa-lg dell" onclick="modalcrud(3,'+item.id+')" ></i>'+
                    '</div>'+
                  '</div>'
                ]
                ).draw(false);                
              });
              document.getElementById('namecomp').value="";
              document.getElementById('definicion').value="";
              document.getElementById('definicion_resumen').value="";
              document.getElementById('nivelalto').value="";
              document.getElementById('nivelbajo').value="";
              document.getElementById('status').checked=true;
              if(opt==1)
              { bien('La competencia ha sido creada');}
              if(opt==2)
              { bien('La competencia ha sido actualizada');}
              if(opt==3)
              { bien('La competencia ha sido eliminada');}
              
              $('#Modal').modal('hide');
            }
          });
        }
        else
        {
          mal('Por favor colocar la definición de la competencia');
        }
      }
      else
      {
        mal('Por favor colocar el nombre de la competencia');
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
