<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);

        // return[
        //     // 'redirect_url' => route('log_home', ['id' => $this->id])
        //     'user_id'=> $this->id,
        //     'name'   =>$this->name,
        //     'email'  =>$this->email,
        //     'token'  =>$this->createToken("Token")->plainTextToken,
        //     'roles'  =>$this->roles->pluck('name')??[],
        //      'roles.permissions'=>$this->getPermissionsViaRoles()->pluck(['name'])??[],
           
        // ];
        return [
            'user_id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            // 'token' => $this->createToken("Token")->plainTextToken,
            // 'token' => $this->when($this->token, $this->token),
            'roles' => $this->roles->map(function($role) {
                return [
                    'id'=> $role->id,
                    'name' => $role->name,
                    'permissions' => $role->permissions->pluck('name') ?? [],
                ];
            }),
            // 'family_accounts'=>UserFamilyAccountResource::collection($this->family_accounts),
        ];
        
    }
    // public function with($request)
    // {
    //     return [
    //         'token' => $this->token,
    //     ];
    // }
}

/*
Этот класс UserResource является ресурсом для форматирования данных пользователя перед их 
возвратом в качестве ответа на API запросы. Он наследуется от JsonResource, 
который предоставляет удобный способ форматировать ресурсы для ответов API в формате JSON.
*/

/**
 *  'permissions'=>$this->permissions->pluck('name')??[]
*           'roles'  =>$this->roles,
  *           'permissions'=>$this->permissions */