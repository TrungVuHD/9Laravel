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

    public function getBySlug(string $slug = null): ?Category
    {
        return $this->category->where('slug', $slug)->first();
    }

    public function getIdBySlug(string $slug = null): int
    {
        $category = $this->getBySlug($slug);
        return $category->id ?? 0;
    }

    public function getById(int $id)
    {
        return $this->category->where('id', $id)->firstOrFail();
    }

    public function destroy(Category $category)
    {
        return $category->delete();
    }

    public function paginate(int $limit = 10)
    {
        return $this->category->paginate($limit);
    }
}
