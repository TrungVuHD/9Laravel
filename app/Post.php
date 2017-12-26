<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The array of fillable properties
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'attribution',
        'cat_id'
    ];

    /**
     * The Post-Point relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function points()
    {
        return $this->hasMany(Point::class);
    }

    /**
     * The Post-User relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The Post-Category relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * The Post-Comment relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The Post-Report relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    /**
     * The next scope function: Post::next()
     *
     * @param $query
     * @param $id
     * @return mixed
     */
    public function scopeNext($query, $id)
    {
        return $query->where('id', '>', $id);
    }

    /**
     * The slug scope function: Post::slug()
     *
     * @param $query
     * @param $slug
     * @return mixed
     */
    public function scopeSlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    /**
     * Return the number of points of a post
     *
     * @return int
     */
    public function noPoints()
    {
        return (int) count($this->points);
    }
}
