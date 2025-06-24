<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Asignaciones de Tablas a Validadores</h2>
    </x-slot>

    <div class="max-w-6xl mx-auto mt-6 bg-white p-6 rounded shadow">
        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-end mb-4">
            <a href="{{ route('validador-tablas.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                + Asignar Tabla
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Validador</th>
                        <th class="px-4 py-2 border">Email</th>
                        <th class="px-4 py-2 border">Departamento</th>
                        <th class="px-4 py-2 border">Tabla</th>
                        <th class="px-4 py-2 border">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($asignaciones as $asignacion)
                        <tr>
                            <td class="px-4 py-2 border">{{ $asignacion->id }}</td>
                            <td class="px-4 py-2 border">{{ $asignacion->validador->name }}</td>
                            <td class="px-4 py-2 border">{{ $asignacion->validador->email }}</td>
                            <td class="px-4 py-2 border">{{ $asignacion->departamento->nombre }}</td>
                            <td class="px-4 py-2 border">
                                {{ ucfirst(str_replace('_', ' ', $asignacion->tabla)) }}
                            </td>
                            <td class="px-4 py-2 border">
                                <form action="{{ route('validador-tablas.destroy', $asignacion->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta asignación?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 text-white bg-red-600 rounded hover:bg-red-700">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-2 text-center text-gray-500">No hay asignaciones registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
