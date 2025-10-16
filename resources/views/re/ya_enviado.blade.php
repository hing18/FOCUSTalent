@extends('layouts.public')

@section('content')
<div class="container pt-5 my-5 d-flex justify-content-center">
    <div class="card shadow-lg border-0 rounded-4 text-center p-5" style="max-width: 700px;">
        <div class="card-body">
            <i class="fa-solid fa-circle-exclamation text-warning fa-4x mb-3"></i>
            <h3 class="fw-bold mb-3">Encuesta ya respondida</h3>
            <p class="text-muted">
                Usted ya ha enviado esta encuesta previamente.  
                Muchas gracias por su participación.
            </p>
            <a href="{{ url('/') }}" class="btn btn-outline-primary rounded-pill mt-3 px-4">
                <i class="fa-solid fa-house"></i> Ir al inicio
            </a>
        </div>
    </div>
</div>
@endsection
