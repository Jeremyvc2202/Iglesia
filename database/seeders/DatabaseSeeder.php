<?php

namespace Database\Seeders;

use App\Models\Anuncio;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Usuario miembro de prueba para probar el botón "Acceder"
        User::create([
            'name' => 'Miembro de Prueba',
            'email' => 'miembro@iglesia.com',
            'password' => bcrypt('miembro123'),
        ]);

        Anuncio::create([
            'titulo' => 'Bienvenidos a nuestra nueva página web',
            'contenido' => "Nos alegra compartir con toda la congregación el lanzamiento de nuestra nueva página de anuncios. Aquí encontrarán las últimas noticias, eventos y actividades de la iglesia.",
            'fecha_evento' => null,
            'activo' => true,
        ]);

        Anuncio::create([
            'titulo' => 'Culto especial de acción de gracias',
            'contenido' => "Los invitamos a participar de nuestro culto especial de acción de gracias. Habrá alabanza, testimonios y una palabra especial para toda la familia. ¡No falten!",
            'fecha_evento' => now()->addDays(14)->format('Y-m-d'),
            'activo' => true,
        ]);

        Anuncio::create([
            'titulo' => 'Reunión de jóvenes',
            'contenido' => "Este sábado tendremos nuestra reunión mensual de jóvenes con dinámicas, música y un tiempo de reflexión. Trae a un amigo.",
            'fecha_evento' => now()->addDays(3)->format('Y-m-d'),
            'activo' => true,
        ]);
    }
}
