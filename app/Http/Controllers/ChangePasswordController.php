<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Domain\Models\Email;
use Illuminate\Http\JsonResponse;
use App\Infrastrucutre\Service\GetIP;
use App\Core\Application\Service\RequestPassword\RequestPasswordRequest;
use App\Core\Application\Service\RequestPassword\RequestPasswordService as RequestPasswordRequestPasswordService;

class ChangePasswordController extends Controller
{
    public function request(Request $request, RequestPasswordRequestPasswordService $service): JsonResponse
    {
        $input = new RequestPasswordRequest(
            new Email($request->input('email')),
            new GetIP()
        );
        $response = $service->execute($input);
        return $this->successWithData($response, "Berhasil Mengirim Permintan Mengganti Passsword");
    }
}
