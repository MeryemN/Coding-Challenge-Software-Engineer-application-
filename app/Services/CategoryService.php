<?php

namespace App\Services;

use App\Contracts\CategoryServiceInterface;
use App\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryService implements CategoryServiceInterface
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function createCategory(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'parent_id' => 'integer|nullable',
        ]);
        return $this->categoryRepository->create($validatedData);
    }

    public function updateCategory(Request $request, $id)
    {
        // Check if the product exists
        $category = $this->getCategoryById($id);
        if ($category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'parent_id' => 'integer|nullable',
        ]);

        // If validation passes, create a new product
        if ($validator->fails()) {
            return ['error' => $validator->errors()];
        }

        // If validation passes, update the category
        return $this->categoryRepository->update($id, $request->all());
    }


    public function getCategoryById($id)
    {
        return $this->categoryRepository->find($id);
    }


    public function getAllCategories()
    {
        return $this->categoryRepository->all();
    }

    public function deleteCategory($id)
    {
        return $this->categoryRepository->delete($id);
    }
}
