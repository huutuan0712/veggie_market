<?php

namespace App\Services;

use App\DTOs\Product\ProductCollection;
use App\Models\Product;
use App\DTOS\Product\Product as ProductDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService extends BaseService
{
    /**
     * @var Product|Builder
     */
    protected Model|Builder $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function where($column, $value)
    {
        return $this->model->where($column, $value);
    }

    public function create(array $attributes): Product
    {
        if (! isset($attributes['slug']) || empty($attributes['slug'])) {
            $attributes['slug'] = Str::slug($attributes['name']);
        }

        return parent::create($attributes);
    }

    public function createDTO (ProductDTO $dto): ?ProductDTO
    {
        $attributes = $dto->toArray();
        $product = $this->create($attributes);

        $this->handleProductImages($product, $dto->images);

        return ProductDTO::fromModel($product);
    }

    public function update(string|int $id, array $attributes): Product
    {
          if ((! isset($attributes['slug']) || empty($attributes['slug'])) && isset($attributes['name'])) {
            $attributes['slug'] = Str::slug($attributes['name']);
        }

       return parent::update($id, $attributes);
    }

   public function updateDTO(string|int $id, ProductDTO $dto): ?ProductDTO
   {
       if (empty($dto->slug) && !empty($dto->name)) {
           $dto->slug = Str::slug($dto->name);
       }
       $attributes = $dto->toArray();

       $product = $this->update($id, $attributes);

       if (!empty($dto->images)) {
           $this->handleProductImages($product, $dto->images);
       }

       return ProductDTO::fromModel($product);
   }


    public function getPaginatedList(array $params = []): ?ProductCollection
    {
        $page = $params['page'] ?? 1;
        $perPage = $params['per_page'] ?? 15;
        $perPage = min($perPage, 100); // Maximum 100 items per page
        $search = $params['search'] ?? null;
        $sortBy = $params['sort_by'] ?? 'name';
        $sortDirection = $params['sort_direction'] ?? 'asc';
        $includeDeleted = $params['include_deleted'] ?? false;
        $category = $params['category'] ?? null;

        $query = $this->model->newQuery()->with(['category']);

        // Include soft deleted items if requested
        if ($includeDeleted) {
            $query->withTrashed();
        }

        if ($category) {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category);
            });
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

        return ProductCollection::fromPaginator($categories);
    }


    public function getProductWithRelations ($id): ?ProductDTO
    {
        $query = $this->model->with('category')->newQuery();
        $product = $query->findOrFail($id);

        return ProductDTO::fromModel($product);
    }

    public function restore ($id): ?ProductDTO
    {
        try {

            $product = $this->model->withTrashed()->findOfFail($id);
            $product->restore();

            return ProductDTO::fromModel($product);
        } catch (ModelNotFoundException $e){
            return null;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function forceDelete ($id)
    {
        try {
            $product = $this->model->withTrashed()->findOfFail($id);
            $result = $product->forceDelete();

            return $result;

        } catch (ModelNotFoundException $e){
            return null;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    protected function handleProductImages(Product $product, array $images): void
    {
        foreach ($images as $imageFile) {
            if ($imageFile instanceof UploadedFile) {
                $path = $imageFile->store('products', 'public');

                $product->images()->create([
                    'path' => $path,
                ]);
            }
        }
    }

    public function deleteProductImages(Product $product): void
    {
        foreach ($product->images as $image) {
            if ($image->path && Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path);
            }

            $image->delete();
        }
    }
}
