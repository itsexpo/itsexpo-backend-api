<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Core\Application\Service\Departemen\DepartemenService;

;

class DepartemenController extends Controller
{
    /**
    * @OA\Tag(
    *   name="Get Departemen",
    *   description="API Endpoints of Departemen"
    * )
    *      @OA\Get(
    *          path="/departemen",
    *          tags={"Get Departemen"},
    *          description="get all departemen",
    *
    *          @OA\Response(
    *              response="200",
    *              description="Success",
    *              @OA\JsonContent(
    *                  type="object",
    *                  @OA\Property(property="succes", type="boolean"),
    *                  @OA\Property(property="data", type="object"),
    *                  @OA\Property(property="message", type="string"),
    *               )
    *         ),
    *          @OA\Response(
    *              response="404",
    *              description="Not Found",
    *              @OA\JsonContent(
    *                  type="object",
    *                  @OA\Property(property="succes", type="boolean", example="false"),
    *                  @OA\Property(property="code", type="string", example="1001"),
    *                  @OA\Property(property="message", type="string"),
    *               )
    *         ),
    *      @OA\Get(
    *          path="/departemen",
    *          tags={"Get Departemen"},
    *          description="get departemen by fakultas_id",
    *          @OA\RequestBody(
    *              required=true,
    *              @OA\JsonContent(
    *                  required={"fakultas_id"},
    *                  @OA\Property(property="fakultas_id", type="string", example="1101020"),
    *              )
    *          ),
    *
    *          @OA\Response(
    *              response="200",
    *              description="Success",
    *              @OA\JsonContent(
    *                  type="object",
    *                  @OA\Property(property="succes", type="boolean"),
    *                  @OA\Property(property="data", type="object"),
    *                  @OA\Property(property="message", type="string"),
    *               )
    *         ),
    *          @OA\Response(
    *              response="404",
    *              description="Not Found",
    *              @OA\JsonContent(
    *                  type="object",
    *                  @OA\Property(property="succes", type="boolean", example="false"),
    *                  @OA\Property(property="code", type="string", example="1002"),
    *                  @OA\Property(property="message", type="string"),
    *               )
    *         ),
    *
    *
    *   )
     */
    /**
     * @throws Exception
     */
    public function departemen(Request $request, DepartemenService $service): JsonResponse
    {
        $response = $service->execute($request['fakultas_id']);
        return $this->successWithData($response, "Berhasil Mengambil Data Departemen");
    }
}
