<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValidadorTabla extends Model
{
    protected $fillable = ['validador_id', 'departamento_id', 'tabla'];

    public function validador()
    {
        return $this->belongsTo(User::class, 'validador_id');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }
}
