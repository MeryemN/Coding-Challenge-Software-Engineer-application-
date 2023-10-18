<?php

namespace App\Services;

use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\ProductServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductService implements ProductServiceInterface
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function createProduct(Request $request)
    {
        Validator::extend('positive', function ($attribute, $value, $parameters, $validator) {
            return $value > 0;
        });

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'string',
            'price' => 'required|numeric',
            'image' => 'file', // Ensure it's a file
            'category_id' => 'integer',
        ]);

        // Handle image upload and store it in a storage location
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('product', 'public'); // Store in the public/product directory
            $validatedData['image'] = $imagePath;
        }

        // If validation didn't passe, throw an error
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // If validation passes, create a new product
        return $this->productRepository->create($request->all());
    }

    public function updateProduct(Request $request, $id)
    {
        // Check if the product exists
        $product = $this->getProductById($id);
        if ($product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'string',
            'price' => 'required|numeric',
            'image' => 'file', // Ensure it's a file
            'category_id' => 'integer',
        ]);

        // Handle image upload and store it in a storage location
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('product', 'public'); // Store in the public/product directory
            $validatedData['image'] = $imagePath;
        }

        // If validation didn't passe, throw an error
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // If validation passes, update the product
        return $this->productRepository->update($id, $request->all());
    }

    public function getAllProducts(Request $request)
    {
        return $this->productRepository->all($request);
    }

    public function getProductById($id)
    {
        return $this->productRepository->find($id);
    }

    public function deleteProduct($id)
    {
        return $this->productRepository->delete($id);
    }
}
