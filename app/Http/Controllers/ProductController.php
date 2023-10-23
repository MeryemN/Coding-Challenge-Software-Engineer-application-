<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request): JsonResponse
    {
        $products = $this->productService->getAllProducts($request);
        return response()->json($products, 200);
    }

    public function show($id): JsonResponse
    {
        $product = $this->productService->getProductById($id);

        if ($product) {
            return response()->json($product, 200);
        }

        return response()->json(['error' => 'No Product Found.'], 404);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = $this->productService->createProduct($data);
            return response()->json($result, 201); // 201 Created
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 400); // 400 Bad Request
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $data = $request->all();
            $result = $this->productService->updateProduct($id, $data);

            return response()->json($result, 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 400);
        }
    }

    public function destroy($id): JsonResponse
    {
        if ($this->productService->deleteProduct($id)) {
            return response()->json(['message' => 'Product deleted successfully.'], 200);
        } else {
            return response()->json(['error' => 'Product not found.'], 404);
        }
    }
}
