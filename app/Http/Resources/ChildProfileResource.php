<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChildProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'gender'=> $this->gender,
            'birthday'=>$this->birthday,
            'allergies'=>$this->allergies,
            'illnesses'=>$this->illnesses,
            //'family_accounts'=>UserFamilyAccountResource::collection($this->family_accounts),
            'attendances'=>ChildProfileAttendanceResource::collection($this->attendances),
        ];
    }
}

