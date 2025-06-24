<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Editar Empleado') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white rounded shadow">
                <!-- Mensaje de éxito -->
                @if (session('success'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Errores de validación -->
                @if ($errors->any())
                    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded" role="alert">
                        <ul class="pl-5 list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('empleados.update', $empleado) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Nombre -->
                    <div>
                        <x-input-label for="name" :value="__('Nombre completo')" />
                        <x-text-input id="name" name="name" type="text" class="block w-full mt-1"
                                       value="{{ old('name', $empleado->name) }}" required autofocus />
                    </div>

                    <!-- Correo electrónico -->
                    <div>
                        <x-input-label for="email" :value="__('Correo electrónico')" />
                        <x-text-input id="email" name="email" type="email" class="block w-full mt-1"
                                       value="{{ old('email', $empleado->email) }}" required />
                    </div>

                    <!-- Departamento -->
                    <div>
                        <x-input-label for="departamento_id" :value="__('Departamento')" />
                        <select name="departamento_id" id="departamento_id"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                            @foreach ($departamentos as $departamento)
                                <option value="{{ $departamento->id }}"
                                    {{ $empleado->departamento_id == $departamento->id ? 'selected' : '' }}>
                                    {{ $departamento->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Roles (checkboxes) -->
                    <div>
                        <x-input-label :value="__('Roles')" />
                        <div class="flex flex-wrap gap-2 mt-1">
                            @foreach ($roles as $role)
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                        {{ $empleado->hasRole($role->name) ? 'checked' : '' }}
                                        class="text-blue-600 border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200">
                                    <span class="ml-2 text-sm text-gray-700">{{ ucfirst($role->name) }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>


                    <!-- Contraseña -->
                    <div>
                        <x-input-label for="password" :value="__('Contraseña (opcional)')" />
                        <x-text-input id="password" name="password" type="password" class="block w-full mt-1" />
                        <p class="mt-1 text-xs text-gray-500">Si no deseas cambiar la contraseña, deja este campo vacío.</p>
                    </div>

                    <!-- Confirmar contraseña -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                                       class="block w-full mt-1" />
                    </div>
                    

                    <!-- Botón -->
                    <div>
                        <x-primary-button>
                            {{ __('Guardar Cambios') }}
                        </x-primary-button>
                    </div>
                </form>
                <form action="{{ route('empleados.reenviarCorreo', $empleado->id) }}" method="POST" class="mt-3">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                Reenviar correo de bienvenida
                            </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
