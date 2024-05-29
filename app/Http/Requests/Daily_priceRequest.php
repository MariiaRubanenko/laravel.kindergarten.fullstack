<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Helpers\Helper;
use Illuminate\Contracts\Validation\Validator;

class Daily_priceRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'price' => 'required|numeric',
            
            'price' => 'required|numeric|min:0|gt:3',
            // 'year' => 'required|integer|min:' . date('Y'),
            'month_id' => 'nullable|exists:months,id',
        ];
    }

    public function failedValidation(Validator $validator){

        // send error message
        Helper::sendError('validation error', $validator->errors());
    }
}
