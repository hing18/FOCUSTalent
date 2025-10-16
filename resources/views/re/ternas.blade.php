<!DOCTYPE html>
@extends('layouts.plantilla')

@section('title','Solicitudes de Vacantes')
<!-- JavaScript -->
<script type="text/javascript">
  function preloader(){
    document.getElementById("preload").style.display = "none";
    document.getElementById("iframe").style.display = "block";
  }
  window.onload = preloader;
</script>
<!-- Estilo -->
<style>
  div#iframe { display: none; }
  div#preload { cursor: wait; }
</style> 
<style>
  .tooltip.custom-tooltip .tooltip-inner {
    background-color: #cfe2ff;
    color: #084298;
    font-size: 14px;
    padding: 8px 10px;
    border-radius: 6px;
    box-shadow: 0 0 8px rgba(0,0,0,0.2);
  }
</style>
@section('content')
    <div class="pagetitle pb-0 mb-0">
      <div class="row pb-0 mb-0">
        <div class="col-8 my-0 py-0">
          <h1 class="text-secondary">Ternas</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"style="font-weight: normal;">Presentación de Ternas</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
    <small>
      <div id="preload" class="align-items-center justify-content-center text-center">
        <div class="d-flex justify-content-center align-items-center" style="height: 50vh;" id="div_spinner">
          <div class="spinner-border text-primary me-2" role="status"></div>
          <span class="small">Cargando...</span>
        </div>
      </div>
    </small>
    <small>
      <div id="div_cargando" class="align-items-center justify-content-center text-center d-none">
        <div class="d-flex justify-content-center align-items-center" style="height: 50vh;" id="div_spinner">
          <div class="spinner-border text-primary me-2" role="status"></div>
          <span class="small">Cargando...</span>
        </div>
      </div>
    </small>
    
      <div id="iframe" style="display: none;"> 
        <form>
          @csrf

          <!-- LISTADO PRINCIPAL -->
            <div class="card" id="card_listado">
              <div class="card-header pb-0">
                <div class="row mb-2" id="div_titulo_sol">
                  <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <div class="col text-start h5 "> <i class="fa-solid fa-users pe-2"></i> Ternas activas</div>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <table class="table mt-4 table-striped">
                  <thead>          
                    <tr>
                      <td class="align-middle text-center" style="color: #4B6EAD;"> Reclutador </td>
                      <td class="align-middle text-center" style="color: #4B6EAD;"> F. Solicitud </td>
                      <td class="align-middle text-center" style="color: #4B6EAD;"> Posición </td>
                      <td class="align-middle text-center" style="color: #4B6EAD;"> Vacantes </td>
                      <td class="align-middle text-center" style="color: #4B6EAD;"> Terna # </td>
                      <td class="align-middle text-center" style="color: #4B6EAD;"> Candidatos </td>
                      <td> </td>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($data_ternas as $ternas)
                      @php
                        $i=0;
                        $list_fechas = "<ol>";
                        foreach ($fecha_ternas as $fechas) {
                          $i++;
                          if ($fechas->oferta_id == $ternas->oferta_id) {
                            $list_fechas .= "<li>" . $fechas->fecha_Terna . "</li>";
                          }
                        }
                        $list_fechas .= "</ol>";
                      @endphp
                    <tr>
                        <td class="text-secondary align-middle text-center">
                          <span id="lb_reclutador_{{ $ternas->id }}">{{ $ternas->nombre_completo }}</span>
                          <input type="hidden" id="email_reclutador_{{ $ternas->id }}" value="{{ $ternas->email_reclutador }}">
                        </td>
                        <td class="text-secondary align-middle text-center">
                          <span id="lb_f_solicitud_{{ $ternas->id }}">{{ $ternas->fsolicitud }}</span>
                        </td>
                        <td>
                          <span class="text-primary fw-semibold pb-0 d-block">
                            <span id="lb_nom_posicion_{{ $ternas->id }}">{{ $ternas->nom_puesto }}</span>
                          </span>
                          <span class="text-secondary pt-0 d-block" style="font-size: 10px; margin-top: -3px;">
                            <span id="lb_nom_unidad_{{ $ternas->id }}">{{ $ternas->unidad }}</span>
                          </span>
                        </td>
                        <td class="text-secondary align-middle text-center">
                          <span class="badge bg-secondary fs-6" id="lb_cant_solicitada_{{ $ternas->id }}">{{ $ternas->solicitados }}</span>
                        </td>
                        <td class="text-secondary align-middle text-center">
                          <span class="badge bg-primary fs-6" data-bs-custom-class="custom-tooltip" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-html="true" title="{!! $list_fechas !!}">
                            {{ $ternas->total_envios }}
                          </span>
                        </td>
                        <td class="text-secondary align-middle text-center">
                          <span class="badge bg-success fs-6">{{ $ternas->total_candidatos }}</span>
                        </td>
                        <td class="align-middle text-center">
                          <div class="dropdown py-0">
                            <button class="btn btn-outline-primary btn-sm" type="button"
                                    id="dropdownMenu2"
                                    onclick="verDetalle({{ $ternas->id }})"
                                    aria-expanded="false">
                              <i class="fa-solid fa-users-line fa-lg me-2"></i>Ver candidatos
                            </button>
                          </div>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>

                </table>
              </div>
            </div> 
          
          <!-- VER DETALLE -->
            <div class="card d-none" id="card_detalle">      
              <div class="card-header pb-0">
                <div class="row mb-2" id="div_titulo_sol">
                  <div class="col-8 d-grid gap-2 d-md-flex justify-content-md-end">
                    <div class="col text-start h5 ">
                      <input type="hidden" id="id_terna" value="">  
                      <input type="hidden" id="id_ofl" value="">        
                      <span class="text-primary fw-semibold pb-0" id="lb_nom_posicion"></span>,
                      <span class="text-secondary" style="font-size: 12px;" id="lb_nom_unidad"> </span>
                      <span class="text-secondary ms-2 ps-4 pt-1 d-block" style="font-size: 12px;" id="lb_f_solicitud"> </span>
                      <span class="text-secondary ms-2 ps-4 pt-1 d-block" style="font-size: 12px;" id="lb_cant_solicitada"> </span>
                      <span class="text-secondary ms-2 ps-4 pt-1 d-block" style="font-size: 12px;" id="lb_reclutador"> </span>
                      <input type="hidden" id="email_reclutador" value="">        
                    </div>
                  </div>
                  <div class="col-4 my-0 py-0 align-items-center justify-content-end" id="bto_ternas">
                    <div class="col text-end"><button type="button" class="btn btn-sm btn-secondary py-1 mb-2" onclick="verListadoTernas()"><i class="fa-solid fa-arrow-left fa-lg pe-2"></i>Volver</button></div>
                    <div class="col text-end d-none" id="bto_ver_Candidatos"><button type="button" class="btn btn-sm btn-primary" onclick="verCandidatos()"><i class="fa-solid fa-users-line fa-lg pe-2"></i>Ver Candidatos</button></div>
                    <div class="col text-end" id="bto_ver_Analisis"><button type="button" class="btn btn-sm btn-primary" onclick="verAnalisis()"><i class="fa-solid fa-magnifying-glass-chart fa-xl pe-2"></i> Ver análisis de pruebas psicométricas </button></div>
                  </div> 
                </div>
              </div>

              <div class="card-body card_body_Candidatos mt-2" id="div_candidatos">          
              </div>

              <div class="card-body card_body_AnalisisPruebas mt-2 d-none" id="div_analisis_pruebas">
                <div class="pagetitle pt-4 pb-0 mb-0">
                  <div class="row pb-0 mb-0">
                    <div class="col-8 my-0 py-0">
                      <h5 class="text-primary">Análisis comparativo de perfiles</h5>
                    </div>
                  </div>
                </div>
                <!-- APL -->
                  <div class="row pb-0 mb-0">
                    <div class="col-8 my-0 py-0">
                      <h5 class="text-secondary">Resultados de Prueba APL </h5>
                      <nav>
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item"style="font-weight: normal;">Modelo de competencia - <span class="fw-bold" id="jerarquia_analisis_apl"></span></li>
                        </ol>
                      </nav>
                    </div>
                  </div>
                  <hr class="mt-0">
                  <div class="row align-items-center justify-content-center">   
                    <div class="col-12 small">
                      <table id="tabla-participantes" class="table table-sm table-hover">
                        <tbody id="body-rows"></tbody>
                      </table>
                    </div>
                  </div>
                <!-- RAZI -->
                  <div class="row pt-4 pb-0 mb-0">
                    <div class="col-8 my-0 py-0">
                      <h5 class="text-secondary">Resultados de Prueba RAZI </h5>
                      <nav>
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item"style="font-weight: normal;">Capacidad de razonamiento Verbal, Numérico y Abstracto</li>
                        </ol>
                      </nav>
                    </div>
                  </div>
                  <hr class="mt-0">
                  <div class="row align-items-center justify-content-center">   
                    <div class="col-10 small">
                      <table id="tabla-participantes-razi" class="table table-sm table-hover">
                        <tbody id="body-rows-razi"></tbody>
                      </table>
                    </div>
                  </div>
                <!-- DISC -->
                  <div class="row pt-4 pb-0 mb-0">
                    <div class="col-8 my-0 py-0">
                      <h5 class="text-secondary">Resultados de Prueba <span style="color: blue;">D</span><span style="color: red;">I</span><span style="color: orange;">S</span><span style="color: green;">C</span> </h5>
                      <nav>
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item"style="font-weight: normal;">Estilos de comportamientos: Dominante - Influyente - Estable - Concienzudo </li>
                        </ol>
                      </nav>
                    </div>
                  </div>
                  <hr class="mt-0">
                  <div class="row align-items-center justify-content-center">   
                    <div class="col-8 small">
                      <table id="tabla-participantes-disc" class="table table-sm table-hover">
                        <tbody id="body-rows-disc"></tbody>
                      </table>
                    </div>
                  </div>  
                <!-- VERITAS -->
                  <div class="row pt-4 pb-0 mb-0">
                    <div class="col-8 my-0 py-0">
                      <h5 class="text-secondary">Resultados de Prueba Veritas </h5>
                        <nav>
                          <ol class="breadcrumb">
                            <li class="breadcrumb-item"style="font-weight: normal;">Prueba de intergridad</li>
                          </ol>
                        </nav>
                      </div>
                    </div>
                    <hr class="mt-0">
                    <div class="row align-items-center justify-content-center">   
                      <div class="col-8 small">
                        <table id="tabla-participantes-veritas" class="table table-sm table-hover">
                          <tbody id="body-rows-veritas"></tbody>
                        </table>
                      </div>
                    </div> 
              </div>
            </div>

        </form>
      </div>
      <!-- MODAL PARA VER DOSC PDS -->
        <div class="modal fade" id="modalViewer" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalViewerLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header bg-light text-secondary py-1">
                  <h5 class="modal-title" id="modalViewerLabel">Documento PDF</h5>
                  <button type="button" class="btn-close btn-close-secondary" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              <div class="modal-body p-2">
                  <iframe id="pdfViewer" src="" width="100%" height="500" frameborder="0"></iframe>
              </div>
            </div>
          </div>
        </div>

      <!-- MODAL PARA SELECCIONAR FECHA DE ENTREVISTA -->
        <div class="modal fade" id="ModalFEntrevista" data-bs-backdrop="static" tabindex="-1" aria-labelledby="ModalFEntrevistaLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content shadow-sm border-0 rounded-3">
              
              <div class="modal-header bg-light text-primary py-1">
                <h5 class="modal-title" id="ModalFEntrevistaLabel">
                  <i class="fa-solid fa-calendar-days me-2"></i>Programar entrevista
                </h5>
                <button type="button" class="btn-close btn-close-secondary" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>

              <div class="modal-body py-3 px-4">
                <input id="id_curri" type="hidden" value="">
                <input id="id_part" type="hidden" value="">

                <div class="mb-3">
                  <label for="lugar_entrevista" class="form-label fw-semibold"><i class="fa-solid fa-map-pin text-danger"></i> Lugar de la entrevista</label>
                  <input type="text" class="form-control form-control-sm" id="lugar_entrevista" placeholder="Ej: Oficina principal, Sala de juntas, Virtual, etc.">
                </div>

                <div class="mb-3">
                  <label for="obs_entrevista" class="form-label fw-semibold"><i class="fa-solid fa-pen-to-square text-primary"></i> Observaciones</label>
                  <textarea class="form-control form-control-sm" id="obs_entrevista" rows="3" placeholder="Ej: Sugerir tres opciones de horario, requerimientos, etc."></textarea>
                  <small class="text-secondary">Por favor, proponga <b>al menos tres horarios</b> disponibles para agendar la entrevista con el candidato.</small>
                </div>

                <div class="alert alert-info p-2 small">
                  <i class="fa-solid fa-envelope me-1"></i>
                  El reclutador recibirá una notificación por correo electrónico con los detalles para coordinar la entrevista.
                </div>
              </div>

              <div class="modal-footer bg-light py-1 px-4">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                  <i class="fa-solid fa-arrow-left me-1"></i>Cancelar
                </button>
                <button id="btn_enviar" type="button" class="btn btn-primary btn-sm" onclick="programaEntrevista()">
                  <i class="fas fa-save me-1"></i>Guardar
                </button>
                <button id="btn_enviando" type="button" class="btn btn-secondary btn-sm d-none" disabled>
                  <i class="fa-solid fa-rotate fa-spin-pulse me-1"></i>Enviando
                </button>
              </div>
            </div>
          </div>
        </div>
        
      <!-- MODAL PARA DECLINAR -->
        <div class="modal fade" id="ModalDeclinar" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header bg-light text-secondary py-1">
                <h5 class="modal-title text-danger" id="exampleModalLabel"><i class="fa-solid fa-user-xmark pe-1"></i> Declinar candidato</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <input id="id_curri_declinar" type="hidden" value="">
                <input id="id_part_declinar" type="hidden" value="">
                <div class="row py-3">
                  <div class="col">
                    Por favor indicar la razón por la cual está declinando al candidato<br>
                    <textarea class="form-control form-control-sm" id="obs_declinar" name="obs_declinar" rows="3"></textarea>                    
                  </div>                  
                  <small class="text-secondary">Nota: El reclutador recibirá una notificación por correo electrónico con los detalles de esta declinación.</small>
                </div>
              </div>
              <div class="modal-footer py-1 bg-light">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pe-2"></i> Cancelar</button>
                <button id="btn_enviar_declinar" type="button" class="btn btn-danger btn-sm" onclick="saveDeclinar()"style="display: block"><i class="fa-solid fa-user-xmark fa-lg pe-2"></i>Declinar</button>
                <button id="btn_enviando_declinar" type="button" class="btn btn-secondary btn-sm d-none"><i class="fa-solid fa-rotate fa-spin-pulse"></i> Enviando</button>
              </div>
            </div>
          </div>
        </div>
