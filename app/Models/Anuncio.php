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

    public function getImagenUrlAttribute(): ?string
    {
        if (!$this->imagen) return null;

        // Si la imagen ya tiene 'http', es un link de Cloudinary, lo devolvemos directo.
        // Si no, asumimos que es un archivo local antiguo y usamos asset().
        return str_starts_with($this->imagen, 'http') ? $this->imagen : asset('storage/'.$this->imagen);
    }
}