<?php

namespace App\Core\Application\Service\KTIAdminPass;

use App\Core\Application\Mail\PaymentAccepted;
use App\Exceptions\UserException;
use Illuminate\Support\Facades\Mail;
use App\Core\Application\Mail\PaymentNeedRevision;
use App\Core\Domain\Models\KTI\Team\KTITeamId;
use App\Core\Domain\Models\Pembayaran\PembayaranId;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Repository\StatusPembayaranRepositoryInterface;
use App\Core\Domain\Repository\KTIMemberRepositoryInterface;
use App\Core\Domain\Repository\KTITeamRepositoryInterface;

class KTIAdminPassService
{
    private KTITeamRepositoryInterface $kti_team_repository;
    private KTIMemberRepositoryInterface $kti_member_repository;
    private UserRepositoryInterface $user_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;
    private StatusPembayaranRepositoryInterface $status_pemabayaran_repository;

    /**
     * @param KTITeamRepositoryInterface $kti_team_repository
     * @param KTIMemberRepositoryInterface $kti_member_repository
     * @param UserRepositoryInterface $user_repository
     * @param PembayaranRepositoryInterface $pembayaran_repository
     * @param StatusPemabyaranRepositoryInterface $status_pembayaran_repository
     */
    public function __construct(KTITeamRepositoryInterface $kti_team_repository, KTIMemberRepositoryInterface $kti_member_repository, UserRepositoryInterface $user_repository, PembayaranRepositoryInterface $pembayaran_repository, StatusPembayaranRepositoryInterface $status_pembayaran_repository)
    {
        $this->kti_team_repository = $kti_team_repository;
        $this->kti_member_repository = $kti_member_repository;
        $this->user_repository = $user_repository;
        $this->pembayaran_repository = $pembayaran_repository;
        $this->status_pemabayaran_repository = $status_pembayaran_repository;
    }

    public function execute(KTIAdminPassRequest $request)
    {
        $id = new KTITeamId($request->getTeamId());
        $kti_team = $this->kti_team_repository->find($id);
        if (!$kti_team) {
            UserException::throw("KTI Team Tidak Ditemukan", 1001, 404);
        }

        if($kti_team->isLolosPaper() === $request->isLolosPaper())
        {
            UserException::throw("Tidak Dapat Mengganti Status Kelolosan Tim Karena Statusnya Sudah Sama", 1007, 404);
        }

        $kti_team->pass($request->isLolosPaper());
        $this->kti_team_repository->persist($kti_team);
    }
}
