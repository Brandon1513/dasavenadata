<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Importaciones') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 bg-white shadow sm:rounded-lg">

                <!-- Filtros -->
                <form method="GET" class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Usuario</label>
                        <select name="usuario" class="w-full border-gray-300 rounded">
                            <option value="">-- Todos --</option>
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" {{ request('usuario') == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estatus</label>
                        <select name="estatus" class="w-full border-gray-300 rounded">
                            <option value="">-- Todos --</option>
                            <option value="pendiente" {{ request('estatus') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="aprobado" {{ request('estatus') == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                            <option value="rechazado" {{ request('estatus') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Desde</label>
                        <input type="date" name="desde" value="{{ request('desde') }}" class="w-full border-gray-300 rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hasta</label>
                        <input type="date" name="hasta" value="{{ request('hasta') }}" class="w-full border-gray-300 rounded">
                    </div>

                    <div class="md:col-span-4 text-right">
                        <x-primary-button>Filtrar</x-primary-button>
                        <a href="{{ route('importaciones.validar') }}" class="ml-2 text-sm text-gray-600 underline">Limpiar</a>
                    </div>
                </form>

                <!-- Tabla -->
                @if ($importaciones->isEmpty())
                    <p class="text-gray-600">No se encontraron resultados.</p>
                @else
                    <table class="w-full text-sm border table-auto">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-2 py-2 border">Tabla</th>
                                <th class="px-2 py-2 border">Archivo</th>
                                <th class="px-2 py-2 border">Usuario</th>
                                <th class="px-2 py-2 border">Fecha</th>
                                <th class="px-2 py-2 border">Estatus</th>
                                <th class="px-2 py-2 border">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($importaciones as $imp)
                                <tr>
                                    <td class="px-2 py-1 border">{{ $imp->tabla }}</td>
                                    <td class="px-2 py-1 border">{{ $imp->archivo_original }}</td>
                                    <td class="px-2 py-1 border">{{ $imp->user->name ?? 'N/A' }}</td>
                                    <td class="px-2 py-1 border">{{ $imp->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-2 py-1 capitalize border">{{ $imp->estatus ?? 'pendiente' }}</td>
                                    <td class="px-2 py-1 space-x-2 border">
                                        <a href="{{ route('importaciones.detalle', $imp->id) }}"
                                           class="text-blue-600 hover:underline">Ver</a>

                                        @if ($imp->estatus === 'pendiente')
                                            <a href="{{ route('importaciones.validarVista', $imp->id) }}"
                                               class="text-green-600 hover:underline">Validar</a>

                                            <form method="POST" action="{{ route('importaciones.rechazar', $imp->id) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-red-600 hover:underline">Rechazar</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Paginación -->
                    <div class="mt-4">
                        {{ $importaciones->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
