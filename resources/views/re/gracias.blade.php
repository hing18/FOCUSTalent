@extends('layouts.public')

@section('content')
<div class="container pt-5 my-5 d-flex justify-content-center">
    <div class="card shadow-lg border-0 rounded-4 text-center p-5" style="max-width: 700px;">
        <div class="card-body">
            <i class="fa-solid fa-circle-check text-success fa-4x mb-3"></i>
            <h3 class="fw-bold mb-3">¡Gracias por su evaluación!</h3>
            <p class="text-muted">
                Sus respuestas han sido registradas exitosamente.  
                Su opinión es muy valiosa para mejorar nuestro servicio.
            </p>
            <a href="{{ url('/') }}" class="btn btn-primary rounded-pill mt-3 px-4 shadow-sm">
                <i class="fa-solid fa-house"></i> Volver al inicio
            </a>
        </div>
    </div>
</div>
@endsection
