<?php

namespace App\Core\Application\Service\GetUserWahanaSeni;

use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Models\Wahana3D\Wahana3DMemberType;
use App\Core\Domain\Repository\Wahana2DRepositoryInterface;
use App\Core\Domain\Repository\DepartemenRepositoryInterface;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Repository\Wahana3DTeamRepositoryInterface;
use App\Core\Domain\Repository\Wahana3DMemberRepositoryInterface;
use App\Core\Domain\Repository\StatusPembayaranRepositoryInterface;

class GetUserWahanaSeniService
{
    private Wahana2DRepositoryInterface $wahana_2d_repository;
    private Wahana3DMemberRepositoryInterface $wahana_3d_member_repository;
    private Wahana3DTeamRepositoryInterface $wahana_3d_team_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;
    private StatusPembayaranRepositoryInterface $status_pembayaran_repository;
    private DepartemenRepositoryInterface $departemen_repository;

    public function __construct(Wahana2DRepositoryInterface $wahana_2d_repository, Wahana3DMemberRepositoryInterface $wahana_3d_member_repository, Wahana3DTeamRepositoryInterface $wahana_3d_team_repository, PembayaranRepositoryInterface $pembayaran_repository, StatusPembayaranRepositoryInterface $status_pembayaran_repository, DepartemenRepositoryInterface $departemen_repository)
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
        // Wahan Seni 2D
        $wahana2d = $this->wahana_2d_repository->findByUserId($account->getUserId());
        $response_wahana2d = null;
        if ($wahana2d) {
            $response_wahana2d = "";
            if ($wahana2d->getPembayaranId()->toString() != null) {
                $status_pembayaran = $this->status_pembayaran_repository->find($this->pembayaran_repository->find($wahana2d->getPembayaranId())->getStatusPembayaranId())->getStatus();
            } else {
                $status_pembayaran = "AWAITING PAYMENT";
            }
            $pembayaran = new PembayaranObjResponse($status_pembayaran, $wahana2d->getPembayaranId()->toString());

            $departemen = $this->departemen_repository->find($wahana2d->getDepartemenId())->getName();

            $response_wahana2d = new GetUserWahana2DResponse(
                $wahana2d,
                $pembayaran,
                $departemen
            );
        }
        // Wahana Seni 3D
        $wahana3d = $this->wahana_3d_team_repository->findByUserId($account->getUserId());
        $response_wahana3d = null;
        if ($wahana3d) {
            $response_wahana3d = "";
            if ($wahana3d->getPembayaranId()->toString() != null) {
                $status_pembayaran = $this->status_pembayaran_repository->find($this->pembayaran_repository->find($wahana3d->getPembayaranId())->getStatusPembayaranId())->getStatus();
            } else {
                $status_pembayaran = "AWAITING PAYMENT";
            }
            $pembayaran = new PembayaranObjResponse($status_pembayaran, $wahana3d->getPembayaranId()->toString());

            $members = $this->wahana_3d_member_repository->findAllMember($wahana3d->getId());

            $members_array = [];
            foreach ($members as $member) {
                $departemen = $this->departemen_repository->find($member->getDepartemenId())->getName();
                $memb = new GetUserWahana3DMemberResponse($member->getName(), $member->getNrp()->toString(), $departemen, $member->getKontak(), $member->getKtmUrl(), ($member->getMemberType() === Wahana3DMemberType::KETUA) ? true : false);
                array_push($members_array, $memb);
            }

            $response_wahana3d = new GetUserWahana3DResponse(
                $wahana3d->getId()->toString(),
                $wahana3d->getTeamName(),
                $wahana3d->getTeamCode(),
                $wahana3d->getDeskripsiKarya(),
                $pembayaran,
                $members_array
            );
        }

        return new GetUserWahanaSeniResponse($response_wahana2d, $response_wahana3d);
    }
}
