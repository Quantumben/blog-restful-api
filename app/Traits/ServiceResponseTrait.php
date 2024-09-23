<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ServiceResponseTrait
{
    /**
     * @param  string  $message
     * @param  mixed  $data
     * @return array
     */
    public function success(string $message = '', mixed $data = []): array
    {
        return [
            'success' => true,
            'message' => $message,
            'data' => $data,
            'status_code' => 200,
        ];
    }

   /**
     * @param  string  $message
     * @param  mixed  $data
     * @return array
     */
    public function error(string $message = '', mixed $data = [], $statusCode = 500): array
    {
        return [
            'success' => false,
            'message' => $message,
            'data' => $data,
            'status_code' => $statusCode
        ];
    }
}