@endsection

<script type='text/javascript'>
  function saveDeclinar() {
      let id_part = $('#id_part_declinar').val();
      let id_curri = $('#id_curri_declinar').val();
      let id_terna = $('#id_terna').val();
      let id_ofl = $('#id_ofl').val();
      let obs_declinar = $('#obs_declinar').val().trim();
      let email_reclutador = $('#email_reclutador').val().trim();
      let nom_posicion = $('#lb_nom_posicion').html();
      let nom_unidad = $('#lb_nom_unidad').html();
      let candidato = $('#nom_' + id_curri).html();
      let actualiza_entrevista = $('#actualiza_entrevista').val();

      if (obs_declinar === '') {
          Swal.fire({
              icon: 'warning',
              title: 'Advertencia',
              text: 'Por favor, indique la razón por la cual está declinando al candidato.',
              confirmButtonText: 'Aceptar'
          });
          return;
      }

      let parametros = {
          id_part,
          id_curri,
          id_terna,
          id_ofl,
          email_reclutador,
          candidato,
          nom_posicion,
          nom_unidad,
          obs_declinar,
          _token: $('input[name="_token"]').val()
      };

      $.ajax({
          url: "{{ route('ternas.declinarCandidato') }}",
          type: 'POST',
          data: parametros,
          dataType: 'json',
          beforeSend: function() {
              $('#btn_enviar_declinar').addClass('d-none');
              $('#btn_enviando_declinar').removeClass('d-none');
          },
          success: function(response) {
              $('#ModalDeclinar').modal('hide');
              $('#btn_enviar_declinar').removeClass('d-none');
              $('#btn_enviando_declinar').addClass('d-none');

              if (response.success) {
                  bien(response.message || 'El candidato ha sido declinado exitosamente.');
                  verDetalle($('#id_terna').val());
              } else {
                  mal(response.message || 'Ocurrió un error al procesar la solicitud.');
                  $('#actualiza_entrevista').val(actualiza_entrevista);
              }
          },
          error: function(xhr) {
              $('#ModalDeclinar').modal('hide');
              $('#btn_enviar_declinar').removeClass('d-none');
              $('#btn_enviando_declinar').addClass('d-none');

              let mensaje = (xhr.responseJSON && xhr.responseJSON.message)
                  ? xhr.responseJSON.message
                  : 'Ocurrió un error al procesar la solicitud.';
              mal(mensaje);
              $('#actualiza_entrevista').val(actualiza_entrevista);
          }
      });
  }

  // ------ DECLINAR ENTREVISTA
    function modaldeclinar(id_part, id_curri) {
      $('#id_part_declinar').val(id_part);
      $('#id_curri_declinar').val(id_curri);
      $('#obs_declinar').val('');

      let actualiza_entrevista = $('#actualiza_entrevista_' + id_curri).val();
      let nombreCandidato = $('#nom_' + id_curri).text();

      const mostrarModal = () => {
          $('#ModalDeclinar').find('.modal-title').text('Declinar candidato ' + nombreCandidato);
          $('#ModalDeclinar').modal('show');
      };

      const cargarMotivoDeclinacion = () => {
          $.ajax({
              url: "{{ route('ternas.verDeclinacion') }}",
              type: 'POST',
              data: {
                  id_curri: id_curri,
                  id_part: id_part,
                  id_ofl: $('#id_ofl').val(),
                  _token: $('input[name="_token"]').val()
              },
              dataType: 'json',
              success: function(response) {
                  if (response.success) {
                      $('#obs_declinar').val(response.declinacion.motivo_descarte || '');
                  }
                  mostrarModal();
              },
              error: function() {
                  mostrarModal(); // Mostrar modal incluso si la consulta falla
              }
          });
      };

      // Validación si ya tiene entrevista
      if (actualiza_entrevista && parseInt(actualiza_entrevista) === 1) {
          Swal.fire({
              icon: "question",
              html: "El candidato ya tiene una entrevista programada, ¿Desea eliminar la entrevista y declinar al candidato?",
              showCancelButton: true,
              cancelButtonText: '<i class="fas fa-arrow-left"></i> Cancelar',
              confirmButtonText: '<i class="fa-solid fa-calendar-days"></i> Sí, eliminar entrevista',
              confirmButtonColor: "#3085d6",
          }).then((result) => {
              if (result.isConfirmed) {
                  cargarMotivoDeclinacion(); // ✅ Mostrar modal solo después de cargar
              }
          });
      } else {
          cargarMotivoDeclinacion();
      }
  }

  // ------ PROGRAMAR ENTREVISTA
    function programaEntrevista() {
      let id_curri = $('#id_curri').val();
      let id_terna = $('#id_terna').val();
      let id_ofl = $('#id_ofl').val();
      let id_part = $('#id_part').val();
      let f_entrevista = $('#f_entrevista').val();
      let h_entrevista = $('#h_entrevista').val();
      let lugar_entrevista = $('#lugar_entrevista').val().trim();
      let obs_entrevista = $('#obs_entrevista').val().trim();
      let email_reclutador = $('#email_reclutador').val().trim();
      let nom_posicion = $('#lb_nom_posicion').html();
      let nom_unidad = $('#lb_nom_unidad').html();
      let candidato = $('#nom_' + id_curri).html();

      if (f_entrevista === '' || h_entrevista === '' || lugar_entrevista === '') {
        Swal.fire({
          icon: 'warning',
          title: 'Advertencia',
          text: 'Por favor, complete todos los campos requeridos.',
          confirmButtonText: 'Aceptar'
        });
        return;
      }

      let parametros = {
        id_curri,
        id_ofl,
        id_terna,
        id_part,        
        lugar_entrevista,
        observaciones: obs_entrevista,
        email_reclutador,
        candidato,
        nom_posicion,
        nom_unidad,
        _token: $('input[name="_token"]').val()
      };

      $.ajax({
        url: "{{ route('ternas.programarEntrevista') }}",
        type: 'POST',
        data: parametros,
        dataType: 'json',
        beforeSend: function () {
          $('#btn_enviar').addClass('d-none');
          $('#btn_enviando').removeClass('d-none');
        },
        success: function (response) {
          $('#btn_enviar').removeClass('d-none');
          $('#btn_enviando').addClass('d-none');
          $('#ModalFEntrevista').modal('hide');

          if (response.success) {
            bien(response.message || 'La entrevista ha sido programada exitosamente.');
            verDetalle($('#id_terna').val());
          } else {
            mal(response.message || 'Ocurrió un error al procesar la solicitud.');
          }
        },
        error: function (xhr) {
          $('#btn_enviar').removeClass('d-none');
          $('#btn_enviando').addClass('d-none');
          $('#ModalFEntrevista').modal('hide');

          let mensaje = (xhr.responseJSON && xhr.responseJSON.message)
            ? xhr.responseJSON.message
            : 'Ocurrió un error al procesar la solicitud.';
          mal(mensaje);
        }
      });
    }

  // ------  VER DETALLE
    function verDetalle(id_terna)
    {
      let parametros = {
        id_terna: id_terna,
        _token: $('input[name="_token"]').val()
      };

      $.ajax({
        url: "{{ route('ternas.verDetalle') }}",
        type: 'POST',
        data: parametros,
        dataType: 'json',
        beforeSend: function() { 
          $('#lb_nom_posicion').html('<i class="text-primary fa-solid fa-user-tie pe-2"></i>'+$('#lb_nom_posicion_'+id_terna).html());
          $('#lb_nom_unidad').html($('#lb_nom_unidad_'+id_terna).html());
          $('#lb_f_solicitud').html('<i class="fa-solid fa-calendar-days me-2"></i>Fecha de Solicitud: '+$('#lb_f_solicitud_'+id_terna).html());
          $('#lb_cant_solicitada').html('<i class="fa-solid fa-magnifying-glass me-2"></i>Cantidad Solicitada: '+$('#lb_cant_solicitada_'+id_terna).html());
          $('#lb_reclutador').html('<i class="fa-solid fa-user-tie me-2"></i>Reclutador: '+$('#lb_reclutador_'+id_terna).html());
          $('#email_reclutador').val($('#email_reclutador_'+id_terna).val());
          $('#card_listado').addClass('d-none'); 
          $('#div_cargando').removeClass('d-none'); 
        },
        success: function(response) {
          if(response.success)
          { const candidatos = response.participantes;            
            const card = $('#card_detalle');
            const cardbody = card.find('.card_body_Candidatos');
            $('#jerarquia_analisis_apl').html(response.jerarquia);
            cardbody.empty();
            if(candidatos)
            { $('#id_terna').val(response.terna.id);
              $('#id_ofl').val(response.id_ofl);
              
                let oculta_contenido="";
                
              candidatos.forEach(part => {
                let actualiza_entrevista = 0;
                programacion = ""; declinacion= ""; bot_entrevista = ""; bot_declina = "";msn_botn = "Solicitar entrevista";
                if(part.fecha_entrevista==null&&part.id_entrevista!=null)
                { msn_botn = "Entrevista solicitada"; }
                if(part.fecha_entrevista!=null && part.id_entrevista!=null)
                { msn_botn = "Entrevista programada"; }
                bot_declina='<button type="button" class="btn btn-sm btn-danger py-0" onclick="modaldeclinar('+part.id_part+','+part.id_curri+')"><i class="fa-solid fa-user-xmark me-1"></i>Declinado</button>';

                if(part.id_entrevista!=null && part.id_entrevista!=undefined)
                { if(part.entrevista_realizada==0)
                  { actualiza_entrevista= 1;
                    bot_entrevista="<button type='button' class='btn btn-sm btn-success py-0' onclick='programarEntrevista("+part.id_part+","+part.id_curri+")'><i class='fa-solid fa-calendar-days me-1'></i>"+msn_botn+"</button>";
                    programacion=
                    '<div class="alert alert-primary small" role="alert">'+
                      '<span class="fw-semibold"><i class="fa-solid fa-calendar-days fa-lg me-2"></i> '+msn_botn+'</span><hr class="my-1">'+
                        'Lugar de la entrevista: <span class="fw-bold">'+part.lugar_entrevista+'</span>'+
                        '<div>Observaciones: <span class="fw-bold">'+part.observaciones+'</span></div>'+
                    '</div>';
                  }
                  if(part.entrevista_realizada==1)
                  { actualiza_entrevista= 1;
                    bot_entrevista="";
                    bot_declina='';
                    programacion=
                      '<div class="alert alert-success small" role="alert">'+
                      '<span class="fw-semibold"><i class="fa-solid fa-check-double fa-lg me-2"></i> Entrevista finalizada</span><hr class="my-1">'+
                      '<i class="fa-regular fa-calendar-check pe-1"></i>'+ part.fecha_real_formateada+'</div>';
                    
                    oculta_contenido=" d-none";
                  }
                }
                else{
                  bot_entrevista="<button type='button' class='btn btn-sm btn-outline-success py-0' onclick='programarEntrevista("+part.id_part+","+part.id_curri+")'><i class='fa-solid fa-calendar-days me-1'></i>Solicitar Entrevista</button>";
                }
                
                if(part.id_etapa=11)
                { if(part.motivo_descarte!=null && part.motivo_descarte!=undefined)
                  { 
                    actualiza_entrevista= 2;
                    declinacion=
                    '<div class="alert alert-danger small"  role="alert">'+
                      '<span class="fw-semibold"><i class="fa-solid fa-user-xmark fa-lg me-2"></i> Candidato declinado</span><hr class="my-1">'+
                      '<div>Motivo: <span class="fw-bold">'+part.motivo_descarte+'</span></div>'+
                    '</div>';
                    oculta_contenido=" d-none";
                  }
                  else{
                    bot_declina='<button type="button" class="btn btn-sm btn-outline-danger py-0" onclick="modaldeclinar('+part.id_part+','+part.id_curri+')"><i class="fa-solid fa-user-xmark me-1"></i>Declinar</button>';
                  }
                }

                if(part.id_etapa=12)
                { if(part.motivo_descarte!=null && part.motivo_descarte!=undefined)
                  { bot_declina='';
                    actualiza_entrevista= 0;
                    declinacion=
                    '<div class="alert alert-danger small"  role="alert">'+
                      '<span class="fw-semibold"><i class="fa-solid fa-user-xmark fa-lg me-2"></i> Candidato descartado del proceso</span><hr class="my-1">'+
                      '<div>Motivo: <span class="fw-bold">'+part.motivo_descarte+'</span></div>'+
                    '</div>';
                    bot_entrevista="";
                    programacion="";
                    oculta_contenido=" d-none";
                  }
                }
                cardbody.append(`                
                <div class="card mb-2 " style=" box-shadow: none;border: 1px solid #e2e2e2;">
                  <div class="row g-0">
                    <div class="col-3 py-2 d-flex flex-column justify-content-center align-items-center text-secondary text-center bg-light">                      
                      <div><img src="${part.foto_mostrar}" alt="Foto de ${part.prinombre} ${part.priapellido}" class="rounded-circle" style="background:#FFFFFF; width: 120px; height: 120px; object-fit: cover; border: 1px solid #aeafb0;"></div>
                      <div><input type="hidden" id="fto_${part.id_curri}" value="${part.foto_mostrar}">
                            <input id="actualiza_entrevista_${part.id_curri}" type="hidden" value="${actualiza_entrevista}">
                        <div class="fw-bold text-uppercase" style="color: #4B6EAD;font-size: 14px" id="nom_${part.id_curri}">${part.prinombre} ${part.priapellido}</div>
                        <div class="text-secondary fw-bold" style="font-size: 12px"><i class="fa-solid fa-globe pe-1"></i>${part.nacionalidad}</div>
                        <div class="text-secondary" style="font-size: 12px"><i class="fa-solid fa-envelope pe-1"></i><span class="text-primary">${part.email}</span></div>
                        <div class="text-secondary" style="font-size: 12px"><i class="fa-solid fa-phone-flip pe-1"></i>${part.tel}</div>
                      </div>
                    </div>
                    
                    <div class="col-9 px-1">
                      <div class="card-body">
                        <div class="h5 my-3 fw-semibold text-uppercase" style="color: #4B6EAD; font-size: 16px">${part.prinombre} ${part.priapellido}</div>
                        <small>
                          <small>
                            <div class="row justify-content-center align-items-center ${oculta_contenido}">                                   
                              <div class="col-auto small text-center justify-content-center align-items-center px-1">
                                <span id="name_file_cv_terna_${part.id_curri}" class="d-none">CV - ${part.prinombre} ${part.priapellido}</span> 
                                <input type="hidden" id="v_file_cv_terna_${part.id_curri}" value="${part.cv_doc}">
                                ${part.cv_doc ? `<button type="button" class="btn btn-sm btn-outline-primary py-0" onclick="viewfile('cv_terna_${part.id_curri}')"><i class="fa-solid fa-magnifying-glass me-1"></i>Ver CV</button>`: ''}                              
                              </div>                       
                              <div class="col-auto small text-center justify-content-center align-items-center px-1">
                                <span id="name_file_apl_terna_${part.id_curri}" class="d-none">APL - ${part.prinombre} ${part.priapellido}</span>
                                <span id="ico_doc_apl_terna_${part.id_curri}"></span>                                     
                              </div>                       
                              <div class="col-auto small text-center justify-content-center align-items-center px-1"> 
                                <span id="name_file_razi_terna_${part.id_curri}" class="d-none">RAZI - ${part.prinombre} ${part.priapellido}</span>
                                <span id="ico_doc_razi_terna_${part.id_curri}"></span>  
                              </div>                       
                              <div class="col-auto small text-center justify-content-center align-items-center px-1"> 
                                <span id="name_file_disc_terna_${part.id_curri}" class="d-none">DISC - ${part.prinombre} ${part.priapellido}</span>
                                <span id="ico_doc_disc_terna_${part.id_curri}"></span>
                              </div>                       
                              <div class="col-auto small text-center justify-content-center align-items-center px-1"> 
                                ${bot_entrevista}
                              </div>                       
                              <div class="col-auto small text-center justify-content-center align-items-center px-1"> 
                                ${bot_declina}
                              </div> 
                            </div>  
                          </small>  
                        </small>  
                        <hr>
                        <div class="card-text ${oculta_contenido}"><small class="text-secondary"><span class="fw-semibold text-primary">CONCEPTO DE LA DIRECCIÓN DE GENTE Y ORGANIZACIÓN:</span><br>${part.obs}</small></div> ${programacion}${declinacion}</div>
                    </div>
                  </div>
                </div>`)
              });
            }
            
            const ult_pruebas_apl = response.ult_pruebas_apl;
            const competencias = response.competencias;
            const resultados = response.resultados_competencias_apl;
            const ult_pruebas_razi = response.ult_pruebas_razi;
            const ult_pruebas_disc = response.ult_pruebas_disc;
            const ult_pruebas_veritas = response.ult_pruebas_veritas;
            
            // APL
              let headerRow = '<tr><td></td><td></td>'; // Primera celda vacía
              ult_pruebas_apl.forEach(part => {
                let fullName = $('#nom_' + part.id_curri).html();
                let fto=$('#fto_' + part.id_curri).val();
                candidatos.forEach(part_candidatos => {
                  if(part_candidatos.id_curri==part.id_curri)
                  {  
                
                headerRow += `
                  <td class="text-center align-middle col_part_APL_${part.id_curri}">
                    <div class="align-items-center">
                      <div class="me-2">
                        <img src="${fto}" alt="Foto de ${fullName}" class="rounded-circle" style="background:#FFFFFF; width: 50px; height: 50px; object-fit: cover; border: 1px solid #aeafb0;">
                      </div>
                      <div>
                        <div class="fw-bold text-uppercase" style="color: #4B6EAD;font-size: 11px">${fullName}<br><span id="declinado_APL_${part.id_curri}" class="badge rounded-pill bg-danger d-none">Declinado</span></div>
                      </div>
                    </div>
                  </td>`;
                  if(part.informe!=null)
                  { $(`#ico_doc_apl_terna_${part.id_curri}`).html(`
                    <button type="button" class="btn btn-sm btn-outline-primary px-1 py-0" onclick="viewfile('apl_terna_${part.id_curri}')"><i class="fa-solid fa-magnifying-glass me-1"></i>Ver APL</button>
                    <input type="hidden" id="v_file_apl_terna_${part.id_curri}" value="${part.informe}">`)}
                  else
                  { $(`#ico_doc_apl_terna_${part.id_curri}`).html(`<i class="fa-solid fa-triangle-exclamation fa-lg text-warning" title="No hay documento adjunto"></i>`) };
                  }});
              });
              headerRow += '</tr>';
              headerRow += '<tr><td style="background-color:#668BD0;"></td><td class="text-center align-middle text-white" style="background-color:#668BD0;">% DE AJUSTE AL PUESTO</td>'; // Primera celda vacía
              ult_pruebas_apl.forEach(part => {
                candidatos.forEach(part_candidatos => {
                  if(part_candidatos.id_curri==part.id_curri)
                  {  
                    let cumplimiento = part.cumplimiento;
                    headerRow += `<td class="col_part_APL_${part.id_curri} text-center align-middle text-white fw-bold" style="background-color:#668BD0;font-size: 14px;">${cumplimiento}%</td>`;
                  }
                });
              });
              headerRow += '</tr>';      
              headerRow += '<tr><td style="background-color:#D4DCEB;"></td><td class="text-center align-middle" style="background-color:#D4DCEB;">TOTAL DE PUNTOS</td>'; // Primera celda vacía
              ult_pruebas_apl.forEach(part => {
                candidatos.forEach(part_candidatos => {
                  if(part_candidatos.id_curri==part.id_curri)
                  { 
                    let sum_puntaje = part.sum_puntaje;
                    headerRow += `<td class="col_part_APL_${part.id_curri} text-center align-middle" style="background-color:#D4DCEB;font-size: 14px;">${sum_puntaje}</td>`;
                  }
                });
              });
              headerRow += '</tr>';               
              let r_span_1=0; let r_span_2=0; let r_span_3=0; 
              competencias.forEach(comp => {
                if(comp.tipo==1){   r_span_1++;}
                if(comp.tipo==2){   r_span_2++;}
                if(comp.tipo==3){   r_span_3++;}
              });
              let bodyHtml = '';grupo=0;
              competencias.forEach(comp => {
                celda=""; 
                if(comp.tipo==1&&grupo==0){    celda='<tr><td class="text-start align-middle ps-4" rowspan="'+r_span_1+'">Críticas</td>';grupo=1;}
                if(comp.tipo==2&&grupo==1){    celda='<tr><td class="text-start align-middle ps-4" rowspan="'+r_span_2+'">Muy Importantes</td>';grupo=2;}
                if(comp.tipo==3&&grupo==2){    celda='<tr><td class="text-start align-middle ps-4" rowspan="'+r_span_3+'">Importantes</td>';grupo=3;}
                let row = `${celda} <td class="text-start align-middle ps-4">${comp.competencia}</td>`; // Nombre de la competencia
                ult_pruebas_apl.forEach(part => {
                  
                candidatos.forEach(part_candidatos => {
                  if(part_candidatos.id_curri==part.id_curri)
                  { 
                    const resultado = resultados.find(r =>
                    r.id_curri === part.id_curri &&
                    r.competencia_id === comp.id_competencia
                  );
                  row += `<td class="col_part_APL_${part.id_curri} text-center align-middle">${resultado ? resultado.puntaje : '-'}</td>`;
                                    }
                });
                });
                row += '</tr>';
                bodyHtml += row;
              });
              $('#body-rows').html(headerRow+bodyHtml);
            

            // RAZI
              let headerRowRazi = '<tr><td></td>'; // Primera celda vacía
              ult_pruebas_razi.forEach(part => {
                let fullNameRazi = $('#nom_' + part.id_curri).html();
                let ftoRazi=$('#fto_' + part.id_curri).val();
                headerRowRazi += `
                  <td class="col_part_RAZI_${part.id_curri} text-center align-middle">
                    <div class="align-items-center">
                      <div class="me-2">
                        <img src="${ftoRazi}" alt="Foto de ${fullNameRazi}" class="rounded-circle" style="background:#FFFFFF; width: 50px; height: 50px; object-fit: cover; border: 1px solid #aeafb0;">
                      </div>
                      <div>
                        <div class="fw-bold text-uppercase" style="color: #4B6EAD;font-size: 11px">${fullNameRazi}<br><span id="declinado_RAZI_${part.id_curri}" class="badge rounded-pill bg-danger d-none">Declinado</span></div>
                      </div>
                    </div>
                  </td>`;
                  if(part.informe!=null)
                  { $(`#ico_doc_razi_terna_${part.id_curri}`).html(`
                    <button type="button" class="btn btn-sm btn-outline-primary px-1 py-0" onclick="viewfile('razi_terna_${part.id_curri}')">
                      <i class="fa-solid fa-magnifying-glass me-1"></i>Ver RAZI
                    </button>
                    <input type="hidden" id="v_file_razi_terna_${part.id_curri}" value="${part.informe}">`)}
                  else{
                    $(`#ico_doc_razi_terna_${part.id_curri}`).html(``)
                  };
              });
              headerRowRazi += '</tr>';
              let bodyHtmlRazi = '';
              let row_razi = `<tr><td class="text-center align-middle text-white ps-4" style="background-color:#668BD0;">Aptitud General</td>`;
              ult_pruebas_razi.forEach(part => {
                row_razi += `<td class="col_part_RAZI_${part.id_curri} text-center align-middle text-white fw-bold" style="background-color:#668BD0;font-size: 14px;">${part ? part.general : '-'}</td>`;
              });
              row_razi += '</tr>';
              bodyHtmlRazi += row_razi;
              row_razi = `<tr><td class="text-start align-middle ps-4">Aptitud Verbal</td>`;
              ult_pruebas_razi.forEach(part => {
                row_razi += `<td class="col_part_RAZI_${part.id_curri} text-center align-middle">${part ? part.puntaje_v : '-'}</td>`;
              });
              row_razi += '</tr>';
              bodyHtmlRazi += row_razi;
              row_razi = `<tr><td class="text-start align-middle ps-4">Aptitud Numérica</td>`;
              ult_pruebas_razi.forEach(part => {
                row_razi += `<td class="col_part_RAZI_${part.id_curri} text-center align-middle">${part ? part.puntaje_n : '-'}</td>`;
              });
              row_razi += '</tr>';
              bodyHtmlRazi += row_razi;
              row_razi = `<tr><td class="text-start align-middle ps-4">Aptitud Abstracta</td>`;
              ult_pruebas_razi.forEach(part => {
                row_razi += `<td class="col_part_RAZI_${part.id_curri} text-center align-middle">${part ? part.puntaje_a : '-'}</td>`;
              });
              row_razi += '</tr>';
              bodyHtmlRazi += row_razi;                     
              $('#body-rows-razi').html(headerRowRazi+bodyHtmlRazi);

            // DISC
              let headerRowDisc = '<tr><td></td>'; // Primera celda vacía
              ult_pruebas_disc.forEach(part => {
                let fullNameDisc = $('#nom_' + part.id_curri).html();
                let ftoDisc=$('#fto_' + part.id_curri).val();
                headerRowDisc += `
                  <td class="col_part_DISC_${part.id_curri} text-center align-middle">
                    <div class="align-items-center">
                      <div class="me-2">
                        <img src="${ftoDisc}" alt="Foto de ${fullNameDisc}" class="rounded-circle" style="background:#FFFFFF; width: 50px; height: 50px; object-fit: cover; border: 1px solid #aeafb0;">
                      </div>
                      <div>
                        <div class="fw-bold text-uppercase" style="color: #4B6EAD;font-size: 11px">${fullNameDisc}<br><span id="declinado_DISC_${part.id_curri}" class="badge rounded-pill bg-danger d-none">Declinado</span></div>
                      </div>
                    </div>
                  </td>`;
                  if(part.informe!=null)
                  { $(`#ico_doc_disc_terna_${part.id_curri}`).html(`
                    <button type="button" class="btn btn-sm btn-outline-primary px-1 py-0" onclick="viewfile('disc_terna_${part.id_curri}')">
                      <i class="fa-solid fa-magnifying-glass me-1"></i>Ver DISC
                    </button>
                    <input type="hidden" id="v_file_disc_terna_${part.id_curri}" value="${part.informe}">`)}
                  else{
                    $(`#ico_doc_disc_terna_${part.id_curri}`).html(``)
                  };
              });
              headerRowDisc += '</tr>';
              let bodyHtmlDisc = '';                      
              let row_disc = `<tr><td class="text-center fw-semibold" style="color: blue;font-size: 18px;">D</td>`;
              ult_pruebas_disc.forEach(part => {
                row_disc += `<td class="col_part_DISC_${part.id_curri} text-center align-middle">${part ? part.puntaje_d : '-'}%</td>`;
              });
              row_disc += '</tr>';
              bodyHtmlDisc += row_disc;
              row_disc = `<tr><td class="text-center fw-semibold" style="color: red;font-size: 18px;">I</td>`;
              ult_pruebas_disc.forEach(part => {
                row_disc += `<td class="col_part_DISC_${part.id_curri} text-center align-middle">${part ? part.puntaje_i : '-'}%</td>`;
              });
              row_disc += '</tr>';
              bodyHtmlDisc += row_disc;
              row_disc = `<tr><td class="text-center fw-semibold" style="color: orange;font-size: 18px;">S</td>`;
              ult_pruebas_disc.forEach(part => {
                row_disc += `<td class="col_part_DISC_${part.id_curri} text-center align-middle">${part ? part.puntaje_s : '-'}%</td>`;
              });
              row_disc += '</tr>';
              bodyHtmlDisc += row_disc;
              row_disc = `<tr><td class="text-center fw-semibold" style="color: green;font-size: 18px;">C</td>`;
              ult_pruebas_disc.forEach(part => {
                row_disc += `<td class="col_part_DISC_${part.id_curri} text-center align-middle">${part ? part.puntaje_c : '-'}%</td>`;
              });
              row_disc += '</tr>';
              bodyHtmlDisc += row_disc;
              $('#body-rows-disc').html(headerRowDisc+bodyHtmlDisc);
            
            // VERITAS
              let headerRowVeritas = '<tr>'; // Primera celda vacía
              ult_pruebas_veritas.forEach(part => {
              let fullNameVeritas = $('#nom_' + part.id_curri).html();
              let ftoVeritas=$('#fto_' + part.id_curri).val();
              headerRowVeritas += `
                <td class="col_part_VERITAS_${part.id_curri} text-center align-middle">
                  <div class="align-items-center">
                    <div class="me-2">
                      <img src="${ftoVeritas}" alt="Foto de ${fullNameVeritas}" class="rounded-circle" style="background:#FFFFFF; width: 50px; height: 50px; object-fit: cover; border: 1px solid #aeafb0;">
                    </div>
                    <div>
                      <div class="fw-bold text-uppercase" style="color: #4B6EAD;font-size: 11px">${fullNameVeritas}<br><span id="declinado_VERITAS_${part.id_curri}" class="badge rounded-pill bg-danger d-none">Declinado</span></div>
                    </div>
                  </div>
                </td>`;                               
              });
              headerRowVeritas += '</tr>';
              let bodyHtmlVeritas = '';                        
              let row_veritas = `<tr>`;                            
              ult_pruebas_veritas.forEach(part => {
                res="";
                if(part.puntaje==1){ res="1-Elegible";}
                if(part.puntaje==2){ res="2-Elegible/Revisar";}
                if(part.puntaje==3){ res="3-No Elegible";}
                row_veritas += `<td class="col_part_VERITAS_${part.id_curri} text-center align-middle">${part ? res : '-'}</td>`;
              });
              row_veritas += '</tr>';
              bodyHtmlVeritas += row_veritas;
              $('#body-rows-veritas').html(headerRowVeritas+bodyHtmlVeritas);
                
            $('#card_detalle').removeClass('d-none');           
            $('#div_candidatos').removeClass('d-none');           
            $('#div_cargando').addClass('d-none');

          }
        },
        error: function(xhr) {
          console.error('Error en la petición AJAX', xhr);   
          $('#card_listado').addClass('d-none'); 
          $('#card_detalle').removeClass('d-none');     
          $('#div_cargando').addClass('d-none');
        }
      });
    }

  // ------ MUESTRA MODAL PARA PROGRAMAR ENTREVISTA
    function programarEntrevista(id_part, id_curri) {
      $('#id_curri').val(id_curri);
      $('#id_part').val(id_part);
      $('#f_entrevista').val('');
      $('#h_entrevista').val('');
      $('#lugar_entrevista').val('');
      $('#obs_entrevista').val('');

      let actualiza_entrevista = $('#actualiza_entrevista_' + id_curri).val();
      let nombreCandidato = $('#nom_' + id_curri).text();
      let mensaje = '';
      let botonTexto = "<i class='fa-solid fa-calendar-days me-1'></i> Programar entrevista";

      if (actualiza_entrevista === '1') {
        mensaje = "El candidato ya tiene una entrevista programada, ¿Desea modificar la programación?";
        botonTexto = "<i class='fa-solid fa-calendar-days me-1'></i> Sí, modificar";
      } else if (actualiza_entrevista === '2') {
        mensaje = "El candidato ha sido declinado, ¿Desea programar una entrevista y eliminar la declinación?";
        botonTexto = "<i class='fa-solid fa-calendar-days me-1'></i> Sí, programar entrevista";
      }

      const mostrarModal = () => {
        $('#ModalFEntrevista').find('.modal-title').text((actualiza_entrevista === '0' ? 'Programar' : 'Actualizar') + ' entrevista para ' + nombreCandidato);
        $('#ModalFEntrevista').modal('show');
      };

      const cargarEntrevistaExistente = () => {
        $.ajax({
          url: "{{ route('ternas.verEntrevista') }}",
          type: 'POST',
          data: {
            id_curri: id_curri,
            id_part: id_part,
            id_ofl: $('#id_ofl').val(),
            _token: $('input[name="_token"]').val()
          },
          dataType: 'json',
          success: function (response) {
            if (response.success && response.entrevista) {
              
              $('#lugar_entrevista').val(response.entrevista.lugar_entrevista);
              $('#obs_entrevista').val(response.entrevista.observaciones);
            }
            mostrarModal();
          },
          error: function () {
            mostrarModal(); // Mostrar modal aunque haya error en consulta
          }
        });
      };

      if (actualiza_entrevista > '0') {
        Swal.fire({
          icon: "question",
          html: mensaje,
          showCancelButton: true,
          cancelButtonText: '<i class="fas fa-arrow-left"></i> Cancelar',
          confirmButtonText: botonTexto,
          confirmButtonColor: "#3085d6",
        }).then((result) => {
          if (result.isConfirmed) {
            cargarEntrevistaExistente();
          }
        });
      } else {
        mostrarModal();
      }
    }

  //------- VER ANALISIS DE PRUEBAS PSICOMETRICAS  
    function verAnalisis()
    {
      $('#div_analisis_pruebas').removeClass('d-none');
      $('#div_candidatos').addClass('d-none');
      $('#bto_ver_Candidatos').removeClass('d-none');
      $('#bto_ver_Analisis').addClass('d-none');
    }

    function verCandidatos()
    {
      $('#div_analisis_pruebas').addClass('d-none');
      $('#div_candidatos').removeClass('d-none');
      $('#bto_ver_Candidatos').addClass('d-none');
      $('#bto_ver_Analisis').removeClass('d-none');
    }

    function verListadoTernas()
    {
      $('#card_listado').removeClass('d-none'); 
      $('#card_detalle').addClass('d-none'); 
      $('#div_analisis_pruebas').addClass('d-none');
      $('#div_candidatos').addClass('d-none');
      $('#bto_ver_Candidatos').addClass('d-none');
      $('#bto_ver_Analisis').removeClass('d-none');
    }

  // ------- VER ARCHIVO EN MODAL
    function viewfile(doc) 
    {
          let filePath = $('#v_file_' + doc).val();
          if (!filePath) {
              alert('No hay archivo para visualizar.');
              return;
          }

          // Asignar la ruta al iframe
          $('#pdfViewer').attr('src', filePath);

          // Cambiar el título del modal según el documento
          let docName = $('#name_file_' + doc).text();
          $('#modalViewerLabel').text(docName);

          // Mostrar el modal
          let modal = new bootstrap.Modal(document.getElementById('modalViewer'));
          modal.show();
    }
   
  //----- MENSAJE GENERICO SI ALGO SALE MAL, SE ENVIA EL MENSAJE EN EL PARAMETRO
    function mal(msn) {
        Swal.fire({
            position: 'center',
            icon: 'warning',
            text: msn,
        })
    }

  //----- MENSAJE GENERICO SI ALGO SALE BIEN, SE ENVIA EL MENSAJE EN EL PARAMETRO
    function bien(msn) {
        Swal.fire({
            position: 'center',
            icon: 'success',
            text: msn,
            showConfirmButton: false,
            timer: 2000
        })
    }
</script>