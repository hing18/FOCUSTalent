<!DOCTYPE html>
@extends('layouts.plantilla')

@section('title','Entrevistas')

<script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
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



@section('content')
    <div class="pagetitle pb-0 mb-0">
      <div class="row pb-0 mb-0">
        <div class="col-8 my-0 py-0">
          <h1 class="text-secondary">Entrevistas</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"style="font-weight: normal;">Programación de entrevistas de candidatos</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
    <small>
      <div id="preload" class="align-items-center justify-content-center text-center">
        <div class="d-flex justify-content-center align-items-center" style="height: 50vh;">
          <div class="spinner-border text-primary me-2" role="status"></div>
          <span class="small">Cargando...</span>
        </div>
      </div>
    </small>
    <div id="iframe" style="display: none;"> 
        <form>
            @csrf                     
                <div class="d-flex justify-content-center align-items-center d-none" style="height: 50vh;" id="div_spinner">
                    <div class="spinner-border text-primary me-2" role="status"></div>
                    <span class="small">Cargando...</span>
                </div>
                <!-- LISTADO PRINCIPAL -->
                <div class="card" id="card_listado">
                    <div class="card-header pb-0">
                        <div class="row mb-2" id="div_titulo_sol">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <div class="col text-start h5 "> <i class="fa-regular fa-calendar-days text-primary pe-2"></i> Entrevistas programadas</div>
                        </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm mt-4 table-striped">
                        <thead>          
                            <tr>
                                <td class="align-middle text-center" style="color: #4B6EAD;"> Reclutador </td>
                                <td class="align-middle text-center" style="color: #4B6EAD;"> F. Solicitud </td>
                                <td class="align-middle text-center" style="color: #4B6EAD;"> Posición </td>
                                <td class="align-middle text-center" style="color: #4B6EAD;"> Vacantes </td>
                                <td class="align-middle text-center" style="color: #4B6EAD;"> Entrevistas </td>
                                <td> </td>
                            </tr>
                        </thead>
                        <tbody class="listadoPrincipal">
                            @foreach ($ofertas as $oferta)
                            <tr>
                                <td class="text-secondary align-middle text-center small">
                                    <span id="lb_reclutador_{{ $oferta->id_ofl }}">{{ $oferta->nombre_reclutador }}</span><br>
                                    <input type="hidden" id="email_reclutador_{{ $oferta->id_ofl }}" value="{{ $oferta->email_reclutador }}">
                                </td>
                                <td class="text-secondary align-middle text-center small">
                                    <span id="lb_f_solicitud_{{ $oferta->id_ofl }}">{{ $oferta->f_solicitud }}</span></td>
                                <td>
                                    <span class="text-primary fw-semibold pb-0 d-block">
                                        <span id="lb_nom_posicion_{{ $oferta->id_ofl }}">{{ $oferta->nom_puesto }}</span>
                                    </span>
                                    <span class="text-secondary pt-0 d-block" style="font-size: 10px; margin-top: -3px;">
                                        <span id="lb_nom_unidad_{{ $oferta->id_ofl }}">{{ $oferta->unidad }}</span>
                                    </span>
                                </td>
                                <td class="text-secondary align-middle text-center"><span id="lb_cant_solicitada_{{ $oferta->id_ofl }}">{{ $oferta->vacantes }}</span></td>
                                <td class="text-secondary align-middle text-center">{{ $oferta->num_candidatos }}</td>
                                <td class="align-middle text-center">
                                    <div class="dropdown py-0">                            
                                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-users-gear fa-lg pe-2"></i>Acciones  </button>
                                    <ul class="dropdown-menu p-0">
                                        <li><button class="dropdown-item text-secondary" type="button" onclick="verEntrevistas({{ $oferta->id_ofl }})" ><i class="fa-solid fa-people-arrows fa-lg me-2"></i>Ver entrevistas</button></li>
                                        
                                    </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>

                <!-- LISTADO CANDIDATOS -->
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
                            <div id="bto_volver" class="col text-end"><button type="button" class="btn btn-sm btn-secondary py-1 mb-2" onclick="verListadoPrincipal()"><i class="fa-solid fa-arrow-left fa-lg pe-2"></i>Volver</button></div>
                            <div id="bto_cancelar" class="col text-end d-none"><button type="button" class="btn btn-sm btn-secondary py-1 mb-2" onclick="verEntrevistas($('#id_ofl').val())"><i class="fa-solid fa-arrow-left fa-lg pe-2"></i>Cancelar</button></div>
                        </div> 
                        </div>
                    </div>

                    <div class="card-body d-none" id="div_spinner_candidato">
                        <div class="d-flex justify-content-center align-items-center" style="height: 50vh;">
                            <div class="spinner-border text-primary me-2" role="status"></div>
                            <span class="small">Cargando...</span>
                        </div>
                    </div>

                    <div class="card-body d-none" id="entrevistas">
                        <small>
                            <table class="table mt-2 table-sm table-hover" style="width:100%" id="tableEntrevistas">                                    
                                <thead>
                                    <tr class="">
                                        <th class="text-center bg-light text-secondary">CANDIDATO</th>
                                        <th class="text-start ps-4 bg-light text-secondary">PROGRAMACIÓN</th>
                                        <th class="text-center bg-light text-secondary">VALORACIÓN</th>
                                        <th class="bg-light"></th>
                                    </tr>
                                </thead>
                                <tbody class="tbody_entrevistas">
                                    
                                </tbody>
                            </table>      
                        </small>
                    </div>

                    <div class="card-body d-none card_body_Candidatos mt-2" id="card_entrevista">
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
@endsection

