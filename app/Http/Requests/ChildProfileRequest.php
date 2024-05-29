<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Helpers\Helper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class ChildProfileRequest extends FormRequest
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
            'gender' => 'required|string|in:male,female',
            'birthday' => 'required|date',
            'allergies' => 'nullable|string|max:255',
            'illnesses' => 'nullable|string|max:255',
            'image' => ['nullable', new \App\Rules\Base64Image],
            'family_account_id' => 'required|exists:family_accounts,id',
            'group_id' => 'nullable|exists:groups,id',
        ];
    }

    public function failedValidation(Validator $validator){

        Helper::sendError('validation error', $validator->errors());
    }
}
