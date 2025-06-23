<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Departamentos') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                @if (session('success'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-700">Listado de departamentos</h3>
                        <a href="{{ route('departamentos.create') }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white transition bg-blue-600 rounded-md hover:bg-blue-700">
                            + Agregar Departamento
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm bg-white border rounded-lg">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-3 border-b">ID</th>
                                    <th class="px-4 py-3 border-b">Nombre</th>
                                    <th class="px-4 py-3 border-b">Creado</th>
                                    <th class="px-4 py-3 border-b">Estado</th>
                                    <th class="px-4 py-3 border-b">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($departamentos as $departamento)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 border-b">{{ $departamento->id }}</td>
                                        <td class="px-4 py-3 border-b">{{ $departamento->nombre }}</td>
                                        <td class="px-4 py-3 border-b">{{ $departamento->created_at->format('d-m-Y') }}</td>
                                        <td class="px-4 py-3 border-b">
                                            @if ($departamento->activo)
                                                <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded">Activo</span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded">Inactivo</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 border-b">
                                            <form method="POST" action="{{ route('departamentos.toggle', $departamento->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1 text-xs font-semibold text-white transition 
                                                    {{ $departamento->activo ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} 
                                                    rounded">
                                                    {{ $departamento->activo ? 'Inactivar' : 'Activar' }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $departamentos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
