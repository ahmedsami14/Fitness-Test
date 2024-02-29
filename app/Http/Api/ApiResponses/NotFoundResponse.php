<?php

namespace App\Http\Api\ApiResponses;

use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

class NotFoundResponse implements Responsable
{
    public function __construct(
        protected array|Arrayable $data,
        protected string|Exception $message = 'Not Found',
        protected array $headers = [],
    ) {
    }

    public function toResponse($request): JsonResponse
    {
        if ($this->data instanceof Arrayable) {
            $this->data = $this->data->toArray();
        }

        if ($this->message instanceof Exception) {
            $this->message = $this->message->getMessage();
        }

        $response = [
            'success' => false,
            'message' => $this->message,
            'data' => $this->data,
        ];

        return response()->json($response, JsonResponse::HTTP_NOT_FOUND, $this->headers);
    }
}