<!DOCTYPE html>
@extends('layouts.plantilla')

@section('title','Solicitudes de Vacantes')
<style>
.text-justify {
    text-align: justify;
    text-justify: inter-word;
}
</style>
@section('content')
<div class="pagetitle pb-0 mb-0">
  <div class="row pb-0 mb-0">
    <div class="col-8 my-0 py-0">
      <h1 class="text-secondary">Solicitud de Contratación</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"style="font-weight: normal;">Control del HeadCount</li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<div class="card">
  <div class="card-header pb-0">
    <h5><i class="fas fa-users"></i> Control del HeadCount</h5>    
  </div>
  <div class="card-body">
    <div class="row mt-2">
        <div class="col-4">        
              <select class="form-select form-select-sm" name="sel_grp" id="sel_grp" aria-label="Default select example" onchange="sel_uniades(this.value)">
                  <option value='0' selected>Seleccionar Grupo</option>
                  @foreach( $data_sups as $sup )
                      <option value="{{ $sup->idgrupo."-".$sup->tienda }}">{{ $sup->grupo }}</option>
                  @endforeach
            </select>
        </div>
        <div class="col-4">        
              <select class="form-select form-select-sm" name="sel_ue" id="sel_ue" aria-label="Default select example" onchange="muestra_estructura()" disabled>
                  <option value='0' selected>Seleccionar Unidad</option>
                  @foreach( $data_sups as $sup )
                      <option value="{{ $sup->idgrupo."-".$sup->tienda }}">{{ $sup->grupo }}</option>
                  @endforeach
            </select>
        </div>
    </div>
    <hr>
    <small>
      <div id="tabla_estructura" class="d-flex align-items-center justify-content-center">  </div>
    </small>
  </div>
</div> 

<!-- Modal listado de colaboradores-->
<div class="modal fade" id="modalcolab" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
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

