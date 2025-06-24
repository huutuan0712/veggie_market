<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    protected bool $success;

    protected string $message;

    protected ?array $meta = [];

    protected ?array $data = [];

    protected ?array $errors = null;

    protected int $statusCode = 200;

    /**
     * Tạo response thành công
     *
     * @return static
     */
    public static function success(string $message, mixed $data = null, $meta = null, int $statusCode = 200): self
    {
        $instance = new self;
        $instance->success = true;
        $instance->message = $message;
        $instance->data = $data ?? [];
        $instance->meta = $meta ?? [];
        $instance->statusCode = $statusCode;

        return $instance;
    }

    /**
     * Tạo response lỗi
     *
     * @return static
     */
    public static function error(string $message, ?array $errors = null, int $statusCode = 400): self
    {
        $instance = new self;
        $instance->success = false;
        $instance->message = $message;
        $instance->errors = $errors;
        $instance->statusCode = $statusCode;

        return $instance;
    }

    /**
     * Tạo response thành công với một DTO
     *
     * @param  object  $dto  Đối tượng DTO có phương thức toArray()
     * @return static
     */
    public static function successWithDTO(string $message, $dto, int $statusCode = 200): self
    {
        if (! method_exists($dto, 'toArray')) {
            throw new \InvalidArgumentException('DTO must have toArray method');
        }
        $instance = new self;
        $instance->success = true;
        $instance->message = $message;
        $instance->data = $dto->toArray();
        $instance->statusCode = $statusCode;

        return $instance;
    }

    /**
     * Tạo response thành công với một Collection DTO
     *
     * @param  object  $collectionDTO  Đối tượng Collection có phương thức toArray()
     * @return static
     */
    public static function successWithCollection(string $message, object $collectionDTO, int $statusCode = 200): self
    {
        if (! method_exists($collectionDTO, 'toArray')) {
            throw new \InvalidArgumentException('Collection DTO must have toArray method');
        }

        return self::success($message, $collectionDTO->data, $collectionDTO->meta, $statusCode);
    }

    /**
     * Chuyển thành JsonResponse
     */
    public function toResponse(): JsonResponse
    {
        $response = [
            'success' => $this->success,
            'message' => $this->message,
        ];

        if ($this->data !== null) {
            $response['data'] = $this->data;
        }

        if ($this->meta !== null) {
            $response['meta'] = $this->meta;
        }

        if ($this->errors !== null) {
            $response['errors'] = $this->errors;
        }

        return new JsonResponse($response, $this->statusCode);
    }
}
