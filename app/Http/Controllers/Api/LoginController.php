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

        

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
