<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\Helper;
use App\Http\Resources\UserResource;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Family_account;




class RegisterController extends Controller
{
    public function register_api(RegisterRequest $request){
    
        //register user
        $user= User::create([
            'name' =>$request->name,   // name это поле обьекта request, а 'name' это ключ масива, а так же поле обьекта User
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);


        $roleName = $request->role;
        $role = Role::where('name', $roleName)->first();
        if($role){
            $user->assignRole($role); 
        }

        // Проверяем, если роль пользователя - "parent"
         if ($roleName === 'parent') {

        // Создаем запись в таблице family_accounts
        $this->createFamilyAccount($user);
        }
        

        return new UserResource($user);
    }

    protected function createFamilyAccount($user)
    {
        Family_account::create(['user_id' => $user->id]);
    }




}
