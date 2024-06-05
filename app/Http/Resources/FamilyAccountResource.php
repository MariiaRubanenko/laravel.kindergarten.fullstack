<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FamilyAccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'family_account_id' => $this->id,
            'user_id'=> $this->user_id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'child_profiles'=> FamilyAccountChildProfileResource::collection($this->child_profiles),
            'trusted_persons'=>TrustedPersonResource::collection($this->trusted_persons),
            'image_data' => $this->image_data ? base64_encode($this->image_data) : null,
            'phone'=>$this->phone_number,
        ];
    }
}
