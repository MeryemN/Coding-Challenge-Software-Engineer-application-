<?php

namespace App\Services;

use App\Models\Product;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\ProductServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class ProductService implements ProductServiceInterface
{
    protected $productRepository;
    protected $validator;

    public function __construct(ProductRepositoryInterface $productRepository, ValidationFactory $validator)
    {
        $this->productRepository = $productRepository;
        $this->validator = $validator;
    }

    public function createProduct(array $data)
    {
        $this->validator->extend('positive', function ($attribute, $value, $parameters, $validator) {
            return $value > 0;
        });

        // Validate the request data
        $validator =  $this->validator->make($data, [
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'file', // Ensure it's a file
            'price' => 'required|numeric',
            'category_id' => 'integer',
        ]);

        // If validation didn't passe, throw an error
        if ($validator->fails()) {
            return ['error' => 'Validation failed', 'details' => $validator->errors()];
        }

        // // Handle image upload and store it in a storage location
        if (array_key_exists('image', $data)) {
            $image = $data['image'];
            $imagePath = $image->store('images', 'images'); // Store in the 'images' disk
            $data['image'] = $imagePath;
        }

        // If validation passes, create a new product
        return $this->productRepository->create($data);
    }


    public function updateProduct($id, array $data)
    {
        // Check if the product exists
        $product =  $this->productRepository->find($id);
        if (!$product) {
            return ['error' => 'Product not found'];
        }

        // Validate the request data
        $validator =  $this->validator->make($data, [
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'file', // Ensure it's a file
            'price' => 'required|numeric',
            'category_id' => 'integer',
        ]);

        // If validation didn't passe, throw an error
        if ($validator->fails()) {
            return ['error' => 'Validation failed', 'details' => $validator->errors()];
        }

        // Handle image upload and store it in a storage location
        if (array_key_exists('image', $data)) {
            $image = $data['image'];
            $imagePath = $image->store('images', 'images'); // Store in the 'images' disk
            $data['image'] = $imagePath;
        }

        // If validation passes, update the product
        return $this->productRepository->update($id, $data);
    }

    public function getAllProducts()
    {
        return $this->productRepository->all();
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
