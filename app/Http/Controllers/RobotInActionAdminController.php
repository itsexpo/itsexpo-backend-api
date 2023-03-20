<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Core\Application\Service\RobotInActionAdminConfirm\RobotInActionAdminConfirmService;
use App\Core\Application\Service\RobotInActionAdminConfirm\RobotInActionAdminConfirmRequest;

class RobotInActionAdminController extends Controller
{
    public function confirmTeam(Request $request, RobotInActionAdminConfirmService $service)
    {
        $request->validate([
          'pembayaran_id' => 'required',
          'status_pembayaran_id' => 'required'
        ]);

        $input = new RobotInActionAdminConfirmRequest(
            $request->input('pembayaran_id'),
            $request->input('status_pembayaran_id')
        );

        $service->execute($input);
        return $this->success("Berhasil Mengubah Status Pembayaran");
    }
}
