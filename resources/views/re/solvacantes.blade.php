<!DOCTYPE html>
@extends('layouts.plantilla')

@section('title','Solicitudes de Vacantes')

@section('content')

<!-- Button trigger modal -->
  <div class="row">
      <div class="col-4">        
            <select class="form-select form-select-sm" name="sel_ue" id="sel_ue" aria-label="Default select example" onchange="muestra_estructura()">
                <option value='0' selected>Seleccione Unidad Económica</option>
                @foreach( $data_sups as $sup )
                    <option value="{{ $sup->id }}">{{ $sup->nameund }}</option>
                @endforeach
          </select>
      </div>

  </div>
<hr>
  <small>
    <div id="tabla_estructura" class="d-flex align-items-center justify-content-center">  </div>
  </small>





<!-- Modal listado de colaboradores-->
<div class="modal fade" id="modalcolab" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg  modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title" id="staticBackdropLabel">Lista de Colaboradores</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Posición: </label>
          <span id="lb_nom_posicion" class="text-primary text-sm"></span>
        </div>
        <div class="mb-3" id="list_colab">
          <table class="table table-striped table-sm table-bordered" id="MyTable_unidad">
            <thead>
              <tr>
                <th scope="col" class="text-center bg-light">#</th>
                <th scope="col" class="text-center bg-light">Código</th>
                <th scope="col" class="text-center bg-light">Cédula</th>
                <th scope="col" class="text-center bg-light">Nombre</th>
              </tr>
            </thead>
            <tbody id="body_colab">              
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cancelar</button>
      </div>
    </div>
  </div>
</div>




