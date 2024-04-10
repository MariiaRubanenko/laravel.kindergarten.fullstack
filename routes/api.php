<?php

//use App\Http\Controllers\Api\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    ActionController,
    AttendanceController,
    Child_profileController,
    DayController,
    Family_accountController,
    GroupController,
    LessonController,
    LoginController,
    RegisterController,
    StaffController,
    Trusted_personController,
    UserController,

};
use App\Http\Resources\UserResource;
use App\Http\Controllers\LoginTokenController;
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
//php artisan sanctum:prune-expired комана для очищения от неактивныхтокенов за 24 часа



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return new UserResource($request->user());
});


// Route::post('/login', [LoginController::class, 'login_api'])->name('login_api');

// Route::post('/register',[RegisterController::class, 'register_api'])->name('register_api');

// Route::get('/users', [UserController::class, 'index']);

Route::apiResources([
    'users' => UserController::class,
    'family_accounts'=>Family_accountController::class,
    'child_profiles' =>Child_profileController::class,
    'attendances' => AttendanceController::class,
    'groups'=> GroupController::class,
    'staffs' => StaffController::class,
    'trusted_persons'=> Trusted_personController::class,
    'days'=> DayController::class,
    'actions'=> ActionController::class,
    'lessons'=> LessonController::class,
]);



Route::get('timetable_group/{group_id}/days/{day_id}',[LessonController::class, 'indexByGroupAndDay'] );
Route::get('absent_сhildren/{group_id}/date/{date}', [AttendanceController::class, 'absentChildrenByGroupAndDate']);
Route::get('children_without_group', [Child_profileController::class, 'childrenWithoutGroup']);
Route::get('staffs_without_group', [StaffController::class, 'staffsWithoutGroup']);


Route::group(['middleware'=>['auth:sanctum']], function(){
    Route::get('/test',[UserController::class, 'index'] );
    // Route::get('/test2',[GroupController::class, 'index'] );

    
    Route::post('/register',[RegisterController::class, 'register_api'])->name('register_api');
    Route::post('/create_group',[GroupController::class, 'store']);
    Route::post('/create_active',[ActionController::class, 'store']);

    Route::post('/change_password', [UserController::class, 'changePassword']);

    // Route::delete('/logout', [LoginController::class, 'destroy']);
});

Route::group(['middleware' => ['auth:sanctum', 'role:teacher']], function () {
    Route::get('/test2',[GroupController::class, 'index'] );
});

// For mobile auth
Route::post('/login_token', [LoginTokenController::class, 'store']);
Route::delete('/delete_tokens/', [LoginTokenController::class, 'destroy']);
