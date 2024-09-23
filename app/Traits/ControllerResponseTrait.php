<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ControllerResponseTrait
{
    /**
     * @param  string  $message
     * @param  mixed  $data
     * @return JsonResponse
     */
    public function successResponse( string $message = '', mixed $data = []): JsonResponse
    {
        return response()->json(['data' => $data, 'message' => $message]);
    }

    /**
     * @param  string  $message
     * @param  int  $errorCode
     * @return JsonResponse
     */
    public function errorResponse(string $message = '', int $statusCode = 401): JsonResponse
    {
        return response()->json(['message' => $message], $statusCode);
    }
}
