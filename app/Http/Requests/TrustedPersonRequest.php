<?php

namespace App\Http\Requests;
use App\Http\Helpers\Helper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class TrustedPersonRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => ['required', 'string', 'max:255', 'regex:/^\+380\d{9}$/'],
            'image' => ['nullable', new \App\Rules\Base64Image],
            'family_account_id' => 'nullable|exists:family_accounts,id',
        ];
    }
    public function failedValidation(Validator $validator){

        Helper::sendError('validation error', $validator->errors());
    }
}
