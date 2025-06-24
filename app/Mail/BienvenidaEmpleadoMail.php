<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BienvenidaEmpleadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $empleado;
    public $password;
    public $rol;

    public function __construct(User $empleado, $password, $rol)
    {
        $this->empleado = $empleado;
        $this->password = $password;
        $this->rol = $rol;
    }

    public function build()
    {
        return $this->subject('Bienvenido a la plataforma')
                    ->markdown('emails.bienvenida-empleado');
    }
}
