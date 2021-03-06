<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    const IMG_DIR = 'posts';

    /**
     * The array of fillable properties
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'nsfw',
        'image',
        'tall_image',
        'gif',
        'attribution',
        'user_id',
        'cat_id',
        'slug'
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
        return (int) $this->points->count();
    }

    /**
     * The hot scope function for retrieving the hot posts
     *
     * @param $query
     * @return mixed
     */
    public function scopeHot($query)
    {
        return $query->leftJoin('points', 'points.post_id', '=', 'posts.id')
            ->groupBy(['posts.id', 'posts.title', 'posts.slug'])
            ->havingRaw('COUNT(points.id) >= 40')
            ->orderBy('posts.id', 'DESC');
    }

    /**
     * The hot scope function for retrieving the trending posts
     *
     * @param $query
     * @return mixed
     */
    public function scopeTrending($query)
    {
        return $query->leftJoin('points', 'points.post_id', '=', 'posts.id')
            ->groupBy('points.post_id')
            ->havingRaw('COUNT(points.id) >= 25')
            ->havingRaw('COUNT(points.id) < 40');
    }

    /**
     * The hot scope function for retrieving the fresh posts
     *
     * @param $query
     * @return mixed
     */
    public function scopeNew($query)
    {
        return $query->leftJoin('points', 'points.post_id', '=', 'posts.id')
            ->groupBy(['posts.id', 'posts.title', 'posts.slug'])
            ->havingRaw('COUNT(points.id) < 25')
            ->orderBy('posts.id', 'DESC');
    }

    /**
     * The scope search method
     *
     * @param $query
     * @param $keyword
     * @return mixed
     */
    public function scopeSearch($query, $keyword)
    {
        $keyword = strtolower($keyword);
        return $query->where(DB::raw('LOWER(title)'), 'like', "%$keyword%");
    }
}
