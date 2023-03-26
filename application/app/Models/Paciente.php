<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paciente extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome_completo',
        'nome_mae_completo',
        'data_nascimento',
        'foto',
        'cpf',
        'cns',
    ];

    /**
     * The address that belong to the patient.
     */
    public function PacientesEndereco(): HasMany
    {
        return $this->hasMany(PacientesEndereco::class);
    }
}
