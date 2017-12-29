<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * @var array The mass-assignable properties
     */
    protected $fillable = [
       'comment',
        'post_id',
        'user_id',
        'parent_id'
    ];

    /**
     * The subcomments relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subcomments()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }

    /**
     * The points relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function points()
    {
        return $this->hasMany(CommentPoint::class);
    }

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
     * The postComments scope method
     *
     * @param $query
     * @param $post_id
     * @return mixed
     */
    public function scopePostComments($query, $post_id)
    {
        return $query->where('post_id', $post_id)
            ->where('parent_id', 0)
            ->where('user_id', '<>', 0);
    }

    /**
     * The postSubComments scope method
     *
     * @param $query
     * @param $post_id
     * @return mixed
     */
    public function scopePostSubComments($query, $post_id)
    {
        return $query->where('post_id', $post_id)
            ->where('parent_id', '<>', 0)
            ->where('user_id', '<>', 0);
    }
}
