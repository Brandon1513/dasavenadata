<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">Relación de Tablas por Departamento</h2>
    </x-slot>

    <div class="max-w-6xl p-6 mx-auto">
         <!-- Mensaje de éxito -->
                @if (session('success'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
        <div class="flex items-center justify-between mb-4">
            <form method="GET" action="{{ route('departamento.tablas.index') }}" class="flex items-center gap-2">
                <select name="departamento_id" class="px-3 py-2 border rounded">
                    <option value="">Departamentos</option>
                    @foreach ($departamentos as $departamento)
                        <option value="{{ $departamento->id }}" {{ request('departamento_id') == $departamento->id ? 'selected' : '' }}>
                            {{ $departamento->nombre }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 text-white transition bg-blue-600 rounded hover:bg-blue-700">
                    Filtrar
                </button>
            </form>

            <a href="{{ route('departamento.tablas.create') }}"
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition bg-green-600 rounded-lg shadow hover:bg-green-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Asignar Nueva Tabla
            </a>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="font-semibold text-gray-700 bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left">Departamento</th>
                        <th class="px-6 py-3 text-left">Tabla</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($tablas as $tabla)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3">{{ $tabla->departamento->nombre }}</td>
                            <td class="px-6 py-3">{{ $tabla->tabla }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-3 text-center text-gray-500">No hay registros.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $tablas->appends(request()->query())->links() }}
        </div>
    </div>
</x-app-layout>
