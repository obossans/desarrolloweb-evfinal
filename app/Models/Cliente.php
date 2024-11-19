<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'rut',
        'rubro',
        'rsocial',
        'telefono',
        'direccion',
        'nombre',
        'email',
        'activo',
    ];
}
