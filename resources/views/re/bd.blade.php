@extends('layouts.plantilla')

@section('title','base de Datos')
@section('content')

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
      #img_photo:hover {filter: sepia(75%);}      
    </style> 
    <form id="form_new_reg" enctype="multipart/form-data">
        <div class="pagetitle pb-0 mb-0">
            <div class="row pb-0 mb-0">
                <div class="col-6 my-0 py-0">
                    <h1 class="text-secondary">Hojas de Vida</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item" style="font-weight: normal;">Hojas de Vida</li>
                            <li class="breadcrumb-item" style="color: #4B6EAD"><span id="div_nomsecreg">Listado de Registros</span></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-6 my-0 py-0 d-flex d-grid gap-2 align-items-center justify-content-end">
                    <button type="button" id="bto_n" class="ms-4 btn btn-sm btn-primary" onclick="canceladd_reg()"><i class="fas fa-plus-circle fa-lg pe-1"></i> Nuevo Registro</button>
                    <button type="button" id="bto_c" class="btn btn-sm btn-secondary d-none" onclick="canceladd_reg()"><i class="fa-solid fa-arrow-left fa-lg pe-2"></i>Cancelar</button>
                    <button type="button" id="bto_d" class="btn btn-sm btn-outline-danger d-none me-4" onclick="dell_reg()"><i class="fa-solid fa-trash-can fa-lg pe-2"></i>Eliminar Hoja de Vida</button>
                    <button type="button" id="bto_e" class="btn btn-sm btn-outline-primary d-none me-4" onclick="edit_reg()"><i class="fa-solid fa-pen-to-square fa-lg pe-2"></i>Editar Hoja de Vida</button>
                    <button type="button" id="bto_r_c" class="btn btn-sm btn-secondary d-none" onclick="registro(0)"><i class="fa-solid fa-arrow-left fa-lg pe-2"></i>Volver</button>
                    <button type="button" id="bto_g" class="btn btn-sm btn-success d-none" onclick="validateForm()"><i class="fas fa-save fa-lg pe-2"></i>Guardar</button>
                </div>   
            </div>
        </div>     
        @csrf
        <small>
            <div id="preload" class="align-items-center justify-content-center text-center">
                <div class="d-flex justify-content-center align-items-center" style="height: 50vh;" id="div_spinner">
                    <div class="spinner-border text-primary me-2" role="status"></div>
                    <span class="small">Cargando...</span>
                </div>
            </div>
        </small>

        <div id="iframe" style="display: none;">              
            <div id="l_registros">
                <div class="card shadow">
                    <div class="card-header h6 text-uppercase fw-bold" style="color: #4B6EAD;">               
                        <i class="fas fa-th-list pe-2 text-primary"></i> Registro de Hojas de Vida
                    </div>
                    <div class="card-body">
                        <table id="MyTable" class="table table-hover" style="width:100%">                                    
                            <thead>
                                <tr class="bg-light">
                                    <th>NOMBRE</th>
                                    <th>RESIDENCIA</th>
                                    <th>PROFESIÓN</th>
                                    <th>PROCESOS ASOCIADOS</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_registros">
                                @foreach( $data_listado as $data )
                                @php
                                    $nombre = $data->prinombre ?? '';
                                    $apellido = $data->priapellido ?? '';
                                    $iniciales = strtoupper(mb_substr($nombre, 0, 1) . mb_substr($apellido, 0, 1));
                                @endphp         
                                    <tr id="row_{{ $data->id }}" class="oflinfo" onclick="registro({{ $data->id }})">
                                        <td class="align-middle">   
                                            <div class="d-flex align-items-center">
                                                <div class="me-2">
                                                    @if ($data->foto)
                                                        <img src="{{ asset($data->foto) }}" alt="Foto de {{ $nombre }} {{ $apellido }}"
                                                            class="rounded-circle"
                                                            style="background:#FFFFFF; width: 60px; height: 60px; object-fit: cover; border: 1px solid #aeafb0;">
                                                    @else
                                                        <span class="rounded-circle d-flex align-items-center justify-content-center"
                                                            style="width: 60px; height: 60px; background-color: {{ $data->color_bg }}; border-radius: 50%; color: {{ $data->color_text }};
                                                                    font-family: 'Segoe UI', 'Roboto', sans-serif; font-size: 30px; text-transform: uppercase; border: 1px solid {{ $data->color_text }}">
                                                            {{ $iniciales }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-uppercase" style="color: #4B6EAD;font-size: 13px">{{ $data->prinombre }} {{ $data->priapellido }}</div>
                                                    <div class="text-secondary" style="font-size: 12px"><i class="fa-solid fa-envelope pe-1"></i><span class="text-primary">{{ $data->email }}</span></div>
                                                    <div class="text-secondary" style="font-size: 12px"><i class="fa-solid fa-phone-flip pe-1"></i> {{ $data->tel }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-secondary align-middle">{{ $data->prov_residencia }}</td>
                                        <td class="align-middle">
                                            <div>
                                                <div class="text-secondary">{{ $data->titulo }}</div>
                                                <div class="text-secondary">{{ $data->entidad }}</div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-secondary"style="font-size: 10px">
                                            <ul>
                                            @foreach( $data_procesos as $procesos)
                                                @if ($procesos->id_curri===$data->id)
                                                    <li>{{ $procesos->id_ofl }}-{{ $procesos->puesto }}</li>
                                                @endif
                                            @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
 
            <div class="d-none" id="new_registro">
                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-user-shield fa-lg me-2"></i> Protegemos tu privacidad. La información proporcionada se utilizará exclusivamente para fines de reclutamiento y selección.
                </div>
                    <!------ DATOS PERSONALES--->
                    <div class="card shadow">
                        <div  style=" background-color: #D4DCEB;"class="card-header text-primary h6 text-uppercase fw-semibold py-2">                 
                            <i class="fas fa-user-tag fa-lg pe-2 text-secondary "></i> Datos Personales                   
                        </div>
                        <div class="card-body">
                            <div class="px-4 mt-4">
                                <div class="row">
                                    <div class="col mb-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sel_genero" id="genero_M" value="M" checked onclick="change_img(this.value)">
                                            <label class="form-check-label" for="genero_M">Masculino</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sel_genero" id="genero_F" value="F" onclick="change_img(this.value)">
                                            <label class="form-check-label" for="genero_F">Femenino</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-3 mb-3">
                                        <label for="prinombre" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Primer nombre:</label>
                                        <input type="text" class="form-control form-control-sm" id="prinombre" name="prinombre" required>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="segnombre" class="form-label form-label-sm">Segundo nombre:</label>
                                        <input type="text" class="form-control form-control-sm" id="segnombre" name="segnombre">
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="priapellido" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Primer apellido:</label>
                                        <input type="text" class="form-control form-control-sm" id="priapellido" name="priapellido" required>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="segapellido" class="form-label form-label-sm">Segundo apellido:</label>
                                        <input type="text" class="form-control form-control-sm" id="segapellido" name="segapellido">
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="f_nacimiento" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> F. nacimiento:</label>
                                        <input type="date" class="form-control form-control-sm" id="f_nacimiento" name="f_nacimiento" max="{{ $fecha_anterior }}" required>
                                    </div>
                                    
                                    <div class="col-3 mb-3">
                                        <label for="sel_tipodoc" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Tipo de documento:</label>
                                        <select class="form-select form-select-sm" name="sel_tipodoc" id="sel_tipodoc" required>
                                            @foreach( $data_tipo_documento as $tipo_documento )
                                                <option value="{{ $tipo_documento->letra }}">{{ $tipo_documento->tipodoc}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-3 mb-3">
                                        <label for="num_docip" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> # de documento:</label>
                                        <input type="text" class="form-control form-control-sm" id="num_docip" name="num_docip" required>
                                    </div>                             
                                    <div class="col-3 mb-3">
                                        <label for="num_ss" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> # Seguro Social:</label>
                                        <input type="text" class="form-control form-control-sm" id="num_ss" name="num_ss" required>
                                    </div>
                                    
                                    <div class="col-3 mb-3">
                                        <label for="sel_estadocivil" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Estado civil:</label>
                                        <select class="form-select form-select-sm" name="sel_estadocivil" id="sel_estadocivil" required>
                                        <option  value=''>Seleccionar</option>
                                        <option value="casado">CASADO (A)</option>
                                        <option value="soltero">SOLTERO (A)</option>
                                        <option value="unido">UNIDO (A)</option>
                                        <option value="divorciado">DIVORCIADO (A)</option>
                                        <option value="separado">SEPARADO (A)</option>
                                        <option value="viudo">VIUDO (A)</option>
                                        </select>
                                    </div>
                                        
                                    <div class="col-3 mb-3">
                                        <label for="sel_nacionalidad" class="form-label form-label-sm">
                                            <i class="fas fa-asterisk text-danger fa-2xs"></i> País de nacimiento:
                                        </label>
                                        <select class="form-select form-select-sm" name="sel_nacionalidad" id="sel_nacionalidad" onchange="showpermiso(this.value)" required>
                                            @foreach($data_nacionalidades as $nacionalidades)
                                                <option value="{{ $nacionalidades->id }}" {{ $nacionalidades->id == 53 ? 'selected' : '' }}>
                                                    {{ $nacionalidades->pais }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                </div>

                                <div class="row">                                
                                    <div class="col-3 mb-3 mt-2 d-none">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="nacext[]" id="nacext_N" value="N" checked>
                                            <label class="form-check-label" for="nacext_N">Nacional</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="nacext[]" id="nacext_E" value="E">
                                            <label class="form-check-label" for="nacext_E">Extranjero </label>
                                        </div>
                                    </div>
                                    
                                    <div id="div_permiso_trab" >
                                        
                                    </div>                            
                                </div>

                                <div class="row">
                                    <div class="col-3 mb-3">
                                        <label for="sel_provincias" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Província de residencia:</label>
                                        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="sel_provincias" id="sel_provincias" onchange="buscarlugar('distrito',this.value)" required>
                                            <option selected value=''>Seleccionar</option>
                                            @foreach( $data_provincias as $provincias )
                                                <option value="{{ $provincias->id }}">{{ $provincias->provincia}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="sel_distrito" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Distrito de residencia:</label>
                                        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="sel_distrito" id="sel_distrito"  onchange="buscarlugar('corregimiento',this.value)" disabled required></select>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="sel_corregimiento" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Corregimiento de residencia:</label>
                                        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="sel_corregimiento" id="sel_corregimiento" disabled required></select>
                                    </div>
                                    <div class="col-sm-3 mb-3">
                                        <label for="direc" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Dirección específica:</label>
                                        <input type="text" class="form-control form-control-sm" aria-label=".form-select-sm example" id="direc" name="direc" required>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="telefono" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Teléfono:</label>
                                        <input type="tel" class="form-control form-control-sm" id="telefono" name="telefono" required>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="mail" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Correo electrónico:</label>
                                        <input type="email" class="form-control form-control-sm" id="mail" name="mail" placeholder="email@ejemplo.com" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!------ SALUD Y SEGURIDAD--->
                    <div class="card shadow">
                        <div  style=" background-color: #D4DCEB;"class="card-header text-primary h6 text-uppercase fw-semibold py-2">  
                            <i class="fa-solid fa-hand-holding-medical fa-lg pe-2 text-secondary"></i> Salud y Seguridad                         
                        </div>
                        <div class="card-body">
                            <div class="px-4 mt-4">
                                <div class="row">
                                    <div class="col-3 mb-3">
                                        <label for="sel_sangre" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs pe-1"></i>Tipo de Sangre</label>
                                        <select class="form-select form-select-sm" id="sel_sangre" name="sel_sangre">
                                        <option value="O+">O +</option>
                                        <option value="O-">O -</option>
                                        <option value="A+">A +</option>
                                        <option value="A-">A -</option>
                                        <option value="B+">B +</option>
                                        <option value="B-">B -</option>
                                        <option value="AB+">AB +</option>
                                        <option value="AB-">AB -</option>
                                        </select>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="medico_cabecera" class="form-label form-label-sm"> Médico de Cabecera:</label>
                                        <input class="form-control form-control-sm" type="text" id="medico_cabecera" name="medico_cabecera">
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="hospital" class="form-label form-label-sm"> Hospital:</label>
                                        <input class="form-control form-control-sm" type="text" id="hospital" name="hospital">
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="telhospital" class="form-label form-label-sm"> Teléfono:</label>
                                        <input class="form-control form-control-sm" type="text" id="telhospital" name="telhospital">
                                    </div>
                                </div>
                                <div class="row">                            
                                    <div class="col-3 mb-3">
                                        <label for="sel_alergico" class="form-label form-label-sm" ><i class="fas fa-asterisk text-danger fa-2xs pe-1"></i>Alérgico a medicamentos</label>
                                        <select class="form-select form-select-sm" id="sel_alergico">
                                            <option value="S">Si</option>
                                            <option value="N" selected>No</option>                                
                                        </select>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="nombre_medicamento" class="form-label form-label-sm">Nombre del medicamento:</label>
                                        <input class="form-control form-control-sm" type="text" id="nombre_medicamento" name="nombre_medicamento">
                                    </div>
                                </div>                                    
                                <div class="row">
                                    <div class="col-3 mb-3">
                                        <label for="sel_discapacidad" class="form-label form-label-sm" id="lb_docip"><i class="fas fa-asterisk text-danger fa-2xs pe-1"></i>Posee alguna discapacidad?</label>
                                        <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="sel_discapacidad" id="sel_discapacidad">
                                        <option selected value='No'>No</option>
                                            @foreach( $data_listdiscapacidad as $listdiscapacidad )
                                                <option value="{{ $listdiscapacidad->id }}">{{ $listdiscapacidad->discapacidad}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="explique_disc" class="form-label form-label-sm"> Detallar:</label>
                                        <input class="form-control form-control-sm" type="text" id="explique_disc" name="explique_disc">
                                    </div>
                                </div>
                                <div class="row">                                                        
                                    <div class="col-3 mb-3">
                                        <label for="sel_lesion" class="form-label form-label-sm" ><i class="fas fa-asterisk text-danger fa-2xs pe-1"></i>Tuvo alguna lesión laboral?</label>
                                        <select class="form-select form-select-sm" id="sel_lesion">
                                            <option value="S">Si</option>
                                            <option value="N" selected>No</option>                                
                                        </select>
                                    </div>

                                    <div class="col-3 mb-3">
                                        <label for="nombre_lesion" class="form-label form-label-sm">Especifique:</label>
                                        <input class="form-control form-control-sm" type="text" id="nombre_lesion" name="nombre_lesion">
                                    </div>
                                </div>
                                
                                <div class="row mb-3">                                                        
                                    <div class="col-3 mb-3">
                                        <label for="nombre_urgencia" class="form-label form-label-sm" ><i class="fas fa-asterisk text-danger fa-2xs pe-1"></i>Contacto en caso de urgencia</label>                                        
                                        <input class="form-control form-control-sm" type="text" id="nombre_urgencia" name="nombre_urgencia">
                                    </div>

                                    <div class="col-3 mb-3">
                                        <label for="nombre_urgencia_parentesco" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs pe-1"></i>Parentesco:</label>
                                        <input class="form-control form-control-sm" type="text" id="nombre_urgencia_parentesco" name="nombre_urgencia_parentesco">
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="nombre_urgencia_parentesco" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs pe-1"></i>Teléfono:</label>
                                        <input class="form-control form-control-sm" type="text" id="nombre_urgencia_telefono" name="nombre_urgencia_telefono">
                                    </div>
                                </div>      
                            </div>
                        </div>
                    </div>
                                        
                    <!------ EDUCACIÓN Y FORMACIÓN--->
                    <div class="card shadow">
                        <div  style=" background-color: #D4DCEB;"class="card-header text-primary h6 text-uppercase fw-semibold py-2"> 
                            <i class="fa-solid fa-user-graduate fa-lg pe-2 text-secondary"></i> Educación y Formación                         
                        </div>
                        <div class="card-body">
                            <input type="hidden" value="0" id="num_educ">
                            <div class="mt-4" id="educ_form">
                                 
                            </div>                        
                            <div class="row px-4 pt-2">
                                <div class="col d-flex d-grid gap-2 align-items-center justify-content-end">
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="add_educ();renumerar_educacion();"><i class="fa-solid fa-plus pe-2"></i>Agregar Nueva Educación</button>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    
                    <!------ CURSOS / SEMINARIOS------>    
                    <div class="card shadow">
                        <div  style=" background-color: #D4DCEB;"class="card-header text-primary h6 text-uppercase fw-semibold py-2">    
                            <i class="fa-solid fa-chalkboard-user fa-lg pe-2 text-secondary"></i> Cursos / Seminarios                      
                        </div>
                        <div class="card-body">
                           
                            <div class="row mt-4">
                                <div class="col-auto mb-2">
                                    ¿Desea registrar algún curso o seminario realizado?
                                </div>
                                <div class="col-6 ms-2 mb-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" role="button" type="radio" name="opt_cursos_" id="cursos_n" value="NO" onchange="showcursos()" checked>
                                        <label class="form-check-label" role="button" for="cursos_n">NO</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" role="button" type="radio" name="opt_cursos_" id="cursos_s" value="SI"  onchange="showcursos()">
                                        <label class="form-check-label" role="button" for="cursos_s">SI</label>
                                    </div>
                                </div>
                            </div>

                            <div id="div_cursos" class="d-none">
                                <input type="hidden" value="0" id="num_cursos">
                                <div class="mt-4" id="cursos_seminarios">
                                </div>                        

                                <div class="row px-4 pt-2">
                                    <div class="col d-flex d-grid gap-2 align-items-center justify-content-end">
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="add_cursos();renumerar_cursos();"><i class="fa-solid fa-plus pe-2"></i>Agregar Curso / Seminario</button>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>

                    <!------ CONOCIMIENTOS ADICONALES------>    
                    <div class="card shadow">
                        <div  style=" background-color: #D4DCEB;"class="card-header text-primary h6 text-uppercase fw-semibold py-2">    
                            <i class="fa-solid fa-lightbulb fa-lg pe-2 text-secondary"></i> Conocimientos Adicionales                      
                        </div>
                        <div class="card-body">
                            <div class="px-4 mt-4">
                                <div class="row">
                                    <div class="col-3 mb-3">
                                        <label for="sel_espanol" class="form-label form-label-sm">Idioma Español</label>
                                        <select class="form-select form-select-sm" id="sel_espanol">
                                            <option value="Nada">Nada</option>
                                            <option value="Poco">Poco</option>
                                            <option value="Intermedio">Intermedio</option>
                                            <option value="Avanzado">Avanzado</option>
                                        </select>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="sel_ingles" class="form-label form-label-sm">Idioma Inglés:</label>
                                        <select class="form-select form-select-sm" id="sel_ingles">
                                            <option value="Nada">Nada</option>
                                            <option value="Poco">Poco</option>
                                            <option value="Intermedio">Intermedio</option>
                                            <option value="Avanzado">Avanzado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3 mb-3">
                                        <label for="sel_computadora" class="form-label form-label-sm">Dominio de Computadora:</label>
                                        <select class="form-select form-select-sm" id="sel_computadora">
                                            <option value="Nada">Nada</option>
                                            <option value="Poco">Poco</option>
                                            <option value="Intermedio">Intermedio</option>
                                            <option value="Avanzado">Avanzado</option>
                                        </select>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="sel_word" class="form-label form-label-sm">Manejo de Word</label>
                                        <select class="form-select form-select-sm" id="sel_word">
                                            <option value="Nada">Nada</option>
                                            <option value="Poco">Poco</option>
                                            <option value="Intermedio">Intermedio</option>
                                            <option value="Avanzado">Avanzado</option>
                                        </select>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="sel_excel" class="form-label form-label-sm">Manejo de Excel</label>
                                        <select class="form-select form-select-sm" id="sel_excel">
                                            <option value="Nada">Nada</option>
                                            <option value="Poco">Poco</option>
                                            <option value="Intermedio">Intermedio</option>
                                            <option value="Avanzado">Avanzado</option>
                                        </select>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label for="sel_ppt" class="form-label form-label-sm">Manejo de Power Point</label>
                                        <select class="form-select form-select-sm" id="sel_ppt">
                                            <option value="Nada">Nada</option>
                                            <option value="Poco">Poco</option>
                                            <option value="Intermedio">Intermedio</option>
                                            <option value="Avanzado">Avanzado</option>
                                        </select>
                                    </div>
                                    <div class="col-9 mb-3">
                                        <input type="text" class="form-control form-control-sm" name="otro_conocimiento" placeholder="Detalle otros conocimientos">
                                    </div>
                                </div>
                                
                                <div class="row mt-3">
                                    <b class="text-secondary"> Tipos de vehículos que sabe manejar:</b>                                                               
                                    <div class="mb-3 row">
                                        <div class="col-2">
                                            <input type="checkbox" id="chk_sedan">
                                            <label for="chk_sedan" class="col-sm col-form-label"> Sedan / Pickup</label>
                                        </div>
                                        <div class="col-2">
                                            <input type="checkbox" id="chk_camion">
                                            <label for="chk_camion" class="col-sm col-form-label"> Camión</label>
                                        </div>
                                        <div class="col-2">
                                            <input type="checkbox" id="chk_trailer">
                                            <label for="chk_trailer" class="col-sm col-form-label"> Trailer</label>
                                        </div>
                                        <div class="col-2">
                                            <input type="checkbox" id="chk_moto">
                                            <label for="chk_moto" class="col-sm col-form-label"> Moto</label>
                                        </div>
                                        <div class="col-2">
                                            <input type="checkbox" id="chk_montacargas">
                                            <label for="chk_montacargas" class="col-sm col-form-label"> Monta Cargas</label>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>                            
                                                            
                    <!------ REFERENCIAS PERSONALES--->
                    <div class="card shadow">
                        <div  style=" background-color: #D4DCEB;"class="card-header text-primary h6 text-uppercase fw-semibold py-2">      
                            <i class="fa-solid fa-people-arrows fa-lg pe-2 text-secondary"></i> Referencias Personales                         
                        </div>
                        <div class="card-body">
                            
                            <div class="row px-4 p-2">  
                                <div class="alert alert-warning  py-1 my-2" role="alert">
                                    <small><i class="fas fa-asterisk pe-2"></i>NO incluir parientes</small>
                                </div>
                            </div>
                            <div class="row ps-2">
                                <div class="col-3 mb-3">
                                    <input type="text" class="form-control form-control-sm" id="nombre_ref_personal_1" name="nombre_ref_personal_1" placeholder="Referencia Personal #1" required>
                                </div>
                                <div class="col-4 mb-3">
                                    <input type="text" class="form-control form-control-sm" id="dir_ref_personal_1" name="dir_ref_personal_1" placeholder="Dirección" required>
                                </div>
                                <div class="col-3 mb-3">
                                    <input type="text" class="form-control form-control-sm" id="tel_ref_personal_1" name="tel_ref_personal_1" placeholder="Teléfono" required>
                                </div>
                            </div>                            
                            <div class="row ps-2">
                                <div class="col-3 mb-3">
                                    <input type="text" class="form-control form-control-sm" id="nombre_ref_personal_2" name="nombre_ref_personal_2" placeholder="Referencia Personal #2" required>
                                </div>
                                <div class="col-4 mb-3">
                                    <input type="text" class="form-control form-control-sm" id="dir_ref_personal_2" name="dir_ref_personal_2" placeholder="Dirección" required>
                                </div>
                                <div class="col-3 mb-3">
                                    <input type="text" class="form-control form-control-sm" id="tel_ref_personal_2" name="tel_ref_personal_2" placeholder="Teléfono" required>
                                </div>
                            </div>                            
                            <div class="row ps-2">
                                <div class="col-3 mb-3">
                                    <input type="text" class="form-control form-control-sm" id="nombre_ref_personal_3" name="nombre_ref_personal_3" placeholder="Referencia Personal #3" required>
                                </div>
                                <div class="col-4 mb-3">
                                    <input type="text" class="form-control form-control-sm" id="dir_ref_personal_3" name="dir_ref_personal_3" placeholder="Dirección" required>
                                </div>
                                <div class="col-3 mb-3">
                                    <input type="text" class="form-control form-control-sm" id="tel_ref_personal_3" name="tel_ref_personal_3" placeholder="Teléfono" required>
                                </div>
                            </div>                            
                        </div>
                    </div>

                    <!------ EXPERIENCIA LABORAL--->
                    <div class="card shadow">
                        <div  style=" background-color: #D4DCEB;"class="card-header text-primary h6 text-uppercase fw-semibold py-2">   
                            <i class="fa-solid fa-user-check fa-lg pe-2 text-secondary"></i> Experiencia laboral                         
                        </div>
                        <div class="card-body">
                            
                            <div class="row mt-4">
                                <div class="col-auto mb-3">
                                    ¿Ha tenido alguna experiencia laboral?
                                </div>
                                <div class="col-6 ms-2 mb-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" role="button" type="radio" name="opt_experiencia_" id="experiencia_n" value="NO" onchange="showexperiencia()" checked>
                                        <label class="form-check-label" role="button" for="experiencia_n">NO</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" role="button" type="radio" name="opt_experiencia_" id="experiencia_s" value="SI"  onchange="showexperiencia()">
                                        <label class="form-check-label" role="button" for="experiencia_s">SI</label>
                                    </div>
                                </div>
                            </div>

                            <div id="div_experiencia" class="d-none">
                                <div class="row px-4 p-2">  
                                    <div class="alert alert-warning  py-1 my-2" role="alert">
                                        <small><i class="fas fa-asterisk pe-2"></i>Por favor indique su experiencia laboral de los últimos 5 años. Inicie con el trabajo más reciente</small>
                                    </div>
                                </div>
                                <input type="hidden" value="0" id="num_ref_labs">
                                <div id="ref_labs">
                                </div>                            
                                <div class="row px-4 pt-2">
                                    <div class="col d-flex d-grid gap-2 align-items-center justify-content-end">
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="add_ref();renumerar_experiencias();"><i class="fa-solid fa-plus pe-2"></i>Agregar Experiencia Laboral</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!------ FAMILIARES EN AL COMPAÑIA------>    
                    <div class="card shadow">
                        <div  style=" background-color: #D4DCEB;"class="card-header text-primary h6 text-uppercase fw-semibold py-2">     
                            <i class="fa-solid fa-people-group fa-lg pe-2 text-secondary"></i> Familiares en la empresa                      
                        </div>
                        <div class="card-body">
                            <div class="row mt-4">
                                <div class="col-auto mb-3">
                                    ¿Tiene familiares trabajando actualmente en alguna de nuestras unidades económicas?
                                </div>
                                <div class="col-4 ms-2 mb-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" role="button" type="radio" name="opt_familia_" id="opt_familia_n" value="NO" checked onchange="showfamily()">
                                        <label class="form-check-label" role="button" for="opt_familia_n">NO</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" role="button" type="radio" name="opt_familia_" id="opt_familia_s" value="SI"  onchange="showfamily()">
                                        <label class="form-check-label" role="button" for="opt_familia_s">SI</label>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="0" id="num_familiar">
                            <div id="div_familiares" class="d-none">
                                <div class="mt-4" id="familiares">
                                </div>                        

                                <div class="row px-4 pt-2">
                                    <div class="col d-flex d-grid gap-2 align-items-center justify-content-end">
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="add_familiar();renumerar_familiar();"><i class="fa-solid fa-plus pe-2"></i>Agregar Familiar</button>
                                    </div>
                                </div>  
                            </div>  
                        </div>
                    </div>                    
                    
                    <!------ DEPENDIENTES----->    
                    <div class="card shadow">
                        <div  style=" background-color: #D4DCEB;"class="card-header text-primary h6 text-uppercase fw-semibold py-2"> 
                            <i class="fa-solid fa-people-roof fa-lg pe-2 text-secondary"></i> Dependientes                      
                        </div>
                        <div class="card-body">

                            <div class="row mt-4">
                                <div class="col-auto mb-3">
                                    ¿Tiene familiares que dependan de usted?
                                </div>
                                <div class="col-6 ms-2 mb-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" role="button" type="radio" name="opt_depentiene_" id="opt_depend_n" value="NO" checked onchange="showfamilydepends()">
                                        <label class="form-check-label" role="button" for="opt_depend_n">NO</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" role="button" type="radio" name="opt_depentiene_" id="opt_depend_s" value="SI"  onchange="showfamilydepends()">
                                        <label class="form-check-label" role="button" for="opt_depend_s">SI</label>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="0" id="num_familiar_dependiente">
                            <div id="div_familiares_dependientes" class="d-none">
                                <div class="mt-4" id="familiares_dependientes">
                                </div>                        

                                <div class="row px-4 pt-2">
                                    <div class="col d-flex d-grid gap-2 align-items-center justify-content-end">
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="add_dependientes();renumerar_dependientes();"><i class="fa-solid fa-plus pe-2"></i>Agregar Dependiente</button>
                                    </div>
                                </div>  
                            </div>  
                        </div>
                    </div>
                    
                    <!------ HOJA DE VIDA------>
                    <div class="card shadow">
                        <div  style=" background-color: #D4DCEB;"class="card-header text-primary h6 text-uppercase fw-semibold py-2"> 
                            <i class="fa-solid fa-file-arrow-up fa-lg pe-2 text-secondary"></i>Hoja de Vida                       
                        </div>
                        <div class="card-body">
                            <div class="px-4 mt-4">
                                <div class="row">
                                    <div class="col-6 mb-3 mt-4">
                                        <label for="filecv" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i>  Adjuntar hoja de vida:</label>
                                        <input class="form-control form-control-sm file" name="filecv" id="filecv" type="file" accept=".doc,.pdf,image/*" required>
                                    </div>                                                                  
                                    <div class="col-6 text-center">
                                        <span class="align-items-center justify-content-center text-center" style="cursor: pointer;" onclick="document.getElementById('insert_image_bd').click()" id="space_photo">
                                            <img src="storage/profiles/photo/el.png" class="rounded" alt="Foto" style="width: 150px; height: 150px; object-fit: cover; border: 2px solid #aeafb0;"id="img_photo" title="Cambiar foto">
                                        </span>
                                        <input  name="insert_image_bd" id="insert_image_bd" accept="image/*"  style="display: none;" type="file">
                                        <input type="hidden" id="foto_temp_path" name="foto_temp_path" value="">
                                        <div class="mb-0 pt-1">Adjuntar foto</div>                                     
                                    </div>                        
                                </div> 
                            </div> 
                        </div>
                    </div>

                    <!------ AUTORIZACIÓN------>
                    <div class="card shadow">
                        <div  style=" background-color: #D4DCEB;"class="card-header text-primary h6 text-uppercase fw-semibold py-2"> 
                            <i class="fa-solid fa-signature fa-lg pe-2 text-secondary"></i>Autorización y Declaración                       
                        </div>
                        <div class="card-body">
                            <div class="px-4 mt-4">                                                                 
                                <div class="mb-3 row">
                                    <div class="col-sm-auto form-check">
                                      <input class="form-check-input" type="checkbox" id="chk_viajar" name="chk_viajar">
                                      <label class="form-check-label" for="chk_viajar">
                                        ¿Tiene disponibilidad para viajar en caso de que el trabajo lo requiera?
                                      </label>
                                    </div>
                                  </div>
                                  
                                  <div class="mb-3 row">
                                    <div class="col-sm-auto form-check">
                                      <input class="form-check-input" type="checkbox" id="chk_psico" name="chk_psico">
                                      <label class="form-check-label" for="chk_psico">
                                        ¿Está usted dispuesto a someterse a un examen psicométrico?
                                      </label>
                                    </div>
                                  </div>
                                  
                                  <div class="mb-3 row">
                                    <div class="col-sm-auto form-check">
                                      <input class="form-check-input" type="checkbox" id="chk_verificar_info" name="chk_verificar_info" required>
                                      <label class="form-check-label" for="chk_verificar_info">
                                       <i class="fas fa-asterisk text-danger fa-2xs"></i>  Autorizo la verificación de la información proporcionada en este formulario.
                                      </label>
                                    </div>
                                  </div>
                                  
                                  <div class="mb-3 row">
                                    <div class="col-sm-auto form-check">
                                      <input class="form-check-input" type="checkbox" id="chk_afirmacion" name="chk_afirmacion" required>
                                      <label class="form-check-label" for="chk_afirmacion">
                                       <i class="fas fa-asterisk text-danger fa-2xs"></i>  Declaro que toda la información proporcionada es verdadera y completa.
                                      </label>
                                    </div>
                                  </div>
                            </div> 
                        </div>
                    </div>
            </div>

            <div class="d-none px-4" id="registro">               
                <div class="row">
                    <div class="col-auto ms-4" id="div_foto_reg">
                        <img src="{{ asset('storage/profiles/photo/el.png')}}" class="rounded-circle" alt="Foto" style="width: 125px; height: 125px; object-fit: cover; border: 2px solid #aeafb0;" title="Cambiar foto">
                    </div>
                    <div class="col d-flex align-items-center ps-2" >                        
                        <div>
                            <div class="fw-bold text-uppercase" id="nom_reg" style="color: #4B6EAD;"></div>
                            <div class="text-secondary small"><i class="fa-solid fa-envelope pe-2"></i><span id="mail_reg" class="text-primary"></span></div>
                            <div class="text-secondary small"><i class="fa-solid fa-phone-flip pe-2"></i><span id="tel_reg" class="text-primary"></span></div>
                            <div class="text-secondary small"><i class="fa-solid fa-location-dot pe-2"></i><span id="res_reg" class="text-primary"></span></div>
                        </div>
                    </div>                    
                </div>
                <div class="row pt-4 small">                
                    <div class="col-12">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs">
                              <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab1">Descripción General</button>
                              </li>
                              <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab2">Curriculum</button>
                              </li>
                              <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab3">Pruebas Psicométricas</button>
                              </li>
                            </ul>
                            <div class="tab-content pt-2 bg-white shadow">            
                                <!-- INFORMACIÓN PERSONAL -->
                                <div class="tab-pane fade show active p-4" id="tab1">                                  
                                    <div class="card mt-4" style=" box-shadow: none;border: 1px solid #e2e2e2;">
                                        <!-- Datos Personales -->
                                        <div class="card-header h6 text-uppercase fw-semibold py-2 text-primary" style="background-color: #D4DCEB;  border-radius: 4px 4px 0px 0px;">
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
                                                <strong class="text-secondary"><i class="fa-solid fa-phone-flip fa-lg pe-1 text-success"></i>Teléfono:</strong><br>
                                                <span id="lb_tel" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-4">
                                                <strong class="text-secondary"><i class="fa-solid fa-envelope fa-lg pe-1 text-primary"></i>Correo:</strong><br>
                                                <span id="lb_email" class="text-muted"></span>
                                            </div>
                                            <div class="col-md-8">
                                                <strong class="text-secondary"><i class="fa-solid fa-location-dot fa-lg pe-1 text-danger"></i>Dirección:</strong><br>
                                                <span id="lb_dir" class="text-muted"></span>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 small card mt-4" style=" box-shadow: none;border: 1px solid #e2e2e2;">
                                        <!-- Salud y Seguridad -->
                                        <div class="card-header h6 text-uppercase fw-semibold py-2 text-primary" style="background-color: #D4DCEB;  border-radius: 4px 4px 0px 0px;">
                                            <i class="fa-solid fa-hand-holding-medical fa-lg ps-2 pe-2 text-secondary"></i>Salud y Seguridad
                                        </div>
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
                                                <strong class="text-secondary"><i class="fa-solid fa-phone-flip fa-lg pe-1 text-success"></i>Teléfono:</strong><br>
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
                                                <strong class="text-secondary"><i class="fa-solid fa-phone-flip fa-lg pe-1 text-success"></i>Teléfono:</strong><br>
                                                <span id="lb_tel_urgencia" class="text-muted"></span>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 small card mt-4" style=" box-shadow: none;border: 1px solid #e2e2e2;">
                                        <!-- Educación y Formación -->
                                        <div class="card-header h6 text-uppercase fw-semibold py-2 text-primary" style="background-color: #D4DCEB;  border-radius: 4px 4px 0px 0px;">
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
                                    <div class="mt-4 small card mt-4" style=" box-shadow: none;border: 1px solid #e2e2e2;">
                                        <!-- Educación y Formación -->
                                        <div class="card-header h6 text-uppercase fw-semibold py-2 text-primary" style="background-color: #D4DCEB;  border-radius: 4px 4px 0px 0px;">
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
                                    <div class="mt-4 small card mt-4" style=" box-shadow: none;border: 1px solid #e2e2e2;">
                                        <!-- Educación y Formación -->
                                        <div class="card-header h6 text-uppercase fw-semibold py-2 text-primary" style="background-color: #D4DCEB;  border-radius: 4px 4px 0px 0px;">
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
                                                    <strong class="text-secondary"><i class="fa-solid fa-laptop fa-lg pe-1 text-info"></i>Dominio de computadora:</strong><br>
                                                    <span id="lb_pc" class="text-muted"></span>
                                                </div>
                                                <div class="col-md-3">
                                                    <strong class="text-secondary"><i class="fa-solid fa-file-word fa-lg pe-1 text-primary"></i>Manejo de Word:</strong><br>
                                                    <span id="lb_word" class="text-muted"></span>
                                                </div>
                                                <div class="col-md-3">
                                                    <strong class="text-secondary"><i class="fa-solid fa-file-excel fa-lg pe-1 text-success"></i>Manejo de Excel:</strong><br>
                                                    <span id="lb_excel" class="text-muted"></span>
                                                </div>
                                                <div class="col-md-3">
                                                    <strong class="text-secondary"><i class="fa-solid fa-file-powerpoint fa-lg pe-1 text-danger"></i>Manejo de Power Point:</strong><br>
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
                                                        <strong class="text-secondary"><i class="fa-solid fa-car-side fa-lg pe-1 text-primary"></i>Sedan/Pickup:</strong><br>
                                                        <span id="lb_sedan" class="text-muted"></span>
                                                    </div>
                                                    <div class="col-2">
                                                        <strong class="text-secondary"><i class="fa-solid fa-truck fa-lg pe-1 text-primary"></i>Camión:</strong><br>
                                                        <span id="lb_camion" class="text-muted"></span>
                                                    </div>
                                                    <div class="col-2">
                                                        <strong class="text-secondary"><i class="fa-solid fa-truck-moving fa-lg pe-1 text-primary"></i>Trailer:</strong><br>
                                                        <span id="lb_trailer" class="text-muted"></span>
                                                    </div>
                                                    <div class="col-2">
                                                        <strong class="text-secondary"><i class="fa-solid fa-motorcycle fa-lg pe-1 text-primary"></i>Moto:</strong><br>
                                                        <span id="lb_moto" class="text-muted"></span>
                                                    </div>
                                                    <div class="col-2">
                                                        <strong class="text-secondary"><i class="fa-solid fa-truck-ramp-box fa-lg pe-1 text-primary"></i>Monta Cargas:</strong><br>
                                                        <span id="lb_montacargas" class="text-muted"></span>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="mt-4 small card mt-4" style=" box-shadow: none;border: 1px solid #e2e2e2;">
                                        <!-- Referencias Personales -->
                                        <div class="card-header h6 text-uppercase fw-semibold py-2 text-primary" style="background-color: #D4DCEB;  border-radius: 4px 4px 0px 0px;">
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
                                    <div class="mt-4 small card mt-4" style=" box-shadow: none;border: 1px solid #e2e2e2;">
                                        <!-- Experiencia Laboral -->
                                        <div class="card-header h6 text-uppercase fw-semibold py-2 text-primary" style="background-color: #D4DCEB;  border-radius: 4px 4px 0px 0px;">
                                            <i class="fa-solid fa-user-check fa-lg ps-2 pe-2 text-secondary"></i>Experiencia Laboral
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="row g-3 ms-2 mb-3">
                                                <div class="col-md-12" id="lis_exp_lab">     
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 small card mt-4" style=" box-shadow: none;border: 1px solid #e2e2e2;">                           
                                        <!-- Familiares en la Compañia -->
                                        <div class="card-header h6 text-uppercase fw-semibold py-2 text-primary" style="background-color: #D4DCEB;  border-radius: 4px 4px 0px 0px;">
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
                                    <div class="mt-4 small card mt-4" style=" box-shadow: none;border: 1px solid #e2e2e2;">
                                        <!-- Dependientes -->
                                        <div class="card-header h6 text-uppercase fw-semibold py-2 text-primary" style="background-color: #D4DCEB;  border-radius: 4px 4px 0px 0px;">
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
                                    <div class="mt-4 small card mt-4" style=" box-shadow: none;border: 1px solid #e2e2e2;">
                                        <!-- Autorización y Declaración -->
                                        <div class="card-header h6 text-uppercase fw-semibold py-2 text-primary" style="background-color: #D4DCEB;  border-radius: 4px 4px 0px 0px;">
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

    
                                <!-- HOJA DE VIDA PDF -->
                                <div class="tab-pane fade" id="tab2">                                
                                    <div id="cv_pdf" class="w-100 p-4" style="height:80vh;">   
                                            
                                    </div>
                                </div>

                                <!-- PRUEBAS PSICOMÉTRICAS -->
                                <div class="tab-pane fade p-4" id="tab3">      
                                    <div class="col-12 mt-0 py-0 mb-2  d-flex d-grid gap-2 align-items-center justify-content-end">
                                        <input type="hidden" id="id_curri" name="id_curri" value="">
                                        <button type="button" class="btn btn-sm btn-success" onclick="savepruebaspsico()"><i class="fas fa-save fa-lg pe-2"></i>Guardar</button>
                                    </div> 
                                    <!-- DISC -->
                                    <div class="card mt-4" style=" box-shadow: none;border: 1px solid #e2e2e2;">
                                        <div class="card-header h6 text-uppercase fw-semibold py-2 text-primary" style="background-color: #D4DCEB;  border-radius: 4px 4px 0px 0px;">
                                            DISC
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="row">
                                                <div class="col-2 mb-3">
                                                    <span class="text-secondary" for="fecha_disc">Fecha de la prueba</span><br>
                                                    <input type="hidden" id="id_disc" name="id_disc" value="">
                                                    <div class="input-group col-2">
                                                        <input type="date" class="form-control form-control-sm" id="fecha_disc" name="fecha_disc" placeholder="Fecha de la prueba" aria-label="Fecha de la prueba">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3" id="div_archivo_disc">
                                                    <span class="text-secondary">Adjuntar Informe DISC</span>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control form-control-sm" id="archivo_disc" name="pdf_file" accept="application/pdf" aria-label="Archivo Psicométrico" onchange="procesarPDF('DISC')">
                                                        <span class="input-group-text"><i class="fa-solid fa-file-pdf text-secondary"></i></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 d-flex align-items-end mb-4 d-none" id="div_download_archivo_disc">
                                                </div>
                                                 
                                                <div class="col-2 text-end ms-auto d-none" id="bto_delete_archivo_disc">
                                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="dell_file('DISC');">
                                                        <i class="fa fa-trash"></i> Eliminar
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <span class="text-secondary" for="tbl_disc">Resultados</span><br>
                                                    <table class="table table-sm table-borderless m-0 p-0" id="tbl_disc">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text fw-semibold p-1" style="color: blue;">D</span>
                                                                        <input type="number" class="form-control form-control-sm  p-1" id="disc_d" name="disc_d" placeholder="0.00" min="0.01" step="0.01" aria-label="D" aria-describedby="disc_d">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text fw-semibold p-1" style="color: red">I</span>
                                                                        <input type="number" class="form-control form-control-sm p-1" id="disc_i" name="disc_i" placeholder="0.00" min="0.01" step="0.01" aria-label="I" aria-describedby="disc_i">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text fw-semibold p-1" style="color: orange">S</span>
                                                                        <input type="number" class="form-control form-control-sm p-1" id="disc_s" name="disc_s" placeholder="0.00" min="0.01" step="0.01" aria-label="S" aria-describedby="disc_s">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text fw-semibold p-1" style="color: green">C</span>
                                                                        <input type="number" class="form-control form-control-sm p-1" id="disc_c" name="disc_c" placeholder="0.00" min="0.01" step="0.01" aria-label="C" aria-describedby="disc_c">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>   
                                                </div>
                                                <div class="col-md-6">
                                                    <textarea class="form-control form-control-sm" id="obs_disc" name="obs_disc" rows="3" placeholder="Agregar comentarios..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                                                    
                                    <!-- APL -->
                                    <div class="card mt-4" style=" box-shadow: none;border: 1px solid #e2e2e2;">
                                        <div class="card-header h6 text-uppercase fw-semibold py-2 text-primary" style="background-color: #D4DCEB;  border-radius: 4px 4px 0px 0px;">
                                            ANÁLISIS DEL PERFIL LABORAL - APL
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="row">
                                                <div class="col-2 mb-3">
                                                    <span class="text-secondary" for="fecha_apl">Fecha de la prueba</span><br>
                                                    <input type="hidden" id="id_apl" name="id_apl" value="">
                                                    <div class="input-group col-2">
                                                        <input type="date" class="form-control form-control-sm" id="fecha_apl" name="fecha_apl" placeholder="Fecha de la prueba" aria-label="Fecha de la prueba">
                                                    </div>
                                                </div>          

                                                <div class="col-md-6 mb-3" id="div_archivo_apl">
                                                    <label for="FileAPL" class="form-label mb-0 text-secondary" style="white-space: nowrap;">Importar Resultados APL</label>
                                                    <div class="input-group">
                                                        <input id="FileAPL" type="file" name="pdf_file" class="form-control form-control-sm" accept="application/pdf" onchange="procesarPDF('APL')">                                                        
                                                         <span class="input-group-text"><i class="fa-solid fa-file-pdf text-secondary"></i></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-2 d-flex align-items-end mb-3"  id="bto_upload_archivo_apl">
                                                    
                                                </div>

                                                <div class="col-md-6 d-flex align-items-end mb-4 d-none"  id="div_download_archivo_apl">
                                                </div>
                                                <div class="col-2 text-end ms-auto d-none" id="bto_delete_archivo_apl">
                                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="dell_file('APL');">
                                                        <i class="fa fa-trash"></i> Eliminar
                                                    </button>
                                                </div>

                                            </div>
                                            <div class="row" id="div_apl_resultados">
                                                @foreach ($competencias as $competencia)                                                                    
                                                    <div class="col-4 mb-1 d-flex align-items-center">
                                                        <input type="number" class="form-control form-control-sm px-1 py-0" 
                                                            style="width: 45px;" 
                                                            id="val_comp_{{$competencia->id}}" 
                                                            name="val_comp_{{$competencia->id}}" 
                                                            placeholder="0" 
                                                            min="0" 
                                                            aria-label="{{$competencia->nombre}}">
                                                        <label for="val_comp_{{$competencia->id}}" class="ps-1" style="font-size: 11.5px; color:{{$competencia->color}}">{{$competencia->nombre}}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-6">
                                                    <textarea class="form-control form-control-sm" id="obs_apl" name="obs_apl" rows="3" placeholder="Agregar comentarios..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <!-- RAZI -->
                                    <div class="card mt-4" style=" box-shadow: none;border: 1px solid #e2e2e2;">
                                        <div class="card-header h6 text-uppercase fw-semibold py-2 text-primary" style="background-color: #D4DCEB;  border-radius: 4px 4px 0px 0px;">
                                            RAZI
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="row">
                                                <div class="col-2 mb-3">
                                                    <span class="text-secondary" for="fecha_razi">Fecha de la prueba</span><br>
                                                    <input type="hidden" id="id_razi" name="id_razi" value="">
                                                    <div class="input-group col-2">
                                                        <input type="date" class="form-control form-control-sm" id="fecha_razi" name="fecha_razi" placeholder="Fecha de la prueba" aria-label="Fecha de la prueba">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3" id="div_archivo_razi">
                                                    <span class="text-secondary">Importar Resultados RAZI</span>
                                                    <div class="input-group">
                                                        
                                                        <input id="archivo_razi" type="file" class="form-control form-control-sm"name="archivo_razi" accept="application/pdf">
                                                        <span class="input-group-text"><i class="fa-solid fa-file-pdf text-secondary"></i></span>
                                                    </div>
                                                </div>      
                                                

                                                <div class="col-md-6 d-flex align-items-end mb-4 d-none"  id="div_download_archivo_razi">
                                                </div>
                                                <div class="col-2 text-end ms-auto d-none" id="bto_delete_archivo_razi">
                                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="dell_file('RAZI');">
                                                        <i class="fa fa-trash"></i> Eliminar
                                                    </button>
                                                </div>                                          
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <table class="table table-sm table-borderless m-0 p-0" id="tbl_disc">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text p-1">Verb.</span>
                                                                        <input type="number" class="form-control form-control-sm p-1" id="razi_v" name="razi_v" placeholder="0" min="0" aria-label="V" aria-describedby="razi_v">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text p-1">Num.</span>
                                                                        <input type="number" class="form-control form-control-sm p-1" id="razi_num" name="razi_num" placeholder="0" min="0" aria-label="N" aria-describedby="razi_n">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text p-1">Abstrac.</span>
                                                                        <input type="number" class="form-control form-control-sm p-1" id="razi_abs" name="razi_abs" placeholder="0" min="0" aria-label="A" aria-describedby="razi_a">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text p-1">General</span>
                                                                        <input type="number" class="form-control form-control-sm p-1" id="razi_gen" name="razi_gen" placeholder="0" min="0" aria-label="A" aria-describedby="razi_gen">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4" class="text-center">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text p-1">Preguntas acertadas</span>
                                                                        <input type="number" class="form-control form-control-sm p-1" style="max-width: 70px" id="razi_acertadas" name="razi_acertadas" placeholder="0" min="0" aria-label="A" aria-describedby="razi_acertadas">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>   
                                                </div>
                                                <div class="col-md-6">
                                                    <textarea class="form-control form-control-sm" id="obs_razi" name="obs_razi" rows="3" placeholder="Agregar comentarios..."></textarea>
                                                </div>                                            
                                            </div>                                            
                                        </div>
                                    </div>

                                    <!---- VERITA -->
                                    <div class="card mt-4" style=" box-shadow: none;border: 1px solid #e2e2e2;">                                        
                                        <div class="card-header h6 text-uppercase fw-semibold py-2 text-primary" style="background-color: #D4DCEB;  border-radius: 4px 4px 0px 0px;">
                                            VERITAS
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="row">
                                                <div class="col-2 mb-3">
                                                    <span class="text-secondary" for="fecha_veritas">Fecha de la prueba</span><br>
                                                    <input type="hidden" id="id_veritas" name="id_veritas" value="">
                                                        <div class="input-group col-2">
                                                            <input type="date" class="form-control form-control-sm" id="fecha_veritas" name="fecha_veritas" placeholder="Fecha de la prueba" aria-label="Fecha de la prueba">
                                                        </div>
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <span class="text-secondary" for="veritas_result">Resultado</span><br>

                                                        <select class="form-select form-select-sm" aria-label="small select example" id="veritas_result" name="veritas_result">
                                                            <option selected>Seleccione</option>
                                                            <option value="1">1- Elegible</option>
                                                            <option value="2">2- Elegible / Revisar</option>
                                                            <option value="3">3- No Elegible</option>
                                                        </select>
  
                                                </div>
                                                <div class="col-md-6">
                                                    <textarea class="form-control form-control-sm" id="obs_veritas" name="obs_veritas" rows="3" placeholder="Agregar comentarios..."></textarea>
                                                </div>
                                                
                                                <div class="col-2 text-end ms-auto d-none" id="bto_delete_archivo_veritas">
                                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="dell_file('VERITAS');">
                                                        <i class="fa fa-trash"></i> Eliminar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!---- 16 PF -->
                                    <div class="card mt-4" style=" box-shadow: none;border: 1px solid #e2e2e2;">                                        
                                        <div class="card-header h6 text-uppercase fw-semibold py-2 text-primary" style="background-color: #D4DCEB;  border-radius: 4px 4px 0px 0px;">
                                            16 PF - Personalidad
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="row">
                                                <div class="col-2 mb-3">
                                                    <span class="text-secondary" for="fecha_16pf">Fecha de la prueba</span><br>
                                                    <input type="hidden" id="id_16pf" name="id_16pf" value="">
                                                        <div class="input-group col-2">
                                                            <input type="date" class="form-control form-control-sm" id="fecha_16pf" name="fecha_16pf" placeholder="Fecha de la prueba" aria-label="Fecha de la prueba">
                                                        </div>
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <span class="text-secondary" for="16pf_result">Resultado</span><br>                                                    
                                                    <input type="text" class="form-control form-control-sm" id="16pf_result" name="16pf_result">
                                                </div>
                                                <div class="col-md-6">
                                                    <textarea class="form-control form-control-sm" id="obs_16pf" name="obs_16pf" rows="3" placeholder="Agregar comentarios..."></textarea>
                                                </div>
                                                
                                                <div class="col-2 text-end ms-auto d-none" id="bto_delete_archivo_16pf">
                                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="dell_file('16pf');">
                                                        <i class="fa fa-trash"></i> Eliminar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!---- RAVEN -->
                                    <div class="card mt-4" style=" box-shadow: none;border: 1px solid #e2e2e2;">
                                        <div class="card-header h6 text-uppercase fw-semibold py-2 text-primary" style="background-color: #D4DCEB;  border-radius: 4px 4px 0px 0px;">
                                            Raven - Inteligencia
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="row">
                                                <div class="col-2 mb-3">
                                                    <span class="text-secondary" for="fecha_raven">Fecha de la prueba</span><br>
                                                    <input type="hidden" id="id_raven" name="id_raven" value="">
                                                        <div class="input-group col-2">
                                                            <input type="date" class="form-control form-control-sm" id="fecha_raven" name="fecha_raven" placeholder="Fecha de la prueba" aria-label="Fecha de la prueba">
                                                        </div>
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <span class="text-secondary" for="raven_result">Resultado</span><br>
                                                        <select class="form-select form-select-sm" aria-label="small select example" id="raven_result" name="raven_result">
                                                            <option selected>Seleccione</option>
                                                            <option value="1">1- Muy superior</option>
                                                            <option value="2">2- Superior</option>
                                                            <option value="3">3- Superior al término medio</option>
                                                            <option value="4">4- Término medio</option>
                                                            <option value="5">5- Inferior al término medio</option>
                                                            <option value="6">6- Deficiente</option>
                                                        </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <textarea class="form-control form-control-sm" id="obs_raven" name="obs_raven" rows="3" placeholder="Agregar comentarios..."></textarea>
                                                </div>
                                                
                                                <div class="col-2 text-end ms-auto d-none" id="bto_delete_archivo_raven">
                                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="dell_file('raven');">
                                                        <i class="fa fa-trash"></i> Eliminar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>  
                            </div>
                        </div>
                    </div>                        
                </div>
            </div>
    </form> 

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
                  <div id="image_bd" style="width:350px; margin-top:10px"></div>
                </div>
              </div>
            </div>
            <div class="modal-footer py-0 bg-light">
              <button type="button" class="btn btn-sm btn-secondary corp_back" data-bs-dismiss="modal"><i class="fa-solid fa-arrow-left pr-2"></i> Cancelar</button>
              <button class="btn btn-sm btn-primary crop_image_bd"><i class="fas fa-cut"></i> Recortar y guardar</button>
            </div>
          </div>
        </div>
    </div>

    <template id="plantilla_dependientes">  
        <div class="px-4 py-2 mb-2 border border-info rounded dependientes-item">
            <div class="row">
                <small>
                    <div class="col-3 mt-0 mb-2 ms-1 fw-bold text-primary">
                        Dependiente # <span class="num_dependiente"></span>
                    </div>
                </small>
            </div>
            <div class="row">
                <div class="col-3 mb-3">
                    <input type="text" class="form-control form-control-sm" name="nombre_dependiente_" placeholder="Nombre del Dependiente" required>
                </div>
                <div class="col-3 mb-3">
                    <input type="text" class="form-control form-control-sm" name="parentesco_dependiente_" placeholder="Parentesco" required>
                </div>               
                
                <div class="col-3 mb-3">
                    <input type="date" class="form-control form-control-sm" name="fecha_nac_" placeholder="Fecha de Nacimiento" required>
                </div>

                <div class="col-3 mb-2 text-end me-0">
                    <button type="button" name="btn_del_dependiente_" class="btn btn-danger btn-sm" onclick="this.closest('.dependientes-item').remove();renumerar_dependientes();">
                        <i class="fa fa-trash"></i> Eliminar
                    </button>
                </div>
            </div>
        </div>
    </template>

    <template id="plantilla_familiar">  
        <div class="px-4 py-2 mb-2 border border-info rounded familiar-item">
            <div class="row">
                <small>
                    <div class="col-3 mt-0 mb-2 ms-1 fw-bold text-primary">
                        Familiar # <span class="num_familia"></span>
                    </div>
                </small>
            </div>
            <div class="row">
                <div class="col-3 mb-3">
                    <input type="text" class="form-control form-control-sm" name="nombre_familia_" placeholder="Nombre del Familiar" required>
                </div>
                <div class="col-3 mb-3">
                    <input type="text" class="form-control form-control-sm" name="parentesco_" placeholder="Parentesco" required>
                </div>
                <div class="col-3 mb-3">
                    <input type="text" class="form-control form-control-sm" name="nom_unidad_" placeholder="Nombre de Unidad" required>
                </div>
                <div class="col-3 mb-2 text-end me-0">
                <button type="button" name="btn_del_familiar_" class="btn btn-danger btn-sm" onclick="this.closest('.familiar-item').remove();renumerar_familiar();">
                    <i class="fa fa-trash"></i> Eliminar
                </button>
            </div>
            </div>
        </div>
    </template>

    <template id="plantilla_cursos">  
        <div class="px-4 py-2 mb-2 border border-info rounded cursos-item">
            <div class="row">
                <small>
                    <div class="col-3 mt-0 mb-2 ms-1 fw-bold text-primary">
                        Curso / Seminario # <span class="num_curso"></span>
                    </div>
                </small>
            </div>
            <div class="row">
                <div class="col-3 pe-1 mb-3">
                    <input type="text" class="form-control form-control-sm" name="entidad_curso_" placeholder="Institución">
                </div>
                <div class="col-4 pe-1 mb-3">
                    <input type="text" class="form-control form-control-sm" name="nombre_curso_" placeholder="Nombre del curso / seminario">
                </div>
                <div class="col-1 pe-1 mb-2">
                    <input type="number" class="form-control form-control-sm" name="ano_curso_" min="1950" placeholder="Año">
                </div>
                <div class="col-4 mb-2 text-end">
                <button type="button" name="btn_del_cursos_" class="btn btn-danger btn-sm" onclick="this.closest('.cursos-item').remove();renumerar_cursos();">
                    <i class="fa fa-trash"></i> Eliminar
                </button>
            </div>
            </div>
        </div>
    </template>

    <template id="plantilla_educacion">        
        <div class="px-4 py-2 mb-2 border border-info rounded educacion-item">
            
            <div class="row row-cols-2 mb-2">
                <div class="col mb-2 fw-bold text-primary">               
                    <small>Educación y Formación # <span class="num_edu"></span></small>
                </div>
                <div class="col text-end">
                    <button type="button" name="btn_del_educ_" class="btn btn-danger btn-sm" onclick="this.closest('.educacion-item').remove();renumerar_educacion();">
                        <i class="fa fa-trash"></i> Eliminar
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-3 pe-1 mb-2">
                    <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="sel_niveleduc_" required>
                        <option selected value=''>Nivel de Educación</option>
                        @foreach( $data_nivel_educ as $nivel_educ )
                            <option value="{{ $nivel_educ->id }}">{{ $nivel_educ->nivel_educ}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3 pe-1 mb-2">
                    <input type="text" class="form-control form-control-sm" name="institucion_educ_" placeholder="Institución" required>
                </div>
                <div class="col-3 pe-1 mb-2">
                    <input type="text" class="form-control form-control-sm" name="carrera_educ_" placeholder="Carrera" required>
                </div>
                <div class="col-1 pe-1 mb-2">
                    <input type="number" min="1950" class="form-control form-control-sm" name="ano_educ_" placeholder="Año" required>
                </div>
                <div class="col-2 pe-1 mb-2">
                    <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="sel_estatuseduc_" required>
                        <option selected value=''>Estatus</option>
                        @foreach( $data_estatus_educ as $estatus_educ )
                        <option value="{{ $estatus_educ->id }}">{{ $estatus_educ->estatuseduc}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>    
    </template>

    <template id="plantilla_experiencia">
        <div class="px-4 py-2 mb-2 border border-info rounded experiencia-item">
            <div class="row row-cols-2 mb-2">
                <div class="col mb-2 fw-bold text-primary">               
                    <small>Experiencia Laboral # <span class="num_exp"></span></small>
                </div>
                <div class="col text-end" >
                    <button name="btn_del_experiencia_" type="button" class="btn btn-danger btn-sm" onclick="this.closest('.experiencia-item').remove();renumerar_experiencias();">
                        <i class="fa fa-trash"></i> Eliminar
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-3 mb-2">
                    <input type="text" class="form-control form-control-sm" name="empresa_experiencia_" placeholder="Nombre de Empresa" required>
                </div>
                <div class="col-3 mb-2">
                    <input type="text" class="form-control form-control-sm" name="tel_empresa_" placeholder="Teléfono" required>
                </div>
                <div class="col-6 mb-2">
                    <input type="text" class="form-control form-control-sm" name="dir_" placeholder="Dirección">
                </div>
                <div class="col-3 mb-2">
                    <input type="text" class="form-control form-control-sm" name="pue_" placeholder="Puesto" required>
                </div>
                <div class="col-3 mb-2">
                    <input type="number" class="form-control form-control-sm" name="sal_" placeholder="Salario"  step="0.01" min="0" required>
                </div>
                <div class="col-3 mb-2">
                    <select class="form-select form-select-sm" name="sel_subarea_experiencia_" aria-label=".form-select-sm example" required>
                        <option selected value=''>Área</option>
                        @php $grupo = 0; @endphp
                        @foreach( $data_areas_sub as $areas_sub )
                            @php  
                                if($grupo != $areas_sub->id_area) {
                                    $grupo = $areas_sub->id_area;
                                    echo '<optgroup label="'.$areas_sub->area.'">';
                                }
                            @endphp
                            <option value="{{ $areas_sub->id_sub }}">{{ $areas_sub->subarea }}</option>
                        @endforeach
                        <optgroup label="Otras">
                            <option value="1000">Otra</option>
                    </select>
                </div>
                <div class="col-3 mb-2">
                    <input type="text" class="form-control form-control-sm" name="jefe_" placeholder="Jefe Inmediato"  required>
                </div>
            </div>
            <div class="row">
                <div class="col-2 mb-2">
                    <label class="form-label form-label-sm mb-0">Desde:</label>
                    <input type="date" class="form-control form-control-sm" name="desde_" required>
                </div>
                <div class="col-2 mb-2">
                    <label class="form-label form-label-sm mb-0">Hasta:</label>
                    <input type="date" class="form-control form-control-sm" name="hasta_">
                </div>
                <div class="col-8 mb-2">
                    <textarea class="form-control form-control-sm" name="motivo_" rows="2" placeholder="Motivo de Salida" required></textarea>
                </div>
            </div>
        </div>
    </template>

    <template id="plantilla_permiso">
        <div class="row mb-3">
            <div class="col-md-3 align-middle">
                <label for="sel_tipopermiso" class="form-label form-label-sm">
                    <i class="fas fa-asterisk text-danger fa-2xs"></i> Permiso de trabajo:
                </label>
                <select class="form-select form-select-sm" aria-label=".form-select-sm example" name="sel_tipopermiso" id="sel_tipopermiso" required>
                    <option selected value="">Seleccionar</option>
                    @foreach($data_tipo_permiso as $tipo_permiso)
                        <option value="{{ $tipo_permiso->id }}">
                            {{ $tipo_permiso->tipopermiso }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            
            <div class="col-md-auto mt-4 pt-2">
                <a href="info/PERMISOS DE TRABAJO AUTORIZADOS POR MITRADEL.pdf" download="PERMISOS DE TRABAJO AUTORIZADOS POR MITRADEL.pdf"><i class="far fa-file-pdf fa-2x editlink" title="Descargar documento de permisos de trabajo"></i></a>
            </div>
            <div class="col-md-3">
                <label for="f_vence_permiso" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Vencimiento del permiso:</label>
                <input type="date" class="form-control form-control-sm" id="f_vence_permiso" name="f_vence_permiso" required>
            </div>                    
            <div class="col-5">
                <label for="filepermiso" class="form-label form-label-sm"><i class="fas fa-asterisk text-danger fa-2xs"></i> Adjuntar permiso de trabajo:</label>
                <input class="form-control form-control-sm" name="filepermiso" id="filepermiso" type="file" accept=".doc,.pdf,image/*" required>
            </div>
        </div>
    </template>

<script>
    function dell_reg()
    {
        let id_curri = $('#id_curri').val();
        if (id_curri == '') {
            mal("Debe seleccionar un registro para eliminar.");
            return;
        }

        Swal.fire({
            title: '¿Está seguro de eliminar este registro?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            
            cancelButtonText:  '<i class="fas fa-arrow-left"></i> Cancelar',
            confirmButtonText: '<i class="fa-solid fa-trash-can"></i> Si, eliminar',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('bd.destroy') }}",
                    type: 'POST',
                    data: { id_curri: id_curri, _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        if (response.success) {
                            bien("Registro eliminado correctamente.");

                            $('#row_' + id_curri).remove();
                            canceladd_reg();
                            $('#id_curri').val('');
                        } else {
                            mal(response.message || "Error al eliminar el registro.");
                        }
                    },
                    error: function(xhr, status, error) {
                        let mensaje = "Error al procesar la solicitud.";

                        // Si Laravel retorna un mensaje JSON
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            mensaje += "\n" + xhr.responseJSON.message;
                        }
                        // Si Laravel devuelve errores de validación
                        else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let errores = xhr.responseJSON.errors;
                            for (let campo in errores) {
                                if (errores.hasOwnProperty(campo)) {
                                    mensaje += "\n- " + errores[campo].join("\n- ");
                                }
                            }
                        }
                        // Si Laravel devuelve HTML como error
                        else if (xhr.responseText) {
                            mensaje += "\n" + xhr.responseText;
                        }
                        // Fallback
                        else {
                            mensaje += "\n" + error;
                        }

                        mal(mensaje);
                    }
                });
            }
        });
    }

    function registro(id)
    {   if ($('#registro').hasClass('d-none'))
        {   $("#registro").removeClass('d-none');
            $("#l_registros").addClass('d-none');
            $('#bto_n').addClass('d-none');
            $("#div_nomsecreg").html('Registro #'+ id);
            $('#bto_r_c').removeClass('d-none');
            $('#bto_d').removeClass('d-none');
            $('#bto_e').removeClass('d-none');
            viewreg(id);

        }else{
            $("#registro").addClass('d-none');
            $("#l_registros").removeClass('d-none');
            $("#div_nomsecreg").html('Listado de Registros');
            $('#bto_r_c').addClass('d-none');
            $('#bto_d').addClass('d-none');
            $('#bto_e').addClass('d-none');
            $('#bto_n').removeClass('d-none');
        }
    }

    function savepruebaspsico() {
        let id_curri = $('#id_curri').val();

        let formData = new FormData();
        formData.append('id_curri', id_curri);

        // DISC
            let fecha_disc = $('#fecha_disc').val();        
            let archivo_disc = $('#archivo_disc')[0].files[0];
            let d = $('#disc_d').val();
            let i = $('#disc_i').val();
            let s = $('#disc_s').val();
            let c = $('#disc_c').val();
            let obs_disc = $('#obs_disc').val();
            
            let disc_completo = fecha_disc || archivo_disc || d || i || s || c;
            if (!$('#fecha_disc').prop('disabled')) {
                if (archivo_disc && archivo_disc.size > 10485760) { // 10 MB
                    mal("El archivo DISC no puede ser mayor a 10 MB.");
                    return;
                }

                if (disc_completo) {
                    if (!(fecha_disc && archivo_disc && d && i && s && c)) {
                        mal("Debe completar todos los campos de la prueba DISC.");
                        return;
                    }
                    formData.append('fecha_disc', fecha_disc);
                    formData.append('archivo_disc', archivo_disc);
                    formData.append('disc_d', d);
                    formData.append('disc_i', i);
                    formData.append('disc_s', s);
                    formData.append('disc_c', c);
                    formData.append('obs_disc', obs_disc);
                }
            }

        // APL
            let fecha_apl = $('#fecha_apl').val();
            let archivo_apl = $('#FileAPL')[0].files[0];
            let obs_apl = $('#obs_apl').val();
            let apl_completo = fecha_apl || archivo_apl;
            
            if (!$('#fecha_apl').prop('disabled')) 
            {   if (apl_completo) {
                    if (!(fecha_apl && archivo_apl)) {
                        mal("Debe completar todos los campos de APL.");
                        return;
                    }

                    formData.append('fecha_apl', fecha_apl);
                    formData.append('archivo_apl', archivo_apl);
                    formData.append('obs_apl', obs_apl);

                    // Recolectar competencias del APL
                    let competencias_apl = [];
                    $('#div_apl_resultados input[type=number]').each(function() {
                        let inputId = $(this).attr('id');
                        let valor = $(this).val();

                        if (valor !== '') {
                            let compId = inputId.replace('val_comp_', '');
                            competencias_apl.push({
                                competencia_id: parseInt(compId),
                                puntaje: parseInt(valor)
                            });
                        }
                    });
                    formData.append('competencias_apl', JSON.stringify(competencias_apl));
                }
            }

        // RAZI
            let fecha_razi = $('#fecha_razi').val();
            let archivo_razi = $('#archivo_razi')[0].files[0];
            let razi_v = $('#razi_v').val();
            let razi_n = $('#razi_num').val();
            let razi_a = $('#razi_abs').val();
            let razi_gen = $('#razi_gen').val();
            let razi_acertadas = $('#razi_acertadas').val();            
            let obs_razi = $('#obs_razi').val();

            let razi_completo = fecha_razi || archivo_razi || razi_v || razi_n || razi_a || razi_gen || razi_acertadas;            
            if (!$('#fecha_razi').prop('disabled')) 
            {
                if (razi_completo) {
                    if (!(fecha_razi && archivo_razi && razi_v && razi_n && razi_a && razi_gen && razi_acertadas)) {
                        mal("Debe completar todos los campos de RAZI.");
                        return;
                    }
                    formData.append('fecha_razi', fecha_razi);
                    formData.append('archivo_razi', archivo_razi);
                    formData.append('razi_v', razi_v);
                    formData.append('razi_n', razi_n);
                    formData.append('razi_a', razi_a);
                    formData.append('razi_gen', razi_gen);
                    formData.append('razi_acertadas', razi_acertadas);
                    formData.append('obs_razi', obs_razi);
                }
            }

        // VERITAS
            let fecha_veritas = $('#fecha_veritas').val();
            let veritas_result = $('#veritas_result').val();
            let obs_veritas = $('#obs_veritas').val();

            let veritas_completo = fecha_veritas || veritas_result !== "Seleccione";
            
            if (!$('#fecha_veritas').prop('disabled')) 
            {   if (veritas_completo) {
                    if (!(fecha_veritas && veritas_result !== "Seleccione")) {
                        mal("Debe completar todos los campos de VERITAS.");
                        return;
                    }
                    formData.append('fecha_veritas', fecha_veritas);
                    formData.append('veritas_result', veritas_result);
                    formData.append('obs_veritas', obs_veritas);
                }
            }
            formData.append('_token', $('input[name="_token"]').val());

        if ((razi_completo)||(veritas_completo)||(disc_completo)||(apl_completo)) {
            // Enviar formulario
            $.ajax({
                url: "{{ route('bd.savepruebas') }}",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.archivo_disc)
                    {   $('#div_archivo_disc').addClass('d-none'); 
                        $('#div_download_archivo_disc').removeClass('d-none'); 
                        $('#div_download_archivo_disc').html(`<a href="${response.archivo_disc}" download target="_blank" class="text-decoration-none"><i class="fa-solid fa-download ps-1"></i> Descargar Informe DISC</a>`);
                        $('#bto_delete_archivo_disc').removeClass('d-none');
                        $('#id_disc').val(response.id_disc);
                        $('#fecha_disc').attr('disabled', true);
                        $('#disc_d').attr('disabled', true);
                        $('#disc_i').attr('disabled', true);
                        $('#disc_s').attr('disabled', true);
                        $('#disc_c').attr('disabled', true);
                        $('#obs_disc').attr('disabled', true);
                    }

                    if(response.archivo_apl)
                    {   $('#bto_upload_archivo_apl').addClass('d-none');
                        $('#div_archivo_apl').addClass('d-none');
                        $('#div_download_archivo_apl').removeClass('d-none');
                        $('#bto_delete_archivo_apl').removeClass('d-none');
                        $('#div_download_archivo_apl').html(`<a href="${response.archivo_apl}" download target="_blank" class="text-decoration-none"><i class="fa-solid fa-download ps-1"></i> Descargar Informe DISC</a>`);
                        $('#id_apl').val(response.id_apl);
                        $('#fecha_apl').attr('disabled', true);
                        $('#obs_apl').attr('disabled', true);
                        $('#div_apl_resultados input[type="number"]').attr('disabled', true);
                    }
                    if(response.archivo_razi)
                    {   $('#div_archivo_razi').addClass('d-none');
                        $('#bto_delete_archivo_razi').removeClass('d-none');
                        $('#div_download_archivo_razi').removeClass('d-none');
                        $('#div_download_archivo_razi').html(`<a href="${response.archivo_razi}" download target="_blank" class="text-decoration-none"><i class="fa-solid fa-download ps-1"></i> Descargar Informe RAZI</a>`);
                        $('#id_razi').val(response.id_razi);
                        $('#fecha_razi').attr('disabled', true);
                        $('#razi_v').attr('disabled', true);
                        $('#razi_num').attr('disabled', true);
                        $('#razi_abs').attr('disabled', true);
                        $('#razi_gen').attr('disabled', true);
                        $('#razi_acertadas').attr('disabled', true);
                        $('#obs_razi').attr('disabled', true);
                    }
                    if(response.id_veritas)
                    {   $('#id_veritas').val(response.id_veritas);
                        $('#fecha_veritas').attr('disabled', true);
                        $('#veritas_result').attr('disabled', true);
                        $('#obs_veritas').attr('disabled', true);
                        $('#bto_delete_archivo_veritas').removeClass('d-none');
                    }
                    
                    bien('Datos guardados correctamente');
                    // Aquí podrías limpiar el formulario si lo deseas
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errores = xhr.responseJSON.errors;
                        let mensaje = 'Errores de validación:\n';
                        for (let campo in errores) {
                            mensaje += `- ${errores[campo][0]}\n`;
                        }
                        mal(mensaje);
                    } else {
                        mal('Error al guardar los datos: ' + xhr.responseText);
                    }
                }
            });
        }
    }

    function dell_file(tipo)
    {   if(tipo == 'DISC'){var id=$('#id_disc').val();}
        if(tipo=='APL'){var id=$('#id_apl').val();}
        if(tipo=='RAZI'){var id=$('#id_razi').val();}
        if(tipo=='VERITAS'){var id=$('#id_veritas').val();}

        Swal.fire({
        text: "Se procederá a eliminar el Informe "+tipo+". ¿Desea continuar? ",
        showCancelButton: true,
          cancelButtonText:  '<i class="fas fa-arrow-left"></i> Cancelar',
          confirmButtonText: '<i class="fa-solid fa-trash-can"></i> Si, eliminar',
          confirmButtonColor: "#d33",
          icon: "warning",
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) 
          { var parametros = {
            "id": id,
            "tipo": tipo,
            "_token": $('input[name="_token"]').val()};

            $.ajax({
              data:  parametros, 
              url:   "{{ route('bd.eliminarPrueba') }}",
              type:  'POST', 
              cache: false,    
              dataType: "json",      
              success:  function (data) { 
              
                if(data.error)
                {   Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.error,
                    });
                }else{
                    if(tipo=='DISC')
                    {   $('#div_archivo_disc').removeClass('d-none'); 
                        $('#div_download_archivo_disc').addClass('d-none'); 
                        $('#div_download_archivo_disc').html(``); 
                        $('#bto_delete_archivo_disc').addClass('d-none');                        
                        $('#fecha_disc').val('');
                        $('#archivo_disc').val('');
                        $('#disc_d').val('');
                        $('#disc_i').val('');
                        $('#disc_s').val('');
                        $('#disc_c').val('');
                        $('#obs_disc').val('');
                        $('#fecha_disc').attr('disabled', false);
                        $('#disc_d').attr('disabled', false);
                        $('#disc_i').attr('disabled', false);
                        $('#disc_s').attr('disabled', false);
                        $('#disc_c').attr('disabled', false);
                        $('#obs_disc').attr('disabled', false);  
                        $('#id_disc').val('');
                        
                    }else if(tipo=='APL')
                    {   
                        $('#div_archivo_apl').removeClass('d-none');
                        $('#bto_upload_archivo_apl').removeClass('d-none');
                        $('#div_download_archivo_apl').addClass('d-none');
                        $('#bto_delete_archivo_apl').addClass('d-none');
                        $('#div_download_archivo_apl').html(``);
                        $('#fecha_apl').val('');
                        $('#FileAPL').val('');
                        $('#obs_apl').val('');
                        $('#id_apl').val('');
                        $('#fecha_apl').attr('disabled', false);
                        $('#obs_apl').attr('disabled', false);
                        $('#div_apl_resultados input[type="number"]').attr('disabled', false);
                        $('#div_apl_resultados input[type="number"]').val('');

                    }else if(tipo=='RAZI')
                    {   $('#fecha_razi').val('');
                        $('#div_archivo_razi').removeClass('d-none');
                        $('#div_download_archivo_razi').removeClass('d-none');
                        $('#bto_delete_archivo_razi').addClass('d-none');
                        $('#div_download_archivo_razi').html(``);
                        $('#archivo_razi').val('');
                        $('#razi_v').val('');
                        $('#razi_num').val('');
                        $('#razi_abs').val('');
                        $('#razi_gen').val('');
                        $('#razi_acertadas').val('');
                        $('#obs_razi').val('');
                        $('#id_razi').val('');
                        $('#fecha_razi').attr('disabled', false);
                        $('#razi_v').attr('disabled', false);
                        $('#razi_num').attr('disabled', false);
                        $('#razi_abs').attr('disabled', false);
                        $('#razi_gen').attr('disabled', false);
                        $('#razi_acertadas').attr('disabled', false);
                        $('#obs_razi').attr('disabled', false);                       

                    }else if(tipo=='VERITAS')
                    {   $('#fecha_veritas').val('');
                        $('#veritas_result').val('Seleccione');
                        $('#obs_veritas').val('');
                        $('#id_veritas').val('');
                        $('#fecha_veritas').attr('disabled', false);
                        $('#veritas_result').attr('disabled', false);
                        $('#obs_veritas').attr('disabled', false);
                        $('#bto_delete_archivo_veritas').addClass('d-none');                        
                    }                    
                    bien('El informe '+tipo+' ha sido eliminado correctamente.');                

                }
                
                
              }
            });
          }
          })
    }

    function viewreg(id) {
        $('#div_permiso, #div_fpermiso, #div_dpermiso').addClass('d-none');
        var _token = $('input[name="_token"]').val();
        $('#id_curri').val(id);
        $.ajax({
            data: {
                "_token": _token,
                "id": id
            },
            url: "{{ route('bd.findreg') }}",
            type: 'POST',
            dataType: "json",
            cache: true,
            success: function (data) {
                const datos = data.datos_personales[0];
                const estudios = data.educacion;
                const cursos = data.cursos;
                const otrosconocimientos = data.otrosconocimientos[0];
                const referencia_personal = data.referencia_personal;
                const experiencia_laboral = data.experiencia_laboral;
                const familiares = data.familiares;
                const dependientes = data.dependientes;
                const competencias = data.competencias;
                const prueba_disc = data.prueba_disc;
                const prueba_apl = data.prueba_apl;
                //const prueba_resultados_apl = data.prueba_resultados_apl;
                const prueba_razi = data.prueba_razi;
                const prueba_veritas = data.prueba_veritas;
                
                const iniciales = `${datos.prinombre.charAt(0)}${datos.priapellido.charAt(0)}`.toUpperCase();
                let fotoHtml = `<img src="${datos.foto}" alt="Foto de ${datos.prinombre} ${datos.priapellido}" class="rounded-circle" style="background:#FFFFFF; width: 120px; height: 120px; object-fit: cover; border: 1px solid #aeafb0;">`;

                if (!datos.foto) {
                    fotoHtml = `
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="
                            width: 120px; height: 120px; background-color: ${datos.color_bg};  border-radius: 50%;  display: flex;  align-items: center;  justify-content: center;  color: ${datos.color_text};  font-family: 'Segoe UI', 'Roboto', sans-serif;
                            font-size: 60px;  text-transform: uppercase;  border: 1px solid ${datos.color_text}">
                            ${iniciales}
                        </div>`;
                    }

                // Datos personales
                    $('#nom_reg').html(datos.prinombre + " " + datos.priapellido);
                    $('#mail_reg').html(datos.email);
                    $('#tel_reg').html(datos.tel);
                    $('#div_foto_reg').html(`${fotoHtml}`);
                    $('#res_reg').html(datos.prov_residencia);

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
                    if(otrosconocimientos){
                    $('#lb_espanol').html(otrosconocimientos.espanol);
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
                    tbodyrp.empty();

                    if (referencia_personal.length === 0) {
                        tbodyrp.append(`
                            <tr><td colspan="3" class="text-center">No hay referencias personales registradas</td></tr>
                        `);
                    } else {
                        referencia_personal.forEach(function (e) {
                            tbodyrp.append(`
                                <tr>
                                    <td class="ps-2">${e.nombre}</td>
                                    <td class="ps-2">${e.direccion}</td>
                                    <td class="ps-2">${e.telefono}</td>
                                </tr>
                            `);
                        });
                    }

                    const lis_exp_lab = $('#lis_exp_lab');
                    lis_exp_lab.empty();
                    
                    if(experiencia_laboral.length===0)
                    { 
                        lis_exp_lab.append('<div class="text-center"> No tiene experiencia laboral.</div>');
                    }else{
                        i=0;
                        experiencia_laboral.forEach(function(e){
                            i++;
                            lis_exp_lab.append(
                            '<div class="px-4 py-2 mb-3 border border-info rounded experiencia-item">'+
                                '<div class="row row-cols-2 mb-2">'+
                                    '<div class="col fw-bold text-primary">'+               
                                        '<small>Experiencia Laboral # '+i+'</small>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="row g-2 ">'+                                                            
                                    '<div class="col-md-3">'+
                                        '<strong class="text-secondary">Empresa:</strong><br><span class="text-muted">'+e.empresa+'</span>'+
                                    '</div>'+                                                            
                                    '<div class="col-md-3">'+
                                        '<strong class="text-secondary">Teléfono:</strong><br><span class="text-muted">'+e.telefono+'</span>'+
                                    '</div>'+
                                    '<div class="col-md-6">'+
                                        '<strong class="text-secondary">Dirección:</strong><br><span class="text-muted">'+e.direccion+'</span>'+
                                    '</div>'+
                                    '<div class="col-md-3">'+
                                        '<strong class="text-secondary">Puesto:</strong><br><span class="text-muted">'+e.puesto+'</span>'+
                                    '</div>'+
                                    '<div class="col-md-3">'+
                                        '<strong class="text-secondary">Salario:</strong><br><span class="text-muted">'+e.salario+'</span>'+
                                    '</div>'+
                                    '<div class="col-md-3">'+
                                        '<strong class="text-secondary">Área:</strong><br><span class="text-muted">'+e.area+'</span>'+
                                    '</div>'+
                                    '<div class="col-md-3">'+
                                        '<strong class="text-secondary">Jefe Inmediato:</strong><br><span class="text-muted">'+e.jefe+'</span>'+
                                    '</div>'+
                                    '<div class="col-md-3">'+
                                        '<strong class="text-secondary">Desde:</strong><br><span class="text-muted">'+e.desde+'</span>'+
                                    '</div>'+
                                    '<div class="col-md-3">'+
                                        '<strong class="text-secondary">Hasta:</strong><br><span class="text-muted">'+e.hasta+'</span>'+
                                    '</div>'+
                                    '<div class="col-md-6">'+
                                        '<strong class="text-secondary">Motivo de Salida:</strong><br><span class="text-muted">'+e.motivo_salida+'</span>'+
                                    '</div>'+
                                '</div>'+
                            '</div>');
                        });
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

                // Dependientes
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

                // PDF del CV
                    if (datos.cv_doc) {
                        $('#cv_pdf').html(`<iframe src="${datos.cv_doc}" style="width:100%; height:100%; border:none;" class="w-100 h-100"></iframe>`);
                    } else {
                        $('#cv_pdf').html(`<div class="text-muted">No hay CV disponible.</div>`);
                    }
                
                // Pruebas Psicométricas
                //DISC
                    if (prueba_disc) {
                        $('#archivo_disc').val('');
                        $('#div_archivo_disc').addClass('d-none');
                        $('#div_download_archivo_disc').removeClass('d-none');
                        $('#bto_delete_archivo_disc').removeClass('d-none');
                        if (prueba_disc.fecha_realizada) {
                            if (prueba_disc.informe) {                      
                                $('#div_download_archivo_disc').html(`<a href="${prueba_disc.informe}" download target="_blank" class="text-decoration-none"><i class="fa-solid fa-download ps-1"></i> Descargar Informe DISC</a>`);
                            } else {
                                $('#div_download_archivo_disc').html(`<span class="text-muted">No hay informe disponible</span>`);
                            }
                            $('#id_disc').val(prueba_disc.id);
                            $('#fecha_disc').val(prueba_disc.fecha_realizada);
                            $('#disc_d').val(prueba_disc.puntaje_d);
                            $('#disc_i').val(prueba_disc.puntaje_i);
                            $('#disc_s').val(prueba_disc.puntaje_s);
                            $('#disc_c').val(prueba_disc.puntaje_c);
                            $('#obs_disc').val(prueba_disc.observaciones);

                            $('#fecha_disc').attr('disabled', true);
                            $('#disc_d').attr('disabled', true);
                            $('#disc_i').attr('disabled', true);
                            $('#disc_s').attr('disabled', true);
                            $('#disc_c').attr('disabled', true);
                            $('#obs_disc').attr('disabled', true);                        
                        }
                    }else{
                            $('#archivo_disc').val('');
                            $('#id_disc').val('');
                            $('#fecha_disc').val('');
                            $('#disc_d').val('');
                            $('#disc_i').val('');
                            $('#disc_s').val('');
                            $('#disc_c').val('');
                            $('#obs_disc').val('');

                            $('#fecha_disc').attr('disabled', false);
                            $('#disc_d').attr('disabled', false);
                            $('#disc_i').attr('disabled', false);
                            $('#disc_s').attr('disabled', false);
                            $('#disc_c').attr('disabled', false);
                            $('#obs_disc').attr('disabled', false); 
                            $('#div_archivo_disc').removeClass('d-none');
                            $('#div_download_archivo_disc').addClass('d-none');
                            $('#bto_delete_archivo_disc').addClass('d-none');
                    }
                // APL
                    if (prueba_apl) {
                        
                        $('#FileAPL').val('');
                        $('#div_archivo_apl').addClass('d-none');
                        $('#bto_upload_archivo_apl').addClass('d-none');
                        $('#div_download_archivo_apl').removeClass('d-none');                    
                        $('#bto_delete_archivo_apl').removeClass('d-none');
                        if (prueba_apl.fecha_realizada) {
                            $('#id_apl').val(prueba_apl.id);
                            $('#fecha_apl').val(prueba_apl.fecha_realizada);
                            $('#obs_apl').val(prueba_apl.observaciones);
                            if (prueba_apl.informe) {
                                $('#div_download_archivo_apl').html(`<a href="${prueba_apl.informe}" download target="_blank" class="text-decoration-none"><i class="fa-solid fa-download ps-1"></i> Descargar Informe APL</a>`);
                            } else {
                                $('#div_download_archivo_apl').html(`<span class="text-muted">No hay informe disponible</span>`);
                            }
                            // Rellenar competencias
                            prueba_apl.resultados.forEach(function (e) {
                                $(`#val_comp_${e.competencia_id}`).val(e.puntaje);
                            });
                            $('#fecha_apl').attr('disabled', true);
                            $('#obs_apl').attr('disabled', true);
                            $('#div_apl_resultados input[type="number"]').attr('disabled', true);
                        }
                    }else{
                        $('#FileAPL').val('');
                        $('#fecha_apl').val('');
                        $('#obs_apl').val('');
                        $('#div_apl_resultados input[type="number"]').val('');
                        $('#fecha_apl').attr('disabled', false);
                        $('#obs_apl').attr('disabled', false);
                        $('#div_apl_resultados input[type="number"]').attr('disabled', false);
                        $('#div_archivo_apl').removeClass('d-none');
                        $('#bto_upload_archivo_apl').removeClass('d-none');
                        $('#div_download_archivo_apl').addClass('d-none');                    
                        $('#bto_delete_archivo_apl').addClass('d-none');
                    }
                // RAZI
                    if (prueba_razi) {
                        $('#archivo_razi').val('');
                        $('#div_archivo_razi').addClass('d-none');
                        $('#bto_delete_archivo_razi').removeClass('d-none');
                        $('#div_download_archivo_razi').removeClass('d-none');
                        if (prueba_razi.fecha_realizada) {
                            $('#id_razi').val(prueba_razi.id);
                            $('#fecha_razi').val(prueba_razi.fecha_realizada);
                            $('#razi_v').val(prueba_razi.puntaje_v);
                            $('#razi_num').val(prueba_razi.puntaje_n);
                            $('#razi_abs').val(prueba_razi.puntaje_a);
                            $('#razi_gen').val(prueba_razi.general);
                            $('#razi_acertadas').val(prueba_razi.preg_acertadas);
                            $('#obs_razi').val(prueba_razi.observaciones);
                            if (prueba_razi.informe) {
                                $('#div_download_archivo_razi').html(`<a href="${prueba_razi.informe}" download target="_blank" class="text-decoration-none"><i class="fa-solid fa-download ps-1"></i> Descargar Informe RAZI</a>`);
                            } else {
                                $('#div_download_archivo_razi').html(`<span class="text-muted">No hay informe disponible</span>`);
                            }
                            $('#fecha_razi').attr('disabled', true);
                            $('#razi_v').attr('disabled', true);
                            $('#razi_num').attr('disabled', true);
                            $('#razi_abs').attr('disabled', true);
                            $('#razi_gen').attr('disabled', true);
                            $('#razi_acertadas').attr('disabled', true);
                            $('#obs_razi').attr('disabled', true);                        
                        }
                    }else{
                        $('#archivo_razi').val('');
                        $('#id_razi').val('');
                        $('#fecha_razi').val('');
                        $('#razi_v').val('');
                        $('#razi_num').val('');
                        $('#razi_abs').val('');
                        $('#razi_gen').val('');
                        $('#razi_acertadas').val('');
                        $('#obs_razi').val('');
                        $('#div_archivo_razi').removeClass('d-none');
                        $('#bto_delete_archivo_razi').addClass('d-none');
                        $('#div_download_archivo_razi').addClass('d-none');
                        $('#fecha_razi').attr('disabled', false);
                        $('#razi_v').attr('disabled', false);
                        $('#razi_num').attr('disabled', false);
                        $('#razi_abs').attr('disabled', false);
                        $('#razi_gen').attr('disabled', false);
                        $('#razi_acertadas').attr('disabled', false);
                        $('#obs_razi').attr('disabled', false);
                    }
                // VERITAS
                    if (prueba_veritas) {
                        $('#id_veritas').val(prueba_veritas.id);
                        $('#fecha_veritas').val(prueba_veritas.fecha_realizada);
                        $('#veritas_result').val(prueba_veritas.puntaje);
                        $('#obs_veritas').val(prueba_veritas.observaciones);
                        $('#fecha_veritas').attr('disabled', true);
                        $('#veritas_result').attr('disabled', true);
                        $('#obs_veritas').attr('disabled', true);   
                        $('#bto_delete_archivo_veritas').removeClass('d-none');                     
                    }else{
                        $('#id_veritas').val('');
                        $('#fecha_veritas').val('');
                        $('#veritas_result')[0].selectedIndex = 0;
                        $('#obs_veritas').val('');
                        $('#fecha_veritas').attr('disabled', false);
                        $('#veritas_result').attr('disabled', false);
                        $('#obs_veritas').attr('disabled', false);   
                        $('#bto_delete_archivo_veritas').addClass('d-none');    
                    }
            },
            error: function (xhr, status, error) {
                console.error("Error al cargar los datos:", error);
            }
        });
    }

    function procesarPDF(tipo_file) {
        var _token = $('input[name="_token"]').val();
        if(tipo_file=='APL')
        {    
            const input = document.getElementById('FileAPL');
            const file = input.files[0];

            if (!file) {
                mal('Por favor, selecciona un archivo PDF primero.');
                return;
            }

            const formData = new FormData();
            formData.append('pdf_file', file);
            formData.append('_token', _token); 
            formData.append('tipo_file', tipo_file); 

            $.ajax({
                url: '{{ route("bd.importarResultados") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    // Establecer la fecha (formato yyyy-mm-dd)
                    if (res.fecha) {
                        const partes = res.fecha.split('-'); // dd-mm-yyyy
                        $('#fecha_apl').val(`${partes[2]}-${partes[1]}-${partes[0]}`);
                    }

                    // Rellenar los inputs de competencias
                    res.competencias.forEach(function (e) {
                        const data = res.resultados[e.nombre];
                        if (data !== undefined) {
                            $(`#val_comp_${e.id}`).val(data.valor);
                        }
                    });

                    bien('Resultados cargados correctamente.');
                },
                error: function (err) {
                    console.error(err);
                    mal("Error al procesar el PDF. Asegúrate de que el archivo sea correcto.");
                }
            });
        }
        if(tipo_file=='DISC')
        {  
            const input = document.getElementById('archivo_disc');
            const file = input.files[0];

            if (!file) {
                mal('Por favor, selecciona un archivo PDF primero.');
                return;
            }

            const formData = new FormData();
            formData.append('pdf_file', file);
            formData.append('_token', _token); 
            formData.append('tipo_file', tipo_file); 

            $.ajax({
                url: '{{ route("bd.importarResultados") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {

                    $('#disc_d').val(res.D ?? '-');
                    $('#disc_i').val(res.I ?? '');
                    $('#disc_s').val(res.S ?? '');
                    $('#disc_c').val(res.C ?? '');
                    bien('Resultados DISC importados correctamente.');
                },
                error: function (err) {
                    console.error(err);
                    mal("Error al procesar el PDF. Asegúrate de que el archivo sea correcto.");
                }
            });
        }
        if(tipo_file=='RAZI')
        {  
            const input = document.getElementById('archivo_razi');
            const file = input.files[0];

            if (!file) {
                mal('Por favor, selecciona un archivo PDF primero.');
                return;
            }

            const formData = new FormData();
            formData.append('pdf_file', file);
            formData.append('_token', _token); 
            formData.append('tipo_file', tipo_file); 

            $.ajax({
                url: '{{ route("bd.importarResultados") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    if (res.fecha) {
                        const partes = res.fecha.split(/[-\/]/); // soporta '-' y '/'
                        $('#fecha_razi').val(`${partes[2]}-${partes[1]}-${partes[0]}`);
                    }

                    $('#razi_v').val(res.verbal ?? '');
                    $('#razi_num').val(res.numerica ?? '');
                    $('#razi_abs').val(res.abstracta ?? '');
                    alert('Resultados RAZI importados correctamente.');
                },
                error: function (err) {
                    console.error(err);
                    alert("Error al procesar el PDF. Asegúrate de que el archivo sea correcto.");
                }
            });
        }
    }

    function change_img(g)
    {   if(g=='M'){ $('#space_photo').html('<img src="storage/profiles/photo/el.png" class="rounded" alt="Foto" style="width: 150px; height: 150px; object-fit: cover; border: 2px solid #aeafb0;"id="img_photo" title="Cambiar foto">');}
        if(g=='F'){ $('#space_photo').html('<img src="storage/profiles/photo/ella.png" class="rounded" alt="Foto" style="width: 150px; height: 150px; object-fit: cover; border: 2px solid #aeafb0;"id="img_photo" title="Cambiar foto">');}
    }

    function showexperiencia()
    {   $('#num_ref_labs').val(0);
        $('#ref_labs').html('');
        if ($('#div_experiencia').hasClass('d-none'))
        {   $("#div_experiencia").removeClass('d-none');
            add_ref();
        }else{
            $("#div_experiencia").addClass('d-none');
        }
    }

    function showcursos()
    {   $('#num_cursos').val(0);
        $('#cursos_seminarios').html('');
        if ($('#div_cursos').hasClass('d-none'))
        {   $("#div_cursos").removeClass('d-none');
            add_cursos();
        }else{
            $("#div_cursos").addClass('d-none');
        }
    }

    //----- MUESTRA DIV NUEVO REGISTRO
    function canceladd_reg()
    {   if ($("#new_registro").hasClass('d-none')) {
            $("#new_registro").removeClass('d-none');
            $("#l_registros").addClass('d-none');
            $("#div_nomsecreg").html('Agregar Nuevo Registro');
            $('#bto_n').addClass('d-none');
            $('#bto_c').removeClass('d-none');
            $('#bto_g').removeClass('d-none');          
        } else {
            $("#new_registro").addClass('d-none');
            $("#l_registros").removeClass('d-none');
            $("#form_new_reg")[0].reset();
            $("#div_nomsecreg").html('Listado de Registros');
            $('#bto_n').removeClass('d-none');
            $('#bto_c').addClass('d-none');
            $('#bto_g').addClass('d-none');  
        }        
    }

    
        
    //-- DEPENDIENTES
    function showfamilydepends()
    {   if ($('#div_familiares_dependientes').hasClass('d-none'))
        {   $('#div_familiares_dependientes').removeClass('d-none'); }
        else
        {   $('#div_familiares_dependientes').addClass('d-none'); }
        $('#num_familiar_dependiente').val(0);
        $('#familiares_dependientes').html('');
        add_dependientes();
    }
        
            //----- AGREGA NUEVO DEPENDIENTE
    function add_dependientes() 
    {   let num_familiar_dependiente = parseInt($('#num_familiar_dependiente').val()) + 1;
        $('#num_familiar_dependiente').val(num_familiar_dependiente);
        
        const template = document.getElementById('plantilla_dependientes');
        const clone = template.content.cloneNode(true);
        
        // Actualiza número de dependiente en el título
        clone.querySelector('.num_dependiente').textContent = num_familiar_dependiente;
        
        // Asigna IDs y names únicos a cada input/select
        clone.querySelectorAll('input, button').forEach(el => {
        const baseName = el.name;
        if (!baseName) return;
            el.name = baseName + num_familiar_dependiente;
            el.id = baseName + num_familiar_dependiente;
        });
        document.getElementById('familiares_dependientes').appendChild(clone);
        if(num_familiar_dependiente===1)
        {   $('#btn_del_dependiente_1').addClass('d-none');}
    }
            
    function renumerar_dependientes() 
    {   $('#familiares_dependientes .dependientes-item').each(function(index) {
            const num = index + 1;
            $(this).find('.num_dependiente').text(num);
        
            // Renumerar name e id
            $(this).find('input').each(function () {
                let baseName = $(this).attr('name');
                if (!baseName) return;
                    baseName = baseName.replace(/\d+$/, '');
                $(this).attr('name', baseName + num);
                $(this).attr('id', baseName + num);
            });
        });
        // Actualiza el número total
        $('#familiares').val($('#familiares .familiar-item').length);
    }
        
        //-- FAMILIARES
    function showfamily()
    {   if ($('#div_familiares').hasClass('d-none'))
        {   $('#div_familiares').removeClass('d-none'); }
        else
        {   $('#div_familiares').addClass('d-none'); }
        $('#num_familiar').val(0);
        $('#familiares').html('');
        add_familiar();
    }
        
    //----- AGREGA NUEVO FAMILIAR
    function add_familiar() 
    {   let num_familiar = parseInt($('#num_familiar').val()) + 1;
        $('#num_familiar').val(num_familiar);
        
        const template = document.getElementById('plantilla_familiar');
        const clone = template.content.cloneNode(true);
        
        // Actualiza número de curso en el título
        clone.querySelector('.num_familia').textContent = num_familiar;
        
        // Asigna IDs y names únicos a cada input/select
        clone.querySelectorAll('input, button').forEach(el => {
            const baseName = el.name;
            if (!baseName) return;
            el.name = baseName + num_familiar;
            el.id = baseName + num_familiar;
        });
        document.getElementById('familiares').appendChild(clone);
        if(num_familiar===1)
        {   $('#btn_del_familiar_1').addClass('d-none');}
    }
        
    function renumerar_familiar() {
        $('#familiares .familiar-item').each(function(index) {
            const num = index + 1;
            $(this).find('.num_familia').text(num);
            // Renumerar name e id
            $(this).find('input').each(function () {
                let baseName = $(this).attr('name');
                if (!baseName) return;
                baseName = baseName.replace(/\d+$/, '');
                $(this).attr('name', baseName + num);
                $(this).attr('id', baseName + num);
            });
        });    
        // Actualiza el número total
        $('#familiares').val($('#familiares .familiar-item').length);
    }
        
    //----- AGREGA NUEVO CURSO
    function add_cursos() 
    {   let num_cursos = parseInt($('#num_cursos').val()) + 1;
        $('#num_cursos').val(num_cursos);
        const template = document.getElementById('plantilla_cursos');
        const clone = template.content.cloneNode(true);
        // Actualiza número de curso en el título
        clone.querySelector('.num_curso').textContent = num_cursos;    
        // Asigna IDs y names únicos a cada input/select
        clone.querySelectorAll('input, select, button').forEach(el => {
            const baseName = el.name;
            if (!baseName) return;
            el.name = baseName + num_cursos;
            el.id = baseName + num_cursos;
        });
        document.getElementById('cursos_seminarios').appendChild(clone);
        if(num_cursos===1)
        {   $('#btn_del_cursos_1').addClass('d-none');}
    }
        
    function renumerar_cursos() {
        $('#cursos_seminarios .cursos-item').each(function(index) {
            const num = index + 1;
            $(this).find('.num_curso').text(num);
            $(this).find('input').each(function () {
                let baseName = $(this).attr('name');
                if (!baseName) return;
                baseName = baseName.replace(/\d+$/, '');
                $(this).attr('name', baseName + num);
                $(this).attr('id', baseName + num);
            });
        });
        $('#cursos_seminarios').val($('#cursos_seminarios .cursos-item').length);
    }
        
    //----- AGREGA NUEVA EDUCACION
    function add_educ() 
    {   let num_educ = parseInt($('#num_educ').val()) + 1;
        $('#num_educ').val(num_educ);
        const template = document.getElementById('plantilla_educacion');
        const clone = template.content.cloneNode(true);
        clone.querySelector('.num_edu').textContent = num_educ;
        clone.querySelectorAll('input, select, button').forEach(el => {
            const baseName = el.name;
            if (!baseName) return;
            el.name = baseName + num_educ;
            el.id = baseName + num_educ;
        });
        document.getElementById('educ_form').appendChild(clone);
        if(num_educ===1)
        {   $('#btn_del_educ_1').addClass('d-none');}  
    }
        
    function renumerar_educacion() 
    {   $('#educ_form .educacion-item').each(function(index) {
            const num = index + 1;
            $(this).find('.num_edu').text(num);
            $(this).find('input, select').each(function () {
                let baseName = $(this).attr('name');
                if (!baseName) return;
                baseName = baseName.replace(/\d+$/, '');
                $(this).attr('name', baseName + num);
                $(this).attr('id', baseName + num);
            });
        });
        $('#num_educ').val($('#educ_form .educacion-item').length);
    }
        
    //----- AGREGA NUEVO HISTORIAL LABORAL
    function add_ref() 
    {   let num_ref_labs = parseInt($('#num_ref_labs').val()) + 1;
        $('#num_ref_labs').val(num_ref_labs);       
        const template = document.getElementById('plantilla_experiencia');
        const clone = template.content.cloneNode(true);
        clone.querySelector('.num_exp').textContent = num_ref_labs;
        clone.querySelectorAll('input, textarea, select, button').forEach(el => {
            const baseName = el.name;
            if (!baseName) return;
            el.name = baseName + num_ref_labs;
            el.id = baseName + num_ref_labs;
        });
        document.getElementById('ref_labs').appendChild(clone);
        if(num_ref_labs===1)
        {   $('#btn_del_experiencia_1').addClass('d-none');}
    }
        
    function renumerar_experiencias() 
    {   $('#ref_labs .experiencia-item').each(function(index) {
            const num = index + 1;
            $(this).find('.num_exp').text(num);
            $(this).find('input, textarea, select').each(function () {
                let baseName = $(this).attr('name');
                if (!baseName) return;
                    baseName = baseName.replace(/\d+$/, '');
                    $(this).attr('name', baseName + num);
                    $(this).attr('id', baseName + num);
            });
        });
        $('#num_ref_labs').val($('#ref_labs .experiencia-item').length);
    }
        
    //----- MUESTRA SECCIÓN PARA ADJUNTAR EL PERMISO
    function showpermiso(idpais) 
    {   if (idpais == 53) {
            $("#div_permiso_trab").addClass('d-none');
            $("#nacext_N").prop('checked', true);
            $("#nacext_E").prop('checked', false);
            $('#div_permiso_trab').html('');
        } else {
            $("#div_permiso_trab").removeClass('d-none');
            $("#nacext_N").prop('checked', false);
            $("#nacext_E").prop('checked', true);
            $('#div_permiso_trab').html('');
            const template = document.getElementById('plantilla_permiso');
            const clone = template.content.cloneNode(true);
            document.getElementById('div_permiso_trab').appendChild(clone);
        }
    }
        
    //----- BUSCADOR DE DISTRITO Y CORREGIMIENTO
    function buscarlugar(opt_find, sel) { 
        var _token = $('input[name="_token"]').val();
        var parametros = {
            "_token": _token,
            "opt_find": opt_find,
            "sel": sel
        };
        $.ajax({
            data: parametros,
            url: "{{ route('ofertas.finddistcor') }}",
            type: 'POST',
            dataType: "json",
            cache: true,
            success: function (data) {
                $('#sel_' + opt_find).empty();
                $('#sel_' + opt_find).append("<option value=''>Seleccionar</option>");
                jQuery(data).each(function (i, item) {
                    $('#sel_' + opt_find).append("<option value='" + item.id + "'>" + item.lugar + "</option>");
                });
                $('#sel_' + opt_find).removeAttr("disabled");
            }
        });
    }

    //--- ELIMINA UNA FILA DE CUALQUIER TABLA, SE PASA LA FILA CON THIS Y EL NOMBRE DE TABLA "table_NOMBRETABLA"
    function delrow(id, opt_table) {
        let row = id.parentNode.parentNode;
        let table = document.getElementById("table_" + opt_table);
        table.deleteRow(row.rowIndex);
    }

        
    //----- VALIDACIÓN DEL FORMULARIO
    function validateForm() {
        const form = document.getElementById("form_new_reg");

        const getVal = (selector) => $(selector).val()?.trim() || '';
        const getCheckedVal = (name) => $(`input[name="${name}"]:checked`).val() || null;

        let msn = '-';

        // DATOS PERSONALES
        const prinombre = getVal('#prinombre');
        const priapellido = getVal('#priapellido');
        const f_nacimiento = getVal('#f_nacimiento');
        const num_docip = getVal('#num_docip');
        const num_ss = getVal('#num_ss');
        const direccion = getVal('#direc');
        const telefono = getVal('#telefono');
        const correo = getVal('#mail');
        const nacionalidad = $('#sel_nacionalidad').val();
        const provincia = $('#sel_provincias').val();
        const distrito = $('#sel_distrito').val();
        const corregimiento = $('#sel_corregimiento').val();
        const estado_civil = $('#sel_estadocivil').val();

        // Edad
        const fechaNacimiento = new Date(f_nacimiento);
        const hoy = new Date();
        let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
        const mes = hoy.getMonth() - fechaNacimiento.getMonth();
        const dia = hoy.getDate() - fechaNacimiento.getDate();
        if (mes < 0 || (mes === 0 && dia < 0)) edad--;
        if (edad < 18) return mal('Debe ser mayor de edad (18 años o más).');

        // Permiso para extranjeros
        let tipo_permiso = null;
        let f_vence_permiso = null;
        if (nacionalidad != 53) {
            tipo_permiso = $('#sel_tipopermiso option:selected').text().trim() || '';
            f_vence_permiso = getVal('#f_vence_permiso');
        }

        const datosFormulario = {
            genero: getCheckedVal("sel_genero"),
            prinombre,
            segnombre: getVal('#segnombre'),
            priapellido,
            segapellido: getVal('#segapellido'),
            f_nacimiento,
            tipo_documento: $('#sel_tipodoc').val(),
            num_docip,
            num_ss,
            estado_civil,
            nacionalidad,
            nacext: getCheckedVal("nacext[]"),
            tipo_permiso,
            f_vence_permiso,
            provincia,
            distrito,
            corregimiento,
            direccion,
            telefono,
            correo,
            tipo_sangre: $('#sel_sangre').val(),
            medico_cabecera: getVal('#medico_cabecera'),
            hospital: getVal('#hospital'),
            telhospital: getVal('#telhospital'),
            alergico: $('#sel_alergico').val(),
            nombre_medicamento: getVal('#nombre_medicamento'),
            discapacidad: $('#sel_discapacidad').val(),
            explique_disc: getVal('#explique_disc'),
            lesion: $('#sel_lesion').val(),
            nombre_lesion: getVal('#nombre_lesion'),
            nombre_urgencia: getVal('#nombre_urgencia'),
            nombre_urgencia_parentesco: getVal('#nombre_urgencia_parentesco'),
            nombre_urgencia_telefono: getVal('#nombre_urgencia_telefono'),
            foto: $('#foto_temp_path').val() || null
        };
        datosFormulario.experiencias = [];
        document.querySelectorAll('#ref_labs .experiencia-item').forEach((item) => {
            const empresa = item.querySelector('[name^="empresa_experiencia_"]')?.value.trim() || '';
            const puesto = item.querySelector('[name^="pue_"]')?.value.trim() || '';
            
            // Puedes validar si hay al menos empresa y puesto antes de agregar
            if (empresa !== '' && puesto !== '') {
                datosFormulario.experiencias.push({
                    empresa,
                    puesto,
                    subarea: `${item.querySelector('[name^="sel_subarea_experiencia_"]')?.value || ''}-${
                        item.querySelector('[name^="sel_subarea_experiencia_"] option:checked')?.textContent.trim() || ''
                    }`,
                    desde: item.querySelector('[name^="desde_"]')?.value || '',
                    hasta: item.querySelector('[name^="hasta_"]')?.value || '',
                    motivo_salida: item.querySelector('[name^="motivo_"]')?.value.trim() || '',
                    telefono: item.querySelector('[name^="tel_empresa_"]')?.value.trim() || '',
                    direccion: item.querySelector('[name^="dir_"]')?.value.trim() || '',
                    salario: item.querySelector('[name^="sal_"]')?.value || '',
                    jefe: item.querySelector('[name^="jefe_"]')?.value.trim() || ''
                });
            }
        });

        // EDUCACIÓN
        datosFormulario.educaciones = [];
        document.querySelectorAll('#educ_form .educacion-item').forEach((item) => {
            const nivel = item.querySelector('[name^="sel_niveleduc_"]')?.value || '0';
            if (nivel !== '0') {
                datosFormulario.educaciones.push({
                    nivel,
                    institucion: item.querySelector('[name^="institucion_educ_"]')?.value.trim() || '',
                    carrera: item.querySelector('[name^="carrera_educ_"]')?.value.trim() || '',
                    ano: item.querySelector('[name^="ano_educ_"]')?.value || '',
                    estatus: item.querySelector('[name^="sel_estatuseduc_"]')?.value || ''
                });
            }
        });

        // CURSOS
        datosFormulario.cursos = [];
        document.querySelectorAll('#cursos_seminarios .cursos-item').forEach((item) => {
            const institucion = item.querySelector('[name^="entidad_curso_"]')?.value.trim() || '';
            const nombre = item.querySelector('[name^="nombre_curso_"]')?.value.trim() || '';
            const ano = item.querySelector('[name^="ano_curso_"]')?.value || '';
            if (institucion && nombre) {
                datosFormulario.cursos.push({ institucion, nombre, ano });
            }
        });

        // REFERENCIAS
        datosFormulario.referencias = Array.from({ length: 3 }, (_, i) => {
            const idx = i + 1;
            return {
                nombre: getVal(`#nombre_ref_personal_${idx}`),
                direccion: getVal(`#dir_ref_personal_${idx}`),
                telefono: getVal(`#tel_ref_personal_${idx}`),
            };
        }).filter(ref => ref.nombre || ref.direccion || ref.telefono);

        // CONOCIMIENTOS
        datosFormulario.conocimientos_adicionales = {
            espanol: $('#sel_espanol').val(),
            ingles: $('#sel_ingles').val(),
            dominioComputadora: $('#sel_computadora').val(),
            manejoWord: $('#sel_word').val(),
            manejoExcel: $('#sel_excel').val(),
            manejoPPT: $('#sel_ppt').val(),
            otroConocimiento: getVal('input[name="otro_conocimiento"]'),
            sedan: $('#chk_sedan').is(':checked') ? 'S' : 'N',
            camion: $('#chk_camion').is(':checked') ? 'S' : 'N',
            trailer: $('#chk_trailer').is(':checked') ? 'S' : 'N',
            moto: $('#chk_moto').is(':checked') ? 'S' : 'N',
            montacargas: $('#chk_montacargas').is(':checked') ? 'S' : 'N',
        };

        // FAMILIARES
        datosFormulario.familiares = $('input[name="opt_familia_"]:checked').val() === 'SI'
            ? $('#familiares .familiar-item').map(function () {
                return {
                    nombre: getVal('input[name^="nombre_familia_"]', $(this)),
                    parentesco: getVal('input[name^="parentesco_"]', $(this)),
                    unidad: getVal('input[name^="nom_unidad_"]', $(this))
                };
            }).get()
            : [];

        // DEPENDIENTES
        datosFormulario.dependientes = $('input[name="opt_depentiene_"]:checked').val() === 'SI'
            ? $('#familiares_dependientes .dependientes-item').map(function () {
                return {
                    nombre: getVal('input[name^="nombre_dependiente_"]', $(this)),
                    parentesco: getVal('input[name^="parentesco_dependiente_"]', $(this)),
                    fechaNacimiento: getVal('input[name^="fecha_nac_"]', $(this))
                };
            }).get()
            : [];

        // Archivos y autorizaciones
        const archivoCV = $('#filecv')[0]?.files[0];
        const permiso_archivo = $('#filepermiso')[0]?.files[0];
        datosFormulario.autorizaciones = {
            chk_psico: $('#chk_psico').is(':checked') ? 'S' : 'N',
            chk_viajar: $('#chk_viajar').is(':checked') ? 'S' : 'N',
            chk_verificar_info: $('#chk_verificar_info').is(':checked') ? 'S' : 'N',
            chk_afirmacion: $('#chk_afirmacion').is(':checked') ? 'S' : 'N',
        };

        // Envío
        const formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());
        formData.append('datos', JSON.stringify(datosFormulario));
        if (archivoCV) formData.append('archivoCV', archivoCV);
        if (permiso_archivo) formData.append('permiso_archivo', permiso_archivo);

        if (form.checkValidity()) {
            $.ajax({
                url: "{{ route('bd.store') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    if (response.data_listado) {
                        bien('Registro guardado correctamente.');
                        const persona = response.data_listado[0];
                        const iniciales = `${persona.prinombre.charAt(0)}${persona.priapellido.charAt(0)}`.toUpperCase();
                        let fotoHtml = `<img src="${persona.foto}" alt="Foto de ${persona.prinombre} ${persona.priapellido}" class="rounded-circle" style="background:#FFFFFF; width: 60px; height: 60px; object-fit: cover; border: 1px solid #aeafb0;">`;
                        if (!persona.foto) {
                            fotoHtml = `
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="
                                    width: 60px; height: 60px; background-color: ${persona.color_bg};  border-radius: 50%;
                                    display: flex; align-items: center; justify-content: center;
                                    color: ${persona.color_text}; font-family: 'Segoe UI', 'Roboto', sans-serif;
                                    font-size: 35px; text-transform: uppercase; border: 1px solid ${persona.color_text}">
                                    ${iniciales}
                                </div>`;
                        }
                        let tabla = $('#MyTable').DataTable();
                        // Insertamos la nueva fila y guardamos su referencia
                        const nuevaFila = tabla.row.add($(`
                            <tr id="row_${persona.id}" class="oflinfo" onclick="registro(${persona.id})">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">${fotoHtml}</div>
                                        <div>
                                            <div class="fw-bold text-uppercase" style="color: #4B6EAD;font-size: 13px">${persona.prinombre ?? ''} ${persona.priapellido}</div>
                                            <div class="text-secondary" style="font-size: 12px"><i class="fa-solid fa-envelope pe-1"></i><span class="text-primary">${persona.email}</span></div>
                                            <div class="text-secondary" style="font-size: 12px"><i class="fa-solid fa-phone-flip pe-1"></i>${persona.tel}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-secondary align-middle">${persona.prov_residencia}</td>
                                <td>
                                    <div class="text-secondary">${persona.titulo}</div>
                                    <div class="text-secondary">${persona.entidad}</div>
                                </td>
                                <td class="align-middle text-secondary" style="font-size: 10px">
                                    <ul></ul>
                                </td>
                            </tr>
                        `)).draw(false);

                        // Limpiar el formulario
                        canceladd_reg();
                        // 1. Obtener el índice de la fila dentro del conjunto actual
                        const index = tabla.rows().indexes().filter(function (idx) {
                            return tabla.row(idx).node() === nuevaFila.node();
                        })[0];
                        // 2. Calcular a qué página pertenece ese índice
                        const pageSize = tabla.page.info().length;
                        const pageIndex = Math.floor(index / pageSize);
                        // 3. Ir a esa página y redibujar
                        tabla.page(pageIndex).draw(false);
                        // 4. Opcional: hacer scroll hacia esa fila o resaltar
                        $(nuevaFila.node()).addClass('table-success');
                        form.reset();
                        // Resetear input file correctamente
                        const oldInput = document.getElementById('insert_image_bd');
                        const newInput = oldInput.cloneNode(true); // clona con los mismos atributos
                        oldInput.parentNode.replaceChild(newInput, oldInput);

                        // Resetear hidden y vista previa
                        document.getElementById('foto_temp_path').value = '';
                        document.getElementById('img_photo').src = 'storage/profiles/photo/el.png';
                    }

                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    mal('Error al enviar el formulario');
                }
            });
        } else {
            form.reportValidity();
        }
    }



    function mal(msn)
    {   Swal.fire({
            position: 'center',
            icon: 'warning',
            text: msn,
        })
    }
    function bien(msn)
    {   Swal.fire({
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

</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        
        add_educ();

    });
</script>
@endsection