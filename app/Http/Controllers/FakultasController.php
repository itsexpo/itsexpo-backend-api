<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Core\Application\Service\Fakultas\FakultasService;

class FakultasController extends Controller
{
    /**
    * @OA\Tag(
    *   name="Get Fakultas",
    *   description="API Endpoints of Fakultas"
    * )
    *      @OA\Get(
    *          path="/fakultas",
    *          tags={"Get Fakultas"},
    *          description="get all fakultas",
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
    *                  @OA\Property(property="code", type="string", example="1010"),
    *                  @OA\Property(property="message", type="string"),
    *               )
    *         ),
    */

    /**
     * @throws Exception
     */
    public function fakultas(FakultasService $service): JsonResponse
    {
        $response = $service->execute();
        return $this->successWithData($response, "Berhasil Mengambil Data Fakultas");
    }
}
