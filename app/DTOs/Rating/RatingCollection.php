<?php


namespace App\DTOs\Rating;


use Illuminate\Pagination\LengthAwarePaginator;

class RatingCollection
{
    public array $data = [];

    public ?array $meta = null;


    public static function fromCollection (array $categories)
    {
        $data = [];

        foreach ($categories as $category)
        {
            $data[] = Rating::fromModel($category);
        }

        $collection = new self;
        $collection->data = $data;
        return $collection;
    }

    public static function fromPaginator (LengthAwarePaginator $paginator): self
    {
        $collection = self::fromCollection($paginator->items());

        $collection->meta = [
            'current_page' => $paginator->currentPage(),
            'from' => $paginator->firstItem(),
            'last_page' => $paginator->lastPage(),
            'path' => $paginator->path(),
            'to' => $paginator->lastItem(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
        ];
        return $collection;
    }

    public function toArray(): array
    {
        $result = [
            'data' => $this->data,
        ];

        if ($this->meta) {
            $result['meta'] = $this->meta;
        }
        return $result;
    }
}
