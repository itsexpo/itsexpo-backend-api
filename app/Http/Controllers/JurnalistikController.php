<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Core\Application\Service\GetDataJurnalistik\GetDataJurnalistikService;
use App\Core\Application\Service\RegisterJurnalistikTeam\RegisterJurnalistikTeamRequest;
use App\Core\Application\Service\RegisterJurnalistikTeam\RegisterJurnalistikTeamService;
use App\Core\Application\Service\RegisterJurnalistikMember\RegisterJurnalistikMemberRequest;
use App\Core\Application\Service\RegisterJurnalistikMember\RegisterJurnalistikMemberService;
use App\Core\Domain\Models\Jurnalistik\JurnalistikMemberType;

use Throwable;

class JurnalistikController extends Controller
{
    public function get(Request $request, GetDataJurnalistikService $service): JsonResponse
    {
        $response = $service->execute($request->get('account'));
        return $this->successWithData($response, "Berhasil Mendapatkan Data Jurnalistik");
    }

    public function createTeam(Request $request, RegisterJurnalistikTeamService $service)
    {
        $request->validate([
          'team_name' => 'max:512|string',
          'team_code' => 'max:512|string',
          'lomba_category' => 'max:512|string',
          'jenis_kegiatan' => 'max:512|string',
          'jumlah_anggota' => 'min:3|max:5|string'
        ]);

        $input = new RegisterJurnalistikTeamRequest(
            $request->input('team_name'),
            $request->input('team_code'),
            $request->input('lomba_category'),
            $request->input('jenis_kegiatan'),
            $request->input('jumlah_anggota')
        );

        DB::beginTransaction();
        try {
            $service->execute($input);
        } catch(Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
        return $this->success("Team berhasil dibuat");
    }

    public function createMember(Request $request, RegisterJurnalistikMemberService $service)
    {
        $request->validate([
          'provinsi_id' => 'max:512|string',
          'kabupaten_id' => 'max:512|string',
          'name' => 'max:512|string',
          'member_type' => 'max:512|string',
          'asal_instansi' => 'max:512|string',
          'id_line' => 'max:512|string',
        ]);

        $input = new RegisterJurnalistikMemberRequest(
            $request->input('provinsi_id'),
            $request->input('kabupaten_id'),
            $request->input('name'),
            // JurnalistikMemberType::from($request->input('member_type')),
            $request->input('member_type'),
            $request->input('asal_instansi'),
            $request->input('id_line'),
            $request->file('id_card_url'),
            $request->file('follow_sosmed_url'),
            $request->file('share_poster_url')
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

/*
Bagaimana cara dapetin jurnalistik_team_id
Bagaimana cara masukkin key value file di postman

RegisterJurnalistikMemberService:
Untuk storage yang input file ditaruh mana
*/
