<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class BaseService
 *
 * This class provides basic CRUD operations for a given model.
 * It implements the IService interface.
 */
class BaseService implements IService
{

    /**
     * @var Model|Builder The model instance.
     */
    protected Model|Builder $model;

    /**
     * Find a model by its primary key.
     *
     * @param  int  $id  The primary key of the model.
     * @return Model The model instance.
     *
     * @throws ModelNotFoundException If no model exists with the given primary key.
     */
    public function find(int|string $id): Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Get all records of the model.
     *
     * @return Collection The collection of all model instances.
     */
    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function searchAll(array $bodyRequest): array
    {
        $filters = $bodyRequest['filters'] ?? [];
        $fields = $bodyRequest['fields'] ?? [];
        $sort = $bodyRequest['sorter'] ?? [];
        $pagination = $bodyRequest['pagination'] ?? ['page' => 1, 'limit' => 10];
        $with = $bodyRequest['with'] ?? [];
        $query = $this->model->newQuery();
        if (! empty($filters)) {
            $query->applyFilters($filters);
        }
        if (! empty($sort)) {
            $query->orderBy($sort['field'], $sort['order']);
        } else {
            $query->orderBy('id', 'desc');
        }
        if (! empty($fields)) {
            $query->select($fields);
        }
        $query->with($with);

        $search = $query->paginate($pagination['pageSize'], ['*'], 'page', $pagination['current']);

        return [
            'data' => $search->items(),
            'pagination' => [
                'total' => $search->total(),
                'page_size' => $search->perPage(),
                'page' => $search->currentPage(),
                'last_page' => $search->lastPage(),
            ],
        ];
    }


    public function findBy(array $conditions, $select = ['*']): ?Model
    {
        return $this->model->select($select)->where($conditions)->first();
    }

    public function paginate(array $conditions, $select = ['*'], $orderBy = ['id', 'asc'], $limit = 10): Builder
    {
        return $this->model->select($select)->where($conditions)->orderBy($orderBy[0], $orderBy[1])->paginate($limit);
    }

    /**
     * Delete a model by its primary key.
     *
     * @param  int  $id  The primary key of the model.
     * @return bool True if the model was deleted, false otherwise.
     *
     * @throws ModelNotFoundException If no model exists with the given primary key.
     */
    public function delete(int $id): bool
    {
        $entity = $this->model->find($id);
        if ($entity) {
            $entity->delete();
            return true;
        }

        throw new ModelNotFoundException;
    }

    /**
     * Create a new model instance.
     *
     * @param  array  $attributes  The attributes to assign to the new model instance.
     * @return Model The newly created model instance.
     *
     * @throws \Exception If the model could not be created.
     */
    public function create(array $attributes): Model
    {
        $entity = $this->model->create($attributes);

        return $entity;
    }

    /**
     * Update a model instance.
     *
     * @param  int  $id  The primary key of the model to update.
     * @param  array  $attributes  The attributes to update on the model.
     * @return Model The updated model instance.
     *
     * @throws ModelNotFoundException If no model exists with the given primary key.
     */
    public function update(int|string $id, array $attributes): Model
    {
        $entity = $this->model->find($id);
        if ($entity) {
            $entity->update($attributes);
            $entity->refresh();

            return $entity;
        }
        throw new ModelNotFoundException;
    }

    /**
     * Update a model instance or create a new one if it does not exist.
     *
     * @param  array  $attributes  The attributes to update or assign to the new model instance.
     * @param  array  $values  The values to update or assign to the new model instance.
     * @return Model|Builder The updated or newly created model instance.
     */
    public function updateOrCreate(array $attributes, array $values): Model|Builder
    {
        $entity = $this->model->where($attributes)->first();
        if ($entity) {
            $entity->update($values);
        } else {
            $entity = $this->model->create($values);
        }

        return $entity;
    }

    public function moveFile(string $fileName): ?string
    {
        $path = sprintf('tmp/%s', $fileName);
        if (Storage::exists($path)) {
            $newPath = sprintf('public/%s/%s', $this->model->getTable(), $fileName);
            Storage::move($path, $newPath);
            Storage::delete($path);

            return Str::replace('public/', 'storage/', $newPath);
        }

        return null;
    }

    /**
     * Generate string type UUID
     */
    public function generateUUIDString()
    {
        return Str::uuid();
    }

    /**
     * Filter query.
     *
     * @param  Builder  $query  query
     * @param  array  $data  list of conditions
     * @return \Illuminate\Database\Query\Builder
     */
    public function filter(Builder $query, array $data = []): Builder
    {
        if (count($data) && method_exists($this, 'search')) {
            foreach ($data as $key => $value) {
                $query = $this->search($query, $key, $value);
            }
        }

        return $query;
    }

    /**
     * Get Collection|model|Builder via conditions.
     *
     * @param  array  $conditions  List of conditions
     * @param  bool  $isReturnQuery  Get builder or not.
     */
    public function list(array $conditions, bool $isReturnQuery = false): Model|Collection|LengthAwarePaginator|Builder|\Illuminate\Support\Collection
    {
        $selectable = [];
        if (empty($conditions['select'])) {
            $select = $this->model->getTable().'.*';
            $selectable = $this->model->selectable ?? [$select];
        } else {
            $selectable = $conditions['select'];
        }

        // joinWith other table
        if (isset($conditions['join_with']) && method_exists($this, 'joinWith')) {
            $entities = $this->joinWith($this->model, $conditions);
        }

        // select list column
        if (empty($entities)) {
            $entities = $this->model->select($selectable);
        } else {
            $entities = $entities->select($selectable);
        }

        // relations
        if (isset($conditions['with'])) {
            $entities = $entities->with($conditions['with']);
        }

        // realtion counts
        if (isset($conditions['with_count'])) {
            $entities = $entities->withCount($conditions['with_count']);
        }

        // filter data
        if (count($conditions)) {
            $entities = $this->filter($entities, $conditions);
        }

        // order by
        if (isset($conditions['order_by'], $conditions['order_type'])) {
            $entities = $entities->orderBy($conditions['order_by'], $conditions['order_type'] ? 'asc' : 'desc');
        }

        // first
        if (isset($conditions['first'])) {
            return $entities->first();
        }

        // all
        if (isset($conditions['all'])) {
            return $entities->get();
        }

        // limit
        if (isset($conditions['limit'])) {
            return $entities->paginate($conditions['limit'])->withQueryString();
        }

        // query builder
        if ($isReturnQuery) {
            return $entities;
        }

        return $entities->get();
    }

    /**
     * Join two tables
     * Ex:
     * $conditions['join_with'] =[
     *  'table' => 'categories',
     *      'conditions' => [
     *          'left' => 'documents.category_id',
     *          'operator' => '=',
     *          'right' => 'categories.id'
     *      ],
     * ];
     */
    public function joinWith($entities, array $conditions)
    {
        $targetTable = $conditions['join_with']['table'];
        $conds = $conditions['join_with']['conditions'];
        if (! empty($targetTable) && ! empty($conds)) {
            return $entities->join($targetTable, $conds['left'], $conds['operator'], $conds['right']);
        } else {
            return $entities;
        }
    }

    /**
     * Dynamic build search function
     *
     * @param  Builder  $query  Eloquent query builder
     * @param  string  $column  Column name
     * @param  mixed  $data  Data conditions (string|integer|date|datetime|bool|etc)
     */
    public function search(Builder $query, string $column, $data): Builder
    {
        return $query;
    }
}
