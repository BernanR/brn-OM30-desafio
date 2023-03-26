<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CNSValidated implements ValidationRule
{
    PRIVATE $cns;

    CONST CNS_INVALID_MESSAGE = "O número do CNS é inválido!";

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->cns = (int) str_replace(' ', '', trim($value));

        if ( strlen($this->cns) != 15 ) {

            $fail(self::CNS_INVALID_MESSAGE);
            return;
        }

        // 1. Rotina de validação de Números que iniciam com 1 ou 2
        if (  in_array(substr($this->cns, 0, 1), [1,2]) && self::firstRotine() ) {

            return;
        }

        // Rotina de validação de Números que iniciam com 7, 8 ou 9:
        if (  in_array(substr($this->cns, 0, 1), [7,8,9]) && self::secondRotine()) {

            return;
        }

        $fail(self::CNS_INVALID_MESSAGE);
    }

    /**
     * Run the validation rule.
     * Rotina de validação de Números que iniciam com 1 ou 2:
     */
    private function firstRotine(): bool
    {
        $soma = 0.0;
        $resto = 0.0;
        $dv = 0.0;
        $resultado = "";
        $baseCalculo = 11;
        $pis = substr($this->cns, 0, $baseCalculo);

        $multiplicador = 15;

        for ($i=0; $i < $baseCalculo; $i++) {
            $soma += ((substr($pis, $i, ($i + 1))) * $multiplicador);
            $multiplicador--;
        }

        $resto = $soma % $baseCalculo;
        $dv = $baseCalculo - $resto;

        if ($dv == $baseCalculo) {
            $dv = 0;
        }

        if ($dv == 10){

            $multiplicador = 15;

            for ($i=0; $i < $baseCalculo; $i++) {
                $soma += ((substr($pis, $i, ($i + 1))) * $multiplicador);
                $multiplicador--;
            }

            $soma += 2;

            $resto = $soma % $baseCalculo;
            $dv = $baseCalculo - $resto;
            $resultado = $pis . "001" . $dv;

        } else {
            $resultado = $pis . "000" . $dv;
        }

        if (! $this->cns == $resultado){
            return(false);
        }

        return true;
    }

    /**
     * Run the validation rule.
     * Rotina de validação de Números que iniciam com 7, 8 ou 9
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function secondRotine(): bool
    {
        $soma = 0.0;
        $resto = 0.0;
        $baseCalculo = 15;
        $multiplicador = 15;

        for ($i=0; $i < $baseCalculo; $i++) {
            $soma += ((substr($this->cns, $i, 1)) * $multiplicador);
            $multiplicador--;
        }

        $resto = $soma % 11;

        if ($resto !== 0) return false;
        return true;
    }
}
