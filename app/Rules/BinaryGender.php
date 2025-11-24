<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BinaryGender implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $validGenders = ['male', 'female'];
        $valueLowerCase = strtolower($value);
        if (false === array_search($valueLowerCase, $validGenders)) {
            $fail('The ' . $attribute . ' must be either male or female');
        }
    }
}
