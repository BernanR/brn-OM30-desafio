<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PacienteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome_completo,
            'nome_mae' => $this->nome_mae_completo,
            'foto' => $this->foto,
            'cpf' => $this->cpf,
            'cns' => $this->cns,
            'enderecos' => PacienteEnderecosResource::collection($this->PacientesEndereco),
        ];
    }
}
