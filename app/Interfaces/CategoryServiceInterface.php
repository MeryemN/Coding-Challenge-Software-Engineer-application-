<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

/**
 * Interface CategoryServiceInterface
 *
 * This interface outlines the essential operations for managing category-related logic within the application.
 */
interface CategoryServiceInterface
{
    /**
     * Retrieve all categories.
     *
     * @return mixed Should return a collection of category entities or equivalent data transfer representations.
     */
    public function getAllCategories();

    /**
     * Retrieve a specific category by its unique identifier.
     *
     * @param int $id The unique identifier of the category.
     * @return mixed Should return a single category entity or equivalent representation if found.
     */
    public function getCategoryById($id);

    /**
     * Handle the creation of a new category, using the provided HTTP request data.
     *
     * @param Request $request The HTTP request object containing the information for the new category.
     * @return mixed Should return the newly created category entity or equivalent representation.
     */
    public function createCategory(Request $request);

    /**
     * Handle the update of an existing category, identified by its unique identifier.
     *
     * @param Request $request The HTTP request object containing the updated information for the category.
     * @param int $id The unique identifier of the category to be updated.
     * @return mixed Should return the updated category entity or equivalent representation.
     */
    public function updateCategory(Request $request, $id);

    /**
     * Handle the deletion of a category, identified by its unique identifier.
     *
     * @param int $id The unique identifier of the category to be deleted.
     * @return mixed Should indicate the status of the deletion operation.
     */
    public function deleteCategory($id);
}