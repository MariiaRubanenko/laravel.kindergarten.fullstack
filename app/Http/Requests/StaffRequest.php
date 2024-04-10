<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Helpers\Helper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class StaffRequest extends FormRequest
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
            
        // 'image_name' => 'nullable|string|max:255',
        // 'image_data' => 'nullable',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        'user_id' => 'required|exists:users,id',
        'group_id' => 'nullable|exists:groups,id',
        // 'phone_number' => 'nullable|string|max:255',
        'phone_number' => ['nullable', 'string', 'max:255', 'regex:/^\+380\d{9}$/'],

        ];
    }

    public function failedValidation(Validator $validator){

        // send error message
        Helper::sendError('validation error', $validator->errors());
    }
}
