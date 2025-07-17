<?php

namespace App\DTOs\Rating;

use Illuminate\Support\Facades\Auth;

class Rating
{
    public ?string $id = null;

    public ?string $user_id = null;

    public ?string $product_id = null;

    public ?int $rating = null;

    public ?string $comment = null;

    public ?string $created_at = null;

    public ?string $updated_at = null;



    public static function fromModel(\App\Models\Rating $rating): self
    {
        $dto = new self;
        $dto->id = $rating->id;
        $dto->user_id = $rating->user_id;
        $dto->product_id = $rating->product_id;
        $dto->rating = $rating->rating;
        $dto->comment = $rating->comment;
        $dto->created_at = $rating->created_at?->format('Y-m-d H:i:s');
        $dto->updated_at = $rating->updated_at?->format('Y-m-d H:i:s');
        return $dto;
    }

    public static function fromRequest(array $data): self
    {
        $dto = new self;
        $dto->product_id = $data['product_id'] ?? null;
        $dto->rating = $data['rating'] ?? null;
        $dto->comment = $data['comment'] ?? null;
        $dto->user_id = Auth::user()->id;

        return $dto;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'user_id' => $this->user_id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
