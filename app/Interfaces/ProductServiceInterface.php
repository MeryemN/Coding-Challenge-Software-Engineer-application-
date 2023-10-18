<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface ProductServiceInterface
{
    public function getAllProducts(Request $request);

    public function getProductById($id);

    public function createProduct(Request $request);

    public function updateProduct(Request $request, $id);

    public function deleteProduct($id);
}
