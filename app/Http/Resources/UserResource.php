<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            "avatar" => 'https://cdn.learnku.com/uploads/images/201710/14/1/s5ehp11z6s.png',
            "email" => $this->email,
            'created_at' => $this->created_at->format('Y-m-d H:i'),
        ];
    }
}
