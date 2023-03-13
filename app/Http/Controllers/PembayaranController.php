<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Core\Application\Service\CreatePembayaranJurnalistik\CreatePembayaranJurnalistikRequest;
use App\Core\Application\Service\CreatePembayaranJurnalistik\CreatePembayaranJurnalistikService;

class PembayaranController extends Controller
{
    public function createPembayaranJurnalistik(Request $request, CreatePembayaranJurnalistikService $service): JsonResponse
    {
        $request->validate([
            'bank_id' => 'required',
            'bukti_pembayaran' => 'required',
            'harga' => 'required',
            'jurnalistik_team_id' => 'required'
        ]);

        $input = new CreatePembayaranJurnalistikRequest(
            $request->input('bank_id'),
            $request->input('harga'),
            $request->input('jurnalistik_team_id'),
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
}