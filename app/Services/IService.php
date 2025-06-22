<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface IService
 *
 * This interface defines the contract for services that perform CRUD operations on a model.
 * It is implemented by the BaseService class.
 */
interface IService
{
    /**
     * Find a model by its primary key.
     *
     * @param  int  $id  The primary key of the model.
     * @return Model The model instance.
     */
    public function find(int $id): Model;

    public function findBy(array $conditions): ?Model;

    public function searchAll(array $bodyRequest): array;

    /**
     * Delete a model by its primary key.
     *
     * @param  int  $id  The primary key of the model.
     * @return bool True if the model was deleted, false otherwise.
     */
    public function delete(int $id): bool;

    /**
     * Create a new model instance.
     *
     * @param  array  $attributes  The attributes to assign to the new model instance.
     * @return Model The newly created model instance.
     */
    public function create(array $attributes): Model;

    /**
     * Update a model instance.
     *
     * @param  int  $id  The primary key of the model to update.
     * @param  array  $attributes  The attributes to update on the model.
     * @return Model The updated model instance.
     */
    public function update(int $id, array $attributes): Model;

    /**
     * Update a model instance or create a new one if it does not exist.
     *
     * @param  array  $attributes  The attributes to update or assign to the new model instance.
     * @param  array  $values  The values to update or assign to the new model instance.
     * @return Model|Builder The updated or newly created model instance.
     */
    public function updateOrCreate(array $attributes, array $values): Model|Builder;
}
