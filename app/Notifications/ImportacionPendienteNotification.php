<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ImportacionPendienteNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
   public $importacion;

    public function __construct($importacion)
    {
        $this->importacion = $importacion;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nueva importación pendiente de validación')
            ->greeting('Hola ' . $notifiable->name . ',')
            ->line('Se ha subido una nueva importación a la tabla: ' . $this->importacion->tabla)
            ->action('Revisar Importaciones', route('importaciones.validar')) // crea esta ruta luego
            ->line('Gracias por tu colaboración.');
    }



    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
