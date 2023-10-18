<?php

namespace App\Interfaces;

/**
 * Interface for the Category Repository.
 *
 * Defines the methods to access and manipulate the Category entities.
 */
interface CategoryRepositoryInterface
{
    /**
     * Retrieve all categories.
     *
     * @return mixed A collection of all Category entities, possibly including related entities such as parent categories.
     */
    public function all();

    /**
     * Find a category by its ID.
     *
     * @param mixed $id The unique identifier of the Category entity.
     * @return mixed The Category entity associated with the given ID.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If no Category entity with the specified ID exists.
     */
    public function find($id);

    /**
     * Delete a category by its ID.
     *
     * @param mixed $id The unique identifier of the Category entity.
     * @return void
     * @throws \Exception If the Category entity cannot be deleted.
     */
    public function delete($id);

    /**
     * Create a new category with the provided details.
     *
     * @param array $categoryDetails The details of the Category entity to be created.
     * @return mixed The newly created Category entity.
     */
    public function create(array $categoryDetails);

    /**
     * Update a category identified by its ID with the provided new details.
     *
     * @param mixed $id The unique identifier of the Category entity.
     * @param array $newDetails The new details for the Category entity.
     * @return mixed The Category entity that was updated.
     */
    public function update($id, array $newDetails);
}
