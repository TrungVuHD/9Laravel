<?php

namespace App\Repositories;

use App\Category;

class CategoryRepository extends BaseRepository
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }
}
