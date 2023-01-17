<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Core\Application\Service\Kabupaten\KabupatenService;

class KabupatenController extends Controller
{
    /**
    * @OA\Tag(
    *   name="Get Kabupaten",
    *   description="API Endpoints of Kabupaten"
    * )
    *      @OA\Get(
    *          path="/kabupaten",
    *          tags={"Get Kabupaten"},
    *          description="get all kabupaten",
    *
    *          @OA\Response(
    *              response="200",
    *              description="Success",
    *              @OA\JsonContent(
    *                  type="object",
    *                  @OA\Property(property="success", type="boolean"),
    *                  @OA\Property(property="data", type="object"),
    *                  @OA\Property(property="message", type="string"),
    *               )
    *         ),
    *          @OA\Response(
    *              response="404",
    *              description="Not Found",
    *              @OA\JsonContent(
    *                  type="object",
    *                  @OA\Property(property="success", type="boolean", example="false"),
    *                  @OA\Property(property="code", type="string", example="1057"),
    *                  @OA\Property(property="message", type="string"),
    *               )
    *         ),
    *      @OA\Get(
    *          path="/kabupaten",
    *          tags={"Get Kabupaten"},
    *          description="get kabupaten by provinsi_id",
    *          @OA\RequestBody(
    *              required=true,
    *              @OA\JsonContent(
    *                  required={"provinsi_id"},
    *                  @OA\Property(property="provinsi_id", type="string", example="1101020"),
    *              )
    *          ),
    *
    *          @OA\Response(
    *              response="200",
    *              description="Success",
    *              @OA\JsonContent(
    *                  type="object",
    *                  @OA\Property(property="success", type="boolean"),
    *                  @OA\Property(property="data", type="object"),
    *                  @OA\Property(property="message", type="string"),
    *               )
    *         ),
    *          @OA\Response(
    *              response="404",
    *              description="Not Found",
    *              @OA\JsonContent(
    *                  type="object",
    *                  @OA\Property(property="success", type="boolean", example="false"),
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
    public function kabupaten(KabupatenService $service): JsonResponse
    {
        $provinsi_id = request('provinsi_id');
        $response = $service->execute($provinsi_id);
        return $this->successWithData($response, "Berhasil Mengambil Data Kabupaten");
    }
}
