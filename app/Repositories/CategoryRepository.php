<?php

namespace App\Repositories;

use App\Interfaces\Resources\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function index()
    {
        $categories = Category::all();

        $categories->transform(function ($category) {
            return $this->toArray($category);
        });

        return $categories;
    }

    public function show($category)
    {
        return $this->toArray($category);
    }

    public function toArray($category)
    {
        return [
            'name' => $category->name,
            'slug' => $category->slug,
            'id' => $category->id
        ];
    }
}
