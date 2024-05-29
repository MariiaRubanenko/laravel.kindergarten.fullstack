<?php

// namespace App\Rules;

// use Closure;
// use Illuminate\Contracts\Validation\ValidationRule;

// class Base64Image implements ValidationRule
// {
//     /**
//      * Run the validation rule.
//      *
//      * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
//      */
//     public function validate(string $attribute, mixed $value, Closure $fail): void
//     {
//         //
//     }
// }
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class Base64Image implements Rule
{
    public function passes($attribute, $value)
    {
        if (!Str::startsWith($value, 'data:image')) {
            return false;
        }

        $base64 = substr($value, strpos($value, ',') + 1);
        $decoded = base64_decode($base64);

        if ($decoded === false) {
            return false;
        }

        $imageInfo = getimagesizefromstring($decoded);

        return $imageInfo !== false;
    }

    public function message()
    {
        return 'The :attribute must be a valid base64 image.';
    }
}

