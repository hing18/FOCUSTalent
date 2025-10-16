@extends('layouts.public')

@section('content')
<div class="container pt-5 my-5 d-flex justify-content-center">
    <div class="card shadow-lg border-0 rounded-4 w-100" style="max-width: 900px;">
        <!-- Header -->
        <div class="card-header bg-primary text-white rounded-top-4">
            <h5 class="mb-0">
                <i class="fa-solid fa-list-check fa-lg pe-3"></i>
                Encuesta de Satisfacción del Servicio de Reclutamiento
            </h5>
        </div>

        <!-- Body -->
        <div class="card-body p-4">
            <p class="text-muted">
                Por favor, califique su nivel de satisfacción con el servicio de reclutamiento interno utilizando la siguiente escala:
            </p>
            <form id="formEvaluacion" action="{{ url('/evaluacion-reclutamiento/'.$token) }}" method="POST" class="mt-4">
                @csrf

                @php
                    $preguntas = [
                        "Evalúe la claridad y utilidad de la retroalimentación proporcionada durante el proceso de reclutamiento.",
                        "Indique su nivel de satisfacción con el trato recibido por parte de la reclutadora durante el proceso.",
                        "Considere la disponibilidad de la reclutadora para atender consultas y dar seguimiento al proceso.",
                        "Valore la frecuencia y oportunidad de las actualizaciones recibidas sobre el avance del proceso de reclutamiento.",
                        "En términos generales, ¿Cómo calificaría el servicio de reclutamiento recibido?"
                    ];

                    $significados = [
                        1 => 'Muy insatisfecho',
                        2 => 'Insatisfecho',
                        3 => 'Ligeramente satisfecho',
                        4 => 'Satisfecho',
                        5 => 'Muy satisfecho',
                    ];
                @endphp

                @foreach($preguntas as $index => $texto)
                    <div class="mb-5">
                        <label class="form-label fw-semibold">{{ $index+1 }}. {{ $texto }}</label>
                        <div class="d-flex justify-content-between mt-3">
                            @for ($j = 1; $j <= 5; $j++)
                                <div class="form-check form-check-inline text-center" style="flex:1;">
                                    <input class="form-check-input radio-circle" type="radio"
                                           name="pregunta{{ $index+1 }}" 
                                           id="p{{ $index+1 }}_{{ $j }}" 
                                           value="{{ $j }}">
                                    <label class="form-check-label d-block" for="p{{ $index+1 }}_{{ $j }}">
                                        <div class="circle-number h5">{{ $j }}</div>
                                        <small class="text-muted">{{ $significados[$j] }}</small>
                                    </label>
                                </div>
                            @endfor
                        </div>
                        <hr>
                    </div>
                    
                @endforeach

                <div class="mb-4">
                    <label class="form-label fw-semibold">Comentarios adicionales:</label>
                    <textarea name="comentarios" class="form-control rounded-3" rows="4" placeholder="Escriba sus comentarios aquí..."></textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4 rounded-pill shadow-sm">
                        <i class="fa-solid fa-share fa-lg pe-2"></i>   Enviar Evaluación
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Círculo con número estilo Microsoft Forms */
.radio-circle {
    display: none; /* ocultamos radio original */
}

.radio-circle + label .circle-number {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 2px solid #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 5px auto;
    font-weight: 600;
    color: #6c757d;
    transition: all 0.3s;
}

.radio-circle:checked + label .circle-number {
    background-color: #0d6efd;
    color: white;
    border-color: #0d6efd;
}

/* Hover efecto profesional */
.radio-circle + label:hover .circle-number {
    border-color: #0d6efd;
    color: #0d6efd;
    cursor: pointer;
}

/* Texto debajo del número */
.radio-circle + label small {
    display: block;
    font-size: 1rem;
    margin-top: 3px;
    color: #6c757d;
}

/* Responsive: en móvil reducir tamaño de círculos */
@media (max-width: 576px) {
    .radio-circle + label .circle-number {
        width: 40px;
        height: 40px;
        font-size: 0.9rem;
    }
}
</style>
<script>
document.querySelector("form").addEventListener("submit", function(e) {
    let faltante = null;

    for (let i = 1; i <= 5; i++) {
        const opciones = document.querySelectorAll(`input[name="pregunta${i}"]`);
        let contestada = false;
        opciones.forEach(op => {
            if (op.checked) contestada = true;
        });

        if (!contestada) {
            faltante = i;
            break;
        }
    }

    if (faltante) {
        e.preventDefault();

        const preguntaDiv = document.querySelector(`input[name="pregunta${faltante}"]`).closest('div.mb-5');
        preguntaDiv.classList.add('pregunta-faltante');

        Swal.fire({
            icon: 'warning',
            title: 'Falta responder',
            text: `Por favor responda la pregunta ${faltante} antes de enviar.`
        }).then(() => {
            // Pequeño retraso antes de scroll
            setTimeout(() => {
                preguntaDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 300); // 100ms funciona bien
            // Quitar el resalte después de 3s
            setTimeout(() => {
                preguntaDiv.classList.remove('pregunta-faltante');
            }, 3000);
        });
    }
});

</script>
@endsection
