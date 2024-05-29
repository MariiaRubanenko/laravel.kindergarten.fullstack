<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\Helper;
use App\Http\Resources\UserResource;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Family_account;
use App\Models\Staff;

use App\Notifications\NewUserNotification;




class RegisterController extends Controller
{
    public function register_api(RegisterRequest $request){
    
        $password_notif = $request->password;
        
        //register user
        $user= User::create([
            'name' =>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);


        $roleName = $request->role;
        $role = Role::where('name', $roleName)->first();
        if($role){
            $user->assignRole($role); 
        }

        
         if ($roleName === 'parent') {

        $this->createFamilyAccount($user);
        
        } else if ($roleName === 'teacher') {
            
            $this->createStaffAccount($user);
        }
         else if ($roleName === 'admin') {
           
           
        }
        
        $message = "You are registered as a ".$roleName." on our website Happy Times. ";
        $user->notify( new NewUserNotification($password_notif, $message, $request->name));
        
        return response($user, Response::HTTP_CREATED);
    }

    protected function createFamilyAccount($user)
    {
        Family_account::create(['user_id' => $user->id]);
    }

    protected function createStaffAccount($user)
    {
        Staff::create(['user_id' => $user->id]);
    }


}
