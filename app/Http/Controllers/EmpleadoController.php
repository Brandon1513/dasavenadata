<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Notifications\UsuarioCreadoNotification;
use Illuminate\Support\Str;


class EmpleadoController extends Controller
{
  public function index(Request $request)
{
    $query = User::with('departamento');

    if ($request->has('search') && $request->search) {
        $query->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%');
    }

    $users = $query->paginate(10); // Mantén la paginación como antes

    return view('empleados.index', compact('users'));
}


    public function create()
    {
        $departamentos = Departamento::all();
        $roles = Role::all();
        return view('empleados.create', compact('departamentos', 'roles'));
    }

    


public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed',
        'departamento_id' => 'required|exists:departamentos,id',
        'roles' => 'required|array',
        'roles.*' => 'exists:roles,name',
    ]);

    $passwordTemporal = $request->password; // ya viene desde el formulario

    $empleado = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'departamento_id' => $request->departamento_id,
        'password' => bcrypt($passwordTemporal),
    ]);

    $empleado->syncRoles($request->roles);

    // Enviar notificación por correo
    $empleado->notify(new UsuarioCreadoNotification($empleado, $passwordTemporal));

    return redirect()->route('empleados.index')->with('success', 'Empleado creado correctamente.');
}


    public function edit(User $empleado)
{
    $departamentos = Departamento::all();
    $roles = Role::all();

    return view('empleados.edit', compact('empleado', 'departamentos', 'roles'));
}

public function update(Request $request, User $empleado)
{
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email,' . $empleado->id,
        'departamento_id' => 'required|exists:departamentos,id',
        'roles' => 'required|array',
        'roles.*' => 'exists:roles,name',
        'password' => 'nullable|confirmed'
    ]);

    $empleado->name = $request->name;
    $empleado->email = $request->email;
    $empleado->departamento_id = $request->departamento_id;

    if ($request->filled('password')) {
        $empleado->password = bcrypt($request->password);
    }

    $empleado->save();

    $empleado->syncRoles($request->roles);

    return redirect()->route('empleados.index')->with('success', 'Empleado actualizado correctamente.');
}


    public function toggle(User $empleado)
    {
        $empleado->activo = !$empleado->activo;
        $empleado->save();

        return redirect()->back()->with('success', 'Estado del usuario actualizado.');
    }
    // Agrega métodos para editar, actualizar, eliminar si quieres.

    public function reenviarCorreo(User $empleado)
{
    // 1. Generar nueva contraseña
    $nuevaPassword = Str::random(10);

    // 2. Actualizar la contraseña encriptada
    $empleado->password = bcrypt($nuevaPassword);
    $empleado->save();

    // 3. Obtener el rol asignado (por simplicidad, tomamos el primero)
    $rol = $empleado->getRoleNames()->first();

    // 4. Enviar correo
    Mail::to($empleado->email)->send(new \App\Mail\BienvenidaEmpleadoMail($empleado, $nuevaPassword, $rol));

    return back()->with('success', 'Correo de bienvenida enviado correctamente con nueva contraseña.');
}
}
