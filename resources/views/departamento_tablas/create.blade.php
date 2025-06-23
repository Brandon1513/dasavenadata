<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Asignar Tabla a Departamento
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            <div class="p-6 bg-white rounded shadow">
                <form method="POST" action="{{ route('departamento.tablas.store') }}">
                    @csrf

                    <!-- Departamento -->
                    <div>
                        <x-input-label for="departamento_id" :value="__('Departamento')" />
                        <select name="departamento_id" id="departamento_id" class="block w-full mt-1 border-gray-300 rounded">
                            <option disabled selected>Selecciona un departamento</option>
                            @foreach ($departamentos as $dep)
                                <option value="{{ $dep->id }}">{{ $dep->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Nombre de Tabla -->
                    <div class="mt-4">
                        <x-input-label for="tabla" :value="__('Nombre de Tabla')" />
                        <select name="tabla" id="tabla" class="block w-full mt-1 border-gray-300 rounded">
                            <option disabled selected>Selecciona una tabla</option>
                            @foreach ($tablas as $tabla)
                                <option value="{{ $tabla }}">{{ $tabla }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Botón -->
                    <div class="mt-6">
                        <x-primary-button>
                            Guardar Relación
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
