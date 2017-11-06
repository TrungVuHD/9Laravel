<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Point extends Model
{

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function scopeThumbUp($query, $post_id)
    {
        return $query->where('post_id', $post_id)
            ->where('user_id', Auth::id());
    }
}
