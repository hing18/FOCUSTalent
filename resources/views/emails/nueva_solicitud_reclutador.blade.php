@component('mail::message')
# Nueva Solicitud de Contratación

Estimado(a) **Reclutador**,  

Se ha recibido una nueva **solicitud de contratación** que requiere su atención.

**Detalles de la solicitud:**

- Solicitante: **{{ $solicitud->jefe_nombre }}**
- Puesto: **{{ $solicitud->puesto }}**
- Fecha de envío: **{{ \Carbon\Carbon::parse($solicitud->fecha_envio)->format('d/m/Y') }}**
- Comentarios: **{{ $solicitud->comentarios ?? 'N/A' }}**
- Cantidad solicitada: **{{ $solicitud->cantidad ?? 'N/A' }}**

Por favor, revise y gestione la solicitud según los procedimientos establecidos.


Gracias,<br>
Grupo Regency<br>
Dirección Corporativa de Gente y Organización
@endcomponent
