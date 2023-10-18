<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function all($request);
    public function find($id);
    public function delete($id);
    public function create(array $productDetails);
    public function update($id, array $newDetails);
}
