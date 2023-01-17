<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Core\Application\Service\Desa\DesaService;

class DesaController extends Controller
{
    /**
     * @OA\Tag(
     *   name="Get Desa",
     *   description="API Endpoints of Desa"
     * )
    *      @OA\Get(
    *          path="/desa",
    *          tags={"Get Desa"},
    *          description="get all desa",
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
    *                  @OA\Property(property="code", type="string", example="1057"),
    *                  @OA\Property(property="message", type="string"),
    *               )
    *         ),
    *      @OA\Get(
    *          path="/desa",
    *          tags={"Get Desa"},
    *          description="get desa by id_kecamatan",
    *          @OA\RequestBody(
    *              required=true,
    *              @OA\JsonContent(
    *                  required={"id_kecamatan"},
    *                  @OA\Property(property="id_kecamatan", type="string", example="1101020"),
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
    *                  @OA\Property(property="code", type="string", example="1058"),
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
    public function desa(Request $request, DesaService $service): JsonResponse
    {
        $response = $service->execute($request['id_kecamatan']);
        return $this->successWithData($response, "Berhasil Mengambil Data Desa");
    }
}
