<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Core\Application\Service\GetDataJurnalistik\GetDataJurnalistikService;

class JurnalistikController extends Controller
{
    public function get(Request $request, GetDataJurnalistikService $service): JsonResponse
    {
        $response = $service->execute($request->get('account'));
        return $this->successWithData($response, "Berhasil Mendapatkan Data Jurnalistik");
    }
}
