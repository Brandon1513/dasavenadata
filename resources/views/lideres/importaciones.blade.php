<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Histórico de Importaciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <!-- Mensaje de éxito -->
                @if (session('success'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <table class="w-full text-sm border table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-2 py-2 border">Tabla</th>
                            <th class="px-2 py-2 border">Archivo</th>
                            <th class="px-2 py-2 border">Filas</th>
                            <th class="px-2 py-2 border">Usuario</th>
                            <th class="px-2 py-2 border">Fecha</th>
                            <th class="px-2 py-2 border">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($importaciones as $imp)
                            <tr>
                                <td class="px-2 py-1 border">{{ $imp->tabla }}</td>
                                <td>
                                    <a href="{{ route('ver.archivo', $imp->archivo_original) }}" target="_blank"    class="text-blue-600 underline">
                                        {{ $imp->archivo_original }}
                                    </a>
                                </td>
                                <td class="px-2 py-1 text-center border">{{ $imp->filas_importadas }}</td>
                                <td class="px-2 py-1 border">{{ $imp->user->name ?? 'N/A' }}</td>
                                <td class="px-2 py-1 border">{{ $imp->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-2 py-1 border"><a href="{{ route('importaciones.detalle', $imp->id) }}" class="text-blue-600 hover:underline">Ver</a>
                                @role('administrador')
                                    <form action="{{ route('importaciones.eliminar', $imp->id) }}" method="POST" class="inline-block ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                    </form>
                                @endrole


                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center">No hay registros aún.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $importaciones->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
