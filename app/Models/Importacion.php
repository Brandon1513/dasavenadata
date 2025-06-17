<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Importacion extends Model
{
    use HasFactory;

    protected $table = 'importaciones'; // <- Aquí le indicas el nombre correcto

    protected $fillable = [
        'tabla',
        'archivo_original',
        'filas_importadas',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
