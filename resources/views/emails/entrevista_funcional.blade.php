@php
use Carbon\Carbon;

Carbon::setLocale('es');

$carbonFecha = Carbon::parse($fecha);
$fecha_larga = $carbonFecha->translatedFormat('l j \\d\\e F \\d\\e Y');

$carbonHora = Carbon::createFromFormat('H:i', $hora);
$hora_12h = $carbonHora->format('g:i A');
@endphp

@component('mail::message')
# Entrevista programada

Hola,

Se ha programado la siguiente entrevista:

- **Candidato:** {{ $nom_candidato }}
- **Puesto:** {{ $puesto }}
- **Fecha:** {{ $fecha_larga }}
- **Hora:** {{ $hora_12h }}
- **Lugar:** {{ $lugar }}
- **Comentarios:** {{ $comentarios ?? 'N/A' }}

Puedes agregarla a tu calendario abriendo el archivo adjunto.

Gracias,<br>
Grupo Regency<br>
Dirección Corporativa de Gente y Organización
@endcomponent
 