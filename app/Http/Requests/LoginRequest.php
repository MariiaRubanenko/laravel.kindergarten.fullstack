<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Helpers\Helper;
use Illuminate\Contracts\Validation\Validator;

/*Класс LoginRequest представляет собой объект запроса, который используется для валидации данных,
 полученных из представления (view), перед их обработкой в контроллере LoginController. */

class LoginRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
            'email'=>'required|email|exists:users,email',
            'password'=>'required'// обязательно для заполнения; 
        ];
    }


    public function failedValidation(Validator $validator){

        // send error message
        Helper::sendError('validation error', $validator->errors());
    }
}
