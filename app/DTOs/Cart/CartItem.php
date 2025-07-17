<?php

namespace App\DTOs\Cart;

use App\DTOs\Product\Product as ProductDTO;

class CartItem
{
    public ?int $id = null;
    public ?int $user_id = null;
    public ?int $product_id = null;
    public ?int $quantity = null;
    public ?ProductDTO $product = null;

    public static function fromModel(App\Models\CartItem $cartItem): self
    {
        $dto = new self;
        $dto->id = $cartItem->id;
        $dto->user_id = $cartItem->user_id;
        $dto->product_id = $cartItem->product_id;
        $dto->quantity = $cartItem->quantity;
        $dto->product = ProductDTO::fromModel($cartItem->product);
        return $dto;
    }

    public static function fromRequest(array $data): self
    {
        $dto = new self;
        $dto->product_id = $data['product_id'] ?? null;
        $dto->quantity = $data['quantity'] ?? null;

        return $dto;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
        ];
    }
}
