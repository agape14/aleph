<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SolicitudCreadaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre;
    public $apellido;
    public $id;
    public $url_alternativa;
    public $usuario;
    public function __construct($nombre, $apellido, $id, $url_alternativa,$usuario)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->id = $id;
        $this->url_alternativa = $url_alternativa;
        $this->usuario = $usuario;
    }

    public function build()
    {
        return $this->subject('Nueva Solicitud de Beca Registrada')
                    ->view('notifications.solicitud-creada');
    }

}
