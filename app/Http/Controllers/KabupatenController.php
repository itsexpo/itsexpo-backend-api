<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Core\Application\Service\Kabupaten\KabupatenService;

class KabupatenController extends Controller
{
    /**
     * @OA\Tag(
     *   name="Kabupaten",
     *   description="API Endpoints of Kabupaten"
     * )
    *      @OA\Get(
    *          path="/api/kabupaten",
    *          tags={"Kabupaten"},
    *          description="Get kabupaten by province id",
    *          @OA\Response(
    *              response="200",
    *              description="Success",
    *              @OA\JsonContent(
    *                  type="object",
    *                  @OA\Property(property="status", type="boolean"),
    *                  @OA\Property(property="data", type="object",
    *                       @OA\Property(property="token", type="string"),
    *                   ),
    *               )
    *         ),
    *          @OA\Response(
    *              response="404",
    *              description="Not Found",
    *              @OA\JsonContent(
    *                  type="object",
    *                  @OA\Property(property="success", type="boolean", example="false"),
    *                  @OA\Property(property="code", type="string", example="1049"),
    *                  @OA\Property(property="message", type="string"),
    *               )
    *         ),
    *       @OA\Parameter(
    *          name="provinsi_id",
    *          in="query",
    *          description="ID provinsi",
    *          required=false,
    *      ),
    *   )
     */
    public function kabupaten(Request $request, KabupatenService $service): JsonResponse
    {
        $response = $service->execute($request['provinsi_id']);
        return $this->successWithData($response, "Berhasil Mengambil Data Kabupaten");
    }
}
