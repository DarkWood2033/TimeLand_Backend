<?php

namespace App\Services\Response;

use Illuminate\Http\JsonResponse as BaseJsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class JsonResponse
{
    /**
     * @var int
     */
    private $status = 200;
    /**
     * @var array
     */
    private $data = [];
    /**
     * @var array
     */
    private $headers = [];

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return JsonResponse
     */
    public function setStatus(int $status): JsonResponse
    {
        $this->status = $status;

        return $this;
    }

    public function setHeader(string $name, string $value): JsonResponse
    {
        $this->headers[$name] = $value;

        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    public function setMessage(string $message): JsonResponse
    {
        $this->data['message'] = $message;

        return $this;
    }

    public function setItem(JsonResource $item): JsonResponse
    {
        $this->data['item'] = $item;

        return $this;
    }

    public function setItems(ResourceCollection $items): JsonResponse
    {
        $this->data['items'] = $items;

        return $this;
    }

    public function send(): BaseJsonResponse
    {
        return new BaseJsonResponse($this->data, $this->status, $this->headers);
    }
}
