<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name'=> $this->name,
            'description'=> $this->description,
            'image'=> $this->image,
            'user_name'=> $this->user->name,
            'user_email'=> $this->user->email,
            'category'=> $this->category->name,
            'comments' => CommentResource::collection($this->comments)
        ];
    }
}