<!-- Modal solicitudes de vacantes-->
<div class="modal fade" id="modalsoli" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg  modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title text-primary" id="staticBackdropLabel"><i class="fas fa-plus-circle fa-lg text-secondary"></i> Solicitud de vacante</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3 row">
          <label class="col-form-label-sm col-form-label"><b>Posición:</b> </label>            
            <label id="lb_nom_posicion_sol" class="col-sm-10 col-form-label col-form-label-sm"></label>            
        </div>
        <div class="mb-3 row">
          <label class="col-form-label-sm col-form-label"><b>Propósito del puesto:</b> </label>            
            <label id="lb_proposito" class="col-sm-12 col-form-label col-form-label-sm"></label>            
        </div>
        <hr>
        <form class="row">
          <div class="mb-3 row">
            <div class="col-sm-6">
              <label for="sel_PAGADORA" class="form-label col-form-label-sm"><b>PAGADORA:</b></label>
                <select id="sel_PAGADORA" class="form-select form-select-sm" onchange="findceco(this)" >
                  <option value='0' class="text-muted" selected>Seleccione</option>
                  @foreach( $data_PAGADORAs as $PAGADORAs )
                    <option value="{{ $PAGADORAs->COD_PAGADORA }}">{{ $PAGADORAs->COD_PAGADORA }} - {{ $PAGADORAs->PAGADORA }}</option>
                  @endforeach
                </select>
            </div>
            <div class="col-sm-6">
              <label for="sel_ceco" class="form-label col-form-label-sm"><b>Centro de costo:</b></label>
                <select id="sel_ceco" class="form-select form-select-sm" disabled>
                </select>
            </div>
          </div>

          <div class="col-sm-12 mb-3">
            <label for="sel_motivo" class="form-label col-form-label-sm"><b>Motivo de la solicitud:</b></label>
              <select id="sel_motivo" class="form-select form-select-sm" onchange="autorizacion()">
                <option value='0' class="text-muted" selected>Seleccione</option>
                @foreach( $data_vacantes_motivo as $vacantes_motivo )
                  <option value="{{ $vacantes_motivo->id }}">{{ $vacantes_motivo->motivo }}</option>
                @endforeach
              </select>
          </div>

          <div id="div_doc_autorizacion" style="display: none;">           
            <div class="mb-3">
              <label for="doc_autorizacion" class="col-sm-12 col-form-label col-form-label-sm">Adjuntar autorización</label>
              <input class="form-control form-control-sm" id="doc_autorizacion" type="file">
            </div>
          </div>
          
          <input id="tiemporeal" value="0" type="hidden">
          <input id="id_puesto" value="0" type="hidden">
          <input id="codigo_puesto" value="-" type="hidden">
          <input id="id_secc" value="0" type="hidden">
          <input id="id_ue" value="0" type="hidden">
          <input id="id_jer" value="0" type="hidden">
          <input id="id_escala" value="0" type="hidden">

          <br>
          <div class="col-sm-2">
            <label for="cant_vac" class="form-label col-form-label-sm"><b>Cantidad:</b></label>
              <input type="number" class="form-control form-control-sm" onchange="nuevotiempo()" id="cant_vac" value="1" min="1" pattern="^[0-9]+" onpaste="return false;" onDrop="return false;" autocomplete="off">
          </div>

          <div class="col-sm-4">
            <label for="sel_sex" class="form-label col-form-label-sm"><b>Género:</b></label>
              <select id="sel_sex" class="form-select form-select-sm">
                <option value='0' class="text-muted" selected>Seleccione</option>
                @foreach( $data_vacantes_genero as $vacantes_genero )
                  <option value="{{ $vacantes_genero->letra }}">{{ $vacantes_genero->genero }}</option>
                @endforeach
              </select>
          </div>
          
          <div class="col-sm-4 mb-3">
            <label for="sel_edad" class="form-label col-form-label-sm"><b>Rango de edad:</b></label>
              <select id="sel_edad" class="form-select form-select-sm">
                <option value='0' class="text-muted" selected>Seleccione</option>
                @foreach( $data_vacantes_edades as $vacantes_edades )
                  <option value="{{ $vacantes_edades->rango }}">{{ $vacantes_edades->rango }}</option>
                @endforeach
              </select>
          </div>

          <div class="col-sm-12 col-form-label col-form-label-sm"><b>NOTA:</b> <span class="col-sm-12 mb-3 fw-bolder text-primary" id="lb_tiempo"></span> días calendario es tiempo estipulado según la cantidad de vacantes que se esta solicitando.</div>
          <div class="col-sm-12">
            <label for="textareacoment" class="form-label col-form-label-sm"><b>Comentarios adicionales:</b></label>
            <textarea class="form-control" id="textareacoment" rows="3"></textarea>
          </div>        
        </form>
      </div>
      <div class="modal-footer bg-light">        
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cancelar</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="su(1)"  tabindex="-1" id="bto_guarda" style="display: block"><i class="fas fa-paper-plane pr-2"></i> Enviar</button>
      </div>
    </div>
  </div>
</div>
@endsection

