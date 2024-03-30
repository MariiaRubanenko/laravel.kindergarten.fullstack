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
            'id'=>$this->id,
            'name' => $this->name,
            'gender'=> $this->gender,
            'birthday'=>$this->birthday,
            'allergies'=>$this->allergies,
            'illnesses'=>$this->illnesses,
            //'image_data'=>$this->image_data,
            'image_data' => base64_encode($this->image_data), // изменение для отображения изображения
            'attendances'=>ChildProfileAttendanceResource::collection($this->attendances),
            'group_id'=>$this->group_id,
            'group_name' => $this->group ? $this->group->name : null,
            // 'family_account_id'=>$this->family_account->id,
            'family_account_id' => $this->family_account ? $this->family_account->id : null,
        ];
        

    }
}

