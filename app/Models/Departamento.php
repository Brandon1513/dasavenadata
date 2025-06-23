<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    //
     // Para permitir asignación masiva del campo 'nombre'
   protected $fillable = ['nombre', 'activo'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
public function tablasPermitidas()
    {
        return $this->hasMany(DepartamentoTabla::class);
    }

}
