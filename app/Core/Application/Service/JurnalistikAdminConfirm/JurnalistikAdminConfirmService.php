<?php

namespace App\Core\Application\Service\JurnalistikAdminConfirm;

use App\Core\Application\Mail\PaymentAccepted;
use App\Exceptions\UserException;
use Illuminate\Support\Facades\Mail;
use App\Core\Application\Mail\PaymentNeedRevision;
use App\Core\Domain\Models\Pembayaran\PembayaranId;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Repository\JurnalistikTeamRepositoryInterface;
use App\Core\Domain\Repository\StatusPembayaranRepositoryInterface;
use App\Core\Domain\Repository\JurnalistikMemberRepositoryInterface;

class JurnalistikAdminConfirmService
{
    private JurnalistikTeamRepositoryInterface $jurnalistik_team_repository;
    private JurnalistikMemberRepositoryInterface $jurnalistik_member_repository;
    private UserRepositoryInterface $user_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;
    private StatusPembayaranRepositoryInterface $status_pemabayaran_repository;

    /**
     * @param JurnalistikTeamRepositoryInterface $jurnalistik_team_repository
     * @param JurnalistikMemberRepositoryInterface $jurnalistik_member_repository
     * @param UserRepositoryInterface $user_repository
     * @param PembayaranRepositoryInterface $pembayaran_repository
     * @param StatusPemabyaranRepositoryInterface $status_pembayaran_repository
     */
    public function __construct(JurnalistikTeamRepositoryInterface $jurnalistik_team_repository, JurnalistikMemberRepositoryInterface $jurnalistik_member_repository, UserRepositoryInterface $user_repository, PembayaranRepositoryInterface $pembayaran_repository, StatusPembayaranRepositoryInterface $status_pembayaran_repository)
    {
        $this->jurnalistik_team_repository = $jurnalistik_team_repository;
        $this->jurnalistik_member_repository = $jurnalistik_member_repository;
        $this->user_repository = $user_repository;
        $this->pembayaran_repository = $pembayaran_repository;
        $this->status_pemabayaran_repository = $status_pembayaran_repository;
    }

    public function execute(JurnalistikAdminConfirmRequest $request)
    {
        $id = new PembayaranId($request->getPembayaranId());
        $pembayaran = $this->pembayaran_repository->find($id);
        if (!$pembayaran) {
            UserException::throw("Pembayaran Tidak Ditemukan", 1001, 404);
        }

        $cekStatusPembayaran = $this->status_pemabayaran_repository->find($request->getStatusPembayaranId());
        if (!$cekStatusPembayaran) {
            UserException::throw("Status Pembayaran Tidak Ditemukan", 1001, 404);
        }

        $jurnalistik_team = $this->jurnalistik_team_repository->findByPembayaranId($id);
        if (!$jurnalistik_team) {
            UserException::throw("Jurnalistik Team Tidak Ditemukan", 1001, 404);
        }
        $ketua_member = $this->jurnalistik_member_repository->findKetua($jurnalistik_team->getId());
        if (!$ketua_member) {
            UserException::throw("Ketua Team Tidak Ditemukan", 1001, 404);
        }
        $ketua_user = $this->user_repository->find($ketua_member->getUserId());
        if (!$ketua_user) {
            UserException::throw("Ketua User Tidak Ditemukan", 1001, 404);
        }

        $this->pembayaran_repository->changeStatusPembayaran($pembayaran->getId(), $request->getStatusPembayaranId());
        if ($cekStatusPembayaran->getId() == 1) {
            Mail::to($ketua_user->getEmail()->toString())->send(new PaymentNeedRevision(
                $ketua_user->getName(),
            ));
        } elseif ($cekStatusPembayaran->getId() == 3) {
            Mail::to($ketua_user->getEmail()->toString())->send(new PaymentAccepted(
                $ketua_user->getName(),
            ));
        }
    }
}
