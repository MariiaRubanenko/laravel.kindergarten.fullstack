<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'=>$this->family_account->user->name,
            'image_data' => base64_encode($this->family_account->image_data),
            'text'=>$this->text,
            'created_at'=>$this->created_at->format('Y-m-d'), 
        ];

    }
}
