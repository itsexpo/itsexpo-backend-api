<?php

namespace App\Core\Application\Service\RobotInActionAdmin;

use Illuminate\Support\Facades\DB;

use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Repository\RobotInActionTeamRepositoryInterface;
use App\Core\Domain\Repository\StatusPembayaranRepositoryInterface;
use App\Core\Domain\Models\RobotInAction\Team\RobotInActionTeam;
use App\Core\Domain\Repository\RobotInActionMemberRepositoryInterface;

class RobotInActionAdminService
{
    private RobotInActionTeamRepositoryInterface  $robot_in_action_team_repository;
    private RobotInActionMemberRepositoryInterface $robot_in_action_member_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;
    private StatusPembayaranRepositoryInterface $status_pembayaran_repository;

    public function __construct(RobotInActionTeamRepositoryInterface $robot_in_action_team_repository, PembayaranRepositoryInterface $pembayaran_repository, StatusPembayaranRepositoryInterface $status_pembayaran_repository, RobotInActionMemberRepositoryInterface $robot_in_action_member_repository)
    {
        $this->robot_in_action_team_repository = $robot_in_action_team_repository;
        $this->pembayaran_repository = $pembayaran_repository;
        $this->status_pembayaran_repository = $status_pembayaran_repository;
        $this->robot_in_action_member_repository = $robot_in_action_member_repository;
    }

    public function execute(RobotInActionAdminRequest $request): RobotInActionAdminPaginationResponse
    {
        $rows = DB::table('robot_in_action_team')
            ->leftJoin('pembayaran', 'robot_in_action_team.pembayaran_id', '=', 'pembayaran.id')
            ->leftJoin('status_pembayaran', 'pembayaran.status_pembayaran_id', '=', 'status_pembayaran.id')
            ->leftJoin('robot_in_action_member', 'robot_in_action_team.id', '=', 'robot_in_action_member.robot_in_action_team_id')
            ->where('robot_in_action_member.member_type', 'KETUA');

        $totaltim = DB::table('robot_in_action_team')
            ->count();
        $pembayaran_revisi = DB::table('robot_in_action_team')
            ->leftJoin('pembayaran', 'robot_in_action_team.pembayaran_id', '=', 'pembayaran.id')
            ->where('pembayaran.status_pembayaran_id', 1)
            ->count();
        $pembayaran_gagal = DB::table('robot_in_action_team')
            ->leftJoin('pembayaran', 'robot_in_action_team.pembayaran_id', '=', 'pembayaran.id')
            ->where('pembayaran.status_pembayaran_id', 2)
            ->count();
        $pembayaran_success = DB::table('robot_in_action_team')
            ->leftJoin('pembayaran', 'robot_in_action_team.pembayaran_id', '=', 'pembayaran.id')
            ->where('pembayaran.status_pembayaran_id', 3)
            ->count();
        $pembayaran_awaiting_verification = DB::table('robot_in_action_team')
            ->leftJoin('pembayaran', 'robot_in_action_team.pembayaran_id', '=', 'pembayaran.id')
            ->where('pembayaran.status_pembayaran_id', 4)
            ->count();
        $pembayaran_awaiting_payment = DB::table('robot_in_action_team')
            ->leftJoin('pembayaran', 'robot_in_action_team.pembayaran_id', '=', 'pembayaran.id')
            ->where('pembayaran.status_pembayaran_id', 5)
            ->count();

        if ($request->getFilter()) {
            $rows->where('pembayaran.status_pembayaran_id', $request->getFilter());
        }
        if ($request->getSearch()) {
            $rows->where('robot_in_action_team.team_name', 'like', '%' . $request->getSearch() . '%')->orWhere('robot_in_action_member.name', 'like', '%' . $request->getSearch() . '%');
        }

        $rows = $rows->paginate($request->getPerPage(), ['robot_in_action_team.*'], 'Data Management', $request->getPage());

        $teams = [];
        foreach ($rows as $row) {
            $teams[] = $this->robot_in_action_team_repository->constructFromRows([$row])[0];
        }

        $teams_pagination = [
            "data" => $teams,
            "max_page" => ceil($rows->total() / $request->getPerPage())
        ];

        $team_response = array_map(function (RobotInActionTeam $team) {
            $status_pembayaran = false;
            if ($team->getPembayaranId()->toString() != null) {
                $pembayaran_id = $this->pembayaran_repository->find($team->getPembayaranId())->getStatusPembayaranId();
                $status_pembayaran = $this->status_pembayaran_repository->find($pembayaran_id)->getStatus();
            }
            $ketua_tim = $this->robot_in_action_member_repository->findKetua($team->getId())->getName();
            $created_at = $this->robot_in_action_team_repository->getCreatedAt($team->getId());
            return new RobotInActionAdminResponse(
                $ketua_tim,
                $team,
                $created_at,
                $status_pembayaran
            );
        }, $teams_pagination['data']);

        return new RobotInActionAdminPaginationResponse($team_response, $request->getPage(), $teams_pagination['max_page'], $totaltim, $pembayaran_revisi, $pembayaran_gagal, $pembayaran_success, $pembayaran_awaiting_verification, $pembayaran_awaiting_payment);
    }
}
