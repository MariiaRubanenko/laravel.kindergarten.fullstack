<?php
/*Этот контроллер обрабатывает запросы на аутентификацию через API и возвращает информацию о пользователе в формате JSON.
 Он является частью вашего API для работы с пользователями в вашем приложении.
*/

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\Helper;
use App\Http\Resources\UserResource;


class LoginController extends Controller
{
    public function login_api(LoginRequest $request){
    
        //login user
        //return true;
        if(!Auth::attempt($request->only('email','password'))){ // проверка есть ли пользователь с таким именем и совпадает ли пароль
            Helper::sendError('Email or Password is wrong !!!');
        }
        //send response

        return new UserResource(auth()->user()); // если аутентификация прошла успешно, создается новый экземпляр UserResource, который представляет аутентифицированного пользователя. 
        /*
        при успешной аутентификации метод login вернет данные пользователя в формате,
         определенном в UserResource, который затем будет возвращен клиенту в формате JSON.
        */
        

        /*При обработке HTTP-запроса Laravel анализирует его маршрут и, когда определяется, что запрос
         должен быть обработан методом login контроллера LoginController,
         Laravel автоматически создает экземпляр класса LoginRequest с данными из запроса.
        Когда Laravel создает экземпляр LoginRequest, он заполняет его данными из HTTP-запроса,
        соответствующими правилам валидации, определенным в методе rules класса LoginRequest.
        Этот процесс позволяет Laravel автоматически
        проверять и валидировать данные запроса перед передачей их в метод login для дальнейшей обработки. */
    }
}
