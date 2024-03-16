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
            //'image_data'=>$this->image_data,
            'image_data' => base64_encode($this->image_data), // изменение для отображения изображения
            'attendances'=>ChildProfileAttendanceResource::collection($this->attendances),
        ];
        

    }
}

