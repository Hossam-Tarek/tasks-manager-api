<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiHelper
{
    /**
     * Return a JSON success response.
     *
     * @param mixed $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public static function success(mixed $data = [], string $message = '', int $code = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Return a JSON failure response.
     *
     * @param mixed $errors
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public static function fail(mixed $errors = [], string $message = '', int $code = 400): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }
}
