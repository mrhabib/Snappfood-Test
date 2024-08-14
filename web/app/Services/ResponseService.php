<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class ResponseService
{
    /**
     * Return a success response.
     *
     * @param mixed $data The data to return in the response.
     * @param string $message The message to return in the response.
     * @param int $code The HTTP status code for the response.
     * @return JsonResponse
     */
    public static function success(mixed $data, string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }


    public static function error($errors = [], $message = '', $statusCode = 400)
    {
        return response()->json([
            'success' => false,
            'errors' => $errors,
            'message' => $message,
        ], $statusCode);
    }
}