<!-- Modal solicitudes de vacantes - Minimalista y Corporativo -->
<div class="modal fade" id="modalsoli" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" id="div_modalsoli">
    <div class="modal-content border-0 shadow-sm">
      
      <!-- Header -->
      <div class="modal-header bg-light border-bottom py-2">
        <h5 class="modal-title text-primary fw-bold" id="staticBackdropLabel">
          <i class="fas fa-plus-circle me-2"></i> Solicitud de Contratación de Personal
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <!-- Body -->
      <div class="modal-body px-4 py-3">
        <div id="div_form_solicitud">
          <form class="row g-3">
            @csrf
            <div class="d-flex justify-content-between align-items-center w-100">
              <div>
                <span class="text-secondary fw-semibold">Posición:</span>
                <label id="lb_nom_posicion_sol" class="text-muted"></label>
              </div>
              <div>
                <div class="form-check {{ $show_conficencial }}">
                  <input class="form-check-input" type="checkbox" value="" id="Confidencial">
                  <label class="form-check-label" for="Confidencial">
                    Confidencial
                  </label>
                </div>
              </div>
            </div>
            <!-- Motivo de solicitud -->
            <div class="col-12">
              <label class="form-label text-secondary fw-semibold mb-0">Motivo de la solicitud</label>
              <select id="sel_motivo" class="form-select" onchange="autorizacion()">
                <option value='0' class="text-muted" selected>Seleccione</option>
                @foreach($data_vacantes_motivo as $vacantes_motivo)
                  <option value="{{ $vacantes_motivo->id }}">{{ $vacantes_motivo->motivo }}</option>
                @endforeach
              </select>
            </div>
            <!-- Autorización (oculto hasta necesario) -->
            <div id="div_doc_autorizacion" class="col-12" style="display: none;">
              <label class="form-label text-secondary fw-semibold mb-0">Adjuntar autorización</label>
              <input class="form-control form-control-sm" id="doc_autorizacion" type="file">
            </div>
            <!-- Hidden inputs -->
            <div>
              <input id="tiemporeal" value="0" type="hidden">
              <input id="id_puesto" value="0" type="hidden">
              <input id="codigo_puesto" value="-" type="hidden">
              <input id="id_secc" value="0" type="hidden">
              <input id="id_ue" value="0" type="hidden">
              <input id="id_jer" value="0" type="hidden">
              <input id="id_escala" value="0" type="hidden">
            </div>
            <!-- Cantidad, Género, Edad -->
            <div class="col-sm-2">
              <label class="form-label text-secondary fw-semibold mb-0">Cantidad</label>
              <input type="number" class="form-control" onchange="nuevotiempo()" id="cant_vac" value="1" min="1" pattern="^[0-9]+" onpaste="return false;" onDrop="return false;" autocomplete="off">
            </div>
            <div class="col-sm-5">
              <label class="form-label text-secondary fw-semibold mb-0">Género</label>
              <select id="sel_sex" class="form-select">
                <option value='0' class="text-muted" selected>Seleccione</option>
                @foreach($data_vacantes_genero as $vacantes_genero)
                  <option value="{{ $vacantes_genero->letra }}">{{ $vacantes_genero->genero }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-5">
              <label class="form-label text-secondary fw-semibold mb-0">Rango de edad</label>
              <select id="sel_edad" class="form-select">
                <option value='0' class="text-muted" selected>Seleccione</option>
                @foreach($data_vacantes_edades as $vacantes_edades)
                  <option value="{{ $vacantes_edades->rango }}">{{ $vacantes_edades->rango }}</option>
                @endforeach
              </select>
            </div>
            <!-- Nota sobre tiempo -->
            <div class="col-12">
              <small class="alert alert-primary py-2 my-3" role="alert">  
                <b>NOTA: </b> <span id="lb_tiempo"></span> días calendario representa el tiempo estimado para cubrir la cantidad de vacantes solicitadas.
              </small>
            </div>
            <!-- Rango salarial -->
            <div class="col-12 pt-2 mb-3">
              <label class="form-label text-secondary fw-semibold mb-0">Rango salarial</label>
              <div class="row g-2">
                <div class="col-sm-4">
                  <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light fw-bold">Mínimo</span>
                    <input type="number" class="form-control" id="salario_min" min="0" placeholder="Ej: 1200" step="0.01">
                    <span class="input-group-text">$</span>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light fw-bold">Máximo</span>
                    <input type="number" class="form-control" id="salario_max" min="0" placeholder="Ej: 1800" step="0.01">
                    <span class="input-group-text">$</span>
                  </div>
                </div>
              </div>
              <small class="form-text text-muted">
                Indique el rango salarial disponible para este puesto. Ambos valores deben ser coherentes.
              </small>
            </div>
            <!-- Requisitos -->
            <div class="col-12">
              <label class="form-label text-secondary fw-semibold mb-0">Requisitos imprescindibles para la contratación</label>
              <textarea class="form-control" id="textareacoment" rows="2"></textarea>
              <small class="form-text text-primary mt-0">
                En caso de que la contratación incluya beneficios adicionales, favor detallarlos.
              </small>
            </div>
          </form>
        </div>
        <div id="div_form_perfil" class="d-none">
          <h5>Perfil del puesto</h5><hr>
          <div class="d-flex justify-content-between align-items-center w-100 mb-3">
            <div>
              <span class="text-secondary fw-semibold">Posición:</span>
              <label id="lb_nom_posicion_perfil" class="text-primary"></label>
            </div>
          </div>
            <div class="mb-3 w-100">
              <span class="text-secondary fw-semibold">Propósito:</span><br>
              <label id="lb_proposito" class="text-muted text-justify"></label>
            </div>
            <div class="row align-items-center justify-content-center text-center my-3">
              <div class="col-sm-10 align-items-center justify-content-center text-center">
                <div class="align-items-center justify-content-center shadow " style=" border: 1px solid #b9bcbe; border-radius: 0.75rem; padding: 8px;">
                  <table id="table_comp" class="display compact table table-sm table-hover small" style="width:100%">
                    <thead>
                      <tr>
                        <th class="text-secondary text-center align-middle table-primary" rowspan="2" width='30%'>COMPETENCIAS</th>
                        <th class="text-secondary text-center align-middle table-primary" rowspan="2" width='20%'>CRITICIDAD</th>
                        <th class="text-secondary text-center align-middle table-primary" colspan="10">NIVEL MÁXIMO</th>
                      </tr>
                      <tr>
                        <th class="text-secondary text-center align-middle table-secondary" width='4%'>1</th>
                        <th class="text-secondary text-center align-middle table-secondary" width='4%'>2</th>
                        <th class="text-secondary text-center align-middle table-secondary" width='4%'>3</th>
                        <th class="text-secondary text-center align-middle table-secondary" width='4%'>4</th>
                        <th class="text-secondary text-center align-middle table-secondary" width='4%'>5</th>
                        <th class="text-secondary text-center align-middle table-secondary" width='4%'>6</th>
                        <th class="text-secondary text-center align-middle table-secondary" width='4%'>7</th>
                        <th class="text-secondary text-center align-middle table-secondary" width='4%'>8</th>
                        <th class="text-secondary text-center align-middle table-secondary" width='4%'>9</th>
                        <th class="text-secondary text-center align-middle table-secondary" width='4%'>10</th>
                      </tr>
                    </thead>
                    <tbody class="text-secondary" id="tbody_comp">                           
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="row align-items-center justify-content-center text-center my-3">
              <div class="col-sm-10 align-items-center justify-content-center text-center">
                <div class="align-items-center justify-content-center shadow " style=" border: 1px solid #b9bcbe; border-radius: 0.75rem; padding: 8px;">
                  <table id="table_habilidad" class="display compact table table-sm table-hover small" style="width:100%">
                    <thead>
                      <tr>
                        <th class="text-secondary text-center align-middle table-primary">Habilidades y conocimientos técnicos</th>
                        <th class="text-secondary text-center align-middle table-primary" width='20%'>Deseado o Indispensable</th>
                      </tr>
                    </thead>
                    <tbody class="text-light" id="tbody_habilidad">
                    </tbody>
                  </table>      
                </div>
              </div>
            </div>
        </div> 
      </div>
      <!-- Footer -->
      <div class="modal-footer bg-light py-2 border-top">
        <div class="d-flex justify-content-between align-items-center w-100">
          <div class="form-check form-switch"  style="cursor: pointer;">
            <input class="form-check-input" type="checkbox" id="sw_verperfil" style="cursor: pointer;">
            <label class="form-check-label" for="sw_verperfil" id="lb_verperfil" style="cursor: pointer;">
               Ver perfil del puesto
            </label>
          </div>

          <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-secondary btn-sm" id="bto_cancelar" data-bs-dismiss="modal" onclick="limpiar()">
              <i class="fa-solid fa-arrow-left me-1"></i> Cancelar
            </button>
            <button type="button" class="btn btn-success btn-sm" onclick="send()" id="bto_guarda">
              <i class="fas fa-paper-plane me-1"></i> Solicitar
            </button>
          </div>
        </div>
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
    if(sel_ue.length>0)
    {
      var parametros = {
      "sel_ue" : sel_ue,
      "opt": 'sol_vac',
      "_token":_token};
      $.ajax({
        data:  parametros, 
        url:   "{{ route('procedimientos.show') }}",
        type:  'POST', 
        cache: true, 
    
        beforeSend: function () {
          document.getElementById("tabla_estructura").innerHTML=
        '<div class="d-flex justify-content-center align-items-center" style="height: 50vh;" id="div_spinner">'+
          '<div class="spinner-border text-primary me-2" role="status"></div>'+
          '<span class="small text-secondary">Cargando...</span>'+
        '</div>';
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
          url:   "{{ route('procedimientos.show') }}",
          type:  'POST', 
          cache: true, 
          beforeSend: function () {
            document.getElementById("list_colab").innerHTML='<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
          },
            success:  function (data) { document.getElementById("list_colab").innerHTML=data;
          }
        });
  }

  function modalsolicitud(cod_uni,id_pue)
  { var _token = $('input[name="_token"]').val();+
    limpiar();
    $('#sw_verperfil').prop('checked', false);

    $('#salario_min').val('');
    $('#salario_max').val('');
    $('#textareacoment').val('');
    // Mostrar solicitud
    $('#div_form_solicitud').removeClass('d-none');
    $('#div_form_perfil').addClass('d-none');

    // Mostrar botones
    $('#bto_cancelar, #bto_guarda').removeClass('d-none');
    $('#div_modalsoli').addClass('modal-lg');
    $('#div_modalsoli').removeClass('modal-xl');
    $('#lb_verperfil').removeClass('text-primary');
    document.getElementById('lb_nom_posicion_sol').innerHTML=document.getElementById('div_nom_puest_'+id_pue).innerHTML;
    $('#lb_nom_posicion_perfil').html($('#div_nom_puest_'+id_pue).html());
    var parametros = {
      "id_pue" : id_pue,
      "_token":_token};
      $.ajax({
        data:  parametros, 
        url:   "{{ route('solvacantes.show') }}", 
        type:  'POST', 
        dataType: "json",
        cache: true, 
        //beforeSend: function () { document.getElementById("lb_proposito").innerHTML='<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';},
        success:  function (data) { 
          jQuery(data).each(function(i, item){
            document.getElementById("lb_tiempo").innerHTML = item.tiempo;
            document.getElementById("tiemporeal").value = item.tiempo;
            document.getElementById("id_puesto").value = id_pue;
            document.getElementById("id_secc").value = item.iduni;
            document.getElementById("id_ue").value = item.idue;
            document.getElementById("id_jer").value = item.idjer;
            document.getElementById("id_escala").value = item.id_escala;
            $('#lb_proposito').html(item.proposito);
            $('#tbody_comp').append(item.competencias);
            $("#tbody_comp").html('');
            jQuery(item.competencias).each(function(i, item_comp){               
                contendor  = $("#tbody_comp").html();
                nuevaFila   = '<tr>'+
                '<td class="text-sm-start ps-3" style="color:'+item_comp.color+'">'+item_comp.nombre+'</td><td class="text-center">'+item_comp.nomtipocomp+'</td><td></td><td></td><td></td><td></td><td></td><td';
                color='#fff';
                if(item_comp.perfil==8){color='greendf-8';}      
                nuevaFila+=' class="'+color+'"></td><td';
                color='#fff';
                if(item_comp.perfil==8){color='greendf-9';}
                if(item_comp.perfil==9){color='greendf-8';}         
                nuevaFila+=' class="'+color+'"></td><td';
                color='#fff';
                if(item_comp.perfil==8){color='greendf-10';}
                if(item_comp.perfil==9){color='greendf-9';}
                if(item_comp.perfil==10){color='greendf-8';}             
                nuevaFila+=' class="'+color+'"></td><td';
                color='#fff';
                if(item_comp.perfil==9){color='greendf-10';}
                if(item_comp.perfil==10){color='greendf-9';}             
                nuevaFila+=' class="'+color+'"></td><td';
                color='#fff';
                if(item_comp.perfil==10){color='greendf-10';}            
                nuevaFila+=' class="'+color+'"></td></tr>';
                $("#tbody_comp").html(contendor+nuevaFila);
            });
           
            $("#tbody_habilidad").html('');
            x=0;
            jQuery(data.habilidades).each(function(i, item){ 
              contendor  = $("#tbody_habilidad").html();
              x++;
              nuevaFila   = '<tr>'+
              '<td class="ps-2 text-secondary text-justify align-middle">'+item.habilidad.slice(3)+'</td>'+
              '<td class="align-middle">'+item.nivel+'</td>'+
              '</tr>';
              $("#tbody_habilidad").html(contendor+nuevaFila); 
            }); 
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

  function send() 
  { const _token = $('input[name="_token"]').val();
    const id_puesto = $("#id_puesto").val();
    const codigo_puesto = $("#codigo_puesto").val();
    const id_secc = $("#id_secc").val();
    const id_ue = $("#id_ue").val();
    const id_jer = $("#id_jer").val();
    const id_escala = $("#id_escala").val();
    const tiemporeal = parseInt($("#tiemporeal").val()) || 0;
    const id_motivo = parseInt($("#sel_motivo").val()) || 0;
    const cantidad = parseInt($("#cant_vac").val()) || 0;
    const genero = $('#sel_sex').val()?.trim();
    const edad = $('#sel_edad').val()?.trim();
    const comentarios = $('#textareacoment').val()?.trim() || '';
    const archivos = $('#doc_autorizacion').get(0).files;
    const tiempocalculado = tiempocalculador(tiemporeal, cantidad);
    const confidencial = $('#Confidencial').is(':checked') ? 1 : 0;
    const min_salarial = parseFloat($('#salario_min').val()) || 0;
    const max_salarial =  parseFloat($('#salario_max').val()) || 0;

    // Validaciones
    if (!id_motivo) {
      mal('Por favor seleccionar el motivo de la solicitud.');
      return;
    }
    if ((id_motivo === 3 || id_motivo === 4) && archivos.length === 0) {
      mal('Por favor adjuntar la autorización de la solicitud de contratación.');
      return;
    }
    if (cantidad <= 0) {
      mal('Por favor indicar la cantidad de vacantes a solicitar.');
      return;
    }
    if (!genero) {
      mal('Por favor seleccionar el género.');
      return;
    }
    if (!edad) {
      mal('Por favor seleccionar el rángo de edad.');
      return;
    }

    // Preparar datos para el envío
    const data = new FormData();
    data.append("id_puesto", id_puesto);
    data.append("codigo_puesto", codigo_puesto);
    data.append("cantidad", cantidad);
    data.append("genero", genero);
    data.append("rango_edad", edad);
    data.append("comentarios", comentarios);
    data.append("id_secc", id_secc);
    data.append("id_ue", id_ue);
    data.append("id_jer", id_jer);
    data.append("id_escala", id_escala);
    data.append("tiemporeal", tiemporeal);
    data.append("tiempocalculado", tiempocalculado);
    data.append("id_motivo", id_motivo);
    data.append("confidencial", confidencial);
    data.append("min_salarial", min_salarial);
    data.append("max_salarial", max_salarial);
    data.append("_token", _token);

    // Adjuntar archivo solo si corresponde
    if ((id_motivo === 3 || id_motivo === 4) && archivos.length > 0) {
      data.append("fileToUpload", archivos[0]);
    }

    // Deshabilitar el botón para evitar múltiples envíos
    $("#btn_enviar").prop("disabled", true);

    // Enviar solicitud AJAX
    $.ajax({
      data: data,
      url: "{{ route('solvacantes.store') }}",
      type: 'POST',
      contentType: false,
      cache: false,
      processData: false,
      dataType: "json",
      beforeSend: function () {
        $('#bto_guarda')
          .prop('disabled', true)
          .html('<i class="fa-solid fa-arrows-rotate fa-spin-pulse"></i> Enviando...');
      },
      success: function (response) {
        $("#btn_enviar").prop("disabled", false); // Reactivar botón
        jQuery(response).each(function (i, item) {
          if (item.sube === 0 || item.sube === 1) {
            $('#modalsoli').modal('hide');
            bien("La solicitud de vacante ha sido enviada");
            document.getElementById("id_totcant_" + id_puesto).innerHTML = item.totcantidad;
            limpiar(); // Asegúrate de que esta función limpie también el input file
            $('#doc_autorizacion').val('');
          } else {
            document.getElementById("div_doc_autorizacion").style.display = "none";
            mal('No fue posible adjuntar el archivo de autorización, por favor verifique y vuelva a enviar.');
          }
        });
      },
      error: function () {
        $("#btn_enviar").prop("disabled", false); // Reactivar botón
        mal('Error en la solicitud. Por favor intente nuevamente.');
      },
      complete: function () {
        $('#bto_guarda')
          .prop('disabled', false)
          .html('<i class="fas fa-paper-plane me-1"></i> Solicitar');
        }
    });
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
  { 
    document.getElementById("sel_motivo").value=0;
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

  function sel_uniades(idgrp) 
  { 
    document.getElementById("tabla_estructura").innerHTML='';
      if (idgrp.length > 0) {
          var parametros = {
              "idgrp": idgrp,
              "_token": $('input[name="_token"]').val()
          };

          $.ajax({
              data: parametros,
              url: "{{ route('solvacantes.unidades') }}",
              type: 'POST',
              dataType: "json",
              cache: true,
              success: function(response) {
                  $('#sel_ue').empty();
                  $('#sel_ue').append("<option value='0'>Seleccionar Unidad</option>");

                /* if (response.data.tipogrp == 1) {
                      // Agrupar por unidad
                      let grupoMap = {};

                      response.data.data_unidades.forEach(function(item) {
                          if (!grupoMap[item.unidad]) {
                              grupoMap[item.unidad] = [];
                          }
                          grupoMap[item.unidad].push(item);
                      });

                      // Generar optgroups y options por unidad
                      for (let unidad in grupoMap) {
                          let optgroup = $("<optgroup>").attr("label", unidad);
                          grupoMap[unidad].forEach(function(suc) {
                              optgroup.append(
                                  $("<option>")
                                      .val(suc.idsuc)
                                      .text(suc.suc ? `${suc.suc}` : '')
                              );
                          });
                          $('#sel_ue').append(optgroup);
                      }

                  } else {*/
                      // Unidades directas sin agrupación
                      response.data.data_unidades.forEach(function(item) {
                          $('#sel_ue').append(
                              $("<option>")
                                  .val(item.idunidad+'-'+item.tienda)
                                  .text(item.unidad)
                          );
                      });
                  //}

                  $('#sel_ue').removeAttr("disabled");
              },
              error: function(xhr) {
                  console.error("Error al cargar unidades", xhr);
                  $('#sel_ue').empty().prop('disabled', true);
              }
          });
      } else {
          $('#sel_ue').empty().prop('disabled', true);
      }
  }
</script>