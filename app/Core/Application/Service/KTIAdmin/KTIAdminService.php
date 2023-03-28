<?php

namespace App\Core\Application\Service\KTIAdmin;

use App\Core\Domain\Models\KTI\Team\KTITeam;
use App\Core\Domain\Repository\KTIMemberRepositoryInterface;
use App\Core\Domain\Repository\KTITeamRepositoryInterface;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Repository\StatusPembayaranRepositoryInterface;

class KTIAdminService
{
    private KTITeamRepositoryInterface $kti_team_repository;
    private KTIMemberRepositoryInterface $kti_member_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;
    private StatusPembayaranRepositoryInterface $status_pembayaran_repository;

    /**
     * @param KTITeamRepositoryInterface $kti_team_repository
     * @param KTIMemberRepositoryInterface $kti_member_repository
     * @param PembayaranRepositoryInterface $pembayaran_repository
     * @param StatusPembayaranRepositoryInterface $status_pembayaran_repository
     */
    public function __construct(KTITeamRepositoryInterface $kti_team_repository, KTIMemberRepositoryInterface $kti_member_repository, PembayaranRepositoryInterface $pembayaran_repository, StatusPembayaranRepositoryInterface $status_pembayaran_repository)
    {
        $this->kti_team_repository = $kti_team_repository;
        $this->kti_member_repository = $kti_member_repository;
        $this->pembayaran_repository = $pembayaran_repository;
        $this->status_pembayaran_repository = $status_pembayaran_repository;
    }

    public function execute(KTIAdminRequest $request): KTIAdminPaginationResponse
    {
        $kti_teams = $this->kti_team_repository->getTeams();
        $total_tim = $this->kti_team_repository->getTotalTimCount();
        $pembayaran_revisi = $this->kti_team_repository->getPembayaranRevisiCount(1);
        $pembayaran_gagal = $this->kti_team_repository->getPembayaranGagalCount(2);
        $pembayaran_success = $this->kti_team_repository->getPembayaranSuccessCount(3);
        $pembayaran_awaiting_verification = $this->kti_team_repository->getAwaitingVerificationCount(4);
        $pembayaran_awaiting_payment = $this->kti_team_repository->getAwaitingPaymentCount(5);

        if ($request->getFilter()) {
            $this->kti_team_repository->getFilter($kti_teams, $request->getFilter());
        }
        if ($request->getSearch()) {
            $this->kti_team_repository->getSearch($kti_teams, $request->getSearch());
        }

        $rows = $kti_teams->paginate($request->getPerPage(), ['kti_team.*'], 'Data Management', $request->getPage());

        $teams = [];
        foreach ($rows as $row) {
            $teams[] = $this->kti_team_repository->constructFromRows([$row])[0];
        }

        $teams_pagination = [
          "data" => $teams,
          "max_page" => ceil($rows->total() / $request->getPerPage())
        ];

        $team_response = array_map(function (KTITeam $team) {
            $status_pembayaran = "AWAITING PAYMENT";
            if ($team->getPembayaranId()->toString() != null) {
                $pembayaran_id = $this->pembayaran_repository->find($team->getPembayaranId())->getStatusPembayaranId();
                $status_pembayaran = $this->status_pembayaran_repository->find($pembayaran_id)->getStatus();
            }

            $ketua_tim = $this->kti_member_repository->findLeadByTeamId($team->getId())->getName();
            $created_at = $this->kti_team_repository->getCreatedAt($team->getId());
            return new KTIAdminResponse(
                $ketua_tim,
                $team,
                $created_at,
                $status_pembayaran
            );
        }, $teams_pagination['data']);

        return new KTIAdminPaginationResponse(
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
