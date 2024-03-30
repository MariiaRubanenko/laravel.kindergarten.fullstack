<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_lesson'=>$this->id,
            'start_time'=>$this->start_time,
            'end_time'=>$this->end_time,
            'id_group'=>$this->group->id,
            'group_name'=> $this-> group->name,
            'id_day'=>$this->day->id,
            'day_of_week'=> $this-> day->name,
            'id_action'=>$this->action->id,
            'action_name'=> $this-> action->name,
        ];
    }
}
