<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Agregar Departamento') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto">
            <div class="p-6 bg-white rounded shadow">
                <form method="POST" action="{{ route('departamentos.store') }}">
                    @csrf

                    <div>
                        <x-input-label for="nombre" :value="__('Nombre del Departamento')" />
                        <x-text-input id="nombre" name="nombre" type="text" class="block w-full mt-1" required autofocus />
                        @error('nombre')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
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
