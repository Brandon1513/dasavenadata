<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'departamento_id', // ✅ agregado
        'activo',          // ✅ agregado
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => 'boolean', // ✅ para que se muestre como true/false
        ];
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }
    public function tablasValidador()
    {
        return $this->hasMany(\App\Models\ValidadorTabla::class, 'validador_id');
    }
    public function importaciones()
    {
        return $this->hasMany(\App\Models\Importacion::class, 'user_id');
    }


}

