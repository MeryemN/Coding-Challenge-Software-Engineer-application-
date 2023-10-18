<?php

namespace App\Interfaces;

interface CategoryRepositoryInterface
{
    public function all();
    public function find($id);
    public function delete($id);
    public function create(array $categoryDetails);
    public function update($id, array $newDetails);
}
