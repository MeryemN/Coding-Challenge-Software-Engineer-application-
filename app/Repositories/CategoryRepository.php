<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all()
    {
        $categories = Category::with('parent')->get();
        return $categories;
    }

    public function find($id)
    {
        return Category::with('parent')->findOrFail($id);
    }

    public function delete($id)
    {
        Category::destroy($id);
    }

    public function create(array $categoryDetails)
    {
        return Category::create($categoryDetails);
    }

    public function update($id, array $newDetails)
    {
        return Category::whereId($id)->update($newDetails);
    }
}
