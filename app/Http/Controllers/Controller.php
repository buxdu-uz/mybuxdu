<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{

    /**
     * @param $message
     * @param array $result
     * @return JsonResponse
     */
    public function successResponse($message, $result = [])
    {
        $response = [
            'status' => true,
            'message' => $message,
            'data'    => $result
        ];
        return response()->json($response);
    }

    /**
     * Error response method.
     *
     * @param $message
     * @param array $result
     * @return JsonResponse
     */
    public function errorResponse($message, $result = []): JsonResponse
    {
        $response = [
            'status' => false,
            'error'=>true,
            'message' => $message
        ];

        if (!empty($result)) {
            $response['data'] = $result;
        }

        return response()->json($response);
    }
}
