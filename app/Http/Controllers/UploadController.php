<?php

namespace App\Http\Controllers;

use App\Models\Importacion;
use App\Models\DepartamentoTabla;
use App\Models\ValidadorTabla;
use App\Models\User;
use App\Notifications\ImportacionPendienteNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    /* ===================== LÍDER: HISTORIAL ===================== */
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

    /* ===================== LÍDER: FORMULARIO UPLOAD ===================== */
    public function showForm()
    {
        $departamentoId = Auth::user()->departamento_id;
        $tablasPermitidas = DepartamentoTabla::where('departamento_id', $departamentoId)->pluck('tabla');

        return view('lideres.upload', compact('tablasPermitidas'));
    }

    /* ===================== LÍDER: SUBIR ARCHIVO (ENVÍA AVISO AL VALIDADOR) ===================== */
    public function upload(Request $request)
    {
        $request->validate([
            'file'  => 'required|file|mimes:csv,xlsx',
            'tabla' => 'required',
        ]);

        $file = $request->file('file');
        $path = $file->store('uploads');

        $data = Excel::toCollection(null, $file)[0];
        $contador = $data->count();

        $importacion = Importacion::create([
            'user_id'          => Auth::id(),
            'tabla'            => $request->tabla,
            'archivo_original' => basename($path),
            'filas_importadas' => $contador,
            'estatus'          => 'pendiente',
        ]);

        // Validador asignado por departamento + tabla
        $departamentoId = Auth::user()->departamento_id;
        $validadorAsignado = ValidadorTabla::where('departamento_id', $departamentoId)
            ->where('tabla', $request->tabla)
            ->first()?->validador;

        if ($validadorAsignado) {
            $validadorAsignado->notify(new ImportacionPendienteNotification($importacion));
        }

        return redirect()->route('upload.form')->with('success', 'Archivo enviado para validación.');
    }

    /* ===================== VALIDADOR: PREVIEW PROTEGIDO POR PERMISOS ===================== */
    public function validarVista($id)
    {
        $importacion = Importacion::findOrFail($id);
        $user = auth()->user();

        $tablasPermitidas = $user->tablasValidador()->pluck('tabla')->toArray();
        if (!in_array($importacion->tabla, $tablasPermitidas)) {
            abort(403, 'No tienes permiso para validar esta importación.');
        }

        $filePath = storage_path('app/private/uploads/' . $importacion->archivo_original);
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'Archivo no encontrado.');
        }

        $data = Excel::toCollection(null, $filePath)[0];
        $previewRows = $data->take(5);
        $headers = $data->first() ? $data->first()->toArray() : [];

        return view('validadores.preview', [
            'importacion'  => $importacion,
            'file'         => $importacion->archivo_original,
            'tabla'        => $importacion->tabla,
            'preview'      => $previewRows,
            'headers'      => $headers,
            'tableColumns' => \Schema::getColumnListing($importacion->tabla),
        ]);
    }

    /* ===================== AJAX: COLUMNAS DE UNA TABLA ===================== */
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
            return response()->json(['error' => 'Error obteniendo columnas: ' . $e->getMessage()], 500);
        }
    }

    /* ===================== ELIMINAR IMPORTACIÓN (ADMIN/LÍDER PROPIO) ===================== */
    public function eliminarImportacion($id)
    {
        $importacion = Importacion::findOrFail($id);

        // Elimina archivo físico si existiera con otra ruta
        if ($importacion->archivo && Storage::disk('local')->exists($importacion->archivo)) {
            Storage::disk('local')->delete($importacion->archivo);
        }

        // Borra datos insertados ese día
        DB::table($importacion->tabla)
            ->whereDate('created_at', $importacion->created_at->toDateString())
            ->delete();

        $importacion->delete();

        return redirect()->route('importaciones.historial')->with('success', 'Importación eliminada correctamente.');
    }

    /* ===================== DETALLE DE IMPORTACIÓN ===================== */
    public function verDetalle($id)
    {
        $importacion = Importacion::with('user')->findOrFail($id);

        $datos = DB::table($importacion->tabla)
            ->whereDate('created_at', $importacion->created_at->toDateString())
            ->limit(10)
            ->get();

        return view('lideres.importaciones-detalle', compact('importacion', 'datos'));
    }

    /* ===================== LISTA PARA VALIDAR (SOLO TABLAS ASIGNADAS) ===================== */
    public function validacionesIndex(Request $request)
    {
        $user = auth()->user();

        $tablasPermitidas = $user->tablasValidador()->pluck('tabla')->toArray();

        if (empty($tablasPermitidas)) {
            $importaciones = collect();
            $usuarios = collect();
            return view('validadores.index', compact('importaciones', 'usuarios'));
        }

        // Usuarios que han importado en esas tablas (para el filtro)
        $usuarios = User::whereHas('importaciones', function ($q) use ($tablasPermitidas) {
            $q->whereIn('tabla', $tablasPermitidas);
        })->orderBy('name')->get();

        $query = Importacion::with('user')->whereIn('tabla', $tablasPermitidas);

        if ($request->filled('usuario')) {
            $query->where('user_id', $request->usuario);
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

        $importaciones = $query->orderByDesc('created_at')
            ->paginate(10)->appends($request->query());

        return view('validadores.index', compact('importaciones', 'usuarios'));
    }

    /* ===================== APROBAR ===================== */
    public function aprobar($id)
    {
        $importacion = Importacion::findOrFail($id);
        $user = auth()->user();

        $tablasPermitidas = $user->tablasValidador()->pluck('tabla')->toArray();
        if (!in_array($importacion->tabla, $tablasPermitidas)) {
            abort(403, 'No tienes permiso para aprobar esta importación.');
        }

        $importacion->estatus      = 'aprobado';
        $importacion->validador_id = $user->id;
        $importacion->save();

        return redirect()->route('importaciones.validar')->with('success', 'Importación aprobada correctamente.');
    }

    /* ===================== RECHAZAR ===================== */
    public function rechazar($id)
    {
        $importacion = Importacion::findOrFail($id);
        $user = auth()->user();

        $tablasPermitidas = $user->tablasValidador()->pluck('tabla')->toArray();
        if (!in_array($importacion->tabla, $tablasPermitidas)) {
            abort(403, 'No tienes permiso para rechazar esta importación.');
        }

        $filePath = storage_path('app/private/uploads/' . $importacion->archivo_original);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $importacion->estatus      = 'rechazado';
        $importacion->validado_en  = now();
        $importacion->validado_por = Auth::id();
        $importacion->save();

        return redirect()->route('importaciones.validar')->with('success', 'Importación rechazada y archivo eliminado.');
    }

    /* ===================== PROCESAR MAPEO + NORMALIZACIÓN ===================== */
    public function procesarMapeo(Request $request)
    {
        $request->validate([
            'file'     => 'required|string',
            'tabla'    => 'required|string',
            'mappings' => 'required|array',
        ]);

        $table    = $request->tabla;
        $mappings = $request->input('mappings');
        $filePath = storage_path('app/private/uploads/' . basename($request->file));

        if (!file_exists($filePath)) {
            return back()->with('error', 'Archivo no encontrado.');
        }

        // Tipos y longitudes reales de columnas
        $columnsMeta   = $this->getColumnsMeta($table);
        // Columnas tratadas como fecha aunque sean VARCHAR en BD (si aplica)
        $extraDateCols = $this->extraDateColumnsByTable($table);

        $data  = Excel::toCollection(null, $filePath)[0];
        $rows  = $data->slice(1);
        $count = 0;

        DB::beginTransaction();
        try {
            foreach ($rows as $row) {
                $insertData = [];

                foreach ($row as $index => $value) {
                    $originalHeader = $data[0][$index] ?? null;
                    $columnName     = $mappings[$originalHeader] ?? null;

                    if (!$columnName) {
                        continue;
                    }

                    $raw = is_null($value) ? null : trim((string)$value);

                    if ($this->isNullLike($raw)) {
                        $normalized = null;
                    } else {
                        $meta = $columnsMeta[$columnName] ?? ['type' => 'string', 'max' => 65535];

                        // Forzar fecha para columnas extras si no son date en BD
                        if (in_array($columnName, $extraDateCols, true) && !in_array($meta['type'], ['date','datetime','timestamp'])) {
                            $normalized = $this->toDate($raw);
                            // Si columna en BD no es tipo fecha, guardamos string "Y-m-d"
                            if (!in_array($meta['type'], ['date','datetime','timestamp']) && $normalized) {
                                $normalized = (string) $normalized;
                            }
                        } else {
                            switch ($meta['type']) {
                                case 'date':
                                case 'datetime':
                                case 'timestamp':
                                    $normalized = $this->toDate($raw);
                                    break;

                                case 'decimal':
                                case 'numeric':
                                case 'float':
                                case 'double':
                                    $normalized = $this->toDecimal($raw);
                                    break;

                                case 'tinyint':
                                case 'smallint':
                                case 'mediumint':
                                case 'int':
                                case 'bigint':
                                    $normalized = $this->toInteger($raw);
                                    break;

                                default: // string/text
                                    $normalized = $this->toString($raw, $meta['max'] ?? 65535);
                            }
                        }
                    }

                    $insertData[$columnName] = $normalized;
                }

                $insertData['created_at'] = now();
                $insertData['updated_at'] = now();

                DB::table($table)->insert($insertData);
                $count++;
            }

            // Actualiza importación
            $imp = Importacion::where('archivo_original', basename($request->file))->first();
            if ($imp) {
                $imp->estatus          = 'aprobado';
                $imp->validado_en      = now();
                $imp->validado_por     = Auth::id();
                $imp->filas_importadas = $count;
                $imp->save();
            }

            DB::commit();
            return redirect()->route('importaciones.validar')->with('success', 'Importación aprobada e insertada correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Error insertando datos: ' . $e->getMessage());
        }
    }

    /* ===================== HELPERS: META COLUMNAS, NORMALIZADORES ===================== */

    /**
     * Tipos y longitudes reales desde INFORMATION_SCHEMA.
     * Resultado: ['col' => ['type' => 'decimal|int|string|text|date|datetime|timestamp', 'max' => int|null]]
     */
    private function getColumnsMeta(string $table): array
    {
        $db   = DB::getDatabaseName();
        $rows = DB::select(
            "SELECT COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH, NUMERIC_PRECISION, NUMERIC_SCALE
             FROM INFORMATION_SCHEMA.COLUMNS
             WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?",
            [$db, $table]
        );

        $meta = [];
        foreach ($rows as $r) {
            $type = strtolower($r->DATA_TYPE);
            $max  = $r->CHARACTER_MAXIMUM_LENGTH ? (int) $r->CHARACTER_MAXIMUM_LENGTH : null;

            if (in_array($type, ['varchar','char','text','mediumtext','longtext','tinytext'])) {
                $normType = in_array($type, ['text','mediumtext','longtext','tinytext']) ? 'text' : 'string';
                $meta[$r->COLUMN_NAME] = ['type' => $normType, 'max' => $max ?? 65535];
            } elseif (in_array($type, ['decimal','numeric','float','double'])) {
                $meta[$r->COLUMN_NAME] = ['type' => 'decimal', 'max' => null];
            } elseif (in_array($type, ['tinyint','smallint','mediumint','int','bigint'])) {
                $meta[$r->COLUMN_NAME] = ['type' => 'int', 'max' => null];
            } elseif (in_array($type, ['date','datetime','timestamp'])) {
                $meta[$r->COLUMN_NAME] = ['type' => $type, 'max' => null];
            } else {
                $meta[$r->COLUMN_NAME] = ['type' => 'string', 'max' => $max ?? 255];
            }
        }
        return $meta;
    }

    /**
     * Columnas que quieres tratar como fecha aunque en BD estén como VARCHAR.
     * Ajusta por tabla según tus plantillas.
     */
    private function extraDateColumnsByTable(string $table): array
    {
        switch ($table) {
            case 'operaciones_quejas_clientes':
                return [
                    'fecha_queja','fecha_produccion','fecha_contacto_mkt','fecha_contacto_cal',
                    'fecha_respuesta','fecha_correo','fecha_reposicion',
                    'fecha_solicitud_producto_produccion',
                    'fecha_entrega_produccion_ecommerce','fecha_armado_reposicion',
                    'fecha_entrega_coord_logistica','fecha_envio_reposicion_paquetera',
                    'reposicion_entregada_cliente','mes_produccion','anio_produccion'
                ];
            default:
                return [];
        }
    }

    private function isNullLike(?string $v): bool
    {
        if ($v === null) return true;
        $s = mb_strtolower(trim($v));
        return $s === '' || in_array($s, ['n/a','na','-','--','s/i','sin info','null','undefined','?'], true);
    }

    /** Retorna string 'Y-m-d' o null */
    private function toDate(?string $v)
    {
        if ($v === null) return null;
        $v = trim($v);
        // remover hora si viene pegada
        $v = preg_replace('/\s+\d{1,2}:\d{2}:\d{2}.*/', '', $v);

        $formats = ['d/m/Y','d-m-Y','Y-m-d','m/d/Y','d.m.Y','Y/m/d'];
        foreach ($formats as $fmt) {
            $dt = \DateTime::createFromFormat($fmt, $v);
            if ($dt && $dt->format($fmt) === $v) {
                return $dt->format('Y-m-d');
            }
        }
        return null;
    }

    /** Limpia $ MXN comas de miles; coma/punto decimal; SI/NO => null */
    private function toDecimal(?string $v): ?float
    {
        if ($v === null) return null;
        $s = trim($v);
        $low = mb_strtolower($s);
        if (in_array($low, ['si','sí','no','n/a','na','?','-','--'], true)) {
            return null;
        }
        $s = str_ireplace(['$', 'mxn', 'usd'], '', $s);
        $s = str_replace([' ', ','], '', $s);  // quita miles y espacios
        $s = str_replace(',', '.', $s);        // (por si quedara)
        if (!is_numeric($s)) return null;
        return round((float)$s, 2);
    }

    /** Entero: SI/NO => 1/0; quita no-dígitos */
    private function toInteger(?string $v): ?int
    {
        if ($v === null) return null;
        $s = trim($v);
        $low = mb_strtolower($s);
        if (in_array($low, ['si','sí','yes','true'], true))  return 1;
        if (in_array($low, ['no','false'], true))            return 0;

        $digits = preg_replace('/[^\d\-]/', '', $s);
        if ($digits === '' || $digits === '-') return null;
        return (int) $digits;
    }

    /** String recortado a la longitud de la columna */
    private function toString(?string $v, int $max = 255): ?string
    {
        if ($v === null) return null;
        $s = trim($v);
        if ($s === '') return null;
        $s = preg_replace('/\s+/', ' ', $s);
        return Str::limit($s, $max, '');
    }
}
