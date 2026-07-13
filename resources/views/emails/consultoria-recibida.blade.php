<x-mail::message>
# Nueva Solicitud de Consultoría

Se ha recibido una nueva solicitud de consultoría a través del sitio web.

**Nombre:** {{ $consultoria->nombre }}
**Email:** {{ $consultoria->email }}

**Mensaje:**
{{ $consultoria->mensaje }}

<br>

Saludos,<br>
{{ config('app.name') }}
</x-mail::message>
