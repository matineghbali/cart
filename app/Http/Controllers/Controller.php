<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @param string $message
     * @param array $data
     * @param string $status
     *
     * @return JsonResponse
     */
    public function successResponse(string $message, $data = [], string $status = '200'): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $status);
    }

    /**
     * @param string $message
     * @param Exception|null $exception
     *
     * @return JsonResponse
     */
    public function failureResponse(string $message, ?Exception $exception = null): JsonResponse
    {
        return response()->json([
            'message' => $message,
        ], $exception->getCode());
    }
}
