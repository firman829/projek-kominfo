<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

class ApiResponseService
{
    /**
     * Success Response
     */
    public static function success(
        string $message = 'Success',
        mixed $data = null,
        int $code = 200
    ): JsonResponse {

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Error Response
     */
    public static function error(
        string $message = 'Error',
        mixed $errors = null,
        int $code = 400
    ): JsonResponse {

        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $code);
    }

    /**
     * Validation Error
     */
    public static function validation(
        mixed $errors,
        string $message = 'Validation Error'
    ): JsonResponse {

        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], 422);
    }
}