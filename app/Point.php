<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Point extends Model
{
    /**
     * The user relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The post relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * The thumbUp scope method
     *
     * @param $query
     * @param $post_id
     * @return mixed
     */
    public function scopeThumbUp($query, $post_id)
    {
        return $query->where('post_id', $post_id)
            ->where('user_id', Auth::id());
    }
}
