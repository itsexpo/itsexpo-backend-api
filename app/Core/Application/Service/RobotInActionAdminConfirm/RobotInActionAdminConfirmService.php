<?php

namespace App\Core\Application\Service\RobotInActionAdminConfirm;

use App\Exceptions\UserException;
use Illuminate\Support\Facades\Mail;
use App\Core\Application\Mail\PaymentAccepted;
use App\Core\Application\Mail\PaymentNeedRevision;
use App\Core\Domain\Models\Pembayaran\PembayaranId;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Repository\StatusPembayaranRepositoryInterface;
use App\Core\Domain\Repository\RobotInActionTeamRepositoryInterface;
use App\Core\Domain\Repository\RobotInActionMemberRepositoryInterface;

class RobotInActionAdminConfirmService
{
    private RobotInActionTeamRepositoryInterface $robotInAction_team_repository;
    private RobotInActionMemberRepositoryInterface $robotInAction_member_repository;
    private UserRepositoryInterface $user_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;
    private StatusPembayaranRepositoryInterface $status_pemabayaran_repository;

    /**
     * @param RobotInActionTeamRepositoryInterface $robotInAction_team_repository
     * @param RobotInActionMemberRepositoryInterface $robotInAction_member_repository
     * @param UserRepositoryInterface $user_repository
     * @param PembayaranRepositoryInterface $pembayaran_repository
     * @param StatusPemabyaranRepositoryInterface $status_pembayaran_repository
     */
    public function __construct(RobotInActionTeamRepositoryInterface $robotInAction_team_repository, RobotInActionMemberRepositoryInterface $robotInAction_member_repository, UserRepositoryInterface $user_repository, PembayaranRepositoryInterface $pembayaran_repository, StatusPembayaranRepositoryInterface $status_pembayaran_repository)
    {
        $this->robotInAction_team_repository = $robotInAction_team_repository;
        $this->robotInAction_member_repository = $robotInAction_member_repository;
        $this->user_repository = $user_repository;
        $this->pembayaran_repository = $pembayaran_repository;
        $this->status_pemabayaran_repository = $status_pembayaran_repository;
    }

    public function execute(RobotInActionAdminConfirmRequest $request)
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

        $robotik_team = $this->robotInAction_team_repository->findByPembayaranId($id);
        if (!$robotik_team) {
            UserException::throw("Robot In Action Team Tidak Ditemukan", 1001, 404);
        }
        $ketua_member = $this->robotInAction_member_repository->findKetua($robotik_team->getId());
        if (!$ketua_member) {
            UserException::throw("Ketua Team Tidak Ditemukan", 1001, 404);
        }
        $ketua_user = $this->user_repository->find($ketua_member->getUserId());
        if (!$ketua_user) {
            UserException::throw("Ketua User Tidak Ditemukan", 1001, 404);
        }

        $this->pembayaran_repository->changeStatusPembayaran($pembayaran->getId(), $request->getStatusPembayaranId());

        $event = "Pre Event";
        
        if ($cekStatusPembayaran->getId() == 1) {
            Mail::to($ketua_user->getEmail()->toString())->send(new PaymentNeedRevision(
                $ketua_user->getName(),
                $event
            ));
        } elseif ($cekStatusPembayaran->getId() == 3) {
            Mail::to($ketua_user->getEmail()->toString())->send(new PaymentAccepted(
                $ketua_user->getName(),
                $event
            ));
        }
    }
}
