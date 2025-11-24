<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PastDate implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $todayTime = Carbon::today();
        $valueTime = Carbon::parse($value);
        
        if (! $valueTime->isBefore($todayTime)) {
            $fail('The ' . $attribute . ' must be past date');
        }
    }
}