<script>

  // ----- MOSTRAR LISTADO DE ENTREVISTAS
    function verEntrevistas(id_ofl) {
        $('#bto_cancelar').addClass('d-none');
        $('#bto_volver').removeClass('d-none');


        $('#id_ofl').val(id_ofl);
        let parametros = {
            id_ofl,
            _token: $('input[name="_token"]').val()
        };
        
        $.ajax({
            url: "{{ route('entrevistas.show') }}",
            data: parametros,
            type: 'POST',
            dataType: 'json',
                beforeSend: function() { 
                $('#lb_nom_posicion').html('<i class="text-primary fa-solid fa-user-tie pe-2"></i>'+$('#lb_nom_posicion_'+id_ofl).html());
                $('#lb_nom_unidad').html($('#lb_nom_unidad_'+id_ofl).html());
                $('#lb_f_solicitud').html('<i class="fa-solid fa-calendar-days me-2"></i>Fecha de Solicitud: '+$('#lb_f_solicitud_'+id_ofl).html());
                $('#lb_cant_solicitada').html('<i class="fa-solid fa-magnifying-glass me-2"></i>Cantidad Solicitada: '+$('#lb_cant_solicitada_'+id_ofl).html());
                $('#lb_reclutador').html('<i class="fa-solid fa-user-tie me-2"></i>Reclutador: '+$('#lb_reclutador_'+id_ofl).html());
                $('#email_reclutador').val($('#email_reclutador_'+id_ofl).val());
                
                $('#card_listado').addClass('d-none'); // LISTADO PRINCIPAL
                $("#card_detalle").addClass('d-none'); // CARD DE CANDIDATOS
                $("#entrevistas").addClass('d-none'); // TABLA DE CANDIDATOS
                $('#card_entrevista').addClass('d-none'); // CANDIDATO

                $('#div_spinner').removeClass('d-none'); },
            success: function(response) {
                const tbody = $('#entrevistas').find('.tbody_entrevistas');
                tbody.empty();

                const hoy = dayjs().format('YYYY-MM-DD');

                response.forEach(entrevista => {
                    const data = entrevista.curri;
                    const fecha = entrevista.fecha_corta;
                    const hora = entrevista.hora_formateada || '';
                    const lugar = entrevista.lugar_entrevista || '';
                    const puesto = (entrevista.ofl?.puesto?.descpue) ?? '';
                    const idPuesto = (entrevista.ofl?.puesto?.id) ?? '';
                    let fecha_hoy = '<i class="fa-regular fa-calendar-days pe-1"></i> '+entrevista.fecha_formateada;
                    let claseFecha = 'text-success';
                    if (fecha === hoy) {
                        claseFecha = 'text-primary';
                        fecha_hoy = `<span class="badge rounded-pill text-primary" style="background-color: #cfe2ff; font-size: 12px"><i class="fa-regular fa-calendar pe-1"></i> Hoy ${entrevista.fecha_formateada}</span>`;
                    } else if (fecha < hoy) {
                        claseFecha = 'text-danger';                        
                        fecha_hoy = '<i class="fa-regular fa-calendar-xmark pe-1"></i> '+entrevista.fecha_formateada;
                    }

                    const nombre = `${data.prinombre} ${data.priapellido}`;
                    const iniciales = `${data.prinombre.charAt(0)}${data.priapellido.charAt(0)}`.toUpperCase();
                    const colores_text = ['#0d6efd', '#6610f2', '#6f42c1', '#d63384', '#dc3545','#fd7e14','#ffc107','#198754','#20c997','#0dcaf0'];
                    const colores_bg = [
                        '#cfe2ff', /* azul claro*/ '#e0cffc', /* morado claro*/ '#e2d9f3', /* lavanda*/ '#f7d6e6', /* rosa claro*/ '#f8d7da', /* rojo claro*/ '#ffe5d0', /* naranja claro*/ '#fff3cd', /* amarillo claro*/
                        '#d1e7dd', /* verde menta claro*/ '#cff4fc', /* cyan claro*/ '#d4edda'  /* verde claro*/];
                    let i = Math.floor(Math.random() * colores_text.length)
                    const color_tx = colores_text[i]; const color_bg = colores_bg[i];
                    let fotoHtml = `<img src="${data.foto}" alt="Foto de ${nombre}" class="rounded-circle" style="background:#FFFFFF; width: 60px; height: 60px; object-fit: cover; border: 1px solid #aeafb0;">`;
                    if (!data.foto) {
                        fotoHtml = `
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="
                            width: 60px; height: 60px; background-color: ${color_bg};  border-radius: 50%;  display: flex;  align-items: center;  justify-content: center;  color: ${color_tx};  font-family: 'Segoe UI', 'Roboto', sans-serif;
                            font-size: 22px;  text-transform: uppercase;  border: 1px solid ${color_tx}">
                                ${iniciales}
                            </div>`;
                    }

                    var programacion = '';

                    if (entrevista.entrevista_realizada == 0) {
                        programacion = '<span class="rounded-pill ' + claseFecha + '" style="font-size: 12px">' + fecha_hoy + '</span><br>' +
                                    '<span class="ps-2" style="font-size: 12px"><i class="fa-regular fa-clock text-primary pe-1"></i>' + hora + '</span><br>' +
                                    '<span class="ps-2" style="font-size: 12px"><i class="fa-solid fa-map-pin text-danger pe-1"></i>' + lugar + '</span>';
                    }

                    if (entrevista.entrevista_realizada == 1) {
                        programacion = '<span class="badge rounded-pill text-success" style="background-color: #d1e7dd; font-size: 12px"><i class="fa-solid fa-check-double pe-1"></i> Entrevista finalizada </span><br>';

                        if (entrevista.fecha_real_formateada) {
                            programacion += '<span class="ps-2" style="font-size: 12px"><i class="fa-regular fa-calendar-days pe-1"></i>' + entrevista.fecha_real_formateada + '</span>';
                        }
                    }

                    opt_candidato='';
                    if(entrevista.notifica_contratar===1){opt_candidato='<span class="badge  rounded-pill  text-secondary" style="background-color: #e9ecef; font-size: 13px"><i class="fa-solid fa-user-clock fa-lg pe-1"></i>  En Espera </span>';}
                    if(entrevista.notifica_contratar===2){opt_candidato='<span class="badge  rounded-pill text-danger" style="background-color: #f8d7da; font-size: 13px"><i class="fa-solid fa-user-xmark fa-lg pe-1"></i>  Declinado </span>';}
                    if(entrevista.notifica_contratar===3){opt_candidato='<span class="badge  rounded-pill text-success" style="background-color: #d1e7dd; font-size: 13px"><i class="fa-solid fa-user-check fa-lg pe-1"></i>  Contratar </span>';}
                    tbody.append(`
                        <tr class="oflinfo" onclick="ver_candidato(${entrevista.id})">
                            <td class="align-middle">   
                                <input type="hidden" id="color_tx_${entrevista.id}" value="${color_tx}">
                                <input type="hidden" id="color_bg_${entrevista.id}" value="${color_bg}">
                                <div class="d-flex align-items-center">
                                    <div class="me-2">
                                        ${fotoHtml}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-uppercase" style="color: #4B6EAD;font-size: 13px">
                                            ${data.prinombre} ${data.priapellido}
                                        </div>
                                        <div class="text-secondary fw-bold" style="font-size: 12px">
                                            <i class="fa-solid fa-globe pe-1"></i>${data.nacionalidad?.nacionalidad || ''}
                                        </div>
                                        <div class="text-secondary" style="font-size: 12px">
                                            <i class="fa-solid fa-envelope pe-1"></i><span class="text-primary">${data.email}</span>
                                        </div>
                                        <div class="text-secondary" style="font-size: 12px">
                                            <i class="fa-solid fa-phone-flip pe-1"></i>${data.tel}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="align-middle text-secondary ps-4 ">
                                ${programacion}
                            </td>
                            <td class="align-middle text-center text-primary"style="font-size: 18px">
                                ${entrevista.valoracion?entrevista.valoracion+'%':'<i class="fa-regular fa-circle-question text-secondary fa-xl"></i>'}
                            </td>
                            <td class="align-middle text-center text-primary"style="font-size: 14px">
                               ${opt_candidato}
                            </td>
                        </tr>
                    `);
                });

                $("#div_spinner").addClass('d-none');
                $("#card_detalle").removeClass('d-none');
                $("#entrevistas").removeClass('d-none'); // TABLA DE CANDIDATOS
            },
            error: function(xhr) {
                $("#div_spinner").addClass('d-none');
                mal("Ocurrió un error al cargar las entrevistas.");
                console.error(xhr.responseText);
            }
        });
    }
   
  // ----- CARGA LISTADO PRINCIPAL
    function verListadoPrincipal() {        
        $('#bto_cancelar').addClass('d-none');
        $('#bto_volver').removeClass('d-none');
        

        let parametros = {
            _token: $('input[name="_token"]').val()
        };

        $.ajax({
            url: "{{ route('entrevistas.list') }}",
            data: parametros,
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {
                
                $('#card_listado').addClass('d-none'); // LISTADO PRINCIPAL
                $("#card_detalle").addClass('d-none'); // CARD DE CANDIDATOS
                $("#entrevistas").addClass('d-none'); // TABLA DE CANDIDATOS
                $('#card_entrevista').addClass('d-none'); // CANDIDATO

                $('#div_spinner').removeClass('d-none');
            },
            success: function (response) {
                const tbody = $('#card_listado').find('.listadoPrincipal');
                tbody.empty();

                response.forEach(oferta => {
                    tbody.append(`
                        <tr>
                            <td class="text-secondary align-middle text-center small">
                                <span id="lb_reclutador_${oferta.id_ofl}">${oferta.nombre_reclutador}</span><br>
                                <input type="hidden" id="email_reclutador_${oferta.id_ofl}" value="${oferta.email_reclutador}">
                            </td>
                            <td class="text-secondary align-middle text-center small">
                                <span id="lb_f_solicitud_${oferta.id_ofl}">${oferta.f_solicitud}</span>
                            </td>
                            <td>
                                <span class="text-primary fw-semibold pb-0 d-block">
                                    <span id="lb_nom_posicion_${oferta.id_ofl}">${oferta.nom_puesto}</span>
                                </span>
                                <span class="text-secondary pt-0 d-block" style="font-size: 10px; margin-top: -3px;">
                                    <span id="lb_nom_unidad_${oferta.id_ofl}">${oferta.unidad}</span>
                                </span>
                            </td>
                            <td class="text-secondary align-middle text-center">
                                <span id="lb_cant_solicitada_${oferta.id_ofl}">${oferta.vacantes}</span>
                            </td>
                            <td class="text-secondary align-middle text-center">${oferta.num_candidatos}</td>
                            <td class="align-middle text-center">
                                <div class="dropdown py-0">                            
                                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-users-gear fa-lg pe-2"></i>Acciones
                                    </button>
                                    <ul class="dropdown-menu p-0">
                                        <li>
                                            <button class="dropdown-item text-secondary" type="button" onclick="verEntrevistas(${oferta.id_ofl})">
                                                <i class="fa-solid fa-people-arrows fa-lg me-2"></i>Ver entrevistas
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    `);
                });

                $('#div_spinner').addClass('d-none');
                $('#card_listado').removeClass('d-none');
            },
            error: function (xhr) {
                $('#div_spinner').addClass('d-none');
                $('#card_detalle').removeClass('d-none');
                mal("Ocurrió un error al cargar el listado.");
                console.error(xhr.responseText);
            }
        });
    }

  // ----- VER CANDIDATO
    function ver_candidato(id)
    {   $('#bto_cancelar').removeClass('d-none');
        $('#bto_volver').addClass('d-none');


        let parametros = {
            id: id,
            _token: $('input[name="_token"]').val() };
        $.ajax({
            url: "{{ route('entrevistas.verCandidato') }}",
            type: 'POST',
            data: parametros,
            dataType: 'json',
            beforeSend: function() { 
                                
                $("#entrevistas").addClass('d-none'); // TABLA DE CANDIDATOS
                $('#card_entrevista').addClass('d-none'); // CANDIDATO


                $('#div_spinner_candidato').removeClass('d-none'); 
                
            },
            success: function(response) {
                if(response.success && response.entrevista.curri) {
                    const entrevista = response.entrevista;
                    const curri = response.entrevista.curri;
                    const apl = response.apl;
                    const disc = response.disc;
                    const razi = response.razi;
                    const obs = response.obs;
                    

                    $('#div_spinner_candidato').addClass('d-none'); 
                    $('#card_entrevista').removeClass('d-none');
                    $('#card_listado').addClass('d-none');
                    const card = $('#card_detalle');
                    const cardbody = card.find('.card_body_Candidatos');
                    cardbody.empty();

                    const nombre = `${curri.prinombre} ${curri.priapellido}`;
                    const iniciales = `${curri.prinombre.charAt(0)}${curri.priapellido.charAt(0)}`.toUpperCase();

                    const color_tx = $('#color_tx_' + id).val(); // o .text()
                    const color_bg = $('#color_bg_' + id).val(); // o .text()

                    let fotoHtml = `<img src="${curri.foto}" alt="Foto de ${nombre}" class="rounded-circle" style="background:#FFFFFF; width: 120px; height: 120px; object-fit: cover; border: 1px solid #aeafb0;">`;

                    if (!curri.foto) {
                        fotoHtml = `
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="
                            width: 120px; height: 120px; background-color: ${color_bg}; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: ${color_tx}; font-family: 'Segoe UI', 'Roboto', sans-serif;
                            font-size: 50px; text-transform: uppercase; border: 1px solid ${color_tx};">
                                ${iniciales}
                            </div>`;
                    }
                    oculta_opt_contrato="";
                    if(entrevista.opcionesContratacion==0){ oculta_opt_contrato=" d-none";}

                    seccion_preguntas = "";

                    if (entrevista.preguntas && entrevista.preguntas.length > 0) {
                        seccion_preguntas = `
                            <hr class="mt-2">
                            <div class="card-text">
                                <span class="text-primary fw-semibold">Preguntas de entrevista:</span>`;

                        entrevista.preguntas.forEach(function(pregunta) {
                            seccion_preguntas += `
                                <div class="card-text mt-2 px-2">
                                    <span class="text-secondary">${pregunta.pregunta}</span>
                                    <textarea 
                                        class="form-control form-control-sm respuesta-pregunta" 
                                        rows="2"
                                        data-id_pregunta="${pregunta.id}"
                                        data-pregunta="${pregunta.pregunta}">${pregunta.respuesta ? pregunta.respuesta : ''}</textarea>
                                </div>`;
                        });

                        seccion_preguntas += `</div>`; // cerramos el div principal
                    }

                    cardbody.append(`         
                        <div class="card mb-2 " style=" box-shadow: none;border: 1px solid #e2e2e2;">
                            <div class="row g-0">
                                <div class="col-3 py-2 flex-column justify-content-center align-items-center text-secondary text-center bg-light">                      
                                    <div class="mt-4 d-flex justify-content-center align-items-center">
                                        ${fotoHtml}
                                    </div>
                                    <div>
                                        <input type="hidden" id="id_entrevista" value="${id}">
                                        <div class="fw-bold text-uppercase" style="color: #4B6EAD;font-size: 14px" id="nom_${curri.id}">${curri.prinombre} ${curri.priapellido}</div>
                                        <div class="text-secondary fw-bold" style="font-size: 12px"><i class="fa-solid fa-globe pe-1"></i>${curri.nacionalidad?.nacionalidad || ''}</div>
                                        <div class="text-secondary" style="font-size: 12px"><i class="fa-solid fa-envelope pe-1"></i><span class="text-primary">${curri.email}</span></div>
                                        <div class="text-secondary" style="font-size: 12px"><i class="fa-solid fa-phone-flip pe-1"></i>${curri.tel}</div>
                                    </div>
                                </div>
                                
                                <div class="col-9 px-3">
                                    <div class="card-body p-2">
                                        <span class="text-secondary">Entrevista con:</span><br>
                                        <span class="h5 my-3 fw-semibold text-uppercase" style="color: #4B6EAD; font-size: 16px">${curri.prinombre} ${curri.priapellido}</span>
                                        <small>
                                        <small>
                                        <div class="row justify-content-start align-items-start mt-2">                                 
                                            <div class="col-auto small text-center justify-content-center align-items-center">
                                                <span id="name_file_cv_${curri.id_curri}" class="d-none">CV - ${curri.prinombre} ${curri.priapellido}</span> 
                                                <input type="hidden" id="v_file_cv_${curri.id_curri}" value="${curri.cv_doc}">
                                                ${curri.cv_doc ? `<button type="button" class="btn btn-sm btn-outline-primary py-0" onclick="viewfile('cv_${curri.id_curri}')"><i class="fa-solid fa-magnifying-glass me-1"></i>Ver CV</button>`: ''}                              
                                            </div>                       
                                            <div class="col-auto small text-center justify-content-center align-items-center">
                                                <span id="name_file_apl_${curri.id_curri}" class="d-none">APL - ${curri.prinombre} ${curri.priapellido}</span>                            
                                                <input type="hidden" id="v_file_apl_${curri.id_curri}" value="${apl}">
                                                ${apl ? `<button type="button" class="btn btn-sm btn-outline-primary py-0" onclick="viewfile('apl_${curri.id_curri}')"><i class="fa-solid fa-magnifying-glass me-1"></i>Ver APL</button>`: ''}  
                                            </div>                       
                                            <div class="col-auto small text-center justify-content-center align-items-center"> 
                                                <span id="name_file_razi_${curri.id_curri}" class="d-none">RAZI - ${curri.prinombre} ${curri.priapellido}</span>
                                                <input type="hidden" id="v_file_razi_${curri.id_curri}" value="${razi}">
                                                ${razi ? `<button type="button" class="btn btn-sm btn-outline-primary py-0" onclick="viewfile('razi_${curri.id_curri}')"><i class="fa-solid fa-magnifying-glass me-1"></i>Ver RAZI</button>`: ''}  
                                            </div>                       
                                            <div class="col-auto small text-center justify-content-center align-items-center"> 
                                                <span id="name_file_disc_${curri.id_curri}" class="d-none">DISC - ${curri.prinombre} ${curri.priapellido}</span>
                                                <input type="hidden" id="v_file_disc_${curri.id_curri}" value="${disc}">
                                                ${disc ? `<button type="button" class="btn btn-sm btn-outline-primary py-0" onclick="viewfile('disc_${curri.id_curri}')"><i class="fa-solid fa-magnifying-glass me-1"></i>Ver DISC</button>`: ''}
                                            </div>                       
                                        </div>  
                                        </small>  
                                        </small>  
                                        <hr class="mt-2">
                                        <span class="fw-semibold text-primary mb-4 small">CONCEPTO DE LA DIRECCIÓN DE GENTE Y ORGANIZACIÓN:</span>
                                        <div class="card-text"><small class="text-secondary">${obs ? obs :''}</small></div>
                                        
                                        ${seccion_preguntas}

                                        <hr class="mt-2">
                                        <div class="card-text">
                                            <span class="text-primary fw-semibold"><span>Comentarios sobre el candidato:</span>
                                            <textarea id="comentarios" name="comentarios" class="form-control form-control-sm" rows="5">${entrevista.comentarios_entrevistador ? entrevista.comentarios_entrevistador : ''}</textarea>
                                        </div>
                                        

                                        <hr class="mt-2">
                                        <div class="row">
                                            <div class="col-6 pt-4 align-middle text-center">
                                                <div>
                                                    <span class="text-secondary">
                                                        <label for="valoracion" class="form-label">
                                                            Valorar al candidato <i class="fa-solid fa-arrow-right pe-2"></i> 
                                                            <strong class="text-primary" style="font-size: 25px"><span id="valoracion_num">${entrevista.valoracion ? entrevista.valoracion : '0'}</span>%</strong>
                                                        </label>
                                                        <input type="range" class="form-range text-primary" min="0" max="100" step="5" id="valoracion" name="valoracion" value="${entrevista.valoracion ? entrevista.valoracion : '0'}">
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-5 ms-4 ps-4 pt-4 align-middle ${oculta_opt_contrato}">
                                                <div class="form-check ms-4 ps-4 pt-2">
                                                    <input style="cursor:pointer" class="form-check-input" type="radio" name="opt_candidato" id="opt_candidato_1" value="1" ${entrevista.notifica_contratar == 1 ? 'checked' : ''}>
                                                    <label style="cursor:pointer" class="form-check-label" for="opt_candidato_1">
                                                        <i class="fa-solid fa-user-clock fa-lg pe-1 text-secondary"></i> En Espera
                                                    </label>
                                                </div>

                                                <div class="form-check ms-4 ps-4 pt-2">
                                                    <input style="cursor:pointer" class="form-check-input" type="radio" name="opt_candidato" id="opt_candidato_2" value="2" ${entrevista.notifica_contratar == 2 ? 'checked' : ''}>
                                                    <label style="cursor:pointer" class="form-check-label" for="opt_candidato_2">
                                                        <i class="fa-solid fa-user-xmark fa-lg pe-1 text-danger"></i> Declinado
                                                    </label>
                                                </div>

                                                <div class="form-check ms-4 ps-4 pt-2">
                                                    <input style="cursor:pointer" class="form-check-input" type="radio" name="opt_candidato" id="opt_candidato_3" value="3" ${entrevista.notifica_contratar == 3 ? 'checked' : ''}>
                                                    <label style="cursor:pointer" class="form-check-label" for="opt_candidato_3">
                                                        <i class="fa-solid fa-user-check fa-lg pe-1 text-success"></i> Contratar
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col text-end"><button type="button" class="btn btn-sm btn-primary py-1 mb-2" onclick="saveEntrevistaFun()"><i class="fa-solid fa-floppy-disk fa-lg pe-2"></i>Guardar</button></div>   
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`);

                    // script para actualizar el valor en tiempo real
                    const slider = document.getElementById('valoracion');
                    const output = document.getElementById('valoracion_num');
                    slider.addEventListener('input', () => {
                        output.textContent = slider.value;
                    });
                }
                $("#card_detalle").removeClass('d-none'); // CARD DE CANDIDATOS
                $("#entrevistas").addClass('d-none'); // TABLA DE CANDIDATOS
                $('#card_entrevista').removeClass('d-none'); // CANDIDATO
            }

        });
    }

    function saveEntrevistaFun() {   
        let comentarios = $('#comentarios').val();
        let valoracion = $('#valoracion').val();

        if (Number(valoracion) === 0) {
            mal('Por favor valorar al candidato.');
            return;
        }

        if (comentarios.trim().length <= 10) {
            mal('Por favor detallar más los comentarios sobre el candidato.');
            return;
        }

        let opt_candidato_val = $('input[name="opt_candidato"]:checked').val();

        let respuestas = [];
        let faltantes = false;

        $(".respuesta-pregunta").each(function() {
            let id_pregunta = $(this).data("id_pregunta");
            let pregunta = $(this).data("pregunta");
            let respuesta = $(this).val().trim();

            if (respuesta.length === 0) {
                faltantes = true;
                $(this).addClass("is-invalid"); // marca borde rojo
            } else {
                $(this).removeClass("is-invalid");
            }

            respuestas.push({
                id_pregunta: id_pregunta,
                pregunta: pregunta,
                respuesta: respuesta
            });
        });

        if (faltantes) {
            mal("Por favor responda todas las preguntas de la entrevista.");
            return;
        }


        let opt_candidato = (opt_candidato_val === "" || typeof opt_candidato_val === "undefined") ? null : parseInt(opt_candidato_val);
        let parametros = {
            id: $('#id_entrevista').val(),
            valoracion: valoracion,
            comentarios: comentarios,
            opt_candidato: opt_candidato,
            respuestas: respuestas,
            _token: $('input[name="_token"]').val()
        };

        $.ajax({
            url: "{{ route('entrevistas.saveEntrevistaFun') }}",
            type: 'POST',
            data: parametros,
            dataType: 'json',
            beforeSend: function() { 
                $("#entrevistas").addClass('d-none'); // TABLA DE CANDIDATOS
                $('#card_entrevista').addClass('d-none'); // CANDIDATO
                $('#div_spinner_candidato').removeClass('d-none'); 
            },
            success: function(response) {
                if(response.success) {
                    bien(response.message);
                    $("#entrevistas").removeClass('d-none');
                    $('#card_entrevista').addClass('d-none');
                    verEntrevistas($('#id_ofl').val());
                    $('#div_spinner_candidato').addClass('d-none'); 
                } else {
                    mal('Error al guardar la entrevista');
                    $('#div_spinner_candidato').addClass('d-none'); 
                    $('#card_entrevista').removeClass('d-none');
                }
            },
            error: function() {
                mal('Ocurrió un error en el servidor');
                $('#card_entrevista').removeClass('d-none');
                $('#div_spinner_candidato').addClass('d-none'); 
            }
        });
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

    // ------- VER ARCHIVO EN MODAL
    function viewfile(doc) 
    {
          let filePath = $('#v_file_' + doc).val();
          if (!filePath) {
              mal('No hay archivo para visualizar.');
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
   
</script>

