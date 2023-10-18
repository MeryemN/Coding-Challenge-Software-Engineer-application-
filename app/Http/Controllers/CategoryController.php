<?php

namespace App\Http\Controllers;

use App\Contracts\CategoryServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(): JsonResponse
    {
        $categories = $this->categoryService->getAllCategories();
        return response()->json($categories, 200);
    }

    public function show($id): JsonResponse
    {
        $category = $this->categoryService->getCategoryById($id);

        if ($category) {
            return response()->json($category, 200);
        }

        return response()->json(['error' => 'Category not found.'], 404);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $createdCategory = $this->categoryService->createCategory($request);
            return response()->json($createdCategory, 201); // 201 Created
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 400); // 400 Bad Request
        }
    }

    public function edit($id): JsonResponse
    {
        $category = $this->categoryService->getCategoryById($id);

        if ($category) {
            return response()->json($category, 200);
        }

        return response()->json(['error' => 'Category not found.'], 404);
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'parent_id' => 'integer|nullable',
            ]);

            $updatedCategory = $this->categoryService->updateCategory($id, $validatedData);

            if ($updatedCategory) {
                return response()->json(['message' => 'Category updated successfully.'], 200);
            } else {
                return response()->json(['error' => 'Category not found.'], 404);
            }
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 400);
        }
    }

    public function destroy($id): JsonResponse
    {
        if ($this->categoryService->deleteCategory($id)) {
            return response()->json(['message' => 'Category deleted successfully.'], 200);
        } else {
            return response()->json(['error' => 'Category not found.'], 404);
        }
    }
}
