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
        return [
            'user_id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'roles' => $this->roles->map(function($role) {
                return [
                    'id'=> $role->id,
                    'name' => $role->name,
                    'permissions' => $role->permissions->pluck('name') ?? [],
                ];
            }),
            'staff_id' => $this->staffs->isNotEmpty() ? $this->staffs->pluck('id') : [],
            'family_account_id' => $this->family_accounts->isNotEmpty() ? $this->family_accounts->pluck('id') : [],
        ];
        
    }
}
