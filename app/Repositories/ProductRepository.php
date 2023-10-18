<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

use function PHPUnit\Framework\isEmpty;

class ProductRepository implements ProductRepositoryInterface 
{
    public function getAllProducts($request) 
    {
        // dd($request);
        // if(!isEmpty($request->all())){
            if ($request->category_id && $request->sortBy) {
                return  Product::with('category')->where('category_id',$request->category_id)->orderBy('price',$request->sortBy)->get();
            }
            if ($request->sortBy) {
                return  Product::with('category')->orderBy('price',$request->sortBy)->get();
            }
            if ($request->category_id) {
                return  Product::with('category')->where('category_id',$request->category_id)->get();
            }

        // }
        return Product::with('category')->get();
    }

    public function getProductById($productId) 
    {
        return Product::with('category')->findOrFail($productId);
    }

    public function deleteProduct($productId) 
    {
        Product::destroy($productId);
    }

    public function createProduct(array $productDetails) 
    {
        return Product::create($productDetails);
    }

    public function updateProduct($productId, array $newDetails) 
    {
        return Product::whereId($productId)->update($newDetails);
    }

}