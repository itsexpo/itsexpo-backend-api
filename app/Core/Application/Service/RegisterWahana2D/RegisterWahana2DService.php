<?php

namespace App\Core\Application\Service\RegisterWahana2D;

use Illuminate\Support\Carbon;
use App\Core\Domain\Models\NRP;
use App\Exceptions\UserException;
use Illuminate\Support\Facades\Mail;
use App\Core\Domain\Models\UserAccount;
use App\Core\Application\Mail\PaymentWaiting;
use App\Core\Domain\Models\Wahana2D\Wahana2D;
use App\Core\Application\ImageUpload\ImageUpload;
use App\Core\Application\Mail\WahanaSeniRegister;
use App\Core\Domain\Models\Pembayaran\Pembayaran;
use App\Core\Application\Mail\WahanaSeniRegisterEmail;
use App\Core\Domain\Repository\RoleRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Repository\Wahana2DRepositoryInterface;
use App\Core\Domain\Models\UserHasListEvent\UserHasListEvent;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Repository\UserHasListEventRepositoryInterface;
use App\Core\Application\Service\RegisterWahana2D\RegisterWahana2DRequest;

class RegisterWahana2DService
{
    private Wahana2DRepositoryInterface $wahana_2d_repository;
    private UserHasListEventRepositoryInterface $user_has_list_event_repository;
    private UserRepositoryInterface $user_repository;
    private RoleRepositoryInterface $role_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;

    /**
     * @param Wahana2DRepositoryInterface $kti_team_repository;
     * @param UserHasListEventRepositoryInterface $user_has_list_event_repository
     * @param UserRepositoryInterface $user_repository
     * @param RoleRepositoryInterface $role_repository
     */
    public function __construct(Wahana2DRepositoryInterface $wahana_2d_repository, UserHasListEventRepositoryInterface $user_has_list_event_repository, UserRepositoryInterface $user_repository, RoleRepositoryInterface $role_repository, PembayaranRepositoryInterface $pembayaran_repository)
    {
        $this->wahana_2d_repository = $wahana_2d_repository;
        $this->user_has_list_event_repository = $user_has_list_event_repository;
        $this->user_repository = $user_repository;
        $this->role_repository = $role_repository;
        $this->pembayaran_repository = $pembayaran_repository;
    }

    public function execute(RegisterWahana2DRequest $request, UserAccount $account)
    {
        $user = $this->user_repository->find($account->getUserId());

        $role = $this->role_repository->find($user->getRoleId());

        if ($role->getName() != 'Mahasiswa') {
            UserException::throw("Role Anda Tidak Diperbolehkan Untuk Mengikuti Lomba Ini", 6002);
        }

        $buktiBayarUrl = ImageUpload::create(
            $request->getBuktiBayar(),
            'wahana_2d/bukti_bayar',
            $account->getUserId()->toString(),
            'Bukti Pembayaran'
        )->upload();

        $ktmUrl = ImageUpload::create(
            $request->getKTM(),
            'wahana_2d/ktm',
            $account->getUserId()->toString(),
            'KTM'
        )->upload();

        $current_time = Carbon::now()->addDay();

        $pembayaran = Pembayaran::create(
            $request->getBankId(),
            51,
            4,
            $request->getAtasNama(),
            $buktiBayarUrl,
            20000,
            $current_time
        );

        $this->pembayaran_repository->persist($pembayaran);

        $nrp = new NRP($request->getNrp());
        $findNrp = $this->wahana_2d_repository->findByNrp($nrp);

        if ($findNrp) {
            UserException::throw("NRP Anda Sudah Terdaftar", 6002);
        }

        if ($nrp->getDepartemen() == "" || $nrp->getFakultas() == "") {
            UserException::throw("NRP Anda Tidak Valid", 6002);
        }


        $registrant = Wahana2D::create(
            $account->getUserId(),
            $pembayaran->getId(),
            $request->getDepartemenId(),
            $request->getName(),
            $nrp,
            $request->getKontak(),
            0,
            $ktmUrl
        );

        $this->wahana_2d_repository->persist($registrant);

        $user_has_list_event = UserHasListEvent::create(
            51,
            $user->getId()
        );
        $this->user_has_list_event_repository->persist($user_has_list_event);
        Mail::to($user->getEmail()->toString())->send(new PaymentWaiting(
            $user->getName(),
        ));
    }
}
