<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\DepartamentoTabla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DepartamentoTablaController extends Controller
{
    public function index(Request $request)
    {
        $departamentos = Departamento::all();

        $query = DepartamentoTabla::with('departamento');

        if ($request->filled('departamento_id')) {
            $query->where('departamento_id', $request->departamento_id);
        }

        $tablas = $query->paginate(10);

        return view('departamento_tablas.index', compact('tablas', 'departamentos'));
    }


    public function create()
    {
        $departamentos = Departamento::all();
        $tablasExistentes = DB::select('SHOW TABLES');

        $tablas = array_map(fn($item) => array_values((array) $item)[0], $tablasExistentes);

        return view('departamento_tablas.create', compact('departamentos', 'tablas'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'departamento_id' => 'required|exists:departamentos,id',
            'tabla' => [
                'required',
                Rule::unique('departamento_tablas')->where(fn ($q) => $q->where('departamento_id', $request->departamento_id)),
            ]
        ]);

        DepartamentoTabla::create($request->only(['departamento_id', 'tabla']));

        return redirect()->route('departamento.tablas.index')->with('success', 'Tabla registrada correctamente.');
    }
}
