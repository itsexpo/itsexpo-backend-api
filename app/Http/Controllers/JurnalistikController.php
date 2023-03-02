<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Core\Application\Service\GetDataJurnalistik\GetDataJurnalistikService;
use App\Core\Application\Service\JoinTeamJurnalistik\JoinTeamJurnalistikRequest;
use App\Core\Application\Service\JoinTeamJurnalistik\JoinTeamJurnalistikService;
use App\Core\Application\Service\DeleteTeamJurnalistik\DeleteTeamJurnalistikRequest;

use App\Core\Application\Service\DeleteTeamJurnalistik\DeleteTeamJurnalistikService;
use App\Core\Application\Service\RegisterJurnalistikTeam\RegisterJurnalistikTeamRequest;
use App\Core\Application\Service\RegisterJurnalistikTeam\RegisterJurnalistikTeamService;
use App\Core\Application\Service\RegisterJurnalistikMember\RegisterJurnalistikMemberRequest;
use App\Core\Application\Service\RegisterJurnalistikMember\RegisterJurnalistikMemberService;

class JurnalistikController extends Controller
{
    public function get(Request $request, GetDataJurnalistikService $service): JsonResponse
    {
        $response = $service->execute($request->get('account'));
        return $this->successWithData($response, "Berhasil Mendapatkan Data Jurnalistik");
    }

        public function joinTeam(Request $request, JoinTeamJurnalistikService $service)
    {
        $request->validate([
            'code_team' => 'string',
        ]);

        $input = new JoinTeamJurnalistikRequest($request->input('code_team'));
        $service->execute($input, $request->get('account'));
        return $this->success("Berhasil Bergabung Dengan Team");
    }

    public function deleteTeam(Request $request, DeleteTeamJurnalistikService $service): JsonResponse
    {
        $request->validate([
            'code_team' => 'string',
            'id_personal' => 'string',
        ]);
        $input = new DeleteTeamJurnalistikRequest(
            $request->input('code_team'),
            $request->input('id_personal'),
        );
        $service->execute($input, $request->get('account'));
        return $this->success("berhasil hapus team");
    }

    public function createJurnalistikKetua(Request $request, RegisterJurnalistikTeamService $service)
    {
        $request->validate([
          'team_name' => 'max:512|string',
          'team_code' => 'max:512|string',
          'lomba_category' => 'max:512|string',
          'jenis_kegiatan' => 'max:512|string',
          'jumlah_anggota' => 'min:3|max:5|string',
          'provinsi_id' => 'max:512|string',
          'kabupaten_id' => 'max:512|string',
          'name' => 'max:512|string',
          'asal_instansi' => 'max:512|string',
          'id_line' => 'max:512|string',
        ]);

        $input = new RegisterJurnalistikTeamRequest(
            $request->input('team_name'),
            $request->input('lomba_category'),
            $request->input('jenis_kegiatan'),
            $request->input('provinsi_id'),
            $request->input('kabupaten_id'),
            $request->input('name'),
            $request->input('asal_instansi'),
            $request->input('id_line'),
            $request->file('id_card'),
            $request->file('follow_sosmed'),
            $request->file('share_poster')
        );

        DB::beginTransaction();
        try {
            $service->execute($input, $request->get('account'));
        } catch(Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Team dan Ketua Berhasil Ditambahkan");
    }

    public function createJurnalistikMember(Request $request, RegisterJurnalistikMemberService $service)
    {
        $request->validate([
          'provinsi_id' => 'max:512|string',
          'kabupaten_id' => 'max:512|string',
          'name' => 'max:512|string',
          'asal_instansi' => 'max:512|string',
          'id_line' => 'max:512|string',
        ]);

        $input = new RegisterJurnalistikMemberRequest(
            $request->input('provinsi_id'),
            $request->input('kabupaten_id'),
            $request->input('name'),
            $request->input('asal_instansi'),
            $request->input('id_line'),
            $request->file('id_card'),
            $request->file('follow_sosmed'),
            $request->file('share_poster')
        );

        DB::beginTransaction();
        try {
            $service->execute($input, $request->get('account'));
        } catch(Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Member Berhasil Ditambahkan");
    }
}