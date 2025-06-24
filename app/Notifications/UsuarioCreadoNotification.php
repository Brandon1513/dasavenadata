<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UsuarioCreadoNotification extends Notification
{
    use Queueable;

    protected $usuario;
    protected $password;

    public function __construct($usuario, $password)
    {
        $this->usuario = $usuario;
        $this->password = $password;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Bienvenido a la plataforma')
            ->greeting('Hola ' . $this->usuario->name . '!')
            ->line('Tu cuenta ha sido creada en la plataforma de validación de archivos.')
            ->line('Aquí están tus credenciales de acceso:')
            ->line('**Usuario:** ' . $this->usuario->email)
            ->line('**Contraseña temporal:** ' . $this->password)
            ->line('**Rol asignado:** ' . $this->usuario->getRoleNames()->first())
            ->line('Por seguridad, deberás cambiar tu contraseña una vez hayas iniciado sesión.')
            ->action('Iniciar sesión', url('/login'))
            ->line('Gracias por usar nuestra plataforma.');
    }
}
