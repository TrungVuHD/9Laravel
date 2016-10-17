<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Point;
use App\User;
use App\Category;

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
}