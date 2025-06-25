<?php

namespace App\DTOs\Product;
use App\Enums\ProductStatus;
use App\DTOs\Category\Category as CategoryDTO;

class Product
{
    public ?string $id = null;

    public ?string $name = null;

    public ?string $slug = null;

    public ?int $category_id = null;

    public ?string $description = null;

    public ?float $price = null;

    public ?float $original_price = null;

    public ?int $stock = null;

    public ?ProductStatus $status = null;

    public ?string $unit = null;

    public ?bool $featured = null;

    public ?array $benefits = null;

    public ?string $created_at = null;

    public ?string $updated_at = null;

    public ?string $deleted_at = null;

    public ?array $images;

    public ?CategoryDTO $category = null;


    public static function fromModel(\App\Models\Product $product): self
    {
        $dto = new self;
        $dto->id = $product->id;
        $dto->name = $product->name;
        $dto->slug = $product->slug;
        $dto->category_id = $product->category_id;
        $dto->description = $product->description;
        $dto->price = $product->price;
        $dto->original_price = $product->original_price;
        $dto->stock = $product->stock;
        $dto->status = $product->status;
        $dto->featured = $product->featured;
        $dto->unit = $product->unit;
        $dto->benefits = $product->benefits;
        $dto->created_at = $product->created_at?->format('Y-m-d H:i:s');
        $dto->updated_at = $product->updated_at?->format('Y-m-d H:i:s');
        $dto->deleted_at = $product->deleted_at?->format('Y-m-d H:i:s');

        $dto->category = CategoryDTO::fromModel($product->category);

        $dto->images = $product->images->map(function ($image) {
            return [
                'id' => $image->id,
                'path' => $image->path,
            ];
        })->toArray();

        return $dto;
    }

    public static function fromRequest(array $data): self
    {
        $dto = new self;
        $dto->name = $data['name'] ?? null;
        $dto->slug = $data['slug'] ?? null;
        $dto->category_id = $data['category_id'] ?? null;
        $dto->description = $data['description'] ?? null;
        $dto->price = $data['price'] ?? 0;
        $dto->original_price = $data['original_price'] ?? 0;
        $dto->stock = $data['stock'] ?? null;
        $dto->status = isset($data['status']) ? ProductStatus::tryFrom($data['status']) : ProductStatus::IN_STOCK;
        $dto->unit = $data['unit'] ?? null;
        $dto->featured = $data['featured'] ?? false;
        $dto->images = $data['images'] ?? [];
        $dto->benefits = $data['benefits'] ?? [];

        return $dto;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'category_id' => $this->category_id,
            'description' => $this->description,
            'price' => $this->price,
            'original_price' => $this->original_price,
            'stock' => $this->stock,
            'status' => $this->status,
            'featured' => $this->featured,
            'unit' => $this->unit,
            'images' => $this->images,
            'benefits' => $this->benefits,
            'category' => $this->category,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
