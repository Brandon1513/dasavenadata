<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Detalle de Importación') }}
        </h2>
    </x-slot>

    <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">

        <div class="p-6 mb-6 bg-white rounded-lg shadow">
            <strong>Tabla:</strong> {{ $importacion->tabla }} <br>
            <strong>Archivo:</strong> {{ $importacion->archivo_original }} <br>
            <strong>Filas Importadas:</strong> {{ $importacion->filas_importadas }} <br>
            <strong>Usuario:</strong> {{ $importacion->user->name }} <br>
            <strong>Fecha:</strong> {{ $importacion->created_at->format('d/m/Y H:i') }}
        </div>

        <div class="p-6 bg-white rounded-lg shadow-sm">
            <h3 class="mb-4 text-lg font-medium">Primeras filas importadas</h3>

            @if ($datos->isEmpty())
                <p class="text-gray-600">No se encontraron datos correspondientes a esta importación.</p>
            @else
                <div class="overflow-auto">
                    <table class="min-w-full border border-collapse">
                        <thead class="bg-gray-100">
                            <tr>
                                @foreach (array_keys((array) $datos->first()) as $col)
                                    <th class="px-2 py-1 text-sm text-left border">{{ $col }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datos as $fila)
                                <tr>
                                    @foreach ((array) $fila as $valor)
                                        <td class="px-2 py-1 text-xs border">{{ $valor }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <div class="mt-6">
                <a href="{{ route('importaciones.historial') }}" class="text-blue-600 hover:underline">← Volver al historial</a>
            </div>
        </div>
    </div>
</x-app-layout>
