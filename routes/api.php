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
    Daily_priceController,
    MonthController,
    PaymentController

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
//X-XSRF-TOKEN


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return new UserResource($request->user());
});


// Route::post('/login', [LoginController::class, 'login_api'])->name('login_api');

// Route::post('/register',[RegisterController::class, 'register_api'])->name('register_api');

// Route::get('/users', [UserController::class, 'index']);

Route::apiResources([
    // 'users' => UserController::class,                   // только админ
    // 'family_accounts'=>Family_accountController::class, //только админ, родитель свой акк
    // 'child_profiles' =>Child_profileController::class,  //
    // 'attendances' => AttendanceController::class,       //
    // 'groups'=> GroupController::class,                  //
    // 'staffs' => StaffController::class,                 //
    // 'trusted_persons'=> Trusted_personController::class,//
    // 'days'=> DayController::class,                      //
    // 'actions'=> ActionController::class,                //
    // 'lessons'=> LessonController::class,                //
]);


Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function () {
    Route::get('/users',[UserController::class, 'index'] );
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
    Route::post('/register',[RegisterController::class, 'register_api'])->name('register_api');
    Route::get('/users/{user}',[UserController::class, 'show'] );

    Route::get('/staffs',[StaffController::class, 'index'] );
    Route::get('staffs_without_group', [StaffController::class, 'staffsWithoutGroup']);

    Route::get('/family_accounts',[Family_accountController::class, 'index'] );
    // Route::post('/send_email',[Family_accountController::class, 'sendParentEmail'] );
    // Route::get('/family_accounts/{family_account}',[Family_accountController::class, 'show'] );

    Route::get('/child_profiles',[Child_profileController::class, 'index'] );
    Route::post('/child_profiles',[Child_profileController::class, 'store'] );
    Route::delete('/child_profiles/{child_profile}',[Child_profileController::class, 'destroy'] );
    Route::get('children_without_group', [Child_profileController::class, 'childrenWithoutGroup']);

    Route::get('/groups',[GroupController::class, 'index'] );
    Route::put('/groups/{group}',[GroupController::class, 'update'] );
    Route::post('/groups',[GroupController::class, 'store'] );
    Route::delete('/groups/{group}',[GroupController::class, 'destroy'] );

    Route::delete('/actions/{action}',[ActionController::class, 'destroy'] );

    Route::get('/lessons',[LessonController::class, 'index'] );
  

    Route::get('/months',[MonthController::class, 'index'] );
    Route::get('/months/{month}',[MonthController::class, 'show'] );

    Route::get('/daily_prices',[Daily_priceController::class, 'index'] );
    Route::get('/daily_prices/{daily_price}',[Daily_priceController::class, 'show'] );
    Route::post('/daily_prices',[Daily_priceController::class, 'store'] );
});


Route::group(['middleware' => ['auth:sanctum', 'role:admin|teacher']], function () {
    // Route::put('/users/{user}', [UserController::class, 'update']);
    Route::put('/staffs/{staff}', [StaffController::class, 'update']);
    Route::get('/groups/{group}',[GroupController::class, 'show'] );
    Route::get('absent_сhildren/{group_id}/date/{date}', [AttendanceController::class, 'absentChildrenByGroupAndDate']);

    Route::get('/actions',[ActionController::class, 'index'] );
    Route::get('/actions/{action}',[ActionController::class, 'show'] );
    Route::post('/actions',[ActionController::class, 'store'] );
    Route::put('/actions/{action}',[ActionController::class, 'update'] );   

    Route::post('/lessons',[LessonController::class, 'store'] );
    Route::put('/lessons',[LessonController::class, 'update'] );
    Route::delete('/lessons/{lesson}',[LessonController::class, 'destroy'] );
    Route::get('timetable_group/{group_id}/days/{day_id}',[LessonController::class, 'indexByGroupAndDay'] );
    Route::get('index_by_group_for_week/{group_id}',[LessonController::class, 'indexByGroupForWeek'] );

    Route::get('/days',[DayController::class, 'index'] );
    Route::get('/days/{day}',[DayController::class, 'show'] );

    // Route::get('/family_accounts/{family_account}',[Family_accountController::class, 'show'] );
    Route::post('/send_email',[Family_accountController::class, 'sendParentEmail'] );
    Route::get('/family_accountsByGroup/{group}',[Family_accountController::class, 'getFamilyAccountIdsByGroup'] );


    //Test
    Route::put('/saveImage/{id}',[StaffController::class, 'saveImage'] ); 

    

});



Route::group(['middleware' => ['auth:sanctum', 'role:admin|parent']], function () {
    
    Route::put('/child_profiles/{child_profile}',[Child_profileController::class, 'update'] );

    Route::delete('/trusted_persons',[Trusted_personController::class, 'destroy'] );

    Route::get('/payments',[PaymentController::class, 'index'] );
    Route::get('/payments/{payment}',[PaymentController::class, 'show'] );
    Route::get('/family_account_payments/{family_account_id}',[PaymentController::class, 'paymentsByFamilyAccountId'] );

    Route::put('/family_accounts/{family_account}',[Family_accountController::class, 'update'] );
    Route::get('/family_accounts/{family_account}',[Family_accountController::class, 'show'] );
    Route::get('/family_accounts_mobile/{family_account}',[Family_accountController::class, 'showForMobile'] );

    Route::get('/staffsWithGroup/{child_id}',[StaffController::class, 'staffsWithGroup'] );
});


Route::group(['middleware' => ['auth:sanctum', 'role:parent']], function () {
    
    Route::post('/attendances',[AttendanceController::class, 'store'] );

    Route::post('/trusted_persons',[Trusted_personController::class, 'store'] );

    Route::post('/comment',[Family_accountController::class, 'storeComment'] );
    
});



Route::group(['middleware'=>['auth:sanctum']], function(){
    
    Route::post('/change_password', [UserController::class, 'changePassword']);
    Route::get('/staffs/{staff}',[StaffController::class, 'show'] );

    Route::get('/child_profiles/{child_profile}',[Child_profileController::class, 'show'] );

    Route::get('/attendances/{attendance}',[AttendanceController::class, 'show'] );
    Route::get('/attendances',[AttendanceController::class, 'index'] );

    Route::get('/trusted_persons',[Trusted_personController::class, 'index'] );
    Route::get('/trusted_persons/{trusted_person}',[Trusted_personController::class, 'show'] );
   

    // Route::post('/session', 'App\Http\Controllers\StripeController@session')->name('session');
});
















// Route::group(['middleware'=>['auth:sanctum']], function(){
//     Route::get('/test',[UserController::class, 'index'] );
   
//     Route::post('/create_group',[GroupController::class, 'store']);
//     Route::post('/create_active',[ActionController::class, 'store']);
//     Route::post('/change_password', [UserController::class, 'changePassword']);
// });

// Route::group(['middleware' => ['auth:sanctum', 'role:teacher']], function () {
//     Route::get('/test2',[GroupController::class, 'index'] );
// });










// For mobile auth
Route::post('/login_token', [LoginTokenController::class, 'store']);
Route::delete('/delete_tokens', [LoginTokenController::class, 'destroy']);
