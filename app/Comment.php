<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CommentPoint;
use App\User;

class Comment extends Model
{
   
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
}