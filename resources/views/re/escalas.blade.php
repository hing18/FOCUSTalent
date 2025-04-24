<!DOCTYPE html>
@extends('layouts.plantilla')

@section('title','Escalas de Tiempo de Respuesta')
<div class="pagetitle">

@section('content')
    <h1 class="text-secondary">Reclutamiento</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"style="font-weight: normal;">Tiempo de Respuesta en la Contratación</li>
        <li class="breadcrumb-item" style="color: #4B6EAD">Configuración de Escalas</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
@csrf
  
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
      <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Escalas</button>
      <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Unidades - Escala</button>
    </div>
  </nav>
  <div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <small>
            @php
                $grupo = null;
                $escala = null;                
            @endphp        
            @foreach($grupos as $data)
                @if ($grupo != $data->grupo)
                    {{-- Cierra la tabla anterior si ya se abrió una --}}
                    @php $x=0; @endphp
                    @if ($grupo != null)                    
                        </tbody> </table> </div>
                        <hr>
                    </div>
                    @endif
        
                    {{-- Abre un nuevo grupo --}}
                    <div class="row"><div class="ps-4 col-auto">
                        <h5 class="my-4" style="color: #4B6EAD">{{ $data->grupo }}                    
                                <button type="button" class="ms-4 btn btn-sm btn-outline-info"onclick="add_escala({{ $data->id_grupo }})"><i class="fas fa-plus-circle pe-1"></i>Nueva Escala</button>               
                        </h5>
                        <table class="table table-sm table-striped-columns table-hover mx-auto" style="table-layout: auto; width: auto; white-space: nowrap;" id="tbl_{{ $data->id_grupo }}">
                            <thead>
                                <tr class="text-center table-primary">
                                    <th style="color: #4B6EAD; vertical-align: middle;">JERARQUÍA</th>
                                    {{-- Mostrar todas las escalas del grupo correspondiente --}}
                                    @foreach($escalas as $dataes)
                                        @if($dataes->id_grupo == $data->id_grupo)
                                            {{-- Mostrar la escala solo si no se ha mostrado antes --}}
                                            @if ($escala != $dataes->nom_escala)
                                                @if ($dataes->id_escala!=null)
                                                <th style="color: #4B6EAD; vertical-align: middle; font-size: 11px;" class="px-2 th-icon" data-id="{{ $dataes->id_escala }}">
                                                    {{ $dataes->nom_escala }} <input class="txt" data-id="{{ $dataes->id_escala }}" type="hidden" value="0" id="e_{{ $dataes->id_escala }}">
                                                    <br>
                                                    <i title="Editar" class="fas fa-pencil-alt fa-lg edit d-none icono" onclick="edit('{{ $dataes->id_escala }}')" data-id="{{ $dataes->id_escala }}"></i>
                                                    <i title="Guardar" title="Guardar" class="fas fa-save fa-lg activar d-none iconos" onclick="save('{{ $dataes->id_grupo }}','{{ $dataes->id_escala }}')" data-id="{{ $dataes->id_escala }}"></i>
                                                    <i title="Eliminar" class="fas fa-trash-alt dell fa-lg d-none icono" onclick="del('{{ $dataes->id_grupo }}','{{ $dataes->id_escala }}')" data-id="{{ $dataes->id_escala }}"></i>
                                                    <div id="spin" class="spinner-border spinner-border-sm text-primary d-none" role="status"> </div>
                                                </th>
                                                    @php
                                                        $escala = $dataes->nom_escala;
                                                    @endphp
                                                @endif
                                            @endif
                                        @endif
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $grupo = $data->grupo;
                                @endphp
                @endif
                <tr> 
                    @php $x++; @endphp
                    <td class="ps-2 small" style="font-size: 11px;"> {{ $data->jerarquia }}<input type="hidden" value="{{ $data->id_jerarquia }}" id="{{ 'idjer_'.$data->id_grupo.'-'.$x }}"></td>
                    
                
                    @foreach($escalas as $dataes)
                        @if($dataes->id_grupo == $data->id_grupo)
                            @if ($dataes->id_escala!=null)
                                @if ($dataes->idjer == $data->id_jerarquia)
                                    <td id="{{ $dataes->id_escala."-".$x }}" class="text-center py-0">{{ $dataes->tiempo ?? '-' }}</td>
                                @endif
                            @endif
                        @endif
                    @endforeach
                </tr>
        
            @endforeach
        
            {{-- Cierra la última tabla si hay contenido --}}
            @if ($grupo != null)
                </tbody>
                </table>
                </div>
            </div>
            @endif
        
            </small>
    </div>
    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <div class="row">
            <div style="color: #4B6EAD;" class=" col h5 mt-4">Escalas aplicadas a unidades del negocio</div>
        </div>
            
        <small>
            @php
                $grupo = null;
                $sel="";
                $list="";
            @endphp  
        
            @foreach($escala_unidades as $data)
                {{-- Verifica si el grupo ha cambiado y cierra la tabla anterior --}}
                @if ($grupo != $data->grupo)
                    @if($sel=="")
                        @foreach($select_escala as $dataescala)
                            @if($dataescala->idgrupo==$data->idgrupo)
                                @php $sel.='<option value="'.$dataescala->id.'">'.$dataescala->nombre.'</option>'; @endphp
                            @endif
                        @endforeach
                        @php
                            $list='<select class="form-select  form-select-sm" aria-label="Seleccionar escala" id="sel0_'.$data->idgrupo.'" onchange="edita_escala('.$data->idgrupo.',this.value,0)">
                                <option selected>Seleccionar escala</option>'.$sel.'</select>';
                        @endphp
                    @endif
                    @if ($grupo != null)                    
                        </tbody> 
                        </table> 
                        </div> 
                        <hr>  
                        </div> 
                    @endif
        
                    {{-- Abre un nuevo grupo --}}
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-auto">
                            <div class="row py-4">
                                <div class="col-auto"> <span class="my-4 h5" style="color: #4B6EAD">{{ $data->grupo }}   <span></div>
                                <div class="col-auto"> @php echo $list; @endphp</div>
                                <div class="col-sm"><button type="button" class="ms-4 btn btn-sm btn-outline-info"onclick="aplica_escala({{ $data->idgrupo }},0)"><i class="fas fa-plus-circle pe-1"></i>Aplicar Escala</button></div>
                            </div>
                            <table class="table table-sm table-striped-columns table-hover mx-auto" id="tblescala_{{ $data->idgrupo }}">
                                <thead>
                                    <tr class="text-center table-primary">
                                        <th style="color: #4B6EAD; vertical-align: middle;">UNIDADES</th>
                                        <th style="color: #4B6EAD; vertical-align: middle;">ESCALA APLICADA</th>
                                    </tr>
                                </thead>
                                <tbody>
                @else
                    @php                    
                        $sel="";
                        $list="";
                    @endphp
                @endif        
                    {{-- Contenido de la fila con unidad y escala --}}
                    <tr> 
                        <td class="ps-4 small py-0">
                            <div class="form-check mt-1">
                                <input class="form-check-input" type="checkbox" value="{{ $data->idunidad }}" name="chk0_{{ $data->idgrupo }}[]" id="chk_{{ $data->idunidad }}" style="cursor: pointer">
                                <label class="form-check-label" for="chk_{{ $data->idunidad }}" style="cursor: pointer">
                                    {{ $data->unidad }}
                                </label>
                            </div>
                        </td>                        
                        <td class="text-center small"><span id="nom_escala_{{ $data->idunidad }}">{{ $data->escala }}</span></td>
                    </tr>        
                    @php
                        $grupo = $data->grupo;
                    @endphp
            @endforeach
        
            {{-- Cierra la última tabla si hay contenido --}}
            @if ($grupo != null)
                </tbody> 
                </table> 
                </div> <HR>
            </div>
            @endif
 

            @php
                $grupo = null;
                $unidadAnterior = null;
                $contadorUnidades = 0;
                $sel="";
                $list="";
            @endphp  

            @foreach($escala_tiendas as $data)
                {{-- Verifica si el grupo ha cambiado y cierra la tabla anterior --}}
                @if ($grupo != $data->grupo)
                    @if($sel=="")
                        @foreach($select_escala as $dataescala)
                            @if($dataescala->idgrupo==$data->idgrupo)
                                @php $sel.='<option value="'.$dataescala->id.'">'.$dataescala->nombre.'</option>'; @endphp
                            @endif
                        @endforeach
                        @php
                            $list='<select class="form-select  form-select-sm" aria-label="Seleccionar escala" id="sel1_'.$data->idgrupo.'" onchange="edita_escala('.$data->idgrupo.',this.value,1)">
                                <option selected>Seleccionar escala</option>'.$sel.'</select>';
                        @endphp
                    @endif
                    @if ($grupo != null)                    
                        </tbody> 
                        </table> 
                    </div> 
                    <hr>  
                    </div> 
                    @endif

                    {{-- Abre un nuevo grupo --}}
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-auto ">
                            <div class="row py-4">
                                <div class="col-auto"> <span class="my-4 h5" style="color: #4B6EAD">{{ $data->grupo }}   <span></div>
                                <div class="col-auto"> @php echo $list; @endphp</div>
                                <div class="col-sm"><button type="button" class="ms-4 btn btn-sm btn-outline-info"onclick="aplica_escala({{ $data->idgrupo }},1)"><i class="fas fa-plus-circle pe-1"></i>Aplicar Escala</button></div>
                            </div>
                            <table class="table table-sm table-hover mx-auto table-bordered" id="tblescala_{{ $data->idgrupo }}">
                                <thead>
                                    <tr class="text-center table-primary">
                                        <th style="color: #4B6EAD; vertical-align: middle;">UNIDADES</th>
                                        <th style="color: #4B6EAD; vertical-align: middle;">TIENDAS</th>
                                        <th style="color: #4B6EAD; vertical-align: middle;">ESCALA APLICADA</th>
                                    </tr>
                                </thead>
                                <tbody>
                @else
                    @php                    
                        $sel="";
                        $list="";
                    @endphp
                @endif

                {{-- Comprobamos si la unidad es la misma que la anterior --}}
                @if ($data->unidad == $unidadAnterior)
                    {{-- Si es la misma unidad, ocultamos la celda de "UNIDADES" --}}
                    <tr> 
                        
                        
                        <td class="ps-4 small py-0">
                            <div class="form-check mt-1">
                                <input class="form-check-input" type="checkbox" value="{{ $data->idsuc }}" name="chk1_{{ $data->idgrupo }}[]" id="chk_{{ $data->idsuc }}" style="cursor: pointer">
                                <label class="form-check-label" for="chk_{{ $data->idsuc }}" style="cursor: pointer">
                                    {{ $data->suc }}
                                </label>
                            </div>
                        </td>                        
                        <td class="text-center small"><span id="nom_escala_{{ $data->idsuc }}">{{ $data->escala }}</span></td>
                    </tr>
                @else
                    {{-- Si es una nueva unidad, mostramos la unidad y la tienda --}}
                    <tr class="table-striped"> 
                        @php
                            // Contamos el número de tiendas para esta unidad (esto lo puedes hacer en el controlador también)
                            $numeroDeTiendas = count($escala_tiendas->where('unidad', $data->unidad)); 
                        @endphp
                        <td style="color: #4B6EAD; vertical-align: middle;" class="ps-4 small" rowspan="{{ $numeroDeTiendas }}"> <!-- Rowspan para combinar las celdas de la misma unidad -->
                                
                                    {{ $data->unidad }}                       

                        </td>
                        <td class="ps-4 small py-0">
                            <div class="form-check mt-1">
                                <input class="form-check-input" type="checkbox" value="{{ $data->idsuc }}" name="chk1_{{ $data->idgrupo }}[]" id="chk_{{ $data->idsuc }}" style="cursor: pointer">
                                <label class="form-check-label" for="chk_{{ $data->idsuc }}" style="cursor: pointer">
                                    {{ $data->suc }}
                                </label>
                            </div>
                        </td>
                        <td class="text-center small"><span id="nom_escala_{{ $data->idsuc }}">{{ $data->escala }}</span></td>
                    </tr>
                @endif

                @php
                    $grupo = $data->grupo;
                    $unidadAnterior = $data->unidad;  // Actualiza la unidad anterior
                @endphp
            @endforeach

            {{-- Cierra la última tabla si hay contenido --}}
            @if ($grupo != null)
                </tbody> 
                </table> 
                </div> 
                <hr> 
            </div>
            @endif

            



        </small>
        
        
        
    </div>
  </div>


