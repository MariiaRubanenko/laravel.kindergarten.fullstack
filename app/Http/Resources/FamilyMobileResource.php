<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FamilyMobileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id'=> $this->user_id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'family_account_id' => $this->id,
            'child_profiles' => $this->child_profiles->pluck('id'),
            'trusted_persons' => $this->trusted_persons->pluck('id'),
            'image_data' => $this->image_data ? base64_encode($this->image_data) : null,
            'phone'=>$this->phone_number,
        ];
    }
}
