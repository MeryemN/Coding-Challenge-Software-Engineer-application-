<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

use function PHPUnit\Framework\isEmpty;

class ProductRepository implements ProductRepositoryInterface
{
    public function create(array $productDetails)
    {
        return Product::create($productDetails);
    }

    public function update($id, array $newDetails)
    {
        return Product::whereId($id)->update($newDetails);
    }

    public function find($id)
    {
        return Product::with('category')->findOrFail($id);
    }

    public function all($request)
    {
        if ($request->category_id && $request->sortBy) {
            return  Product::with('category')->where('category_id', $request->category_id)->orderBy('price', $request->sortBy)->get();
        }
        if ($request->sortBy) {
            return  Product::with('category')->orderBy('price', $request->sortBy)->get();
        }
        if ($request->category_id) {
            return  Product::with('category')->where('category_id', $request->category_id)->get();
        }

        return Product::with('category')->get();
    }

    public function delete($id)
    {
        Product::destroy($id);
    }
}