@endsection

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.th-icon').on('mouseenter', function () {
                // Oculta todos los íconos primero
                $('.icono').addClass('d-none');
                // Muestra los íconos de esta columna
                let id = $(this).data('id');
                if ($('.txt[data-id="' + id + '"]').val() == 0) {
                    $('.icono[data-id="' + id + '"]').removeClass('d-none');
                }
            });
        
            $('.th-icon').on('mouseleave', function () {
                // Opcional: Oculta los íconos al salir
                $('.icono').addClass('d-none');
            });
        });
    
        // Función para editar el tiempo de respuesta
        function edit(x) {
            let th = $('.th-icon[data-id="' + x + '"]');
            let tabla = th.closest('table');
            let numFilas = tabla.find('tbody tr').length;        
            for (let y = 1; y <= numFilas; y++) {
                let celda = $('#' + x + '-' + y);
                if (celda.length) {
                    let valor = celda.text().trim();
                    if (valor === '-') valor = 0;                
                    celda.html(`<div class="d-flex justify-content-center align-items-center py-0" style="text-align: center;">`+
                            `<input style="width: 100px;" min="0" type="number" id="t-${x}-${y}" value="${valor}" class="form-control form-control-sm text-center">`+
                        `</div>`);
                }
            }
            $('.icono').addClass('d-none');
            $('.iconos[data-id="' + x + '"]').removeClass('d-none');
            $('#e_' + x).val(1);
        }
                
        // Función para agregar nueva escala
        function add_escala(grupoId) {
            Swal.fire({
                text: 'Agregar nueva escala',
                icon: 'warning',
                html: `<input type="text" id="new_escala" class="form-control" placeholder="Nombre de la nueva escala">`,
                showCancelButton: true,
                
                confirmButtonColor: "#0d6efd",
                confirmButtonText:  '<i class="fas fa-plus-circle"></i> Agregar',
                cancelButtonText:  '<i class="fas fa-arrow-left"></i> Cancelar',
                preConfirm: () => {
                    const escala = document.getElementById('new_escala').value.trim();
                    if (!escala) {
                        Swal.showValidationMessage('Por favor, indique el nombre de la escala');
                    } else {
                        return { escala, grupoId };
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const { escala, grupoId } = result.value;

                    $.ajax({
                        url: "{{ route('escalas.store') }}",
                        type: "POST",
                        data: {
                            _token: $('input[name="_token"]').val(),
                            escala: escala,
                            grupoId: grupoId
                        },
                        success: function(response) {
                            if (response.code === 200) {
                                const id_escala = response.data.id_escala;

                                // Crear nueva columna en el encabezado
                                const newColumn = `
                                    <th style="color: #4B6EAD; vertical-align: middle; font-size: 11px;" class="px-2 th-icon" data-id="${id_escala}">
                                        ${escala} 
                                        <input class="txt" data-id="${id_escala}" type="hidden" value="0" id="e_${id_escala}">
                                        <br>
                                        <i title="Editar" class="fas fa-pencil-alt fa-lg edit d-none icono" onclick="edit('${id_escala}')" data-id="${id_escala}"></i>
                                        <i title="Guardar" class="fas fa-save fa-lg activar d-none iconos" onclick="save('${grupoId}','${id_escala}')" data-id="${id_escala}"></i>
                                        <i title="Eliminar" class="fas fa-trash-alt dell fa-lg d-none icono" onclick="del('${grupoId}','${id_escala}')" data-id="${id_escala}"></i>
                                        <div id="spin" class="spinner-border spinner-border-sm text-primary d-none" role="status"> </div>
                                    </th>
                                `;
                                for (let cl = 0; cl <= 1; cl++) {
                                    let select = $('#sel' + cl + '_' + grupoId);

                                    if (select.length > 0) {
                                        select.empty();
                                        select.append(new Option('Seleccionar escala', '', true, true));
                                        response.data.select_escalas.forEach(function(escalas) {
                                            // Filtramos las escalas que correspondan a este grupo
                                            if (escalas.idgrupo == grupoId) {
                                                select.append(new Option(escalas.nombre, escalas.id));
                                            }
                                        });
                                    }
                                }
                                $('#tbl_' + grupoId + ' thead tr').append(newColumn);

                                // Agregar celda vacía "-" a cada fila de jerarquía
                                let index = 1;
                                $('#tbl_' + grupoId + ' tbody tr').each(function () {
                                    const newCell = `<td id="${id_escala}-${index}" class="text-center py-0">-</td>`;
                                    $(this).append(newCell);
                                    index++;
                                });

                                // Vuelve a habilitar los íconos de la nueva columna
                                $('.th-icon').on('mouseenter', function () {
                                    // Oculta todos los íconos primero
                                    $('.icono').addClass('d-none');
                                    // Muestra los íconos de esta columna
                                    let id = $(this).data('id');
                                    if ($('.txt[data-id="' + id + '"]').val() == 0) {
                                        $('.icono[data-id="' + id + '"]').removeClass('d-none');
                                    }
                                });

                                $('.th-icon').on('mouseleave', function () {
                                    // Opcional: Oculta los íconos al salir
                                    $('.icono').addClass('d-none');
                                });


                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: response.message,
                                    icon: 'error'
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Hubo un error al agregar la escala.',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        }



        // Función para eliminar los datos editados
        function del(grupoId,x) {
            Swal.fire({
                text: "¿Está seguro de eliminar la escala indicada?",
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: '<i class="fas fa-arrow-left"></i> Cancelar',
                confirmButtonText: '<i class="fas fa-trash-alt"></i> Sí, eliminar',
                confirmButtonColor: "#d33",
            }).then((result) => {
                if (result.isConfirmed) {
                    let parametros = {
                        "esc": x,
                        "_token": $('input[name="_token"]').val()
                    };

                    let spinner = $('.th-icon[data-id="' + x + '"] #spin');

                    // Enviar la solicitud para eliminar la escala de la base de datos
                    $.ajax({
                        data: parametros,
                        url: "{{ route('escalas.destroy') }}",
                        type: 'POST',
                        dataType: "json",
                        beforeSend: function () {
                            spinner.removeClass('d-none');
                            $('.iconos[data-id="' + x + '"]').addClass('d-none');
                        },
                        success: function (response) {
                            spinner.addClass('d-none');


                            if (response.code == 200) {
                                
                            for (let cl = 0; cl <= 1; cl++) {
                                    let select = $('#sel' + cl + '_' + grupoId);

                                    if (select.length > 0) {
                                        select.empty();
                                        select.append(new Option('Seleccionar escala', '', true, true));
                                        response.data.select_escalas.forEach(function(escalas) {
                                            // Filtramos las escalas que correspondan a este grupo
                                            if (escalas.idgrupo == grupoId) {
                                                select.append(new Option(escalas.nombre, escalas.id));
                                            }
                                        });
                                    }
                                }
                                
                                Swal.fire({
                                    text: "Escala eliminada correctamente.",
                                    icon: "success",
                                    timer: 2000,
                                    showConfirmButton: false
                                });

                                // Eliminar la columna del encabezado
                                $('.th-icon[data-id="' + x + '"]').remove();

                                // Eliminar las celdas de esa columna en cada fila
                                $('td[id^="' + x + '-"]').remove();
                            } else {
                                Swal.fire({
                                    text: data.message || "Ocurrió un error al eliminar.",
                                    icon: "error"
                                });
                            }
                        },
                        error: function (xhr) {
                            spinner.addClass('d-none');
                            Swal.fire({
                                text: "Ocurrió un error inesperado al eliminar.",
                                icon: "error"
                            });
                        }
                    });
                }
            });
        }



        // Función para guardar los datos editados
        function save(g,x) {
            let th = $('.th-icon[data-id="' + x + '"]');
            let tabla = th.closest('table');
            let numFilas = tabla.find('tbody tr').length;
            let datos = [];

            // Recorre todas las filas de la tabla y obtiene los valores editados
            for (let y = 1; y <= numFilas; y++) {
                let input = document.getElementById(`t-${x}-${y}`);
                let inputjer = document.getElementById(`idjer_${g}-${y}`);

                if (input && inputjer) {
                    let valor = parseFloat(input.value) || 0;
                    let valorjer = parseFloat(inputjer.value) || 0;
                    datos.push({
                        idjer: valorjer,
                        tiempo: valor
                    });
                }
            }

            // Si no hay datos para guardar, mostramos un mensaje de advertencia
            if (datos.length === 0) {
                Swal.fire({
                    text: "No hay datos para guardar.",
                    icon: "warning"
                });
                return;
            }

            let parametros = {
                "esc": x,
                "datos": JSON.stringify(datos),
                "_token": $('input[name="_token"]').val()
            };

            let spinner = $('.th-icon[data-id="' + x + '"] #spin');

            // Enviar los datos editados a la base de datos usando AJAX
            $.ajax({
                data: parametros,
                url: "{{ route('escalas.store') }}",
                type: 'POST',
                dataType: "json",
                beforeSend: function () {
                    spinner.removeClass('d-none');
                    $('.iconos[data-id="' + x + '"]').addClass('d-none');
                },
                success: function (data) {
                    spinner.addClass('d-none');
                    if (data.code == 200) {
                        Swal.fire({
                            text: "Datos guardados correctamente.",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });

                        // Opcional: volver a modo lectura
                        $(`#e_${x}`).val(0);
                        $('.iconos[data-id="' + x + '"]').addClass('d-none');

                        // Actualizar la tabla con los nuevos valores guardados
                        for (let y = 1; y <= numFilas; y++) {
                            let input = document.getElementById(`t-${x}-${y}`);
                            if (input) {
                                let valor = parseFloat(input.value) || '-';
                                $(`#${x}-${y}`).html(valor);
                            }
                        }
                    } else {
                        Swal.fire({
                            text: data.message || "Ocurrió un error al guardar.",
                            icon: "error"
                        });
                    }
                },
                error: function (xhr) {
                    spinner.addClass('d-none');
                    let errorMsg = "Ocurrió un error inesperado.";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        text: errorMsg,
                        icon: "error"
                    });
                }
            });
        }

        function edita_escala(idgrupo, idescala,cl) {
            // Desmarcamos todos los checkboxes del grupo
            $('input[name="chk'+cl+'_' + idgrupo + '[]"]').prop('checked', false);
            
            if(idescala>0)
            {
                $.ajax({
                url: "{{ route('escalas.show') }}",
                type: "POST",
                data: {
                    _token: $('input[name="_token"]').val(),
                    idgrupo: idgrupo,
                    idescala: idescala
                },
                beforeSend: function() {
                    // Puedes mostrar un loader o bloquear la UI aquí si querés
                    console.log("Enviando solicitud para grupo: " + idgrupo + ", escala: " + idescala);
                },
                success: function(response) {
                    if (response.code === 200) {


                        // Marcamos los checkboxes que vienen en la respuesta
                        response.data.unidades.forEach(function(unidad) {

                            $('#chk_' + unidad.id_unidad).prop('checked', true);
                        });

                        console.log('Unidades actualizadas:', response.data.unidades);
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.message || 'No se pudo obtener la información de la escala.',
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud:", error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Hubo un error al buscar la escala. Código HTTP: ' + xhr.status,
                        icon: 'error'
                    });
                }
            });
            }
        }

        function aplica_escala(idgrupo, cl)
        {
            idescala=$('#sel'+cl+'_'+idgrupo).val();

            let selechk = [];
            $('input[name="chk'+cl+'_' + idgrupo + '[]"]:checked').each(function () {
                selechk.push($(this).val());
            });

            if(selechk.length>0)
            {
                $.ajax({
                    url: "{{ route('escalas.update') }}",
                    type: "POST",
                    data: {
                        _token: $('input[name="_token"]').val(),
                        idgrupo: idgrupo,
                        idescala: idescala,
                        cl: cl,
                        selechk: selechk,
                    },
                    beforeSend: function() {
                        // Puedes mostrar un loader o bloquear la UI aquí si querés
                        console.log("Enviando solicitud para grupo: " + idgrupo + ", cl: " + cl);
                    },
                    success: function(response) {
                        if (response.code === 200) {


                           Swal.fire({
                            text: response.message,
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                            });

                            response.data.unidades_escala.forEach(function(unidad) {
                                if(unidad.escala==null)
                                {   $('#nom_escala_' + unidad.idunidad).html('');}
                                else
                                {   $('#nom_escala_' + unidad.idunidad).html(unidad.escala);}
                            });

                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message || 'No se pudo obtener la información de la escala.',
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error en la solicitud:", error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Hubo un error al buscar la escala. Código HTTP: ' + xhr.status,
                            icon: 'error'
                        });
                    }
                });
            }
        }

    </script>
    