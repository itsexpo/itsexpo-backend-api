<?php

namespace App\Http\Controllers;

use App\Core\Application\Service\WahanaSeniAdminConfirm\WahanaSeniAdminConfirmRequest;
use App\Core\Application\Service\WahanaSeniAdminConfirm\WahanaSeniAdminConfirmService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WahanaSeniAdminController extends Controller
{
    public function confirm2DTeam(Request $request, WahanaSeniAdminConfirmService $service): JsonResponse
    {
        $request->validate([
            'pembayaran_id' => 'required',
            'status_pembayaran_id' => 'required'
        ]);

        $input = new WahanaSeniAdminConfirmRequest(
            $request->input('pembayaran_id'),
            $request->input('status_pembayaran_id'),
            '2D'
        );

        $service->execute($input);
        return $this->success("Berhasil Mengubah Status Pembayaran");
    }

    public function confirm3DTeam(Request $request, WahanaSeniAdminConfirmService $service): JsonResponse
    {
        $request->validate([
            'pembayaran_id' => 'required',
            'status_pembayaran_id' => 'required'
        ]);

        $input = new WahanaSeniAdminConfirmRequest(
            $request->input('pembayaran_id'),
            $request->input('status_pembayaran_id'),
            '3D'
        );

        $service->execute($input);
        return $this->success("Berhasil Mengubah Status Pembayaran");
    }
}
