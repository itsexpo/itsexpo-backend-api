<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
    * @OA\Info(title="ITS Expo API Documentation", version="1.0")
    *
    * @OA\Tag(
    *   name="General Respond",
    *   description="General Api Respond"
    * )
    * @OA\Get(
    *      path="/test",
    *      tags={"General Respond"},
    *      @OA\Response(
    *       response="200",
    *       description="Success",
    *       @OA\JsonContent(
    *           type="object",
    *            @OA\Property(property="status", type="boolean"),
    *            @OA\Property(property="message", type="string"),
    *            @OA\Property(property="data", type="object",
    *                  @OA\Property(property="hallo", type="string"),
    *                  @OA\Property(property="world", type="string"),
    *            ),
    *       )
    *  ),
    *
    *  @OA\Response(
    *       response="401",
    *       description="Unauthorized",
    *           @OA\JsonContent(
    *                  type="object",
    *                  @OA\Property(property="status", type="boolean", example="false"),
    *                  @OA\Property(property="message", type="string"),
    *               )
    *         ),
    *  @OA\Response(
    *       response="500",
    *       description="Unauthorized",
    *           @OA\JsonContent(
    *                  type="object",
    *                  @OA\Property(property="status", type="boolean", example="false"),
    *                  @OA\Property(property="code", type="string"),
    *                  @OA\Property(property="message", type="string"),
    *               )
    *         ),
    * )
    */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function successWithData($data, $message): JsonResponse
    {
        return response()->json(
            [
                'success' => true,
                'data' => $data,
                'message' => $message,
            ]
        );
    }

    protected function success($message): JsonResponse
    {
        return response()->json(
            [
                'success' => true,
                'message' => $message,
            ]
        );
    }
}
