<?php

namespace App\Services;

use App\Interfaces\CategoryServiceInterface;
use App\Interfaces\CategoryRepositoryInterface;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;


class CategoryService implements CategoryServiceInterface
{
    protected $categoryRepository;
    protected $validator;

    public function __construct(CategoryRepositoryInterface $categoryRepository, ValidationFactory $validator)
    {
        $this->categoryRepository = $categoryRepository;
        $this->validator = $validator;
    }

    public function createCategory(array $data)
    {
        $validator = $this->validator->make($data, [
            'name' => 'required|string',
            'parent_id' => 'integer',
        ]);

        if ($validator->fails()) {
            return ['error' => 'Validation failed', 'details' => $validator->errors()];
        }

        return  $this->categoryRepository->create($data);
    }


    public function updateCategory($id, array $data)
    {
        // Check if the product exists
        $category = $this->getCategoryById($id);
        if (!$category) {
            return ['error' => 'Category not found'];
        }
        // Validate the request data

        $validator = $this->validator->make($data, [
            'name' => 'required|string|max:50',
            'parent_id' => 'integer|nullable',
        ]);

        // If validation passes, create a new product
        if ($validator->fails()) {
            return ['error' => $validator->errors()];
        }
        // If validation passes, update the category
        return $this->categoryRepository->update($id, $data);
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
