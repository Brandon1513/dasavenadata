<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use App\Models\Importacion;
use Illuminate\Http\Request;
use App\Models\DepartamentoTabla;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ImportacionPendienteNotification;
use App\Models\User;
use App\Models\ValidadorTabla;



class UploadController extends Controller
{
    public function historial()
    {
        if (Auth::user()->hasRole('administrador')) {
            $importaciones = Importacion::with('user')
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        } else {
            $importaciones = Importacion::with('user')
                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        }

        return view('lideres.importaciones', compact('importaciones'));
}

    public function showForm()
    {
        $departamentoId = Auth::user()->departamento_id;
        $tablasPermitidas = DepartamentoTabla::where('departamento_id', $departamentoId)->pluck('tabla');

        return view('lideres.upload', compact('tablasPermitidas'));
    }


public function upload(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:csv,xlsx',
        'tabla' => 'required'
    ]);

    $file = $request->file('file');
    $path = $file->store('uploads');

    $data = Excel::toCollection(null, $file)[0];
    $contador = $data->count();

    $importacion = Importacion::create([
        'user_id' => Auth::id(),
        'tabla' => $request->tabla,
        'archivo_original' => basename($path),
        'filas_importadas' => $contador,
        'estatus' => 'pendiente'
    ]);

    // Obtener el departamento del usuario que sube el archivo
    $departamentoId = Auth::user()->departamento_id;

    // Buscar al validador asignado a ese departamento y tabla
    $validadorAsignado = ValidadorTabla::where('departamento_id', $departamentoId)
        ->where('tabla', $request->tabla)
        ->first()?->validador;

    // Enviar la notificación solo al validador asignado
    if ($validadorAsignado) {
        $validadorAsignado->notify(new ImportacionPendienteNotification($importacion));
    }

    return redirect()->route('upload.form')->with('success', 'Archivo enviado para validación.');
}


