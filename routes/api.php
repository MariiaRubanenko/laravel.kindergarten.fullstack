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


Route::group(['prefix' => 'api','middleware' => ['auth:sanctum', 'role:admin']], function () {
    Route::get('/users',[UserController::class, 'index'] );
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
    Route::post('/register',[RegisterController::class, 'register_api'])->name('register_api');
    Route::get('/users/{user}',[UserController::class, 'show'] );

    Route::get('/staffs',[StaffController::class, 'index'] );
    Route::get('staffs_without_group', [StaffController::class, 'staffsWithoutGroup']);

    Route::get('/family_accounts',[Family_accountController::class, 'index'] );

    Route::get('/child_profiles',[Child_profileController::class, 'index'] );
    Route::post('/child_profiles',[Child_profileController::class, 'store'] );
    Route::delete('/child_profiles/{child_profile}',[Child_profileController::class, 'destroy'] );
    Route::get('children_without_group', [Child_profileController::class, 'childrenWithoutGroup']);

    Route::get('/groups',[GroupController::class, 'index'] );
    Route::put('/groups/{group}',[GroupController::class, 'update'] );
    Route::post('/groups',[GroupController::class, 'store'] );
    Route::delete('/groups/{group}',[GroupController::class, 'destroy'] );

    Route::delete('/actions/{action}',[ActionController::class, 'destroy'] );

    Route::get('/months',[MonthController::class, 'index'] );
    Route::get('/months/{month}',[MonthController::class, 'show'] );

    Route::get('/daily_prices',[Daily_priceController::class, 'index'] );
    Route::get('/daily_prices/{daily_price}',[Daily_priceController::class, 'show'] );
    Route::post('/daily_prices',[Daily_priceController::class, 'store'] );
});


Route::group(['prefix' => 'api','middleware' => ['auth:sanctum', 'role:admin|teacher']], function () {

   
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
    

    Route::get('/days',[DayController::class, 'index'] );
    Route::get('/days/{day}',[DayController::class, 'show'] );

    // Route::get('/family_accounts/{family_account}',[Family_accountController::class, 'show'] );
    Route::post('/send_email',[Family_accountController::class, 'sendParentEmail'] );
    Route::get('/family_accountsByGroup/{group}',[Family_accountController::class, 'getFamilyAccountIdsByGroup'] );

});



Route::group(['prefix' => 'api','middleware' => ['auth:sanctum', 'role:admin|parent']], function () {
    
    Route::put('/child_profiles/{child_profile}',[Child_profileController::class, 'update'] );

    Route::delete('/trusted_persons/{trusted_person}',[Trusted_personController::class, 'destroy'] );
    
    Route::get('/payments',[PaymentController::class, 'index'] );
    Route::get('/payments/{payment}',[PaymentController::class, 'show'] );
    Route::get('/family_account_payments/{family_account_id}',[PaymentController::class, 'paymentsByFamilyAccountId'] );

    Route::put('/family_accounts/{family_account}',[Family_accountController::class, 'update'] );
    
    Route::get('/family_accounts_mobile/{family_account}',[Family_accountController::class, 'showForMobile'] );

    Route::get('/staffsWithGroup/{child_id}',[StaffController::class, 'staffsWithGroup'] );
  
});


Route::group(['prefix' => 'api','middleware' => ['auth:sanctum', 'role:parent']], function () {
    
    Route::post('/attendances',[AttendanceController::class, 'store'] );

    Route::post('/trusted_persons',[Trusted_personController::class, 'store'] );

    Route::post('/comment',[Family_accountController::class, 'storeComment'] );

    Route::put('/trusted_persons/{trusted_person}',[Trusted_personController::class, 'update'] );

    Route::get('/download-apk', function () {
        $file = public_path('apk/HappyTimes.apk'); // Шлях до файлу в папці public
        return response()->download($file);
    });
    
});



Route::group(['prefix' => 'api','middleware'=>['auth:sanctum']], function(){
    
    Route::post('/change_password', [UserController::class, 'changePassword']);
    Route::get('/staffs/{staff}',[StaffController::class, 'show'] );

    Route::get('/child_profiles/{child_profile}',[Child_profileController::class, 'show'] );

    Route::get('/attendances/{attendance}',[AttendanceController::class, 'show'] );
    Route::get('/attendances',[AttendanceController::class, 'index'] );

    Route::get('/trusted_persons',[Trusted_personController::class, 'index'] );
    Route::get('/trusted_persons/{trusted_person}',[Trusted_personController::class, 'show'] );
   
    Route::get('/lessons',[LessonController::class, 'index'] );
    Route::get('timetable_group/{group_id}/days/{day_id}',[LessonController::class, 'indexByGroupAndDay'] );
    Route::get('index_by_group_for_week/{group_id}',[LessonController::class, 'indexByGroupForWeek'] );
    // Route::post('/session', 'App\Http\Controllers\StripeController@session')->name('session');

       Route::get('/family_accounts/{family_account}',[Family_accountController::class, 'show'] );
});







// For mobile auth
Route::post('/api/login_token', [LoginTokenController::class, 'store']);
Route::delete('/api/delete_tokens', [LoginTokenController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/api/comments', [Family_accountController::class, 'indexComment']);