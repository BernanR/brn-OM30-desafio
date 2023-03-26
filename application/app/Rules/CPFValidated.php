<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CPFValidated implements ValidationRule
{
    PRIVATE $cpf;
    CONST CPF_INVALID_MESSAGE = "O cpf informado é inválido!";

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->cpf = $value;

        // Remove any non-digit characters
        $this->cpf = preg_replace('/[^0-9]/', '', $this->cpf);

        // Verify CPF length
        if (strlen($this->cpf) != 11) {

            $fail(self::CPF_INVALID_MESSAGE);
            return;
        }

        // Verify if all digits are the same (e.g. 11111111111)
        if (preg_match('/^(\d)\1*$/', $this->cpf)) {
            $fail(self::CPF_INVALID_MESSAGE);
            return;
        }

        // Calculate the first verification digit
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += (int) $this->cpf[$i] * (10 - $i);
        }
        $digit1 = 11 - ($sum % 11);
        if ($digit1 >= 10) {
            $digit1 = 0;
        }

        // Calculate the second verification digit
        $sum = 0;
        for ($i = 0; $i < 9; $i++) {
            $sum += (int) $this->cpf[$i] * (11 - $i);
        }
        $sum += $digit1 * 2;
        $digit2 = 11 - ($sum % 11);
        if ($digit2 >= 10) {
            $digit2 = 0;
        }

        // Verify if the verification digits match
        if ($this->cpf[9] != $digit1 || $this->cpf[10] != $digit2) {
            $fail(self::CPF_INVALID_MESSAGE);
            return;
        }

        // CPF is valid
        return;
    }
}
