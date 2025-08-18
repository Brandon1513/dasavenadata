<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Vista previa — {{ $importacion->nombre_original ?? $importacion->archivo_original }}
            </h2>

            <div class="flex items-center gap-2">
                <a href="{{ route('importaciones.download', $importacion) }}"
                   class="inline-flex items-center px-4 py-2 text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                    Descargar archivo
                </a>
                <a href="{{ url()->previous() }}"
                   class="inline-flex items-center px-4 py-2 text-indigo-700 rounded-lg bg-indigo-50 hover:bg-indigo-100">
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow sm:rounded-lg">
                @if(session('error'))
                    <div class="p-3 mb-4 text-sm text-red-800 border border-red-200 rounded bg-red-50">
                        {{ session('error') }}
                    </div>
                @endif

                @if(empty($rows) || $rows->isEmpty())
                    <p class="text-sm text-gray-600">No hay datos para mostrar.</p>
                @else
                    <div class="overflow-auto border border-gray-200 rounded">
                        <table class="min-w-full text-sm">
                            @if(!empty($headers))
                                <thead class="sticky top-0 z-10 bg-gray-100">
                                    <tr>
                                        @foreach($headers as $h)
                                            <th class="px-3 py-2 font-semibold text-left text-gray-700 border-b border-gray-200">
                                                {{ $h }}
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                            @endif
                            <tbody class="divide-y divide-gray-100">
                                @foreach($rows as $r)
                                    <tr class="odd:bg-white even:bg-gray-50">
                                        @foreach($r->toArray() as $cell)
                                            <td class="px-3 py-2 whitespace-nowrap">
                                                @php
                                                    $val = is_scalar($cell) || is_null($cell) ? $cell : json_encode($cell);
                                                @endphp
                                                {{ ($val === null || $val === '') ? '—' : $val }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <p class="mt-3 text-xs text-gray-500">
                        Mostrando hasta {{ $limit ?? 500 }} filas para vista previa. El botón
                        <strong>Descargar archivo</strong> baja el original completo.
                    </p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
