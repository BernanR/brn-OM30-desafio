<?php

namespace App\Http\Requests;

use App\Rules\CNSValidated;
use App\Rules\CPFValidated;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StorePacienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $paciente = $this->route('paciente');
        $id = ($paciente) ? $paciente->id : -1;

        return [
            'nome_completo' => 'required|string|max:255',
            'nome_mae_completo' => 'required|string|max:255',
            'data_nascimento' => 'required|string|max:255',
            'foto' => 'required|string|max:255',
            'cpf' => [
                'required',
                'min:11',
                'max:14',
                Rule::unique('pacientes')->ignore($id),
                new CPFValidated()
            ],
            'cns' => [
                'required',
                'min:15',
                'max:18',
                Rule::unique('pacientes')->ignore($id),
                new CNSValidated()
            ],
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $cns = (int) str_replace(' ', '', trim($this->cns));

        $this->merge([
            'cns' => $cns,
        ]);
    }
}
