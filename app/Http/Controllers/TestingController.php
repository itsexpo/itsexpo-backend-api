<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Core\Application\Service\StoreImage\StoreImageService;

class TestingController extends Controller
{
    /**
     * @throws Exception
     */
    public function storeImage(Request $request, StoreImageService $service): JsonResponse
    {
        $response = $service->execute($request->file('file_test'));
        return $this->successWithData($response, "Berhasil Menambahkan File");
    }
}
