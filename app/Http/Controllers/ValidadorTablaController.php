<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ValidadorTabla;
use App\Models\Departamento;
use Illuminate\Http\Request;
use App\Models\DepartamentoTabla;

class ValidadorTablaController extends Controller
{
    public function index()
    {
        $asignaciones = ValidadorTabla::with('validador', 'departamento')->get();
        return view('validador_tablas.index', compact('asignaciones'));
    }

    public function create()
    {
        $validadores = User::role('validador')->get();
       $departamentos = Departamento::where('activo', 1)->get(); // ✅ CORRECTO


        // Obtener tablas reales desde la tabla departamento_tablas
        $tablas = DepartamentoTabla::distinct()->pluck('tabla');

        return view('validador_tablas.create', compact('validadores', 'departamentos', 'tablas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'validador_id' => 'required|exists:users,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'tabla' => 'required|array|min:1',
            'tabla.*' => 'string|max:255',
        ]);

        foreach ($request->tabla as $tabla) {
            ValidadorTabla::create([
                'validador_id' => $request->validador_id,
                'departamento_id' => $request->departamento_id,
                'tabla' => $tabla,
            ]);
        }


        return redirect()->route('validador-tablas.index')->with('success', 'Asignación guardada correctamente.');
    }

    public function destroy($id)
    {
        ValidadorTabla::findOrFail($id)->delete();
        return redirect()->route('validador-tablas.index')->with('success', 'Asignación eliminada.');
    }
    public function getTablasPorDepartamento($id)
    {
        $tablas = DepartamentoTabla::where('departamento_id', $id)->pluck('tabla');
        return response()->json($tablas);
    }
}
