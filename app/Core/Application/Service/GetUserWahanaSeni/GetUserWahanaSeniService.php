<?php

namespace App\Core\Application\Service\GetUserWahanaSeni;

use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Repository\DepartemenRepositoryInterface;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Repository\StatusPembayaranRepositoryInterface;
use App\Core\Domain\Repository\Wahana2DRepositoryInterface;
use App\Core\Domain\Repository\Wahana3DTeamRepositoryInterface;

class GetUserWahanaSeniService
{
    private Wahana2DRepositoryInterface $wahana_2d_repository;
    private Wahana3DTeamRepositoryInterface $wahana_3d_member_repository;
    private Wahana3DTeamRepositoryInterface $wahana_3d_team_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;
    private StatusPembayaranRepositoryInterface $status_pembayaran_repository;
    private DepartemenRepositoryInterface $departemen_repository;

    public function __construct(Wahana2DRepositoryInterface $wahana_2d_repository, Wahana3DTeamRepositoryInterface $wahana_3d_member_repository, Wahana3DTeamRepositoryInterface $wahana_3d_team_repository, PembayaranRepositoryInterface $pembayaran_repository, StatusPembayaranRepositoryInterface $status_pembayaran_repository, DepartemenRepositoryInterface $departemen_repository)
    {
        $this->wahana_2d_repository = $wahana_2d_repository;
        $this->wahana_3d_member_repository = $wahana_3d_member_repository;
        $this->wahana_3d_team_repository = $wahana_3d_team_repository;
        $this->pembayaran_repository = $pembayaran_repository;
        $this->status_pembayaran_repository = $status_pembayaran_repository;
        $this->departemen_repository = $departemen_repository;
    }

    public function execute(UserAccount $account)
    {
        $wahana2d = $this->wahana_2d_repository->findByUserId($account->getUserId());
        $response_wahana2d = null;
        if ($wahana2d) {
            $response_wahana2d = "";
            if ($wahana2d->getPembayaranId()->toString() != null) {
                $status_pembayaran = $this->status_pembayaran_repository->find($this->pembayaran_repository->find($wahana2d->getPembayaranId())->getStatusPembayaranId())->getStatus();
            } else {
                $status_pembayaran = "AWAITING PAYMENT";
            }

            $departemen = $this->departemen_repository->find($wahana2d->getDepartemenId())->getName();

            $response_wahana2d = new GetUserWahana2DResponse(
                $wahana2d,
                $wahana2d->getPembayaranId()->toString(),
                $status_pembayaran,
                $departemen
            );
        }

        return new GetUserWahanaSeniResponse($response_wahana2d);
    }
}
