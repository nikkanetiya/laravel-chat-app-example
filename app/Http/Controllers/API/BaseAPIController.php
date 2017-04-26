<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

/**
 * Class BaseAPIController
 * @package App\Http\Controllers\API
 */
class BaseAPIController extends Controller
{
    /**
     * Return generic response for showing success
     *
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseSuccess($data = [])
    {
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Return generic response for showing error
     *
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseError($statusCode = 500)
    {
        return response()->json([
            'success' => false
        ], $statusCode);
    }
}
