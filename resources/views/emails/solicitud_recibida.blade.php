@component('mail::message')
# Solicitud recibida

Estimado(a) **{{ $solicitud->jefe_nombre }}**,  

Nos complace confirmar que su **solicitud de contratación** para el puesto de **{{ $solicitud->puesto }}** ha sido **recibida exitosamente** por nuestro equipo de Gestión de Talento.

La solicitud será revisada y procesada conforme a los procedimientos establecidos.  
Si se requiere información adicional, el equipo de Gestión de Talento se pondrá en contacto con usted directamente.

**Fecha de envío:** {{ $solicitud->fecha_envio->format('d/m/Y') }}

Gracias,<br>
Grupo Regency<br> 
Dirección Corporativa de Gente y Organización
@endcomponent

