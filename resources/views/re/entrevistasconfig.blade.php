<!DOCTYPE html>
@extends('layouts.plantilla')

@section('title','Configuración de Entrevistas')

@section('content')

    <script type="text/javascript">
        // <![CDATA[
        function preloader() {
            document.getElementById("preload").style.display = "none";
            document.getElementById("iframe").style.display = "block";
        }
        // preloader
        window.onload = preloader;
        // ]]>
    </script>
    <style>
        /* Labels */
        .label {
            font-weight: 600;
            color: #6c757d;
        }
          .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: .5rem;
            margin-bottom: 1rem;
        }
    </style>
    <div class="pagetitle pb-0 mb-0">
        <div class="row pb-0 mb-0">
            <div class="col-8 my-0 py-0">
                <h1 class="text-secondary">Preguntas de Entrevistas</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" style="font-weight: normal;">Configuración de Preguntas para Entrevistas Funcionales</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <small>
        <div id="preload" class="align-items-center justify-content-center text-center">
            <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
        </div>
    </small>

    <!-- LISTADO PRINCIPAL OFERTAS LABORALES-->
    <div id="iframe" style="display: none;">
        <div class="card">
            <div class="card-header pb-0">
                <h4><i class="fa-solid fa-clipboard-question"></i> Configuración de Preguntas de Entrevistas Funcionales</h4>
            </div>
            <div class="card-body">
                @csrf
                <div class="row mt-4">
                    <div class="col-4">
                        <select class="form-select form-select-sm" name="sel_grp" id="sel_grp" aria-label="Default select example" onchange="muestra_estructura(1)">
                            <option value='0' selected>Seleccione Grupo</option>
                            @foreach( $data_sups as $sup )
                            <option value="{{ $sup->id }}">{{ $sup->nameund }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4" id="div_ue">
                        <select class="form-select form-select-sm" name="sel_ue" id="sel_ue" aria-label="Default select example" onchange="muestra_estructura(10)" style="display:none">
                            <option value='0' selected>Seleccione Unidad</option>
                        </select>
                    </div>
                </div>
                <hr>
                <small>
                    <div id="tabla_estructura" class="d-flex align-items-center justify-content-center"></div>
                </small>
            </div>
        </div>
    </div>

    <!-- Modal PREGUNTAS FUNCIONALES-->
    <div class="modal fade" id="modalPreg" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalPreg" aria-hidden="true">
        <div id="clase_modal" class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-light text-primary py-1 fs-5">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-clipboard-question fa-lg pe-2"></i> Preguntas de Entrevista Funcional
                    </h5>
                    <button type="button" class="btn-close btn-close-secondary" onclick="muestra_estructura(10)" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                
                <div class="modal-body">
                    <div class="row mb-2">           
                        <div class="col label">Nombre de la Posición:</div>
                        <div id="lb_posicion" class="col-sm-9 text-primary"style="text-align: justify;"></div>   
                        <input type="hidden" id="idf" value="">    
                        <input type="hidden" id="idpue" value="">     
                        <input type="hidden" id="idpreg" value="">
                    </div>
                    
                    <div class="row">
                        <div class="col label">Propósito:</div>
                        <div id="lb_proposito" class="col-sm-9" style="text-align: justify;"></div>
                    </div>

                    <div class="row mt-2">
                        <div class="col px-4">
                        <small>
                        <small>
                        <table id="table_respon" class="table table-bordered table-sm " style="width:100%">
                        <thead>
                            <tr>
                            <th class="text-light text-center align-middle bg-primary">Áreas de Responsabilidad</th>
                            <th class="text-light text-center align-middle bg-primary">Tareas</th>
                            <th class="text-light text-center align-middle bg-primary">Nivel de Criticidad</th>
                            </tr>
                        </thead>
                        <tbody class="text-secondary" id="body_respon">                        
                            <!-- Listado de responsabilidades -->
                        </tbody>
                        </table>
                        </small>
                        </small>
                    </div>
                    </div>


                    <h5 class="card-title">Preguntas de Entrevista</h5>
                    <div class="row mb-2 px-4">   
                        
                        <div class="col-2"></div>
                        <div class="col-7 text-end">
                            <textarea id="nueva_pregunta" name="nueva_pregunta"  class="form-control form-control-sm" placeholder="Nueva pregunta"rows="2"></textarea>
             
                        </div>
                        <div class="col-3 text-end">
                            <button type="button" id="bto_add" class="btn btn-sm btn-outline-primary" onclick="add_preg()"> <i class="fa-solid fa-plus"></i> Agregar pregunta</button>
                            <button type="button" id="bto_upd" class="btn btn-sm btn-info d-none" onclick="upd_preg()"> <i class="fa-solid fa-plus"></i> Actualizar pregunta</button>
                        </div>
                    </div>  

                    <div class="row px-4">
                        <div class="col-2"></div>
                        <div class="col-8 align-items-center justify-content-center">
                            <table class="table table-hover">
                                <tbody id="preguntas">
                                </tbody>
                            </table>
                        </div>
                        <div class="col-2"></div>
                    </div>
                </div>
                <div class="modal-footer bg-light py-1">
                    <button type="button" id="btn btn-secondary btn-sm" class="btn btn-secondary btn-sm"  data-bs-dismiss="modal" onclick="muestra_estructura(10)"><i class="fa-solid fa-arrow-left pe-1"></i> Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    // EDITAR PREGUNTA
    function editar_pregunta(idpreg) {
        $("#nueva_pregunta").val($('#pregunta_' + idpreg).html());
        $('#bto_add').addClass('d-none');
        $('#bto_upd').removeClass('d-none');
        $('#idpreg').val(idpreg);
        $("#nueva_pregunta").focus();
    }
    // ACTUALIZAR PREGUNTA
    function upd_preg() 
    {
        var idpreg = $('#idpreg').val();
        var nueva_pregunta = $('#nueva_pregunta').val().trim();
        if (nueva_pregunta === '') {
            mal('La pregunta no puede estar vacía.');
            return;
        }
        var _token = $('input[name="_token"]').val();
        var parametros = { idpreg, nueva_pregunta, _token };

        // Guardar scroll actual
        var scrollPos = $(window).scrollTop();

        $.ajax({
            data: parametros,
            url: "{{ route('entrevistasconfig.editpreg') }}",
            type: 'POST',
            dataType: "json",
            cache: true,
            success: function (data) {
                if (data.success) {
                    $('#nueva_pregunta').val('');
                    $('#idpreg').val('');
                    $('#bto_add').removeClass('d-none');
                    $('#bto_upd').addClass('d-none');
                    $('#pregunta_' + idpreg).html(nueva_pregunta);

                } else {
                    mal(data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                mal(xhr.responseText);
            }
        });
    }

    function eliminar_pregunta(idpreg) {
        var _token = $('input[name="_token"]').val();
        var parametros = {"idpreg": idpreg, "_token": _token };

        $.ajax({
            data: parametros,
            url: "{{ route('entrevistasconfig.destroy') }}",
            type: 'POST',
            dataType: "json",
            cache: true,
            success: function (data) {
                if (data.success) {
                    edit_preg($('#idf').val(), $('#idpue').val()); // Recargar las preguntas
                } else {
                    mal('Error al eliminar la pregunta. Inténtelo de nuevo.');
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                mal('Error en la solicitud. Inténtelo de nuevo.');
            }
        });
    }

    // AGREGAR PREGUNTA
    function add_preg()
    {
        var idf = $('#idf').val();
        var nueva_pregunta = $('#nueva_pregunta').val().trim();
        if (nueva_pregunta === '') {
            mal('La pregunta no puede estar vacía.');
            return;
        }

        var _token = $('input[name="_token"]').val();
        var parametros = { "idf": idf, "nueva_pregunta": nueva_pregunta, "_token": _token };

        $.ajax({
            data: parametros,
            url: "{{ route('entrevistasconfig.store') }}",
            type: 'POST',
            dataType: "json",
            cache: true,
            success: function (data) {
                if (data.success) {
                    $('#nueva_pregunta').val(''); // Limpiar el campo de entrada
                    edit_preg(idf, $('#idpue').val()); // Recargar las preguntas
                } else {
                    mal('Error al agregar la pregunta. Inténtelo de nuevo.');
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                mal('Error en la solicitud. Inténtelo de nuevo.');
            }
        });
    }

    function edit_preg(idf, idpue) {
        $('#lb_posicion').html($('#pue_' + idpue).html());
        $('#modalPreg').modal('show');
        $('#idf').val(idf);
        $('#idpue').val(idpue);
        var _token = $('input[name="_token"]').val();
        var parametros = { "idf": idf, "_token": _token };

        $.ajax({
            data: parametros,
            url: "{{ route('entrevistasconfig.edit') }}",
            type: 'POST',
            dataType: "json",
            cache: true,
            beforeSend: function () {
                $("#preguntas").html('<tr><td colspan="2"><div class="text-muted small">Cargando...</div></td></tr>');
            },
            success: function (data) {
                $('#lb_proposito').html(data.proposito ?? '');
                $("#preguntas").empty();

                $("#body_respon").html('');
                $.each(data.respons, function(i, item){ 
                    let rowspan = item.cant_tarea > 0 ? item.cant_tarea : 1;
                    let tareasDeArea = data.tareas.filter(t => t.idarearespon === item.id_respon);

                    if (tareasDeArea.length === 0) {
                        // Caso: no tiene tareas, igual muestro fila con solo el área
                        $("#body_respon").append(
                            '<tr>' +
                                '<td class="ps-2 align-middle text-uppercase" rowspan="'+rowspan+'">'+item.area_respon+'</td>' +
                                '<td class="text-center text-muted" colspan="2">Sin tareas registradas</td>' +
                            '</tr>'
                        );
                    } else {
                        $.each(tareasDeArea, function(j, tarea){
                            let fila = "<tr>";
                            if (j === 0) {
                                // primera fila → meto el área con rowspan
                                fila += '<td class="ps-2 align-middle text-uppercase" rowspan="'+rowspan+'">'+item.area_respon+'</td>';
                            }
                            fila += '<td class="align-middle">'+tarea.tarea+'</td>';
                            fila += '<td class="text-center align-middle">'+tarea.criticidad+'</td>';
                            fila += "</tr>";
                            $("#body_respon").append(fila);
                        });
                    }
                });

                /*agregando preguntas si existen*/

                if (!data.preguntas || data.preguntas.length === 0) {
                    $("#preguntas").html('<tr><td colspan="2"><div class="text-center text-muted small">No hay preguntas registradas.</div></td></tr>');                
                }else
                {   x=0;
                    $.each(data.preguntas, function (i, item) {
                    x++;
                        $("#preguntas").append(
                            '<tr>' +
                            '<td><div class="text-muted">' + x + ' - <span id="pregunta_' + item.id + '">' + item.pregunta + '</span></div></td>' +
                            '<td class="text-end">' +
                            '<i class="fa-solid fa-pencil text-primary" style="cursor:pointer;" onclick="editar_pregunta(' + item.id + ')"></i>' +
                            '<i class="fas fa-trash-alt text-danger ms-2" style="cursor:pointer;" onclick="eliminar_pregunta(' + item.id + ')"></i>' +
                            '</td>' +
                            '</tr>'
                        );
                    });}

            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
    // MUESTRA ESTRUCTURA SEGUN GRUPO Y UNIDAD
    function muestra_estructura(opt) {
        var _token = $('input[name="_token"]').val();
        var sel_grp = document.getElementById('sel_grp').value; // ✅ definido siempre
        var sel_ue = document.getElementById('sel_ue').value;

        if (opt == 1) {
            document.getElementById("tabla_estructura").innerHTML = '';
            if (sel_grp > 0) {
                var parametros = {
                    "sel_grp": sel_grp,
                    "opt": opt,
                    "_token": _token
                };
                $.ajax({
                    data: parametros,
                    url: "{{ route('procedimientos.show') }}",
                    type: 'POST',
                    dataType: "json",
                    cache: true,
                    beforeSend: function() {
                        $("#sel_ue").prop("disabled", true).hide();
                    },
                    success: function(data) {
                        $("#sel_ue").show().prop("disabled", false).empty();
                        $('#sel_ue').append("<option value='0' selected>Seleccione Unidad Económica</option>");

                        // mejor performance al armar opciones
                        let options = data.map(item => `<option value="${item.id}">${item.nameund}</option>`).join('');
                        $('#sel_ue').append(options);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $("#tabla_estructura").html('<div class="text-danger"><i class="fa-solid fa-triangle-exclamation"></i> Error al cargar las unidades</div>');
                    }
                });
            }
        }

        if (opt == 10) {
            if (sel_grp > 0 && sel_ue > 0) {
                var parametros = {
                    "sel_ue": sel_ue,
                    "opt": opt,
                    "_token": _token
                };
                $.ajax({
                    data: parametros,
                    url: "{{ route('procedimientos.show') }}",
                    type: 'POST',
                    cache: true,
                    beforeSend: function() {
                        document.getElementById("tabla_estructura").innerHTML =
                            '<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
                    },
                    success: function(data) {
                        document.getElementById("tabla_estructura").innerHTML = data;
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $("#tabla_estructura").html('<div class="text-danger"><i class="fa-solid fa-triangle-exclamation"></i> Error al cargar la estructura</div>');
                    }
                });
            }
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
