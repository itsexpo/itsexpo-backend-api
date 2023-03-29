<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Core\Application\Service\CekPembayaranJurnalistik\CekPembayaranJurnalistikService;
use App\Core\Application\Service\CekPembayaranRobotInAction\CekPembayaranRobotInActionService;
use App\Core\Application\Service\CreatePembayaranJurnalistik\CreatePembayaranJurnalistikRequest;
use App\Core\Application\Service\CreatePembayaranJurnalistik\CreatePembayaranJurnalistikService;
use App\Core\Application\Service\CreatePembayaranKTI\CreatePembayaranKTIRequest;
use App\Core\Application\Service\CreatePembayaranKTI\CreatePembayaranKTIService;
use App\Core\Application\Service\CreatePembayaranRobotInAction\CreatePembayaranRobotInActionRequest;
use App\Core\Application\Service\CreatePembayaranRobotInAction\CreatePembayaranRobotInActionService;
use App\Core\Application\Service\UpdatePembayaran\UpdatePembayaranRequest;
use App\Core\Application\Service\UpdatePembayaran\UpdatePembayaranService;

class PembayaranController extends Controller
{
    public function createPembayaranJurnalistik(Request $request, CreatePembayaranJurnalistikService $service): JsonResponse
    {
        $request->validate([
            'bank_id' => 'required',
            'bukti_pembayaran' => 'required|file|mimes:jpeg,png,pdf',
            'harga' => 'required',
            'jurnalistik_team_id' => 'required',
            'atas_nama' => 'required|string',
        ]);

        $input = new CreatePembayaranJurnalistikRequest(
            $request->input('bank_id'),
            $request->input('harga'),
            $request->input('jurnalistik_team_id'),
            $request->input('atas_nama'),
            $request->file('bukti_pembayaran'),
        );

        DB::beginTransaction();
        try {
            $service->execute($input, $request->get('account'));
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Berhasil Melakukan Pembayaran");
    }

    public function createPembayaranKTI(Request $request, CreatePembayaranKTIService $service): JsonResponse
    {
        $request->validate([
            'bank_id' => 'required',
            'bukti_pembayaran' => 'required',
            'harga' => 'required',
            'atas_nama' => 'required|string',
            'kti_team_id' => 'required'
        ]);

        $input = new CreatePembayaranKTIRequest(
            $request->input('bank_id'),
            $request->input('harga'),
            $request->input('kti_team_id'),
            $request->input('atas_nama'),
            $request->file('bukti_pembayaran'),
        );

        DB::beginTransaction();
        try {
            $service->execute($input, $request->get('account'));
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        
        return $this->success("Berhasil Melakukan Pembayaran");
    }
     
    public function cekPembayaranJurnalistik(Request $request, CekPembayaranJurnalistikService $service): JsonResponse
    {
        $response = $service->execute($request->get('account'));
        return $this->successWithData($response, "Berhasil Mendapatkan Detail Cek Pembayaran");
    }

    public function createPembayaran(Request $request, CreatePembayaranRobotInActionService $service)
    {
        $request->validate([
            'bank_id' => 'required|integer',
            'harga' => 'required|integer',
            'robot_in_action_team_id' => 'required|string',
            'atas_nama' => 'required|string',
            'bukti_pembayaran' => 'required|file|mimes:jpeg,png,pdf'
        ]);

        $input = new CreatePembayaranRobotInActionRequest(
            $request->input('bank_id'),
            $request->input('harga'),
            $request->input('robot_in_action_team_id'),
            $request->input('atas_nama'),
            $request->file('bukti_pembayaran')
        );

        DB::beginTransaction();
        try {
            $service->execute($input, $request->get('account'));
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();

        return $this->success("Berhasil melakukan pembayaran");
    }

    public function cekPembayaran(Request $request, CekPembayaranRobotInActionService $service): JsonResponse
    {
        $response = $service->execute($request->get('account'));
        return $this->successWithData($response, "Berhasil Mendapatkan Detail Cek Pembayaran");
    }

    public function updatePembayaran(Request $request, UpdatePembayaranService $service)
    {
        $request->validate([
            'payment_id' => 'required'
        ]);
        $input = new UpdatePembayaranRequest($request->input('payment_id'));
        $service->execute($input, $request->get('account'));
        return $this->success("Berhasil merubah waktu pembayaran");
    }
}
