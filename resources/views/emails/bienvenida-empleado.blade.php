@component('mail::message')
# Hola {{ $empleado->name }}!

Tu cuenta ha sido creada en la plataforma de validación de archivos.

Aquí están tus credenciales de acceso:

**Usuario:** {{ $empleado->email }}  
**Contraseña temporal:** {{ $password }}  
**Rol asignado:** {{ $rol }}

> Por seguridad, deberás cambiar tu contraseña una vez hayas iniciado sesión.

@component('mail::button', ['url' => url('/login')])
Iniciar sesión
@endcomponent

Gracias por usar nuestra plataforma.

Saludos,  
{{ config('app.name') }}
@endcomponent
