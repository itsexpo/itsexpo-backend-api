<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Core\Application\Service\Desa\DesaService;

class DesaController extends Controller
{
    /**
     * @throws Exception
     */
    public function desa(DesaService $service): JsonResponse
    {
        $response = $service->execute();
        return $this->successWithData($response, "Berhasil Mengambil Data Desa");
    }
}
