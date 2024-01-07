<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CPF implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cpfUnderValidation = preg_replace('/\D/', '', $value);

        if (strlen($cpfUnderValidation) != 11 || preg_match("/^{$cpfUnderValidation[0]}{11}$/", $cpfUnderValidation)) {
            $fail('O CPF fornecido não possui 11 dígitos válidos ou contém todos os números iguais.');

            return;
        }

        for ($s = 10, $n = 0, $i = 0; $s >= 2; $n += $cpfUnderValidation[$i++] * $s--);

        if ($cpfUnderValidation[9] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            $fail('O primeiro dígito verificador do CPF não está correto.');

            return;
        }

        for ($s = 11, $n = 0, $i = 0; $s >= 2; $n += $cpfUnderValidation[$i++] * $s--);

        if ($cpfUnderValidation[10] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            $fail('O segundo dígito verificador do CPF não está correto.');
        }
    }
}
