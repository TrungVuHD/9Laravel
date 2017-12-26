<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PostResource extends Resource
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
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'slug' => $this->slug,
            'attribution' => $this->attribution,
            'nfsw' => $this->nsfw,
            'cat_id' => $this->cat_id,
            'user_id' => $this->user_id,
            'gif' => $this->gif,
            'tall_image' => $this->tall_image
        ];
    }
}