public function validarVista($id)
{
    $importacion = Importacion::findOrFail($id);
    $user = auth()->user();

    // Validar que el validador tenga acceso a esta tabla
    $tablasPermitidas = $user->tablasValidador()->pluck('tabla')->toArray();

    if (!in_array($importacion->tabla, $tablasPermitidas)) {
        abort(403, 'No tienes permiso para validar esta importación.');
    }

    $filePath = storage_path('app/private/uploads/' . $importacion->archivo_original);

    if (!file_exists($filePath)) {
        return redirect()->back()->with('error', 'Archivo no encontrado.');
    }

    $data = \Maatwebsite\Excel\Facades\Excel::toCollection(null, $filePath)[0];
    $previewRows = $data->take(5);
    $headers = $data->first() ? $data->first()->toArray() : [];

    return view('validadores.preview', [
        'importacion' => $importacion,
        'file' => $importacion->archivo_original,
        'tabla' => $importacion->tabla,
        'preview' => $previewRows,
        'headers' => $headers,
        'tableColumns' => \Schema::getColumnListing($importacion->tabla)
    ]);
}





    public function getTableColumns(Request $request)
    {
        $tabla = $request->input('tabla');

        if (!$tabla) {
            return response()->json(['error' => 'Tabla no especificada.'], 400);
        }

        try {
            $columns = DB::getSchemaBuilder()->getColumnListing($tabla);
            return response()->json(['columns' => $columns]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error obteniendo columnas: '.$e->getMessage()], 500);
        }
    }

    public function eliminarImportacion($id)
{
    $importacion = Importacion::findOrFail($id);

    // Elimina archivo físico
    if ($importacion->archivo && Storage::disk('local')->exists($importacion->archivo)) {
        Storage::disk('local')->delete($importacion->archivo);
    }

    // Elimina datos de la tabla importada
    DB::table($importacion->tabla)
        ->whereDate('created_at', $importacion->created_at->toDateString())
        ->delete();

    // Elimina el registro del historial
    $importacion->delete();

    return redirect()->route('importaciones.historial')->with('success', 'Importación eliminada correctamente.');
}

    public function verDetalle($id)
    {
        $importacion = Importacion::with('user')->findOrFail($id);

        $datos = DB::table($importacion->tabla)
        ->whereDate('created_at', $importacion->created_at->toDateString())
        ->limit(10)
        ->get();

        return view('lideres.importaciones-detalle', compact('importacion', 'datos'));
    }
    public function validacionesIndex(Request $request)
{
    $user = auth()->user();

    // Obtener las tablas que este validador tiene asignadas
    $tablasPermitidas = $user->tablasValidador()->pluck('tabla')->toArray();

    // Si no tiene tablas asignadas, que no vea nada
    if (empty($tablasPermitidas)) {
        $importaciones = collect(); // colección vacía
        $usuarios = collect(); // colección vacía para evitar errores en la vista
        return view('validadores.index', compact('importaciones', 'usuarios'));
    }

    // Obtener usuarios relacionados con esas importaciones (solo para el select)
    $usuarios = \App\Models\User::whereHas('importaciones', function ($q) use ($tablasPermitidas) {
        $q->whereIn('tabla', $tablasPermitidas);
    })->orderBy('name')->get();

    // Filtrar importaciones por esas tablas
    $query = \App\Models\Importacion::with('user')
        ->whereIn('tabla', $tablasPermitidas);

    // Filtros adicionales
    if ($request->filled('usuario')) {
        $query->where('user_id', $request->usuario); // filtrando por ID del usuario
    }

    if ($request->filled('estatus')) {
        $query->where('estatus', $request->estatus);
    }

    if ($request->filled('desde')) {
        $query->whereDate('created_at', '>=', $request->desde);
    }

    if ($request->filled('hasta')) {
        $query->whereDate('created_at', '<=', $request->hasta);
    }

    $importaciones = $query->orderByDesc('created_at')->paginate(10)->appends($request->query());

    return view('validadores.index', compact('importaciones', 'usuarios'));
}



    
 public function aprobar($id)
    {
        $importacion = Importacion::findOrFail($id);
        $user = auth()->user();

        // Validar que el validador tenga permiso sobre la tabla
        $tablasPermitidas = $user->tablasValidador()->pluck('tabla')->toArray();

        if (!in_array($importacion->tabla, $tablasPermitidas)) {
            abort(403, 'No tienes permiso para aprobar esta importación.');
        }

        $importacion->estatus = 'aprobada';
        $importacion->validador_id = $user->id;
        $importacion->save();

        return redirect()->route('importaciones.validar')->with('success', 'Importación aprobada correctamente.');
    }





   public function rechazar($id)
    {
        $importacion = Importacion::findOrFail($id);
        $user = auth()->user();

        // Validar que el validador tenga permiso sobre la tabla
        $tablasPermitidas = $user->tablasValidador()->pluck('tabla')->toArray();

        if (!in_array($importacion->tabla, $tablasPermitidas)) {
            abort(403, 'No tienes permiso para rechazar esta importación.');
        }

        // Elimina el archivo físico si existe
        $filePath = storage_path('app/private/uploads/' . $importacion->archivo_original);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Marca como rechazado
        $importacion->estatus = 'rechazado';
        $importacion->validado_en = now();
        $importacion->validado_por = Auth::id();
        $importacion->save();

        return redirect()->route('importaciones.validar')->with('success', 'Importación rechazada y archivo eliminado.');
    }

    public function procesarMapeo(Request $request)
{
    $request->validate([
        'file' => 'required|string',
        'tabla' => 'required|string',
        'mappings' => 'required|array',
    ]);

    $mappings = $request->input('mappings');
    $filePath = storage_path('app/private/uploads/' . basename($request->file));

    if (!file_exists($filePath)) {
        return back()->with('error', 'Archivo no encontrado.');
    }

    $data = Excel::toCollection(null, $filePath)[0];
    $rows = $data->slice(1); // omite encabezado
    $contador = 0;

    foreach ($rows as $row) {
        $insertData = [];

        foreach ($row as $index => $value) {
            $originalHeader = $data[0][$index] ?? null;
            $columnName = $mappings[$originalHeader] ?? null;

            if ($columnName) {
                $valor = trim($value);

                // Normaliza valores vacíos
                if (in_array(strtolower($valor), ['n/a', '-', ''])) {
                    $valor = null;
                }

                // Aquí puedes agregar lógica para fechas o formatos especiales
                if (in_array($columnName, ['fecha', 'fecha_inicio', 'fecha_termino']) && !empty($valor)) {
                    $partes = explode('/', $valor);
                    if (count($partes) === 3) {
                        $valor = "{$partes[2]}-{$partes[1]}-{$partes[0]}";
                    }
                }

                $insertData[$columnName] = $valor;
            }
        }

        $insertData['created_at'] = now();
        $insertData['updated_at'] = now();

        DB::table($request->tabla)->insert($insertData);
        $contador++;
    }

    // Actualiza la importación como validada
    $importacion = Importacion::where('archivo_original', basename($request->file))->first();
    if ($importacion) {
        $importacion->estatus = 'aprobado';
        $importacion->validado_en = now();
        $importacion->validado_por = Auth::id();
        $importacion->filas_importadas = $contador;
        $importacion->save();
    }

    return redirect()->route('importaciones.validar')->with('success', 'Importación aprobada e insertada correctamente.');
}




}
