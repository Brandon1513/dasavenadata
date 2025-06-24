<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Asignar Tabla a Validador</h2>
    </x-slot>

    <div class="max-w-xl mx-auto mt-6 bg-white p-6 rounded shadow">
        <form action="{{ route('validador-tablas.store') }}" method="POST">
            @csrf

            <!-- Validador -->
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Validador</label>
                <select name="validador_id" class="w-full border rounded px-3 py-2" required>
                    @foreach($validadores as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Departamento -->
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Departamento</label>
                <select id="departamento_id" name="departamento_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Selecciona un departamento</option>
                    @foreach ($departamentos as $departamento)
                        <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tabla -->
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Tablas a Validar</label>
                <select id="tabla" name="tabla[]" class="w-full border rounded px-3 py-2" multiple size="5" required>
                    <option disabled>Selecciona primero un departamento</option>
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Guardar</button>
        </form>
    </div>
</x-app-layout>

<script>
document.getElementById('departamento_id').addEventListener('change', function () {
    const departamentoId = this.value;
    const tablaSelect = document.getElementById('tabla');

    // Limpiar opciones actuales
    tablaSelect.innerHTML = '<option disabled>Cargando tablas...</option>';

    if (departamentoId) {
        fetch(`/departamentos/${departamentoId}/tablas`)
            .then(response => response.json())
            .then(tablas => {
                tablaSelect.innerHTML = '<option disabled>Selecciona una o más tablas</option>';
                tablas.forEach(tabla => {
                    const option = document.createElement('option');
                    option.value = tabla;
                    option.textContent = tabla;
                    tablaSelect.appendChild(option);
                });
            })
            .catch(error => {
                tablaSelect.innerHTML = '<option disabled>Error al cargar tablas</option>';
                console.error(error);
            });
    } else {
        tablaSelect.innerHTML = '<option disabled>Selecciona primero un departamento</option>';
    }
});
</script>
