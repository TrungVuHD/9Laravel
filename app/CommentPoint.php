<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Comment;
use App\User;

class CommentPoint extends Model
{

    public function comment()
    {

        return $this->belongsTo(Comment::class);
    }

    public function user()
    {

        return $this->belongsTo(User::class);
    }

}
