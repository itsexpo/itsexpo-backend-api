<?php

namespace App\Core\Application\Service\WahanaSeniAdminConfirm;

use App\Core\Application\Mail\PaymentAccepted;
use App\Core\Application\Mail\PaymentNeedRevision;
use App\Core\Domain\Models\Pembayaran\PembayaranId;
use App\Exceptions\UserException;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Repository\StatusPembayaranRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Repository\Wahana2DRepositoryInterface;
use App\Core\Domain\Repository\Wahana3DTeamRepositoryInterface;
use Illuminate\Support\Facades\Mail;

class WahanaSeniAdminConfirmService
{
    private Wahana3DTeamRepositoryInterface $wahana_3d_team_repository;
    private Wahana2DRepositoryInterface $wahana_2d_repository;
    private UserRepositoryInterface $user_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;
    private StatusPembayaranRepositoryInterface $status_pemabayaran_repository;
    /**
     * @param
     */
    public function __construct(Wahana3DTeamRepositoryInterface $wahana_3d_team_repository, Wahana2DRepositoryInterface $wahana_2d_repository, UserRepositoryInterface $user_repository, PembayaranRepositoryInterface $pembayaran_repository, StatusPembayaranRepositoryInterface $status_pembayaran_repository)
    {
        $this->wahana_3d_team_repository = $wahana_3d_team_repository;
        $this->wahana_2d_repository = $wahana_2d_repository;
        $this->user_repository = $user_repository;
        $this->pembayaran_repository = $pembayaran_repository;
        $this->status_pemabayaran_repository = $status_pembayaran_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(WahanaSeniAdminConfirmRequest $request): void
    {
        $id = new PembayaranId($request->getPembayaranId());
        $pembayaran = $this->pembayaran_repository->find($id);
        if (!$pembayaran) {
            UserException::throw("Pembayaran Tidak Ditemukan", 5075, 404);
        }

        $cekStatusPembayaran = $this->status_pemabayaran_repository->find($request->getStatusPembayaranId());
        if (!$cekStatusPembayaran) {
            UserException::throw("Status Pembayaran Tidak Ditemukan", 5695, 404);
        }

        $wahana = null;
        $ketua = null;
        switch($request->getType()) {
            case '2D':
                $wahana = $this->wahana_2d_repository->findByPembayaranId($pembayaran->getId());
                $ketua = $this->user_repository->find($wahana->getUserId());
                break;
            case '3D':
                $wahana = $this->wahana_3d_team_repository->findByPembayaranId($pembayaran->getId());
                $ketua = $this->user_repository->find($wahana->getUserId());
                break;
            default:
                UserException::throw("Type is not allowed", 500);
        }

        if(!$wahana) {
            UserException::throw("Wahana {$request->getType()} Tidak Ditemukan", 5666, 404);
        }

        $this->pembayaran_repository->changeStatusPembayaran($pembayaran->getId(), $request->getStatusPembayaranId());
        if ($cekStatusPembayaran->getId() == 1) {
            Mail::to($ketua->getEmail()->toString())->send(new PaymentNeedRevision(
                $ketua->getName(),
            ));
        } elseif ($cekStatusPembayaran->getId() == 3) {
            Mail::to($ketua->getEmail()->toString())->send(new PaymentAccepted(
                $ketua->getName(),
            ));
        }
    }
}

