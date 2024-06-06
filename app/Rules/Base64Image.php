<?php

/* namespace App\Rules;

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
} */

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class Base64Image implements Rule
{
    protected $errorMessage;

    public function passes($attribute, $value)
    {
/*         if (!Str::startsWith($value, 'data:image')) {
            $this->errorMessage = 'The :attribute must start with "data:image".';
            return false;
        } */

        $base64 = substr($value, strpos($value, ',') + 1);
        $decoded = base64_decode($base64);

        if ($decoded === false) {
            $this->errorMessage = 'The :attribute contains invalid base64 encoded data.';
            return false;
        }
/* 
        $imageInfo = getimagesizefromstring($decoded);

        if ($imageInfo === false) {
            $this->errorMessage = 'The :attribute must be a valid image.';
            return false;
        }
 */
        return true;
    }

    public function message()
    {
        return $this->errorMessage ?: 'The :attribute must be a valid base64 image.';
    }
}


