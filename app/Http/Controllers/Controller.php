<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public $mensajes = [
        'email.required' => 'El email es obligatorio',
        'email.email' => 'El email no tiene un formato valido',
        'password.required' => 'La contraseña es obligatoria',
        'rut.required' => 'El rut es obligatorio',
        'rubro.required' => 'El rubro es obligatorio',
        'telefono.required' => 'El telefono es obligatorio',
        'direccion.required' => 'La direccion es obligatorio',
        'nombre.required' => 'El nombre es obligatorio'
        
    ];
}
