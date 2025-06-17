<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Carga Masiva de Archivos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Mensaje de éxito -->
            @if (session('success'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Errores de validación -->
            @if ($errors->any())
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                    <ul class="pl-5 list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('upload.file') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <!-- Selector dinámico de tablas permitidas -->
                        <div>
                            <x-input-label for="tabla" :value="__('Departamento / Tabla de destino')" />
                            <select name="tabla" id="tabla"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- Seleccione --</option>
                                @foreach ($tablasPermitidas as $tabla)
                                    <option value="{{ $tabla }}">{{ ucfirst(str_replace('_', ' ', $tabla)) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Subir archivo -->
                        <div>
                            <x-input-label for="file" :value="__('Archivo (Excel o CSV)')" />
                            <input type="file" name="file" id="file"
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm"
                                   required>
                        </div>

                        <!-- Botón -->
                        <div>
                            <x-primary-button>
                                {{ __('Subir y Cargar') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
