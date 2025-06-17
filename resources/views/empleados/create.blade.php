<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Agregar Empleado') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            <div class="p-6 bg-white rounded shadow">
                <form method="POST" action="{{ route('empleados.store') }}">
                    @csrf

                    <!-- Nombre -->
                    <div>
                        <x-input-label for="name" :value="__('Nombre completo')" />
                        <x-text-input id="name" name="name" type="text" class="block w-full mt-1" required autofocus />
                    </div>

                    <!-- Correo -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Correo electrónico')" />
                        <x-text-input id="email" name="email" type="email" class="block w-full mt-1" required />
                    </div>

                    <!-- Departamento -->
                    <div class="mt-4">
                        <x-input-label for="departamento_id" :value="__('Departamento')" />
                        <select name="departamento_id" id="departamento_id" class="block w-full mt-1 border-gray-300 rounded">
                            @foreach ($departamentos as $departamento)
                                <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Contraseña -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Contraseña')" />
                        <x-text-input id="password" name="password" type="password" class="block w-full mt-1" required />
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="block w-full mt-1" required />
                    </div>

                    <!-- Roles (checkboxes) -->
                    <div class="mt-4">
                        <x-input-label :value="__('Roles')" />
                        <div class="flex flex-wrap gap-2 mt-1">
                            @foreach ($roles as $role)
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                           class="text-blue-600 border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200">
                                    <span class="ml-2 text-sm text-gray-700">{{ ucfirst($role->name) }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-6">
                        <x-primary-button>
                            {{ __('Guardar') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
