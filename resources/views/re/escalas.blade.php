<!DOCTYPE html>
@extends('layouts.plantilla')

@section('title','Escalas de Tiempo de Respuesta')
<div class="pagetitle">

@section('content')
    <h1 class="text-secondary">Reclutamiento</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"style="font-weight: normal;">Tiempo de Respuesta en la Contratación</li>
        <li class="breadcrumb-item" style="color: #4B6EAD">Escalas</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <hr>
  
<small>
  @php
    $grupo = null;
    $escala = null;
@endphp

@php $x=0; @endphp
@foreach($grupos as $data)
    @if ($grupo != $data->grupo)
        {{-- Cierra la tabla anterior si ya se abrió una --}}
        @if ($grupo != null)
            </tbody> </table> </div>
        </div>
        @endif

        {{-- Abre un nuevo grupo --}}
        <div class="row"><div class="col-auto">
            <h5 class="my-4" style="color: #4B6EAD">{{ $data->grupo }}</h5>
            <table class="table table-sm table-striped-columns table-hover mx-auto">
                <thead>
                    <tr class="text-center table-primary">
                        <th style="color: #4B6EAD; vertical-align: middle;">JERARQUÍA</th>
                        {{-- Mostrar todas las escalas del grupo correspondiente --}}
                        @foreach($escalas as $dataes)
                            @if($dataes->id_grupo == $data->id_grupo)
                                {{-- Mostrar la escala solo si no se ha mostrado antes --}}
                                @if ($escala != $dataes->nom_escala)
                                    @if ($dataes->id_escala!=null)
                                    <th style="color: #4B6EAD; vertical-align: middle;" class="px-2 th-icon" data-id="{{ $dataes->id_escala }}">
                                        {{ $dataes->nom_escala }} <input class="txt" data-id="{{ $dataes->id_escala }}" type="hidden" value="0" id="e_{{ $dataes->id_escala }}">
                                        <br>
                                        <i title="Editar" class="fas fa-pencil-alt fa-fw edit fa-lg d-none icono" onclick="edit('{{ $dataes->id_escala }}')" data-id="{{ $dataes->id_escala }}"></i>
                                        <i title="Guardar" title="Guardar" class="fas fa-save fa-fw activar fa-lg d-none iconos" onclick="save('{{ $dataes->id_escala }}')" data-id="{{ $dataes->id_escala }}"></i>
                                        <i title="Eliminar" title="Eliminar" class="fas fa-trash-alt dell fa-fw fa-lg d-none icono" data-id="{{ $dataes->id_escala }}"></i>
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
        <td class="ps-4">{{ $data->jerarquia }}<input type="hidden" value="{{ $data->id_jerarquia }}" id="{{ 'idjer_'.$x }}"></td>
        
       
        @foreach($escalas as $dataes)
            @if($dataes->id_grupo == $data->id_grupo)
                @if ($dataes->id_escala!=null)
                    @if ($dataes->idjer == $data->id_jerarquia)
                        <td id="{{ $dataes->id_escala."-".$x }}" class="text-center">{{ $dataes->tiempo ?? '-' }}</td>
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
                    celda.html(`
                        <div class="d-flex justify-content-center align-items-center" style="text-align: center;">
                            <input style="width: 100px;" min="0" type="number" id="t-${x}-${y}" value="${valor}" class="form-control form-control-sm text-center">
                        </div>
                    `);
                }
            }
            $('.icono').addClass('d-none');
            $('.iconos[data-id="' + x + '"]').removeClass('d-none');
            $('#e_' + x).val(1);
        }
    
        // Función para guardar los datos editados
        function save(x) {
            let th = $('.th-icon[data-id="' + x + '"]');
            let tabla = th.closest('table');
            let numFilas = tabla.find('tbody tr').length;    
            var datos = [];
            
            for (let y = 1; y <= numFilas; y++) {
                let input = document.getElementById(`t-${x}-${y}`);
                let inputjer = document.getElementById(`idjer_${y}`);
    
                if (input && inputjer) {
                    let valor = parseFloat(input.value) || 0;
                    let valorjer = parseFloat(inputjer.value) || 0;
                    datos.push({
                        id_escala: x,
                        idjer: valorjer,
                        tiempo: valor
                    });
                }
            }
    
            let json = JSON.stringify(datos);
            console.log(json);  // Aquí se muestra el JSON generado en la consola.
            
            // Aquí puedes hacer una petición AJAX para enviar el JSON al servidor si es necesario:
            // Example AJAX request
            // fetch('/your-endpoint', {
            //     method: 'POST',
            //     headers: {
            //         'Content-Type': 'application/json',
            //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            //     },
            //     body: json
            // })
            // .then(response => response.json())
            // .then(data => console.log(data))
            // .catch(error => console.error('Error:', error));
        }
    </script>
    