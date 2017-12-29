<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * @var array The mass-assignable properties
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'published',
        'show_in_menu'
    ];
}
