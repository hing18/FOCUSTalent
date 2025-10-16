<p>Estimado/a,</p>

<p>Nos complace informarle que el proceso de contratación para el puesto <strong>{{ $puesto }}</strong> ha concluido exitosamente.</p>

<p>Los colaboradores seleccionados son:</p>
<ul>
@foreach ($empleados as $emp)
    <li>{{ $emp->prinombre ?? 'N/A' }} {{ $emp->segnombre ?? '' }} {{ $emp->priapellido ?? '' }} {{ $emp->segapellido ?? '' }}</li>
@endforeach
</ul>

<p>Le solicitamos cordialmente que complete la <strong>evaluación del proceso de reclutamiento</strong> para ayudarnos a mejorar continuamente nuestro servicio.</p>

<p style="text-align: center; margin: 20px 0;">
    <a href="{{ $url }}" style="display: inline-block; background-color: #0d6efd; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 8px; font-weight: bold;">
        -> Evalue nuestro servicio ingresando Aquí
    </a>
</p>

<p>Agradecemos de antemano su colaboración y el tiempo dedicado a proporcionarnos su retroalimentación.</p>

<p>Atentamente,<br>
<strong>Dirección de Gente y Organización</strong></p>
