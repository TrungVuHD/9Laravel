<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\Comment;
use App\Report;
use App\Point;
use App\User;

class Post extends Model
{

    public function points()
    {

        return $this->hasMany(Point::class);
    }

    public function user()
    {

        return $this->belongsTo(User::class);
    }

    public function category()
    {

        return $this->belongsTo(Category::class);
    }

    public function comments()
    {

        return $this->hasMany(Comment::class);
    }

    public function reports()
    {

        return $this->hasMany(Report::class);
    }
}
