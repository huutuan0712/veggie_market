<?php

namespace App\DTOs\User;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

class User {

    public ?string $username = null;

    public ?string $email = null;

    public ?string $password = null;

    public ?string $full_name = null;

    public ?string $phone = null;

    public ?string $image = null;

    public ?string $address = null;

    public ?string $created_at = null;

    public ?string $updated_at = null;

    public ?string $deleted_at = null;


    public static function fromModel (\App\Models\User $user):self
    {
        $dto = new self;
        $dto->username = $user->username;
        $dto->email = $user->email;
        $dto->password = $user->password;
        $dto->full_name = $user->full_name;
        $dto->phone = $user->phone;
        $dto->image = $user->image;
        $dto->address = $user->address;
        $dto->created_at = $user->created_at?->format('Y-m-d H:i:s');
        $dto->updated_at = $user->updated_at?->format('Y-m-d H:i:s');
        $dto->deleted_at = $user->deleted_at?->format('Y-m-d H:i:s');

        return $dto;
    }


    public static function fromRequest (array $data): self
    {
        $dto = new self;
        $dto->username = $data['username'] ?? null;
        $dto->email = $data['email'] ?? null;
        $dto->password = Hash::make($data['password']) ?? null;
        $dto->full_name = $data['full_name'] ?? null;
        $dto->phone = $data['phone'] ?? null;
        $dto->address = $data['address'] ?? null;

        if(isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $path = $data['image']->store('avatars','public');
            $dto->image = 'storage/'.$path;
        } else {
            $dto->image = $data['image'] ?? null;
        }

        return $dto;
    }


    public function toArray(): array
    {
        return [
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
            'full_name' => $this->full_name,
            'phone' => $this->phone,
            'image' => $this->image,
            'address' => $this->address,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
