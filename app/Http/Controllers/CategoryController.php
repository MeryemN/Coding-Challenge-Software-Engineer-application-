<?php

namespace App\Http\Controllers;

use App\Interfaces\CategoryServiceInterface;
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

    public function store(Request $request)
    {  
        $data = $request->all();
        $result = $this->categoryService->createCategory($data);

        if (isset($result['error'])) {
            return response()->json($result, 422);
        }

        return response()->json($result, 201);
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
        $data = $request->all();
        $result = $this->categoryService->updateCategory($id, $data);

        if (isset($result['error'])) {
            return response()->json($result, 422);
        }

        return response()->json($result, 200);
    }

    public function destroy($id): JsonResponse
    {
        $result = $this->categoryService->deleteCategory($id);

        if (isset($result['error'])) {
            return response()->json($result, 404);
        }

        return response()->json($result, 200);
    }
}
