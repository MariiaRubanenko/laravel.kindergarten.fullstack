<?php


use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    
    RegisterController,
    LoginController,
    Family_accountController,
    

};
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'home'])->name('home');


Route::get('/login',[AuthController::class, 'login'])->name ('login');
// Route::get('/register',[AuthController::class, 'register'])->name ('register')->middleware('auth');

// Route::post('/register',[RegisterController::class, 'register_api'])->name('register_api');

Route::post('/login', [LoginController::class, 'login_api'])->name('login_api')->middleware('guest');
Route::delete('/logout', [LoginController::class, 'destroy'])->middleware('auth');

Route::get('/comments', [Family_accountController::class, 'indexComment']);


//Payment
Route::get('/checkout', 'App\Http\Controllers\StripeController@checkout')->name('checkout');
Route::post('/session', 'App\Http\Controllers\StripeController@session')->name('session');
Route::post('/cancel', 'App\Http\Controllers\StripeController@session')->name('cancel');
Route::get('/success', 'App\Http\Controllers\StripeController@success')->name('success');
