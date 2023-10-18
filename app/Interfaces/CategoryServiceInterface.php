<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface CategoryServiceInterface
{
    public function getAllCategories();

    public function getCategoryById($id);

    public function createCategory(Request $request);

    public function updateCategory(Request $request, $id);

    public function deleteCategory($id);
}
