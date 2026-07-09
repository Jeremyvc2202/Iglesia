<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Culto extends Model
{
    // Con esto habilitamos la asignación masiva para estos campos
    protected $fillable = [
        'nombre', 
        'horario',
        'imagen',
        'activo'
    ];
}