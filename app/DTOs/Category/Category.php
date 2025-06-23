<?php

namespace App\DTOs\Category;

class Category
{
    public ?string $id = null;

    public ?string $name = null;

    public ?string $slug = null;

    public ?string $description = null;

    public ?string $created_at = null;

    public ?string $updated_at = null;

    public ?string $deleted_at = null;


    public static function fromModel(\App\Models\Category $category): self
    {
        $dto = new self;
        $dto->id = $category->id;
        $dto->name = $category->name;
        $dto->slug = $category->slug;
        $dto->description = $category->description;
        $dto->created_at = $category->created_at?->format('Y-m-d H:i:s');
        $dto->updated_at = $category->updated_at?->format('Y-m-d H:i:s');
        $dto->deleted_at = $category->deleted_at?->format('Y-m-d H:i:s');

        return $dto;
    }

    public static function fromRequest(array $data): self
    {
        $dto = new self;
        $dto->name = $data['name'] ?? null;
        $dto->slug = $data['slug'] ?? null;
        $dto->description = $data['description'] ?? null;

        return $dto;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
