<?php

namespace App\Services;

use App\DTOs\Category\CategoryCollection;
use App\Models\Category;
use App\DTOS\Category\Category as CategoryDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class CategoryService extends BaseService
{
    /**
     * @var Category|Builder
     */
    protected Model|Builder $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function create(array $attributes): Category
    {
        if (! isset($attributes['slug']) || empty($attributes['slug'])) {
            $attributes['slug'] = Str::slug($attributes['name']);
        }
        return parent::create($attributes);
    }

    public function createDTO (CategoryDTO $dto): ?CategoryDTO
    {
        $attributes = $dto->toArray();

        $category = $this->create($attributes);

        return CategoryDTO::fromModel($category);
    }

    public function update(string|int $id, array $attributes): Category
    {
        if ((! isset($attributes['slug']) || empty($attributes['slug'])) && isset($attributes['name'])) {
            $attributes['slug'] = Str::slug($attributes['name']);
        }
       return parent::update($id, $attributes);
    }

    public function updateDTO (string|int $id, CategoryDTO $dto): ?CategoryDTO
    {
        if (empty($dto->slug) && !empty($dto->name)) {
            $dto->slug = Str::slug($dto->name);
        }

        $attributes= $dto->toArray();

        $category = $this->update($id, $attributes);
        return CategoryDTO::fromModel($category);
    }

    public function getPaginatedList(array $params = []): CategoryCollection
    {
        $page = $params['page'] ?? 1;
        $perPage = $params['per_page'] ?? 15;
        $perPage = min($perPage, 100); // Maximum 100 items per page
        $search = $params['search'] ?? null;
        $sortBy = $params['sort_by'] ?? 'name';
        $sortDirection = $params['sort_direction'] ?? 'asc';
        $includeDeleted = $params['include_deleted'] ?? false;
        $category = $params['category'] ?? null;

        $query = $this->model->query();

        // Include soft deleted items if requested
        if ($includeDeleted) {
            $query->withTrashed();
        }

        if ($category) {
            $query->where('slug', $category);
        }

        // Apply search filter if provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        $query->orderBy($sortBy, $sortDirection);

        // Get paginated results
        $categories = $query->paginate($perPage, ['*'], 'page', $page);

        return CategoryCollection::fromPaginator($categories);
    }


    public function getCategoryWithRelations ($id): ?CategoryDTO
    {
        $query = $this->model->newQuery();
        $category = $query->findOrFail($id);

        return CategoryDTO::fromModel($category);
    }

    public function restore ($id): ?CategoryDTO
    {
        try {

            $category = $this->model->withTrashed()->findOfFail($id);
            $category->restore();

            return CategoryDTO::fromModel($category);
        } catch (ModelNotFoundException $e){
            return null;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function forceDelete ($id)
    {
        try {
            $category = $this->model->withTrashed()->findOfFail($id);
            $result = $category->forceDelete();

            return $result;

        } catch (ModelNotFoundException $e){
            return null;
        } catch (\Exception $e) {
            throw $e;
        }
    }

}
