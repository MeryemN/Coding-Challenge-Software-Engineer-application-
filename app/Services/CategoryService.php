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
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
        ]);

        // If validation passes, create a new product
        if ($validator->fails()) {
            return ['error' => $validator->errors()];
        }

        // If validation passes, create a new category
        return $this->categoryRepository->create($request->all());
    }

    public function updateCategory(Request $request, $id)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|max:50',
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
