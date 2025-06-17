<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Vista Previa y Mapeo de Columnas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <h3 class="mb-4 text-lg font-medium">Vista previa del archivo</h3>

                <!-- Muestra la vista previa de las primeras filas -->
                <table class="w-full text-sm border">
                    <thead class="bg-gray-100">
                        <tr>
                            @foreach ($headers as $header)
                                <th class="px-2 py-1 border">{{ $header }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($preview as $row)
                            <tr>
                                @foreach ($row as $cell)
                                    <td class="px-2 py-1 border">{{ $cell }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Formulario para que el usuario haga el mapeo -->
                <form action="{{ route('upload.map') }}" method="POST" class="mt-6 space-y-4">
                    @csrf
                    <input type="hidden" name="file" value="{{ $file }}">
                    <input type="hidden" name="tabla" value="{{ $tabla }}"> <!-- CAMBIO AQUÍ -->

                    <h3 class="text-lg font-medium">Mapeo de columnas</h3>
                    @foreach ($headers as $header)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">{{ $header }}</label>
                            <select name="mappings[{{ $header }}]" class="block w-full border-gray-300 rounded">
                                <option value="">-- No importar --</option>
                                @foreach ($tableColumns as $col)
                                    <option value="{{ $col }}">{{ $col }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach

                    <x-primary-button>
                        {{ __('Confirmar e Insertar Datos') }}
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
