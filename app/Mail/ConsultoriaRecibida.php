<?php

namespace App\Mail;

use App\Models\Consultoria;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConsultoriaRecibida extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Consultoria $consultoria,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nueva Solicitud de Consultoría - ' . $this->consultoria->nombre,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.consultoria-recibida',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
