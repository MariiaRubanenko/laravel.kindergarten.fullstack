<?php

namespace App\Http\Requests;

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
            // 'phone' => 'required|string|max:255',
            'phone' => ['required', 'string', 'max:255', 'regex:/^\+380\d{9}$/'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'family_account_id' => 'nullable|exists:family_accounts,id',
        ];
    }
}
