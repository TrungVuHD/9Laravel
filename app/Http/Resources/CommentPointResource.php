<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CommentPointResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id ?? null,
            'comment_id' => $this->comment_id ?? null,
            'user_id' => $this->user_id ?? null,
            'created_at' => $this->created_at ?? null,
            'updated_at' => $this->updated_at ?? null
        ];
    }
}
