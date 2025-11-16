<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IndonesianPhoneNumber implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $isValid = (bool) preg_match('/^08[1-9]{1}\d{1}-{1}\d{4}-\d{2,5}$/', $value);

        if (!$isValid) {
            $fail('The ' . $attribute . ' is not an Indonesian phone number of the required format');
        }
    }
}
