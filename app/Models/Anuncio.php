<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anuncio extends Model
{
    use HasFactory;

    protected $table = 'anuncios';

    protected $fillable = [
        'titulo',
        'contenido',
        'imagen',
        'fecha_evento',
        'activo',
    ];

    protected $casts = [
        'fecha_evento' => 'date',
        'activo' => 'boolean',
    ];

    /**
     * URL pública de la imagen del anuncio (o null si no tiene).
     */
    public function getImagenUrlAttribute(): ?string
    {
        return $this->imagen ? asset('storage/'.$this->imagen) : null;
    }
}