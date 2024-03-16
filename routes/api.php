<?php

//use App\Http\Controllers\Api\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AttendanceController,
    Child_profileController,
    Family_accountController,
    GroupController,
    LoginController,
    RegisterController,
    StaffController,
    UserController,

};
use App\Http\Resources\UserResource;
// use App\Http\Controllers\Api\{
//     LoginController
// };

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return new UserResource($request->user());
});


Route::post('/login', [LoginController::class, 'login_api'])->name('login_api');

Route::post('/register',[RegisterController::class, 'register_api'])->name('register_api');

// Route::get('/users', [UserController::class, 'index']);

Route::apiResources([
    'users' => UserController::class,
    'family_accounts'=>Family_accountController::class,
    'child_profiles' =>Child_profileController::class,
    'attendances' => AttendanceController::class,
    'groups'=> GroupController::class,
    'staffs' => StaffController::class,
]);



Route::group(['middleware'=>['auth:sanctum']], function(){
    Route::get('/test',[UserController::class, 'index'] );
});
