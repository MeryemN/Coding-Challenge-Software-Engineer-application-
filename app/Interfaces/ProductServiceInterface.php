<?php

namespace App\Interfaces;

/**
 * Interface ProductRepositoryInterface
 *
 * This interface defines the standard functions to be implemented by the ProductRepository,
 * ensuring consistent management of the Product entities.
 */
interface ProductRepositoryInterface
{
    /**
     * Retrieve all products, potentially based on filtering criteria.
     *
     * @param mixed $request The data that may contain criteria for filtering query results.
     * @return mixed A collection of Product entities.
     */
    public function all($request);

    /**
     * Retrieve a product by its unique identifier.
     *
     * @param int $id The ID of the product.
     * @return mixed A Product entity or null if no entity with this ID exists.
     */
    public function find($id);

    /**
     * Remove a product from the repository identified by its unique ID.
     *
     * @param int $id The ID of the product to be deleted.
     * @return void
     */
    public function delete($id);

    /**
     * Create a new product in the repository.
     *
     * @param array $productDetails The details required to create a product.
     * @return mixed The Product entity that was created.
     */
    public function create(array $productDetails);

    /**
     * Update the information of a product identified by its unique ID.
     *
     * @param int $id The ID of the product to be updated.
     * @param array $newDetails New details to update in the product's information.
     * @return mixed Returns the updated Product entity.
     */
    public function update($id, array $newDetails);
}