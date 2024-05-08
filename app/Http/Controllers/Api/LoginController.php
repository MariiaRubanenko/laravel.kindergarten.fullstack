<?php
/*Этот контроллер обрабатывает запросы на аутентификацию через API и возвращает информацию о пользователе в формате JSON.
 Он является частью вашего API для работы с пользователями в вашем приложении.
*/

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\Helper;
use App\Http\Resources\UserResource;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\User;
use Illuminate\Http\Response;



use Illuminate\Http\Resources\Json\JsonResource;
;


class LoginController extends Controller
{
    // public function login_api(LoginRequest $request){
    
    //     //login user
    //     //return true;
    //     // if(!Auth::attempt($request->only('email','password'))){ // проверка есть ли пользователь с таким именем и совпадает ли пароль
    //     //     Helper::sendError('Email or Password is wrong !!!');
    //     // }
    //     // //send response

    //     // // return new UserResource(auth()->user()); // если аутентификация прошла успешно, создается новый экземпляр UserResource, который представляет аутентифицированного пользователя. 
    //     // $user = Auth::user();
    //     // // $token = $user->createToken('authToken')->plainTextToken;
        
    //     // if ($user instanceof \App\Models\User) {
    //     //     // Hinting here for $user will be specific to the User object
           
    //     //     $token = $user->createToken('authToken')->plainTextToken;
    //     // } 

    //     // // return response()->json(['token' => $token, 'user' => $user]);
    //     // // return new UserResource($user, $token);

    //     // return response()->json(['token' => $token]); 


        
    //     /*
    //     при успешной аутентификации метод login вернет данные пользователя в формате,
    //      определенном в UserResource, который затем будет возвращен клиенту в формате JSON.
    //     */
        

    //     /*При обработке HTTP-запроса Laravel анализирует его маршрут и, когда определяется, что запрос
    //      должен быть обработан методом login контроллера LoginController,
    //      Laravel автоматически создает экземпляр класса LoginRequest с данными из запроса.
    //     Когда Laravel создает экземпляр LoginRequest, он заполняет его данными из HTTP-запроса,
    //     соответствующими правилам валидации, определенным в методе rules класса LoginRequest.
    //     Этот процесс позволяет Laravel автоматически
    //     проверять и валидировать данные запроса перед передачей их в метод login для дальнейшей обработки. */
    //     // $credentials = $request->validate([
    //     //     'email' => ['required', 'string', 'email'],
    //     //     'password' => ['required', 'string'],
    //     // ]);

    //     $credentials = $request->validate();

    //     if (Auth::attempt($credentials)) {
    //         $request->session()->regenerate();

    //         return response($request->user(), Response::HTTP_CREATED);
    //     }

    //     return response([
    //         'email' => 'The provided credentials do not match our records.',
    //     ], Response::HTTP_UNPROCESSABLE_ENTITY);

    // }

    public function login_api(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // return response($request->user(), Response::HTTP_CREATED);
            return new UserResource($request->user());
        }

        return response([
            'message' => 'The provided credentials do not match our records.',
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

        // public function logout(PersonalAccessToken $token)
        // {
        //     // $request->user()->tokens->where(id, );
        //     $token->delete();
        // }
    //     public function logout(Request $request)
    // {
    //     $request->user()->tokens()->delete();

    //     return response()->json('Logged out successfully');
    // }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
