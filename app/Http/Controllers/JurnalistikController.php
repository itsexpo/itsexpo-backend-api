<?php

namespace App\Http\Controllers;

use App\Core\Application\Service\DeleteTeamJurnalistik\DeleteTeamJurnalistikRequest;
use App\Core\Application\Service\DeleteTeamJurnalistik\DeleteTeamJurnalistikService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Core\Application\Service\GetDataJurnalistik\GetDataJurnalistikService;
use App\Core\Application\Service\JoinTeamJurnalistik\JoinTeamJurnalistikRequest;
use App\Core\Application\Service\JoinTeamJurnalistik\JoinTeamJurnalistikService;

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

        $input = new JoinTeamJurnalistikRequest($request->input('code_team'), $request->get('account'));
        $service->execute($input);
        return $this->success("berhasil gabung team");
    }

    public function deleteTeam(Request $request, DeleteTeamJurnalistikService $service): JsonResponse
    {
        $request->validate([
            'code_team' => 'string',
            'id_personal' => 'string',
        ]);
        $input = new DeleteTeamJurnalistikRequest(
            $request->input('code_team'),
            $request->get('account'),
            $request->input('id_personal'),
        );
        $service->execute($input);
        return $this->success("berhasil hapus team");
    }
}
