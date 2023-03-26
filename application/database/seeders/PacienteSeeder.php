<?php

namespace Database\Seeders;

use App\Models\Paciente;
use Illuminate\Database\Seeder;
use App\Models\PacientesEndereco;

class PacienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Paciente::factory(10)->has(
            PacientesEndereco::factory()->count(1)
        )->create();
    }
}
