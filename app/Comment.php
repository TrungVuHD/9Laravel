<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Comment extends Model
{
    protected $fillable = [
       'comment', 'post_id', 'user_id', 'parent_id'
    ];

    public function points()
    {
        return $this->hasMany(CommentPoint::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function scopePostComments($query, $post_id)
    {
        return $query->where('post_id', $post_id)
            ->where('parent_id', 0);
    }

    public function scopePostSubComments($query, $post_id)
    {
        return $query->where('post_id', $post_id)
            ->where('parent_id', '<>', 0);
    }
}
