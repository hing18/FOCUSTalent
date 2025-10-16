<!DOCTYPE html>
@extends('layouts.plantilla')

@section('title','Generador de Contratos')

@section('content')
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

<style>
  /* Tarjeta del perfil */
  .profile-card {
    background: linear-gradient(145deg, #ffffff, #f3f6fa);
    border-radius: 12px;
    border: 1px solid #e3e7ee;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
  }
  .profile-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
  }

  /* Foto de perfil */
  #space_photo img {
    border-radius: 50%;
    border: 3px solid #f1f1f1;
    width: 120px;
    height: 120px;
    object-fit: cover;
  }

  /* Botones */
  .profile-card .btn {
    
    font-weight: 500;
  }

  /* Labels */
  .label {
    font-weight: 600;
    color: #6c757d;
  }

  /* Títulos */
  .card-title {
    font-size: 1.1rem;
    font-weight: 600;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: .5rem;
    margin-bottom: 1rem;
  }

  /* Tabs */
  .nav-tabs-bordered .nav-link.active {
    font-weight: 600;
    color: #0d6efd;
    border-color: #0d6efd;
  }
</style>


    <div class="pagetitle pb-0 mb-0">
        <div class="row pb-0 mb-0">
            <div class="col-8 my-0 py-0">
                <h1 class="text-secondary">Generador de Contratos</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"style="font-weight: normal;">Listado de Contratos de Trabajo por Generar</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
  <small>
    <div id="preload" class="align-items-center justify-content-center text-center"><div class="spinner-border spinner-border-sm text-primary" role="status"></div></div>
  </small>
    <!-- LISTADO PRINCIPAL OFERTAS LABORALES-->
    <div id="iframe" style="display: none;">
