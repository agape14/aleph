<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SolicitudCreadaNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $solicitud;

    public function __construct($solicitud)
    {
        $this->solicitud = $solicitud;
    }

    /**
     * Obtener los canales de notificación.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Crear el mensaje de correo.
     */

        /*
        return (new MailMessage)
            ->subject('Nueva Solicitud de Beca Registrado')
            ->greeting('Hola, ' . $notifiable->name)
            ->line('Se ha registrado una nueva solicitud de beca.')
            ->line('Detalles de la solicitud:')
            ->line('Nombre: ' . $this->solicitud->estudiante->nombres)
            ->line('Apellido: ' . $this->solicitud->estudiante->apepaterno. ' ' .  $this->solicitud->estudiante->apematerno)
            ->action('Ver Solicitud', url('/solicitudes/' . $this->solicitud->id))
            ->line('Si tienes problemas al hacer clic en el botón "Ver Solicitud", copia y pega la siguiente URL en tu navegador:')
            ->line(url('/solicitudes/' . $this->solicitud->id))
            ->salutation('Saludos, Mi Empresa') // Cambiar el "Regards, Laravel"
            ->with(['logo_url' => asset('images/Aleph-school.png')]);
        */
    public function toMail($notifiable)
    {
        $url = url('/solicitudes/' . $this->solicitud->id);

        return (new MailMessage)
            ->subject('Nueva Solicitud Creada')
            ->view('notifications.solicitud-creada', [
                'url' => $url,
                'logo_url' => asset('images/logo.png')
            ]);
    }

    /**
     * Configuración para otras representaciones como SMS.
     */
    public function toArray($notifiable)
    {
        return [
            'id' => $this->solicitud->id,
            'nombre' => $this->solicitud->estudiante->nombres. ' ' . $this->solicitud->estudiante->apepaterno. ' ' .  $this->solicitud->estudiante->apematerno,
        ];
    }
}
