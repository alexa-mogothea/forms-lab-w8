<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidCourseCode implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || ! preg_match('/^[A-Z]{3,7}\d$/', $value)) {
            $fail('The :attribute must be 3–7 capital letters '
                . 'followed by one digit, e.g. WEBDEV3.');
        }
    }
}
