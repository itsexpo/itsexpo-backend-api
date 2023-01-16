<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Core\Application\Service\Kabupaten\KabupatenService;

class KabupatenController extends Controller
{
    /**
     * @throws Exception
     */
    public function kabupaten(Request $request, KabupatenService $service): JsonResponse
    {
        $provinsi_id = request('provinsi_id');
        $response = $service->execute($provinsi_id);
        return $this->successWithData($response, "Berhasil Mengambil Data Kabupaten");
    }
}
