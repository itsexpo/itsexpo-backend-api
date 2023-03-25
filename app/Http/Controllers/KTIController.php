<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\KTI\KTIMemberType;
use App\Core\Application\Service\GetKTITeam\GetKTITeamService;
use App\Core\Application\Service\RegisterKTITeam\RegisterKTITeamRequest;
use App\Core\Application\Service\RegisterKTITeam\RegisterKTITeamService;
use App\Core\Application\Service\CekPembayaranKTI\CekPembayaranKTIService;
use App\Core\Application\Service\RegisterKTIMember\RegisterKTIMemberRequest;
use App\Core\Application\Service\RegisterKTIMember\RegisterKTIMemberService;

class KTIController extends Controller
{
    public function createKTITeam(Request $request, RegisterKTITeamService $kti_team_service, RegisterKTIMemberService $kti_member_service)
    {
        $request->validate([
            'team_name' => 'max:512|string',
            'asal_instansi' => 'max:512|string',
            'nama_ketua' => 'max:512|string',
            'no_telp_ketua' => 'max:512|string',
        ]);

        $input = new RegisterKTITeamRequest(
            $request->input('team_name'),
            $request->input('asal_instansi'),
            $request->input('nama_ketua'),
            $request->input('no_telp_ketua'),
            $request->file('follow_sosmed'),
            $request->file('bukti_repost'),
            $request->file('twibbon'),
            $request->file('file_abstrak')
        );

        $input_member = array_map(function (array $member) {
            return new RegisterKTIMemberRequest(
                $member['nama'],
                $member['no_telp'],
                KTIMemberType::MEMBER
            );
        }, $request->input('team_member'));

        DB::beginTransaction();
        try {
            $kti_team_service->execute($input, $request->get('account'));
            $kti_member_service->execute($input_member, $request->get('account'));
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Berhasil Membuat Tim");
    }

    public function getKTITeam(Request $request, GetKTITeamService $service)
    {
        $data = $service->execute($request->get('account'));
        return $this->successWithData($data, "Berhasil mendapatkan data tim");
    }

    public function cekPembayaranKTI(Request $request, CekPembayaranKTIService $service): JsonResponse
    {
        $response = $service->execute($request->get('account'));
        return $this->successWithData($response, "Berhasil Mendapatkan Detail Cek Pembayaran");
    }
}
