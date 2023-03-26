<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PacientesEndereco>
 */
class PacientesEnderecoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'endereco' => fake()->sentence(5),
            'numero' => rand(1111, 9999),
            'complemento' => fake()->sentence(2),
            'bairro' => fake()->sentence(2),
            'cep' => rand(11111111, 99999999),
            'cidade' => fake()->sentence(3),
            'estado' => fake()->sentence(2),
        ];

    }
}
