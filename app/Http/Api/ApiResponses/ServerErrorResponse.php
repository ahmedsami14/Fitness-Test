<?php

namespace App\Http\Api\ApiResponses;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

class ServerErrorResponse implements Responsable
{
    public function __construct(
        protected array|Arrayable $data,
        protected string $message,
        protected array $headers = [],
    ) {
    }

    public function toResponse($request): JsonResponse
    {
        if ($this->data instanceof Arrayable) {
            $this->data = $this->data->toArray();
        }

        $response = [
            'success' => false,
            'message' => $this->message,
            'data' => $this->data,
        ];

        return response()->json($response, JsonResponse::HTTP_INTERNAL_SERVER_ERROR, $this->headers);
    }
}