<?php

namespace App\Core\Application\Service\JurnalistikAdmin;

use Illuminate\Support\Facades\DB;

use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Repository\JurnalistikTeamRepositoryInterface;
use App\Core\Domain\Repository\StatusPembayaranRepositoryInterface;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeam;
use App\Core\Domain\Repository\JurnalistikMemberRepositoryInterface;

class JurnalistikAdminService
{
    private JurnalistikTeamRepositoryInterface  $jurnalistik_team_repository;
    private JurnalistikMemberRepositoryInterface $jurnalistik_member_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;
    private StatusPembayaranRepositoryInterface $status_pembayaran_repository;

    public function __construct(JurnalistikTeamRepositoryInterface $jurnalistik_team_repository, PembayaranRepositoryInterface $pembayaran_repository, StatusPembayaranRepositoryInterface $status_pembayaran_repository, JurnalistikMemberRepositoryInterface $jurnalistik_member_repository)
    {
        $this->jurnalistik_team_repository = $jurnalistik_team_repository;
        $this->pembayaran_repository = $pembayaran_repository;
        $this->status_pembayaran_repository = $status_pembayaran_repository;
        $this->jurnalistik_member_repository = $jurnalistik_member_repository;
    }

    public function execute(JurnalistikAdminRequest $request): JurnalistikAdminPaginationResponse
    {
        $rows = DB::table('jurnalistik_team')
            ->leftJoin('pembayaran', 'jurnalistik_team.pembayaran_id', '=', 'pembayaran.id')
            ->leftJoin('status_pembayaran', 'pembayaran.status_pembayaran_id', '=', 'status_pembayaran.id')
            ->leftJoin('jurnalistik_member', 'jurnalistik_team.id', '=', 'jurnalistik_member.jurnalistik_team_id')
            ->where('jurnalistik_member.member_type', 'KETUA');

        $totaltim = DB::table('jurnalistik_team')
            ->count();
        $pembayaran_revisi = DB::table('jurnalistik_team')
            ->leftJoin('pembayaran', 'jurnalistik_team.pembayaran_id', '=', 'pembayaran.id')
            ->where('pembayaran.status_pembayaran_id', 1)
            ->count();
        $pembayaran_gagal = DB::table('jurnalistik_team')
            ->leftJoin('pembayaran', 'jurnalistik_team.pembayaran_id', '=', 'pembayaran.id')
            ->where('pembayaran.status_pembayaran_id', 2)
            ->count();
        $pembayaran_success = DB::table('jurnalistik_team')
            ->leftJoin('pembayaran', 'jurnalistik_team.pembayaran_id', '=', 'pembayaran.id')
            ->where('pembayaran.status_pembayaran_id', 3)
            ->count();
        $pembayaran_awaiting_verification = DB::table('jurnalistik_team')
            ->leftJoin('pembayaran', 'jurnalistik_team.pembayaran_id', '=', 'pembayaran.id')
            ->where('pembayaran.status_pembayaran_id', 4)
            ->count();
        $pembayaran_awaiting_payment = DB::table('jurnalistik_team')
            ->leftJoin('pembayaran', 'jurnalistik_team.pembayaran_id', '=', 'pembayaran.id')
            ->where('pembayaran.status_pembayaran_id', 5)
            ->count();

        if ($request->getFilter()) {
            $rows->where('pembayaran.status_pembayaran_id', $request->getFilter());
        }
        if ($request->getSearch()) {
            $rows->where('jurnalistik_team.team_name', 'like', '%' . $request->getSearch() . '%')->orWhere('jurnalistik_member.name', 'like', '%' . $request->getSearch() . '%');
        }

        $rows = $rows->paginate($request->getPerPage(), ['jurnalistik_team.*'], 'Data Management', $request->getPage());

        $teams = [];
        foreach ($rows as $row) {
            $teams[] = $this->jurnalistik_team_repository->constructFromRows([$row])[0];
        }

        $teams_pagination = [
            "data" => $teams,
            "max_page" => ceil($rows->total() / $request->getPerPage())
        ];

        $team_response = array_map(function (JurnalistikTeam $team) {
            $pembayaran_id = $this->pembayaran_repository->find($team->getPembayaranId())->getStatusPembayaranId();
            $ketua_tim = $this->jurnalistik_member_repository->findKetua($team->getId())->getName();
            $status_pembayaran = $this->status_pembayaran_repository->find($pembayaran_id)->getStatus();
            $created_at = $this->jurnalistik_team_repository->getCreatedAt($team->getId());
            return new JurnalistikAdminResponse(
                $ketua_tim,
                $team,
                $created_at,
                $status_pembayaran
            );
        }, $teams_pagination['data']);

        return new JurnalistikAdminPaginationResponse($team_response, $request->getPage(), $teams_pagination['max_page'], $totaltim, $pembayaran_revisi, $pembayaran_gagal, $pembayaran_success, $pembayaran_awaiting_verification, $pembayaran_awaiting_payment);
    }
}
