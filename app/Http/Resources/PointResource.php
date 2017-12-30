<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PointResource extends Resource
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
            'post_id' => $this->post_id ?? null,
            'user_id' => $this->user_id ?? null,
            'created_at' => $this->created_at ?? null,
            'updated_at' => $this->updated_at ?? null
        ];
    }
}