<script type='text/javascript'>
  function muestra_estructura()
  {
    var _token = $('input[name="_token"]').val();
    sel_ue = document.getElementById('sel_ue').value;
    if(sel_ue>0)
    {
      var parametros = {
      "sel_ue" : sel_ue,
      "opt": 'sol_vac',
      "_token":_token};
      $.ajax({
        data:  parametros, 
        url:   "{{ route('estructura.procedimientos') }}",
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

  function modalcolab(cod_uni,cod_pue)
  { var _token = $('input[name="_token"]').val();

      var n=0;
      $("#MyTable_unidad tbody tr").each(function () 
      { n++;});
      for(i=n;i>=0;i--)
      { $("#MyTable_unidad tbody tr:eq('"+i+"')").remove();};

      document.getElementById('lb_nom_posicion').innerHTML=document.getElementById('div_nom_puest_'+cod_pue).innerHTML;
      var parametros = {
        "sel_ue" : cod_uni,
        "cod_pue" : cod_pue,
        "opt": 'sol_vac_listcolab',
        "_token":_token};
        $.ajax({
          data:  parametros, 
          url:   "{{ route('estructura.procedimientos') }}",
          type:  'POST', 
          cache: true, 
          beforeSend: function () {
            document.getElementById("list_colab").innerHTML='<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
          },
            success:  function (data) { document.getElementById("list_colab").innerHTML=data;
          }
        });
  }

  function modalsolicitud(cod_uni,cod_pue,id_pue)
  { var _token = $('input[name="_token"]').val();
    limpiar();
    document.getElementById('lb_nom_posicion_sol').innerHTML=document.getElementById('div_nom_puest_'+cod_pue).innerHTML;
    var parametros = {
      "id_pue" : id_pue,
      "_token":_token};
      $.ajax({
        data:  parametros, 
        url:   "{{ route('solvacantes.show') }}",
        type:  'POST', 
        dataType: "json",
        cache: true, 
        beforeSend: function () { document.getElementById("lb_proposito").innerHTML='<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';},
        success:  function (data) { 
          jQuery(data).each(function(i, item){
            document.getElementById("lb_proposito").innerHTML = item.proposito;
            document.getElementById("lb_tiempo").innerHTML = item.tiempo;
            document.getElementById("tiemporeal").value = item.tiempo;

            document.getElementById("id_puesto").value = id_pue;
            document.getElementById("codigo_puesto").value = cod_pue;
            document.getElementById("id_secc").value = item.id_secc;
            document.getElementById("id_ue").value = item.id_ue;
            document.getElementById("id_jer").value = item.id_jer;
            document.getElementById("id_escala").value = item.id_escala;
          });          
        }
      });
  }
  
  function autorizacion()
  { var _token = $('input[name="_token"]').val();
    var id_motivo=document.getElementById("sel_motivo").value;
    var parametros = {
      "id_motivo" : id_motivo,
      "_token":_token};
      $.ajax({
        data:  parametros, 
        url:   "{{ route('solvacantes.viewmotivo') }}",
        type:  'POST', 
        dataType: "json",
        cache: true,        
        success:  function (data) { 
          jQuery(data).each(function(i, item){
            if(item.necesita=='true')
            { document.getElementById("div_doc_autorizacion").style.display="block";}
            else
            { document.getElementById("div_doc_autorizacion").style.display="none";}          
          });
       }
      });
  }
  
  function nuevotiempo()
  { document.getElementById("lb_tiempo").innerHTML='';
    cantidad=  parseInt(document.getElementById('cant_vac').value);
    tiemporeal= parseInt(document.getElementById("tiemporeal").value);
    document.getElementById("lb_tiempo").innerHTML= tiempocalculador(tiemporeal,cantidad);
    //document.getElementById("lb_tiempo").innerHTML=tiemporeal;
  }

  function tiempocalculador(tiemporeal,cantidad)
  {
    return(Math.round((tiemporeal*(((cantidad-1)*10)/100))+tiemporeal));
  }

  function su(opt)
  { var _token = $('input[name="_token"]').val();
    var id_puesto = document.getElementById("id_puesto").value;
    var codigo_puesto = document.getElementById("codigo_puesto").value;
    var id_secc = document.getElementById("id_secc").value;
    var id_ue = document.getElementById("id_ue").value;
    var id_jer = document.getElementById("id_jer").value;
    var id_escala = document.getElementById("id_escala").value;
    var tiemporeal = parseInt(document.getElementById("tiemporeal").value);
    var id_motivo = document.getElementById("sel_motivo").value;
    var cantidad=  parseInt(document.getElementById('cant_vac').value);
    var genero = document.getElementById('sel_sex').value;
    var edad = document.getElementById('sel_edad').value;
    var archivo = document.getElementById("doc_autorizacion").files;    
    var tiempocalculado=tiempocalculador(tiemporeal,cantidad);
    var comentarios = document.getElementById("textareacoment").value;
    var sel_PAGADORA = document.getElementById("sel_PAGADORA").value;
    var sel_ceco = document.getElementById("sel_ceco").value;

    if((id_motivo==3 || id_motivo==4)&&archivo.length==0)
    { mal('Por favor adjuntar la autorización de la solicitud de la vacante.');}
    else
    { if(id_motivo!=3 & id_motivo!=4){ archivo ='-';}}

    
    if(sel_ceco.length>0)
    { 

    if(id_motivo!=0)
    { 
      if(archivo.length>0)
      { if(archivo!='-'){ file = archivo[0];}else{file='-';}
        if(cantidad>0)
        {
          if(genero.length>0)
          {
            if(edad.length>0)
            { 
            var data = new FormData();
                data.append("id_puesto",id_puesto);
                data.append("codigo_puesto", codigo_puesto);
                data.append("cantidad",cantidad);
                data.append("genero",genero);
                data.append("rango_edad",edad);
                data.append("comentarios",comentarios);
                data.append("id_secc",id_secc);
                data.append("id_ue",id_ue);
                data.append("id_jer",id_jer);
                data.append("id_escala",id_escala);
                data.append("tiemporeal",tiemporeal);
                data.append("tiempocalculado",tiempocalculado);
                data.append("id_motivo",id_motivo);
                data.append("fileToUpload",file);
                data.append("sel_PAGADORA",sel_PAGADORA);
                data.append("sel_ceco",sel_ceco);
                data.append("_token" ,_token);
              $.ajax({
                data: data, 
                url:   "{{ route('solvacantes.store') }}",
                            type:  'POST',//método de envio
                            contentType: false,       // The content type used when sending data to the server.
                            cache: false,             // To unable request pages to be cached
                            processData:false,			// To send DOMDocument or non processed data file it is set to false+
                            dataType: "json",
                success:  function (data) { 
                  jQuery(data).each(function(i, item){
                    if(item.sube==0||item.sube==1)
                    { $('#modalsoli').modal('hide');
                      bien("La solicitud de vacante ha sido enviada");
                      document.getElementById("id_totcant_"+id_puesto).innerHTML=item.totcantidad;
                      limpiar();
                    }
                    else
                    { document.getElementById("div_doc_autorizacion").style.display="none";
                      mal('No fue posible adjuntar el archivo de autorización, por favor verifique y vuelva a enviar');
                    }    
                  });              
                }
              });
            }
            else
            { mal('Por favor seleccionar el rángo de edad.');}
          }
          else
          { mal('Por favor seleccionar el género.');}
        }
        else
        { mal('Por favor indicar la cantidad de vacantes a solicitar.');}
      }
    }
    else
    { mal('Por favor seleccionar el motivo de la solicitud.');}
  }
    else
    { mal('Por favor seleccionar el centro de costo.');}
  }

  function findceco(COD_PAGADORA)
  { var _token = $('input[name="_token"]').val();

    if(COD_PAGADORA.value.length>0)
    {
      var parametros = {
        "COD_PAGADORA" : COD_PAGADORA.value,
        "_token":_token};
        $.ajax({
          data:  parametros, 
          url:   "{{ route('solvacantes.ceco') }}",
          type:  'POST', 
          dataType: "json",
          cache: true,        
          success:  function (data) {               
            $('#sel_ceco').empty();
            $('#sel_ceco').append("<option value='0'>Seleccionar</option>"); 
            jQuery(data).each(function(i, item){  
              $('#sel_ceco').append("<option value='"+ item.cod_cia +"'>"+item.cod_cia+' - '+ item.nom_cia+ "</option>"); 
            });
            $('#sel_ceco').removeAttr("disabled");           
        }
        });
      }
      else{
        $('#sel_ceco').empty();
        $('#sel_ceco').prop('disabled', true);
      }
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

function mal(msn)
{
    Swal.fire({
        position: 'center',
        icon: 'warning',
        text: msn,
  })
}
function limpiar()
{ document.getElementById("sel_motivo").value=0;
  document.getElementById("lb_proposito").innerHTML = '';
  document.getElementById("lb_tiempo").innerHTML = '';
  document.getElementById("tiemporeal").value = 0;
  document.getElementById("id_puesto").value = 0;
  document.getElementById("codigo_puesto").value= '-';
  document.getElementById("id_secc").value  = 0;
  document.getElementById("id_ue").value = 0;
  document.getElementById("id_jer").value = 0;
  document.getElementById("id_escala").value = 0;
  document.getElementById('sel_sex').value=0;
  document.getElementById('sel_edad').value=0;
  document.getElementById("doc_autorizacion").value='';
  document.getElementById('cant_vac').value=1;
    document.getElementById('textareacoment').value='';
    document.getElementById('lb_nom_posicion_sol').innerHTML='';
}
  </script>