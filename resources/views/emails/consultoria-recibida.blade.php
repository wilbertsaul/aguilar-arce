<x-mail::message>
# Nueva Solicitud de Consultoría

Se ha recibido una nueva solicitud de consultoría a través del sitio web.

**Nombre:** {{ $consultoria->nombre }}
**Email:** {{ $consultoria->email }}
@if($consultoria->empresa_ruc)
**Empresa / RUC:** {{ $consultoria->empresa_ruc }}
@endif
@if($consultoria->whatsapp)
**WhatsApp:** {{ $consultoria->whatsapp }}
@endif
@if($consultoria->etapa)
**Etapa:** {{ ['empezando' => 'Estoy empezando', 'operando' => 'Ya estoy operando', 'crecer' => 'Quiero crecer y controlar'][$consultoria->etapa] ?? $consultoria->etapa }}
@endif
@if($consultoria->requerimientos)
**Requerimientos:** {{ $consultoria->requerimientos }}
@endif

**Mensaje:**
{{ $consultoria->mensaje }}

<br>

Saludos,<br>
{{ config('app.name') }}
</x-mail::message>
