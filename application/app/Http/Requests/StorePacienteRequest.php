<?php

namespace App\Http\Requests;

use App\Rules\CNSValidated;
use App\Rules\CPFValidated;
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

        $rules =  [
            'nome_completo' => 'required|string|max:255',
            'nome_mae_completo' => 'required|string|max:255',
            'data_nascimento' => 'required|string|max:255',
            'foto' => 'string|max:255',
            'cpf' => [
                'required',
                'min:11',
                'max:14',
                new CPFValidated()
            ],
            'cns' => [
                'required',
                'min:15',
                'max:18',
                new CNSValidated()
            ],
        ];

        if ($paciente) {

            $rules['cpf'][] = Rule::unique('pacientes')->ignore($paciente->id);
            $rules['cns'][] = Rule::unique('pacientes')->ignore($paciente->id);
        } else {
            $rules['cpf'][] = 'unique:pacientes';
            $rules['cns'][] = 'unique:pacientes';
        }

        return $rules;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $cns = (int) str_replace(' ', '', trim($this->cns));
        $cpf = (int) str_replace('-', '', str_replace('.', '', trim($this->cpf)));

        $this->merge([
            'cns' => trim($cns),
            'cpf' => trim($cpf)
        ]);
    }
}
