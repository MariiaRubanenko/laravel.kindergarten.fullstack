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
            'child_profiles'=> FamilyAccountChildProfileResource::collection($this->child_profiles),
            // 'family_accounts'=>UserFamilyAccountResource::collection($this->family_accounts),
        ];
    }
}
