<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    //
    public function users()
    {
        return $this->hasMany(User::class);
    }
public function tablasPermitidas()
    {
        return $this->hasMany(DepartamentoTabla::class);
    }

}
