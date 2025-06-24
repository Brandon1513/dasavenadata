<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartamentoTabla extends Model
{
    use HasFactory;

    protected $fillable = ['departamento_id', 'tabla'];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }
    public function scopeActivos($query)
    {
        return $query->whereHas('departamento', function ($q) {
            $q->where('activo', 1);
        });
    }

}
