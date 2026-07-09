<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AnuncioFactory extends Factory
{
    public function definition(): array
    {
        return [
            'titulo' => fake()->sentence(4),
            'contenido' => fake()->paragraph(3),
            'fecha_evento' => fake()->optional()->dateTimeBetween('now', '+2 months'),
            'activo' => true,
        ];
    }
}
