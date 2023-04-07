<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Application\Service\GetUserWahanaSeni\GetUserWahanaSeniService;

class WahanaSeniController extends Controller
{
    public function getDetail(Request  $request, GetUserWahanaSeniService $service)
    {
        $response = $service->execute($request->get('account'));
        return $response;
    }
}
