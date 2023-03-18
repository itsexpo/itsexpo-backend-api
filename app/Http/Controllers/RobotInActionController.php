<?php

namespace App\Http\Controllers;

use App\Core\Application\Service\CekPembayaranRobotInAction\CekPembayaranRobotInActionService;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use App\Core\Domain\Models\RobotInAction\RobotInActionMemberType;
use App\Core\Application\Service\GetAnggotaRobotInAction\GetAnggotaRobotInActionService;
use App\Core\Application\Service\RegisterRobotInAction\Ketua\RegisterRobotInActionKetuaRequest;
use App\Core\Application\Service\RegisterRobotInAction\Ketua\RegisterRobotInActionKetuaService;
use App\Core\Application\Service\RegisterRobotInAction\Member\RegisterRobotInActionMemberRequest;
use App\Core\Application\Service\RegisterRobotInAction\Member\RegisterRobotInActionMemberService;
use App\Core\Application\Service\CreatePembayaranRobotInAction\CreatePembayaranRobotInActionRequest;
use App\Core\Application\Service\CreatePembayaranRobotInAction\CreatePembayaranRobotInActionService;

class RobotInActionController extends Controller
{
    public function register(Request $request, RegisterRobotInActionKetuaService $service_ketua, RegisterRobotInActionMemberService $service_member)
    {
        $request->validate([
            'member_type' => 'required|string',
            'name' => 'required|string',
            'no_telp' => 'required|string',
            'asal_sekolah' => 'required|string',
        ]);
        if ($request->input('member_type') == RobotInActionMemberType::KETUA->value) {
            $request->validate([
                'team_name' => 'required|string',
                'deskripsi_karya' => 'required|string',
            ]);
            $input_ketua = new RegisterRobotInActionKetuaRequest(
                $request->input('member_type'),
                $request->input('team_name'),
                $request->input('name'),
                $request->input('no_telp'),
                $request->input('deskripsi_karya'),
                $request->input('asal_sekolah'),
                $request->file('id_card'),
                $request->file('follow_sosmed'),
                $request->file('share_poster'),
            );

            DB::beginTransaction();
            try {
                $service_ketua->execute($input_ketua, $request->get('account'));
            } catch (Throwable $e) {
                DB::rollBack();
                throw $e;
            }
            DB::commit();

            return $this->success("Berhasil Mendaftarkan ketua dan tim");
        } elseif ($request->input('member_type') == RobotInActionMemberType::MEMBER->value) {
            $input_member = new RegisterRobotInActionMemberRequest(
                $request->input('member_type'),
                $request->input('name'),
                $request->input('no_telp'),
                $request->input('asal_sekolah'),
                $request->file('id_card'),
                $request->file('follow_sosmed'),
                $request->file('share_poster'),
            );

            DB::beginTransaction();
            try {
                $service_member->execute($input_member, $request->get('account'));
            } catch (Throwable $e) {
                DB::rollBack();
                throw $e;
            }
            DB::commit();

            return $this->success("Berhasil Mendaftarkan member");
        }
    }

    public function get(Request $request, GetAnggotaRobotInActionService $service)
    {
        $response = $service->execute($request->get('account'));
        return $this->successWithData($response, "Berhasil mendapatkan data robot in action");
    }

    public function createPembayaran(Request $request, CreatePembayaranRobotInActionService $service)
    {
        $request->validate([
            'bank_id' => 'required|integer',
            'harga' => 'required|integer',
            'robotInAction_team_id' => 'required|string',
            'bukti_pembayaran' => 'required|file|mimes:jpeg,png,pdf'
        ]);

        $input = new CreatePembayaranRobotInActionRequest(
            $request->input('bank_id'),
            $request->input('harga'),
            $request->input('robotInAction_team_id'),
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
}
