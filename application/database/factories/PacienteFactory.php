<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Paciente>
 */
class PacienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome_completo' => fake()->name(),
            'nome_mae_completo' => fake()->name(),
            'data_nascimento' => fake()->date(),
            'foto' => fake()->imageUrl(380, 380, 'profile', true),
            'cpf' => rand(11111111111, 99999999999),
            'cns' => rand(111111111111111, 999999999999999)
        ];
    }
}