<div class="card">
  <div class="card-header pb-0">
    <h4><i class="fas fa-file-signature"></i> Generar de Contratos de Trabajo</h4>
  </div>
  <div class="card-body">
      @csrf
      <div id="div_tabla">
        <table class="table table-sm mt-4 table-hover">
          <thead>          
            <tr>
              <td class="align-middle text-center" style="color: #4B6EAD;"> Candidato </td>
              <td class="align-middle text-center" style="color: #4B6EAD;"> F. Ingreso </td>
              <td class="align-middle text-center" style="color: #4B6EAD;"> Posición </td>
              <td class="align-middle text-center" style="color: #4B6EAD;"> Reclutador </td>                  
            </tr>
          </thead>
          <tbody id="listadoPrincipal">
            @if ($data_parti && count($data_parti) > 0)
                @foreach ($data_parti as $data)
                    @php
                        $iniciales = strtoupper(substr($data->prinombre, 0, 1) . substr($data->priapellido, 0, 1));
                        if ($data->foto) {
                            $fotoHtml = "<img src='{$data->foto}' alt='Foto de {$data->prinombre} {$data->priapellido}' class='rounded-circle' style='background:#FFFFFF; width: 60px; height: 60px; object-fit: cover; border: 1px solid #aeafb0;'>";
                        } else {
                            $fotoHtml = "
                                <div class='rounded-circle d-flex align-items-center justify-content-center' style='width: 60px; height: 60px; background-color: {$data->color_bg}; border-radius: 50%; 
                                    color: {$data->color_text}; font-family: Segoe UI, Roboto, sans-serif; font-size: 22px; text-transform: uppercase; border: 1px solid {$data->color_text}'>
                                    {$iniciales}
                                </div>";
                        }
                    @endphp
                    <tr class="oflinfo" onclick="show({{ $data->id_carta }})">
                        <td class="align-middle">
                            <input type="hidden" id="color_tx_{{ $data->id_participante }}" value="{{ $data->color_text }}">
                            <input type="hidden" id="color_bg_{{ $data->id_participante }}" value="{{ $data->color_bg }}">
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    {!! $fotoHtml !!}
                                </div>
                                <div>
                                    <div class="fw-bold text-uppercase" style="color: #4B6EAD;font-size: 14px">
                                        {{ $data->prinombre }} {{ $data->priapellido }}
                                    </div>
                                    <div class="text-secondary" style="font-size: 11px">
                                        <i class="fa-solid fa-globe pe-1"></i>{{ $data->nacionalidad }}
                                    </div>
                                    <div class="text-secondary" style="font-size: 11px">
                                        <i class="fa-solid fa-id-card pe-1"></i>{{ $data->num_doc }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle text-center text-secondary">{{ $data->finicio_formateado }}</td>
                        <td class="align-middle text-center text-secondary">
                            <span class="text-primary fw-semibold pb-0 d-block">
                                {{ $data->descpue }}
                            </span>
                            <span class="text-secondary pt-0 d-block" style="font-size: 10px; margin-top: -3px;">
                                {{ $data->nameund }}
                            </span>
                        </td>
                        <td class="align-middle text-center text-secondary">
                            {{ $data->nombre_reclutador }} {{ $data->apellido_reclutador }}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="align-middle" colspan="4"> 
                        <div class="d-flex justify-content-center align-items-center text-secondary">
                            No hay contrataciones pendientes.
                        </div>
                    </td>
                </tr>
            @endif
          </tbody>

        </table>
      </div>

      <div id="div_detalle" class="py-3 d-none">
        <div class="row">
          <div class="col-4">
            <div class="d-flex flex-column align-items-center text-center mb-3">
              <div id="space_photo" class="mb-1"><div   class="align-middle text-center mt-4 pt-4" style="height: 120px"><div class="spinner-border text-primary" role="status"></div></div></div>
               <input id="id_curri" name="id_curri" type="hidden" value="">
               <input id="id_carta" name="id_carta" type="hidden" value="">
               <input id="id_part" name="id_part" type="hidden" value="">
               <input id="id_puesto" name="id_puesto" type="hidden" value="">
              <div class="fw-bold text-uppercase" style="color: #4B6EAD;font-size: 14px" id="lb_nombre"></div>

              <div id="div_nacionalidad" class="text-secondary" style="font-size: 11px">
                <i class="fa-solid fa-globe pe-1"></i><span id="lb_nacionalidad"></span>
              </div>

              <div id="div_num_doc" class="text-secondary" style="font-size: 11px">
                <i class="fa-solid fa-id-card pe-1"></i><span id="lb_num_doc"></span>
              </div>

              <div id="div_num_colab" class="text-secondary d-none" style="font-size: 16px">
                <span class=" text-primary" id="lb_puesto_colab"></span><br>
                <span class="fw-semibold" id="lb_num_colab"></span><br>
                <span class="badge rounded-pill text-success" style="background-color: #d4edda;font-size: 14px"><i class="fa-solid fa-user-check fa-lg pe-1"></i> Contratado</span>
              </div>

            </div>
          </div>
          <div class="col-8 text-end">
            <span id="bto_generacontrato"><a href="#" class="btn btn-sm btn-success" onclick="contratoPdf()"> <i class="fas fa-file-pdf"></i> Generar Contrato </a></span>
            <span id="bto_finalizacontrato"><a href="#" class="btn btn-sm btn-primary" onclick="finaliza_contratacion()">  <i class="fas fa-user-tie"></i> Finalizar Contratación</a></span>
            <a href="#" class="btn btn-sm btn-secondary" onclick="back()"> <i class="fas fa-arrow-left"></i> Volver </a>
          </div>
        </div>

        <div class="row">
          <!-- Detalles -->
          <div class="col">
            <div class="card p-3 profile-card">
              <ul class="nav nav-tabs nav-tabs-bordered mb-3" role="tablist">
                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-puesto">Detalle del Puesto</button>
                </li>
                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-documentacion">Documentación</button>
                </li>
              </ul>

              <div class="tab-content">
                <!-- Puesto -->
                <div class="tab-pane fade show active" id="tab-puesto">
                  <h5 class="card-title">Detalle del Puesto</h5> 
                    <div class="row mb-2 px-4">
                      <div class="col-lg-3 col-md-4 label">Compañía</div>
                      <div id="lb_cia" class="col-lg-9 col-md-8 text-uppercase"></div>
                    </div>
                    <div class="row mb-2 px-4">
                      <div class="col-lg-3 col-md-4 label">Centro de Costo</div>
                      <div id="lb_ceco" class="col-lg-9 col-md-8 mayusc"></div>
                    </div>
                    <div class="row mb-2 px-4">
                      <div class="col-lg-3 col-md-4 label">Und. Económica</div>
                      <div id="lb_ue" class="col-lg-9 col-md-8 mayusc"></div>
                    </div>
                    <div class="row mb-2 px-4">
                      <div class="col-lg-3 col-md-4 label">Posición</div>
                      <div id="lb_pos" class="col-sm-9 text-primary"></div>
                    </div>
                    <div class="row mb-2 px-4">
                      <div class="col-lg-3 col-md-4 label">Propósito</div>
                      <div id="lb_proposito" class="col-sm-9 small fst-italic"style="text-align: justify;"></div>
                    </div>

                    <div class="row mb-2 px-4">
                      <div class="col-lg-3 col-md-4 label">Dirigir Carta a:</div>
                      <div id="lb_carta_a" class="col-sm-9 small"style="text-align: justify;"></div>
                    </div>

                    <div class="row mb-2 px-4">
                      <div class="col-lg-3 col-md-4 label">Registro de Marcaciones:</div>
                      <div id="lb_marcaciones" class="col-sm-9 small"style="text-align: justify;"></div>
                    </div>

                  <h5 class="card-title">Detalle de Remuneración</h5>
                    <div class="row g-3 px-4 align-items-center mb-3">
                      <!-- Salario mensual -->
                      <div class="col-md-4">
                        <span class="label">Salario:</span></br>
                        <div class="text-secondary" id="lb_salario_mensual" name="lb_salario_mensual"></div>
                      </div>

                      <!-- Tipo de salario -->
                      <div class="col-md-4">
                        <span class="label">Tipo de Salario:</span></br>
                        <div class="text-secondary" id="lb_tiposalario" name="lb_tiposalario"></div>
                      </div>

                      <!-- Salario por hora -->
                      <div class="col-md-4" id="div_salario_hora">
                        <span class="label">Rata por hora:</span></br>
                        <div class="text-secondary" id="lb_salariohora" name="lb_salariohora"></div>
                      </div>
                    </div>
                                       
                    <div class="row g-3 px-4 align-items-center mb-3">
                      <!-- Salario mensual -->
                      <div class="col-md-4">
                        <span class="label">Tipo de Contrato:</span></br>
                        <div class="text-secondary" id="lb_tipoContrato" name="lb_tipoContrato"></div>
                      </div>

                      <!-- Tipo de salario -->
                      <div class="col-md-4">
                        <span class="label">Fecha de Ingreso:</span></br>
                        <div class="text-secondary" id="lb_fIngreso" name="lb_fIngreso"></div>
                      </div>

                      <!-- Salario por hora -->
                      <div class="col-md-4" id="div_salario_hora">
                        <span class="label">Fecha de Terminación:</span></br>
                        <div class="text-secondary" id="lb_fTerminacion" name="lb_fTerminacion"></div>
                      </div>
                    </div>

                    
                  <h5 class="card-title">Detalle del Candidato</h5>
                    <div class="row g-3 px-4 align-items-center mb-3">
                      <div class="col-md-4">
                        <span class="label">Nombre:</span></br>
                        <div class="text-secondary" id="lb_nombreContrato" name="lb_nombreContrato"></div>
                      </div>

                      <div class="col-md-4">
                        <span class="label">Cédula / Pasaporte:</span></br>
                        <div class="text-secondary" id="lb_cedula" name="lb_cedula"></div>
                      </div>

                      <div class="col-md-4">
                        <span class="label"># Seguro Social:</span></br>
                        <div class="text-secondary" id="lb_nss" name="lb_nss"></div>
                      </div>
                    </div>
                    
                    <div class="row g-3 px-4 align-items-center mb-3">
                      <div class="col-md-4" >
                        <span class="label">Fecha de Nacimiento:</span></br>
                        <div class="text-secondary" id="lb_fnacimiento" name="lb_fnacimiento"></div>
                      </div>

                      <div class="col-md-4">
                        <span class="label">Edad:</span></br>
                        <div class="text-secondary" id="lb_edad" name="lb_edad"></div>
                      </div>

                      <div class="col-md-4">
                        <span class="label">Estado Civil:</span></br>
                        <div class="text-secondary" id="lb_estadocivil" name="lb_estadocivil"></div>
                      </div>
                    </div>

                    <div class="row g-3 px-4 align-items-center mb-3">
                      <div class="col-md-4" >
                        <span class="label">Nacionalidad:</span></br>
                        <div class="text-secondary" id="lb_nacionalidadcontrato" name="lb_nacionalidadcontrato"></div>
                      </div>

                      <div class="col-md-4" >
                        <span class="label">Teléfono:</span></br>
                        <div class="text-secondary" id="lb_telefono" name="lb_telefono"></div>
                      </div>

                      <div class="col-md-4">
                        <span class="label">Email:</span></br>
                        <div class="text-secondary" id="lb_mail" name="lb_mail"></div>
                      </div>
                    </div>
                             
                    <div class="row g-3 px-4 align-items-center mb-3" id="div_permiso_trab">
                      <div class="col-md-4" >
                        <span class="label">Permiso de Trabajo:</span></br>
                        <div class="text-secondary" id="lb_permiso_trab" name="lb_permiso_trab"></div>
                      </div>

                      <div class="col-md-4" >
                        <span class="label">Fecha de Vencimiento:</span></br>
                        <div class="text-secondary" id="lb_vence_permiso_trab" name="lb_vence_permiso_trab"></div>
                      </div>
                    </div>

                    <div class="row g-3 px-4 align-items-center mb-3">
                      <div class="col-md-12">
                        <span class="label">Dirección:</span></br>
                        <div class="text-secondary" id="lb_direccion" name="lb_direccion"></div>
                      </div>
                    </div>

                    <div class="row g-3 px-4 align-items-center mb-3">
                      <div class="col-md-4">
                        <span class="label">Contacto en caso de urgencia:</span></br>
                        <div class="text-secondary" id="lb_contacto_urgencia" name="lb_contacto_urgencia"></div>
                      </div>
                      <div class="col-md-4">
                        <span class="label">Parentesco:</span></br>
                        <div class="text-secondary" id="lb_parent_urgencia" name="lb_parent_urgencia"></div>
                      </div>
                      <div class="col-md-4">
                        <span class="label">Teléfono:</span></br>
                        <div class="text-secondary" id="lb_tel_urgencia" name="lb_tel_urgencia"></div>
                      </div>
                    </div>
                    
                  <h5 class="card-title">Dependientes</h5>
                  <div class="row g-3 px-4 align-items-center mb-1">
                    <div class="col-md-4">
                      <span class="label">Nombre</span>
                    </div>
                    <div class="col-md-4">
                      <span class="label">Parentesco</span>
                    </div>
                    <div class="col-md-4">
                      <span class="label">F. Nacimiento</span>
                    </div>
                  </div>
                  <div class="row g-3 px-4 align-items-center mb-2" id="div_dependientes">
                    <div class="text-center text-primary">No tiene dependientes registrados.</div>
                  </div>
                </div>

                <!-- Documentación -->
                <div class="tab-pane fade" id="tab-documentacion">
                  <h5 class="card-title">Documentos Adjuntos</h5>  
                    <div class="row align-items-center justify-content-center">                
                      <div class="col-10 align-items-center justify-content-center">
                        <table class="table bg-transparent" >
                          <tbody id="tbody_docs" class="bg-transparent">                          
                          </tbody>
                        </table>
                      </div>
                    </div>
                </div>
                
              </div>
            </div>
          </div>
        </div>

      </div>

    <div id="idformulariocontrato"></div>
    <!-- Modal -->
    <div id="insertimageModal" class="modal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header py-0 bg-light">
            <h5 class="modal-title text-primary">Recortar y guardar</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row ">
              <div class="col-md profile-card pt-4 d-flex flex-column align-items-center">
                <div id="image_demo" style="width:350px; margin-top:10px"></div>
              </div>
            </div>
          </div>
          <div class="modal-footer py-0 bg-light">
            <button type="button" class="btn btn-sm btn-secondary corp_back" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cancelar</button>
            <button class="btn btn-sm btn-primary crop_image"><i class="fas fa-cut"></i> Recortar y guardar</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

    <!-- Modal ver docs pdf-->
    <div class="modal fade" id="modalViewer" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalViewer" aria-hidden="true">
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

    <!-- Modal CONTRATO DE TRABAJO-->
    <div class="modal fade" id="modalContrato" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalContrato" aria-hidden="true">
        <div id="clase_modal" class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-light text-primary py-1 fs-5">
                    <h5 class="modal-title"><i class="fa-solid fa-signature fa-lg pe-1"></i>Contrato de Trabajo</h5>
                    <button type="button" class="btn-close btn-close-secondary" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                
                <div class="modal-body p-2">

                    <!-- SUBIR ARCHIVO -->
                    <div class="mb-3" id="div_adjuntar_contrato">
                        Adjuntar contrato firmado por ambas partes:<br>   
                        <div id="input_name_docs_rp" class="input-group">                                            
                            <input class="form-control form-control-sm" id="contrato_file" name="contrato_pdf_file" type="file" accept="application/pdf">
                            <span class="input-group-text"><i class="fa-solid fa-file-pdf text-primary"></i></span>
                        </div>
                    </div>

                    <!-- VISTA PREVIA PDF -->
                    <div class="d-none" id="div_frame_contrato">
                      <div class=" row">                                     
                        <div class="row px-4">
                          <div class="col-lg-3 col-md-4 label">Dirigir Carta a:</div>
                          <div id="lb_carta_a_firmado" class="col-sm-9 small"style="text-align: justify;"></div>
                        </div>

                        <div class="row px-4">
                          <div class="col-lg-3 col-md-4 label">Registro de Marcaciones:</div>
                          <div id="lb_marcaciones_firmado" class="col-sm-9 small"style="text-align: justify;"></div>
                        </div>
                        
                      </div>
                        <iframe id="pdfViewer_contrato" src="" width="100%" height="350" frameborder="0"></iframe>
                    </div>   
                </div>

                <div class="modal-footer bg-light py-1">
                    <span id="alert_contrato" class="alert alert-danger py-1 d-none" role="alert"></span>
                    <span  id="alert_contrato_codigo" class="alert alert-primary py-1 d-none" role="alert">
                      <i class="fa-solid fa-circle-info"></i> El código del colaborador se asignará automáticamente al presionar el botón "Guardar".
                    </span>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cancelar</button>
                    <button type="button" id="bto_sube_contrato" class="btn btn-primary btn-sm d-none" onclick="upContrato()"><i class="fa-solid fa-upload pe-1"></i> Adjuntar</button>
                    <button type="button" id="bto_save_contrato" class="btn btn-success btn-sm d-none" onclick="saveContratofirmado()"><i class="fa-solid fa-floppy-disk pe-1"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>

@endsection
<script type='text/javascript'>

  function finaliza_contratacion()
  { $('#div_adjuntar_contrato').removeClass('d-none');
    $('#div_frame_contrato').addClass('d-none');
    $('#clase_modal').removeClass('modal-xl');  
    $('#bto_sube_contrato').removeClass('d-none'); 
    $('#bto_save_contrato').addClass('d-none');
    $('#contrato_file').val('');
    $('#alert_contrato').addClass('d-none');
    $('#alert_contrato_codigo').addClass('d-none');
    $('#modalContrato').modal('show');
  }

    // Subir archivo temporal
  function upContrato() {
        const fileInput = document.getElementById('contrato_file');
        const file = fileInput.files[0];

        if (!file || file.type !== 'application/pdf') {
            $('#alert_contrato').text('Debe seleccionar un archivo PDF válido.').removeClass('d-none');
            return;
        }

        $('#alert_contrato').addClass('d-none');
        const formData = new FormData();
        formData.append('pdf_file', file);
        formData.append('_token', $('input[name="_token"]').val()); 

        $.ajax({
            url: "{{ route('rl.tempUploadContrato') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#clase_modal').addClass('modal-xl');
                $('#div_adjuntar_contrato').addClass('d-none');
                $('#bto_sube_contrato').addClass('d-none');
                $('#div_frame_contrato').removeClass('d-none');
                $('#bto_save_contrato').removeClass('d-none');
                $('#pdfViewer_contrato').attr('src', response.url_temp);
                $('#pdfViewer_contrato').data('temp-file', response.filename); // Guardamos nombre temporal
                $('#alert_contrato_codigo').removeClass('d-none');




            },
            error: function(xhr) {
                $('#alert_contrato').text('Error al subir archivo temporal.').removeClass('d-none');
            }
        });
  }

  function saveContratofirmado() 
  { let id_curri = $('#id_curri').val();
    let id_carta = $('#id_carta').val();
    let id_part = $('#id_part').val();
    let id_puesto = $('#id_puesto').val();
    const tempFilename = $('#pdfViewer_contrato').data('temp-file'); 
        if (!tempFilename) {
            mal('Faltan datos para guardar el contrato.');
            return;
        }
        Swal.fire({
          icon: "info",
          html: "Esta acción completará el proceso de contratación y registrará al candidato como colaborador.<br> ¿Desea continuar?",
          showCancelButton: true,
          confirmButtonText: '<i class="fa-solid fa-user-check fa-lg"></i> Sí, Contratar',
          confirmButtonColor: "#0d6efd",
          cancelButtonText: '<i class="fas fa-arrow-left"></i> Cancelar',
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                  url: "{{ route('rl.saveContratofirmado') }}",
                  method: 'POST',
                  data: {
                      filename: tempFilename,
                      id_carta: id_carta,
                      id_curri: id_curri,
                      id_part: id_part,
                      id_puesto: id_puesto,
                      _token: $('input[name="_token"]').val()
                  },
                  success: function(resp) {
                    if(resp.success)
                    { bien(resp.message);
                      $('#div_nacionalidad').addClass('d-none');
                      $('#div_num_doc').addClass('d-none');
                      $('#div_num_colab').removeClass('d-none');
                      $('#lb_num_colab').html(resp.code);
                      $('#bto_generacontrato').addClass('d-none');
                      $('#bto_finalizacontrato').addClass('d-none');
                      $('#modalContrato').modal('hide');
                      
                      // Limpiar input de archivo
                      $('#contrato_file').val('');

                      // Limpiar iframe PDF
                      $('#pdfViewer_contrato').attr('src', '');

                      // Limpiar textos
                      $('#lb_carta_a_firmado').text('');
                      $('#lb_marcaciones_firmado').text('');

                      // Ocultar alertas
                      $('#alert_contrato').addClass('d-none').text('');
                      $('#alert_contrato_codigo').addClass('d-none');

                      // Mostrar/ocultar secciones según sea necesario
                      $('#div_adjuntar_contrato').removeClass('d-none');
                      $('#div_frame_contrato').addClass('d-none');

                      // Ocultar botones
                      $('#bto_sube_contrato').addClass('d-none');
                      $('#bto_save_contrato').addClass('d-none');

                    }
                    else{
                      mal(resp.message);
                    }
                  },
                  error: function(xhr) {
                      mal('Error al guardar el contrato firmado.');
                  }
              });
       }})
  }
  
  function contratoPdf() {       
    $('#div_adjuntar_contrato').addClass('d-none');
    $('#div_frame_contrato').removeClass('d-none');
    $('#bto_sube_contrato').addClass('d-none');
    $('#bto_save_contrato').addClass('d-none');
    const id_curri = $('#id_curri').val();
    const id_carta = $('#id_carta').val();
    var _token = $('input[name="_token"]').val();
    var parametros = {"id_carta":id_carta, "id_curri":id_curri, "_token": _token};
    $.ajax({
      data:  parametros, 
      url:   "{{ route('rl.contratoPdf') }}",
      type:  'POST', 
      dataType: "json",
      cache: false,          
      success: function (response) {
        if (response && response.success) {
          $('#clase_modal').addClass('modal-xl');  
          $('#modalContrato').modal('show');
          bien('Contrato generado correctamente');
          $('#pdfViewer_contrato').attr('src', response.url_pdf);
          $('#pdfViewer_contrato').on('load', function() { $(this).removeClass('d-none'); });
          $('#pdfViewer_contrato').on('error', function() { showAlert('Error al cargar el PDF. Por favor, intente nuevamente.'); });
        }
      }
    });
  }

  function show(id_carta)
  {   
      $('#div_tabla').addClass('d-none'); // LISTADO PRINCIPAL DE CONTRATOS POR GENERAR
      $('#div_detalle').removeClass('d-none'); // DETALLE DEL CANDIDATO PARA GENERAR CONTRATO
      $('#num_aprob_ofl').val('');
      $('#div_adjunta_contrato').removeClass('d-none');
      $('#contwork_frim').val('');
      
      $('#div_nacionalidad').removeClass('d-none');
      $('#div_num_doc').removeClass('d-none');
      $('#div_num_colab').addClass('d-none');
      $('#lb_num_colab').html('');
      $('#bto_generacontrato').removeClass('d-none');
      $('#bto_finalizacontrato').removeClass('d-none');
      //$('#id_curri').val(id_curri);
      //$('#id_participante').val(id_part);
        var _token = $('input[name="_token"]').val();
        var parametros = {
          "id_carta":id_carta,
          "_token": _token};
          $.ajax({
            data:  parametros, 
            url:   "{{ route('rl.show') }}",
            type:  'POST', 
            dataType: "json",
            cache: false,          
            success:  function (item) {
              const data = item.data_parti || {};
              const prinombre = data.prinombre || '';
              const priapellido = data.priapellido || '';
              const segnombre = data.segnombre || '';
              const segapellido = data.segapellido || '';
              const nombre = `${prinombre} ${priapellido}`.trim();
              const iniciales = `${prinombre.charAt(0) || ''}${priapellido.charAt(0) || ''}`.toUpperCase();
              const color_tx = $('#color_tx_'+(data.id_part||'')).val() || '#000';
              const color_bg = $('#color_bg_'+(data.id_part||'')).val() || '#ccc';
              const dependientes = item.dependientes;
              const documentacion = item.documentacion;
              const cv_doc = data.cv_doc;
              const carta_oferta_firmado = data.doc_cofl;
              const contrato_firmado = data.contrato_firmado;
              let fotoHtml = '';
              if(data.foto) {
                  fotoHtml = `<img src="${data.foto}" alt="Foto de ${nombre}" class="rounded-circle" style="background:#FFFFFF; width: 120px; height: 120px; object-fit: cover; border: 1px solid #aeafb0;">`;
              } else {
                  fotoHtml = `
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; background-color: ${color_bg}; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: ${color_tx}; font-family: 'Segoe UI', 'Roboto', sans-serif; font-size: 50px; text-transform: uppercase; border: 1px solid ${color_tx}">
                      ${iniciales}
                    </div>`;
              }

              $('#space_photo').html(fotoHtml);  
              $('#lb_nombre').html(nombre);
              $('#lb_nombre_completo').html(`${prinombre} ${segnombre} ${priapellido} ${segapellido}`.trim());
              $('#lb_pos').html(data.puesto);
              $('#lb_puesto_colab').html(data.puesto);

              $('#lb_proposito').html(data.proposito);
              $('#lb_carta_a').html(data.carta_presentacion);
              $('#lb_marcaciones').html(data.marcacion);
              $('#lb_carta_a_firmado').html(data.carta_presentacion);
              $('#lb_marcaciones_firmado').html(data.marcacion);
              $('#lb_cia').html(data.cia);
              $('#lb_ceco').html(data.ceco);
              $('#lb_ue').html(data.unidad);
              $('#lb_salario_mensual').html(data.sal);
              $('#lb_tiposalario').html(data.tiposalario);
              $('#lb_salariohora').html(data.sal_hora);
              $('#lb_tipoContrato').html(data.tipo_contrato); 
              $('#lb_fIngreso').html(data.finicio_largo); 
              $('#lb_fTerminacion').html(data.fterminacion_largo);
              $('#lb_nombreContrato').html(data.nombre_completo);
              $('#lb_num_doc').html(data.num_doc);
              $('#lb_cedula').html(data.num_doc);
              $('#lb_nss').html(data.num_ss);
              $('#lb_fnacimiento').html(data.f_nacimiento);
              $('#lb_edad').html(data.edad);
              $('#lb_estadocivil').html(data.estadocivil);
              $('#lb_nacionalidad').html(data.nacionalidad);
              $('#lb_nacionalidadcontrato').html(data.nacionalidad);
              $('#lb_telefono').html(data.tel);
              $('#lb_mail').html(data.email);
              $('#div_permiso_trab').addClass('d-none');
              if(data.id_nacionalidad!=53)
              { $('#lb_permiso_trab').html(data.permiso_trab);
                $('#lb_vence_permiso_trab').html(data.f_vence_permiso_trab);
                $('#div_permiso_trab').removeClass('d-none');}
              else{
                $('#lb_permiso_trab').html('');
                $('#lb_vence_permiso_trab').html('');
              }
              $('#lb_direccion').html(data.provincia+', '+data.distrito+', '+data.corregimiento+', '+data.direccion);
              $('#lb_contacto_urgencia').html(data.contacto_urgencia);
              $('#lb_parent_urgencia').html(data.parentesco_urgencia);
              $('#lb_tel_urgencia').html(data.tel_urgencia);
              $('#id_curri').val(data.id_curri);
              $('#id_carta').val(data.id_carta);
              $('#id_part').val(data.id_part);
              $('#id_puesto').val(data.id_puesto);
              // Dependientes
              if(dependientes.length > 0) {
                  $('#div_dependientes').html('');
                  jQuery(dependientes).each(function(i, dep) {  
                      $('#div_dependientes').append(
                         `<div class="col-md-4"><div class="text-secondary">${dep.nombre}</div></div>
                          <div class="col-md-4"><div class="text-secondary">${dep.parentesco}</div></div>
                          <div class="col-md-4"><div class="text-secondary">${dep.f_nacimiento}</div></div>`
                      );
                  });
              }
              $('#tbody_docs').html('');
                jQuery(documentacion).each(function(i, doc) {  
                  if(doc.downdoc!=null)
                  { input_doc = `<div id="input_name_docs_${doc.tipo}" class="input-group"><div class="text-center text-primary">Documento Adjunto</div></div>`;
                    enlaces=`
                    <span id="enlaces_${doc.tipo}">
                      <button type="button" class="btn btn-sm btn-outline-primary px-1 py-0 me-1" id="bto_down_${doc.tipo}" onclick="downfile('${doc.tipo}')"><i class="fa-solid fa-download"></i></button>
                      <button type="button" class="btn btn-sm btn-outline-success px-1 py-0 me-1" id="bto_view_${doc.tipo}" onclick="viewfile('${doc.tipo}')"><i class="fa-solid fa-magnifying-glass"></i></button>
                      <button type="button" class="btn btn-sm btn-outline-danger px-1 py-0 me-1" id="bto_del_${doc.tipo}" onclick="delfile('${doc.tipo}')"><i class="fa-solid fa-trash-can"></i></button>
                    </span>`;
                  }
                  else{
                    input_doc=`<div id="input_name_docs_${doc.tipo}" class="input-group text-center">                      
                            <input class="form-control form-control-sm" id="${doc.tipo}_file" name="pdf_file" type="file" accept="application/pdf">
                            <span class="input-group-text"><i class="fa-solid fa-file-pdf text-primary"></i></span>
                          </div>`;
                    enlaces=`
                    <span id="enlaces_${doc.tipo}">
                      <button type="button" class="btn btn-sm btn-outline-info px-1 py-0 me-1" id="bto_up_${doc.tipo}" onclick="upfile('${doc.tipo}')"><i class="fa-solid fa-upload"></i></button>
                      </span>`;
                  }
                  nomb=`${prinombre} ${priapellido}`.trim()
                  $('#tbody_docs').append(
                    `<tr>
                      <td class="align-middle text-secondary bg-transparent"><span id="name_file_${doc.tipo}">${doc.nomdoc}</span></td>
                        <td class="small align-middle text-center bg-transparent">
                          <div id="div_name_docs_${doc.tipo}" class="d-none">${doc.nomdoc}</div>
                          <input type='hidden' id='v_file_${doc.tipo}' value='${doc.downdoc}'> 
                          <input type='hidden' id='file_${doc.tipo}' value="${doc.id_doc}"> 
                          <a id='link_${doc.tipo}' href='${doc.downdoc}' download='${doc.tipo}_${nomb}' target='_blank'></a>                                                                                                                                                                                  
                          ${input_doc}                        
                        </td>
                        <td class="align-middle text-center bg-transparent">
                          ${enlaces}                          
                        </td>
                      </tr>`
                  );
                });
                
              if(cv_doc!=null)
                { 
                  $('#tbody_docs').append(
                    `<tr>
                      <td class="align-middle text-secondary bg-transparent"><span id="name_file_cv">Hoja de vida</span></td>
                        <td class="small align-middle text-center bg-transparent">
                          <div id="div_name_docs_cv" class="d-none">Hoja de Vida</div>
                          <input type='hidden' id='v_file_cv' value='${cv_doc}'> 
                          <a id='link_cv' href='${cv_doc}' download='cv_${nomb}' target='_blank'></a>                                                                                                                                                                                  
                          <div id="input_name_docs_cv" class="input-group"><div class="text-center text-primary">Documento Adjunto</div></div>                        
                        </td>
                        <td class="align-middle text-center bg-transparent">
                          <span id="enlaces_cv">
                            <button type="button" class="btn btn-sm btn-outline-primary px-1 py-0 me-1" id="bto_down_cv" onclick=downfile("cv")><i class="fa-solid fa-download"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-success px-1 py-0 me-1" id="bto_view_cv" onclick=viewfile("cv")><i class="fa-solid fa-magnifying-glass"></i></button>
                          </span>                          
                        </td>
                      </tr>`
                  );
                }
                if(carta_oferta_firmado!=null)
                { 
                  $('#tbody_docs').append(
                    `<tr>
                      <td class="align-middle text-secondary bg-transparent"><span id="name_file_cofl">Carta oferta firmada</span></td>
                        <td class="small align-middle text-center bg-transparent">
                          <div id="div_name_docs_cofl" class="d-none">Carta Oferta Firmada</div>
                          <input type='hidden' id='v_file_cofl' value='${carta_oferta_firmado}'> 
                          <a id='link_cofl' href='${carta_oferta_firmado}' download='Carta_Oferta_${nomb}' target='_blank'></a>                                                                                                                                                                                  
                          <div id="input_name_docs_cofl" class="input-group"><div class="text-center text-primary">Documento Adjunto</div></div>                        
                        </td>
                        <td class="align-middle text-center bg-transparent">
                          <span id="enlaces_cofl">
                            <button type="button" class="btn btn-sm btn-outline-primary px-1 py-0 me-1" id="bto_down_cofl" onclick=downfile("cofl")><i class="fa-solid fa-download"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-success px-1 py-0 me-1" id="bto_view_cofl" onclick=viewfile("cofl")><i class="fa-solid fa-magnifying-glass"></i></button>
                          </span>                          
                        </td>
                      </tr>`
                  );
                }
                if(contrato_firmado!=null)
                { 
                  $('#tbody_docs').append(
                    `<tr>
                      <td class="align-middle text-secondary bg-transparent"><span id="name_file_cont">Contrato firmado</span></td>
                        <td class="small align-middle text-center bg-transparent">
                          <div id="div_name_docs_cont" class="d-none">Contrato Firmado</div>
                          <input type='hidden' id='v_file_cont' value='${contrato_firmado}'> 
                          <a id='link_cont' href='${contrato_firmado}' download='Contrato_${nomb}' target='_blank'></a>                                                                                                                                                                                  
                          <div id="input_name_docs_cont" class="input-group"><div class="text-center text-primary">Documento Adjunto</div></div>                        
                        </td>
                        <td class="align-middle text-center bg-transparent">
                          <span id="enlaces_cont">
                            <button type="button" class="btn btn-sm btn-outline-primary px-1 py-0 me-1" id="bto_down_cont" onclick=downfile("cont")><i class="fa-solid fa-download"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-success px-1 py-0 me-1" id="bto_view_cont" onclick=viewfile("cont")><i class="fa-solid fa-magnifying-glass"></i></button>
                          </span>                          
                        </td>
                      </tr>`
                  );
                }
             // const carta_oferta_firmado = data.doc_cofl;
             // const contrato_firmado = data.contrato_firmado;
            },
              error: function(xhr, status, error) {
              console.error('Error al obtener datos:', error);
              alert('Ocurrió un error al obtener los datos del candidato.');
            }
          });
  }

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

  function downfile(doc)
  {
        const href = $('#link_' + doc).attr('href');
        const filename = $('#link_' + doc).attr('download') || 'documento.pdf';
        if (!href) {
            mal('No hay archivo disponible para descargar.');
            return;
        }
        const tempLink = document.createElement('a');
        tempLink.href = href;
        tempLink.setAttribute('download', filename);
        tempLink.style.display = 'none';
        document.body.appendChild(tempLink);
        tempLink.click();
        document.body.removeChild(tempLink);
  }

  function delfile(doc)
  {   const id_curri = $('#id_curri').val();
        const nombreArchivo = $('#name_file_' + doc).html();
        msn="¿Se eliminará el archivo adjunto '" + nombreArchivo + "', desea continuar?";
        Swal.fire({
            icon: "question",
            text: msn,
            showCancelButton: true,
            cancelButtonText: '<i class="fas fa-arrow-left"></i> Cancelar',
            confirmButtonText: '<i class="fa-solid fa-trash-can"></i> Sí, Eliminar',
            confirmButtonColor: "#d33",
        }).then((result) => {
          if (result.isConfirmed) {
            const parametros = {
              "_token": $('input[name="_token"]').val(),
              "id_doc": $('#file_' + doc).val(), 
              "id_curri": id_curri,
              "doc": doc,
            };
            $.ajax({
              data: parametros,
              url: "{{ route('ofertas.deldocs') }}", 
              type: 'POST',
              dataType: "json",
              cache: true,
              success: function(data) {
                $('#input_name_docs_' + doc).html('');
                $('#enlaces_' + doc).html('');
                $('#input_name_docs_' + doc).html('<input class="form-control form-control-sm" id="'+doc+'_file" name="pdf_file" type="file" accept="application/pdf"> <span class="input-group-text"><i class="fa-solid fa-file-pdf text-primary"></i></span>');
                $('#enlaces_' + doc).html('<button type="button" class="btn btn-sm btn-outline-info px-1 py-0 me-1" id="bto_up_'+doc+'" onclick=upfile("'+doc+'")><i class="fa-solid fa-upload"></i></button>');

                bien(data.message); 
              },
              error: function(xhr) {
                console.error("Error al intentar eliminar la carta oferta", xhr.responseText);
                mal("Error al intentar eliminar la carta oferta", xhr.responseText);                      
              }
            });
          }
        });
  }

    function upfile(doc)
    {  
        const input = document.getElementById(doc+'_file');
        const file = input.files[0];
        const id_curri= $('#id_curri').val();
        if (!file) {
            mal('Por favor, selecciona un archivo PDF primero.');
            return;
        }

        const formData = new FormData();
        formData.append('pdf_file', file);
        formData.append('_token', $('input[name="_token"]').val()); 
        formData.append('tipo_file', doc); 
        formData.append('id_curri', id_curri); 
        $.ajax({
            url: '{{ route("ofertas.importardocs") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
              $('#link_'+doc).attr('href', res.downdoc);
              
                $('#input_name_docs_' + doc).html('');
                $('#enlaces_' + doc).html('');
              $('#input_name_docs_' + doc).html('<div class="text-center text-primary">Documento Adjunto</div>');
              $('#enlaces_' + doc).html(
                  '<button type="button" class="btn btn-sm btn-outline-primary px-1 py-0 me-1" id="bto_down_'+doc+'" onclick=downfile("'+doc+'")><i class="fa-solid fa-download"></i></button>'+
                  '<button type="button" class="btn btn-sm btn-outline-success px-1 py-0 me-1" id="bto_view_'+doc+'" onclick=viewfile("'+doc+'")><i class="fa-solid fa-magnifying-glass"></i></button>'+
                  '<button type="button" class="btn btn-sm btn-outline-danger px-1 py-0 me-1" id="bto_del_'+doc+'" onclick=delfile("'+doc+'")><i class="fa-solid fa-trash-can"></i></button>');
              $("#v_file_"+doc).val(res.downdoc);
              $("#file_"+doc).val(res.id_doc);
              bien(res.message);
            },
            error: function (err) {
                console.error(err);
                mal("Error al procesar el PDF. Asegúrate de que el archivo sea correcto.");
            }
        });
    }

  function back()
  { $('#div_tabla').removeClass('d-none');        
    $('#div_detalle').addClass('d-none');        
    $('#div_permiso_trab').addClass('d-none');        
    var _token = $('input[name="_token"]').val();
    var parametros = {
      
      "_token": _token};
      $.ajax({
        data:  parametros, 
        url:   "{{ route('rl.porcontrato') }}",
        type:  'POST', 
        dataType: "json",
        cache: false,          
        beforeSend: function() {
          $('#listadoPrincipal').html('');
          $('#listadoPrincipal').html(`
              <tr>
                <td class="align-middle" colspan="4"> 
                  <div class="d-flex justify-content-center align-items-center">
                    <div class="spinner-border text-primary me-2 spinner-border-sm" role="status"></div>
                    <span class="small">Cargando...</span>
                  </div>
                </td>
              </tr>`);
        },
        success: function (item) {
          const data = item.data_parti;
          $('#listadoPrincipal').html('');
          if(data)
              {data.forEach((persona) => {
              let iniciales = (persona.prinombre.charAt(0) + persona.priapellido.charAt(0)).toUpperCase();
              let fotoHtml = '';

              if (persona.foto) {
                fotoHtml = `
                  <img src="${persona.foto}" alt="Foto de ${persona.prinombre} ${persona.priapellido}" 
                    class="rounded-circle" style="background:#FFFFFF; width: 60px; height: 60px; object-fit: cover; border: 1px solid #aeafb0;">
                `;
              } else {
                fotoHtml = `
                  <div class="rounded-circle d-flex align-items-center justify-content-center"
                      style="width: 60px; height: 60px; background-color: ${persona.color_bg}; 
                      border-radius: 50%; color: ${persona.color_text}; font-family: 'Segoe UI', 'Roboto', sans-serif; 
                      font-size: 22px; text-transform: uppercase; border: 1px solid ${persona.color_text}">
                    ${iniciales}
                  </div>`;
              }

              const html = `
                <tr class="oflinfo" onclick="show(${persona.id_carta})">
                  <td class="align-middle">
                    <input type="hidden" id="color_tx_${persona.id_participante}" value="${persona.color_text}">
                    <input type="hidden" id="color_bg_${persona.id_participante}" value="${persona.color_bg}">
                    <div class="d-flex align-items-center">
                      <div class="me-2">
                        ${fotoHtml}
                      </div>
                      <div>
                        <div class="fw-bold text-uppercase" style="color: #4B6EAD;font-size: 14px">
                          ${persona.prinombre} ${persona.priapellido}
                        </div>
                        <div class="text-secondary" style="font-size: 11px">
                          <i class="fa-solid fa-globe pe-1"></i>${persona.nacionalidad}
                        </div>
                        <div class="text-secondary" style="font-size: 11px">
                          <i class="fa-solid fa-id-card pe-1"></i>${persona.num_doc}
                        </div>
                      </div>
                    </div>
                  </td>
                  <td class="align-middle text-center text-secondary">${persona.finicio_formateado}</td>
                  <td class="align-middle text-center text-secondary">
                    <span class="text-primary fw-semibold pb-0 d-block">
                      ${persona.descpue}
                    </span>
                    <span class="text-secondary pt-0 d-block" style="font-size: 10px; margin-top: -3px;">
                      ${persona.nameund}
                    </span>
                  </td>
                  <td class="align-middle text-center text-secondary">
                    ${persona.nombre_reclutador} ${persona.apellido_reclutador}
                  </td>
                </tr>`;

              $('#listadoPrincipal').append(html);
            });
          }else
          {
            $('#listadoPrincipal').html(`
              <tr>
                <td class="align-middle" colspan="4"> 
                  <div class="d-flex justify-content-center align-items-center">
                    No hay contrataciones pendientes.
                  </div>
                </td>
              </tr>`);
          }

        }

      })
  }

  //----- SUBRE ARCHIVOS A STORAGE
  function sube_file(optarchi)
  { var _token = $('input[name="_token"]').val();

   // $("#tipo_archi").val(optarchi);
    if(optarchi=='contwork')
    {    
      var file= document.getElementById('contwork_frim').files;
      filefirmado = file[0];
      var data = new FormData();    
      data.append("_token", _token); 
      data.append("optarchi", optarchi);
      data.append("filedoc", filefirmado);
      data.append("num_aprob_ofl", $('#num_aprob_ofl').val());
      $.ajax({
        data:  data, 
        url:   "{{ route('ofertas.subir') }}",
        type:  'POST',//método de envio
        contentType: false,       // The content type used when sending data to the server.
        cache: false,             // To unable request pages to be cached
        processData:false,			// To send DOMDocument or non processed data file it is set to false+
        dataType: "json",
        beforeSend: function () {
          document.getElementById('div_adjunta_contrato').style.display="none";
          $('#div_contrato_firmado').html('<div class="spinner-border spinner-border-sm text-primary" role="status"></div>');
          document.getElementById('div_contrato_firmado').style.display="block";
        }, 
        success:  function (data) {

          //  document.getElementById('div_cartaoferta_aprobacion').style.display='block';
            document.getElementById('div_adjunta_contrato').style.display='block';
            document.getElementById('div_contrato_firmado').style.display='none';
            document.getElementById('contwork_frim').value="";
          if(data!='-')
          { fecha= data.f_contworkfirmado.split('-');
            document.getElementById('div_adjunta_contrato').style.display="none";
            document.getElementById('div_contrato_firmado').style.display="block";
            $('#div_contrato_firmado').html('<a href="'+data.url+'" download="Contrato Firmado - '+$('#lb_nombre').html()+'"><i class="fas fa-download"></i> Descargar <b>Contrato Firmado</b>. ('+fecha[2]+'-'+fecha[1]+'-'+fecha[0]+')</a> <i title="Eliminar archivo de contrato firmado" class="fa-solid fa-trash-can dell" onclick=deldocont("'+$('#num_aprob_ofl').val()+'")></i>');
          }
        }
      });
    }
  }

  //----- MENSAJE GENERICO SI ALGO SALE MAL, SE ENVIA EL MENSAJE EN EL PARAMETRO
  function mal(msn)
  {
      Swal.fire({
        position: 'center',
        icon: 'warning',
        text: msn,
      })
  }

  //----- MENSAJE GENERICO SI ALGO SALE BIEN, SE ENVIA EL MENSAJE EN EL PARAMETRO
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