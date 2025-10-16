<!DOCTYPE html>
@extends('layouts.plantilla')
<script src="{{ asset('assets/js/code/highcharts.js')}}"></script>
<script src="{{ asset('assets/js/code/highcharts-more.js')}}"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<style>
    /* Ajustes visuales */
    .select2-container--default .select2-selection--single {
        height: 40px;
        display: flex;
        align-items: center;
        padding-left: 2.5rem; /* para dejar espacio al ícono del filtro */
    }

    .select2-results__option img,
    .select2-results__option span.initiales-circle {
        margin-right: 8px;
        vertical-align: middle;
    }
</style>
@section('content')
    <!-- JavaScript -->
    <script type="text/javascript">
        // <![CDATA[
        function preloader() {
            document.getElementById("preload").style.display = "none";
            document.getElementById("iframe").style.display = "block";
        }
        //preloader
        window.onload = preloader;
        // ]]>
    </script>
    <!-- Quill CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <!-- Quill JS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <!-- Javascript -->
    <script src="{{ asset('assetsw/js/jquery-1.11.1.min.js') }}"></script>
    <script src="{{ asset('assetsw/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assetsw/js/jquery.backstretch.min.js') }}"></script>
    <script src="{{ asset('assetsw/js/scripts.js') }}"></script>
    <!-- Estilo -->
    <style>
        .bootstrap-select .dropdown-toggle {
            border-radius: 0.375rem;
            /* Igual que form-select de Bootstrap 5 */
            border: 1px solid #ced4da;
            height: calc(2.2rem + 2.2px);
            padding: 0.15rem 0.7rem;
            font-size: 1rem;
            background-color: #fff;
            color: #212529;
        }

        .bootstrap-select .dropdown-menu {
            border-radius: 0.375rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .bootstrap-select .dropdown-item.active,
        .bootstrap-select .dropdown-item:active {
            background-color: #0d6efd;
            color: #fff;
        }
    </style>
    <style>
        td.vertical-text {
            writing-mode: vertical-rl;
            transform: rotate(200deg);
            text-align: left;
            white-space: nowrap;
            padding: 5px;
            padding-bottom: 2px;
            height: 150px;
            vertical-align: bottom;
            font-size: 12px;
            background-color: transparent;
        }
        .text-primary-terna {
            color: blue !important;
        }
    </style>
    <style>
        div#iframe {
            display: none;
        }
        div#preload {
            cursor: wait;
        }
    #iframe,
    #Detalle-Candidato {
    width: 100% !important;
    min-width: 100%;
    max-width: 100%;
    }
    </style>

<style>
      /* Ajustar el tamaño del editor */
      trix-editor {
            width: 100%;           /* Ancho del editor (puedes ajustarlo según tu necesidad) */
            height: 250px;         /* Altura reducida */
            border: 1px solid #ccc; /* Puedes agregar borde si lo deseas */
            padding: 10px;          /* Espaciado dentro del editor */
            font-size: 14px;        /* Tamaño de fuente más pequeño */
            display: block;
  
            overflow-y: auto;   /* Barra de scroll vertical */
            white-space: pre-wrap; /* Para que el texto se envuelva en líneas */
        }

        /* Opción para ocultar el área de entrada (input hidden) */
        #x {
            display: none;
        }
</style>
<style>
    /* Estilo profesional */
    #modalPaseaFirma .modal-content {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    border-radius: 0.75rem;
    }


    #modalPaseaFirma strong {
    font-weight: 600;
    }

    #modalPaseaFirma .form-label {
    font-size: 0.9rem;
    }
      .nav-tabs-bordered .nav-link.active {
    font-weight: 600;
    color: #0d6efd;
    border-color: #0d6efd;
  }
</style>
    <div class="pagetitle pb-0 mb-0">
        <div class="row pb-0 mb-0">
            <div class="col-8 my-0 py-0">
                <h1 class="text-secondary">Solicitudes en Proceso</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"style="font-weight: normal;">Control de Solicitudes de Contratación</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- SOLICITUD DE CONTRATACIÓN PARA APROBAR-->
    <input type="hidden" id="id_ofl_glb" value="">
        <div class="row gx-3" id="div_badge_solicitudes">
            <style>
                .stats-card {
                border: none;
                border-left: 5px solid;
                border-radius: 1rem;
                box-shadow: 0 3px 6px rgba(0, 0, 0, 0.08);
                transition: all 0.25s ease;
                background: white;
                }
                .stats-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
                }
                .stats-icon {
                width: 42px;
                height: 42px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                font-size: 1.4rem;
                }
                .text-muted-small {
                font-size: 0.75rem;
                letter-spacing: 0.3px;
                }
            </style>
            <input id="idu" type="hidden" value="{{ Auth::user()->id }}">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card stats-card border-info">
                <div class="card-body py-2 px-3">
                    <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="fw-bold text-muted mb-0" id="tot_vacantes_activas">{{ $stats['vacantes_activas'] }}</h4>
                        <div class="text-muted-small text-info fw-semibold">Vacantes Activas</div>
                    </div>
                    <div class="stats-icon bg-info bg-opacity-10 text-info">
                        <i class="fa-solid fa-people-group fa-lg"></i>
                    </div>
                    </div>
                </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="card stats-card border-primary">
                <div class="card-body py-2 px-3">
                    <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="fw-bold text-muted mb-0" id="tot_vacantes_asignadas">{{ $stats['vacantes_asignadas'] }}</h4>
                        <div class="text-muted-small text-primary fw-semibold">Vacantes Asignadas</div>
                    </div>
                    <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                        <i class="fa-solid fa-arrows-down-to-people fa-lg"></i>
                    </div>
                    </div>
                </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="card stats-card border-secondary">
                <div class="card-body py-2 px-3">
                    <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="fw-bold text-muted mb-0" id="tot_vacantes_sin_asignar">{{ $stats['vacantes_sin_asignar'] }}</h4>
                        <div class="text-muted-small text-secondary fw-semibold">Vacantes sin Asignar</div>
                    </div>
                    <div class="stats-icon bg-secondary bg-opacity-10 text-secondary">
                        <i class="fa-solid fa-person-circle-question fa-lg"></i>
                    </div>
                    </div>
                </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="card stats-card border-warning">
                <div class="card-body py-2 px-3">
                    <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="fw-bold text-muted mb-0" id="tot_vacantes_del_mes">{{ $stats['vacantes_del_mes'] }}</h4>
                        <div class="text-muted-small text-warning fw-semibold">Vacantes del Mes</div>
                    </div>
                    <div class="stats-icon bg-warning bg-opacity-10 text-warning">
                        <i class="fa-solid fa-person-circle-exclamation fa-lg"></i>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>

    <div class="card" style="width: 100%;">
        <div class="card-header py-0 bg-light">
            <div class="row my-2 py-0" id="div_titulo_sol">
                <div class="d-flex justify-content-between align-items-center flex-wrap my-0">
                    <!-- Título a la izquierda -->
                    <div class="d-flex align-items-center">
                        <i class="fas fa-th-list pe-2"></i>
                        <h5 class="m-0">Solicitudes de Contratación</h5>
                    </div>

                    <!-- Filtro a la derecha -->
                    <div class="d-flex align-items-center mt-md-0">
                        <div class="dropdown position-relative d-inline-block mt-2" style="min-width: max-content;">
                            <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center" type="button" id="filtroBtn">
                                <i class="bi bi-funnel-fill me-2"></i>
                                Filtrar solicitudes...
                            </button>
                            <!-- Lista de opciones -->
                            <div class="dropdown-menu mt-1 p-0" id="filtroDropdown" style="min-width: max-content;">
                                <!-- Opción "Todos" -->
                                <div style="cursor: pointer" class="dropdown-item d-flex align-items-center filtro-item px-2 py-1" data-id="all">
                                    <i class="fa-solid fa-bars fa-lg me-2"></i> Todas
                                </div>
                                <!-- Opción "Sin Asignar" -->
                                <div style="cursor: pointer" class="dropdown-item d-flex align-items-center filtro-item px-2 py-1" data-id="nothing">
                                    <i class="fa-solid fa-circle-minus fa-lg me-2"></i> Sin Asignar
                                </div>
                                @foreach($data_reclutadores as $reclutador)
                                    @php
                                        $nombre = $reclutador->prinombre ?? '';
                                        $apellido = $reclutador->priapellido ?? '';
                                        $iniciales = strtoupper(mb_substr($nombre, 0, 1) . mb_substr($apellido, 0, 1));
                                    @endphp
                                    <div style="cursor: pointer" class="dropdown-item d-flex align-items-center filtro-item px-2 py-1" data-id="{{ $reclutador->id }}">
                                        @if($reclutador->foto)
                                            <img src="{{ asset($reclutador->foto) }}" class="rounded-circle me-2" style="width:24px;height:24px;object-fit:cover;border:1px solid #ccc;">
                                        @else
                                            <span class="rounded-circle me-2 d-flex align-items-center justify-content-center"
                                                style="width:24px;height:24px;background:{{ $reclutador->color_bg }};
                                                color:{{ $reclutador->color_text }};font-size:11px;font-weight:bold;border:1px solid {{ $reclutador->color_text }}">
                                                {{ $iniciales }}
                                            </span>
                                        @endif
                                        <span id="nom_reclutador_{{ $reclutador->id }}">{{ $reclutador->nombre }}</span><span class="badge bg-primary ms-1" id="id_cantidad_badge_{{ $reclutador->id }}">{{ $reclutador->total_vacantes }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row my-2 pt-1 d-none" id="div_titulo_pos">
                <div class="col-9 my-0 py-0 small">
                    <small>
                    <div class="col text-start h5 text-primary"> <i class="fa-solid fa-user-tie"></i> <span id="nom_pos_ofl"></span></div>
                    <div><i class="fa-solid fa-calendar-days ms-4 pe-1"></i>
                        <spam id="lb_fech_sol"></span>
                    </div>
                    <div><i class="fa-solid fa-magnifying-glass ms-4 pe-1"></i>
                        <spam id="lb_cant_part"></span>                        
                    </div>
                    <div><i class="fa-solid fa-user-tie ms-4 pe-1"></i>
                        <spam id="lb_cant_contratados"></span>                        
                    </div>
                    <input type="hidden" id="hrs_mensuales" value="">
                </small>
                </div>
                <div class="col-3 my-0 py-0 align-items-center justify-content-end"id="bto_listado_candidato">
                    <!-- REGREGA AL LISTADO PRINCIPAL DE OFERTAS LABORALES-->
                    <div class="col text-end"><button type="button" class="btn btn-sm btn-secondary py-1 mb-2" onclick="cancel_ofl()"><i class="fa-solid fa-arrow-left fa-lg pe-2"></i>Volver</button> </div> 
                    <div class="col text-end">
                        <div class="dropdown py-0">                            
                            <!-- ACCIONES DE LISTADO DE PARTICIPANTES DE OFERTAS LABORALES-->
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-gear fa-lg pe-2"></i>Acciones  </button>
                            <ul class="dropdown-menu p-0">
                                <li><button class="border-top dropdown-item py-1 text-secondary" type="button" onclick="add_candidate()" ><i class="fa-solid fa-user-plus text-primary fa-lg pe-2"></i>Agregar Candidato</button></li>
                                <li><button class="border-top dropdown-item py-1 text-secondary" type="button" onclick="add_terna()" ><i class="fa-solid fa-users-line text-success fa-lg pe-2"></i>Presentar Terna</button></li>
                            </ul>
                        </div>                        
                    </div>
                </div>
                <div class="col-3 my-0 py-0 align-items-center justify-content-end d-none" id="bto_volver_det_candidato">
                    <div class="col text-end"><button type="button" class="btn btn-sm btn-secondary py-1 mb-2" onclick="cancel_det_candidate()"><i class="fa-solid fa-arrow-left fa-lg pe-2"></i>Volver</button></div>
                    <div class="col text-end"><button type="button" class="btn btn-sm btn-danger" onclick="modaldeclinar()"><i class="fas fa-user-times fa-lg"></i> Descartar Candidato </button></div>
                </div>
                
                <div class="col-3 my-0 py-0 align-items-center justify-content-end d-none" id="bto_ternas">
                    <div class="col text-end"><button type="button" class="btn btn-sm btn-secondary py-1 mb-2" onclick="cancel_ternas()"><i class="fa-solid fa-arrow-left fa-lg pe-2"></i>Volver</button></div>
                    <div class="col text-end"><button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#emailModal" onclick="sendTerna()"><i class="fa-solid fa-paper-plane fa-lg pe-2"></i> Enviar Terna </button></div>
                </div>                
            </div>
        </div>

        <div class="card-body">
            <small>
                <div id="preload" class="align-items-center justify-content-center text-center">
                    <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                </div>
            </small>
            <!-- LISTADO PRINCIPAL OFERTAS LABORALES-->
            <div id="iframe" style="display: none;">
                <!-- LISTADO PRINCIPAL DE LA OFERTAS-->                
                <div id="listado">
                    @foreach ($data_ofertas as $ofertas)
                        @php
                            $fsol = explode('-', $ofertas->fecha_sol);
                            $fcie = explode('-', $ofertas->fecha_tope);
                            $hoy = date('Y-m-d');
                            $mensaje = ''; $link = '';

                            if ($ofertas->fecha_tope < $hoy) {
                                $mensaje ='<span class="text-danger"><i class="far fa-clock fa-spin"></i> Solicitud vencida</span>';
                            }
                            $boder = 'border-primary';
                            $band_asig=0;
                            if($ofertas->id_reclutador_asignado)
                            {   $band_asig=1;}
                            if ($ofertas->id_estatus == 1) {
                                $link =
                                    '<div class="dropdown py-0">
                                        <button class="btn btn-warning text-dark btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-gear pe-2"></i>
                                            Acciones  
                                        </button>
                                        <ul class="dropdown-menu p-0">
                                            <li><button class="border-top dropdown-item py-1" type="button"  onclick="busca_ofl('.$ofertas->id.')"><i class="fa-solid fa-magnifying-glass pe-2 text-primary"></i> Ver Solicitud</button></li>
                                            
                                        </ul>
                                    </div>';
                                $boder = 'border-warning';
                            }
                            if ($ofertas->id_estatus == 2) {
                                $link =
                                '<div class="dropdown py-0">
                                    <button class="btn btn-info btn-sm dropdown-toggle text-light" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-gear pe-2"></i>
                                        Acciones  
                                    </button>
                                    <ul class="dropdown-menu p-0">
                                        <li><button class="border-top dropdown-item py-1" type="button" onclick="mod_prospectos('.$ofertas->id .')" >'.$ofertas->icono.' Ver Candidatos</button></li>
                                        <li><button class="border-top dropdown-item py-1" type="button"  onclick="busca_ofl('.$ofertas->id.')"><i class="fa-solid fa-magnifying-glass pe-2 text-primary"></i>Ver Solicitud</button></li>
                                        <li><button class="border-top dropdown-item py-1" type="button"  onclick="asigrecuiter('.$ofertas->id.','.$band_asig.')"><i class="fa-solid fa-people-arrows pe-2 text-primary"></i>Reasignar reclutador</button></li>
                                    </ul>
                                </div>';
                            }
                            $conf = '<span id="conf_' . $ofertas->id . '"></span>';
                            if($ofertas->confidencial == 1){
                                $conf="<span class='ms-2 badge rounded-pill text-danger' style='background-color: #f8d7da; font-size: 12px;'><i class='fa-solid fa-triangle-exclamation pe-1'></i>Confidencial</span>";
                            }
                        
                            $nombre_reclutador = $ofertas->prinombre_reclutador ?? '';
                            $apellido_reclutador = $ofertas->priapellido_reclutador ?? '';
                            $iniciales_reclutador = strtoupper(mb_substr($nombre_reclutador, 0, 1) . mb_substr($apellido_reclutador, 0, 1));
                        @endphp
                        <div class="row border @php echo $boder @endphp my-2 p-2 rounded oflinfo" id="ofl_{{ $ofertas->id }}" data-reclutador="{{ $ofertas->id_reclutador_asignado }}">
                            <div class="row">
                                <div class="col-11">
                                    <h6 class="mb-0 text-primary">
                                        <small><b>#{{ $ofertas->id }} <span id="despue_{{ $ofertas->id }}">{{ $ofertas->descpue }}</span></b>,
                                        <small> {{ $ofertas->unidad_economica }}@php echo $conf; @endphp</small></small>
                                    </h6>
                                </div>
                                <div class="col-1 d-grid gap-4 d-md-flex justify-content-md-end">
                                    <input id="name_{{ $ofertas->id }}" value="{{ $ofertas->name }}" type="hidden">
                                    <span id="divico_{{ $ofertas->id }}">
                                        @php echo $link; @endphp
                                    </span>
                                </div>
                                <span class="text-secondary">
                                    <small>
                                        <small> 
                                            Fecha de solicitud: <span id="fech_sol_{{ $ofertas->id }}"><span class="text-primary fw-semibold">{{ $ofertas->fecha_sol }}</span></span>
                                            <span class="ps-3">Cantidad solicitada:</span> <span class="text-primary fw-semibold">{{ $ofertas->cantidad }}</span>            
                                            <span class="ps-3 d-inline-flex align-items-center">
                                                Reclutador:
                                                @if($ofertas->id_reclutador_asignado)
                                                    <div class="d-inline-flex align-items-center ms-1" id="div_nombre_reclutador_{{ $ofertas->id }}">
                                                        @if($ofertas->reclutador_foto)
                                                            <img src="{{ asset($ofertas->reclutador_foto) }}" 
                                                                class="rounded-circle me-1" 
                                                                style="width:24px;height:24px;object-fit:cover;border:1px solid #ccc; vertical-align:middle;">
                                                        @else
                                                            <span class="rounded-circle me-1 d-flex align-items-center justify-content-center"
                                                                style="width:24px;height:24px;background:{{ $ofertas->color_bg_reclutador }};
                                                                        color:{{ $ofertas->color_text_reclutador }};font-size:11px;font-weight:bold;
                                                                        border:1px solid {{ $ofertas->color_text_reclutador }}">
                                                                {{ $iniciales_reclutador }}
                                                            </span>
                                                        @endif
                                                        <span class="text-primary fw-semibold" id="reclutador_{{ $ofertas->id }}">
                                                            {{ $nombre_reclutador }} {{ $apellido_reclutador }}
                                                        </span>
                                                    </div>
                                                @else                                                
                                                    <div class="d-inline-flex align-items-center ms-1" id="div_nombre_reclutador_{{ $ofertas->id }}">
                                                        <span class="ms-1 text-muted"><i class="fa-solid fa-circle-minus fa-lg me-1"></i> <span class="text-primary fw-semibold" id="reclutador_{{ $ofertas->id }}">Sin asignar</span></span>
                                                    </div>
                                                @endif
                                            </span>
                                        </small>
                                    </small>
                                </span>
                            </div>

                            <hr class="my-0">
                            <small>
                                <div class="row text-secondary mt-1" id="div_status_ofl">
                                    <div class="col text-center">
                                        <div  class="fw-bold" id="cantpart_{{ $ofertas->id }}">{{ $ofertas->proceso }}</div>
                                        <div class="text-center">Candidatos</div>
                                    </div>
                                    <div class="col text-center">
                                        <div class="fw-bold" id="cantinicial_{{ $ofertas->id }}">{{ $ofertas->incial }}</div>
                                        <div class="badge bg-secondary"><i class="fas fa-street-view"></i> Ent. Inicial
                                        </div>
                                    </div>

                                    <div class="col text-center">
                                        <div class="fw-bold" id="cantfuncional_{{ $ofertas->id }}">{{ $ofertas->funcional }}</div>                                            
                                        <div class="badge bg-info"><i class="fas fa-user-tie"></i> Presentación de Terna</div>
                                    </div>

                                    <div class="col text-center">
                                        <div class="fw-bold" id="cantofertalaboral_{{ $ofertas->id }}">{{ $ofertas->ofertalaboral }}</div>
                                        <div class="badge bg-warning"><i class="fas fa-user-clock"></i> Entrevista funcional</div>
                                    </div>

                                    <div class="col text-center">
                                        <div class="fw-bold" id="cantdocumentacion_{{ $ofertas->id }}">{{ $ofertas->documentacion }}</div>
                                        <div class="badge bg-primary"><i class="far fa-address-book"></i> Presentación de oferta</div>
                                    </div>

                                    <div class="col text-center">
                                        <div class="fw-bold" id="cantfirma_{{ $ofertas->id }}">{{ $ofertas->firma }}</div>
                                        <div class="badge bg-success"><i class="fa-solid fa-signature pe-1"></i> Firma de Contrato</div>
                                    </div>

                                    <div class="col text-center">
                                        <div class="fw-bold" id="cantcont_{{ $ofertas->id }}">{{ $ofertas->contratado }}</div>
                                        <div><span style="background-color:#0BC114;" class="badge"><i class="fas fa-check-double"></i>Contratados</div>
                                    </div>
                                    
                                </div>
                            </small>
                        </div>
                    @endforeach
                    <div class="text-center text-muted py-4 d-none" id='div_sin_registro'>
                        <i class="fas fa-box-open fa-2x mb-2 mt-4"></i>
                            <div>No hay solicitudes asignadas al relutador seleccionado</div>
                    </div>
                </div>              

                <!-- LISTADO DE LOS ASPIRANTES O CANDIDATOS-->
                <div id="div_oferta_laboral" class="d-none pt-4">                 
                    <table class="table table-hover table-sm" style="width:100%" id="table_prospectos">
                        <thead>
                            <tr>
                                <td class="text-center  text-secondary">Nombre</td>
                                <td class="text-center  text-secondary">Aspiración Salarial</td>
                                <td class="text-center  text-secondary">Estatus</td>
                                <td class="text-center  text-secondary"><i class="fas fa-cog"></i></td>
                            </tr>
                        </thead>
                        <tbody id="tbody_aspirantes">
                        </tbody>
                    </table>
                </div>

                <!-- LISTADO DE LOS ASPIRANTES para terna-->
                <div id="div_terna" class="d-none pt-4">
                    <div class="pagetitle pb-0 mb-0">
                            <div class="row pb-0 mb-0">
                                <div class="col-10 my-0 py-0">
                                    <h5 class="text-primary">Creación de Terna</h5>
                                    <nav>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"style="font-weight: normal;">Selecciones los candidatos que van a componer la terna.</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                    </div>
                    <hr class="mt-1">
                    <div class="row align-items-center justify-content-center">   
                            <div class="col-8">
                                <table class="table table-hover table-sm" style="width:100%" id="table_terna">
                                    <thead>
                                        <tr>
                                            <td class="text-center  text-secondary" style="width: 5%">Sel.</td>
                                            <td class="text-center  text-secondary" style="width: 30%">Nombre</td>
                                            <td class="text-center  text-secondary" style="width: 5%">CV</td>
                                            <td class="text-center  text-secondary" style="width: 5%">APL</td>
                                            <td class="text-center  text-secondary" style="width: 5%">RAZI</td>
                                            <td class="text-center  text-secondary" style="width: 5%">DISC</td>
                                            <td class="text-center  text-secondary" style="width: 15%">Observaciones</td>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody_terna"></tbody>
                                </table>
                            </div>
                    </div>
                                            
                    <div class="pagetitle pt-4 pb-0 mb-0">
                            <div class="row pb-0 mb-0">
                                <div class="col-8 my-0 py-0">
                                    <h5 class="text-primary">Análisis comparativo de perfiles</h5>
                                </div>
                            </div>
                    </div>
                        
                    <div class="row pb-0 mb-0">
                            <div class="col-8 my-0 py-0">
                                <h5 class="text-secondary">Resultados de Prueba APL </h5>
                                <nav>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"style="font-weight: normal;">Modelo de competencia - <span class="fw-bold" id="jerarquia_analisis_apl">Asistente Ejecutiva</span></li>
                                    </ol>
                                </nav>
                            </div>
                    </div>
                    <hr class="mt-0">

                    <!-- APL -->
                            <div class="row align-items-center justify-content-center">   
                                <div class="col-10 small">
                                    <table id="tabla-participantes" class="table table-sm small table-hover">
                                        <tbody id="body-rows">
                                            <!-- Filas dinámicas aquí -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
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

                    <!-- RAZI -->
                            <div class="row align-items-center justify-content-center">   
                                <div class="col-10 small">
                                    <table id="tabla-participantes-razi" class="table table-sm small table-hover">
                                        <tbody id="body-rows-razi">
                                            <!-- Filas dinámicas aquí -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
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

                    <!-- DISC -->
                            <div class="row align-items-center justify-content-center">   
                                <div class="col-8 small">
                                    <table id="tabla-participantes-disc" class="table table-sm small table-hover">
                                        <tbody id="body-rows-disc">
                                            <!-- Filas dinámicas aquí -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>  
                            
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

                    <!-- VERITAS -->
                            <div class="row align-items-center justify-content-center">   
                                <div class="col-8 small">
                                    <table id="tabla-participantes-veritas" class="table table-sm small table-hover">
                                        <tbody id="body-rows-veritas">
                                            <!-- Filas dinámicas aquí -->
                                        </tbody>
                                    </table>
                                </div>
                            </div> 

                </div>

                <!-- DETALLE DEL CANDIDATO-->
                    <div class="d-flex justify-content-center align-items-center d-none" style="height: 20vh;" id="div_spinner">
                        <div class="spinner-border text-primary me-2" role="status"></div>
                        <span>Cargando...</span>
                    </div>
                    <div id="Detalle-Candidato" style="width: 100%" class="d-none pt-4">
                        <div class="row">
                            <div class="col-auto ms-4" id="div_foto_reg">
                                <img src="storage/profiles/photo/el.png" class="rounded-circle" alt="Foto"
                                    style="width: 125px; height: 125px; object-fit: cover; border: 1px solid #aeafb0;"
                                    title="Cambiar foto">
                            </div>
                            <div class="col-6 d-flex align-items-center ps-2">
                                <div>
                                    <div class="fw-bold text-uppercase" id="nom_reg" style="color: #4B6EAD;"></div>
                                    <div class="text-secondary small"><i class="fa-solid fa-envelope pe-2"></i><span id="mail_reg" class="text-primary"></span></div>
                                    <div class="text-secondary small"><i class="fa-solid fa-phone-flip pe-2"></i><span id="tel_reg" class="text-primary"></span></div>
                                    <div class="text-secondary small"><i class="fa-solid fa-location-dot pe-2"></i><span id="res_reg" class="text-primary"></span></div>
                                    <div class="text-secondary small">
                                        <i class="fa-solid fa-file-pdf pe-2"></i>
                                        <span id="cv_reg" class="text-primary">Hoja de Vida</span>
                                        <button type="button" class="ms-2 btn btn-sm btn-outline-primary px-1 py-0" onclick="downfile('cv')"><i class="fa-solid fa-download"></i></button>
                                        <button type="button" class="btn btn-sm btn-outline-success px-1 py-0" onclick="viewfile('cv')"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                    <input type="hidden" id="id_curri" name="id_curri" value="">
                                </div>
                            </div>
                            
                            <div class="col-4 small">
                                <div class="alert alert-primary small p-2 d-none"  role="alert" id="alert_estatus">
                                    <span class="fw-semibold" id="titulo_estatus"></span><hr class="my-1">
                                    <div><span id="motivo_estatus"></span></div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="reclutamiento_id_curri" value="">
                        <input type="hidden" id="reclutamiento_id_participante" value="">
                        <input type="hidden" id="reclutamiento_nom_puesto" name="reclutamiento_nom_puesto" value="">
                        <input type="hidden" id="reclutamiento_nom_unidad" name="reclutamiento_nom_unidad" value="">
                        <!--DETALLE PARA PASOS DE CONTRATACIÓN-->
                        <ul class="nav nav-tabs nav-tabs-bordered my-3 " id="myTab" role="tablist">
                        
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#Paso-0" id="tab-Paso-0">Descripción General</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#Paso-2" id="tab-Paso-2">Entrevista inicial</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#Paso-3" id="tab-Paso-3">Pruebas Psicométricas</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#Paso-5" id="tab-Paso-5">Documentación</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#Paso-4" id="tab-Paso-4">Entrevistas</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#Paso-6" id="tab-Paso-6">Ofertas</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">                            
                            <!--DATOS PERSONALES-->
                            <div class="tab-pane fade show active p-2 small" id="Paso-0">
                                <div class="card mt-4"style=" box-shadow: none;border: 1px solid #e2e2e2;">
                                    <!-- Datos Personales -->
                                    <div class="card-header h6 text-uppercase fw-semibold py-2 text-primary" style="background-color: #D4DCEB;  border-radius: 5px 5px 0px 0px;">
                                        <i class="fas fa-user-tag fa-lg ps-2 pe-2 text-secondary"></i>Datos Personales
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="row g-3 ms-2 mb-3">
                                            <div class="col-md-3">
                                                <strong class="text-secondary">Nombre:</strong><br>
                                                <span id="lb_nombre" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-3">
                                                <strong class="text-secondary">Apellido:</strong><br>
                                                <span id="lb_apellido" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-3">
                                                <strong class="text-secondary">F. Nacimiento:</strong><br>
                                                <span id="lb_fnac" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-3">
                                                <strong class="text-secondary"><span id="lb_tipo_doc"></span>:</strong><br>
                                                <span id="lb_num_doc" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-3">
                                                <strong class="text-secondary"># Seguro Social:</strong><br>
                                                <span id="lb_css" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-3">
                                                <strong class="text-secondary">Estado Civil:</strong><br>
                                                <span id="lb_ecivil" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-3">
                                                <strong class="text-secondary">Nacionalidad:</strong><br>
                                                <span id="lb_nacionalidad" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-3 d-none" id="div_permiso">
                                                <strong class="text-secondary">Tipo de Permiso:</strong><br>
                                                <span id="lb_permiso" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-3 d-none" id="div_fpermiso">
                                                <strong class="text-secondary">F. Vencimiento:</strong><br>
                                                <span id="lb_permiso_vencimiento" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-3 d-none" id="div_dpermiso">
                                                <strong class="text-secondary">Permiso:</strong><br>
                                                <span id="lb_permiso_atach" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-3">
                                                <strong class="text-secondary">Teléfono:</strong><br>
                                                <span id="lb_tel" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-4">
                                                <strong class="text-secondary">Correo:</strong><br>
                                                <span id="lb_email" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-8">
                                                <strong class="text-secondary">Dirección:</strong><br>
                                                <span id="lb_dir" class="text-muted"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-4"style=" box-shadow: none;border: 1px solid #e2e2e2;">
                                    <!-- Salud y Seguridad -->
                                    <div class="card-header h6 text-uppercase fw-semibold py-2 text-primary" style="background-color: #D4DCEB;  border-radius: 5px 5px 0px 0px;">
                                        <i class="fa-solid fa-hand-holding-medical fa-lg ps-2 pe-2 text-secondary"></i>Salud y Seguridad</div>
                                    <div class="card-body p-4">
                                        <div class="row g-3 ms-2 mb-3">
                                            <div class="col-md-3">
                                                <strong class="text-secondary">Tipo de Sangre:</strong><br>
                                                <span id="lb_tipo_sangre" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-3">
                                                <strong class="text-secondary">Médico de Cabecera:</strong><br>
                                                <span id="lb_medico_cabecera" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-3">
                                                <strong class="text-secondary">Hospital:</strong><br>
                                                <span id="lb_hospital" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-3">
                                                <strong class="text-secondary">Teléfono:</strong><br>
                                                <span id="lb_tel_hospital" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-3">
                                                <strong class="text-secondary">Alérgico a medicamentos:</strong><br>
                                                <span id="lb_alergico_medicamento" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-9">
                                                <strong class="text-secondary">Nombre del medicamento:</strong><br>
                                                <span id="lb_nom_medicamento" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-3">
                                                <strong class="text-secondary">Discapacidad:</strong><br>
                                                <span id="lb_discapacidad" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-9">
                                                <strong class="text-secondary">Detalle:</strong><br>
                                                <span id="lb_det_discapacidad" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-3">
                                                <strong class="text-secondary">Lesión Laboral:</strong><br>
                                                <span id="lb_lesion_laboral" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-9">
                                                <strong class="text-secondary">Detalle:</strong><br>
                                                <span id="lb_det_lesion" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-3">
                                                <strong class="text-secondary">Contacto en caso de urgencia:</strong><br>
                                                <span id="lb_contacto_urgencia" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-3">
                                                <strong class="text-secondary">Parentesco:</strong><br>
                                                <span id="lb_parentesco_urgencia" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-3">
                                                <strong class="text-secondary">Teléfono:</strong><br>
                                                <span id="lb_tel_urgencia" class="text-muted"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-4"style=" box-shadow: none;border: 1px solid #e2e2e2;">
                                    <!-- Educación y Formación -->
                                    <div class="card-header h6 text-uppercase fw-semibold py-2 text-primary" style="background-color: #D4DCEB;  border-radius: 5px 5px 0px 0px;">
                                        <i class="fa-solid fa-user-graduate fa-lg ps-2 pe-2 text-secondary"></i>Educación y Formación
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="row g-3 ms-2 mb-3">
                                            <div class="col-md-12">
                                                <table class="table table-sm" id="tbl_educacion">
                                                    <thead>
                                                        <tr>
                                                            <th class="ps-1 text-secondary bg-light">Carrera</th>
                                                            <th class="ps-1 text-secondary bg-light">Institución</th>
                                                            <th class="ps-1 text-secondary bg-light">Año</th>
                                                            <th class="ps-1 text-secondary bg-light">Nivel</th>
                                                            <th class="ps-1 text-secondary bg-light">Estatus</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-4"style=" box-shadow: none;border: 1px solid #e2e2e2;">
                                    <!-- Educación y Formación -->
                                    <div class="card-header h6 text-uppercase fw-semibold py-2 text-primary" style="background-color: #D4DCEB;  border-radius: 5px 5px 0px 0px;">
                                        <i class="fa-solid fa-chalkboard-user fa-lg ps-2 pe-2 text-secondary"></i>Cursos / Seminarios
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="row g-3 ms-2 mb-3 d-flex justify-content-center">
                                            <div class="col-md-8">
                                                <table class="table table-sm" id="tbl_cursos">
                                                    <thead>
                                                        <tr>
                                                            <th class="ps-1 text-secondary bg-light">Curso / Seminario</th>
                                                            <th class="ps-1 text-secondary bg-light">Institución</th>
                                                            <th class="ps-1 text-secondary bg-light">Año</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-4"style=" box-shadow: none;border: 1px solid #e2e2e2;">
                                    <!-- Educación y Formación -->
                                    <div class="card-header h6 text-uppercase fw-semibold py-2 text-primary" style="background-color: #D4DCEB;  border-radius: 5px 5px 0px 0px;">
                                        <i class="fa-solid fa-lightbulb fa-lg ps-2 pe-2 text-secondary"></i>Conocimentos adicionales
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="row g-3 ms-2 mb-4">
                                            <div class="col-md-3">
                                                <strong class="text-secondary">Idioma Español:</strong><br>
                                                <span id="lb_espanol" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-9">
                                                <strong class="text-secondary">Idioma Inglés:</strong><br>
                                                <span id="lb_ingles" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-3">
                                                <strong class="text-secondary"><i
                                                        class="fa-solid fa-laptop fa-lg pe-1 text-info"></i>Dominio de computadora:</strong><br>
                                                <span id="lb_pc" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-3">
                                                <strong class="text-secondary"><i
                                                        class="fa-solid fa-file-word fa-lg pe-1 text-primary"></i>Manejo de Word:</strong><br>
                                                <span id="lb_word" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-3">
                                                <strong class="text-secondary"><i
                                                        class="fa-solid fa-file-excel fa-lg pe-1 text-success"></i>Manejo de Excel:</strong><br>
                                                <span id="lb_excel" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-3">
                                                <strong class="text-secondary"><i
                                                        class="fa-solid fa-file-powerpoint fa-lg pe-1 text-danger"></i>Manejo de Power Point:</strong><br>
                                                <span id="lb_ppt" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-12">
                                                <strong class="text-secondary">Otros:</strong><br>
                                                <span id="lb_otros" class="text-muted"></span>
                                            </div>
                                        </div>

                                        <div class="row mx-2 mb-3">
                                            <span class="text-secondary mt-2 fw-semibold"> Tipos de vehículos que sabe manejar:</span>
                                            <hr class="mt-0">
                                            <div class="mb-3 row">
                                                <div class="col-2">
                                                    <strong class="text-secondary"><i
                                                            class="fa-solid fa-car-side fa-lg pe-1 text-primary"></i>Sedan/Pickup:</strong><br>
                                                    <span id="lb_sedan" class="text-muted"></span>
                                                </div>
                                                <div class="col-2">
                                                    <strong class="text-secondary"><i
                                                            class="fa-solid fa-truck fa-lg pe-1 text-primary"></i>Camión:</strong><br>
                                                    <span id="lb_camion" class="text-muted"></span>
                                                </div>
                                                <div class="col-2">
                                                    <strong class="text-secondary"><i
                                                            class="fa-solid fa-truck-moving fa-lg pe-1 text-primary"></i>Trailer:</strong><br>
                                                    <span id="lb_trailer" class="text-muted"></span>
                                                </div>
                                                <div class="col-2">
                                                    <strong class="text-secondary"><i
                                                            class="fa-solid fa-motorcycle fa-lg pe-1 text-primary"></i>Moto:</strong><br>
                                                    <span id="lb_moto" class="text-muted"></span>
                                                </div>
                                                <div class="col-2">
                                                    <strong class="text-secondary"><i
                                                            class="fa-solid fa-truck-ramp-box fa-lg pe-1 text-primary"></i>Monta Cargas:</strong><br>
                                                    <span id="lb_montacargas" class="text-muted"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-4"style=" box-shadow: none;border: 1px solid #e2e2e2;">
                                    <!-- Referencias Personales -->
                                    <div class="card-header h6 text-uppercase fw-semibold py-2 text-primary" style="background-color: #D4DCEB;  border-radius: 5px 5px 0px 0px;">
                                        <i class="fa-solid fa-people-arrows fa-lg ps-2 pe-2 text-secondary"></i>Referencia personal
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="row g-3 ms-2 mb-3 d-flex justify-content-center">
                                            <div class="col-md-10">
                                                <table class="table table-sm" id="ref_personal">
                                                    <thead>
                                                        <tr>
                                                            <th class="ps-1 text-secondary bg-light">Nombre</th>
                                                            <th class="ps-1 text-secondary bg-light">Dirección</th>
                                                            <th class="ps-1 text-secondary bg-light">Teléfono</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-4"style=" box-shadow: none;border: 1px solid #e2e2e2;">
                                    <!-- Experiencia Laboral -->
                                    <div class="card-header h6 text-uppercase fw-semibold py-2 text-primary" style="background-color: #D4DCEB;  border-radius: 5px 5px 0px 0px;">
                                        <i class="fa-solid fa-user-check fa-lg ps-2 pe-2 text-secondary"></i>Experiencia Laboral
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="row g-3 ms-2 mb-3">
                                            <div class="col-md-12" id="lis_exp_lab">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-4"style=" box-shadow: none;border: 1px solid #e2e2e2;">
                                    <!-- Familiares en la Compañia -->
                                    <div class="card-header h6 text-uppercase fw-semibold py-2 text-primary" style="background-color: #D4DCEB;  border-radius: 5px 5px 0px 0px;">
                                        <i class="fa-solid fa-people-group fa-lg ps-2 pe-2  text-secondary"></i>Familiares en la empresa
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="row g-3 ms-2 mb-3 d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <table class="table table-sm" id="lis_familiares">
                                                    <thead class="table-secondary">
                                                        <tr>
                                                            <th class="ps-1 text-secondary bg-light">Nombre</th>
                                                            <th class="ps-1 text-secondary bg-light">Parentesco</th>
                                                            <th class="ps-1 text-secondary bg-light">Unidad económina</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-4"style=" box-shadow: none;border: 1px solid #e2e2e2;">
                                    <!-- Dependientes -->
                                    <div class="card-header h6 text-uppercase fw-semibold py-2 text-primary"
                                        style="background-color: #D4DCEB;  border-radius: 5px 5px 0px 0px;">
                                        <i class="fa-solid fa-people-roof fa-lg ps-2 pe-2 text-secondary"></i>Dependientes
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="row g-3 ms-2 mb-3 d-flex justify-content-center">
                                            <div class="col-md-6">
                                                <table class="table table-sm" id="lis_dependientes">
                                                    <thead class="table-secondary">
                                                        <tr>
                                                            <th class="ps-1 text-secondary bg-light">Nombre</th>
                                                            <th class="ps-1 text-secondary bg-light">Parentesco</th>
                                                            <th class="ps-1 text-secondary bg-light">F. de nacimiento</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-4"style=" box-shadow: none;border: 1px solid #e2e2e2;">
                                    <!-- Autorización y Declaración -->
                                    <div class="card-header h6 text-uppercase fw-semibold py-2 text-primary"
                                        style="background-color: #D4DCEB;  border-radius: 5px 5px 0px 0px;">
                                        <i class="fa-solid fa-signature fa-lg ps-2 pe-2 text-secondary"></i>Autorización y Declaración
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="row g-3 ms-2 mb-3">
                                            <div class="col-md-12 px-4 mt-4">
                                                <div class="mb-2">
                                                    <i class="fa-solid fa-check-circle text-success me-2" id="chk_lb_viajar"></i>
                                                    ¿Tiene disponibilidad para viajar en caso de que el trabajo lo requiera?
                                                </div>

                                                <div class="mb-2">
                                                    <i class="fa-solid fa-check-circle text-success me-2" id="chk_lb_psico"></i>
                                                    ¿Está usted dispuesto a someterse a un examen psicométrico?
                                                </div>

                                                <div class="mb-2">
                                                    <i class="fa-solid fa-check-circle text-success me-2" id="chk_lb_verificar_info"></i>
                                                    Autorizo la verificación de la información proporcionada en este formulario.
                                                </div>

                                                <div class="mb-2">
                                                    <i class="fa-solid fa-check-circle text-success me-2" id="chk_lb_afirmacion"></i>
                                                    Declaro que toda la información proporcionada es verdadera y completa.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--PRUEBAS PSICOMÉTRICAS-->
                            <div class="tab-pane fade" id="Paso-3">
                                
                                <div class="fw-semibold pt-4" style="color: #4B6EAD;"> Pruebas Psicométricas</div>
                                <hr class="mt-0">
                                <div class="row ps-4 g-3">                            
                                    <small>
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                <td class="text-center text-secondary fw-semibold small" style="width: 10%">Prueba</td>
                                                <td class="text-center text-secondary fw-semibold small" style="width: 20%">Fecha de la prueba</td>
                                                <td class="text-center text-secondary fw-semibold small" style="width: 40%">Resultado</td>
                                                <td class="text-center text-secondary fw-semibold small" style="width: 30%">Archivo</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <!-- DISC -->
                                                <tr>
                                                    <td class="align-middle fw-semibold text-primary text-center">DISC</td>
                                                    <td class="align-middle text-center">
                                                        <span class="text-secondary" id="fecha_disc"></span>
                                                    </td>
                                                    <td class="text-center small align-middle">
                                                        <table class="table table-sm table-borderless m-0 p-0">
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <div class="input-group">
                                                                            <span class="input-group-text small fw-semibold p-1" style="color: blue;">D</span>
                                                                            <input type="text" class="form-control form-control-sm bg-white text-center p-0" id="disc_d" name="disc_d" disabled>
                                                                            
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group">
                                                                            <span class="input-group-text small fw-semibold p-1" style="color: red">I</span>
                                                                            <input type="text" class="form-control form-control-sm bg-white text-center p-0" id="disc_i" name="disc_i" disabled>
                                                                            
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group">
                                                                            <span class="input-group-text small fw-semibold p-1" style="color: orange">S</span>
                                                                            <input type="text" class="form-control form-control-sm bg-white text-center p-0" id="disc_s" name="disc_s" disabled>
                                                                            
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group">
                                                                            <span class="input-group-text small fw-semibold p-1" style="color: green">C</span>
                                                                            <input type="text" class="form-control form-control-sm bg-white text-center p-0" id="disc_c" name="disc_c" disabled>
                                                                            
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>        
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span id="archivo_disc"></span>
                                                    </td>
                                                </tr>
                                            
                                            <!-- APL -->
                                                <tr>
                                                    <td class="align-middle fw-semibold text-primary text-center">APL</td>
                                                    <td class="align-middle text-center">
                                                        <span class="text-secondary" id="fecha_apl"></span>
                                                    </td>
                                                    <td class="small align-middle">
                                                        <div class="input-group">
                                                            <span style="font-size: 14px" class="input-group-text px-1 py-0 text-secondary">Ajuste al puesto</span>
                                                            <input type="text" class="form-control form-control-sm p-1 bg-white text-center" style="max-width: 60px;" id="calce_apl" name="calce_apl" disabled>                                                        
                                                            <span id="ver_calce" style="cursor:pointer" class=" text-info ms-2 d-none mt-2" data-bs-toggle="modal" data-bs-target="#modal-calce">
                                                                    <i class="fa-solid fa-magnifying-glass"></i> Ver calce
                                                            </span>
                                                            
                                                        </div>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span id="archivo_apl"></span>
                                                    </td>
                                                </tr>

                                            <!-- RAZI -->
                                                <tr>
                                                    <td class="align-middle fw-semibold text-primary text-center">RAZI</td>
                                                    <td class="align-middle text-center">
                                                        <span class="text-secondary" id="fecha_razi"></span>
                                                    </td>
                                                    <td class="small align-middle">
                                                        <table class="table table-sm table-borderless m-0 p-0">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-center small align-middle">
                                                                        <div class="input-group justify-content-center">
                                                                            <span style="font-size: 14px" class="input-group-text px-1 py-0 text-secondary">Verb.</span>
                                                                            <input type="text" class="form-control form-control-sm p-1 bg-white text-center" style="max-width: 50px;" id="razi_v" name="razi_v" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group justify-content-center">
                                                                            <span style="font-size: 14px" class="input-group-text px-1 py-0 text-secondary">Num.</span>
                                                                            <input type="text" class="form-control form-control-sm p-1 bg-white text-center"style="max-width: 50px;" id="razi_n" name="razi_n" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group justify-content-center">
                                                                            <span style="font-size: 14px" class="input-group-text px-1 py-0 text-secondary">Abstrac.</span>
                                                                            <input type="text" class="form-control form-control-sm p-1 bg-white text-center" style="max-width: 50px;" id="razi_a" name="razi_a" disabled>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="input-group justify-content-center">
                                                                            <span style="font-size: 14px" class="input-group-text px-1 py-0 text-secondary">Gral.</span>
                                                                            <input type="text" class="form-control form-control-sm p-1 bg-white text-center" style="max-width: 50px;" id="razi_gen" name="razi_gen" disabled>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>        
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span id="archivo_razi"></span>
                                                    </td>
                                                </tr>
                                                
                                            <!-- VERITAS -->   
                                                <tr>
                                                <td class="align-middle fw-semibold text-primary text-center">VERITAS</td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary" id="fecha_veritas"></span>
                                                </td>
                                                <td class="d-flex align-middle text-center">
                                                    <div class="input-group justify-content-center">
                                                        <select class="form-select form-select-sm bg-white text-center" style="max-width: 180px;" id="veritas_result" name="veritas_result" disabled>
                                                            <option selected>Seleccione</option>
                                                            <option value="1">1- Elegible</option>
                                                            <option value="2">2- Elegible / Revisar</option>
                                                            <option value="3">3- No Elegible</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td></td>
                                                </tr>

                                            </tbody>
                                        </table>                            
                                    </small>
                                </div>
                            </div>

                            <!--ENTREVISTA INICIAL-->
                            <div class="tab-pane fade px-2" id="Paso-2" role="tabpanel" aria-labelledby="Paso-2" tabindex="0">
                                
                                <div class="row ms-4 mt-4 ">
                                    <div class="col-4">
                                        <span class="text-secondary" id="lb_fecha_entrevista"></span>
                                    </div>
                                    <div class="col-2">  
                                        <span class="text-secondary" id="fecha_entrevista"></span>
                                    </div>     
                                    <div class="col-6 d-flex align-items-center justify-content-end">
                                        <button type="button" class="btn btn-sm btn-success" onclick="saveentrevista_ini()"><i class="fas fa-save fa-lg pe-2"></i>Guardar</button>
                                    </div> 
                                </div>
                                <div class="fw-semibold" style="color: #4B6EAD;"> Entrevista Inicial</div>
                                <hr class="mt-0">
                                <div class="row ms-4 mt-0 mb-3">
                                    <div class="col-4">
                                        <span class="text-secondary" id="lb_entrevista_por"></span>
                                    </div>     
                                    <div class="col-6">
                                        <span class="text-secondary" id="entrevista_por"></span>
                                    </div> 
                                </div>
                                <div class="row ms-4 mb-3">
                                    <div class="col-4">
                                        <span class="text-secondary"><i class="fas fa-asterisk text-danger fa-2xs"></i> ¿Esta laborando actualmente?</span>
                                    </div>
                                    <div class="col-auto">
                                        <input class="form-check-input" type="radio" name="trabajando" id="trabajando_s" value="s" onchange="muestra_div_labora()">
                                        <label class="form-check-label" for="trabajando_s"> Si </label>
                                    </div>
                                    <div class="col-auto">
                                        <input class="form-check-input" type="radio" name="trabajando" id="trabajando_n" value="n" checked onchange="muestra_div_labora()">
                                        <label class="form-check-label" for="trabajando_n"> No </label>
                                    </div>
                                </div>
                                <span id="div_si_labora" class="d-none">
                                    <div class="row ms-4 mb-3">   
                                        <div class="col-4">
                                            <span class="text-secondary"><i class="fas fa-asterisk text-danger fa-2xs"></i> ¿Nombre de la empresa donde labora?</span>
                                        </div>
                                        <div class="col-auto">
                                            <input type="text" style="width: 300px" class="form-control form-control-sm" id="empresa_actual" val=''>
                                        </div>
                                    </div>

                                    <div class="row ms-4 mb-3">   
                                        <div class="col-4">
                                            <span class="text-secondary"><i class="fas fa-asterisk text-danger fa-2xs"></i> ¿Qué posición ocupa?</span>
                                        </div>
                                        <div class="col-auto">
                                            <input type="text" style="width: 300px" class="form-control form-control-sm" id="puesto_actual" val=''>
                                        </div>
                                    </div>
                                                                
                                    <div class="row ms-4 mb-3">   
                                        <div class="col-4">
                                            <span class="text-secondary"><i class="fas fa-asterisk text-danger fa-2xs"></i> ¿Qué salario devenga?</span>
                                        </div>
                                        <div class="col-auto">
                                            <input type="number" class="form-control form-control-sm"style="width: 100px" id="salario_actual" name="salario_actual" placeholder="0.00" min="0.01" step="0.01">
                                        </div>
                                    </div> 
                                    
                                    <div class="row ms-4 mb-3">   
                                        <div class="col-4">
                                            <span class="text-secondary"><i class="fas fa-asterisk text-danger fa-2xs"></i> ¿Cuenta con algún tipo de beneficios adicional al salario?</span>
                                        </div>
                                        <div class="col-auto">
                                            <input type="text" style="width: 300px" class="form-control form-control-sm" id="beneficios" val=''>
                                        </div>
                                    </div>

                                </span>
                                <div class="row ms-4 mb-3">   
                                    <div class="col-4">
                                        <span class="text-secondary"><i class="fas fa-asterisk text-danger fa-2xs"></i> ¿Cuál es su aspiración salarial?</span>
                                    </div>
                                    <div class="col-auto">
                                        <input type="number" class="form-control form-control-sm"style="width: 100px" id="aspiracion_salarial" name="aspiracion_salarial" placeholder="0.00" min="0.01" step="0.01">
                                    </div>
                                </div>
                                            
                                <div class="row ms-4 mb-3" id="div_nuevas_preg">
                                </div>                 
                                
                                <div class="row ms-4 mb-3">   
                                    <div class="col-2">
                                        <span style="cursor:pointer" class="text-primary small" onclick="add_preg()"><i class="fa-solid fa-plus"></i> Nueva pregunta</span>
                                        <input id="num_preg" type="hidden" val="0">
                                    </div>
                                </div>  
                    
                                
                                <div class="row ps-4 mb-3">
                                    <div class="col-6">
                                        <textarea class="form-control form-control-sm" id="comentarios_adicionales" name="comentarios_adicionales" rows="2" placeholder="Observaciones..."></textarea>
                                    </div>
                                </div>

                                <div class="fw-semibold pt-4" style="color: #4B6EAD;"> Validación de Referencias</div>
                                <hr class="mt-0">   

                                <div class="card border-0 shadow-none">
                                    <div class="card-header text-secondary py-1">Referencias Personales</div>
                                    <div class="card-body p-4">                                
                                        <small>
                                            <table class="table table-sm table-striped" id="valida_ref_personal">
                                                <thead class="table-primary text-center">
                                                    <tr>
                                                        <th class="ps-1 text-secondary">Nombre</th>
                                                        <th class="ps-1 text-secondary">Dirección</th>
                                                        <th class="ps-1 text-secondary">Teléfono</th>
                                                        <th class="ps-1 text-secondary"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </small>   
                                    </div>
                                </div>
                            
                                <div class="card border-0 shadow-none">
                                    <!-- Experiencia Laboral -->
                                    <div class="card-header text-secondary py-1"> Experiencia Laboral </div>
                                    <div class="card-body p-4">
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-12 small" id="validar_lis_exp_lab"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!--DOCUMENTACIÓN-->
                            <div class="tab-pane fade" id="Paso-5" role="tabpanel" aria-labelledby="Paso-5" tabindex="0">                            
                                <div class="fw-semibold mt-4 pt-4" style="color: #4B6EAD;"> Adjuntar documentos</div>
                                <hr class="mt-0"> 
                                <div class="row pt-2 align-middle justify-content-center">
                                    <div class="col-10">
                                        <table class="table table-hover mt-3">
                                            <tbody>
                                                <tr>
                                                    <td class="align-middle text-secondary"><span id="name_file_rp">Record policivo</span></td>
                                                    <td class="small align-middle text-center">
                                                        <div id="div_name_docs_rp" class="d-none"></div>
                                                        <div id="input_name_docs_rp" class="input-group">                                               
                                                            <input class="form-control form-control-sm" id="rp_file" name="pdf_file" type="file" accept="application/pdf">
                                                            <span class="input-group-text"><i class="fa-solid fa-file-pdf text-primary"></i></span>
                                                        </div>
                                                    </td>
                                                    <td class="small align-middle text-center">
                                                        <button type="button" class="btn btn-sm btn-outline-info px-1 py-0" id="bto_up_rp" onclick="upfile('rp')"><i class="fa-solid fa-upload"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-primary px-1 py-0 d-none" id="bto_down_rp" onclick="downfile('rp')"><i class="fa-solid fa-download"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-success px-1 py-0 d-none" id="bto_view_rp" onclick="viewfile('rp')"><i class="fa-solid fa-magnifying-glass"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-danger px-1 py-0 d-none" id="bto_del_rp" onclick="delfile('rp')"><i class="fa-solid fa-trash-can"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle text-secondary"><span id="name_file_ced">Copia de cédula</span></td>
                                                    <td class="small align-middle text-center">
                                                        <div id="div_name_docs_ced" class="d-none"></div>
                                                        <div id="input_name_docs_ced" class="input-group">             
                                                            <input class="form-control form-control-sm" id="ced_file" name="pdf_file" type="file" accept="application/pdf">
                                                            <span class="input-group-text"><i class="fa-solid fa-file-pdf text-primary"></i></span>
                                                        </div>
                                                    </td>
                                                    <td class="small align-middle text-center">
                                                        <button type="button" class="btn btn-sm btn-outline-info px-1 py-0" id="bto_up_ced" onclick="upfile('ced')"><i class="fa-solid fa-upload"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-primary px-1 py-0 d-none" id="bto_down_ced" onclick="downfile('ced')"><i class="fa-solid fa-download"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-success px-1 py-0 d-none" id="bto_view_ced" onclick="viewfile('ced')"><i class="fa-solid fa-magnifying-glass"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-danger px-1 py-0 d-none" id="bto_del_ced" onclick="delfile('ced')"><i class="fa-solid fa-trash-can"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle  text-secondary"><span id="name_file_cn">Certificado de nacimiento</span></td>
                                                    <td class="small align-middle text-center">
                                                        <div id="div_name_docs_cn" class="d-none"></div>
                                                        <div id="input_name_docs_cn" class="input-group">                      
                                                            <input class="form-control form-control-sm" id="cn_file" name="pdf_file" type="file" accept="application/pdf">
                                                            <span class="input-group-text"><i class="fa-solid fa-file-pdf text-primary"></i></span>
                                                        </div>
                                                    </td>
                                                    <td class="small align-middle text-center">
                                                        <button type="button" class="btn btn-sm btn-outline-info px-1 py-0" id="bto_up_cn" onclick="upfile('cn')"><i class="fa-solid fa-upload"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-primary px-1 py-0 d-none" id="bto_down_cn" onclick="downfile('cn')"><i class="fa-solid fa-download"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-success px-1 py-0 d-none" id="bto_view_cn" onclick="viewfile('cn')"><i class="fa-solid fa-magnifying-glass"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-danger px-1 py-0 d-none" id="bto_del_cn" onclick="delfile('cn')"><i class="fa-solid fa-trash-can"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle text-secondary"><span id="name_file_dpl">Copia de último diploma</span></td>
                                                    <td class="small align-middle text-center">
                                                        <div id="div_name_docs_dpl" class="d-none"></div>
                                                        <div id="input_name_docs_dpl" class="input-group">
                                                            <input class="form-control form-control-sm" id="dpl_file" name="pdf_file" type="file" accept="application/pdf">
                                                            <span class="input-group-text"><i class="fa-solid fa-file-pdf text-primary"></i></span>
                                                        </div>
                                                    </td>
                                                    <td class="small align-middle text-center">
                                                        <button type="button" class="btn btn-sm btn-outline-info px-1 py-0" id="bto_up_dpl" onclick="upfile('dpl')"><i class="fa-solid fa-upload"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-primary px-1 py-0 d-none" id="bto_down_dpl" onclick="downfile('dpl')"><i class="fa-solid fa-download"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-success px-1 py-0 d-none" id="bto_view_dpl" onclick="viewfile('dpl')"><i class="fa-solid fa-magnifying-glass"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-danger px-1 py-0 d-none" id="bto_del_dpl" onclick="delfile('dpl')"><i class="fa-solid fa-trash-can"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle text-secondary"><span id="name_file_css">Copia de carné de S.S. o ficha de S.S.</span></td>
                                                    <td class="small align-middle text-center">
                                                        <div id="div_name_docs_css" class="d-none"></div>
                                                        <div id="input_name_docs_css" class="input-group">           
                                                            <input class="form-control form-control-sm" id="css_file" name="pdf_file" type="file" accept="application/pdf">
                                                            <span class="input-group-text"><i class="fa-solid fa-file-pdf text-primary"></i></span>
                                                        </div>
                                                    </td>
                                                    <td class="small align-middle text-center">
                                                        <button type="button" class="btn btn-sm btn-outline-info px-1 py-0" id="bto_up_css" onclick="upfile('css')"><i class="fa-solid fa-upload"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-primary px-1 py-0 d-none" id="bto_down_css" onclick="downfile('css')"><i class="fa-solid fa-download"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-success px-1 py-0 d-none" id="bto_view_css" onclick="viewfile('css')"><i class="fa-solid fa-magnifying-glass"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-danger px-1 py-0 d-none" id="bto_del_css" onclick="delfile('css')"><i class="fa-solid fa-trash-can"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle text-secondary"><span id="name_file_dir">Constancia de dirección</span></td>
                                                    <td class="small align-middle text-center">
                                                        <div id="div_name_docs_dir" class="d-none"></div>
                                                        <div id="input_name_docs_dir" class="input-group">                      
                                                            <input class="form-control form-control-sm" id="dir_file" name="pdf_file" type="file" accept="application/pdf">
                                                            <span class="input-group-text"><i class="fa-solid fa-file-pdf text-primary"></i></span>
                                                        </div>
                                                    </td>
                                                    <td class="small align-middle text-center">
                                                        <button type="button" class="btn btn-sm btn-outline-info px-1 py-0" id="bto_up_dir" onclick="upfile('dir')"><i class="fa-solid fa-upload"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-primary px-1 py-0 d-none" id="bto_down_dir" onclick="downfile('dir')"><i class="fa-solid fa-download"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-success px-1 py-0 d-none" id="bto_view_dir" onclick="viewfile('dir')"><i class="fa-solid fa-magnifying-glass"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-danger px-1 py-0 d-none" id="bto_del_dir" onclick="delfile('dir')"><i class="fa-solid fa-trash-can"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle text-secondary"><span id="name_file_fto">Foto tamaño carnet</span></td>
                                                    <td class="small align-middle text-center">
                                                        <div id="div_name_docs_fto" class="d-none"></div>
                                                        <div id="input_name_docs_fto" class="input-group">                      
                                                            <input class="form-control form-control-sm" id="fto_file" name="pdf_file" type="file" accept="application/pdf">
                                                            <span class="input-group-text"><i class="fa-solid fa-file-pdf text-primary"></i></span>
                                                        </div>
                                                    </td>
                                                    <td class="small align-middle text-center">
                                                        <button type="button" class="btn btn-sm btn-outline-info px-1 py-0" id="bto_up_fto" onclick="upfile('fto')"><i class="fa-solid fa-upload"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-primary px-1 py-0 d-none" id="bto_down_fto" onclick="downfile('fto')"><i class="fa-solid fa-download"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-success px-1 py-0 d-none" id="bto_view_fto" onclick="viewfile('fto')"><i class="fa-solid fa-magnifying-glass"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-danger px-1 py-0 d-none" id="bto_del_fto" onclick="delfile('fto')"><i class="fa-solid fa-trash-can"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle text-secondary"><span id="name_file_sipe">Validacón en SIPE (screenshot)</span></td>
                                                    <td class="small align-middle text-center">
                                                        <div id="div_name_docs_sipe" class="d-none"></div>
                                                        <div id="input_name_docs_sipe" class="input-group">                      
                                                            <input class="form-control form-control-sm" id="sipe_file" name="pdf_file" type="file" accept="application/pdf">
                                                            <span class="input-group-text"><i class="fa-solid fa-file-pdf text-primary"></i></span>
                                                        </div>
                                                    </td>
                                                    <td class="small align-middle text-center">
                                                        <button type="button" class="btn btn-sm btn-outline-info px-1 py-0" id="bto_up_sipe" onclick="upfile('sipe')"><i class="fa-solid fa-upload"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-primary px-1 py-0 d-none" id="bto_down_sipe" onclick="downfile('sipe')"><i class="fa-solid fa-download"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-success px-1 py-0 d-none" id="bto_view_sipe" onclick="viewfile('sipe')"><i class="fa-solid fa-magnifying-glass"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-danger px-1 py-0 d-none" id="bto_del_sipe" onclick="delfile('sipe')"><i class="fa-solid fa-trash-can"></i></button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle text-secondary"><span id="name_file_ortho">Copia de la prueba de ortho</span></td>
                                                    <td class="small align-middle text-center">
                                                        <div id="div_name_docs_ortho" class="d-none"></div>
                                                        <div id="input_name_docs_ortho" class="input-group">                      
                                                            <input class="form-control form-control-sm" id="ortho_file" name="pdf_file" type="file" accept="application/pdf">
                                                            <span class="input-group-text"><i class="fa-solid fa-file-pdf text-primary"></i></span>
                                                        </div>
                                                    </td>
                                                    <td class="small align-middle text-center">
                                                        <button type="button" class="btn btn-sm btn-outline-info px-1 py-0" id="bto_up_ortho" onclick="upfile('ortho')"><i class="fa-solid fa-upload"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-primary px-1 py-0 d-none" id="bto_down_ortho" onclick="downfile('ortho')"><i class="fa-solid fa-download"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-success px-1 py-0 d-none" id="bto_view_ortho" onclick="viewfile('ortho')"><i class="fa-solid fa-magnifying-glass"></i></button>
                                                        <button type="button" class="btn btn-sm btn-outline-danger px-1 py-0 d-none" id="bto_del_ortho" onclick="delfile('ortho')"><i class="fa-solid fa-trash-can"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>        
                                </div>
                            </div>

                            <!--Entrevistas funcionales-->
                            <div class="tab-pane fade" id="Paso-4" role="tabpanel" aria-labelledby="Paso-4" tabindex="0">
                                <div class="row mt-4">
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-sm btn-primary" onclick="crea_nueva_entrevista()"><i class="fa-solid fa-calendar-plus pe-2"></i>Agendar nueva entrevista</button>
                                    </div>
                                </div>
                                <div class="fw-semibold" style="color: #4B6EAD;"> Programación de Entrevistas</div>
                                <hr class="mt-0">
                                <input type="hidden" id="num_entrevistas" value="0">
                                <div class="row pt-4 align-middle justify-content-center" id="div_entrevistas">                                    
                                    <!-- Aquí se cargarán las entrevistas funcionales -->
                                </div>
                            </div>

                            <!--Ofertas laborales-->
                            <div class="tab-pane fade pb-4" id="Paso-6" role="tabpanel" aria-labelledby="Paso-6" tabindex="0">                                
                                <div class="row mt-4">
                                    <div class="col-12 text-end">
                                        <button id="bot_nueva_cofl" type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalCartaOferta" onclick="$('#form_carta_oferta')[0].reset();resetBeneficiosHerramientas();"><i class="fa-regular fa-file-lines pe-2"></i>Crear nueva carta oferta</button>
                                        <button id="bot_pasa_fimacontrato" type="button" class="btn btn-sm btn-success d-none"  onclick="pasar_a_firma()"><i class="fa-solid fa-file-signature pe-2"></i>Pasar a firma de contrato</button>
                                    </div>
                                </div>

                                <div class="fw-semibold" style="color: #4B6EAD;"> Carta Oferta de Trabajo</div>
                                <hr class="mt-0">
                                <div class="row p-4 mb-4 align-middle justify-content-center" id="div_cartas_oferta">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <td class="text-center">Registro</td>
                                                <td class="text-center">Salario</td>
                                                <td class="text-center">Fecha de ingreso</td>
                                                <td class="text-center">Generado por</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody_cartas_oferta">
                                            <!-- Aquí se cargarán las cartas oferta -->                                            
                                        </tbody>
                                    </table>                                    
                                </div>
                            </div>   
                        </div>
                    </div>    
                </div>
            </div>
        </div>  

    <!-- Modal Solicitud de Contratación -->
    <div class="modal fade" id="modalsoli" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-sm rounded-2">

                <!-- Header -->
                <div class="modal-header bg-body-secondary border-bottom py-2 px-3">
                    <h6 class="modal-title text-primary fw-semibold mb-0">
                        <i class="fa-solid fa-briefcase me-2"></i> Solicitud de Contratación
                        <span id="lb_id_sol" class="badge bg-primary-subtle text-primary ms-2"></span>
                    </h6>
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    <input type="hidden" id="id_ofl_txt" value="">
                </div>

                <!-- Body -->
                <div class="modal-body py-2 px-3">
                    <div class="row align-items-end d-none" id="div_reasigna_confidencial">
                        <div class="col-6 mb-3">
                            <label for="asginar_reclutador" class="form-label small text-primary mb-1">
                                Asignar reclutador
                            </label>
                            <select id="asginar_reclutador" class="form-select form-select-sm">
                                <option value="0" class="text-muted" selected>Seleccione</option>
                                @foreach($data_reclutadores as $reclutadores)
                                    <option value="{{ $reclutadores->id }}">{{ $reclutadores->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-6 mb-3">
                            <div class="d-flex justify-content-end">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="Confidencial">
                                    <label class="form-check-label" for="Confidencial">
                                        Confidencial
                                    </label>
                                </div>
                            </div>
                        </div>  
                    <hr>           
                    </div>
                    <div class="border rounded p-2 bg-light-subtle mb-2 small">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <strong class="text-secondary">Fecha de solicitud:</strong>
                                <span id="lb_f_sol" class="ms-1"></span>
                            </div>
                            <div class="col-md-6">
                                <span id="lb_f_lim" class="text-secondary fw-semibold"></span>
                                <span> días disponibles para la contratación</span>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2 mb-2 small">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary mb-0">Unidad económica</label>
                            <input id="lb_ue" class="form-control form-control-sm" type="text" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary mb-0">Área</label>
                            <input id="lb_secc" class="form-control form-control-sm" type="text" readonly>
                        </div>
                    </div>

                    <div class="mb-2 small">
                        <label class="form-label fw-semibold text-secondary mb-0">Posición</label>
                        <input id="lb_nom_posicion_sol" class="form-control form-control-sm" type="text" readonly>
                    </div>

                    <div class="row text-center my-4">
                        <div class="col">
                            <div class="border rounded py-1 bg-body-tertiary">
                                <div class="small text-secondary">Cantidad solicitada</div>
                                <div id="lb_cant" class="fw-semibold text-danger"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="border rounded py-1 bg-body-tertiary">
                                <div class="small text-secondary">HC Aprobado</div>
                                <div id="lb_aprobado" class="fw-semibold text-primary"></div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="border rounded py-1 bg-body-tertiary">
                                <div class="small text-secondary">HC Actual</div>
                                <div id="lb_real" class="fw-semibold text-success"></div>
                            </div>
                        </div>
                    </div>                   

                    <div class="row g-2 mb-2 small">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary mb-0">Género</label>
                            <input id="lb_genero" class="form-control form-control-sm" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary mb-0">Rango de edad</label>
                            <input id="lb_edad" class="form-control form-control-sm" readonly>
                        </div>
                    </div>

                    <div class="mb-2 small">
                        <label class="form-label fw-semibold text-secondary mb-0">Motivo de la solicitud</label>
                        <div class="input-group input-group-sm">
                            <input id="lb_motivo" class="form-control form-control-sm" readonly>
                            <span id="lb_doc_aut" class="input-group-text bg-body border-start fw-semibold text-primary">
                                <i class="fa-solid fa-file-signature me-1"></i> Autorización
                            </span>
                        </div>
                    </div>
                    <!-- Rango salarial -->
                    <div class="col-12 mb-2 small">
                        <label class="form-label text-secondary fw-semibold mb-0">Rango salarial</label>
                        <div class="row g-2">
                            <div class="col-sm-4">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light fw-bold text-secondary">Mínimo</span>
                                <input type="number" class="form-control" id="salario_min" min="0" placeholder="0.00" readonly>
                                <span class="input-group-text">$</span>
                            </div>
                            </div>
                            <div class="col-sm-4">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light fw-bold text-secondary">Máximo</span>
                                <input type="number" class="form-control" id="salario_max" min="0" placeholder="0.00" readonly>
                                <span class="input-group-text">$</span>
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2 small">
                        <label class="form-label fw-semibold text-secondary mb-0">Requisitos imprescindibles para la contratación</label>
                        <textarea id="lb_coment" class="form-control form-control-sm" rows="2" readonly></textarea>
                    </div>

                    <div class="text-end small text-primary fst-italic d-flex justify-content-end align-items-end">
                        <div>
                            <i class="fa-solid fa-user-pen me-1"></i> Solicitado por:
                           <span id="lb_por" class="fw-semibold"></span>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer bg-body-tertiary py-2 px-3 justify-content-between" id="footer_solicitud">                    
                    <div class="text-start">
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="su(4)" id="bto_rechaza">
                            <i class="fa-solid fa-xmark me-1"></i> Rechazar solicitud
                        </button>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-sm btn-primary" onclick="su(2)" id="bto_guarda">
                            <i class="fa-solid fa-check-double me-1"></i> Aprobar solicitud
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                            <i class="fa-solid fa-arrow-left me-1"></i> Cerrar
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Rechaza vacantes-->
    <div class="modal fade" id="Modal_del" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow-lg rounded-3 overflow-hidden">

                <!-- Header -->
                <div class="modal-header bg-light text-white py-2">
                    <h5 class="modal-title fw-semibold mb-0 text-danger">
                    <i class="fas fa-ban me-2"></i> Rechazar Solicitud
                    </h5>
                    <button type="button" class="btn-close btn-close-secondary" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body px-4 py-3 bg-white">
                    <form class="needs-validation" novalidate>
                    
                    <div class="row mb-2 align-items-center">
                        <label class="col-sm-4 col-form-label-sm text-secondary fw-semibold"># Solicitud:</label>
                        <div class="col-sm-4">
                        <span id="lb_id_sol_rech" class="fw-bold text-dark"></span>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label class="col-sm-4 col-form-label-sm text-secondary fw-semibold">Posición:</label>
                        <div class="col-sm-8">
                        <input id="lb_nom_posicion_sol_rech" class="form-control form-control-sm bg-white" type="text" disabled readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label-sm text-secondary fw-semibold">Cantidad:</label>
                        <div class="col-sm-3">
                        <input id="lb_cant_rech" class="form-control form-control-sm bg-white" type="text" disabled readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">
                        Motivo del rechazo
                        </label>
                        <textarea class="form-control form-control-sm shadow-sm" id="txt_area_observacion" name="txt_area_observacion" rows="3" placeholder="Describe brevemente el motivo..."></textarea>
                    </div>

                    <div class="alert alert-warning py-2 mb-0 small d-flex align-items-center">
                        <i class="fas fa-info-circle me-2"></i>
                        <span><strong>Nota:</strong> El solicitante será notificado del rechazo.</span>
                    </div>
                    </form>
                </div>

                <!-- Footer -->
                <div class="modal-footer bg-white border-0 py-2 d-flex justify-content-end">
                    <button type="button"
                    onclick="$('#Modal_del').modal('hide');$('#modalsoli').modal('show');"
                    class="btn btn-outline-secondary btn-sm px-3">
                    <i class="fa-solid fa-arrow-left me-1"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-danger btn-sm px-3 shadow-sm" onclick="re(4)" id="bto_guarda">
                    <i class="fas fa-ban me-1"></i> Rechazar
                    </button>
                </div>

            </div>
        </div>
    </div>

        
    <!-- Modal Reasignar Reclutador -->
    <div class="modal fade" id="Modal_recuiter" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow-sm">
                <!-- HEADER -->
                <div class="modal-header bg-white border-bottom py-2 px-3">
                    <h6 class="modal-title fw-semibold text-primary mb-0">
                        <i class="fa-solid fa-people-arrows me-2 text-primary"></i><span id="titulo_relutador">Reasignar Reclutador</span>
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <!-- BODY -->
                <div class="modal-body px-4 py-3">
                    <form id="form_reasignar">
                        <input type="hidden" id="id_ofl_reasig_reclu" value="">
                        <div class="mb-3" id="anterior_relutador">
                            <label class="form-label small text-secondary mb-1">Reclutador actual</label>
                            <input id="lb_nom_reclutador_ant" class="form-control form-control-sm" type="text" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="nuevo_reclutador" class="form-label small text-secondary mb-1"><span id="lb_nombre_reclutador">Nuevo reclutador</span></label>
                            <select id="nuevo_reclutador" class="form-select form-select-sm">
                                <option value="0" class="text-muted" selected>Seleccione</option>
                                @foreach($data_reclutadores as $reclutadores)
                                    <option value="{{ $reclutadores->id }}">
                                        {{ $reclutadores->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="alert alert-light border-start border-info py-2 mb-0 small">
                            <i class="fa-solid fa-circle-info text-info me-2"></i>
                            El nuevo reclutador recibirá notificación automática.
                        </div>
                    </form>
                </div>

                <!-- FOOTER -->
                <div class="modal-footer bg-light border-0 py-2 px-3">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fa-solid fa-arrow-left me-1"></i>Cancelar
                    </button>
                    <button type="button" class="btn btn-sm btn-primary" id="bto_reasignar" onclick="reasignarReclutador()">
                        <span id="spinner_reasignar" class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>
                        <span id="text_reasignar"><i class="fa-solid fa-people-arrows me-1"></i>Asignar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal add_candidato-->
    <div class="modal fade" id="modal_add_candidato" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header py-2 bg-light">
                    <h5 class="modal-title fs-5 text-primary" id="staticBackdropLabel"><i
                            class="fa-solid fa-user-plus pe-1"></i> Agregar Candidato</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-3">
                            <select class="form-select" id="sel_f_by" onchange="filterby(this.value)">
                                <option selected value="0">Filtrar por</option>
                                <option value="1">Email</option>
                                <option value="2">Área de Experiencia</option>
                            </select>

                            <input type="hidden" id="id_ofl" value="">
                        </div>
                        <div class="col-4">
                            <span id="id_find_email" class="d-none">
                                <input type="email" class="form-control" id="mail" name="mail" placeholder="email@ejemplo.com">
                            </span>
                            <span id="id_find_area" class="d-none">
                                <select class="form-select" id="sel_area">
                                    <option selected value="0">Seleccionar área de experiencia</option>
                                    @foreach ($data_areas as $area)
                                        <option value="{{ $area->id }}">{{ $area->area }}</option>
                                    @endforeach
                                </select>
                            </span>
                        </div>
                        <div class="col-2 my-0 py-0 align-items-center justify-content-end" id="bto_f"
                            class="d-none">
                            <button type="button" class="btn btn-primary py-1" onclick="find_candidate()"><i class="fa-solid fa-filter pe-1"></i>Listar</button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <table id="MyTable" class="mt-4 table table-hover" style="width:100%">
                                <thead class="table-primary">
                                    <tr>
                                        <th class="text-center text-secondary" style="background:#a7c7f8;"></th>
                                        <th class="text-center text-secondary" style="background:#a7c7f8;">Nombre</th>
                                        <th class="text-center text-secondary" style="background:#a7c7f8;">Profesión</th>
                                        <th class="text-center text-secondary" style="background:#a7c7f8;">Experiencia</th>
                                        <th class="text-center text-secondary" style="background:#a7c7f8;">CV</th>
                                        <th class="text-center text-secondary" style="background:#a7c7f8;">Procesos Asociados</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer py-1 bg-light">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pe-1"></i>Cancelar</button>
                    <button type="button" class="btn btn-sm btn-success" onclick="agregarCandidatosSeleccionados()"><i class="fa-solid fa-plus pe-1"></i>Agregar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal CALCE -->
    <div class="modal fade" id="modal-calce" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-light py-2 text-primary">
                    <h5 class="modal-title" id="staticBackdropLabel"><i class="fa-solid fa-list-check fa-lg"></i> Calce</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="row px-4">
                            <div class="col-12" id="nom_puesto_calce"></div>
                            <span class=" mt-0 text-primary small" id="jerarquia_calce"></span>
                            <hr>

                        </div> 
                        <div class="col-10" id="div_calce">   
                            
                            <div class="row">
                                <div class="col-12 text-center">
                                   <div class="col-12" id="calce_total"></div>
                                </div>
                            </div>                        
                            <div class="row small pb-1">
                                <div class="col-4 text-center fw-bold"style="color: #4B6EAD">CRÍTICAS</div>
                                <div class="col-4 text-center fw-bold"style="color: #4B6EAD">MUY IMPORTANTES</div>
                                <div class="col-4 text-center fw-bold"style="color: #4B6EAD">IMPORTANTES</div>
                            </div>
                            <div class="row">
                                <div class="col-4" id="comp_cri"></div>
                                <div class="col-4" id="comp_mimp"></div>
                                <div class="col-4" id="comp_imp"></div>
                            </div> 
                            <div id="container_area">

                            </div>
                            
                        </div>
                    </div>
                </div>
        <div class="modal-footer bg-light py-1">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cerrar</button>
        </div>
            </div>
        </div>
    </div>

    <!-- Modal referencia personal -->
    <div class="modal fade" id="modal-ref-personal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-light py-2 text-primary">
                    <h5 class="modal-title" id="staticBackdropLabel"><i class="fa-solid fa-list-check fa-lg"></i> Validación de Referencia Personal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3 ms-2 mb-3">
                        <div class="col-md-6">
                            <span class="text-secondary">Señor(a): </span>
                            <span id="lb_nombre_ref_p" class="text-secondary fw-semibold"></span>
                            <input id="id_ref_p" type="hidden">
                        </div>
                        <div class="col-md-6">
                            <span class="text-secondary">Tel: </span>
                            <span id="lb_tel_ref_p" class="text-secondary fw-semibold"></span>
                        </div>
                    </div>
                    <div class="row g-3 ms-4 mb-3">
                        <div class="col-md-12">
                            <span class="text-secondary"><i class="fas fa-asterisk text-danger fa-2xs"></i> ¿Cuál es el vínculo de usted con <span class="text-primary" id="candidato_p1"></span>?</span>
                            <input type="text" style="width: 400px" class="form-control form-control-sm" id="validacion_ref_p_vinculo" val=''>
                        </div>
                    </div>
                    <div class="row g-3 ms-4 mb-3">
                        <div class="col-md-12">
                            <span class="text-secondary"><i class="fas fa-asterisk text-danger fa-2xs"></i> ¿Cómo describe la forma de ser de <span class="text-primary" id="candidato_p2"></span>?</span>
                            <input type="text" style="width: 400px"  class="form-control form-control-sm" id="validacion_ref_p_formardeser" val=''>
                        </div>
                    </div>

                    <div class="fw-semibold text-secondary small">Conductas a Evaluar</div>
                    <hr class="mb-3 mt-1">
                    <div class="row justify-content-center">
                        <div class="col-md-10">        
                        
                            <div class="row g-3 ms-2 mb-2">
                                <div class="col-md-8">                            
                                    <span class="text-secondary">¿Mantiene relaciones sociales sanas?</span>
                                </div>
                                <div class="col-md-auto">
                                    <input class="form-check-input" type="radio" name="relaciones_ref_p" id="relaciones_ref_p_s" value="s">
                                    <label class="form-check-label" for="relaciones_ref_p_s"> Si </label>
                                </div>
                                <div class="col-md-auto">
                                    <input class="form-check-input" type="radio" name="relaciones_ref_p" id="relaciones_ref_p_n" value="n" checked>
                                    <label class="form-check-label" for="relaciones_ref_p_n"> No </label>
                                </div>
                            </div>
                            
                            <div class="row g-3 ms-2 mb-2">
                                <div class="col-md-8">                            
                                    <span class="text-secondary">¿Lo considera responsable?</span>
                                </div>
                                <div class="col-md-auto">
                                    <input class="form-check-input" type="radio" name="responsable_ref_p" id="responsable_ref_p_s" value="s">
                                    <label class="form-check-label" for="responsable_ref_p_s"> Si </label>
                                </div>
                                <div class="col-md-auto">
                                    <input class="form-check-input" type="radio" name="responsable_ref_p" id="responsable_ref_p_n" value="n" checked>
                                    <label class="form-check-label" for="responsable_ref_p_n"> No </label>
                                </div>
                            </div>
                            
                            <div class="row g-3 ms-2 mb-2">
                                <div class="col-md-8">                            
                                    <span class="text-secondary">¿Lo considera cortés?</span>
                                </div>
                                <div class="col-md-auto">
                                    <input class="form-check-input" type="radio" name="cortes_ref_p" id="cortes_ref_p_s" value="s">
                                    <label class="form-check-label" for="cortes_ref_p_s"> Si </label>
                                </div>
                                <div class="col-md-auto">
                                    <input class="form-check-input" type="radio" name="cortes_ref_p" id="cortes_ref_p_n" value="n" checked>
                                    <label class="form-check-label" for="cortes_ref_p_n"> No </label>
                                </div>
                            </div>
                            
                            <div class="row g-3 ms-2 mb-2">
                                <div class="col-md-8">                            
                                    <span class="text-secondary">¿Lo considera cooperador?</span>
                                </div>
                                <div class="col-md-auto">
                                    <input class="form-check-input" type="radio" name="cooperador_ref_p" id="cooperador_ref_p_s" value="s">
                                    <label class="form-check-label" for="cooperador_ref_p_s"> Si </label>
                                </div>
                                <div class="col-md-auto">
                                    <input class="form-check-input" type="radio" name="cooperador_ref_p" id="cooperador_ref_p_n" value="n" checked>
                                    <label class="form-check-label" for="cooperador_ref_p_n"> No </label>
                                </div>
                            </div>
                            
                            <div class="row g-3 ms-2 mb-2">
                                <div class="col-md-8">                            
                                    <span class="text-secondary">¿Ha tenido problemas de honestidad?</span>
                                </div>
                                <div class="col-md-auto">
                                    <input class="form-check-input" type="radio" name="honestidad_ref_p" id="honestidad_ref_p_s" value="s">
                                    <label class="form-check-label" for="honestidad_ref_p_s"> Si </label>
                                </div>
                                <div class="col-md-auto">
                                    <input class="form-check-input" type="radio" name="honestidad_ref_p" id="honestidad_ref_p_n" value="n" checked>
                                    <label class="form-check-label" for="honestidad_ref_p_n"> No </label>
                                </div>
                            </div>
                            
                            <div class="row g-3 ms-2 mb-2">
                                <div class="col-md-8">                            
                                    <span class="text-secondary">¿Si tuviera un negocio propio lo contrataría?</span>
                                </div>
                                <div class="col-md-auto">
                                    <input class="form-check-input" type="radio" name="contrataria_ref_p" id="contrataria_ref_p_s" value="s">
                                    <label class="form-check-label" for="contrataria_ref_p_s"> Si </label>
                                </div>
                                <div class="col-md-auto">
                                    <input class="form-check-input" type="radio" name="contrataria_ref_p" id="contrataria_ref_p_n" value="n" checked>
                                    <label class="form-check-label" for="contrataria_ref_p_n"> No </label>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="row g-3 ms-4 mb-3 mt-3">
                        <div class="col-md-12">
                            <span class="text-secondary"><i class="fas fa-asterisk text-danger fa-2xs"></i> ¿Por qué?</span>
                            <textarea class="form-control form-control-sm" id="validacion_ref_p_porq" rows="2"></textarea>
                        </div>
                    </div>
                    <div id="info_validador_ref_p" class="alert alert-info d-none mt-2 small">
                        Validado por: <span id="validador_nombre_ref_p"></span><br>
                        Fecha: <span id="validador_fecha_ref_p"></span>
                    </div>
                </div>
                <div class="modal-footer bg-light py-1">
                    <span id="alert_ref_p" class="alert alert-danger py-1 d-none" role="alert"><i class="fa-solid fa-triangle-exclamation"></i> Por favor llenar los campos necesarios</span>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cerrar</button>
                    <button id="btn_add_ref_p" type="button" class="btn btn-primary btn-sm" onclick="guardar_ref_personal('p')"><i class="fa-solid fa-save pr-2"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal referencia laboral -->
    <div class="modal fade" id="modal-ref-laboral" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-light py-2 text-primary">
                    <h5 class="modal-title" id="staticBackdropLabel"><i class="fa-solid fa-list-check fa-lg"></i> Validación de Referencia Laboral</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">                    
                    <div class="row g-3 ms-2 mb-3">
                        <div class="col-md-6">
                            <span class="text-secondary">Empresa: </span>
                            <span id="lb_nombre_ref_l" class="text-secondary fw-semibold"></span>
                            <input id="id_ref_l" type="hidden">
                        </div>
                        <div class="col-md-6">
                            <span class="text-secondary">Tel: </span>
                            <span id="lb_tel_ref_l" class="text-secondary fw-semibold"></span>
                        </div>
                    </div>

                    <div class="row g-3 ms-4 mb-3">
                        <div class="col-md-12">
                            <span class="text-secondary"><i class="fas fa-asterisk text-danger fa-2xs"></i> ¿Periodo o cantidad de años en el que <span class="text-primary" id="candidato_l1"></span> laboró en la empresa?</span>
                            <input type="text" style="width: 100px" class="form-control form-control-sm" id="validacion_ref_l_periodo">
                        </div>
                    </div>

                    <div class="row g-3 ms-4 mb-3">
                        <div class="col-md-12">
                            <span class="text-secondary"><i class="fas fa-asterisk text-danger fa-2xs"></i> ¿Motivo de salida de <span class="text-primary" id="candidato_l2"></span> de la empresa?</span>
                            <input type="text" style="width: 400px"  class="form-control form-control-sm" id="validacion_ref_l_motivo_salida" val=''>
                        </div>
                    </div>

                    
                   
                    <div class="fw-semibold text-secondary small">Conductas a Evaluar</div>
                    <hr class="mb-3 mt-1">
                    <div class="row justify-content-center">
                        <div class="col-md-10">                                    
                            <div class="row g-3 ms-2 mb-2">
                                <table class="table mt-4 table-borderless m-0 p-0">
                                    <tbody>
                                        <tr>
                                            <td class="text-secondary">Relación con Jefes Inmediatos</td>
                                            <td class="align-middle text-center text-secondary"><input class="form-check-input" type="radio" name="reljefe_ref_l" id="reljefe_ref_l_4" value="4">
                                                <label class="form-check-label small" for="reljefe_ref_l_4">Excelente</label></td>
                                            <td class="align-middle text-center text-secondary"><input class="form-check-input" type="radio" name="reljefe_ref_l" id="reljefe_ref_l_3" value="3">
                                                <label class="form-check-label small" for="reljefe_ref_l_3">Bueno</label></td>
                                            <td class="align-middle text-center text-secondary"><input class="form-check-input" type="radio" name="reljefe_ref_l" id="reljefe_ref_l_2" value="2">
                                                <label class="form-check-label small" for="reljefe_ref_l_2">Regular</label></td>
                                            <td class="align-middle text-center text-secondary"><input class="form-check-input" type="radio" name="reljefe_ref_l" id="reljefe_ref_l_1" value="1" checked>
                                                <label class="form-check-label small" for="reljefe_ref_l_1">Deficiente</label></td>
                                        </tr>
                                        <tr>
                                            <td class="text-secondary">Relación con Compañeros</td>
                                            <td class="align-middle text-center text-secondary"><input class="form-check-input" type="radio" name="relcompa_ref_l" id="relcompa_ref_l_4" value="4">
                                                <label class="form-check-label small" for="relcompa_ref_l_4">Excelente</label></td>
                                            <td class="align-middle text-center text-secondary"><input class="form-check-input" type="radio" name="relcompa_ref_l" id="relcompa_ref_l_3" value="3">
                                                <label class="form-check-label small" for="relcompa_ref_l_3">Bueno</label></td>
                                            <td class="align-middle text-center text-secondary"><input class="form-check-input" type="radio" name="relcompa_ref_l" id="relcompa_ref_l_2" value="2">
                                                <label class="form-check-label small" for="relcompa_ref_l_2">Regular</label></td>
                                            <td class="align-middle text-center text-secondary"><input class="form-check-input" type="radio" name="relcompa_ref_l" id="relcompa_ref_l_1" value="1" checked>
                                                <label class="form-check-label small" for="relcompa_ref_l_1">Deficiente</label></td>
                                        </tr>
                                        <tr>
                                            <td class="text-secondary">Puntualidad</td>
                                            <td class="align-middle text-center text-secondary"><input class="form-check-input" type="radio" name="puntualidad_ref_l" id="puntualidad_ref_l_4" value="4">
                                                <label class="form-check-label small" for="puntualidad_ref_l_4">Excelente</label></td>
                                            <td class="align-middle text-center text-secondary"><input class="form-check-input" type="radio" name="puntualidad_ref_l" id="puntualidad_ref_l_3" value="3">
                                                <label class="form-check-label small" for="puntualidad_ref_l_3">Bueno</label></td>
                                            <td class="align-middle text-center text-secondary"><input class="form-check-input" type="radio" name="puntualidad_ref_l" id="puntualidad_ref_l_2" value="2">
                                                <label class="form-check-label small" for="puntualidad_ref_l_2">Regular</label></td>
                                            <td class="align-middle text-center text-secondary"><input class="form-check-input" type="radio" name="puntualidad_ref_l" id="puntualidad_ref_l_1" value="1" checked>
                                                <label class="form-check-label small" for="puntualidad_ref_l_1">Deficiente</label></td>
                                        </tr>
                                        <tr>
                                            <td class="text-secondary">Problemas de Honestidad</td>
                                            <td class="align-middle text-center text-secondary"><input class="form-check-input" type="radio" name="honestidad_ref_l" id="honestidad_ref_l_s" value="s">
                                                <label class="form-check-label small" for="honestidad_ref_l_s">Si</label></td>
                                            <td class="align-middle text-center text-secondary"><input class="form-check-input" type="radio" name="honestidad_ref_l" id="honestidad_ref_l_n" value="n" checked>
                                                <label class="form-check-label small" for="honestidad_ref_l_n">No</label></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="text-secondary">Responsable</td>
                                            <td class="align-middle text-center text-secondary"><input class="form-check-input" type="radio" name="responsable_ref_l" id="responsable_ref_l_s" value="s">
                                                <label class="form-check-label small" for="responsable_ref_l_s">Si</label></td>
                                            <td class="align-middle text-center text-secondary"><input class="form-check-input" type="radio" name="responsable_ref_l" id="responsable_ref_l_n" value="n" checked>
                                                <label class="form-check-label small" for="responsable_ref_l_n">No</label></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="text-secondary">Cooperador</td>
                                            <td class="align-middle text-center text-secondary"><input class="form-check-input" type="radio" name="cooperador_ref_l" id="cooperador_ref_l_s" value="s">
                                                <label class="form-check-label small" for="cooperador_ref_l_s">Si</label></td>
                                            <td class="align-middle text-center text-secondary"><input class="form-check-input" type="radio" name="cooperador_ref_l" id="cooperador_ref_l_n" value="n" checked>
                                                <label class="form-check-label small" for="cooperador_ref_l_n">No</label></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="text-secondary">Cortés</td>
                                            <td class="align-middle text-center text-secondary"><input class="form-check-input" type="radio" name="cortes_ref_l" id="cortes_ref_l_s" value="s">
                                                <label class="form-check-label small" for="cortes_ref_l_s">Si</label></td>
                                            <td class="align-middle text-center text-secondary"><input class="form-check-input" type="radio" name="cortes_ref_l" id="cortes_ref_l_n" value="n" checked>
                                                <label class="form-check-label small" for="cortes_ref_l_n">No</label></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="text-secondary">¿Lo contrataria nuevamente?</td>
                                            <td class="align-middle text-center text-secondary"><input class="form-check-input" type="radio" name="locontrataria_ref_l" id="locontrataria_ref_l_s" value="s">
                                                <label class="form-check-label small" for="locontrataria_ref_l_s">Si</label></td>
                                            <td class="align-middle text-center text-secondary"><input class="form-check-input" type="radio" name="locontrataria_ref_l" id="locontrataria_ref_l_n" value="n" checked>
                                                <label class="form-check-label small" for="locontrataria_ref_l_n">No</label></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>                                                        
                        </div>
                    </div>
                    
                    <div class="row g-3 ms-2 mb-3 mt-3">
                        <div class="col-md-12">
                            <span class="text-secondary">Observación:</span><br>
                            <textarea class="form-control form-control-sm" id="validacion_ref_l_obs" name="validacion_ref_l_obs" rows="2"></textarea>
                        </div>
                    </div>
                    Referencias de Recursos Humanos:<br>
                    <div class="row g-3 ms-2 mb-3">
                        <div class="col-md-6">
                            <span class="text-secondary"><i class="fas fa-asterisk text-danger fa-2xs"></i> Nombre:</span><br>
                            <input class="form-control form-control-sm" id="referencias_por" name="referencias_por" type="text">
                        </div>
                        <div class="col-md-6">
                            <span class="text-secondary"><i class="fas fa-asterisk text-danger fa-2xs"></i> Puesto:</span><br>
                            <input class="form-control form-control-sm" id="referencias_puesto_por" name="referencias_puesto_por" type="text">
                        </div>
                    </div>
                    <div id="info_validador_ref_l" class="alert alert-info d-none mt-2 small">
                        Validado por: <span id="validador_nombre_ref_l"></span><br>
                        Fecha: <span id="validador_fecha_ref_l"></span>
                    </div>
                </div>
                <div class="modal-footer bg-light py-1">
                    <span id="alert_ref_l" class="alert alert-danger py-1 d-none" role="alert"><i class="fa-solid fa-triangle-exclamation"></i> Por favor llenar los campos necesarios</span>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cerrar</button>
                    <button id="btn_add_ref_l" type="button" class="btn btn-primary btn-sm" onclick="guardar_ref_personal('l')"><i class="fa-solid fa-save pr-2"></i> Guardar</button>
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

    <!-- Modal add OBSERVACIÓN TERNA-->
    <div class="modal fade" id="modalOBSTerna" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalOBSTerna" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-light text-primary py-1">
                    <h5 class="modal-title" id="modalOBSTernaLabel">Observaciones del candidato</h5>
                    <input type="hidden" id="id_curriOBSTerna">
                    <input type="hidden" id="id_partOBSTerna">
                    <button type="button" class="btn-close btn-close-secondary" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body p-2">
                    <div class="my-3 px-4">
                        <label class="form-label form-label-sm text-secondary mb-3">
                            Redacte una descripción del candidato resaltando los aspectos clave que deben ser comunicados al entrevistador, tales como su experiencia profesional más relevante, formación académica, habilidades técnicas o blandas destacadas, etc.
                        </label>
                        <span class="fw-semibold text-primary">CONCEPTO DE LA DIRECCIÓN DE GENTE Y ORGANIZACIÓN</span>
                        <input id="OBSterna" type="hidden" name="OBSterna">
                        <trix-editor input="OBSterna" id="editor-OBSterna"></trix-editor>
                    </div>
                </div>
                
                <div class="modal-footer bg-light py-1">
                    <span id="alert_ref_terna" class="alert alert-danger py-1 d-none" role="alert"><i class="fa-solid fa-triangle-exclamation"></i> Por favor llenar los campos necesarios</span>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cerrar</button>
                    <button type="button" class="btn btn-primary btn-sm" onclick="guardar_obs_terna()"><i class="fa-solid fa-save pr-2"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal SEND TERNA-->
    <div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
            <form id="emailForm">
                @csrf
                <div class="modal-header bg-light py-1">
                <h5 class="modal-title text-primary" id="emailModalLabel">Enviar Terna</h5>
                    <button type="button" class="btn-close btn-close-secondary" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    
                    <!-- Destinatario -->
                    <div class="mb-2">
                        <span class="text-secondary">Para</span><br>
                        <input type="email" class="form-control form-control-sm" id="toEmail" name="to" required>
                    </div>
                    
                    <!-- Asunto -->
                    <div class="mb-2">
                        <span class="text-secondary">Asunto: </span>
                        <input type="text" class="form-control form-control-sm" id="subject" name="subject" required>
                    </div>

                    <!-- Mensaje enriquecido -->
                    <div class="mb-2">
                        <span class="text-secondary">Mensaje</span><br>
                        <small>
                            <input id="send_OBSterna" type="hidden" name="send_OBSterna">
                            <trix-editor input="send_OBSterna"></trix-editor> 
                        </small>
                    </div>                      
                </div>
                <div class="modal-footer bg-light py-1">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cerrar</button>
                    <button id="btn_enviar" type="button" class="btn btn-primary btn-sm" onclick="enviar_terna(event)"><i class="fa-solid fa-share"></i> Enviar</button>
                    <button id="btn_enviando" type="button" class="btn btn-secondary btn-sm d-none" ><i class="fa-solid fa-rotate fa-spin-pulse"></i> Enviando</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- MODAL DESCARTAR -->
    <div class="modal fade" id="ModalDeclinar" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light text-secondary py-1">
                    <h5 class="modal-title text-danger" id="exampleModalLabel"><i class="fa-solid fa-user-xmark pe-1"></i> Descartar candidato</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input id="id_curri_declinar" type="hidden" value="">
                    <input id="id_part_declinar" type="hidden" value="">
                    <div class="row py-3">
                        <div class="col">
                            <span class="text-secondary">Indicar la razón por la cual está descartando al candidato</span>

                            <select class="form-select form-select-sm" aria-label="Small select example" id="motivo_declinar" name="motivo_declinar">
                            <option selected>Seleccionar motivo</option>
                            <option value="1">Resultados de Veritas</option>
                            <option value="2">Resultados de APL</option>
                            <option value="3">Resultados del poligrafo</option>
                            <option value="4">Por Record policivo</option>
                            <option value="5">Malas referencias laborales</option>
                            <option value="6">Malas referencias personales</option>
                            <option value="7">No cumple con el perfil</option>
                            <option value="8">No se presentó a la entrevista</option>
                            <option value="9">Otra</option>
                        </select></br>
                            Por favor detallar</br>
                            <textarea class="form-control form-control-sm" id="obs_declinar" name="obs_declinar" rows="3"></textarea>                    
                        </div>                  
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 text-start">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="s" id="chk_descarta_bd" name="chk_descarta_bd" onchange="toggleDescartarLabel(this)">
                                <label class="form-check-label text-secondary" id="lbl_descarta_bd" for="chk_descarta_bd"> Descartar de futuras búsquedas y ofertas.</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer py-1 bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pe-2"></i> Cancelar</button>
                    <button id="btn_enviar_declinar" type="button" class="btn btn-danger btn-sm" onclick="saveDescarte()"style="display: block"><i class="fa-solid fa-user-xmark fa-lg pe-2"></i>Descartar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL NUEVA ENTREVISTA-->
    <div class="modal fade" id="modalEntrevista" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalEntrevista" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light text-primary py-2">
                    <h5 class="modal-title" id="modalEntrevista"><i class="fa-solid fa-calendar-plus"></i> Entrevista Funcional</h5>
                    <button type="button" class="btn-close btn-close-secondary" data-bs-dismiss="modal" onclick="ajusta_num()" aria-label="Cerrar"></button>
                </div>
                    <div class="modal-body">                               
                        <div class=" mt-2 d-none" id="div_spinner_entrevista_new">
                            <div class="d-flex justify-content-center align-items-center" style="height: 20vh;">
                                <div class="spinner-border text-primary me-2" role="status"></div>
                                <span>Enviando...</span>
                            </div>
                        </div> 
                        <div class="pt-2" id="div_entrevista_new">
                            <input type="hidden" id="id_entrevista" value="0">
                            <input type="hidden" id="num_update" value="0">
                            <div class="row mb-2">
                                <div class="col-6">
                                    Fecha de entrevista:</br>
                                    <input type="date" id="fecha_entrevista_new" name="fecha_entrevista" class="form-control form-control-sm">
                                </div>
                                <div class="col-6">
                                    Hora:</br>
                                    <input type="time" id="hora_entrevista_new" name="hora_entrevista" class="form-control form-control-sm" value="">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    Entrevistador:</br>
                                    <input type="email" id="email_entrevistador_new" name="email_entrevistador" class="form-control form-control-sm" value="">
                                </div>
                                <div class="col-12 text-start pe-0">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="s" id="chk_opt_contrata_new" name="chk_opt_contrata_new" checked>
                                        <label class="form-check-label text-primary" for="chk_opt_contrata_new">
                                            Muestra las opciones de mantener en Espera, Declinar o Contratar al candidato.
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="s" id="chk_opt_preguntas_entrevistas" name="chk_opt_preguntas_entrevistas" checked>
                                        <label class="form-check-label text-primary" for="chk_opt_preguntas_entrevistas">
                                            Habilitar en esta entrevista las preguntas según el descriptivo de funciones.
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    lugar de la entrevista:<br>
                                    <input type="text" id="lugar_entrevista_new" name="lugar_entrevista" class="form-control form-control-sm" value="">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    Comentarios:</br>
                                    <textarea id="comentarios_entrevista_funcional_new" name="comentarios_entrevista_funcional" rows="2" class="form-control form-control-sm"> </textarea>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-8 text-start">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="s" id="chk_agenda_entrevista_new" name="chk_agenda_entrevista_new" checked>
                                        <label class="form-check-label text-primary" for="chk_agenda_entrevista_new">
                                            Enviar agenda de entrevista al candidato y al entrevistador
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light py-1 text-end">
                        <button type="button" class="btn btn-sm btn-success" onclick="saveentrevista()"><i class="fas fa-save fa-lg pe-2"></i>Guardar</button>
                    </div>
                </div>
            </div>
    </div>
    
    <!-- Modal NUEVA CARTA OFERTA-->
    <div class="modal fade" id="modalCartaOferta" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalCartaOferta" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-light text-primary py-1">
                    <h5 class="modal-title"><i class="fa-solid fa-file-signature fa-lg pe-1"></i>Carta de Oferta laboral</h5>
                    <button type="button" class="btn-close btn-close-secondary" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">   
                    <form id="form_carta_oferta">                           
                        <div class="row">                                        
                            <div class="col-12">
                                <div class="fw-semibold text-primary fs-6">Datos de la Compañía</div>
                                <hr class="mt-0">  
                                <!-- Datos de la compañia -->
                                <div class="mb-3 row">
                                    <div class="col-sm-6">
                                        <label for="sel_cia" class="form-label"><i class="fas fa-asterisk text-danger fa-2xs"></i> Compañía:</label>
                                        <select id="sel_cia" class="form-select form-select-sm" onchange="findceco(this.value,0)">
                                            <option value="0" class="text-muted" selected>Seleccione</option>
                                            @foreach($data_pagadoras as $pagadora)
                                                <option value="{{ $pagadora->COD_PAGADORA }}">{{ $pagadora->COD_PAGADORA }} - {{ $pagadora->PAGADORA }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="sel_ceco" class="form-label"><i class="fas fa-asterisk text-danger fa-2xs"></i> Centro de costo:</label>
                                        <select id="sel_ceco" class="form-select form-select-sm" disabled></select>
                                    </div>
                                </div>
                                <!-- Propuesta Salarial -->
                                <div class="fw-semibold text-primary fs-6 mt-5">Propuesta Salarial</div>
                                <hr class="mt-0">
                                <div class="row g-3 px-4 align-items-center mb-3">
                                    <!-- Salario mensual -->
                                    <div class="col-md-4">
                                        <i class="fas fa-asterisk text-danger fa-2xs"></i> Salario Mensual:</br>
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <span class="input-group-text">$</span>
                                            <input type="number"class="form-control" id="salario_mensual" name="salario_mensual" placeholder="0.00" min="0.01" step="0.01" onchange="muestra_salario_hora()">
                                        </div>
                                    </div>

                                    <!-- Tipo de salario -->
                                    <div class="col-md-4">
                                        <i class="fas fa-asterisk text-danger fa-2xs"></i> Tipo de Salario:<br>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tipo_salario" id="salario_base_radio" value="B" checked onchange="muestra_salario_hora()">
                                            <label class="form-check-label" for="salario_base_radio">Sueldo Base</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tipo_salario" id="salario_hora_radio" value="H" onchange="muestra_salario_hora()">
                                            <label class="form-check-label" for="salario_hora_radio">Sueldo por hora</label>
                                        </div>
                                    </div>

                                    <!-- Salario por hora -->
                                    <div class="col-md-4 d-none" id="div_salario_hora">
                                        <i class="fas fa-asterisk text-danger fa-2xs"></i> Salario por hora:<br>                                                    
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" id="salario_hora" name="salario_hora" placeholder="0.00" min="0.01" step="0.01">
                                        </div>
                                    </div>
                                </div>
                                <!-- Tipo de contrato -->
                                <div class="row g-3 px-4 align-items-center mb-3">
                                    <div class="col-md-4">
                                        <i class="fas fa-asterisk text-danger fa-2xs"></i> Tipo de Contrato:<br>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tipo_contrato" id="contrato_permanente_radio" value="P" checked onchange="muestra_fecha_terminacion()">
                                            <label class="form-check-label" for="contrato_permanente_radio">Indefinido</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tipo_contrato" id="contrato_temporal_radio" value="T" onchange="muestra_fecha_terminacion()">
                                            <label class="form-check-label" for="contrato_temporal_radio">Definido</label>
                                        </div>
                                    </div>
                                                                
                                    <div class="col-md-4">
                                        <i class="fas fa-asterisk text-danger fa-2xs"></i> Fecha de Ingreso:</br>
                                        <div style="width: 150px;">
                                            <input id="fecha_inicio" name="fecha_inicio" class="form-control form-control-sm" type="date"> 
                                        </div>
                                    </div>

                                    <div class="col-md-4 d-none" id="div_fecha_terminacion">
                                        <i class="fas fa-asterisk text-danger fa-2xs"></i> Fecha de Terminación:</br>
                                        <div style="width: 150px;">
                                            <input id="fecha_terminacion" name="fecha_terminacion" class="form-control form-control-sm" type="date"> 
                                        </div>
                                    </div>
                                </div>                                                
                                <!-- Beneficios -->
                                <div class="fw-semibold text-primary fs-6 mt-5">Beneficios</div>
                                <hr class="mt-0">
                                <div class="px-4">
                                    <div class="row g-3" id="beneficios_container">
                                        <input type="hidden" id="num_beneficios" value="{{ count($data_beneficios) }}">
                                        @foreach ($data_beneficios as $beneficio)
                                            <div class="col-md-10">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="{{ $beneficio->id }}" id="{{ $beneficio->id }}_bcheck" onchange="toggleInput(this,'b')">
                                                            <label class="form-check-label" for="{{ $beneficio->id }}_bcheck">{{ $beneficio->beneficio }}</label>
                                                        </div>
                                                    </div>
                                                    @if($beneficio->tipo_dato !== null)
                                                        @php
                                                            $icono = '';
                                                            if ($beneficio->tipo_dato === 'dinero') {   $icono = '<span class="input-group-text">$</span>';} 
                                                            elseif ($beneficio->tipo_dato === 'porcen') {   $icono = '<span class="input-group-text">%</span>';}
                                                        @endphp
                                                        <div class="col-auto">
                                                            <div class="input-group input-group-sm d-none" style="width: 100px;">
                                                                {!! $icono !!}
                                                                <input type="number" class="form-control" id="{{ $beneficio->id }}_btxt" name="{{ $beneficio->id }}_btxt" placeholder="0.00" min="0.01" step="0.01">
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach             
                                    </div>
                                </div>                                                                                                    
                                <!-- Herramientas de trabajo -->
                                <div class="fw-semibold text-primary fs-6 mt-5">Herramientas de Trabajo</div>
                                <hr class="mt-0">                                                
                                <div class="px-4">
                                    <div class="row g-3" id="herramientas_container">
                                        <input type="hidden" id="num_herramientas" value="{{ count($data_herramientas) }}">
                                        @foreach ($data_herramientas as $beneficio)
                                            <div class="col-md-10">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="{{ $beneficio->id }}" id="{{ $beneficio->id }}_hcheck" onchange="toggleInput(this,'h')">
                                                            <label class="form-check-label" for="{{ $beneficio->id }}_hcheck">{{ $beneficio->beneficio }}</label>
                                                        </div>
                                                    </div>
                                                    @if($beneficio->tipo_dato !== null)
                                                        @php
                                                            $icono = '';
                                                            if ($beneficio->tipo_dato === 'dinero') {   $icono = '<span class="input-group-text">$</span>';} 
                                                            elseif ($beneficio->tipo_dato === 'porcen') {   $icono = '<span class="input-group-text">%</span>';}
                                                        @endphp
                                                        <div class="col-auto">
                                                            <div class="input-group input-group-sm d-none" style="width: 100px;">
                                                                {!! $icono !!}
                                                                <input type="number" class="form-control" id="{{ $beneficio->id }}_htxt" name="{{ $beneficio->id }}_htxt" placeholder="0.00" min="0.01" step="0.01">
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach             
                                    </div>
                                </div>
                                <div class="fw-semibold text-primary fs-6 mt-5">Plazo del Nombramiento</div>
                                <hr class="mt-0">                                                
                                <div class="px-4">
                                    <div class="row g-3" id="plazo_nombramiento">
                                        <input id="txt_plazo_nombramiento" type="hidden" name="txt_plazo_nombramiento" value="El presente contrato será por <strong>tiempo indefinido</strong>, con un <strong>periodo probatorio de tres (3) meses</strong>. Es entendido que la compañía podrá ofrecerle en el futuro, otra posición compatible con su carrera de servicios.">
                                        <trix-editor input="txt_plazo_nombramiento" id="editor-txt_plazo_nombramiento" class="trix-content" style="height: 100px;"></trix-editor>
                                    </div>
                                </div>
                                <!-- Firma de aprobación -->
                                <div class="fw-semibold text-primary fs-6 mt-5">Firma de aprobación</div>
                                <hr class="mt-0">
                                <div class="px-4">
                                    <div class="mb-3 row">
                                        <label for="sel_firmante" class="col-sm-auto col-form-label "><i class="fas fa-asterisk text-danger fa-2xs"></i> Firmante:</label>
                                        <div class="col-sm-auto">
                                            <select id="sel_firmante" class="form-select form-select-sm">
                                                <option value="0" class="text-muted" selected>Seleccione</option>
                                                @foreach($data_firmantes as $firmante)
                                                    <option value="{{ $firmante->id }}">
                                                        {{ $firmante->nombre }} - {{ $firmante->cargo }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>                                                                            
                                <div class="card-body mt-2 d-none" id="div_spinner_carta_oferta">
                                    <div class="d-flex justify-content-center align-items-center" style="height: 20vh;">
                                        <div class="spinner-border text-primary me-2" role="status"></div>
                                        <span>Generando Carta Oferta...</span>
                                    </div>
                                </div>                                            
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light py-1">
                    <span id="alert_cartaoferta" class="alert alert-danger py-1 d-none" role="alert"></span>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary btn-sm" onclick="crearCartaOferta()"><i class="fa-solid fa-file-signature pe-1"></i> Generar Carta Oferta</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal CARTA OFERTA ACEPTADA-->
    <div class="modal fade" id="modalAceptaCartaOferta" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalAceptaCartaOferta" aria-hidden="true">
        <div id="clase_modal" class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-light text-primary py-1  fs-5">
                    <h5 class="modal-title"><i class="fa-solid fa-signature fa-lg pe-1"></i>Carta de oferta firmada</h5>
                    <button type="button" class="btn-close btn-close-secondary" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body p-2">
                    <!-- SUBIR ARCHIVO -->
                    <div class="mb-3" id="div_adjuntar_carta">
                        Adjuntar carta oferta firmada por ambas partes:<br>   
                        <div id="input_name_docs_rp" class="input-group">                                            
                            <input class="form-control form-control-sm" id="carta_file" name="carta_pdf_file" type="file" accept="application/pdf">
                            <span class="input-group-text"><i class="fa-solid fa-file-pdf text-primary"></i></span>
                        </div>
                    </div>
                    <!-- VISTA PREVIA PDF -->
                    <div class="d-none" id="div_frame_carta">
                        <iframe id="pdfViewer_carta" src="" width="100%" height="432" frameborder="0"></iframe>
                    </div>   
                </div>
                <div class="modal-footer bg-light py-1">
                    <span id="alert_cartaoferta" class="alert alert-danger py-1 d-none" role="alert"></span>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cancelar</button>
                    <button type="button" id="bto_sube_carta" class="btn btn-primary btn-sm" onclick="upCartaOferta()"><i class="fa-solid fa-upload pe-1"></i> Adjuntar</button>
                    <button type="button" id="bto_save_carta" class="btn btn-success btn-sm d-none" onclick="saveCartaOfertafirmada()"><i class="fa-solid fa-floppy-disk pe-1"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal VALIDANDO PARA FIRMA DE CONTRATO-->
    <div class="modal fade" id="modalPaseaFirma" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalPaseaFirma" aria-hidden="true">
        <div id="clase_modal" class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content shadow-lg border-0 rounded-3">
            
            <!-- Header -->
            <div class="modal-header bg-primary text-white py-2">
                <h5 class="modal-title fw-semibold">
                <i class="fa-solid fa-signature fa-lg pe-2"></i>Datos para la Contratación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            
            <!-- Body -->
            <div class="modal-body p-4">
                
                <!-- Compañía / Centro de costo -->
                <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="sel_cia_firma" class="form-label fw-semibold text-secondary">Compañía</label>
                    <select id="sel_cia_firma" class="form-select form-select-sm" onchange="findceco(this.value,0)">
                    @foreach($data_pagadoras as $pagadora)
                        <option value="{{ $pagadora->COD_PAGADORA }}">{{ $pagadora->COD_PAGADORA }} - {{ $pagadora->PAGADORA }}</option>
                    @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="sel_ceco_firma" class="form-label fw-semibold text-secondary">Centro de costo</label>
                    <select id="sel_ceco_firma" class="form-select form-select-sm"></select>
                </div>
                <div class="col-md-6">
                    <strong class="text-secondary">Unidad:</strong><br>
                    <span id="lb_unidad_firma" class="text-muted"></span>
                </div>
                <div class="col-md-6">
                    <strong class="text-secondary">Puesto:</strong><br>
                    <span id="lb_puesto_firma" class="text-muted"></span>
                </div>
                </div>

                <!-- Datos del candidato -->
                <h6 class="fw-bold text-primary mt-3">Datos del Candidato</h6>
                <hr class="mt-1">

                <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <strong class="text-secondary">Nombre:</strong><br>
                    <span id="lb_nombre_firma" class="text-muted"></span>
                </div>
                <div class="col-md-4">
                    <strong class="text-secondary">Núm. de Identificación:</strong><br>
                    <span id="lb_num_identidad_firma" class="text-muted"></span>
                </div>
                <div class="col-md-4">
                    <strong class="text-secondary">No. de Seguro Social:</strong><br>
                    <span id="lb_num_ss_firma" class="text-muted"></span>
                </div>
                </div>

                <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <strong class="text-secondary">Tipo de Contrato:</strong><br>
                    <span id="lb_tipocontratofirma" class="text-muted"></span>
                </div>
                <div class="col-md-4">
                    <strong class="text-secondary">Fecha de Ingreso:</strong><br>
                    <span id="lb_fingreso_firma" class="text-muted"></span>
                </div>
                <div class="col-md-4">
                    <strong class="text-secondary">Fecha de Terminación:</strong><br>
                    <span id="lb_fsalida_firma" class="text-muted"></span>
                </div>
                </div>

                <div class="row g-3">
                <div class="col-md-4">
                    <strong class="text-secondary">Tipo de Salario:</strong><br>
                    <span id="lb_tiposalariofirma" class="text-muted"></span>
                </div>
                <div class="col-md-4">
                    <strong class="text-secondary">Salario Mensual:</strong><br>
                    <span id="lb_salariomensual_firma" class="text-muted"></span>
                </div>
                <div class="col-md-4">
                    <strong class="text-secondary">Rata por Hora:</strong><br>
                    <span id="lb_ratahora_firma" class="text-muted"></span>
                </div>
                </div>

                
                <div class="row g-3 mb-3 mt-4">
                <div class="col-md-4">
                    <strong class="text-secondary">Carta de Presentación Dirigida a:</strong><br>
                    <input class="form-control form-control-sm" type="text" id="txt_cartaafirma">
                </div>
                <div class="col-md-4">
                    <strong class="text-secondary">Registro de Marcación (Reloj):</strong><br>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="chk_marcacion_firma">
                        <label class="form-check-label" for="chk_marcacion_firma">
                            Si registra macaciones
                        </label>
                    </div>
                </div>
                </div>


                <div id="div_b" class="d-none">
                <!-- BENEFICIOS -->
                    <h6 class="fw-bold text-primary mt-3">Beneficios</h6>
                    <hr class="mt-1">
                    <ul id="list_b"> </ul>
                </div>

                <div id="div_h" class="d-none">
                <!-- HERRAMIENTAS -->
                    <h6 class="fw-bold text-primary mt-3">Herramientas</h6>
                    <hr class="mt-1">
                    <ul id="list_h"> </ul>
                </div>
                
                <!-- PRUENAS PSICOMÉTRICAS -->
                    <h6 class="fw-bold text-primary mt-3">Resultados de Prueba VERITAS</h6>
                    <hr class="mt-1">
                    <div class="row g-3">
                        <div class="col-md-4 ps-4">
                            <strong class="text-secondary">Resultado de prueba VERITAS:</strong><br>
                            <span id="lb_veritas" class="text-muted"></span>
                        </div>
                    </div>
                
                <!-- DOCUMENTACION -->
                    <h6 class="fw-bold text-primary mt-3">Documentos Adjuntos</h6>
                    <hr class="mt-1">
                    <ul id="tbodyDocs"> </ul>

            </div>
            
            <!-- Footer -->
            <div class="modal-footer bg-light py-2 " style="border-top: none;">
                <span id="alert_cartaofertafirma" class="alert alert-danger py-1 px-2 d-none" role="alert"></span>
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                <i class="fa-solid fa-arrow-left pe-1"></i>Cancelar
                </button>
                <button type="button" id="bto_save_carta" class="btn btn-success btn-sm" onclick="sendfirmaContrato()">
                    <i class="fa-solid fa-floppy-disk pe-1"></i>Enviar
                </button>
            </div>
            </div>
        </div>
    </div>
@endsection


<script type='text/javascript'>
    document.addEventListener('DOMContentLoaded', function() {
        const filtroItems = document.querySelectorAll('.filtro-item');
        const ofertas = document.querySelectorAll('.oflinfo');
        const filtroBtn = document.getElementById('filtroBtn');
        const divSinRegistro = document.getElementById('div_sin_registro');

        filtroItems.forEach(item => {
            item.addEventListener('click', function() {
                const idReclutador = this.getAttribute('data-id');
                
                // Cambiar texto del botón
                filtroBtn.innerHTML = '<i class="bi bi-funnel-fill me-2"></i>' + this.innerHTML.trim();

                let visibles = 0; // contador de ofertas mostradas

                // Mostrar / ocultar ofertas
                ofertas.forEach(oferta => {
                    const ofertaReclutador = oferta.getAttribute('data-reclutador');
                    let mostrar = false;

                    if (idReclutador === 'all') {
                        mostrar = true;
                    } else if (idReclutador === 'nothing') {
                        // Mostrar solo ofertas sin reclutador
                        if (!ofertaReclutador || ofertaReclutador === '0') {
                            mostrar = true;
                        }
                    } else {
                        if (ofertaReclutador === idReclutador) {
                            mostrar = true;
                        }
                    }

                    oferta.style.display = mostrar ? '' : 'none';
                    if (mostrar) visibles++;
                });

                // Mostrar u ocultar el mensaje "sin registro"
                if (visibles === 0) {
                    divSinRegistro.classList.remove('d-none');
                } else {
                    divSinRegistro.classList.add('d-none');
                }
            });
        });
    });


    function asigrecuiter(id_ofl,opt)
    {   $('#id_ofl_reasig_reclu').val(id_ofl);
        $('#lb_nom_reclutador_ant').val( $('#reclutador_' + id_ofl).text().trim());
        $('#Modal_recuiter').modal('show');
        $('#nuevo_reclutador').val(0);
        if(opt==1)
        {   $('#titulo_relutador').html('Reasignar Reclutador');
            $('#anterior_relutador').removeClass('d-none');
            $('#lb_nombre_reclutador').html('Nuevo Reclutador');
        }
        else
        {   $('#titulo_relutador').html('Asignar Reclutador');
            $('#anterior_relutador').addClass('d-none');
            $('#lb_nombre_reclutador').html('Reclutador');}
    }

    function reasignarReclutador() {
        const id_ofl = $('#id_ofl_reasig_reclu').val();
        const id_reclutador = $('#nuevo_reclutador').val();

        if (id_reclutador != 0) {
            const datos = {
                id_ofl,
                id_reclutador,
                _token: $('input[name="_token"]').val()
            };

            // Mostrar spinner y cambiar texto
            $('#spinner_reasignar').removeClass('d-none');
            $('#text_reasignar').text('Asignando...');

            $.ajax({
                url: "{{ route('ofertas.reasignarReclutador') }}",
                method: 'POST',
                data: datos,
                success: function (response) { 
                    // Ocultar spinner y restaurar texto
                    $('#spinner_reasignar').addClass('d-none');
                    $('#text_reasignar').html('<i class="fa-solid fa-people-arrows me-1"></i>Asignar');

                    if (!response.success) {
                        mal(response.message || 'Ocurrió un error al procesar la solicitud.');
                        return;
                    }

                    $('#Modal_recuiter').modal("hide");
                    bien('Reclutador reasignado correctamente.');

                    const reclutador = response.reclutador;
                    let htmlReclutador = '';

                    if (reclutador.foto) {
                        // Si tiene foto
                        htmlReclutador = `
                            <div class="d-inline-flex align-items-center ms-1">
                                <img src="${reclutador.foto}" 
                                    class="rounded-circle me-1" 
                                    style="width:24px;height:24px;object-fit:cover;border:1px solid #ccc; vertical-align:middle;">
                                <span class="text-primary fw-semibold" id="reclutador_` + id_ofl + `">${reclutador.prinombre} ${reclutador.priapellido}</span>
                            </div>
                        `;
                    } else {
                        // Si no tiene foto, mostrar iniciales
                        const iniciales = (reclutador.prinombre[0] ?? '') + (reclutador.priapellido[0] ?? '');
                        htmlReclutador = `
                            <div class="d-inline-flex align-items-center ms-1">
                                <span class="rounded-circle me-1 d-flex align-items-center justify-content-center"
                                    style="width:24px;height:24px;background:${reclutador.color_bg};
                                        color:${reclutador.color_text};font-size:11px;font-weight:bold;
                                        border:1px solid ${reclutador.color_text}">
                                    ${iniciales.toUpperCase()}
                                </span>
                                <span class="text-primary fw-semibold" id="reclutador_` + id_ofl + `">${reclutador.prinombre} ${reclutador.priapellido}</span>
                            </div>
                        `;
                    }

                    const reclutadores = response.reclutadores;
                    jQuery(reclutadores).each(function(i, item) {
                        $('#id_cantidad_badge_'+item.id).html(item.total_vacantes);
                    })
                    
                    $('#tot_vacantes_activas').html(response.stats.vacantes_activas); 
                    $('#tot_vacantes_asignadas').html(response.stats.vacantes_asignadas);
                    $('#tot_vacantes_sin_asignar').html(response.stats.vacantes_sin_asignar);
                    $('#tot_vacantes_del_mes').html(response.stats.vacantes_del_mes);

                    // Asignar el HTML al div
                    $('#div_nombre_reclutador_' + id_ofl).html(htmlReclutador);

                    // Actualizar también el data-reclutador del contenedor
                    $('#ofl_' + id_ofl).attr('data-reclutador', id_reclutador);
                },
                error: function(xhr, status, error) {
                    $('#spinner_reasignar').addClass('d-none');
                    $('#text_reasignar').html('<i class="fa-solid fa-people-arrows me-1"></i>Asignar');
                    mal('Ocurrió un error al procesar la solicitud.');
                }
            });
        }
    }

    function sendfirmaContrato()
    {   const carta_presentacion_input = document.getElementById('txt_cartaafirma');
        const carta_presentacion = carta_presentacion_input.value.trim();
        // Validación
            if (carta_presentacion === '') {
                $('#alert_cartaofertafirma')
                    .removeClass('d-none')
                    .html('<i class="fa-solid fa-triangle-exclamation"></i> Debe completar la carta de presentación.');
                carta_presentacion_input.focus();
                return; // Detiene la ejecución
            } else {
                $('#alert_cartaofertafirma').addClass('d-none');
            }

            const id_cartaoflacept = $('#file_cartaoflacept').val();
            const id_ofl = $('#id_ofl_glb').val();
            const id_curri = $('#reclutamiento_id_curri').val();
            const id_part = $('#reclutamiento_id_participante').val();
            const sel_cia_firma = $('#sel_cia_firma').val();
            const sel_ceco_firma = $('#sel_ceco_firma').val();
            const marcacion = document.getElementById('chk_marcacion_firma').checked ? 1 : 0;

        const datos = {
            id_cartaoflacept,
            carta_presentacion,
            id_ofl,
            id_curri,
            id_part,
            marcacion,
            sel_cia_firma,
            sel_ceco_firma,
            _token: $('input[name="_token"]').val()
        };
        $.ajax({
            url: "{{ route('ofertas.sendfirmaContrato') }}",
            method: 'POST',
            data: datos,
            success: function (response) { 
                if (!response.success) {
                    mal(response.message || 'Ocurrió un error al procesar la solicitud.');
                    return;
                }
                $('#modalPaseaFirma').modal("hide");
                const cartas_ofertas = response.cartas_ofertas;
                const nombre = $('#nom_reg').html();
                $('#tbody_cartas_oferta').html('');

                if (cartas_ofertas) {
                    let fila = '';

                    if (cartas_ofertas.estado == 3) {
                        fila += `
                            <tr>
                                <td class="small align-middle text-center">
                                    ${cartas_ofertas.fecha_registro || ''}
                                    <input type='hidden' id='v_file_cartaoflacept' value='${cartas_ofertas.aceptacion_ofl}'> 
                                    <input type='hidden' id='file_cartaoflacept' value='${cartas_ofertas.id}'> 
                                    <a id='link_cartaoflacept' href='${cartas_ofertas.aceptacion_ofl}' download='Carta Oferta - ${nombre}' target='_blank'></a>
                                </td>
                                <td class="small align-middle text-center">${cartas_ofertas.salario || ''}</td>                                
                                <td class="small align-middle text-center">${cartas_ofertas.finicio_formateado || ''}</td>  
                                <td class="small align-middle text-center">${cartas_ofertas.generada_por || ''}</td>                                      
                                <td class="small align-middle text-center">                                     
                                    <div class="dropdown py-0">
                                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-gear pe-2"></i> Acciones
                                        </button>
                                        <ul class="dropdown-menu p-0" aria-labelledby="dropdownMenu2">
                                            <li>
                                                <button class="border-top dropdown-item py-1" type="button" onclick="viewfile('cartaoflacept')">
                                                    <i class="fa-solid fa-magnifying-glass text-info"></i> Ver
                                                </button>
                                            </li>
                                            <li>
                                                <button class="border-top dropdown-item py-1" type="button" onclick="downfile('cartaoflacept')">
                                                    <i class="fa-solid fa-download"></i> Descargar
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>`;
                        $('#bot_nueva_cofl').addClass('d-none');
                        $('#bot_pasa_fimacontrato').removeClass('d-none');

                    } else if (cartas_ofertas.estado == 4) {
                        fila += `
                            <tr>
                                <td class="small align-middle text-center">
                                    ${cartas_ofertas.fecha_registro || ''}
                                    <input type='hidden' id='v_file_cartaoflacept' value='${cartas_ofertas.aceptacion_ofl}'> 
                                    <input type='hidden' id='file_cartaoflacept' value='${cartas_ofertas.id}'> 
                                    <a id='link_cartaoflacept' href='${cartas_ofertas.aceptacion_ofl}' download='Carta Oferta - ${nombre}' target='_blank'></a>
                                </td>
                                <td class="small align-middle text-center">$${cartas_ofertas.salario || ''}</td>
                                <td class="small align-middle text-center">${cartas_ofertas.finicio_formateado || ''}</td>
                                <td class="small align-middle text-center">${cartas_ofertas.generada_por || ''}</td>
                                <td class="align-middle text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <span class="badge rounded-pill" style="background-color: #cfe2ff; color:#0d6efd;">
                                            <i class="fa-solid fa-signature fa-lg pe-1"></i> Firma de Contrato
                                        </span>
                                        <div class="dropdown py-0">
                                            <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-gear pe-2"></i> Acciones</button>
                                            <ul class="dropdown-menu p-0" aria-labelledby="dropdownMenu2">
                                                <li><button class="border-top dropdown-item py-1" type="button" onclick="viewfile('cartaoflacept')" ><i class="fa-solid fa-magnifying-glass text-info"></i> Ver</button></li>
                                                <li><button class="border-top dropdown-item py-1" type="button" onclick="downfile('cartaoflacept')"><i class="fa-solid fa-download text-primary"></i> Descargar</button></li>
                                            </ul>
                                        </div>                                                   
                                    </div>
                                </td>
                            </tr>`;
                        $('#bot_nueva_cofl').addClass('d-none');
                        $('#bot_pasa_fimacontrato').addClass('d-none');
                        bien(response.message);
                    }
                    $('#tbody_cartas_oferta').html(fila);
                }
            },
            error: function(xhr) {
                mal('Error al pasar a firma de contrato.');
            }
        })

    }
    
    function pasar_a_firma()
    {   $('#div_b').removeClass('d-none');
        $('#div_h').removeClass('d-none');
        const id_cartaoflacept = $('#file_cartaoflacept').val();
        $('#lb_nombre_firma').html($('#lb_nombre').html()+" "+$('#lb_apellido').html());
        $('#lb_num_identidad_firma').html($('#lb_num_doc').html());
        $('#lb_num_ss_firma').html($('#lb_css').html());
        
        $('#modalPaseaFirma').modal("show");
        const datos = {
            id_cartaoflacept,
            _token: $('input[name="_token"]').val()
        };

        $.ajax({
            url: "{{ route('ofertas.validaPaseFirma') }}",
            method: 'POST',
            data: datos,
            success: function (response) { 
                const carta = response.carta_oferta;
                const beneficios = response.beneficios;
                const documentos = response.documentosFirma;
                $('#sel_cia_firma').val(carta.cod_cia).change();
                findceco(carta.cod_cia,carta.cod_ceco);
                $('#lb_unidad_firma').html(carta.unidad);
                $('#lb_puesto_firma').html(carta.puesto);
                $('#lb_num_identidad_firma').html(carta.num_doc);
                $('#lb_num_ss_firma').html(carta.num_ss);
                $('#lb_tipocontratofirma').html(carta.tipo_contrato);
                $('#lb_fingreso_firma').html(carta.finicio_format);                
                $('#lb_fsalida_firma').html('');
                if(carta.sel_tipo_contrato!='P'){   $('#lb_fsalida_firma').html(carta.fterminacion_format);}                
                $('#lb_tiposalariofirma').html(carta.tipo_salario);
                $('#lb_salariomensual_firma').html(carta.salario);
                $('#lb_veritas').html(carta.veritas);
                $('#lb_ratahora_firma').html('')
                if(carta.sel_tipo_salario!='B'){   
                    const salario = parseFloat(carta.salario);
                    const horas = parseFloat($('#hrs_mensuales').val());
                    const salario_hora = salario / horas;
                    $('#lb_ratahora_firma').html(salario_hora.toFixed(6));
                } 
                if(beneficios)
                {   $('#list_b').html('');
                    $('#list_h').html('');
                    band_b=0;band_h=0;
                    jQuery(beneficios).each(function(i, item) {
                        beneficio_txt= item.beneficio;
                        icono='';
                        if(item.tipo_dato=='dinero'){ icono=": <b> $"+item.monto+"</b>";}
                        if(item.tipo_dato=='porcen'){ icono=": <b>"+item.monto+'%'+"</b>";}
                        if(item.tipo_dato=='numerico'){ icono=": <b>"+item.monto+"</b>";}
                        if(item.tipo=='b'){band_b=1;}if(item.tipo=='h'){band_h=1;}
                        $('#list_'+item.tipo).append(`<li>${beneficio_txt}  ${icono}</li>`); 

                    });
                    if(band_b==0){ $('#list_b').append(`<li>No mantiene registros</li>`);}
                    if(band_h==0){ $('#list_h').append(`<li>No mantiene registros</li>`);}
                }   
                $('#tbodyDocs').html('');
                if(documentos)
                {   jQuery(documentos).each(function(i, item) {
                        nom_doc=item.nomdoc;
                        tipo_doc=item.id;
                        ruta=item.downdoc;
                        clasedone=" d-none";
                        icono='<i class="fa-solid fa-question text-danger"></i>';
                        if(ruta!=null){clasedone="";icono='<i class="fa-solid fa-check text-success"></i>';}
                        $('#tbodyDocs').append(
                            `<li>${nom_doc} ${icono} </li>`
                        );
                    });
                }          
            }            
        });
        $('#txt_cartaafirma').focus();
    }

    function crearCartaOferta() {   
        const id_ofl = $('#id_ofl_glb').val();
        const id_curri = $('#reclutamiento_id_curri').val();
        const id_part = $('#reclutamiento_id_participante').val();
        const salario = parseFloat($('#salario_mensual').val()) || 0;
        const salario_hora = parseFloat($('#salario_hora').val()) || 0;

        const tipo_salario = $('input[name="tipo_salario"]:checked').val() || 'B';
        const tipo_contrato = $('input[name="tipo_contrato"]:checked').val() || 'P';
        const fecha_inicio = $('#fecha_inicio').val();
        const fecha_terminacion = $('#fecha_terminacion').val() || null;

        const sel_cia = $('#sel_cia').val();
        const sel_ceco = $('#sel_ceco').val();
        const txt_plazo_nombramiento = $('#txt_plazo_nombramiento').val().trim();
        const sel_firmante = $('#sel_firmante').val();
        $('#bot_nueva_cofl').removeClass('d-none');
        $('#bot_pasa_fimacontrato').addClass('d-none');

        // Helper para mostrar alertas y poner foco
        function showAlert(htmlMsg, focusSelector) {
            $('#alert_cartaoferta').html('<i class="fa-solid fa-triangle-exclamation"></i> ' + htmlMsg);
            $('#alert_cartaoferta').removeClass('d-none');
            if (focusSelector) {
                const el = $(focusSelector);
                if (el.length) el.focus();
            }
            setTimeout(function() { $('#alert_cartaoferta').addClass('d-none'); }, 5000);
        }

        // Validaciones
        if (!sel_cia || sel_cia === '0') {
            showAlert('Debe seleccionar una Compañía', '#sel_cia');
            return;
        }
        if (!sel_ceco || sel_ceco === '0') {
            showAlert('Debe seleccionar un centro de costo', '#sel_ceco');
            return;
        }
        if (!salario || salario <= 0) {
            showAlert('Debe ingresar un salario mensual válido', '#salario_mensual');
            return;
        }
        if (tipo_salario === 'H' && (!salario_hora || salario_hora <= 0)) {
            showAlert('Debe ingresar un salario por hora válido', '#salario_hora');
            return;
        }
        if (!fecha_inicio) {
            showAlert('Debe ingresar una fecha de inicio válida', '#fecha_inicio');
            return;
        }
        if (tipo_contrato === 'T' && !fecha_terminacion) {
            showAlert('Debe ingresar una fecha de terminación válida para contrato temporal', '#fecha_terminacion');
            return;
        }
        if (txt_plazo_nombramiento.length < 10) {
            showAlert('El plazo del nombramiento es muy corto. Por favor, ingrese una descripción más detallada.', '#editor-txt_plazo_nombramiento');
            return;
        }
        if (!sel_firmante || sel_firmante === '0') {
            showAlert('Debe seleccionar un Firmante', '#sel_firmante');
            return;
        }

        // Recolectar beneficios / herramientas
        const beneficios = [];
        try {
            $('#beneficios_container .form-check-input[type="checkbox"], #herramientas_container .form-check-input[type="checkbox"]').each(function () {
                if ($(this).is(':checked')) {
                    const checkId = $(this).attr('id'); // ej. 12_bcheck o 15_hcheck
                    const idBase = checkId.replace(/_(b|h)check$/, ''); // ej. 12 o 15 (string)
                    const tipo = checkId.includes('_hcheck') ? 'h' : 'b';
                    const labelText = $(`label[for="${checkId}"]`).text().trim();
                    let monto = 0;
                    const inputId = `#${idBase}_${tipo}txt`;
                    const inputElem = $(inputId);

                    // Si existe un input numérico asociado y está visible (no tiene clase d-none)
                    if (inputElem.length) {
                        const parentInputGroup = inputElem.closest('.input-group');
                        const visible = !parentInputGroup.hasClass('d-none') && inputElem.is(':visible');
                        if (visible) {
                            const val = parseFloat(inputElem.val());
                            if (isNaN(val) || val <= 0) {
                                inputElem.focus();
                                throw `Debe ingresar un monto válido para: ${labelText}`;
                            }
                            monto = val;
                        }
                    }
                    beneficios.push({
                        idBeneficio: parseInt(idBase, 10),
                        nombre: labelText,
                        monto,
                        tipo
                    });
                }
            });
        } catch (error) {
            showAlert(error);
            return;
        }

        const datos = {
            id_ofl,
            id_curri,
            id_part,
            salario,
            salario_hora,
            tipo_salario,
            fecha_inicio,
            fecha_terminacion,
            tipo_contrato,
            sel_cia,
            sel_ceco,
            txt_plazo_nombramiento,
            sel_firmante,
            beneficios,
            _token: $('input[name="_token"]').val()
        };

        // Mostrar spinner (si lo tienes)
        //$('#div_spinner_carta_oferta').removeClass('d-none');

        $.ajax({
            url: "{{ route('ofertas.crearCartaOferta') }}",
            method: 'POST',
            data: datos,
            success: function (response) {      
                $('#form_carta_oferta').removeClass('d-none');
               
                if (response && response.success) {
                    $('#modalCartaOferta').modal('hide');
                    $('#modalViewer').modal('show');
                    bien('Carta generada correctamente');

                    $('#pdfViewer').attr('src', response.url_pdf);
                    $('#pdfViewer').on('load', function() { $(this).removeClass('d-none'); });
                    $('#pdfViewer').on('error', function() { showAlert('Error al cargar el PDF. Por favor, intente nuevamente.'); });

                    // CARTAS DE OFERTA
                    const cartas_ofertas = response.cartas_ofertas;
                    nombre = $('#nom_reg').html();
                    $('#tbody_cartas_oferta').html('');
                    if(cartas_ofertas){
                        let fila = '';
                            fila += `<tr>
                                        <td class="small align-middle text-center">
                                            ${cartas_ofertas.fecha_registro || ''}
                                            <input type='hidden' id='v_file_cartaofl' value='${cartas_ofertas.url_carta_oferta}'> <input type='hidden' id='file_cartaofl' value='${cartas_ofertas.id}'> <a id='link_cartaofl' href='${cartas_ofertas.url_carta_oferta}' download='Carta Oferta - ${nombre}' target='_blank'></a>
                                        </td>
                                        <td class="small align-middle text-center">$${cartas_ofertas.salario || ''}</td>                                
                                        <td class="small align-middle text-center">${cartas_ofertas.finicio_formateado || ''}</td>  
                                        <td class="small align-middle text-center">${cartas_ofertas.generada_por || ''}</td>                                      
                                        <td class="small align-middle text-center">                                     
                                            <div class="dropdown py-0">
                                                <button class="btn btn-info btn-sm dropdown-toggle text-light" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-gear pe-2"></i> Acciones</button>
                                                <ul class="dropdown-menu p-0" aria-labelledby="dropdownMenu2">
                                                    <li><button class="border-top dropdown-item py-1" type="button" onclick="viewfile('cartaofl')" ><i class="fa-solid fa-magnifying-glass text-info"></i> Ver</button></li>
                                                    <li><button class="border-top dropdown-item py-1" type="button" onclick="editfile('cartaofl')" ><i class="fa-solid fa-pencil text-primary"></i> Editar</button></li>
                                                    <li><button class="border-top dropdown-item py-1" type="button" onclick="delfile('cartaofl')" ><i class="fa-solid fa-trash-can text-danger"></i> Eliminar</button></li>
                                                    <li><button class="border-top dropdown-item py-1" type="button" onclick="aceptcartaofl('cartaofl')" ><i class="fa-solid fa-file-circle-check text-success"></i> Carta Oferta Aceptada</button></li>
                                                    <li><button class="border-top dropdown-item py-1" type="button" onclick="declinacartaofl('cartaofl')" ><i class="fa-solid fa-person-circle-xmark text-secondary"></i> Candidato Declina</button></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>`;
                            $('#tbody_cartas_oferta').html(fila);                            
                            $('#bot_nueva_cofl').addClass('d-none');
                            $('#bot_pasa_fimacontrato').addClass('d-none');
                    }

                } else {
                    const msg = (response && response.message) ? response.message : 'Error al generar la carta';
                    showAlert(msg);
                }                        
                $('#form_carta_oferta')[0].reset();
                resetBeneficiosHerramientas();
                $('#div_spinner_carta_oferta').addClass('d-none');
            },
            error: function (xhr) {
                $('#div_spinner_carta_oferta').addClass('d-none');

                // Intenta obtener un mensaje del servidor
                let serverMsg = 'Error al generar la carta.';
                if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                    serverMsg = xhr.responseJSON.message;
                } else if (xhr && xhr.responseText) {
                    // opcionalmente mostrar parte de la respuesta (útil para debugging)
                    console.error(xhr.responseText);
                }
                showAlert(serverMsg);
            }
        });
    }
    
    function aceptcartaofl() {
        $('#clase_modal').removeClass('modal-xl');
        $('#div_adjuntar_carta').removeClass('d-none');
        $('#bto_sube_carta').removeClass('d-none');
        $('#div_frame_carta').addClass('d-none');
        $('#bto_save_carta').addClass('d-none');
        $('#alert_cartaoferta').addClass('d-none');
        $('#carta_file').val('');
        $('#modalAceptaCartaOferta').modal('show');
    }

    // Subir archivo temporal
    function upCartaOferta() {
        const fileInput = document.getElementById('carta_file');
        const file = fileInput.files[0];

        if (!file || file.type !== 'application/pdf') {
            $('#alert_cartaoferta').text('Debe seleccionar un archivo PDF válido.').removeClass('d-none');
            return;
        }

        $('#alert_cartaoferta').addClass('d-none');
        const formData = new FormData();
        formData.append('pdf_file', file);
        formData.append('_token', $('input[name="_token"]').val()); 

        $.ajax({
            url: "{{ route('ofertas.tempUploadCartaOferta') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#clase_modal').addClass('modal-xl');
                $('#div_adjuntar_carta').addClass('d-none');
                $('#bto_sube_carta').addClass('d-none');

                $('#div_frame_carta').removeClass('d-none');
                $('#bto_save_carta').removeClass('d-none');

                $('#pdfViewer_carta').attr('src', response.url_temp);
                $('#pdfViewer_carta').data('temp-file', response.filename); // Guardamos nombre temporal
            },
            error: function(xhr) {
                $('#alert_cartaoferta').text('Error al subir archivo temporal.').removeClass('d-none');
            }
        });
    }

    function saveCartaOfertafirmada() {        
        $('#bot_nueva_cofl').addClass('d-none');
        $('#bot_pasa_fimacontrato').addClass('d-none');
        let id_cartaofl = $('#file_cartaofl').val();
        const id_part = $('#reclutamiento_id_participante').val();
        const tempFilename = $('#pdfViewer_carta').data('temp-file'); 

        if (!tempFilename || !id_cartaofl) {
            mal('Faltan datos para guardar la carta firmada.');
            return;
        }

        $.ajax({
            url: "{{ route('ofertas.saveCartaOfertaFinal') }}",
            method: 'POST',
            data: {
                filename: tempFilename,
                id_cartaofl: id_cartaofl,
                id_part: id_part,
                _token: $('input[name="_token"]').val()
            },
            success: function(resp) {
                bien(resp.message);
                $('#modalAceptaCartaOferta').modal('hide');
                const cartas_ofertas = resp.cartas_ofertas    
                if(cartas_ofertas){
                    nombre = $('#nom_reg').html();
                    $('#tbody_cartas_oferta').html('');
                    if(cartas_ofertas.estado==1)
                    {   let fila = '';
                        fila += `<tr>
                                <td class="small align-middle text-center">
                                        ${cartas_ofertas.fecha_registro || ''}
                                    <input type='hidden' id='v_file_cartaofl' value='${cartas_ofertas.url_carta_oferta}'> <input type='hidden' id='file_cartaofl' value='${cartas_ofertas.id}'> <a id='link_cartaofl' href='${cartas_ofertas.url_carta_oferta}' download='Carta Oferta - ${nombre}' target='_blank'></a>
                                </td>
                                <td class="small align-middle text-center">$${cartas_ofertas.salario || ''}</td>                                
                                <td class="small align-middle text-center">${cartas_ofertas.finicio_formateado || ''}</td>  
                                <td class="small align-middle text-center">${cartas_ofertas.generada_por || ''}</td>                                      
                                <td class="small align-middle text-center">                                     
                                    <div class="dropdown py-0">
                                        <button class="btn btn-info btn-sm dropdown-toggle text-light" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-gear pe-2"></i> Acciones</button>
                                            <ul class="dropdown-menu p-0" aria-labelledby="dropdownMenu2">
                                                <li><button class="border-top dropdown-item py-1" type="button" onclick="viewfile('cartaofl')" ><i class="fa-solid fa-magnifying-glass text-info"></i> Ver</button></li>
                                                <li><button class="border-top dropdown-item py-1" type="button" onclick="editfile('cartaofl')" ><i class="fa-solid fa-pencil text-primary"></i> Editar</button></li>
                                                <li><button class="border-top dropdown-item py-1" type="button" onclick="delfile('cartaofl')" ><i class="fa-solid fa-trash-can text-danger"></i> Eliminar</button></li>
                                                <li><button class="border-top dropdown-item py-1" type="button" onclick="aceptcartaofl('cartaofl')" ><i class="fa-solid fa-file-circle-check text-success"></i> Carta Oferta Aceptada</button></li>
                                                <li><button class="border-top dropdown-item py-1" type="button" onclick="declinacartaofl('cartaofl')" ><i class="fa-solid fa-person-circle-xmark text-secondary"></i> Candidato Declina</button></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>`;
                        $('#tbody_cartas_oferta').html(fila);                        
                    }                     
                    if(cartas_ofertas.estado==3)
                    {   let fila = '';
                        fila += `<tr>
                            <td class="small align-middle text-center">
                                ${cartas_ofertas.fecha_registro || ''}
                                <input type='hidden' id='v_file_cartaoflacept' value='${cartas_ofertas.aceptacion_ofl}'> <input type='hidden' id='file_cartaoflacept' value='${cartas_ofertas.id}'> <a id='link_cartaoflacept' href='${cartas_ofertas.aceptacion_ofl}' download='Carta Oferta - ${nombre}' target='_blank'></a>
                            </td>
                            <td class="small align-middle text-center">$${cartas_ofertas.salario || ''}</td>                                
                            <td class="small align-middle text-center">${cartas_ofertas.finicio_formateado || ''}</td>  
                            <td class="small align-middle text-center">${cartas_ofertas.generada_por || ''}</td>                                      
                            <td class="small align-middle text-center">                                     
                                <div class="dropdown py-0">
                                    <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-gear pe-2"></i> Acciones</button>
                                    <ul class="dropdown-menu p-0" aria-labelledby="dropdownMenu2">
                                        <li><button class="border-top dropdown-item py-1" type="button" onclick="viewfile('cartaoflacept')" ><i class="fa-solid fa-magnifying-glass text-info"></i> Ver</button></li>
                                        <li><button class="border-top dropdown-item py-1" type="button" onclick="downfile('cartaoflacept')"><i class="fa-solid fa-download text-primary"></i> Descargar</button></li>
                                        <li><button class="border-top dropdown-item py-1" type="button" onclick="delfile('cartaoflacept')" ><i class="fa-solid fa-trash-can text-danger"></i> Eliminar</button></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>`;
                        $('#tbody_cartas_oferta').html(fila);
                        $('#bot_pasa_fimacontrato').removeClass('d-none');
                    }
                }
            },
            error: function(xhr) {
                mal('Error al guardar la carta firmada.');
            }
        });
    }

    function muestra_salario_hora() {
        if ($('#salario_base_radio').is(':checked')) {
            $('#div_salario_hora').addClass('d-none');
            $('#salario_hora').val('');
        } else {
            const salario = parseFloat($('#salario_mensual').val());
            const horas = parseFloat($('#hrs_mensuales').val());
            if(salario>0)
        {const salario_hora = salario / horas;
            $('#div_salario_hora').removeClass('d-none');
            $('#salario_hora').val(salario_hora.toFixed(6));}
            else{
                $('#salario_hora').val('');
            }
        }
    }

    function muestra_fecha_terminacion(){        
        var texto_plazo='';
        if($('#contrato_permanente_radio').is(':checked')) 
        {   $('#div_fecha_terminacion').addClass('d-none');
            $('#div_fecha_terminacion').val('');
            $('#txt_plazo_nombramiento').val('El presente contrato será por <strong>tiempo indefinido</strong>, con un <strong>periodo probatorio de tres (3) meses</strong>. Es entendido que la compañía podrá ofrecerle en el futuro, otra posición compatible con su carrera de servicios.');
        }else{
            $('#div_fecha_terminacion').removeClass('d-none');
            $('#fecha_terminacion').focus();
            $('#txt_plazo_nombramiento').val('El presente contrato será por <strong>tiempo definido de once (11) meses</strong>, con un <strong>periodo probatorio de tres (3) meses</strong>. Es entendido que la compañía podrá ofrecerle en el futuro, otra posición compatible con su carrera de servicios.');
        }        
    }

    // Función para guardar la observación de descarte
    function ajusta_num()
    {   if($('#id_entrevista').val()==0)
        {   var num = parseInt($('#num_entrevistas').val()) - 1;
            $('#num_entrevistas').val(num);
        }
    }

    function saveDescarte() {
        const num = $('#num_entrevistas').val();

        if ($('#motivo_declinar').val() === 'Seleccionar motivo') {
            mal('Por favor, seleccione un motivo de descarte');
            return;
        }
        if ($('#obs_declinar').val().trim() === '') {
            mal('Por favor, detalle el motivo del descarte');
            return;
        }

        let addmsn = '';
        if ($('#chk_descarta_bd').is(':checked')) {
            addmsn = " y también de futuras búsquedas y ofertas";
        }

        Swal.fire({
            icon: "question",
            html: "El candidato será descartado de este proceso" + addmsn + ", ¿Desea continuar?",
            showCancelButton: true,
            cancelButtonText: '<i class="fas fa-arrow-left"></i> Cancelar',
            confirmButtonText: '<i class="fas fa-user-times fa-lg"></i> Sí, Descartar',
            confirmButtonColor: "#dc3545",
        }).then((result) => {
            if (result.isConfirmed) {
                const id_curri = $('#reclutamiento_id_curri').val();
                const id_part = $('#reclutamiento_id_participante').val();
                const id_ofl = $('#id_ofl_glb').val();
                const motivo_descarte = $('#motivo_declinar option:selected').text();
                const detalle_descarte = $('#obs_declinar').val();
                const chk_descarta_bd = $('#chk_descarta_bd').is(':checked') ? 's' : 'n';

                const parametros = {
                    id_curri,
                    id_part,
                    id_ofl,
                    motivo_descarte,
                    chk_descarta_bd,
                    detalle_descarte,
                    _token: $('input[name="_token"]').val()
                };

                $.ajax({
                    url: "{{ route('ofertas.saveDescarte') }}",
                    type: 'POST',
                    data: parametros,
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            bien('El candidato ha sido descartado correctamente');

                            const titulo = chk_descarta_bd == 'n' ? 'Candidato declinado' : 'Candidato descartado';
                            $('#ModalDeclinar').modal('hide');
                            $('#obs_declinar').val('');
                            $('#motivo_declinar').val('');

                            for (let x = 0; x < num; x++) {
                                $('#fecha_entrevista_' + x).val('');
                                $('#hora_entrevista_' + x).val('');
                                $('#alerta_entrevista_' + x).html('<span class="badge rounded-pill text-danger" style="background-color: #f8d7da;"><i class="fa-solid fa-user-xmark fa-lg pe-1"></i> Candidato descartado</span>');
                                $('#flag_' + x).html('<i class="fa-solid fa-flag text-danger"></i>');
                            }

                            $('#alert_estatus').removeClass('d-none');
                            $('#titulo_declinacion_desarte').html(titulo);
                            $('#motivo_declinacion_desarte').html(
                                (motivo_descarte || '') + '<br>' + (detalle_descarte || '')
                            );

                        } else {
                            mal('Error al descartar el candidato');
                        }
                    },
                    error: function () {
                        mal('Ocurrió un error al descartar el candidato');
                    }
                });
            }
        });
    }

    // ------ DEscartar ENTREVISTA
    function modaldeclinar() {     
        let id_curri = $('#reclutamiento_id_curri').val();
        let id_part = $('#reclutamiento_id_participante').val();
        $('#obs_declinar').val('');
        let nombreCandidato = $('#nom_reg').text();
        $('#ModalDeclinar').find('.modal-title').text('Descartar candidato ' + nombreCandidato);
        $('#ModalDeclinar').modal('show'); 
    }

    function toggleDescartarLabel(checkbox) {
        const label = document.getElementById('lbl_descarta_bd');
        if (checkbox.checked) {
            label.classList.remove('text-secondary');
            label.classList.add('text-danger');
        } else {
            label.classList.remove('text-danger');
            label.classList.add('text-secondary');
        }
    }

    function enviar_terna(event)
    {
        event.preventDefault();           
        let formData = $('#emailForm').serializeArray();
    
        let seleccionados = [];
        $('input[name="terna[]"]:checked').each(function () {
            seleccionados.push($(this).val());
        });

        seleccionados.forEach(function(val) { formData.push({ name: 'terna[]', value: val });});

        formData.push({ name: 'id_ofl', value: $('#id_ofl_glb').val() });

        $.ajax({
            url: "{{ route('ofertas.sendTerna') }}",
            method: 'POST',
            data: $.param(formData),
            beforeSend: function() {
                $('#btn_enviar').addClass('d-none');
                $('#btn_enviando').removeClass('d-none');
            },
            success: function(response) {
                if(response.success) {
                    bien('La trena ha sido enviada correctamente');
                    $('#emailModal').modal('hide');
                    $('#emailForm')[0].reset();
                    $('trix-editor[input="send_OBSterna"]')[0].editor.loadHTML('');
                    $('#btn_enviar').removeClass('d-none');
                    $('#btn_enviando').addClass('d-none');
                    cancel_ternas();
                } else {
                    mal('Error al enviar el correo');
                    $('#btn_enviar').removeClass('d-none');
                    $('#btn_enviando').addClass('d-none');
                }
            },
            error: function(xhr) {
                mal('Ocurrió un error al enviar el correo');
                $('#btn_enviar').removeClass('d-none');
                $('#btn_enviando').addClass('d-none');
            }
        });
    }

    function sendTerna()
    {   
        let nomPosTerna=$('#nom_posicion_olf').html();      
        let id_ofl = $('#id_ofl_glb').val();
        let nombres_terna="";
        $('input[name="terna[]"]:checked').each(function() {
            //seleccionados.push($(this).val());
            nombres_terna+="<li>"+$('#nom_'+$(this).val()).html()+"</li>";
        });
        let parametros = {
            id_ofl: id_ofl,        
            _token: $('input[name="_token"]').val()
        };

        $.ajax({
            url: "{{ route('ofertas.msg_sendTerna') }}",
            type: 'POST',
            data: parametros,
            dataType: 'json',
            success: function(response) {
                if(response.success)
                {   
                    const msg_sendterna = response.msg_sendterna;
                    if(msg_sendterna)
                    {   $('#send_OBSterna').val(msg_sendterna[0].msg);
                        document.querySelector('trix-editor[input="send_OBSterna"]').editor.loadHTML(msg_sendterna[0].msg || ''); 
                    
                    const data_users= response.data_users;
                   // const editorElement = document.querySelector('trix-editor[input="send_OBSterna"]');
                  //  const editor = editorElement.editor;
                    let currentHTML = msg_sendterna[0].msg;
                    let updatedHTML = currentHTML
                    .replace(`nom_pos_terna`, `<span class="fw-semibold">${nomPosTerna}</span>`)
                    .replace(`list_candiadtos`, `<ul>${nombres_terna}</ul>`)
                    .replace(`enlace`, `<a href=\"https://intranet.itregency.com/FOCUSTalent/public/login\">https://intranet.itregency.com/FOCUSTalent/public/login</a>`)
                    .replace(`nom_envia_terna`, `${data_users.nombre_completo}<br>${data_users.nom_puesto}<br><span class="text-primary-terna">${data_users.email}</span>`);
                  //  editor.loadHTML(updatedHTML);
                    document.querySelector('trix-editor[input="send_OBSterna"]').editor.loadHTML(updatedHTML);
                    }
                }
            },
            error: function(xhr) {
                console.error('Error en la petición AJAX', xhr);
            }
        });
    }

    function guardar_obs_terna() {
        let id_part = $('#id_partOBSTerna').val();
        let id_curri = $('#id_curriOBSTerna').val();
        let id_ofl = $('#id_ofl_glb').val();
        let OBSterna = $('#OBSterna').val();

        let parametros = {
            id_ofl: id_ofl,
            id_part: id_part,
            id_curri: id_curri,
            OBSterna: OBSterna,
            _token: $('input[name="_token"]').val()
        };

        $.ajax({
            url: "{{ route('ofertas.addOBSTerna') }}",
            type: 'POST',
            data: parametros,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    if (response.obsterna != null && response.obsterna.trim() !== "") {
                        $('#icoOBSTerna_' + id_curri).html(
                            '<i style="cursor:pointer" class="fa-solid fa-comment-dots fa-lg text-primary" onclick="addOBSTerna(' + id_curri + ',' + id_part + ')" title="Ver observación"></i>'
                        );
                    } else {
                        $('#icoOBSTerna_' + id_curri).html(
                            '<i style="cursor:pointer" class="fa-solid fa-comment-medical fa-lg text-secondary" onclick="addOBSTerna(' + id_curri + ',' + id_part + ')" title="Agregar observación"></i>'
                        );
                    }
                    bien(response.message);
                                                     
                    $('#modalOBSTerna').modal('hide');
                    $('#OBSterna').val('');
                    document.querySelector("trix-editor").editor.loadHTML('');
                } else {
                    mal("Ocurrió un error inesperado.");
                    $('#icoOBSTerna_'+id_curri).html('<i style="cursor:pointer" class="fa-solid fa-comment-medical fa-lg text-secondary" onclick="addOBSTerna('+id_curri+','+id_part+')" title="Agregar observación"></i>');
                }
            },
            error: function(xhr) {
                let errorMsg = xhr.responseJSON?.message || 'Error en la petición';
                mal("Error del servidor: " + errorMsg);
                $('#icoOBSTerna_'+id_curri).html('<i style="cursor:pointer" class="fa-solid fa-comment-medical fa-lg text-secondary" onclick="addOBSTerna('+id_curri+','+id_part+')" title="Agregar observación"></i>');
            }
        });
    }

    function addOBSTerna(id_curri, id_part) {
        $('#id_partOBSTerna').val(id_part);
        $('#id_curriOBSTerna').val(id_curri);
        let id_ofl = $('#id_ofl_glb').val();

        let parametros = {
            id_ofl: id_ofl,
            id_part: id_part,
            id_curri: id_curri,
            _token: $('input[name="_token"]').val()
        };

        $.ajax({
            url: "{{ route('ofertas.editOBSTerna') }}",
            type: 'POST',
            data: parametros,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#OBSterna').val(response.obsterna);
                    document.querySelector('trix-editor[input="OBSterna"]').editor.loadHTML(response.obsterna || '');
                } else {
                    mal("No se pudo cargar la observación.");
                }
            },
            error: function() {
                mal("Error al cargar observación.");
            }
        });

        let modal = new bootstrap.Modal(document.getElementById('modalOBSTerna'));
        modal.show();
    }

    function add_terna()
    {
        $('#bto_volver_det_candidato').addClass('d-none');
        $('#bto_listado_candidato').addClass('d-none');
        $('#Detalle-Candidato').addClass('d-none');
        $('#div_oferta_laboral').addClass('d-none');
        $('#div_terna').removeClass('d-none');
        $('#bto_ternas').removeClass('d-none');
        listar_candidates_terna();
    }
        
    function cancel_ternas()
    {
        $('#bto_volver_det_candidato').addClass('d-none');
        $('#bto_listado_candidato').removeClass('d-none');
        $('#bto_ternas').addClass('d-none');
        $('#div_oferta_laboral').removeClass('d-none');
        $('#div_terna').addClass('d-none');
        $('#Detalle-Candidato').addClass('d-none');
        mod_prospectos($('#id_ofl').val())
    }

    function listar_candidates_terna() 
    {
        // Mostrar spinner
        $('#div_spinner').removeClass('d-none');
        $('#div_terna').addClass('d-none'); // Ocultar la tabla mientras carga

        var parametros = {
            "id_ofl": $('#id_ofl_glb').val(),
            "_token": $('input[name="_token"]').val()
        };

        $.ajax({
            data: parametros,
            url: "{{ route('ofertas.listar_candidate_terna') }}",
            type: 'POST',
            dataType: "json",
            cache: false,
            success: function(response) {
                if (response.success) {
                    let participantes = response.participantes;
                    let tbody = $('#tbody_terna');
                    tbody.empty();

                    participantes.forEach(part => {
                        const id = part.id_part_curriculum;
                        ico_obs='<i style="cursor:pointer" class="fa-solid fa-comment-medical fa-lg text-secondary" onclick="addOBSTerna('+part.id_curri+','+part.id_part+')" title="Agregar observación"></i>';
                        if(part.id_obst!=null)
                        {ico_obs='<i style="cursor:pointer" class="fa-solid fa-comment-dots fa-lg text-primary" onclick="addOBSTerna('+part.id_curri+','+part.id_part+')" title="Ver observación"></i>';}

                        const iniciales = `${(part.prinombre || '').charAt(0)}${(part.priapellido || '').charAt(0)}`.toUpperCase();
                        const color_bg = $('#color_bg_'+part.id_curri).val();
                        const color_tx = $('#color_tx_'+part.id_curri).val();
                        let fotoHtml = `<img src="${part.foto}" alt="Foto de ${part.prinombre} ${part.priapellido}" class="rounded-circle" style="background:#FFFFFF; width: 60px; height: 60px; object-fit: cover; border: 1px solid #aeafb0;">`;
                        if (!part.foto) {
                            fotoHtml = `
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="
                                width: 60px; height: 60px; background-color: ${color_bg};  border-radius: 50%;  display: flex;  align-items: center;  justify-content: center;  color: ${color_tx};  font-family: 'Segoe UI', 'Roboto', sans-serif;
                                font-size: 35px;  text-transform: uppercase;  border: 1px solid ${color_tx}">
                                    ${iniciales}
                                </div>`;
                        }

                        let fila = `
                            <tr id="row_part_${part.id_curri}">
                                <td class="align-middle text-center bg-light">
                                    <input type="checkbox" name="terna[]" value="${part.id_curri}" onchange="del_candidate_terna(this.value)" checked>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                            <input type="hidden" id="fto_${part.id_curri}" value="${part.foto}">
                                        <div class="me-2">
                                            ${fotoHtml}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-uppercase" style="color: #4B6EAD;font-size: 13px;text-transform: uppercase;" id="nom_${part.id_curri}">${part.prinombre} ${part.priapellido}</div>
                                            <div class="text-secondary fw-bold" style="font-size: 12px"><i class="fa-solid fa-globe pe-1"></i>${part.nacionalidad}</div>
                                            <div class="text-secondary" style="font-size: 11px"><i class="fa-solid fa-envelope pe-1"></i><span class="text-primary">${part.email}</span></div>
                                            <div class="text-secondary" style="font-size: 11px"><i class="fa-solid fa-phone-flip pe-1"></i>${part.tel}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="small align-middle text-center">
                                    <span id="name_file_cv_terna_${part.id_curri}" class="d-none">CV - ${part.prinombre} ${part.priapellido}</span>
                                    ${
                                        part.cv_doc 
                                        ? `<button type="button" class="btn btn-sm btn-outline-info px-1 py-0" onclick="viewfile('cv_terna_${part.id_curri}')">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </button>
                                        <input type="hidden" id="v_file_cv_terna_${part.id_curri}" value="${part.cv_doc}">`
                                        : '<i class="fa-solid fa-triangle-exclamation fa-lg text-warning" title="No hay documento adjunto"></i>'
                                    }
                                </td>

                                <td class="small align-middle text-center">
                                    <span id="name_file_apl_terna_${part.id_curri}" class="d-none">APL - ${part.prinombre} ${part.priapellido}</span>
                                    <span id="ico_doc_apl_terna_${part.id_curri}"></span>                                    
                                </td>

                                <td class="small align-middle text-center">
                                    <span id="name_file_razi_terna_${part.id_curri}" class="d-none">RAZI - ${part.prinombre} ${part.priapellido}</span>
                                    <span id="ico_doc_razi_terna_${part.id_curri}"></span>  
                                </td>

                                <td class="small align-middle text-center">
                                    <span id="name_file_disc_terna_${part.id_curri}" class="d-none">DISC - ${part.prinombre} ${part.priapellido}</span>
                                    <span id="ico_doc_disc_terna_${part.id_curri}"></span>                                    
                                </td>

                                <td class="align-middle text-center" id="icoOBSTerna_${part.id_curri}">
                                    ${ico_obs}
                                </td>
                            </tr>`;

                        $('#tbody_terna').append(fila);
                    });

                    $('#div_terna').removeClass('d-none');

                    const ult_pruebas_apl = response.ult_pruebas_apl;
                    const competencias = response.competencias;
                    const resultados = response.resultados_competencias_apl;

                    const ult_pruebas_razi = response.ult_pruebas_razi;
                    const ult_pruebas_disc = response.ult_pruebas_disc;
                    const ult_pruebas_veritas = response.ult_pruebas_veritas;
                    // APL
                        // 1. Construir encabezado (participantes como columnas)
                        let headerRow = '<tr><td></td><td></td>'; // Primera celda vacía
                            
                        ult_pruebas_apl.forEach(part => {
                            participantes.forEach(part_candidatos => {
                            if(part_candidatos.id_curri==part.id_curri)
                            {   iniciales = `${(part_candidatos.prinombre || '').charAt(0)}${(part_candidatos.priapellido || '').charAt(0)}`.toUpperCase();
                                color_bg = $('#color_bg_'+part.id_curri).val();
                                color_tx = $('#color_tx_'+part.id_curri).val();
                                fotoHtml = `<img src="${part_candidatos.foto}" alt="Foto de ${part_candidatos.prinombre} ${part_candidatos.priapellido}" class="rounded-circle" style="background:#FFFFFF; width: 50px; height: 50px; object-fit: cover; border: 1px solid #aeafb0;">`;
                                if (!part_candidatos.foto) {
                                    fotoHtml = `
                                        <div class="rounded-circle d-flex text-center align-items-center justify-content-center" style="
                                        width: 50px; height: 50px; background-color: ${color_bg};  border-radius: 50%;  display: flex;  align-items: center;  justify-content: center;  color: ${color_tx};  font-family: 'Segoe UI', 'Roboto', sans-serif;
                                        font-size: 18px;  text-transform: uppercase;  border: 1px solid ${color_tx}">
                                            ${iniciales}
                                        </div>`;
                                } 
                                let fullName = $('#nom_' + part.id_curri).html();


                                headerRow += `
                                    <td class="text-center align-middle col_part_APL_${part.id_curri}">
                                        <div class="align-items-center">
                                            <div class="d-flex text-center align-items-center justify-content-center">
                                                ${fotoHtml}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-uppercase" style="color: #4B6EAD;font-size: 11px">${fullName}</div>
                                            </div>
                                        </div>
                                    </td>`;

                                    if(part.informe!=null)
                                    {   $(`#ico_doc_apl_terna_${part.id_curri}`).html(`
                                            <button type="button" class="btn btn-sm btn-outline-info px-1 py-0" onclick="viewfile('apl_terna_${part.id_curri}')">
                                                <i class="fa-solid fa-magnifying-glass"></i>
                                            </button>
                                            <input type="hidden" id="v_file_apl_terna_${part.id_curri}" value="${part.informe}">`)}
                                    else{   $(`#ico_doc_apl_terna_${part.id_curri}`).html(`<i class="fa-solid fa-triangle-exclamation fa-lg text-warning" title="No hay documento adjunto"></i>`) };

                            } });
                        });
                        headerRow += '</tr>';

                        headerRow += '<tr><td style="background-color:#668BD0;"></td><td class="text-center align-middle text-white" style="background-color:#668BD0;">% DE AJUSTE AL PUESTO</td>'; // Primera celda vacía
                        ult_pruebas_apl.forEach(part => {
                            participantes.forEach(part_candidatos => {
                            if(part_candidatos.id_curri==part.id_curri)
                            {  
                                let cumplimiento = part.cumplimiento;
                                headerRow += `
                                    <td class="col_part_APL_${part.id_curri} text-center align-middle text-white fw-bold" style="background-color:#668BD0;font-size: 14px;">
                                        ${cumplimiento}%
                                    </td>`;
                            } });
                        });
                        headerRow += '</tr>';      
                        headerRow += '<tr><td style="background-color:#D4DCEB;"></td><td class="text-center align-middle" style="background-color:#D4DCEB;">TOTAL DE PUNTOS</td>'; // Primera celda vacía
                        ult_pruebas_apl.forEach(part => {
                            participantes.forEach(part_candidatos => {
                            if(part_candidatos.id_curri==part.id_curri)
                            {  
                                let sum_puntaje = part.sum_puntaje;
                                headerRow += `
                                    <td class="col_part_APL_${part.id_curri} text-center align-middle" style="background-color:#D4DCEB;font-size: 14px;">
                                        ${sum_puntaje}
                                    </td>`;
                            } });
                        });
                        headerRow += '</tr>';               
                        // 2. Construir filas por competencia

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
                                participantes.forEach(part_candidatos => {
                                if(part_candidatos.id_curri==part.id_curri)
                                {  
                                    const resultado = resultados.find(r =>
                                        r.id_curri === part.id_curri &&
                                        r.competencia_id === comp.id_competencia
                                    );
                                    row += `<td class="col_part_APL_${part.id_curri} text-center align-middle">${resultado ? resultado.puntaje : '-'}</td>`;
                                } });
                            });

                            row += '</tr>';
                            bodyHtml += row;
                        });

                        $('#body-rows').html(headerRow+bodyHtml);

                    // RAZI

                        // 1. Construir encabezado (participantes como columnas)
                        let headerRowRazi = '<tr><td></td>'; // Primera celda vacía
                        ult_pruebas_razi.forEach(part => {

                            participantes.forEach(part_candidatos => {
                            if(part_candidatos.id_curri==part.id_curri)
                            {   iniciales = `${(part_candidatos.prinombre || '').charAt(0)}${(part_candidatos.priapellido || '').charAt(0)}`.toUpperCase();
                                color_bg = $('#color_bg_'+part.id_curri).val();
                                color_tx = $('#color_tx_'+part.id_curri).val();
                                fotoHtml = `<img src="${part_candidatos.foto}" alt="Foto de ${part_candidatos.prinombre} ${part_candidatos.priapellido}" class="rounded-circle" style="background:#FFFFFF; width: 50px; height: 50px; object-fit: cover; border: 1px solid #aeafb0;">`;
                                if (!part_candidatos.foto) {
                                    fotoHtml = `
                                        <div class="rounded-circle d-flex text-center align-items-center justify-content-center" style="
                                        width: 50px; height: 50px; background-color: ${color_bg};  border-radius: 50%;  display: flex;  align-items: center;  justify-content: center;  color: ${color_tx};  font-family: 'Segoe UI', 'Roboto', sans-serif;
                                        font-size: 18px;  text-transform: uppercase;  border: 1px solid ${color_tx}">
                                            ${iniciales}
                                        </div>`;
                                        return;
                                } 
                            }});
                            let fullNameRazi = $('#nom_' + part.id_curri).html();
                            let ftoRazi=$('#fto_' + part.id_curri).val();

                            
                            headerRowRazi += `
                                <td class="col_part_RAZI_${part.id_curri} text-center align-middle">
                                    <div class="align-items-center">
                                            <div class="d-flex text-center align-items-center justify-content-center">
                                                ${fotoHtml}
                                            </div>
                                        <div>
                                            <div class="fw-bold text-uppercase" style="color: #4B6EAD;font-size: 11px">${fullNameRazi}</div>
                                        </div>
                                    </div>
                                </td>`;

                                if(part.informe!=null)
                                {   $(`#ico_doc_razi_terna_${part.id_curri}`).html(`
                                        <button type="button" class="btn btn-sm btn-outline-info px-1 py-0" onclick="viewfile('razi_terna_${part.id_curri}')">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </button>
                                        <input type="hidden" id="v_file_razi_terna_${part.id_curri}" value="${part.informe}">`)}
                                else{
                                    $(`#ico_doc_razi_terna_${part.id_curri}`).html(`<i class="fa-solid fa-triangle-exclamation fa-lg text-warning" title="No hay documento adjunto"></i>`)
                                };


                        });
                        headerRowRazi += '</tr>';

                        let bodyHtmlRazi = '';
                        
                        let row_razi = `<tr><td class="text-center align-middle text-white ps-4" style="background-color:#668BD0;">Aptitud General</td>`;
                            ult_pruebas_razi.forEach(part => {
                            //    const resultado_razi = resultados_razi.find(r => r.id_curri === part.id_curri );
                                row_razi += `<td class="col_part_RAZI_${part.id_curri} text-center align-middle text-white fw-bold" style="background-color:#668BD0;font-size: 14px;">${part ? part.general : '-'}</td>`;
                            });
                        row_razi += '</tr>';
                        bodyHtmlRazi += row_razi;
                        
                        row_razi = `<tr><td class="text-start align-middle ps-4">Aptitud Verbal</td>`; // Nombre de la competencia
                            ult_pruebas_razi.forEach(part => {
                            //    const resultado_razi = resultados_razi.find(r => r.id_curri === part.id_curri );
                                row_razi += `<td class="col_part_RAZI_${part.id_curri} text-center align-middle">${part ? part.puntaje_v : '-'}</td>`;
                            });
                        row_razi += '</tr>';
                        bodyHtmlRazi += row_razi;
                        
                        row_razi = `<tr><td class="text-start align-middle ps-4">Aptitud Numérica</td>`; // Nombre de la competencia
                            ult_pruebas_razi.forEach(part => {
                            //    const resultado_razi = resultados_razi.find(r => r.id_curri === part.id_curri );
                                row_razi += `<td class="col_part_RAZI_${part.id_curri} text-center align-middle">${part ? part.puntaje_n : '-'}</td>`;
                            });
                        row_razi += '</tr>';
                        bodyHtmlRazi += row_razi;

                        row_razi = `<tr><td class="text-start align-middle ps-4">Aptitud Abstracta</td>`; // Nombre de la competencia
                            ult_pruebas_razi.forEach(part => {
                            //    const resultado_razi = resultados_razi.find(r => r.id_curri === part.id_curri );
                                row_razi += `<td class="col_part_RAZI_${part.id_curri} text-center align-middle">${part ? part.puntaje_a : '-'}</td>`;
                            });
                        row_razi += '</tr>';
                        bodyHtmlRazi += row_razi;                     
                        $('#body-rows-razi').html(headerRowRazi+bodyHtmlRazi);

                    // DISC

                        // 1. Construir encabezado (participantes como columnas)
                        let headerRowDisc = '<tr><td></td>'; // Primera celda vacía
                        ult_pruebas_disc.forEach(part => {
                            let fullNameDisc = $('#nom_' + part.id_curri).html();
                            let ftoDisc=$('#fto_' + part.id_curri).val();

                            participantes.forEach(part_candidatos => {
                            if(part_candidatos.id_curri==part.id_curri)
                            {   iniciales = `${(part_candidatos.prinombre || '').charAt(0)}${(part_candidatos.priapellido || '').charAt(0)}`.toUpperCase();
                                color_bg = $('#color_bg_'+part.id_curri).val();
                                color_tx = $('#color_tx_'+part.id_curri).val();
                                fotoHtml = `<img src="${part_candidatos.foto}" alt="Foto de ${part_candidatos.prinombre} ${part_candidatos.priapellido}" class="rounded-circle" style="background:#FFFFFF; width: 50px; height: 50px; object-fit: cover; border: 1px solid #aeafb0;">`;
                                if (!part_candidatos.foto) {
                                    fotoHtml = `
                                        <div class="rounded-circle d-flex text-center align-items-center justify-content-center" style="
                                        width: 50px; height: 50px; background-color: ${color_bg};  border-radius: 50%;  display: flex;  align-items: center;  justify-content: center;  color: ${color_tx};  font-family: 'Segoe UI', 'Roboto', sans-serif;
                                        font-size: 18px;  text-transform: uppercase;  border: 1px solid ${color_tx}">
                                            ${iniciales}
                                        </div>`;
                                        return;
                                } 
                            }});

                            headerRowDisc += `
                                <td class="col_part_DISC_${part.id_curri} text-center align-middle">
                                    <div class="align-items-center">
                                        <div class="d-flex text-center align-items-center justify-content-center">
                                            ${fotoHtml}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-uppercase" style="color: #4B6EAD;font-size: 11px">${fullNameDisc}</div>
                                        </div>
                                    </div>
                                </td>`;

                                if(part.informe!=null)
                                {   $(`#ico_doc_disc_terna_${part.id_curri}`).html(`
                                        <button type="button" class="btn btn-sm btn-outline-info px-1 py-0" onclick="viewfile('disc_terna_${part.id_curri}')">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </button>
                                        <input type="hidden" id="v_file_disc_terna_${part.id_curri}" value="${part.informe}">`)}
                                else{
                                    $(`#ico_doc_disc_terna_${part.id_curri}`).html(`<i class="fa-solid fa-triangle-exclamation fa-lg text-warning" title="No hay documento adjunto"></i>`)
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
                            
                            participantes.forEach(part_candidatos => {
                            if(part_candidatos.id_curri==part.id_curri)
                            {   iniciales = `${(part_candidatos.prinombre || '').charAt(0)}${(part_candidatos.priapellido || '').charAt(0)}`.toUpperCase();

                                color_bg = $('#color_bg_'+part.id_curri).val();
                                color_tx = $('#color_tx_'+part.id_curri).val();
                                fotoHtml = `<img src="${part_candidatos.foto}" alt="Foto de ${part_candidatos.prinombre} ${part_candidatos.priapellido}" class="rounded-circle" style="background:#FFFFFF; width: 50px; height: 50px; object-fit: cover; border: 1px solid #aeafb0;">`;
                                if (!part_candidatos.foto) {
                                    fotoHtml = `
                                        <div class="rounded-circle d-flex text-center align-items-center justify-content-center" style="
                                        width: 50px; height: 50px; background-color: ${color_bg};  border-radius: 50%;  display: flex;  align-items: center;  justify-content: center;  color: ${color_tx};  font-family: 'Segoe UI', 'Roboto', sans-serif;
                                        font-size: 18px;  text-transform: uppercase;  border: 1px solid ${color_tx}">
                                            ${iniciales}
                                        </div>`;
                                        return;
                                } 
                            }});

                            headerRowVeritas += `
                                <td class="col_part_VERITAS_${part.id_curri} text-center align-middle">
                                    <div class="align-items-center">
                                        <div class="d-flex text-center align-items-center justify-content-center">
                                            ${fotoHtml}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-uppercase" style="color: #4B6EAD;font-size: 11px">${fullNameVeritas}</div>
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
                    } else {
                    mal("Error: " + response.message);
                    mod_prospectos($('#id_ofl').val());
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                mal("Ocurrió un error al obtener los datos.");
            },
            complete: function() {
                // Ocultar spinner al final (éxito o error)
                $('#div_spinner').addClass('d-none');
            }
        });           
    }

    function del_candidate_terna(code) {
        const checkbox = event.target; // El checkbox que disparó el evento
        const nombre = $('#nom_' + code).text();

        // Solo continuar si el checkbox fue desmarcado (es decir, se intenta quitar al candidato)
        if (!checkbox.checked) {
            Swal.fire({
                icon: "question",
                html: `¿Se eliminará al candidato <strong>${nombre}</strong> de la terna, desea continuar?`,
                showCancelButton: true,
                cancelButtonText: '<i class="fas fa-arrow-left"></i> Cancelar',
                confirmButtonText: '<i class="fa-solid fa-trash-can"></i> Sí, Eliminar',
                confirmButtonColor: "#d33",
            }).then((result) => {
                if (result.isConfirmed) {
                    const id_curri = $(checkbox).val();
                    $('#row_part_' + id_curri).remove();
                    $('.col_part_APL_' + id_curri).remove();
                    $('.col_part_RAZI_' + id_curri).remove();
                    $('.col_part_DISC_' + id_curri).remove();
                    $('.col_part_VERITAS_' + id_curri).remove();
                    bien("Candidato eliminado de la terna");
                } else {
                    // Revertir el checkbox a "marcado" si cancela
                    $(checkbox).prop('checked', true);
                }
            });
        }
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
    {   const id_curri = $('#reclutamiento_id_curri').val();
    
        if(doc=='cartaofl')
        {   msn="¿Se eliminará la carta oferta, desea continuar?";
        }
        else
        {   if(doc=='cartaoflacept')
            {   msn="¿Se eliminará la carta oferta firmada, desea continuar?";}
            else
            {   const nombreArchivo = $('#name_file_' + doc).html();
                msn="¿Se eliminará el archivo adjunto '" + nombreArchivo + "', desea continuar?";}
        }

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
                        if(doc=='cartaofl')
                        {   $('#tbody_cartas_oferta').html('');
                            $('#bot_nueva_cofl').removeClass('d-none');
                            $('#bot_pasa_fimacontrato').addClass('d-none');
                        }
                        else
                        {
                            if(doc=='cartaoflacept')
                            {   $('#bot_nueva_cofl').addClass('d-none');
                                $('#bot_pasa_fimacontrato').addClass('d-none');  
                                const cartas_ofertas = data.cartas_ofertas    
                                if(cartas_ofertas){
                                    nombre = $('#nom_reg').html();
                                    $('#tbody_cartas_oferta').html('');   
                                    if(cartas_ofertas.estado==1)
                                    {   let fila = '';
                                        fila += `<tr>
                                                <td class="small align-middle text-center">
                                                        ${cartas_ofertas.fecha_registro || ''}
                                                    <input type='hidden' id='v_file_cartaofl' value='${cartas_ofertas.url_carta_oferta}'> <input type='hidden' id='file_cartaofl' value='${cartas_ofertas.id}'> <a id='link_cartaofl' href='${cartas_ofertas.url_carta_oferta}' download='Carta Oferta - ${nombre}' target='_blank'></a>
                                                </td>
                                                <td class="small align-middle text-center">$${cartas_ofertas.salario || ''}</td>                                
                                                <td class="small align-middle text-center">${cartas_ofertas.finicio_formateado || ''}</td>  
                                                <td class="small align-middle text-center">${cartas_ofertas.generada_por || ''}</td>                                      
                                                <td class="small align-middle text-center">                                     
                                                    <div class="dropdown py-0">
                                                        <button class="btn btn-info btn-sm dropdown-toggle text-light" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-gear pe-2"></i> Acciones</button>
                                                            <ul class="dropdown-menu p-0" aria-labelledby="dropdownMenu2">
                                                                <li><button class="border-top dropdown-item py-1" type="button" onclick="viewfile('cartaofl')" ><i class="fa-solid fa-magnifying-glass text-info"></i> Ver</button></li>
                                                                <li><button class="border-top dropdown-item py-1" type="button" onclick="editfile('cartaofl')" ><i class="fa-solid fa-pencil text-primary"></i> Editar</button></li>
                                                                <li><button class="border-top dropdown-item py-1" type="button" onclick="delfile('cartaofl')" ><i class="fa-solid fa-trash-can text-danger"></i> Eliminar</button></li>
                                                                <li><button class="border-top dropdown-item py-1" type="button" onclick="aceptcartaofl('cartaofl')" ><i class="fa-solid fa-file-circle-check text-success"></i> Carta Oferta Aceptada</button></li>
                                                                <li><button class="border-top dropdown-item py-1" type="button" onclick="declinacartaofl('cartaofl')" ><i class="fa-solid fa-person-circle-xmark text-secondary"></i> Candidato Declina</button></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>`;
                                        $('#tbody_cartas_oferta').html(fila);                        
                                    }
                                }
                            }
                            else
                            {
                                // Ocultar botones y actualizar UI
                                $('#' + doc + '_file').val('');
                                $('#div_name_docs_' + doc).addClass('d-none');
                                $('#input_name_docs_' + doc).removeClass('d-none');
                                $('#bto_up_' + doc).removeClass('d-none');
                                $('#bto_down_' + doc).addClass('d-none');
                                $('#bto_view_' + doc).addClass('d-none');
                                $('#bto_del_' + doc).addClass('d-none');
                            }
                        }
                        bien(data.message); 
                    },
                    error: function(xhr) {
                        if(doc!='cartaofl')
                        {   console.error("Error al intentar eliminar el documento adjunto:", xhr.responseText);
                            mal("Error al intentar eliminar el documento adjunto:", xhr.responseText);
                        }else{
                               console.error("Error al intentar eliminar la carta oferta", xhr.responseText);
                            mal("Error al intentar eliminar la carta oferta", xhr.responseText);
                        } 
                    }
            
                });
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
        
    function upfile(doc)
    {  
        const input = document.getElementById(doc+'_file');
        const file = input.files[0];
        const id_curri= $('#reclutamiento_id_curri').val();
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
                $('#div_name_docs_'+doc).removeClass('d-none');
                $('#input_name_docs_'+doc).addClass('d-none');
                $('#div_name_docs_'+doc).html(res.f_create+ "-" +res.nombre+"<input type='hidden' id='v_file_"+doc+"' value='"+res.downdoc+"'> <input type='hidden' id='file_"+doc+"' value="+res.id_doc+"> <a id='link_"+doc+"' href='"+res.downdoc+"' download='"+doc+"_"+$('#nom_reg').html()+"' target='_blank'></a>");                                                                                                                                                                                                 
                $('#bto_up_'+doc).addClass('d-none');
                $('#bto_down_'+doc).removeClass('d-none');
                $('#bto_view_'+doc).removeClass('d-none');
                $('#bto_del_'+doc).removeClass('d-none');
                bien(res.message);
            },
            error: function (err) {
                console.error(err);
                mal("Error al procesar el PDF. Asegúrate de que el archivo sea correcto.");
            }
        });
    }

    function saveentrevista_ini() {

        if ($('#fecha_entrevista').html().length > 0) {
            Swal.fire({
                icon: "question",
                text: "¿Se actualizará la fecha de la entrevista, desea continuar?",
                showCancelButton: true,
                cancelButtonText: '<i class="fas fa-arrow-left"></i> Cancelar',
                confirmButtonText: '<i class="fa-solid fa-plus"></i> Si, Continuar',
                confirmButtonColor: "#0D6EFD",
            }).then((result) => {
                if (result.isConfirmed) {
                    ejecutar_guardado_entrevista(); // Aquí llamas la lógica principal
                }
            });
        } else {
            ejecutar_guardado_entrevista(); // Si ya hay fecha, procede directo
        }
    }

    function ejecutar_guardado_entrevista() {
        let preguntas_respuestas = [];
        let valido = true;
        let salario_valor = $('#salario_actual').val().trim();
        let asp_valor = $('#aspiracion_salarial').val().trim();
        let data = {
            _token: $('input[name="_token"]').val(),
            id_participante: $('#reclutamiento_id_participante').val(),
            id_curri: $('#reclutamiento_id_curri').val(),
            id_ofl: $('#id_ofl').val(),
            trabajando: $('input[name="trabajando"]:checked').val(),
            empresa: $('#empresa_actual').val().trim(),
            puesto: $('#puesto_actual').val().trim(),
            salario: salario_valor !== '' ? parseFloat(salario_valor) : null,
            beneficios: $('#beneficios').val().trim(),
            aspiracion_salarial: asp_valor !== '' ? parseFloat(asp_valor) : null,
            comentarios_adicionales: $('#comentarios_adicionales').val().trim(),
        };

        if (data.trabajando === 's') {
            if (
                data.empresa === '' ||
                data.puesto === '' ||
                isNaN(data.salario) || data.salario <= 0 ||
                data.beneficios === ''
            ) {
                mal(`Es importante llenar todos los campos de la entrevista si está trabajando.`);
                return;
            }
        }

        if (isNaN(data.aspiracion_salarial) || data.aspiracion_salarial <= 0) {
            mal(`Debe indicar su aspiración salarial válida.`);
            return;
        }

        $('#div_nuevas_preg .pregunta-item').each(function (index) {
            let pregunta = $(this).find('.pregunta').val().trim();
            let respuesta = $(this).find('.respuesta').val().trim();

            if ((pregunta && !respuesta) || (!pregunta && respuesta)) {
                mal(`La pregunta #${index + 1} debe tener tanto pregunta como respuesta.`);
                valido = false;
                return false;
            }

            if (pregunta !== '' && respuesta !== '') {
                preguntas_respuestas.push({
                    pregunta: pregunta,
                    respuesta: respuesta
                });
            }
        });

        if (!valido) return;

        data.preguntas = preguntas_respuestas;

        $.ajax({
            url: "{{ route('ofertas.save_entrevista_ini') }}",
            method: "POST",
            data: data,
            success: function (response) {
                if (response.success) {
                    bien('Guardado correctamente');
                    $('#lb_fecha_entrevista').html('Fecha de entrevista:');
                    $('#fecha_entrevista').html(response.fecha_actualizacion); 
                    $('#lb_entrevista_por').html('Entrevistado por:');
                    $('#entrevista_por').html(response.por);
                } else {
                    mal('Error: ' + response.message);
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                mal('Ocurrió un error al guardar la entrevista.');
            }
        });
    }

    function add_preg()
    {   let actual = parseInt($('#num_preg').val()) || 0;
        let num = actual + 1;
        $('#num_preg').val(num);
        $('#div_nuevas_preg').append(`    
            <div class="row  pregunta-item" id="fil_${num}">   
                <div class="col-6">
                    <input type="text" name="preguntas[]" class="form-control form-control-sm pregunta" maxlength="255"  placeholder="Nueva pregunta...">
                </div>
                <div class="col-5">
                    <input type="text" name="respuestas[]" class="form-control form-control-sm respuesta" maxlength="255" placeholder="Respuesta...">
                </div>
                <div class="col-1 d-flex align-items-center justify-content-start">
                    <i class="fa-solid fa-trash-can dell" onclick=delrowpreg(${num}) title="Eliminar pregunta"></i>
                </div>
            <hr class="my-2 ">
            </div>`);

    }

    function delrowpreg(num)
    {
        $('#fil_'+num).remove();
    }

    function muestra_div_labora() {
        if ($('#trabajando_s').is(':checked')) {
            $('#div_si_labora').removeClass('d-none');
            // Limpiar los inputs dentro del div
            $('#div_si_labora input').val('');
            $('#empresa_actual').focus();
            
        } else {
            $('#div_si_labora').addClass('d-none');
            // Limpiar los inputs dentro del div
            $('#div_si_labora input').val('');
            $('#aspiracion_salarial').focus();
        }
    }

    // ----- FILTAR CANDIDATOS PARA AGREGAR A OFERTA LABORAL
    function find_candidate() {
        const _token = $('input[name="_token"]').val();
        let ids = '';

        if ($('#sel_f_by').val() == 1) {
            ids = $('#mail').val().trim();
        }
        if ($('#sel_f_by').val() == 2) {
            ids = $('#sel_area').val().trim();
        }

        if (ids.length > 0) {
            const parametros = {
                "_token": _token,
                "ids": ids,
                "id_ofl": $('#id_ofl').val(),
                "opt": $('#sel_f_by').val()
            };

            const table = $('#MyTable');
            const tbody = table.find('tbody');

            $.ajax({
                data: parametros,
                url: "{{ route('ofertas.findcandidate') }}",
                type: 'POST',
                dataType: "json",
                cache: true,
                beforeSend: function() {
                    tbody.empty();
                    tbody.append(`
                        <tr>
                        <td colspan="6" class="text-center">
                            <div class="d-flex justify-content-center align-items-center" style="height: 20vh;" id="div_spinner">
                            <div class="spinner-border text-primary me-2" role="status"></div>
                            <span>Cargando...</span>
                            </div>
                        </td>
                        </tr>
                    `);
                },
                success: function(data) {
                    const candidatos = data.candidatos;
                    const procesos = data.procesos;
                    const experiencias = data.experiencias;
                    if ($.fn.DataTable.isDataTable('#MyTable')) {
                        table.DataTable().clear().destroy();
                    }
                    if (candidatos.length === 0) {
                        table.DataTable({
                            columnDefs: [{ className: "align-middle" }]
                        });
                        tbody.empty();
                        tbody.append(`<tr><td colspan="6" class="text-center text-danger">No se encontraron registros</td></tr>`);
                    } else {
                        candidatos.forEach(function(e) {
                            const nombre_completo = e.prinombre + ' ' + e.priapellido;

                            let proc = '';
                            procesos.forEach(function(p) {
                                if (p.id_curri === e.id) {
                                    proc += `<li>${p.id_ofl} - ${p.puesto}</li>`;
                                }
                            });

                            let exp = '';
                            experiencias.forEach(function(p) {
                                if (p.id === e.id) {
                                    exp += `<li>${p.subarea}</li>`;
                                }
                            });

                            tbody.append(`
                                <tr>
                                    <td class="text-center align-middle" style="background:#e2e2e2;">
                                        <input type="checkbox" style="font-size: 16px" class="form-check-input checkbox-candidato" value="${e.id}">
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            <img src="${e.foto_mostrar}" alt="Foto de ${nombre_completo}" class="rounded-circle" style="background:#FFFFFF; width: 60px; height: 60px; object-fit: cover; border: 1px solid #aeafb0;">
                                        </div>
                                        <div>
                                            <div class="fw-bold text-uppercase" style="color: #4B6EAD;font-size: 13px"><span id="div_nombre_candidato">${nombre_completo}</span></div>
                                            <div class="text-secondary" style="font-size: 12px"><i class="fa-solid fa-envelope pe-1"></i><span class="text-primary">${e.email}</span></div>
                                            <div class="text-secondary" style="font-size: 12px"><i class="fa-solid fa-phone-flip pe-1"></i>${e.tel}</div>
                                        </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <div>
                                        <div style="color: #4B6EAD;">${e.titulo}</div>
                                        <div class="text-secondary" style="font-size: 11px">${e.entidad} (${e.estatuseduc})</div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-secondary" style="font-size: 12px">
                                        <ul>${exp}</ul>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="${e.cv}" download="Curriculum - ${nombre_completo}" target="_blank" class="text-decoration-none">
                                        <i class="fa-solid fa-download fa-lg" title="Descargar Curriculum"></i>
                                        </a>
                                    </td>
                                    <td class="align-middle text-secondary" style="font-size: 12px">
                                        <ul>${proc}</ul>
                                    </td>
                                </tr>
                            `);
                        });

                        table.DataTable({
                            language: {
                                url: "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                            },
                            columnDefs: [{
                                className: "align-middle",
                                targets: "_all"
                            }],
                            pageLength: 10,
                            ordering: true,
                            searching: true
                        });
                    }
                },
                error: function() {
                    tbody.html(
                        `<tr><td colspan="6" class="text-center text-danger">Error al cargar los datos</td></tr>`
                        );
                }
            });
        }
    }

    // ----- AGREGAR CANDIDATOS SELECCIONADOS A OFERTA LABORAL
    function agregarCandidatosSeleccionados() {
        const _token = $('input[name="_token"]').val();
        const id_oferta = $('#id_ofl').val();

        // Obtener todos los checkboxes marcados
        const seleccionados = [];
        $('.checkbox-candidato:checked').each(function() {
            seleccionados.push($(this).val());
        });

        // Validar si hay seleccionados
        if (seleccionados.length === 0) {
            mal("Por favor, seleccione al menos un candidato.");
            return;
        }

        // Confirmación (opcional)
        Swal.fire({
            icon: "question",
            text: "¿Está seguro de que desea agregar los candidatos seleccionados a la oferta?",
            showCancelButton: true,
            cancelButtonText: '<i class="fas fa-arrow-left"></i> Cancelar',
            confirmButtonText: '<i class="fa-solid fa-plus"></i> Si, agregar',
            confirmButtonColor: "#0D6EFD",

            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                // Enviar por AJAX
                $.ajax({
                    url: "{{ route('ofertas.agregarcandidatos') }}", // Asegúrate de tener esta ruta
                    type: "POST",
                    data: {
                        _token: _token,
                        id_oferta: id_oferta,
                        candidatos: seleccionados
                    },
                    success: function(response) {
                        bien("Candidatos agregados correctamente.");
                        mod_prospectos(id_oferta); // Volver a cargar los resultados
                        $('#modal_add_candidato').modal('hide');

                    },
                    error: function() {
                        mal("Hubo un error al agregar los candidatos. Intente nuevamente.");
                    }
                });
            }
        });


    }

    function filterby(val) {
        $('#id_find_email').addClass('d-none');
        $('#id_find_area').addClass('d-none');
        $('#mail').val('');
        $('#bto_f').addClass('d-none');
        if (val == 1) {
            $('#id_find_email').removeClass('d-none');
            $('#bto_f').removeClass('d-none');
        }
        if (val == 2) {
            $('#id_find_area').removeClass('d-none');
            $('#bto_f').removeClass('d-none');
        }
    }

    //----- MODAL AGREGA CANDIDATO
    function add_candidate() {
        $('#sel_f_by').val(0);
        $('#modal_add_candidato').modal('show');
        $('#id_find_email').addClass('d-none');
        $('#mail').val('');
        $('#id_find_area').addClass('d-none');
        $('#bto_f').addClass('d-none');
        let table = $('#MyTable').DataTable();
        table.clear().draw();
    }

    //----- VER DETALLE CANDIDATO PARA EL PROCESO DE LA CONTRATACIÓN
    function ver_det_candidate(id_curri, id_participante) {
        // Limpiar los campos primero
        $('#reclutamiento_id_curri').val(id_curri);
        $('#reclutamiento_id_participante').val(id_participante);
        $('#div_foto_reg').html('');
        $('#nom_reg').html('');
        $('#mail_reg').html('');
        $('#tel_reg').html('');
        $('#res_reg').html('');
        $('#ver_calce').addClass('d-none');
        $('input[type="file"]').val('');
        $('#bto_up_rp').removeClass('d-none');
        $('#bto_down_rp').addClass('d-none');
        $('#bto_view_rp').addClass('d-none');
        $('#bto_del_rp').addClass('d-none');
        $('#div_name_docs_rp').addClass('d-none');
        $('#input_name_docs_rp').removeClass('d-none');
        $('#div_name_docs_rp').html('');
        //<a href="+e.nomdoc+" download="+e.iddoc+"_"+nombre+"></a>
        $('#bto_up_ced').removeClass('d-none');
        $('#bto_down_ced').addClass('d-none');
        $('#bto_view_ced').addClass('d-none');
        $('#bto_del_ced').addClass('d-none');
        $('#div_name_docs_ced').addClass('d-none');
        $('#input_name_docs_ced').removeClass('d-none');
        $('#div_name_docs_ced').html('');
        
        $('#bto_up_cn').removeClass('d-none');
        $('#bto_down_cn').addClass('d-none');
        $('#bto_view_cn').addClass('d-none');
        $('#bto_del_cn').addClass('d-none');
        $('#div_name_docs_cn').addClass('d-none');
        $('#input_name_docs_cn').removeClass('d-none');
        $('#div_name_docs_cn').html('');
        
        $('#bto_up_dpl').removeClass('d-none');
        $('#bto_down_dpl').addClass('d-none');
        $('#bto_view_dpl').addClass('d-none');
        $('#bto_del_dpl').addClass('d-none');
        $('#div_name_docs_dpl').addClass('d-none');
        $('#input_name_docs_dpl').removeClass('d-none');
        $('#div_name_docs_dpl').html('');

        $('#bto_up_css').removeClass('d-none');
        $('#bto_down_css').addClass('d-none');
        $('#bto_view_css').addClass('d-none');
        $('#bto_del_css').addClass('d-none');
        $('#div_name_docs_css').addClass('d-none');
        $('#input_name_docs_css').removeClass('d-none');
        $('#div_name_docs_css').html('');

        $('#bto_up_dir').removeClass('d-none');
        $('#bto_down_dir').addClass('d-none');
        $('#bto_view_dir').addClass('d-none');
        $('#bto_del_dir').addClass('d-none');
        $('#div_name_docs_dir').addClass('d-none');
        $('#input_name_docs_dir').removeClass('d-none');
        $('#div_name_docs_dir').html('');

        $('#bto_up_fto').removeClass('d-none');
        $('#bto_down_fto').addClass('d-none');
        $('#bto_view_fto').addClass('d-none');
        $('#bto_del_fto').addClass('d-none');
        $('#div_name_docs_fto').addClass('d-none');
        $('#input_name_docs_fto').removeClass('d-none');
        $('#div_name_docs_fto').html('');
        
        $('#div_entrevistas').html('');
        $('#num_entrevistas').val(0);
        id_ofl = $('#id_ofl').val();
        $('#alert_estatus').addClass('d-none');

        // Preparar datos
        var _token = $('input[name="_token"]').val();
        var parametros = {
            "_token": _token,
            "id_curri": id_curri,
            "id_ofl": id_ofl,
            "id_participante": id_participante
        };

        // Enviar petición AJAX
            $.ajax({
                data: parametros,
                url: "{{ route('ofertas.ver_det_candicate') }}",
                type: 'POST',
                dataType: "json",
                cache: true,            
                beforeSend: function() {
                    $('#bto_listado_candidato').addClass('d-none');
                    $('#div_oferta_laboral').addClass('d-none');
                    $("#div_spinner").removeClass('d-none');                
                },
                success: function(data) {
                    const datos = data.datos_personales[0];
                    const estudios = data.educacion;
                    const cursos = data.cursos;
                    const otrosconocimientos = data.otrosconocimientos[0];
                    const referencia_personal = data.referencia_personal;
                    const experiencia_laboral = data.experiencia_laboral;
                    const familiares = data.familiares;
                    const dependientes = data.dependientes;
                    const prueba_disc = data.prueba_disc;
                    const prueba_razi = data.prueba_razi;
                    const prueba_veritas = data.prueba_veritas;
                    const datos_calce = data.datos_calce;
                    const prueba_apl = data.prueba_apl;
                    const promedio_calce = data.promedio_calce;
                    const entrevista_ini = data.entrevista_ini;
                    const docs = data.docs;       
                    const entrevistas_funcionales = data.data_entrevista_fun;
                    const candidato = data.candidato;
                    const cartas_ofertas = data.cartas_ofertas;
                    const beneficios = data.beneficios;
                    let nombre =datos.prinombre + " " + datos.priapellido;

                    $("#div_spinner").addClass('d-none');
                    $('#bto_volver_det_candidato').removeClass('d-none');
                    $('#Detalle-Candidato').removeClass('d-none');
                // Datos personales
                    $('#nom_reg').html(datos.prinombre + " " + datos.priapellido);
                    $('#candidato_p1').html(datos.prinombre + " " + datos.priapellido);
                    $('#candidato_p2').html(datos.prinombre + " " + datos.priapellido);
                    $('#candidato_l1').html(datos.prinombre + " " + datos.priapellido);
                    $('#mail_reg').html(datos.email);
                    $('#tel_reg').html(datos.tel);



                    const iniciales = `${(datos.prinombre || '').charAt(0)}${(datos.priapellido || '').charAt(0)}`.toUpperCase();
                    
                    const color_bg = $('#color_bg_'+datos.id).val();
                    const color_tx = $('#color_tx_'+datos.id).val();
                    let fotoHtml = `<img src="${datos.foto}" alt="Foto de ${nombre}" class="rounded-circle" style="background:#FFFFFF; width: 120px; height: 120px; object-fit: cover; border: 1px solid #aeafb0;">`;
                        if (!datos.foto) {
                            fotoHtml = `
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="
                                width: 120px; height: 120px; background-color: ${color_bg};  border-radius: 50%;  display: flex;  align-items: center;  justify-content: center;  color: ${color_tx};  font-family: 'Segoe UI', 'Roboto', sans-serif;
                                font-size: 50px;  text-transform: uppercase;  border: 1px solid ${color_tx}">
                                    ${iniciales}
                                </div>`;
                        }

                    $('#div_foto_reg').html(fotoHtml);
                    $('#res_reg').html(datos.prov_residencia);
                    $('#cv_reg').html('<span id="name_file_cv">Hoja de Vida</span> <input type="hidden" id="v_file_cv" value="' + datos.cv_doc + '"> <a id="link_cv" href="' + datos.cv_doc + '" download="Curriculum - ' + datos.prinombre + " " + datos.priapellido + '" target="_blank"></a>');

                    $('#lb_nombre').html(datos.nom_completo);
                    $('#lb_apellido').html(datos.apl_completo);
                    $('#lb_fnac').html(datos.f_nacimiento);
                    $('#lb_tipo_doc').html(datos.tipo_doc);
                    $('#lb_num_doc').html(datos.num_doc);
                    $('#lb_css').html(datos.num_ss);
                    $('#lb_ecivil').html(datos.estadocivil);
                    $('#lb_nacionalidad').html(datos.nacionalidad);
                    $('#lb_dir').html(datos.dir);
                    $('#lb_tel').html(datos.tel);
                    $('#lb_email').html(datos.email);

                    if (datos.id_nacionalidad != 53) {
                        $('#div_permiso, #div_fpermiso, #div_dpermiso').removeClass('d-none');
                        $('#lb_permiso').html(datos.permiso_trab);
                        $('#lb_permiso_vencimiento').html(datos.f_vence_permiso_trab);
                        if (datos.permiso_doc && datos.permiso_doc !== '-') {
                            $('#lb_permiso_atach').html(`<a href="${datos.permiso_doc}" download target="_blank" class="text-decoration-none"><i class="fa-solid fa-download ps-1"></i> Descargar Permiso</a>`);
                        }
                    }

                // Seguridad
                    $('#lb_tipo_sangre').html(datos.tipo_sangre);
                    $('#lb_medico_cabecera').html(datos.medico);
                    $('#lb_hospital').html(datos.hospital);
                    $('#lb_tel_hospital').html(datos.tel_medico);
                    $('#lb_alergico_medicamento').html(datos.sufre_alergia_medicamento);
                    $('#lb_nom_medicamento').html(datos.medicamento);
                    $('#lb_discapacidad').html(datos.discapacidad);
                    $('#lb_det_discapacidad').html(datos.detalle_descapacidad);
                    $('#lb_lesion_laboral').html(datos.sufre_lesion_laboral);
                    $('#lb_det_lesion').html(datos.lesion_laboral);
                    $('#lb_contacto_urgencia').html(datos.contacto_urgencia);
                    $('#lb_parentesco_urgencia').html(datos.parentesco_urgencia);
                    $('#lb_tel_urgencia').html(datos.tel_urgencia);


                // Educación
                    const tbody = $('#tbl_educacion tbody');
                    tbody.empty();

                    if (estudios.length === 0) {
                        tbody.append(`<tr><td colspan="5" class="text-center">No hay estudios registrados</td></tr>`);
                    } else {
                        estudios.forEach(function (e) {
                            tbody.append(`
                                <tr>
                                    <td class="ps-2">${e.titulo}</td>
                                    <td class="ps-2">${e.entidad}</td>
                                    <td class="ps-2">${e.ano}</td>
                                    <td class="ps-2">${e.nivel_educ}</td>
                                    <td class="ps-2">${e.estatuseduc}</td>
                                </tr>
                            `);
                        });
                    }

                    // Cursos
                    const tbodyc = $('#tbl_cursos tbody');
                    tbodyc.empty();

                    if (cursos.length === 0) {
                        tbodyc.append(`
                            <tr><td colspan="3" class="text-center">No hay cursos o seminarios registrados</td></tr>
                        `);
                    } else {
                        cursos.forEach(function (e) {
                            tbodyc.append(`
                                <tr>
                                    <td class="ps-2">${e.nombre}</td>
                                    <td class="ps-2">${e.entidad}</td>
                                    <td class="ps-2">${e.ano}</td>
                                </tr>
                            `);
                        });
                    }

                // Otros Conocimientos             
                    if(otrosconocimientos)   
                        {$('#lb_espanol').html(otrosconocimientos.espanol);
                        $('#lb_ingles').html(otrosconocimientos.ingles);
                        $('#lb_pc').html(otrosconocimientos.computadora);
                        $('#lb_word').html(otrosconocimientos.word);
                        $('#lb_excel').html(otrosconocimientos.excel);
                        $('#lb_ppt').html(otrosconocimientos.powerpoint);
                        $('#lb_otros').html(otrosconocimientos.otros);
                        $('#lb_sedan').html(otrosconocimientos.sedan);
                        $('#lb_camion').html(otrosconocimientos.camion);
                        $('#lb_trailer').html(otrosconocimientos.trailer);
                        $('#lb_moto').html(otrosconocimientos.moto);
                        $('#lb_montacargas').html(otrosconocimientos.montacarga);}

                // Experiencia personal
                    const tbodyrp = $('#ref_personal tbody');
                    const tbodyrp_validacion =$('#valida_ref_personal tbody');
                    tbodyrp_validacion.empty();
                    tbodyrp.empty();

                    if (referencia_personal.length === 0) {
                        tbodyrp.append(`<tr><td colspan="3" class="text-center">No hay referencias personales registradas</td></tr>`);
                        tbodyrp_validacion.append(`<tr><td colspan="6" class="text-center text-secondary">No hay referencias personales registradas</td></tr>`);
                    } else {
                        var i=0;
                        referencia_personal.forEach(function (e) {
                            i++;
                            tbodyrp.append(`
                                <tr>
                                    <td class="ps-2">${e.nombre}</td>
                                    <td class="ps-2">${e.direccion}</td>
                                    <td class="ps-2">${e.telefono}</td>
                                </tr>
                            `);

                            let bto = '';
                            if (e.validado_por == null) {
                                bto = `<button id="btn_ref_p_${e.id}" onclick="validar_ref(${e.id},'p')" class="btn py-0 btn-sm btn-outline-primary" title="Validar Referencia">  
                                        <i class="fa-solid fa-check pe-1"></i>Validar 
                                    </button>`;
                            } else {
                                bto = `<button id="btn_ref_p_${e.id}" onclick="validar_ref(${e.id},'p')" class="btn py-0 btn-sm btn-success" title="Validar Referencia">  
                                        <i class="fa-solid fa-check-double pe-1"></i>Validado 
                                    </button>`;
                            }

                            tbodyrp_validacion.append(`
                                <tr>
                                    <td class="ps-2 text-start align-middle" id="nom_ref_p_${e.id}">${e.nombre}</td>
                                    <td class="ps-2 text-center align-middle">${e.direccion}</td>
                                    <td class="ps-2 text-center align-middle" id="tel_ref_p_${e.id}">${e.telefono}</td>
                                    <td class="ps-2 text-center align-middle">${bto}</td>
                                </tr>
                            `);
                        });
                    }

                    const lis_exp_lab = $('#lis_exp_lab');
                    const validar_lis_exp_lab = $('#validar_lis_exp_lab');
                    validar_lis_exp_lab.empty();
                    lis_exp_lab.empty();
                    
                    if(experiencia_laboral.length===0)
                    {   const mensaje = '<div class="text-center"> No tiene experiencia laboral.</div>';
                        lis_exp_lab.append(mensaje);
                        validar_lis_exp_lab.append(mensaje);
                    }else{
                        i=0;
                    
                        if (experiencia_laboral.length === 0) {
                            const mensaje = '<div class="text-center"> No tiene experiencia laboral.</div>';
                            lis_exp_lab.append(mensaje);
                            validar_lis_exp_lab.append(mensaje);
                        } else {
                            experiencia_laboral.forEach((e, i) => {
                                const index = i + 1;
                                lis_exp_lab.append(generarHTMLExperiencia(e, index));
                                validar_lis_exp_lab.append(generarHTMLExperiencia(e, index, true));
                            });
                        }
                        
                    }

                // Familiares en la empresa
                    const tbodyfm = $('#lis_familiares tbody');
                    tbodyfm.empty();

                    if (familiares.length === 0) {
                        tbodyfm.append(`
                            <tr><td colspan="3" class="text-center">No tiene familiares trabajando en al compañía</td></tr>
                        `);
                    } else {
                        familiares.forEach(function (e) {
                            tbodyfm.append(`
                                <tr>
                                    <td class="ps-2">${e.nombre}</td>
                                    <td class="ps-2">${e.parentesco}</td>
                                    <td class="ps-2">${e.unidad}</td>
                                </tr>
                            `);
                        });
                    }

                // Dependeintes
                    const tbodydp = $('#lis_dependientes tbody');
                    tbodydp.empty();

                    if (dependientes.length === 0) {
                        tbodydp.append(`
                            <tr><td colspan="3" class="text-center">No tiene dependientes</td></tr>
                        `);
                    } else {
                        dependientes.forEach(function (e) {
                            tbodydp.append(`
                                <tr>
                                    <td class="ps-2">${e.nombre}</td>
                                    <td class="ps-2">${e.parentesco}</td>
                                    <td class="ps-2">${e.f_nacimiento}</td>
                                </tr>
                            `);
                        });
                    }

                    $('#chk_lb_viajar').html(iconoCheck(datos.disponibilidad_viajar));
                    $('#chk_lb_psico').html(iconoCheck(datos.examen_psicometrico));
                    $('#chk_lb_verificar_info').html(iconoCheck(datos.verificar_informacion));
                    $('#chk_lb_afirmacion').html(iconoCheck(datos.informacion_verdadera));

                // DISC
                    if (prueba_disc) {
                        $('#fecha_disc').html(prueba_disc.fecha_realizada ?? '');
                        $('#disc_d').val(prueba_disc.puntaje_d ?? '');
                        $('#disc_i').val(prueba_disc.puntaje_i ?? '');
                        $('#disc_s').val(prueba_disc.puntaje_s ?? '');
                        $('#disc_c').val(prueba_disc.puntaje_c ?? '');
                        if (!prueba_disc.informe) {
                            $('#archivo_disc').html('');
                        } else {
                            $('#archivo_disc').html(
                                `<a href="${prueba_disc.informe}" download target="_blank" class="text-decoration-none">
                                    <i class="fa-solid fa-download"></i> Descargar DISC
                                </a>`
                            );
                        }
                    } else {
                        $('#fecha_disc').html('');
                        $('#disc_d').val('');
                        $('#disc_i').val('');
                        $('#disc_s').val('');
                        $('#disc_c').val('');
                        $('#archivo_disc').html('');
                    }
            
                // APL
                    if(prueba_apl)
                    {    $('#fecha_apl').html(prueba_apl.fecha_realizada ?? '');
                        if (datos_calce.length === 0) {
                            $('#calce_apl').val('');
                        } else {
                            let total_porcentaje = 0;
                            let cantidad = 0;

                            // Limpiar contenedores
                            $('#comp_cri').html('');
                            $('#comp_imp').html('');
                            $('#comp_mimp').html('');
                            let comp = [];
                            let prf = [];
                            let opt = [];
                            // Procesar cada competencia
                            datos_calce.forEach(function (e) {
                                let esperado = 0;
                                let div = '';
                                comp.push(e.competencia);    
                                prf.push(e.esperado);    
                                opt.push(e.puntaje);

                                if (e.esperado == 10) {
                                    esperado = 80;
                                    div = 'cri';
                                } else if (e.esperado == 9) {
                                    esperado = 70;
                                    div = 'mimp';
                                } else if (e.esperado == 8) {
                                    esperado = 60;
                                    div = 'imp';
                                } else {
                                    return; // Competencia no clasificada
                                }

                                const left = (e.puntaje * 20) + 10;

                                total_porcentaje += e.porcentaje;
                                cantidad++;

                                // Insertar bloque HTML
                                $('#comp_' + div).append(`
                                    <div style="font-size: 11px; color: ${e.color}" class="pb-1 fw-semibold">${e.competencia}</div>
                                    <div class="col-12 small mb-2" style="position: relative;">
                                        <div class="circle bg-primary text-white"
                                            style="font-size: 12px; border: 1px solid white; top:-5px; position: absolute; 
                                                    left: ${left}px; width: 20px; height: 20px; border-radius: 50%; 
                                                    text-align: center; line-height: 20px; z-index: 10;">
                                            ${e.puntaje}
                                        </div>
                                        <div class="progress" style="position: relative; height: 10px; width: 220px;">
                                            <div class="progress-bar" style="background-color: #e9ecef; width: ${esperado}%"
                                                role="progressbar" aria-valuenow="${esperado}" aria-valuemin="0" aria-valuemax="100"></div>
                                            <div class="progress-bar bg-secondary" style="width: 20%"
                                                role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                `);
                            });

                            // Calcular promedio de porcentajes                       
                            
                                $('#calce_apl').val(promedio_calce+'%');
                                $('#calce_total').html('');
                                $('#calce_total').append(`
                                    <div class="pb-1 ms-2 text-start text-secondary fw-semibold h6">Porcentaje de ajuste al puesto</div>
                                    <div class="col small mb-3" style="position: relative;">
                                        <div class="circle bg-info text-white align-middle text-center pt-1 fw-semibold" style="font-size: 16px; border: 1px solid white; top:-5px; position: absolute; left: ${promedio_calce}%; width: 30px; height: 30px; border-radius: 50%; text-align: center; line-height: 20px; z-index: 10;">
                                                ${promedio_calce}
                                        </div>
                                        <div class="progress" style="position: relative; height: 20px; ">
                                            
                                        </div>
                                    </div>
                                `);


                            
                            if (!prueba_apl.informe) {
                                $('#archivo_apl').html('<span class="text-secondary">No tiene informe APL</span>');
                            } else {
                                $('#archivo_apl').html(`<a href="${prueba_apl.informe}" download target="_blank" class="ps-4 text-decoration-none"> <i class="fa-solid fa-download"></i> Descargar APL </a>`);
                                $('#ver_calce').removeClass('d-none');
                            }

                            Highcharts.chart('container_area', {
                                chart: {
                                    polar: true, // Se usa el gráfico polar para crear el radar
                                    type: 'line', // Tipo de gráfico
                                },

                                title: {
                                    text: null,
                                    style: {
                                        fontSize: '20px',
                                        fontWeight: 'bold',
                                    }
                                },

                                subtitle: {
                                    text: null,
                                },

                                xAxis: {
                                    categories: comp,
                                    tickInterval: 1,
                                    labels: {
                                        style: {
                                            fontSize: '9px',
                                            color: '#666' // Color más suave para las etiquetas del eje X
                                        }
                                    },
                                    lineWidth: 0, // No líneas en el eje X
                                    maxPadding: 0.1 // Espaciado adicional en el eje X para etiquetas
                                },

                                yAxis: {
                                    min: 0,
                                    max: 10,
                                    title: null,
                                    labels: {
                                        formatter: function () {
                                            // Solo mostrar etiquetas para el valor mínimo y máximo
                                            if (this.value === 0 || this.value === 10) {
                                                return this.value; // Mostrar solo 0 y 10
                                            } else {
                                                return ''; // No mostrar ninguna etiqueta en los valores intermedios
                                            }
                                        }
                                    },
                                    gridLineWidth: 1, // Líneas de la cuadrícula para el radar
                                    gridLineColor: '#ccc', // Color de las líneas de la cuadrícula
                                    gridLineDashStyle: 'Dot', // Estilo de las líneas punteadas
                                    lineWidth: 0
                                },

                                plotOptions: {
                                    series: {
                                        pointStart: 0,
                                        pointInterval: 1,
                                        marker: {               
                                        radius: 0, // Ajustamos el tamaño de los puntos para mejorar la visibilidad
                                            symbol: null,
                                            lineWidth: 2, // Ancho de la línea del marcador
                                            lineColor: '#ffffff' // Color blanco para el borde de los puntos
                                        },
                                        lineWidth: 2 // Aumentamos el grosor de las líneas para mejorar la visibilidad
                                    },
                                    area: {
                                        fillOpacity: 0.4 // Transparencia del área para hacerlo menos intrusivo
                                    }
                                },

                                series: [
                                    {
                                    name: 'Perfil del Puesto',
                                    type: 'line',
                                    data: prf.map(value => value > 5 ? value : 0), // Establece los valores menores a 5 en 0 para no marcar color
                                    color: '#47D45A', // Color verde solo para los valores de prf por encima de 5
                                        marker: {
                                            lineColor: '#47D45A',
                                            radius: 1, // Ajustamos el tamaño de los puntos para mejorar la visibilidad
                                            symbol: 'circle',
                                            lineWidth: 2, // Ancho de la línea del marcador
                                        },
                                    zIndex: 1
                                    },
                                    {
                                        name: 'Perfil de Persona',
                                        type: 'line', // Tipo de gráfico para la serie de línea
                                        data: opt, // Datos de la evaluación real
                                        color: '#066CFD', // Azul para la competencia real
                                        marker: {
                                            lineColor: '#066CFD',
                                            radius: 3, // Ajustamos el tamaño de los puntos para mejorar la visibilidad
                                            symbol: 'circle',
                                            lineWidth: 2, // Ancho de la línea del marcador
                                        },
                                        zIndex: 2, // Asegura que la línea quede encima del área
                                        dashStyle: 'Solid' // Estilo sólido para la línea
                                    }
                                ],

                                legend: {
                                    enabled: true,
                                    borderWidth: 1,
                                    borderColor: '#ddd', // Color más suave para el borde de la leyenda
                                    borderRadius: 5,
                                    align: 'center', // Alinea la leyenda al centro
                                    verticalAlign: 'top', // Coloca la leyenda en la parte superior
                                    layout: 'horizontal', // Establece la leyenda de forma horizontal
                                    symbolHeight: 8,
                                    symbolWidth: 17,
                                    symbolRadius: 3,
                                    squareSymbol: false,
                                    itemStyle: {
                                        fontSize: '12px',
                                        fontWeight: 'bold',
                                        color: '#333' // Color consistente con el título
                                    },
                                    itemHoverStyle: {
                                        color: '#066CFD' // Color de la leyenda cuando se pasa el ratón
                                    }
                                },
                            });
                        }
                    }
                    else{
                        $('#fecha_apl').html('');
                        $('#calce_apl').val('');
                        $('#calce_total').html('');
                        $('#archivo_apl').html('');
                    }


                // RAZI
                    if(prueba_razi)
                    {   $('#fecha_razi').html(prueba_razi.fecha_realizada);
                        $('#razi_v').val(prueba_razi.puntaje_v);
                        $('#razi_n').val(prueba_razi.puntaje_n);
                        $('#razi_a').val(prueba_razi.puntaje_a);
                        $('#razi_gen').val(prueba_razi.general);
                        
                        if (prueba_razi.informe === null || prueba_razi.informe === '-') {
                            $('#archivo_razi').html('<span class="text-secondary">No tiene informe RAZI</span>');
                        } else {
                            $('#archivo_razi').html(
                                `<a href="${prueba_razi.informe}" download target="_blank" class="text-decoration-none">
                                    <i class="fa-solid fa-download"></i> Descargar RAZI
                                </a>`
                            );
                        }
                    }else{
                        $('#fecha_razi').html('');
                        $('#razi_v').val('');
                        $('#razi_n').val('');
                        $('#razi_a').val('');
                        $('#razi_gen').val('');
                        $('#archivo_razi').html('');
                    }
                // Veritas
                    if(prueba_veritas)
                    {   $('#fecha_veritas').html(prueba_veritas.fecha_realizada);
                        $('#veritas_result').val(prueba_veritas.puntaje);

                        if (prueba_veritas.informe === null || prueba_veritas.informe === '-') {
                            $('#archivo_veritas').html('<span class="text-secondary">No tiene informe Veritas</span>');
                        } else {
                            $('#archivo_veritas').html(
                                `<a href="${prueba_veritas.informe}" download target="_blank" class="text-decoration-none">
                                    <i class="fa-solid fa-download"></i> Descargar Veritas
                                </a>`
                            );
                        }
                    }else{
                        $('#fecha_veritas').html('');
                        $('#veritas_result')[0].selectedIndex = 0;
                    }   

                    $('#div_si_labora input').val('');
                    $('#div_si_labora').addClass('d-none');
                    $('input[name="trabajando"][value="n"]').prop("checked", true);                    
                    $('#aspiracion_salarial').val('');
                    $('#comentarios_adicionales').val('');
                    $('#div_nuevas_preg').html('');
                    $('#lb_fecha_entrevista').html('');
                    $('#fecha_entrevista').html('');
                    $('#lb_entrevista_por').html('');
                    $('#entrevista_por').html('');
                
                // Entrevista Inicial
                    if(entrevista_ini)
                    {   $('input[name="trabajando"][value="' + data.entrevista_ini.esta_laborando + '"]').prop("checked", true);  
                        $('#empresa_actual').val(data.entrevista_ini.empresa_actual);
                        $('#aspiracion_salarial').val(data.entrevista_ini.aspiracion_salarial);
                        $('#comentarios_adicionales').val(data.entrevista_ini.comentarios_adicionales);
                        if(data.entrevista_ini.esta_laborando=='s'){    $('#div_si_labora').removeClass('d-none');
                            $('#puesto_actual').val(data.entrevista_ini.posicion_actual);
                            $('#salario_actual').val(data.entrevista_ini.salario_actual);
                            $('#beneficios').val(data.entrevista_ini.beneficios_adicionales);
                        }
                        if(entrevista_ini)
                        {   
                            let actual = 0;
                            let num = actual + 1;
                            $('#num_preg').val(num);
                            entrevista_ini.preguntas.forEach(function (e) {
                                $('#div_nuevas_preg').append(`    
                                    <div class="row  pregunta-item" id="fil_${num}">   
                                        <div class="col-6">
                                            <input type="text" name="preguntas[]" class="form-control form-control-sm pregunta" maxlength="255"  placeholder="Nueva pregunta..." value="${e.pregunta}">
                                        </div>
                                        <div class="col-5">
                                            <input type="text" name="respuestas[]" class="form-control form-control-sm respuesta" maxlength="255" placeholder="Respuesta..." value="${e.respuesta}">
                                        </div>
                                        <div class="col-1 d-flex align-items-center justify-content-start">
                                            <i class="fa-solid fa-trash-can dell" onclick=delrowpreg(${num}) title="Eliminar pregunta"></i>
                                        </div>
                                    <hr class="my-2 ">
                                </div>`);
                            });
                            $('#lb_fecha_entrevista').html('Fecha de entrevista:');
                            $('#fecha_entrevista').html(entrevista_ini.fecha_actualizacion);                             
                            $('#lb_entrevista_por').html('Entrevistado por:');
                            $('#entrevista_por').html(entrevista_ini.por);
                        }
                    }
                // DOCUMENTOS
                    if(docs)
                    {
                    docs.forEach(function (e) {
                        $('#bto_up_'+e.iddoc).addClass('d-none');
                        $('#bto_down_'+e.iddoc).removeClass('d-none');
                        $('#bto_view_'+e.iddoc).removeClass('d-none');
                        $('#bto_del_'+e.iddoc).removeClass('d-none');
                        $('#div_name_docs_'+e.iddoc).removeClass('d-none');
                        $('#input_name_docs_'+e.iddoc).addClass('d-none');
                        $('#div_name_docs_'+e.iddoc).html(e.fecha_registro+ "-"+e.nomdoc+"<input type='hidden' id='v_file_"+e.iddoc+"' value='"+e.downdoc+"'> <input type='hidden' id='file_"+e.iddoc+"' value='"+e.id+"'> <a id='link_"+e.iddoc+"' href='"+e.downdoc+"' download='"+e.iddoc+"_"+$('#nom_reg').html()+"' target='_blank'></a>");
                    }) 
                    }
                // ENTREVISTAS 
                    band_entrevista = 0;

                    // Limpia el div de entrevistas
                    $('#div_entrevistas').empty();

                    // Limpia las clases del estatus
                    $('#alert_estatus')
                    .removeClass('alert-primary alert-danger alert-warning d-none')
                    .addClass('d-none');

                    if (entrevistas_funcionales) {
                        let num = 0;

                        const estados = {
                            porProgramar: {
                                flag: '<i class="fa-solid fa-flag text-warning"></i>',
                                badge: '<span class="badge rounded-pill" style="background-color: #fff3cd; color: #644C06;"><i class="fa-solid fa-triangle-exclamation"></i> Por agendar</span>'
                            },
                            agendada: {
                                flag: '<i class="fa-solid fa-flag text-primary"></i>',
                                badge: '<span class="badge rounded-pill text-primary" style="background-color: #cfe2ff;"><i class="fa-solid fa-people-arrows"></i> Entrevista agendada</span>'
                            },
                            descartado: {
                                flag: '<i class="fa-solid fa-flag text-danger"></i>',
                                badge: '<span class="badge rounded-pill text-danger" style="background-color: #f8d7da;"><i class="fa-solid fa-user-xmark"></i> Candidato descartado</span>'
                            },
                            finalizada: {
                                flag: '<i class="fa-solid fa-flag text-success"></i>',
                                badge: '<span class="badge rounded-pill text-success" style="background-color: #d4edda;"><i class="fa-solid fa-check-double"></i> Entrevista finalizada</span>'
                            }
                        };

                        entrevistas_funcionales.forEach(function (e) {
                            num++;
                            $('#num_entrevistas').val(num);

                            let estado = '';
                            let fecha = e.fecha_formateada || '';
                            let hora = e.hora_formateada || '';
                            let motivo_descarte = '';
                            let detalle_descarte = '';

                            if (candidato.id_etapa >= 6) {
                                if(e.entrevista_realizada==0)
                                {    if (!e.fecha_formateada) {
                                        estado = 'porProgramar';
                                        band_entrevista = 1;
                                    } else {
                                        estado = 'agendada';
                                    }
                                }
                                if(e.entrevista_realizada==1)
                                {   estado = 'finalizada';                                
                                }
                            } else if (candidato.id_etapa == 11 || candidato.id_etapa == 12) {
                                estado = 'descartado';
                            }

                           // $('#alert_estatus').removeClass('alert-primary alert-warning alert-danger alert-secondary alert-success');

                            if (candidato.id_etapa == 11 || candidato.id_etapa == 12) {
                                $('#alert_estatus').removeClass('d-none');
                                $('#alert_estatus').addClass('alert-danger');
                                titulo = candidato.id_etapa == 11 ? '<i class="fa-solid fa-user-xmark fa-lg pe-1"></i> Candidato declinado' : '<i class="fa-solid fa-user-xmark fa-lg pe-1"></i> Candidato descartado';
                                $('#titulo_estatus').html(titulo);
                                motivo = candidato.motivo_descarte || '';
                                detalle = candidato.detalle_descarte || '';
                                $('#motivo_estatus').html(motivo);
                            } else if (candidato.id_etapa >= 6) {
                                $('#alert_estatus').removeClass('d-none');
                                motivo_descarte = '';
                                if(e.entrevista_realizada==0||e.entrevista_realizada==null)
                                {   titulo = band_entrevista ? '<i class="fa-regular fa-calendar-days fa-lg pe-1"></i> Entrevista por programar' : '<i class="fa-solid fa-people-arrows fa-lg pe-1"></i> Entrevista agendada';
                                    if (band_entrevista) {
                                        $('#alert_estatus').addClass('alert-warning');
                                        motivo_descarte = 'Agendar entrevista';
                                    } else {
                                        $('#alert_estatus').addClass('alert-primary');
                                        motivo_descarte = `Número de entrevistas agendadas: ${$('#num_entrevistas').val()}`;
                                    }
                                }
                                if(e.entrevista_realizada==1)
                                {
                                    titulo = '<i class="fa-solid fa-check-double pe-1"></i> Entrevista finalizada';
                                    if(e.notifica_contratar==1)
                                    {   $('#alert_estatus').addClass('alert-secondary');
                                        motivo_descarte = '<i class="fa-solid fa-user-clock fa-lg pe-1"></i>  En Espera.';
                                    }
                                    if(e.notifica_contratar==2)
                                    {   $('#alert_estatus').addClass('alert-danger');
                                        motivo_descarte = '<i class="fa-solid fa-user-xmark fa-lg pe-1"></i>  Declinado.';
                                    }
                                    if(e.notifica_contratar==3)
                                    {   $('#alert_estatus').addClass('alert-success');
                                        motivo_descarte = '<i class="fa-solid fa-user-check fa-lg pe-1"></i>  Contratar';
                                    }
                                }
                                if(motivo_descarte!='')
                            {   $('#titulo_estatus').html(titulo);
                               // $('#alert_estatus').removeClass('alert-primary alert-warning alert-danger alert-secondary alert-success');
                                $('#motivo_estatus').html(motivo_descarte);}
                                //$('#titulo_estatus').html(titulo);
                                //$('#motivo_estatus').html(motivo_descarte);
                            }

                            const flag = estados[estado].flag;
                            const alerta_entrevista = `
                                <div class="row align-middle"><div class="col-12 py-1 ps-2" id="alerta_entrevista_${num}">
                                    ${estados[estado].badge}
                                </div></div>`;

                            const nombre = `${e.nombre_entrevistador} ${e.apellido_entrevistador}`;
  
                            const iniciales = `${(e.nombre_entrevistador || '').charAt(0)}${(e.apellido_entrevistador || '').charAt(0)}`.toUpperCase();

                            const color_tx = e.color_text; const color_bg = e.color_bg;
                            let fotoHtml = `<img src="${e.foto_entrevistador}" alt="Foto de ${nombre}" class="rounded-circle" style="background:#FFFFFF; width: 24px; height: 24px; object-fit: cover; border: 1px solid #aeafb0;">`;
                            if (!e.foto_entrevistador) {
                                fotoHtml = `
                                    <span class="rounded-circle d-flex align-items-center justify-content-center" style="
                                    width: 22px; height: 22px; background-color: ${color_bg};  border-radius: 50%;  display: flex;  align-items: center;  justify-content: center;  color: ${color_tx};  font-family: 'Segoe UI', 'Roboto', sans-serif;
                                    font-size: 12px;  text-transform: uppercase;  border: 1px solid ${color_tx}">
                                        ${iniciales}
                                    </span>`;
                            }

                            if(e.entrevista_realizada!=1)
                            {   opcionesContratacion=" d-none"   
                                if (e.opcionesContratacion==1) {  opcionesContratacion=''; }
                                $('#div_entrevistas').append(`
                                    <div class="card ms-3" style="width: 30rem; box-shadow: none; border: 1px solid #e2e2e2;">  
                                        <div class="card-header p-1 bg-light row">
                                            <div class="col-md-7 text-primary"><i class="fa-solid fa-calendar-days pe-1"></i> Entrevista Funcional #${num}</div>
                                            <div class="col-md-1 offset-md-4 text-end"><span id="flag_${num}">${flag}</span></div>
                                        </div>

                                        <div class="card-body text-secondary mt-2 " id="div_entrevista_${num}">                                           
                                            ${alerta_entrevista}
                                            <small>
                                                <div class="row align-middle">
                                                    <div class="col-auto px-1 fw-semibold"><i class="fa-solid fa-user-tie text-primary pe-1"></i> Entrevistador:</div>
                                                    <div class="col-auto px-0 align-middle">${fotoHtml}</div>
                                                    <div class="col-auto ps-1  align-middle"><span id="lb_entrevistador_${num}"> ${e.nombre_entrevistador} ${e.apellido_entrevistador}</span></div>
                                                </div>                
                                                    
                                                <div class="row align-middle">
                                                    <div class="col-auto px-1 fw-semibold"><i class="fa-solid fa-map-pin text-danger pe-1"></i> Lugar:</div>
                                                    <div class="col-auto px-0 align-middle">${e.lugar_entrevista || ''}</div>
                                                </div>

                                                <div class="row align-middle">
                                                    <div class="col-auto px-1 fw-semibold"><i class="fa-regular fa-calendar-days pe-1"></i> Fecha:</div>
                                                    <div class="col-auto px-0 align-middle">${fecha}</div>
                                                </div>

                                                <div class="row align-middle">
                                                    <div class="col-auto px-1 fw-semibold"><i class="fa-solid fa-clock pe-1"></i> Hora:</div>
                                                    <div class="col-auto px-0 align-middle">${hora}</div>
                                                </div>
                                                
                                                <div class="row align-middle ${opcionesContratacion}" id="div_deciscionContrato_${num}"> <div class="col-auto px-1 fw-semibold">
                                                    <i class="fa-solid fa-check"></i></div>
                                                    <div class="col-auto px-0 align-middle">Decisión de contratar</div> 
                                                </div>
                                                
                                                <div class="row align-middle">
                                                    <div class="col-auto px-1 fw-semibold"><i class="fa-regular fa-comment-dots pe-1"></i></div>
                                                    <div class="col-auto px-0 align-middle ">${e.observaciones}</div>
                                                </div>
                                            </small>
                                        </div>

                                        <div class="card-footer"  style="border:none;">
                                            <button type="button" class="btn btn-sm btn-primary" onclick="verentrevista(${num},${e.id})"><i class="fa-solid fa-magnifying-glass pe-1"></i> Ver Detalle</button>
                                        </div>                                    
                                        <div class="card-body mt-2 d-none" id="div_spinner_entrevista_${num}">
                                            <div class="d-flex justify-content-center align-items-center" style="height: 20vh;">
                                                <div class="spinner-border text-primary me-2" role="status"></div>
                                                    <span>Enviando...</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>                                
                                `);
                            }
                            else
                            {   contratar='';                        
                                opcionesContratacion=" d-none"   
                                if(e.opcionesContratacion==1) {  opcionesContratacion=''; }
                                if(e.notifica_contratar==1) { contratar='<span class="badge rounded-pill text-secondary" style="background-color: #dee2e6; font-size: 14px;"><i class="fa-solid fa-user-clock fa-lg pe-1"></i> En Espera</span><br>'  }
                                if(e.notifica_contratar==2) { contratar='<span class="badge rounded-pill text-danger" style="background-color: #f8d7da; font-size: 14px;"><i class="fa-solid fa-user-xmark fa-lg pe-1"></i> Declinado</span><br>'  }
                                if(e.notifica_contratar==3) { contratar='<span class="badge rounded-pill text-success" style="background-color: #d4edda; font-size: 14px;"><i class="fa-solid fa-user-check fa-lg pe-1"></i> Contratar</span><br>'  }
                                $('#div_entrevistas').append(`
                                    <div class="card ms-3" style="width: 30rem; box-shadow: none; border: 1px solid #e2e2e2;"> 
                                        <div class="card-header p-1 bg-light row">
                                            <div class="col-md-7 text-primary"><i class="fa-solid fa-calendar-days pe-1"></i> Entrevista Funcional #${num}</div>
                                            <div class="col-md-1 offset-md-4 text-end"><span id="flag_${num}">${flag}</span></div>
                                        </div>

                                        <div class="card-body text-secondary mt-2" id="div_entrevista_${num}">
                                                
                                            ${alerta_entrevista}
                                                    <small>
                                                    <div class="row align-middle">
                                                        <div class="col-auto px-1 fw-semibold"><i class="fa-solid fa-user-tie text-primary pe-1"></i> Entrevistador:</div>
                                                        <div class="col-auto px-0 align-middle">${fotoHtml}</div>
                                                        <div class="col-auto ps-1  align-middle"><span id="lb_entrevistador_${num}"> ${e.nombre_entrevistador} ${e.apellido_entrevistador}</span></div>
                                                    </div>                
                                                    
                                                    <div class="row align-middle">
                                                        <div class="col-auto px-1 fw-semibold"><i class="fa-solid fa-map-pin text-danger pe-1"></i> Lugar:</div>
                                                        <div class="col-auto px-0 align-middle">${e.lugar_entrevista || ''}</div>
                                                    </div>

                                                    <div class="row align-middle">
                                                        <div class="col-auto px-1 fw-semibold"><i class="fa-regular fa-calendar-days pe-1"></i> Fecha:</div>
                                                        <div class="col-auto px-0 align-middle">${e.fecha_real_formateada}</div>
                                                    </div>

                                                    <div class="row align-middle">
                                                        <div class="col-auto px-1 fw-semibold"><i class="fa-solid fa-clock pe-1"></i> Hora:</div>
                                                        <div class="col-auto px-0 align-middle">${hora}</div>
                                                    </div>
                                                
                                                    <div class="row align-middle ${opcionesContratacion}" id="div_deciscionContrato_${num}"> 
                                                        <div class="col-auto px-1 fw-semibold"> <i class="fa-solid fa-check"></i></div>
                                                        <div class="col-auto px-0 align-middle">Decisión de contratar</div> 
                                                    </div>
                                                    <hr>
                                                    <div class="row align-middle">
                                                        <div class="col-auto px-1 fw-semibold text-primary">Comentarios sobre el candidato: </div>
                                                        <div class="col-auto px-0 align-middle ">${e.comentarios_entrevistador}</div>
                                                    </div>                                                
                                                    <div class="row align-middle mb-3">
                                                        <div class="col-auto px-1 fw-semibold text-primary">Valoración: </div>
                                                        <div class="col-auto px-0 align-middle ">${e.valoracion}%</div>
                                                    </div>                                                
                                                    <div class="row align-middle">
                                                        <div class="col-auto px-0 align-middle ">${contratar}</div>
                                                    </div>
                                                    </small>
                                            </div>
                                    </div>                                
                                `);
                            }
                            
                        });
                    }
                // CARTAS DE OFERTA
                    $('#tbody_cartas_oferta').html('');
                    
                    if(cartas_ofertas){
                        if(cartas_ofertas.estado==1)
                        {   let fila = '';
                            fila += `<tr>
                                        <td class="small align-middle text-center">
                                            ${cartas_ofertas.fecha_registro || ''}
                                            <input type='hidden' id='v_file_cartaofl' value='${cartas_ofertas.url_carta_oferta}'> <input type='hidden' id='file_cartaofl' value='${cartas_ofertas.id}'> <a id='link_cartaofl' href='${cartas_ofertas.url_carta_oferta}' download='Carta Oferta - ${nombre}' target='_blank'></a>
                                        </td>
                                        <td class="small align-middle text-center">$${cartas_ofertas.salario || ''}</td>                                
                                        <td class="small align-middle text-center">${cartas_ofertas.finicio_formateado || ''}</td>  
                                        <td class="small align-middle text-center">${cartas_ofertas.generada_por || ''}</td>                                      
                                        <td class="small align-middle text-center">                                     
                                            <div class="dropdown py-0">
                                                <button class="btn btn-info btn-sm dropdown-toggle text-light" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-gear pe-2"></i> Acciones</button>
                                                <ul class="dropdown-menu p-0" aria-labelledby="dropdownMenu2">
                                                    <li><button class="border-top dropdown-item py-1" type="button" onclick="viewfile('cartaofl')" ><i class="fa-solid fa-magnifying-glass text-info"></i> Ver</button></li>
                                                    <li><button class="border-top dropdown-item py-1" type="button" onclick="editfile('cartaofl')" ><i class="fa-solid fa-pencil text-primary"></i> Editar</button></li>
                                                    <li><button class="border-top dropdown-item py-1" type="button" onclick="delfile('cartaofl')" ><i class="fa-solid fa-trash-can text-danger"></i> Eliminar</button></li>
                                                    <li><button class="border-top dropdown-item py-1" type="button" onclick="aceptcartaofl('cartaofl')" ><i class="fa-solid fa-file-circle-check text-success"></i> Carta Oferta Aceptada</button></li>
                                                    <li><button class="border-top dropdown-item py-1" type="button" onclick="declinacartaofl('cartaofl')" ><i class="fa-solid fa-person-circle-xmark text-secondary"></i> Candidato Declina</button></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>`;
                            $('#tbody_cartas_oferta').html(fila);
                            $('#bot_nueva_cofl').addClass('d-none');
                            $('#bot_pasa_fimacontrato').addClass('d-none');
                            
                        }
                            else{
                            if(cartas_ofertas.estado==3)
                            {   let fila = '';
                                fila += `<tr>
                                        <td class="small align-middle text-center">
                                            ${cartas_ofertas.fecha_registro || ''}
                                            <input type='hidden' id='v_file_cartaoflacept' value='${cartas_ofertas.aceptacion_ofl}'> <input type='hidden' id='file_cartaoflacept' value='${cartas_ofertas.id}'> <a id='link_cartaoflacept' href='${cartas_ofertas.aceptacion_ofl}' download='Carta Oferta - ${nombre}' target='_blank'></a>
                                        </td>
                                        <td class="small align-middle text-center">$${cartas_ofertas.salario || ''}</td>                                
                                        <td class="small align-middle text-center">${cartas_ofertas.finicio_formateado || ''}</td>  
                                        <td class="small align-middle text-center">${cartas_ofertas.generada_por || ''}</td>                                      
                                        <td class="small align-middle text-center">                                     
                                            <div class="dropdown py-0">
                                                <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-gear pe-2"></i> Acciones</button>
                                                <ul class="dropdown-menu p-0" aria-labelledby="dropdownMenu2">
                                                    <li><button class="border-top dropdown-item py-1" type="button" onclick="viewfile('cartaoflacept')" ><i class="fa-solid fa-magnifying-glass text-info"></i> Ver</button></li>
                                                    <li><button class="border-top dropdown-item py-1" type="button" onclick="downfile('cartaoflacept')"><i class="fa-solid fa-download text-primary"></i> Descargar</button></li>
                                                    <li><button class="border-top dropdown-item py-1" type="button" onclick="delfile('cartaoflacept')" ><i class="fa-solid fa-trash-can text-danger"></i> Eliminar</button></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>`;
                                $('#tbody_cartas_oferta').html(fila);
                                $('#bot_nueva_cofl').addClass('d-none');
                                $('#bot_pasa_fimacontrato').removeClass('d-none');
                            }
                            else{                          
                                
                            if(cartas_ofertas.estado==4)
                            {   let fila = '';
                                    fila += `<tr>
                                            <td class="small align-middle text-center">
                                                ${cartas_ofertas.fecha_registro || ''}
                                                <input type='hidden' id='v_file_cartaoflacept' value='${cartas_ofertas.aceptacion_ofl}'> 
                                                <input type='hidden' id='file_cartaoflacept' value='${cartas_ofertas.id}'> 
                                                <a id='link_cartaoflacept' href='${cartas_ofertas.aceptacion_ofl}' download='Carta Oferta - ${nombre}' target='_blank'></a>
                                            </td>
                                            <td class="small align-middle text-center">$${cartas_ofertas.salario || ''}</td>                                
                                            <td class="small align-middle text-center">${cartas_ofertas.finicio_formateado || ''}</td>  
                                            <td class="small align-middle text-center">${cartas_ofertas.generada_por || ''}</td>                                      
                                            <td class="align-middle text-center">
                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <span class="badge rounded-pill" style="background-color: #cfe2ff; color:#0d6efd;">
                                                        <i class="fa-solid fa-signature fa-lg pe-1"></i> Firma de Contrato
                                                    </span>

                                                    <div class="dropdown py-0">
                                                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-gear pe-2"></i> Acciones</button>
                                                        <ul class="dropdown-menu p-0" aria-labelledby="dropdownMenu2">
                                                            <li><button class="border-top dropdown-item py-1" type="button" onclick="viewfile('cartaoflacept')" ><i class="fa-solid fa-magnifying-glass text-info"></i> Ver</button></li>
                                                            <li><button class="border-top dropdown-item py-1" type="button" onclick="downfile('cartaoflacept')"><i class="fa-solid fa-download text-primary"></i> Descargar</button></li>
                                                        </ul>
                                                    </div>  
                                                    
                                                    
                                                </div>
                                            </td>
                                        </tr>`;
                                    $('#tbody_cartas_oferta').html(fila);
                                    $('#bot_nueva_cofl').addClass('d-none');
                                    $('#bot_pasa_fimacontrato').addClass('d-none');
                            }
                            
                            else{
                                $('#bot_nueva_cofl').addClass('d-none');
                                $('#bot_pasa_fimacontrato').removeClass('d-none');
                            }}
                        }
                    }else{
                        $('#bot_nueva_cofl').removeClass('d-none');
                        $('#bot_pasa_fimacontrato').addClass('d-none');}
            },
            error: function(xhr) {
                console.error("Error al obtener datos del candidato:", xhr.responseText);
            }
        });
    }

    // Editando carta oferta
    function editfile(doc)
    {
        // Preparar datos 
        var parametros = {
            "_token": $('input[name="_token"]').val(),
            "id_carta": $('#file_' + doc).val()
        };

        // Enviar petición AJAX
            $.ajax({
                data: parametros,
                url: "{{ route('ofertas.editcartaoferta') }}",
                type: 'POST',
                dataType: "json",
                cache: true,            
                beforeSend: function() {
                    $('#modalCartaOferta').modal('show');
                    $('#div_spinner_carta_oferta').removeClass('d-none');
                    $('#form_carta_oferta').removeClass('d-none');
                },
                success: function(data) {
                    $('#div_spinner_carta_oferta').addClass('d-none');
                    $('#form_carta_oferta').removeClass('d-none');
                    if (data.success) {
                        const carta = data.carta;
                        $('#sel_cia').val(carta.cod_cia);
                        findceco(carta.cod_cia,carta.cod_ceco)
                        $('#salario_mensual').val(carta.salario);
                        $('#salario_base_radio').prop('checked', carta.sel_tipo_salario == 'B');
                        $('#salario_hora_radio').prop('checked', carta.sel_tipo_salario == 'H');
                        if(carta.sel_tipo_salario == 'H') {
                            muestra_salario_hora();
                        } else {
                            $('#salario_hora').val('');
                        }
                        $('#contrato_permanente_radio').prop('checked', carta.sel_tipo_contrato == 'P');
                        $('#contrato_temporal_radio').prop('checked', carta.sel_tipo_contrato == 'T');
                        $('#fecha_inicio').val(carta.finicio);
                        if(carta.fterminacion!=null && carta.fterminacion!='') {
                            $('#div_fecha_terminacion').removeClass('d-none');
                            $('#fecha_terminacion').val(carta.fterminacion);
                        } else {
                            $('#fecha_terminacion').val('');
                            $('#div_fecha_terminacion').addClass('d-none');
                        }                      
                        $('#sel_ceco').prop('disabled', true);
                        $('#modalCartaOferta').modal('show');
                        document.querySelector('trix-editor[input="txt_plazo_nombramiento"]').editor.loadHTML(carta.plazo_nombramiento || '');
                        $('#sel_firmante').val(carta.id_user_firmante);
                        data.beneficios.forEach(item => {
                            const tipo = item.tipo; // 'b' o 'h'
                            const id = item.id_beneficio;
                            const checkSelector = `#${id}_${tipo}check`;
                            const inputSelector = `#${id}_${tipo}txt`;
                            const check = $(checkSelector);
                            const input = $(inputSelector);
                            if (check.length) {
                                check.prop('checked', true); 
                                if (input.length) {
                                    input.closest('.input-group').removeClass('d-none');
                                    input.val(item.monto);
                                }
                            }
                        });
                    } else {
                        mal('Error al obtener los datos de la carta oferta');
                    }
                }
            })
    }

    function verentrevista(num, idEntrevista) {
        const _token = $('input[name="_token"]').val();
        $('#id_entrevista').val(idEntrevista);
        $('#num_update').val(num);
        $('#div_titulo_entrevista').html('Entrevista Funcional');

        // Limpiar campos
        $('#fecha_entrevista_new').val('');
        $('#hora_entrevista_new').val('');
        $('#email_entrevistador_new').val('');
        $('#lugar_entrevista_new').val('');
        $('#comentarios_entrevista_funcional_new').val('');
        $('#chk_opt_contrata_new').prop('checked', false);
        $('#chk_agenda_entrevista_new').prop('checked', false);
        const parametros = {
            "_token": _token,
            "idEntrevista": idEntrevista};

        $.ajax({
            data: parametros,
            url: "{{ route('ofertas.viewEntFuncional') }}",
            type: 'POST',
            dataType: "json",
            cache: true,
            beforeSend: function () {
                $('#modalEntrevista').modal('show');
                $('#div_spinner_entrevista_new').removeClass('d-none');
                $('#div_entrevista_new').addClass('d-none');
            },
            success: function (data) {
                if (data.success) {
                    const e = data.entrevista_fun;
                    $('#fecha_entrevista_new').val(e.fecha_corta || '');
                    $('#hora_entrevista_new').val(e.hora || '');
                    $('#email_entrevistador_new').val(e.email_entrevistador || '');
                    $('#lugar_entrevista_new').val(e.lugar_entrevista || '');
                    $('#comentarios_entrevista_funcional_new').val(e.observaciones || '');
                    $('#chk_opt_contrata_new').prop('checked', e.opcionesContratacion == 1);
                    $('#chk_agenda_entrevista_new').prop('checked', e.notificado == 1);
                    $('#fecha_entrevista_new').focus();
                } else {
                    mal('Error al obtener los datos de la entrevista');
                }
                $('#div_spinner_entrevista_new').addClass('d-none');
                $('#div_entrevista_new').removeClass('d-none');
            },
            error: function (xhr) {
                console.error("Error al obtener la entrevista:", xhr.responseText);
                mal('Ocurrió un error al obtener la entrevista');
                $('#modalEntrevista').modal('hide');
            }
        });
    }

    function crea_nueva_entrevista()
    {
        var num = parseInt($('#num_entrevistas').val()) + 1;
        $('#num_entrevistas').val(num);
        const now = new Date();
        now.setHours(now.getHours() + 1); // suma 1 hora
        const horas = String(now.getHours()).padStart(2, '0');
        $('#div_titulo_entrevista').html('Nueva Entrevista Funcional');
        $('#fecha_entrevista_new').val(new Date().toISOString().split('T')[0]); // Establecer fecha actual
        $('#hora_entrevista_new').val(`${horas}:00`); // Establecer hora actual + 1 hora
        $('#email_entrevistador_new').val(''); // Limpiar email del entrevistador
        $('#lugar_entrevista_new').val(''); // Limpiar campo de lugar de entrevista
        $('#comentarios_entrevista_funcional_new').val(''); // Limpiar comentarios
        $('#fecha_entrevista_new').focus(); // Enfocar el campo de fecha de entrevista
        $('#id_entrevista').val(0);
        $('#modalEntrevista').modal('show');
    }

    function saveentrevista() {
        var _token = $('input[name="_token"]').val();
        var id_curri = $('#reclutamiento_id_curri').val();
        var id_part = $('#reclutamiento_id_participante').val();
        var id_ofl = $('#id_ofl').val();
        
        var reclutamiento_nom_puesto = $('#reclutamiento_nom_puesto').val();
        var reclutamiento_nom_unidad = $('#reclutamiento_nom_unidad').val();
        var lb_emailentrevistador = $('#email_entrevistador_new').val().trim();
        if($('#id_entrevista').val()==0)
        {   num = $('#num_update').val(); }
        else
        {   num = $('#num_entrevistas').val();}
        var entrevistador_nombre = $('#lb_entrevistador_new').text().trim();        
        var mailCandidato = $('#mail_reg').text();
        var nomCandidato = $('#nom_reg').text();        
        var fecha_entrevista = $('#fecha_entrevista_new').val();
        var hora_entrevista = $('#hora_entrevista_new').val();
        var lugar_entrevista = $('#lugar_entrevista_new').val().trim();
        var comentarios = $('#comentarios_entrevista_funcional_new').val();
        var chk_opt_contrata = $('#chk_opt_contrata_new').is(':checked');
        var enviarAgenda = $('#chk_agenda_entrevista_new').is(':checked');
        var chk_opt_preguntas_entrevistas = $('#chk_opt_preguntas_entrevistas').is(':checked');

        if (fecha_entrevista === '' || hora_entrevista === '' || lugar_entrevista === '') {
            mal('Debe completar todos los campos de la entrevista');
            return;
        }

        // Validar que no sea en el pasado
        var fechaHoraSeleccionada = new Date(fecha_entrevista + 'T' + hora_entrevista);
        var ahora = new Date();
        if (fechaHoraSeleccionada < ahora) {
            mal('No puede programar una entrevista en el pasado');
            return;
        }

        // Validar correo si se enviará agenda
        if (enviarAgenda) {
            if (!lb_emailentrevistador || !validarEmail(lb_emailentrevistador)) {
                mal('El correo del entrevistador no es válido para enviar la agenda');
                return;
            }
            if (!mailCandidato || !validarEmail(mailCandidato)) {
                mal('El correo del candidato no es válido para enviar la agenda');
                return;
            }
        }

        var parametros = {
            "_token": _token,
            "id": $('#id_entrevista').val(),
            "reclutamiento_nom_puesto": reclutamiento_nom_puesto,
            "reclutamiento_nom_unidad": reclutamiento_nom_unidad,
            "email_entrevistador": lb_emailentrevistador,
            "mail_candidato": mailCandidato,
            "nom_candidato": nomCandidato,
            "fecha": fecha_entrevista,
            "hora": hora_entrevista,
            "lugar": lugar_entrevista,
            "comentarios": comentarios,
            "enviar_agenda": enviarAgenda? 's' : 'n',
            "chk_opt_contrata": chk_opt_contrata? 's' : 'n',
            "chk_opt_preguntas_entrevistas": chk_opt_preguntas_entrevistas? 's' : 'n',
            "id_curri": id_curri,
            "id_part": id_part,
            "id_ofl": id_ofl,
        };

        $.ajax({
            data: parametros,
            url: "{{ route('ofertas.save_ent_funcional') }}",
            type: 'POST',
            dataType: "json",
            cache: true,
            beforeSend: function() {
                $('#div_spinner_entrevista_new').removeClass('d-none');
                $('#div_entrevista_new').addClass('d-none');
            },
            success: function(data) {
                if (data.success) {
                    bien('Entrevista guardada correctamente');
                    if($('#id_entrevista').val()==0)
                    {   
                        const e = data.entrevista_fun;
                        const nombre = `${e.nombre_entrevistador} ${e.apellido_entrevistador}`;
                        const iniciales = `${(e.nombre_entrevistador || '').charAt(0)}${(e.apellido_entrevistador || '').charAt(0)}`.toUpperCase();

                        const color_tx = e.color_text; const color_bg = e.colores_bg;
                        let fotoHtml = `<img src="${e.foto_entrevistador}" alt="Foto de ${nombre}" class="rounded-circle" style="background:#FFFFFF; width: 24px; height: 24px; object-fit: cover; border: 1px solid #aeafb0;">`;
                        if (!e.foto_entrevistador) {
                            fotoHtml = `
                                <span class="rounded-circle d-flex align-items-center justify-content-center" style="
                                width: 22px; height: 22px; background-color: ${color_bg};  border-radius: 50%;  display: flex;  align-items: center;  justify-content: center;  color: ${color_tx};  font-family: 'Segoe UI', 'Roboto', sans-serif;
                                font-size: 12px;  text-transform: uppercase;  border: 1px solid ${color_tx}"> ${iniciales} </span>`;
                        }             
                        opcionesContratacion=" d-none"   
                        if (e.opcionesContratacion==1) {  opcionesContratacion=''; }
                        $('#alerta_entrevista_'+num).html(''); 
                        $('#div_entrevistas').append(`
                            <div class="card ms-3" style="width: 30rem; box-shadow: none; border: 1px solid #e2e2e2;">  
                                <div class="card-header p-1 bg-light row">
                                    <div class="col-md-7 text-primary"><i class="fa-solid fa-calendar-days pe-1"></i> Entrevista Funcional #${num}</div>
                                    <div class="col-md-1 offset-md-4 text-end"><span id="flag_${num}"><i class="fa-solid fa-flag text-primary"></i></span></div>
                                </div>

                                <div class="card-body text-secondary mt-2 px-2" id="div_entrevista_${num}">                             
                                                
                                    <div class="row align-middle">
                                        <div class="col-12 py-1 ps-2" id="alerta_entrevista_${num}">
                                            <span class="badge rounded-pill text-primary" style="background-color: #cfe2ff;"><i class="fa-solid fa-triangle-exclamation"></i> Entrevista agendada</span>
                                        </div>
                                    </div>
                                    <small>
                                        <div class="row align-middle">
                                            <div class="col-auto px-1 fw-semibold"><i class="fa-solid fa-user-tie text-primary pe-1"></i> Entrevistador:</div>
                                            <div class="col-auto px-0 align-middle">${fotoHtml}</div>
                                            <div class="col-auto ps-1  align-middle"><span id="lb_entrevistador_${num}"> ${e.nombre_entrevistador} ${e.apellido_entrevistador}</span></div>
                                        </div>                
                                                        
                                        <div class="row align-middle">
                                            <div class="col-auto px-1 fw-semibold"><i class="fa-solid fa-map-pin text-danger pe-1"></i> Lugar:</div>
                                            <div class="col-auto px-0 align-middle">${e.lugar_entrevista || ''}</div>
                                        </div>

                                        <div class="row align-middle">
                                            <div class="col-auto px-1 fw-semibold"><i class="fa-regular fa-calendar-days pe-1"></i> Fecha:</div>
                                            <div class="col-auto px-0 align-middle">${e.fecha_formateada}</div>
                                        </div>

                                        <div class="row align-middle">
                                            <div class="col-auto px-1 fw-semibold"><i class="fa-solid fa-clock pe-1"></i> Hora:</div>
                                            <div class="col-auto px-0 align-middle">${e.hora_formateada}</div>
                                        </div>
                                        
                                        <div class="row align-middle ${opcionesContratacion}" id="div_deciscionContrato_${num}"> <div class="col-auto px-1 fw-semibold">
                                            <i class="fa-solid fa-check"></i></div>
                                            <div class="col-auto px-0 align-middle">Decisión de contratar</div> 
                                        </div>
                                                                                               
                                        <div class="row align-middle">
                                            <div class="col-auto px-1 fw-semibold"><i class="fa-regular fa-comment-dots pe-1"></i></div>
                                            <div class="col-auto px-0 align-middle ">${e.observaciones}</div>
                                        </div>
                                    </small>
                                </div>
                     
                                        
                                <div class="card-body mt-2 d-none" id="div_spinner_entrevista_${num}">
                                    <div class="d-flex justify-content-center align-items-center" style="height: 20vh;">
                                        <div class="spinner-border text-primary me-2" role="status"></div>
                                        <span>Enviando...</span>
                                    </div>
                                </div>
                            </div>                                                              
                        `);     
                    }
                    else
                    {  
                        
                        const entrevistas_funcionales = data.data_entrevista_fun;
                    
                        const e = data.entrevista_fun;                        
                        const estados = {
                            porProgramar: {
                                flag: '<i class="fa-solid fa-flag text-warning"></i>',
                                badge: '<span class="badge rounded-pill" style="background-color: #fff3cd; color: #644C06;"><i class="fa-solid fa-triangle-exclamation"></i> Por agendar</span>'
                            },
                            agendada: {
                                flag: '<i class="fa-solid fa-flag text-primary"></i>',
                                badge: '<span class="badge rounded-pill text-primary" style="background-color: #cfe2ff;"><i class="fa-solid fa-people-arrows"></i> Entrevista agendada</span>'
                            },
                            descartado: {
                                flag: '<i class="fa-solid fa-flag text-danger"></i>',
                                badge: '<span class="badge rounded-pill text-danger" style="background-color: #f8d7da;"><i class="fa-solid fa-user-xmark"></i> Candidato descartado</span>'
                            },
                            finalizada: {
                                flag: '<i class="fa-solid fa-flag text-success"></i>',
                                badge: '<span class="badge rounded-pill text-success" style="background-color: #d4edda;"><i class="fa-solid fa-check-double"></i> Entrevista finalizada</span>'
                            }
                        }; 
                     

                        let estado = '';
                        let fecha = e.fecha_formateada || '';
                        let hora = e.hora_formateada || '';
                        let motivo_descarte = '';
                        let detalle_descarte = '';

                       
                            if(e.entrevista_realizada==0)
                            {    if (!e.fecha_formateada) {
                                    estado = 'porProgramar';
                                    band_entrevista = 1;
                                } else {
                                    estado = 'agendada';
                                }
                            }
                            if(e.entrevista_realizada==1)
                            {   estado = 'finalizada';                                
                            }
                        

                        

       
                            $('#alert_estatus').removeClass('d-none');
                            motivo_descarte = '';
                            if(e.entrevista_realizada==0||e.entrevista_realizada==null)
                            {   titulo = band_entrevista ? '<i class="fa-regular fa-calendar-days fa-lg pe-1"></i> Entrevista por programar' : '<i class="fa-solid fa-people-arrows fa-lg pe-1"></i> Entrevista agendada';
                                if (band_entrevista) {
                                    $('#alert_estatus').addClass('alert-warning');
                                    motivo_descarte = 'Agendar entrevista';
                                } else {
                                    $('#alert_estatus').addClass('alert-primary');
                                    motivo_descarte = `Número de entrevistas agendadas: ${$('#num_entrevistas').val()}`;
                                }
                            }
                            if(e.entrevista_realizada==1)
                            {
                                titulo = '<i class="fa-solid fa-check-double pe-1"></i> Entrevista finalizada';
                                if(e.notifica_contratar==1)
                                {   $('#alert_estatus').addClass('alert-secondary');
                                    motivo_descarte = '<i class="fa-solid fa-user-clock fa-lg pe-1"></i>  En Espera.';
                                }
                                
                                if(e.notifica_contratar==2)
                                {   $('#alert_estatus').addClass('alert-danger');
                                    motivo_descarte = '<i class="fa-solid fa-user-xmark fa-lg pe-1"></i>  Declinado.';
                                }
                                if(e.notifica_contratar==3)
                                {   $('#alert_estatus').addClass('alert-success');
                                    motivo_descarte = '<i class="fa-solid fa-user-check fa-lg pe-1"></i>  Contratar';
                                }
                            }
                            if(motivo_descarte!='')
                            {   $('#titulo_estatus').html(titulo);
                               // $('#alert_estatus').removeClass('alert-primary alert-warning alert-danger alert-secondary alert-success');
                                $('#motivo_estatus').html(motivo_descarte);}
                        


                       
                        const nombre = `${e.nombre_entrevistador} ${e.apellido_entrevistador}`;
                        const iniciales = `${(e.nombre_entrevistador || '').charAt(0)}${(e.apellido_entrevistador || '').charAt(0)}`.toUpperCase();

                        const color_tx = e.color_text; const color_bg = e.colores_bg;
                        let fotoHtml = `<img src="${e.foto_entrevistador}" alt="Foto de ${nombre}" class="rounded-circle" style="background:#FFFFFF; width: 24px; height: 24px; object-fit: cover; border: 1px solid #aeafb0;">`;
                        if (!e.foto_entrevistador) {
                            fotoHtml = `
                                <span class="rounded-circle d-flex align-items-center justify-content-center" style="
                                width: 22px; height: 22px; background-color: ${color_bg};  border-radius: 50%;  display: flex;  align-items: center;  justify-content: center;  color: ${color_tx};  font-family: 'Segoe UI', 'Roboto', sans-serif;
                                font-size: 12px;  text-transform: uppercase;  border: 1px solid ${color_tx}"> ${iniciales} </span>`;
                        }             
                        opcionesContratacion=" d-none"   
                        if (e.opcionesContratacion==1) {  opcionesContratacion=''; }
                        $('#div_entrevista_'+num).empty();
                        $('#div_entrevista_'+num).append(`
                            <div class="row align-middle">
                                <div class="col-12 py-1 ps-2" id="alerta_entrevista_${num}">
                                    <span class="badge rounded-pill text-primary" style="background-color: #cfe2ff;"><i class="fa-solid fa-triangle-exclamation"></i> Entrevista agendada</span>
                                </div>
                            </div>
                            <small>
                                <div class="row align-middle">
                                    <div class="col-auto px-1 fw-semibold"><i class="fa-solid fa-user-tie text-primary pe-1"></i> Entrevistador:</div>
                                    <div class="col-auto px-0 align-middle">${fotoHtml}</div>
                                    <div class="col-auto ps-1  align-middle"><span id="lb_entrevistador_${num}"> ${e.nombre_entrevistador} ${e.apellido_entrevistador}</span></div>
                                </div>                
                                                        
                                <div class="row align-middle">
                                    <div class="col-auto px-1 fw-semibold"><i class="fa-solid fa-map-pin text-danger pe-1"></i> Lugar:</div>
                                    <div class="col-auto px-0 align-middle">${e.lugar_entrevista || ''}</div>
                                </div>

                                <div class="row align-middle">
                                    <div class="col-auto px-1 fw-semibold"><i class="fa-regular fa-calendar-days pe-1"></i> Fecha:</div>
                                    <div class="col-auto px-0 align-middle">${e.fecha_formateada}</div>
                                </div>

                                <div class="row align-middle">
                                    <div class="col-auto px-1 fw-semibold"><i class="fa-solid fa-clock pe-1"></i> Hora:</div>
                                    <div class="col-auto px-0 align-middle">${e.hora_formateada}</div>
                                </div>
                                        
                                <div class="row align-middle ${opcionesContratacion}" id="div_deciscionContrato_${num}"> 
                                    <div class="col-auto px-1 fw-semibold"><i class="fa-solid fa-check"></i></div>
                                    <div class="col-auto px-0 align-middle">Decisión de contratar</div> 
                                </div>
                                                                                               
                                <div class="row align-middle">
                                    <div class="col-auto px-1 fw-semibold"><i class="fa-regular fa-comment-dots pe-1"></i></div>
                                    <div class="col-auto px-0 align-middle ">${e.observaciones}</div>
                                </div>
                            </small>
                        `);
                    }
                } else {
                    mal('Error al guardar la entrevista');
                }
                $('#modalEntrevista').modal('hide');  
                $('#div_spinner_entrevista_new').addClass('d-none');
                $('#div_entrevista_new').removeClass('d-none');
            },
            error: function(xhr) {
                console.error("Error al guardar la entrevista:", xhr.responseText);
            }
        });
    }

    // Validar formato básico de email
    function validarEmail(email) {
        var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
    
    function generarHTMLExperiencia(e, index, conBotonValidar = false) {

       if (e.validado_por == null) {
            bto = `<button id="btn_ref_l_${e.id}" onclick="validar_ref(${e.id},'l')" class="btn py-0 btn-sm btn-outline-primary" title="Validar Referencia">  
                <i class="fa-solid fa-check pe-1"></i>Validar 
                </button>`;
        } else {
            bto = `<button id="btn_ref_l_${e.id}" onclick="validar_ref(${e.id},'l')" class="btn py-0 btn-sm btn-success" title="Validar Referencia">  
            <i class="fa-solid fa-check-double pe-1"></i>Validado 
            </button>`;
                            }
        return `
        <div class="px-4 py-2 mb-3 border border-info rounded experiencia-item">
            <div class="row row-cols-2 mb-2">
                <div class="col fw-bold text-primary">
                    <small>Experiencia Laboral # ${index}</small>
                </div>
                ${conBotonValidar ? ` <div class="col text-end"> ${bto}</div>` : ''}
            </div>
            <div class="row g-2">
                <div class="col-md-3">
                    <strong class="text-secondary">Empresa:</strong><br><span class="text-muted" id="nom_emp_l_${e.id}">${e.empresa}</span>
                </div>
                <div class="col-md-3">
                    <strong class="text-secondary">Teléfono:</strong><br><span class="text-muted" id="tel_emp_l_${e.id}">${e.telefono}</span>
                </div>
                <div class="col-md-6">
                    <strong class="text-secondary">Dirección:</strong><br><span class="text-muted">${e.direccion}</span>
                </div>
                <div class="col-md-3">
                    <strong class="text-secondary">Puesto:</strong><br><span class="text-muted">${e.puesto}</span>
                </div>
                <div class="col-md-3">
                    <strong class="text-secondary">Salario:</strong><br><span class="text-muted">${e.salario}</span>
                </div>
                <div class="col-md-3">
                    <strong class="text-secondary">Área:</strong><br><span class="text-muted">${e.area}</span>
                </div>
                <div class="col-md-3">
                    <strong class="text-secondary">Jefe Inmediato:</strong><br><span class="text-muted">${e.jefe}</span>
                </div>
                <div class="col-md-3">
                    <strong class="text-secondary">Desde:</strong><br><span class="text-muted">${e.desde}</span>
                </div>
                <div class="col-md-3">
                    <strong class="text-secondary">Hasta:</strong><br><span class="text-muted">${e.hasta}</span>
                </div>
                <div class="col-md-6">
                    <strong class="text-secondary">Motivo de Salida:</strong><br><span class="text-muted">${e.motivo_salida}</span>
                </div>
            </div>
        </div>`;
    }
        
    function validar_ref(id_ref, tipo) 
    {
        var _token = $('input[name="_token"]').val();      
        var parametros = {
            "_token": _token,
            "id_ref": id_ref,
            "tipo": tipo
        };
        if (tipo == 'p') {
            $('#modal-ref-personal').modal('show');
            $('#lb_nombre_ref_p').html($('#nom_ref_p_' + id_ref).text());
            $('#lb_tel_ref_p').html($('#tel_ref_p_' + id_ref).text());
            $('#id_ref_p').val(id_ref);      

            $.ajax({
                data: parametros,
                url: "{{ route('ofertas.valida_ref') }}",
                type: 'POST',
                dataType: "json",
                cache: true,
                success: function(data) {
                    if (data.success) {
                        if(data.referencia.validado_por != null)
                        {
                            // Mostrar nombre y fecha
                            $('#validador_nombre_ref_p').text(data.referencia.nombre_validador);
                            $('#validador_fecha_ref_p').text(data.referencia.f_validacion);
                            $('#info_validador_ref_p').removeClass('d-none');
                            $('#btn_add_ref_p').addClass('d-none');

                            // Resto del código...
                            $('#validacion_ref_p_vinculo').val(data.referencia.vinculo);
                            $('#validacion_ref_p_formardeser').val(data.referencia.forma_de_ser);        
                            $('#validacion_ref_p_porq').val(data.referencia.porq);

                            $('input[name="relaciones_ref_p"][value="' + data.referencia.rel_sociales_sanas + '"]').prop("checked", true);                        
                            $('input[name="responsable_ref_p"][value="' + data.referencia.responsable + '"]').prop("checked", true);
                            $('input[name="cortes_ref_p"][value="' + data.referencia.cortes + '"]').prop("checked", true);
                            $('input[name="cooperador_ref_p"][value="' + data.referencia.cooperador + '"]').prop("checked", true);
                            $('input[name="honestidad_ref_p"][value="' + data.referencia.probl_honestidad + '"]').prop("checked", true);
                            $('input[name="contrataria_ref_p"][value="' + data.referencia.lo_contrataria + '"]').prop("checked", true);

                            // Desactivar campos
                            $('#validacion_ref_p_vinculo').attr('disabled', true);                
                            $('#validacion_ref_p_formardeser').attr('disabled', true);
                            $('#validacion_ref_p_porq').attr('disabled', true);
                            $('input[name="relaciones_ref_p"]').attr('disabled', true);
                            $('input[name="responsable_ref_p"]').attr('disabled', true);
                            $('input[name="cortes_ref_p"]').attr('disabled', true);
                            $('input[name="cooperador_ref_p"]').attr('disabled', true);
                            $('input[name="honestidad_ref_p"]').attr('disabled', true);
                            $('input[name="contrataria_ref_p"]').attr('disabled', true);
                        }
                        else
                        {
                            $('#info_validador_ref_p').addClass('d-none');
                            $('#validacion_ref_p_vinculo').val('');
                            $('#validacion_ref_p_formardeser').val('');        
                            $('#validacion_ref_p_porq').val('');

                            $('input[name="relaciones_ref_p"][value="n"]').prop("checked", true);                        
                            $('input[name="responsable_ref_p"][value="n"]').prop("checked", true);
                            $('input[name="cortes_ref_p"][value="n"]').prop("checked", true);
                            $('input[name="cooperador_ref_p"][value="n"]').prop("checked", true);
                            $('input[name="honestidad_ref_p"][value="n"]').prop("checked", true);
                            $('input[name="contrataria_ref_p"][value="n"]').prop("checked", true);
                            // Activar campos para validar
                            $('#validacion_ref_p_vinculo').attr('disabled', false);                
                            $('#validacion_ref_p_formardeser').attr('disabled', false);
                            $('#validacion_ref_p_porq').attr('disabled', false);
                            $('input[name="relaciones_ref_p"]').attr('disabled', false);
                            $('input[name="responsable_ref_p"]').attr('disabled', false);
                            $('input[name="cortes_ref_p"]').attr('disabled', false);
                            $('input[name="cooperador_ref_p"]').attr('disabled', false);
                            $('input[name="honestidad_ref_p"]').attr('disabled', false);
                            $('input[name="contrataria_ref_p"]').attr('disabled', false);
                            $('#btn_add_ref_p').removeClass('d-none');
                        }
                    } else {
                        mal(data.msn);
                    }
                },
                error: function(xhr) {
                    console.error("Error al validar referencia personal:", xhr.responseText);
                }
            });
        }
        if(tipo=='l')
        {
            $('#modal-ref-laboral').modal('show');           
            $('#tel_emp_l_'+id_ref).html();
            $('#lb_nombre_ref_l').html($('#nom_emp_l_'+id_ref).text());
            $('#lb_tel_ref_l').html($('#tel_emp_l_'+id_ref).text());
            $('#id_ref_l').val(id_ref);         
            $.ajax({
                data: parametros,
                url: "{{ route('ofertas.valida_ref') }}",
                type: 'POST',
                dataType: "json",
                cache: true,
                success: function(data) {                       
                    if (data.success) {
                        if(data.referencia.validado_por != null)
                        {
                            // Mostrar nombre y fecha
                            $('#validador_nombre_ref_l').text(data.referencia.nombre_validador);
                            $('#validador_fecha_ref_l').text(data.referencia.f_validacion);
                            $('#info_validador_ref_l').removeClass('d-none');
                            $('#btn_add_ref_l').addClass('d-none');

                            $('#validacion_ref_l_periodo').val(data.referencia.periodo_laborado);
                            $('#validacion_ref_l_motivo_salida').val(data.referencia.motivo_salida_validado);
                            
                            $('input[name="reljefe_ref_l"][value="' + data.referencia.reljefe + '"]').prop("checked", true);  
                            $('input[name="relcompa_ref_l"][value="' + data.referencia.relcompanero + '"]').prop("checked", true); 
                            $('input[name="puntualidad_ref_l"][value="' + data.referencia.puntualidad + '"]').prop("checked", true); 
                            $('input[name="honestidad_ref_l"][value="' + data.referencia.honestidad + '"]').prop("checked", true); 
                            $('input[name="responsable_ref_l"][value="' + data.referencia.responsable + '"]').prop("checked", true); 
                            $('input[name="cooperador_ref_l"][value="' + data.referencia.cooperador + '"]').prop("checked", true); 
                            $('input[name="cortes_ref_l"][value="' + data.referencia.cortes + '"]').prop("checked", true);  
                            $('input[name="locontrataria_ref_l"][value="' + data.referencia.locontrataria + '"]').prop("checked", true);  
                            $('#validacion_ref_l_obs').val(data.referencia.observacion);
                            $('#referencias_por').val(data.referencia.brindada_por);
                            $('#referencias_puesto_por').val(data.referencia.puesto_por);

                            $('#validacion_ref_l_periodo').attr('disabled', true);
                            $('#validacion_ref_l_motivo_salida').attr('disabled', true);
                            $('input[name="reljefe_ref_l"]').attr('disabled', true);
                            $('input[name="relcompa_ref_l"]').attr('disabled', true);
                            $('input[name="puntualidad_ref_l"]').attr('disabled', true); 
                            $('input[name="honestidad_ref_l"]').attr('disabled', true);
                            $('input[name="responsable_ref_l"]').attr('disabled', true);
                            $('input[name="cooperador_ref_l"]').attr('disabled', true);
                            $('input[name="cortes_ref_l"]').attr('disabled', true);
                            $('input[name="locontrataria_ref_l"]').attr('disabled', true);
                            $('#validacion_ref_l_obs').attr('disabled', true);
                            $('#referencias_por').attr('disabled', true);
                            $('#referencias_puesto_por').attr('disabled', true);
                        }
                        else
                        {   $('#btn_add_ref_l').removeClass('d-none');
                            $('#info_validador_ref_l').addClass('d-none');
                            $('#validacion_ref_l_periodo').val('');
                            $('#validacion_ref_l_motivo_salida').val('');
                            $('input[name="reljefe_ref_l"][value="1"]').prop("checked", true);
                            $('input[name="relcompa_ref_l"][value="1"]').prop("checked", true);
                            $('input[name="puntualidad_ref_l"][value="1"]').prop("checked", true);
                            $('input[name="honestidad_ref_l"][value="n"]').prop("checked", true);
                            $('input[name="responsable_ref_l"][value="n"]').prop("checked", true);
                            $('input[name="cooperador_ref_l"][value="n"]').prop("checked", true);
                            $('input[name="cortes_ref_l"][value="n"]').prop("checked", true);
                            $('input[name="locontrataria_ref_l"][value="n"]').prop("checked", true);
                            $('#validacion_ref_l_obs').val('');
                            $('#referencias_por').val('');
                            $('#referencias_puesto_por').val('');

                            $('#validacion_ref_l_periodo').attr('disabled', false);
                            $('#validacion_ref_l_motivo_salida').attr('disabled', false);
                            $('input[name="reljefe_ref_l"]').attr('disabled', false);
                            $('input[name="relcompa_ref_l"]').attr('disabled', false);
                            $('input[name="puntualidad_ref_l"]').attr('disabled', false); 
                            $('input[name="honestidad_ref_l"]').attr('disabled', false);
                            $('input[name="responsable_ref_l"]').attr('disabled', false);
                            $('input[name="cooperador_ref_l"]').attr('disabled', false);
                            $('input[name="cortes_ref_l"]').attr('disabled', false);
                            $('input[name="locontrataria_ref_l"]').attr('disabled', false);
                            $('#validacion_ref_l_obs').attr('disabled', false);
                            $('#referencias_por').attr('disabled', false);
                            $('#referencias_puesto_por').attr('disabled', false);
                            
                        }
                    } else {
                        mal(data.msn);
                    }
                },
                error: function(xhr) {
                    console.error("Error al validar referencia personal:", xhr.responseText);
                }
            });
        }
    }

    function guardar_ref_personal(tipo)
    {   
        var _token = $('input[name="_token"]').val();
        if(tipo=='p')
        {   
            var id_ref = $('#id_ref_p').val();        
            var vinculo=$('#validacion_ref_p_vinculo').val().trim();
            var formardeser = $('#validacion_ref_p_formardeser').val().trim();
            var relaciones_ref_p = $('input[name="relaciones_ref_p"]:checked').val();
            var responsable_ref_p = $('input[name="responsable_ref_p"]:checked').val();
            var cortes_ref_p = $('input[name="cortes_ref_p"]:checked').val();
            var cooperador_ref_p = $('input[name="cooperador_ref_p"]:checked').val();
            var honestidad_ref_p = $('input[name="honestidad_ref_p"]:checked').val();
            var contrataria_ref_p = $('input[name="contrataria_ref_p"]:checked').val();
            var validacion_ref_p_porq = $('#validacion_ref_p_porq').val().trim();
            if((vinculo.length==0)||(formardeser.length==0)||(validacion_ref_p_porq.length==0))
            {   $('#alert_ref_p').removeClass('d-none')
                setTimeout(function() {$('#alert_ref_p').addClass('d-none');}, 2000);
                return;
            }               
            
            var parametros = {
                "_token": _token,
                "id_ref": id_ref,
                "vinculo": vinculo,
                "formardeser": formardeser,
                "relaciones_ref_p": relaciones_ref_p,
                "responsable_ref_p": responsable_ref_p,
                "cortes_ref_p": cortes_ref_p,
                "cooperador_ref_p": cooperador_ref_p,
                "honestidad_ref_p": honestidad_ref_p,
                "contrataria_ref_p": contrataria_ref_p,
                "validacion_ref_p_porq": validacion_ref_p_porq,
                "id_participante" : $('#reclutamiento_id_participante').val(),
            };
            $.ajax({
                data: parametros,
                url: "{{ route('ofertas.update_validacion_ref_p') }}",
                type: 'POST',
                dataType: "json",
                cache: true,
                success: function(data) {
                    if (data.success) {
                        $('#modal-ref-personal').modal('hide'); 
                        $('#lb_nombre_ref_p').html('');
                        $('#lb_tel_ref_p').html('');
                        $('#btn_ref_p_'+id_ref).removeClass('btn-outline-primary');
                        $('#btn_ref_p_'+id_ref).addClass('btn-success');
                        $('#btn_ref_p_'+id_ref).html('<i class="fa-solid fa-check-double pe-1"></i>Validado');                       
                                    
                    } else {
                        mal('Error al almacenar información, por favor intente nuevamente.');
                    }
                },
                error: function(xhr) {
                    console.error("Error al validar referencia personal:", xhr.responseText);
                }
            });
        }
        if(tipo=='l')
        {
            var id_ref = $('#id_ref_l').val();        
            var periodo=$('#validacion_ref_l_periodo').val().trim();
            var motivo_salida = $('#validacion_ref_l_motivo_salida').val().trim();
            var reljefe_ref_l = $('input[name="reljefe_ref_l"]:checked').val();
            var relcompa_ref_l = $('input[name="relcompa_ref_l"]:checked').val();
            var puntualidad_ref_l = $('input[name="puntualidad_ref_l"]:checked').val();
            var honestidad_ref_l = $('input[name="honestidad_ref_l"]:checked').val();
            var responsable_ref_l = $('input[name="responsable_ref_l"]:checked').val();
            var cooperador_ref_l = $('input[name="cooperador_ref_l"]:checked').val();
            var cortes_ref_l = $('input[name="cortes_ref_l"]:checked').val();
            var locontrataria_ref_l = $('input[name="locontrataria_ref_l"]:checked').val();
            var validacion_ref_l_obs=$('#validacion_ref_l_obs').val().trim();
            var referencias_por=$('#referencias_por').val().trim();
            var referencias_puesto_por=$('#referencias_puesto_por').val().trim();
            if((periodo.length==0)||(motivo_salida.length==0)||(referencias_por.length==0)||(referencias_puesto_por.length==0))
            {   $('#alert_ref_l').removeClass('d-none')
                setTimeout(function() {$('#alert_ref_l').addClass('d-none');}, 2000);
                return;
            }  

            var parametros = {
                "_token": _token,
                "id_ref": id_ref,
                "periodo": periodo,
                "motivo_salida": motivo_salida,
                "reljefe_ref_l": reljefe_ref_l,
                "relcompa_ref_l": relcompa_ref_l,
                "puntualidad_ref_l": puntualidad_ref_l,
                "honestidad_ref_l": honestidad_ref_l,
                "responsable_ref_l": responsable_ref_l,
                "cooperador_ref_l": cooperador_ref_l,
                "cortes_ref_l": cortes_ref_l,
                "locontrataria_ref_l": locontrataria_ref_l,
                "validacion_ref_l_obs": validacion_ref_l_obs,
                "referencias_por": referencias_por,
                "referencias_puesto_por": referencias_puesto_por,
                "id_participante" : $('#reclutamiento_id_participante').val(),
            };
            $.ajax({
                data: parametros,
                url: "{{ route('ofertas.update_validacion_ref_l') }}",
                type: 'POST',
                dataType: "json",
                cache: true,
                success: function(data) {
                    if (data.success) {
                        $('#modal-ref-laboral').modal('hide'); 
                        $('#lb_nombre_ref_l').html('');
                        $('#lb_tel_ref_l').html('');
                        $('#btn_ref_l_'+id_ref).removeClass('btn-outline-primary');
                        $('#btn_ref_l_'+id_ref).addClass('btn-success');
                        $('#btn_ref_l_'+id_ref).html('<i class="fa-solid fa-check-double pe-1"></i>Validado');                       
                                    
                    } else {
                        mal('Error al almacenar información, por favor intente nuevamente.');
                    }
                },
                error: function(xhr) {
                    console.error("Error al validar referencia personal:", xhr.responseText);
                }
            });

        }
    }

    function cancel_det_candidate(opt) {
        $('#bto_volver_det_candidato').addClass('d-none');
        $('#bto_listado_candidato').removeClass('d-none');
        $('#div_oferta_laboral').removeClass('d-none');
        $('#div_terna').addClass('d-none');
        $('#Detalle-Candidato').addClass('d-none');
        mod_prospectos($('#id_ofl').val());
    }

    //----- GENERA PDF CARTA OFERTA
    function gererapdf(id) {
        $("#idformulario").html('');
        var form = $("<form/>", {
            action: "{{ route('ofertas.cartapdf') }}",
            method: 'POST',
            id: 'from_cart'
        });
        form.append($("<input>", { type: 'hidden', id: 'txtid', name: 'txtid', value: id }));
        form.append($("<input>", { type: 'hidden', id: 'tok', name: 'tok', value: $('input[name="_token"]').val()}));
        form.append($("<input>", { type: 'hidden', id: 'opt', name: 'opt', value: 0 }));
        form.append('@csrf');
        $("#idformulario").append(form);

        var _token = $('input[name="_token"]').val();
        var parametros = {
            "txtid": id,
            "opt": 1,
            "_token": _token
        };
        $.ajax({
            data: parametros,
            url: "{{ route('ofertas.cartapdf') }}",
            type: 'POST',
            cache: true,
            beforeSend: function() {
                document.getElementById("ico_" + id).innerHTML =
                    '<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
                from_cart.submit();
            },
            success: function(data) {
                if (data == 1) {
                    document.getElementById('div_autorizacioncarta_ofl').style.display = 'block';
                    document.getElementById("ico_" + id).innerHTML =
                        '<i class="fas fa-download fa-lg activar" onclick="gererapdf(' + id + ')"></i>';
                }
            }
        });
    }

    //----- MUESTRA EL DETALLE DE UNA OFERTA LABORAL
    function busca_ofl(id_ofl) {
        var _token = $('input[name="_token"]').val();
        limpiar();
        $('#modalsoli').modal('show');
        $('#asginar_reclutador').val($('#idu').val());
        var parametros = {
            "id_ofl": id_ofl,
            "_token": _token
        };
        $.ajax({
            data: parametros,
            url: "{{ route('ofertas.show') }}",
            type: 'POST',
            dataType: "json",
            cache: true,
            beforeSend: function() {
                document.getElementById("lb_id_sol").innerHTML = '<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
            },
            success: function(data) {
                jQuery(data).each(function(i, item) {
                    //  document.getElementById("sel_status").style.display='block';
                    if(item.id_estatus==1){
                        $('#bto_rechaza').removeClass('d-none');
                        $('#bto_guarda').removeClass('d-none');
                        $('#div_reasigna_confidencial').removeClass('d-none');
                    }
                    if(item.id_estatus!=1){
                        $('#bto_rechaza').addClass('d-none');
                        $('#bto_guarda').addClass('d-none');
                        $('#div_reasigna_confidencial').addClass('d-none');
                    }
                    document.getElementById('lb_id_sol').innerHTML = id_ofl;
                    document.getElementById("id_ofl_txt").value = item.id;
                    document.getElementById("lb_f_sol").innerHTML = item.fecha_sol;
                    document.getElementById("lb_f_lim").innerHTML = item.tiempocalculado;
                    document.getElementById("lb_ue").value = item.unidad_economica;
                    document.getElementById("lb_secc").value = item.seccion;
                    document.getElementById("lb_nom_posicion_sol").value = item.descpue;
                    document.getElementById("lb_cant").innerHTML = item.cantidad;
                    document.getElementById("lb_genero").value = item.genero;
                    document.getElementById("lb_edad").value = item.rango_edad;
                    document.getElementById("lb_motivo").value = item.motivo;
                    document.getElementById("lb_doc_aut").innerHTML = "";
                    document.getElementById("lb_aprobado").innerHTML = item.aprobado;
                    document.getElementById("salario_min").value = item.min_salario;
                    document.getElementById("salario_max").value = item.max_salario;

                    document.getElementById("lb_real").innerHTML = item.countreal;
                    if (item.autorizacion != '-') {
                        document.getElementById("lb_doc_aut").innerHTML = '<a href="' + item.autorizacion + '" download="' + item.autorizacion +'"><i class="fas fa-download"></i> Descargar autorización</a>'
                    }
                    document.getElementById("lb_coment").value = item.comentarios;
                    document.getElementById("lb_por").innerHTML = item.usrname;

                    document.getElementById('lb_id_sol_rech').innerHTML = id_ofl;
                    document.getElementById("lb_nom_posicion_sol_rech").value = item.descpue;
                    document.getElementById("lb_cant_rech").value = item.cantidad;

                });
            }
        });
    }

    //----PARA CAMBIAR EL ESTADO DE LA OFERTE LABORAL
    function su(id_estatus) {
        var _token = $('input[name="_token"]').val();
        //--id_estatus=document.getElementById("sel_status").value;
        id_ofl_txt = document.getElementById("id_ofl_txt").value;

        if (id_estatus == '2') {
            var conf=$('#Confidencial').is(':checked') ? 1 : 0;
            if ($('#asginar_reclutador').val() == 0) {
                mal("Debe seleccionar un reclutador");
                return;
            }
            var parametros = {
                "_token": _token,
                "id_estatus": id_estatus,
                "id_ofl": id_ofl_txt,
                "confidencial": conf,
                "id_reclutador" :$('#asginar_reclutador').val()
            };
            $.ajax({
                data: parametros,
                url: "{{ route('ofertas.update') }}",
                type: 'POST',
                dataType: "json",
                cache: true,
                success: function(data) {
                    if(data.result) {
                        document.getElementById('divico_' + id_ofl_txt).innerHTML =
                            '<div class="dropdown py-0">' +
                            '<button class="btn btn-info btn-sm dropdown-toggle text-light" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-gear pe-2"></i>Acciones </button>' +
                            '<ul class="dropdown-menu p-0">' +
                                '<li><button class="border-top dropdown-item py-1" type="button" onclick="mod_prospectos(' + id_ofl_txt + ')">' + data.icono + ' Ver Candidatos</button></li>' +
                                '<li><button class="border-top dropdown-item py-1" type="button" onclick="busca_ofl(' + id_ofl_txt + ')"><i class="fa-solid fa-magnifying-glass pe-2 text-primary"></i>Ver Solicitud</button></li>' +
                                '<li><button class="border-top dropdown-item py-1" type="button"  onclick="asigrecuiter(' + id_ofl_txt + ',1)"><i class="fa-solid fa-people-arrows pe-2 text-primary"></i>Reasignar reclutador</button></li>'+
                            '</ul>' +
                            '</div>';
                        $("#ofl_" + id_ofl_txt).removeClass('border-warning');
                        $("#ofl_" + id_ofl_txt).addClass('border-primary');
                        $('#conf_' + id_ofl_txt).html('');
                        if(conf==1)
                        {   $('#conf_'+ id_ofl_txt).html("<span class='ms-2 badge rounded-pill text-danger' style='background-color: #f8d7da; font-size: 12px;'><i class='fa-solid fa-triangle-exclamation pe-1'></i>Confidencial</span>");}
                                
                        const reclutador = data.reclutador;
                        let htmlReclutador = '';

                        if (reclutador.foto) {
                            // Si tiene foto
                            htmlReclutador = `
                                <div class="d-inline-flex align-items-center ms-1">
                                    <img src="${reclutador.foto}" 
                                        class="rounded-circle me-1" 
                                        style="width:24px;height:24px;object-fit:cover;border:1px solid #ccc; vertical-align:middle;">
                                    <span class="text-primary fw-semibold" id="reclutador_` + id_ofl_txt + `">${reclutador.prinombre} ${reclutador.priapellido}</span>
                                </div>
                            `;
                        } else {
                            // Si no tiene foto, mostrar iniciales
                            const iniciales = (reclutador.prinombre[0] ?? '') + (reclutador.priapellido[0] ?? '');
                            htmlReclutador = `
                                <div class="d-inline-flex align-items-center ms-1">
                                    <span class="rounded-circle me-1 d-flex align-items-center justify-content-center"
                                        style="width:24px;height:24px;background:${reclutador.color_bg};
                                            color:${reclutador.color_text};font-size:11px;font-weight:bold;
                                            border:1px solid ${reclutador.color_text}">
                                        ${iniciales.toUpperCase()}
                                    </span>
                                    <span class="text-primary fw-semibold" id="reclutador_` + id_ofl_txt + `">${reclutador.prinombre} ${reclutador.priapellido}</span>
                                </div>
                            `;
                        }
                        $('#div_nombre_reclutador_'+id_ofl_txt).html(htmlReclutador);
                        $('#ofl_' + id_ofl_txt).attr('data-reclutador', reclutador.id);
                        
                        $('#tot_vacantes_activas').html(data.stats.vacantes_activas); 
                        $('#tot_vacantes_asignadas').html(data.stats.vacantes_asignadas);
                        $('#tot_vacantes_sin_asignar').html(data.stats.vacantes_sin_asignar);
                        $('#tot_vacantes_del_mes').html(data.stats.vacantes_del_mes);
                        const reclutadores = data.reclutadores;
                        jQuery(data.reclutadores).each(function(i, item) {
                            $('#id_cantidad_badge_'+item.id).html(item.total_vacantes);
                        })
                        limpiar();
                        $('#modalsoli').modal('hide');
                        $('#div_reasigna_confidencial').addClass('d-none');
                        bien("El estado de la solicitud ha cambiado.");
                    };
                }
            });
        }
        if (id_estatus == '4') {
            $('#modalsoli').modal('hide');
            $('#Modal_del').modal('show');
        }
    }

    //---- RECHAZANDO UNA OFERTA LABORAL ------ AQUI SE DEBE ENVIA LA NOTIFICACIÓN DE RECHAZO AL SOLICITANTE
    function re(id_estatus) {
        var _token = $('input[name="_token"]').val();
        var txt_area_observacion = document.getElementById("txt_area_observacion").value;
        //-- var id_estatus= document.getElementById("sel_status").value;
        var id_ofl_txt = document.getElementById("id_ofl_txt").value;
        Swal.fire({
            icon: 'question',
            text: "Se rechazará la solicitud, desea continuar?",
            showCancelButton: true,
            cancelButtonText: '<i class="fas fa-arrow-left"></i> Cancelar',
            confirmButtonText: '<i class="fas fa-trash-alt"></i> Si, rechazar',
            confirmButtonColor: "#d33",
        }).then((result) => {
            if (result.isConfirmed) {
                if (txt_area_observacion.length >= '10') {
                    var parametros = {
                        "_token": _token,
                        "txt_area_observacion": txt_area_observacion,
                        "id_estatus": id_estatus,
                        "id_ofl": id_ofl_txt
                    };
                    $.ajax({
                        data: parametros,
                        url: "{{ route('ofertas.update') }}",
                        type: 'POST',
                        dataType: "json",
                        cache: true,
                        beforeSend: function() {
                            document.getElementById("lb_id_sol_rech").innerHTML =
                                '<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
                        },
                        success: function(data) {
                            $('#ofl_' + id_ofl_txt).remove();
                            
                            $('#tot_vacantes_activas').html(data.stats.vacantes_activas); 
                            $('#tot_vacantes_asignadas').html(data.stats.vacantes_asignadas);
                            $('#tot_vacantes_sin_asignar').html(data.stats.vacantes_sin_asignar);
                            $('#tot_vacantes_del_mes').html(data.stats.vacantes_del_mes);
                            const reclutadores = data.reclutadores;
                            jQuery(data.reclutadores).each(function(i, item) {
                                $('#id_cantidad_badge_'+item.id).html(item.total_vacantes);
                            })

                            limpiar();
                            $('#Modal_del').modal('hide');
                            $('#modalsoli').modal('hide');
                            bien("La solicitud de contraración ha sido rechazada.")
                        }
                    });
                } else {
                    Swal.fire({
                        icon: "warning",
                        text: "Por favor detallar un poco más el motivo del rechazo.",
                    });
                }
            }
        });
    }

    function cancel_ofl() {
        $('#div_oferta_laboral').addClass('d-none');
        $('#listado').removeClass('d-none');
        $('#div_titulo_sol').removeClass('d-none');
        $('#div_badge_solicitudes').removeClass('d-none');
        $('#div_titulo_pos').addClass('d-none');
        $('#bto_listado_candidato').removeClass('d-none');
    }

    //----- LIMPIA FORMULARIO DE DETALLE DE LA SOLICITUD
    function limpiar() {
        //-- document.getElementById("sel_status").style.display='none';
        //-- document.getElementById("sel_status").value=1;  
        document.getElementById("id_ofl_txt").value = '';
        document.getElementById("lb_f_sol").innerHTML = '';
        document.getElementById("lb_f_lim").innerHTML = '';
        document.getElementById("lb_ue").value = '';
        document.getElementById("lb_secc").value = '';
        document.getElementById("lb_nom_posicion_sol").value = '';
        document.getElementById("lb_cant").value = '';
        document.getElementById("lb_genero").value = '';
        document.getElementById("lb_edad").value = '';
        document.getElementById("lb_motivo").value = '';
        document.getElementById("lb_doc_aut").innerHTML = '';
        document.getElementById("lb_doc_aut").innerHTML = '';
        document.getElementById("lb_coment").value = '';
        document.getElementById("lb_por").innerHTML = '';

        document.getElementById('lb_id_sol').innerHTML = '';
        document.getElementById("txt_area_observacion").value = '';

        
        document.getElementById('lb_cant_part').innerHTML = '';
        $('#lb_cant_contratados').html('');
       
       
        document.getElementById("lb_fech_sol").innerHTML = '';
    }

    //----- LISTADO DE PARTICIPANTES
    function mod_prospectos(id_ofl) {
        //limpia_frm();
        $('#div_titulo_sol').addClass('d-none');
        $('#div_badge_solicitudes').addClass('d-none');
        $('#div_titulo_pos').removeClass('d-none');
        $('#div_oferta_laboral').removeClass('d-none');
        $('#div_terna').addClass('d-none');
        $('#listado').addClass('d-none');
        $("#reclutamiento_nom_puesto").val('');
        $("#reclutamiento_nom_unidad").val('');

        var _token = $('input[name="_token"]').val();
        $('#nom_puesto_calce').html('<span class="text-secondary fw-bold h5">' + document.getElementById('despue_' + id_ofl).innerHTML + '</span>');

        var parametros = {
            "_token": _token,
            "id_ofl": id_ofl
        };
        $.ajax({
            data: parametros,
            url: "{{ route('ofertas.edit') }}",
            type: 'POST',
            dataType: "json",
            cache: true,
            success: function(data) {
                const candidatos = data.candidatos;
                const entrevistas = data.entrevistas;
                const oferta = data.oferta[0];
                $("#hrs_mensuales").val(oferta.hrs_mensuales);
                $('#jerarquia_calce').html('<span class="text-secondary">Perfil: </span>'+oferta.jerarquia);
                $('#jerarquia_analisis_apl').html(oferta.jerarquia);
                $('#lb_cant_part').html('Cantidad Solicitada:</b> <span class="text-secondary"><b>'+oferta.cantidad+'</b></span>');
                $('#lb_cant_contratados').html('Contratados:</b> <span class="text-secondary"><b>'+oferta.contratados+'</b></span>');
                $('#lb_fech_sol').html('Cantidad Solicitada:</b> <span class="text-secondary"><b>'+oferta.f_solicitud_formateada+'</b></span>');

                document.getElementById("tbody_aspirantes").innerHTML = "";
                var nuevaFila = '';
                band = 0;
                jQuery(candidatos).each(function(i, item) {
                    if (item.prinombre != null) {
                        band = 1;
                        var segnombre = item.segnombre || '';
                        var segapellido = item.segapellido || '';
                        var nombre_completo = item.prinombre + ' ' + item.priapellido;
                        var flag_entrevista_fun = '';
                        flag_entrevista_fun = item.banges;
                        if(item.id_etapa==6){
                            band_entrevis=0;                            
                            jQuery(entrevistas).each(function(x, item_2) {
                                if (id_ofl == item_2.id_ofl && item.id_participante == item_2.id_part) {    
                                    if(item_2.id_entrevista!=null){
                                        if(item_2.f_entrevista==null)
                                        {   flag_entrevista_fun='<span class="badge rounded-pill" style="background-color: #fff3cd; color:#644C06;"><i class="fa-solid fa-flag text-warning pe-1"></i> Agendar Entrevista </span>';}
                                        else
                                        {   if(item_2.entrevista_realizada==0)
                                            {   flag_entrevista_fun='<span class="badge rounded-pill text-white bg-primary"><i class="fa-solid fa-calendar-days pe-1"></i> Entrevista agendada</span>';}
                                            if(item_2.entrevista_realizada==1)
                                            {   let contratar="";
                                                if(item_2.notifica_contratar==1) { contratar='<span class="badge rounded-pill text-secondary" style="background-color: #dee2e6;"><i class="fa-solid fa-user-clock fa-lg pe-1"></i> En Espera</span><br>'  }
                                                if(item_2.notifica_contratar==2) { contratar='<span class="badge rounded-pill text-danger" style="background-color: #f8d7da;"><i class="fa-solid fa-user-xmark fa-lg pe-1"></i> Declinado</span><br>'  }
                                                if(item_2.notifica_contratar==3) { contratar='<span class="badge rounded-pill text-success" style="background-color: #d4edda;"><i class="fa-solid fa-user-check fa-lg pe-1"></i> Contratar</span><br>'  }
                                                
                                                flag_entrevista_fun=contratar+'<span class="badge rounded-pill text-secondary"><i class="fa-solid fa-check-double pe-1"></i> Entrevista Finalizada</span><br><span class="badge text-secondary">Valoración promedio: <span class="text-primary">'+item_2.valoracion_promedio+'%</span></span>';}
                                        }
                                    }
                                    band_entrevis=1;
                                    return false; // Salir del bucle si se encuentra una coincidencia                                    
                                }
                            });
                            if(band_entrevis==0){
                                flag_entrevista_fun='<span class="badge rounded-pill" style="background-color: #fff3cd; color:#644C06;"><i class="fa-solid fa-flag text-warning pe-1"></i> Agendar Entrevista </span>';
                            }
                        }
                        const nombre = `${item.prinombre} ${item.priapellido}`;
                        const iniciales = `${(item.prinombre || '').charAt(0)}${(item.priapellido || '').charAt(0)}`.toUpperCase();

                        const color_tx = item.color_text; const color_bg = item.color_bg;
                        let fotoHtml = `<img src="${item.foto}" alt="Foto de ${nombre}" class="rounded-circle" style="background:#FFFFFF; width: 60px; height: 60px; object-fit: cover; border: 1px solid #aeafb0;">`;
                        if (!item.foto) {
                            fotoHtml = `
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="
                                width: 60px; height: 60px; background-color: ${color_bg};  border-radius: 50%;  display: flex;  align-items: center;  justify-content: center;  color: ${color_tx};  font-family: 'Segoe UI', 'Roboto', sans-serif;
                                font-size: 22px;  text-transform: uppercase;  border: 1px solid ${color_tx}">
                                    ${iniciales}
                                </div>`;
                        }
                        nuevaFila += '<tr class="oflinfo">';
                        nuevaFila +=
                            '<td class="align-middle">' +
                                '<div class="d-flex align-items-center">' +
                                '<input type="hidden" id="color_tx_' +  item.id_curri + '" value="'+color_tx+'">' +
                                '<input type="hidden" id="color_bg_' +  item.id_curri + '" value="'+color_bg+'">' +
                                    '<div class="me-2">' +
                                        fotoHtml+
                                    '</div>' +
                                    '<div>' +
                                        '<div class="fw-bold text-uppercase" style="color: #4B6EAD;font-size: 13px">' + nombre_completo + '</div>' +
                                        '<div class="text-secondary fw-bold" style="font-size: 12px">' + item.titulo + '</div>' +
                                        '<div class="text-secondary" style="font-size: 11px"><i class="fa-solid fa-envelope pe-1"></i><span class="text-primary">' + item.email + '</span></div>' +
                                        '<div class="text-secondary" style="font-size: 11px"><i class="fa-solid fa-phone-flip pe-1"></i>' + item.tel + '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</td>';
                        nuevaFila += '<td class="text-center align-middle small">' + item.aspiracion_sal + '</td>';
                        nuevaFila += '<td class="text-center align-middle"><span id="div_banges_' + item.id_curri + '">' + flag_entrevista_fun + '</span><br><div class="text-secondary" style="font-size: 10px;">'+item.f_status+'</div></td>';
                        nuevaFila += '<td class="text-center align-middle"><i class="fas fa-search edit pr-2" onclick=ver_det_candidate(' +  item.id_curri + ',' + item.id_participante + ')></i><span class="p-1"> </span><i class="fas fa-trash-alt dell" onclick=delprospecto(this,"prospectos",' + item.id_participante + ')></i></td>';
                        nuevaFila += '</tr>';
                    }
                });
                if (band === 0) {
                    nuevaFila = '<tr><td colspan="6" class="text-center text-muted py-2">No hay candidatos registrados.</td></tr>';
                }
                $('#id_ofl').val(id_ofl);

                $('#id_ofl_glb').val(id_ofl);
                $("#tbody_aspirantes").html(nuevaFila);                
                $('#nom_pos_ofl').html('<b><span id="nom_posicion_olf">' + oferta.nom_puesto + '<span></b>, <small><small>' + oferta.unidad + '</small></small>');
                $('#subject').val('Presentación de Terna ' + oferta.nom_puesto);
                $("#reclutamiento_nom_puesto").val(oferta.nom_puesto);
                $("#reclutamiento_nom_unidad").val(oferta.unidad);

            }
        });
    }

    //----- BUSCA CECOS
    function findceco(selectElement,cod_ceco) {
        const codcia = selectElement;
        const _token = $('input[name="_token"]').val();

        if (codcia !== "0" && codcia.trim() !== "") {
            $.ajax({
                url: "{{ route('ofertas.ceco') }}",
                type: "POST",
                data: { codcia: codcia, _token: _token },
                dataType: "json",
                success: function(data) {
                    const $cecoSelect = $('#sel_ceco');
                    const $cecoSelect_firma = $('#sel_ceco_firma');
                    $cecoSelect.empty().append("<option value='0'>Seleccionar</option>");
                    $cecoSelect_firma.empty();
                    $.each(data, function(i, item) {
                        $cecoSelect.append(`<option value="${item.cod_cia}">${item.cod_cia} - ${item.nom_cia}</option>`);
                        $cecoSelect_firma.append(`<option value="${item.cod_cia}">${item.cod_cia} - ${item.nom_cia}</option>`);
                    });
                    $cecoSelect.prop('disabled', false);
                    $cecoSelect_firma.prop('disabled', false);
                    $('#sel_ceco').val(cod_ceco).change(); // Selecciona el CECO si se proporciona
                    $('#sel_ceco_firma').val(cod_ceco).change(); // Selecciona el CECO si se proporciona
                },
                error: function(xhr, status, error) {
                    console.error("Error al cargar CECOs:", error);
                    mal("Ocurrió un error al obtener los centros de costo.");
                }
            });
        } else {
            $('#sel_ceco').empty().prop('disabled', true);
        }
    }
    //----- ELIMINA FILA DEL PARTICIPANTE SIN ELIMINAR EL REGISTRO DE LA HOJA DE VIDA
    function delprospecto(thisrow, nomtable, idparti) {
        var _token = $('input[name="_token"]').val();
        var id_ofl = $('input[id="id_ofl"]').val();
        Swal.fire({
            text: "Se eliminará el candidato de la solicitud; sin embargo, la hoja de vida querará almacenada en la base de datos.",
            showCancelButton: true,
            icon: "info",
            confirmButtonText: '<i class="fas fa-trash-alt"></i> Eliminar',
            cancelButtonText: '<i class="fas fa-arrow-left"></i> Cancelar',
            confirmButtonColor: "#d33",
        }).then((result) => {
            if (result.isConfirmed) {
                var parametros = {
                    "_token": _token,
                    "id_ofl": id_ofl,
                    "idparti": idparti
                };
                $.ajax({
                    data: parametros,
                    url: "{{ route('ofertas.destroy') }}",
                    type: 'POST',
                    dataType: "json",
                    cache: true,
                    success: function(data) {
                        jQuery(data).each(function(i, item) {
                            //document.getElementById('lb_proceso_part').innerHTML= 'Candidatos: <span class="text-secondary"><b>'+data.conteos+'</b></span>';
                            //document.getElementById('cantpart_'+id_ofl).innerHTML= data.conteos;
                            //document.getElementById('lb_cont_part').innerHTML='Contratados: <span class="text-secondary"><b>'+data.conteoscontratados+'</b></span>';
                            //document.getElementById('cantcont_'+id_ofl).innerHTML= data.conteoscontratados;

                            //document.getElementById('lb_proceso_part').innerHTML = 'Candidatos: <span class="text-secondary"><b>' + data.cant_proceso + '</b></span>';
                            //document.getElementById('lb_cont_part').innerHTML = 'Contratados: <span class="text-secondary"><b>' + data.cant_contratado + '</b></span>';

                            document.getElementById('cantpart_' + data.id_ofl).innerHTML = data.cant_proceso;
                            document.getElementById('cantinicial_' + data.id_ofl).innerHTML = data.cant_inicial;
                            document.getElementById('cantfuncional_' + data.id_ofl).innerHTML = data.cant_funcional;
                            document.getElementById('cantofertalaboral_' + data.id_ofl).innerHTML = data.cant_ofertalaboral;
                            document.getElementById('cantdocumentacion_' + data.id_ofl).innerHTML = data.cant_documentacion;
                            document.getElementById('cantfirma_' + data.id_ofl).innerHTML = data.cant_firma;
                            document.getElementById('cantcont_' + data.id_ofl).innerHTML = data.cant_contratado;
                            if (data.eliminado == 0) {
                                delrow(thisrow, nomtable);
                            }
                            if (data.eliminado == 1) {
                                mal("Imposoble eliminar el candidato, debido al estatus que mantiene");
                            }
                        });
                    }
                });
            }
        });
    }
 
    //--- ELIMINA UNA FILA DE CUALQUIER TABLA, SE PASA LA FILA CON THIS Y EL NOMBRE DE TABLA "table_NOMBRETABLA"
    function delrow(id, opt_table) {
        let row = id.parentNode.parentNode;
        let table = document.getElementById("table_" + opt_table);
        table.deleteRow(row.rowIndex);
    }

    //----- MENSAJE GENERICO SI ALGO SALE MAL, SE ENVIA EL MENSAJE EN EL PARAMETRO
    function mal(msn) {
        return Swal.fire({
            position: 'center',
            icon: 'warning',
            text: msn,
        });
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
       
    function iconoCheck(valor) 
    {
        return valor === "S"
        ? '<i class="fa-solid fa-check-circle text-success me-2"></i>'
        : '<i class="fa-regular fa-circle-xmark text-danger me-2"></i>';
    }

    function toggleInput(checkbox,tipo) {
        const id = checkbox.id.replace('_'+tipo+'check', '');
        const inputGroup = document.getElementById(id + '_'+tipo+'txt')?.closest('.input-group');

        if (!inputGroup) return;

        if (checkbox.checked) {
            inputGroup.classList.remove('d-none');
        } else {
            inputGroup.classList.add('d-none');
            document.getElementById(id + '_'+tipo+'txt').value = '';
        }
    }

    function resetBeneficiosHerramientas() {
        // Reiniciar el formulario
        $('#salario_base_radio').prop('checked', true);
        $('#salario_hora_radio').prop('checked', false);
        $('#div_salario_hora').addClass('d-none');
        $('#contrato_permanente_radio').prop('checked', true);
        $('#contrato_temporal_radio').prop('checked', false);
        $('#div_fecha_terminacion').addClass('d-none');

        $('#sel_ceco').prop('disabled', true);
        
     

        // Desmarcar todos los checkboxes
        $('#beneficios_container input[type="checkbox"], #herramientas_container input[type="checkbox"]').prop('checked', false);

        // Ocultar y limpiar todos los input-group asociados
        $('#beneficios_container .input-group, #herramientas_container .input-group').each(function() {
            $(this).addClass('d-none');
            $(this).find('input[type="number"]').val('');
        });
    }
</script>
