<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Core\Application\Service\Kecamatan\KecamatanRequest;
use App\Core\Application\Service\Kecamatan\KecamatanService;

class KecamatanController extends Controller
{
    /**
     * @OA\Tag(
     *   name="Get Kecamatan",
     *   description="API Endpoints of Kecamatan"
     * )
     *      @OA\Get(
     *          path="/kecamatan",
     *          tags={"Get kecamatan"},
     *          description="get all kecamatan",
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
     *                  @OA\Property(property="code", type="string", example="6969"),
     *                  @OA\Property(property="message", type="string"),
     *               )
     *         ),
     *      @OA\Get(
     *          path="/kecamatan",
     *          tags={"Get kecamatan"},
     *          description="get kecamatan by id_kabupaten",
     *          @OA\RequestBody(
     *              required=true,
     *              @OA\JsonContent(
     *                  required={"kabupaten"},
     *                  @OA\Property(property="kabupaten", type="string", example="1101"),
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
     *                  @OA\Property(property="code", type="string", example="6969"),
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
    public function kecamatan(Request $request, KecamatanService $service): JsonResponse
    {
        $kabupaten =  $request->query("kabupaten", "");
        $input = new KecamatanRequest($kabupaten);
        $response = $service->execute($input);
        return $this->successWithData($response, "Berhasil Mengambil Data Kecamatan");
    }
}
