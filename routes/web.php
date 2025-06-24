<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\ValidadorTablaController;
use App\Http\Controllers\DepartamentoTablaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas de perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:administrador|lider'])->group(function () {
    Route::get('/subir-archivo', [UploadController::class, 'showForm'])->name('upload.form');
    Route::post('/subir-archivo', [UploadController::class, 'upload'])->name('upload.file');
    Route::post('/upload/map', [UploadController::class, 'map'])->name('upload.map');
    Route::post('/get-table-columns', [UploadController::class, 'getTableColumns'])->name('get-table-columns');
});

//empleados

Route::prefix('empleados')->middleware(['auth', 'role:administrador'])->group(function () {
    Route::get('/', [EmpleadoController::class, 'index'])->name('empleados.index');
    Route::get('/create', [EmpleadoController::class, 'create'])->name('empleados.create');
    Route::post('/', [EmpleadoController::class, 'store'])->name('empleados.store');
    Route::get('/{empleado}/edit', [EmpleadoController::class, 'edit'])->name('empleados.edit');
    Route::put('/{empleado}', [EmpleadoController::class, 'update'])->name('empleados.update');
    Route::delete('/{empleado}', [EmpleadoController::class, 'destroy'])->name('empleados.destroy');
    Route::patch('/{empleado}/toggle', [EmpleadoController::class, 'toggle'])->name('empleados.toggle');

});

//historial de importaciones
Route::middleware(['auth', 'role:administrador|lider'])->group(function () {
    Route::get('/importaciones', [UploadController::class, 'historial'])->name('importaciones.historial');
    Route::delete('/importaciones/{id}', [UploadController::class, 'eliminarImportacion'])->name('importaciones.eliminar');
    Route::get('/importaciones/{id}/detalle', [UploadController::class, 'verDetalle'])->name('importaciones.detalle');
    Route::get('/ver-archivo/{nombre}', function ($nombre) {
        $path = storage_path("app/private/uploads/{$nombre}");

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path); // Usa ->download($path) si prefieres descarga directa
    })->name('ver.archivo')->middleware('auth');
    Route::delete('/importaciones/{id}/eliminar', [UploadController::class, 'eliminarImportacion'])->name('importaciones.eliminar');

    

});

//validación de importaciones

Route::middleware(['auth', 'role:validador'])->group(function () {
    Route::get('/importaciones/validar', [UploadController::class, 'validacionesIndex'])->name('importaciones.validar');
    Route::get('/importaciones/{id}/validar', [UploadController::class, 'validarVista'])->name('importaciones.validarVista');
    Route::post('/importaciones/procesar', [UploadController::class, 'procesarMapeo'])->name('upload.map');
    Route::patch('/importaciones/{id}/aprobar', [UploadController::class, 'aprobar'])->name('importaciones.aprobar');
    Route::patch('/importaciones/{id}/rechazar', [UploadController::class, 'rechazar'])->name('importaciones.rechazar');
});


//departamento tablas

Route::middleware(['auth', 'role:administrador'])->group(function () {
    Route::resource('departamento-tablas', DepartamentoTablaController::class)->names('departamento.tablas');
});

//departamentos
Route::middleware(['auth', 'role:administrador'])->group(function () {
    Route::resource('departamentos', DepartamentoController::class)->names('departamentos');
    Route::patch('/departamentos/{id}/toggle', [DepartamentoController::class, 'toggle'])->name('departamentos.toggle');

});

//validadores de tablas

Route::middleware(['auth', 'role:administrador'])->group(function () {
    Route::resource('validador-tablas', ValidadorTablaController::class)->names('validador-tablas');
    Route::get('/departamentos/{id}/tablas', [ValidadorTablaController::class, 'getTablasPorDepartamento']);

});




require __DIR__.'/auth.php';
