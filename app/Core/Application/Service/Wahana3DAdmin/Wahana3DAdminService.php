<?php

namespace App\Core\Application\Service\Wahana3DAdmin;

use App\Core\Domain\Models\Wahana3D\Team\Wahana3DTeam;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Repository\StatusPembayaranRepositoryInterface;
use App\Core\Domain\Repository\Wahana3DMemberRepositoryInterface;
use App\Core\Domain\Repository\Wahana3DTeamRepositoryInterface;

class Wahana3DAdminService
{
    private Wahana3DTeamRepositoryInterface $wahana_3d_team_repository;
    private Wahana3DMemberRepositoryInterface $wahana_3d_member_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;
    private StatusPembayaranRepositoryInterface $status_pembayaran_repository;

    /**
     * @param Wahana3DTeamRepositoryInterface $wahana_3d_team_repository
     * @param Wahana3DMemberRepositoryInterface $wahana_3d_member_repository
     * @param PembayaranRepositoryInterface $pembayaran_repository
     * @param StatusPembayaranRepositoryInterface $status_pembayaran_repository
     */
    public function __construct(
        Wahana3DTeamRepositoryInterface $wahana_3d_team_repository,
        Wahana3DMemberRepositoryInterface $wahana_3d_member_repository,
        PembayaranRepositoryInterface $pembayaran_repository,
        StatusPembayaranRepositoryInterface $status_pembayaran_repository
    )
    {
        $this->wahana_3d_member_repository = $wahana_3d_member_repository;
        $this->wahana_3d_team_repository = $wahana_3d_team_repository;
        $this->pembayaran_repository = $pembayaran_repository;
        $this->status_pembayaran_repository = $status_pembayaran_repository;
    }

    public function execute(Wahana3DAdminRequest $request): Wahana3DAdminPaginationResponse
    {
        $wahana_3d_teams = $this->wahana_3d_team_repository->getTeams();
        $total_tim = $this->wahana_3d_team_repository->getTotalTimCount();
        $pembayaran_revisi = $this->wahana_3d_team_repository->getPembayaranCount(1);
        $pembayaran_gagal = $this->wahana_3d_team_repository->getPembayaranCount(2);
        $pembayaran_success = $this->wahana_3d_team_repository->getPembayaranCount(3);
        $pembayaran_awaiting_verification = $this->wahana_3d_team_repository->getPembayaranCount(4);
        $pembayaran_awaiting_payment = $this->wahana_3d_team_repository->getAwaitingPaymentCount();

        if ($request->getFilter()) {
            $this->wahana_3d_team_repository->getFilter($wahana_3d_teams, $request->getFilter());
        }
        if ($request->getSearch()) {
            $this->wahana_3d_team_repository->getSearch($wahana_3d_teams, $request->getSearch());
        }

        $rows = $wahana_3d_teams->paginate($request->getPerPage(), ['wahana_3d_team.*'], 'Data Management', $request->getPage());

        $teams = [];
        foreach ($rows as $row) {
            $teams[] = $this->wahana_3d_team_repository->constructFromRows([$row])[0];
        }

        $teams_pagination = [
          "data" => $teams,
          "max_page" => ceil($rows->total() / $request->getPerPage())
        ];

        $team_response = array_map(function (Wahana3DTeam $team) {
            $status_pembayaran = "AWAITING PAYMENT";
            if ($team->getPembayaranId()->toString() != null) {
                $pembayaran_id = $this->pembayaran_repository->find($team->getPembayaranId())->getStatusPembayaranId();
                $status_pembayaran = $this->status_pembayaran_repository->find($pembayaran_id)->getStatus();
            }

            $ketua_tim = $this->wahana_3d_member_repository->findLeadByTeamId($team->getId())->getName();
            $created_at = $this->wahana_3d_team_repository->getCreatedAt($team->getId());
            return new Wahana3DAdminResponse(
                $ketua_tim,
                $team,
                $created_at,
                $status_pembayaran,
            );
        }, $teams_pagination['data']);

        return new Wahana3DAdminPaginationResponse(
            $team_response,
            $request->getPage(),
            $teams_pagination['max_page'],
            $total_tim,
            $pembayaran_revisi,
            $pembayaran_gagal,
            $pembayaran_success,
            $pembayaran_awaiting_verification,
            $pembayaran_awaiting_payment
        );
    }
}
