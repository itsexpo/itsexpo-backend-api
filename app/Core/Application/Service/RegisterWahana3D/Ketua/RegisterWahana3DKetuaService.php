<?php

namespace App\Core\Application\Service\RegisterWahana3D\Ketua;

use Carbon\Carbon;
use App\Core\Domain\Models\NRP;
use App\Exceptions\UserException;
use Illuminate\Support\Facades\Mail;
use App\Core\Domain\Models\UserAccount;
use App\Core\Application\ImageUpload\ImageUpload;
use App\Core\Application\Mail\PaymentWaiting;
use App\Core\Domain\Models\Pembayaran\Pembayaran;
use App\Core\Application\Mail\WahanaSeniRegisterEmail;
use App\Core\Domain\Models\Wahana3D\Team\Wahana3DTeam;
use App\Core\Domain\Models\Wahana3D\Wahana3DMemberType;
use App\Core\Domain\Repository\RoleRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Models\Wahana3D\Member\Wahana3DMember;
use App\Core\Domain\Models\UserHasListEvent\UserHasListEvent;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Repository\Wahana3DTeamRepositoryInterface;
use App\Core\Domain\Repository\Wahana3DMemberRepositoryInterface;
use App\Core\Domain\Repository\UserHasListEventRepositoryInterface;
use App\Core\Application\Service\RegisterWahana3D\Ketua\RegisterWahana3DKetuaRequest;

class RegisterWahana3DKetuaService
{
    private Wahana3DTeamRepositoryInterface $wahana_3d_team_repository;
    private Wahana3DMemberRepositoryInterface $wahana_3d_member_repository;
    private UserHasListEventRepositoryInterface $user_has_list_event_repository;
    private UserRepositoryInterface $user_repository;
    private RoleRepositoryInterface $role_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;

    /**
     * @param Wahana3DTeamRepositoryInterface $wahana_3d_team_repository
     * @param Wahana3DMemberRepositoryInterface $wahana_3d_member_repository
     * @param UserHasListEventRepositoryInterface $user_has_list_event_repository
     * @param UserRepositoryInterface $user_repository
     * @param RoleRepositoryInterface $role_repository
     * @param PembayaranRepositoryInterface $pembayaran_repository
     */
    public function __construct(
        Wahana3DTeamRepositoryInterface $wahana_3d_team_repository,
        Wahana3DMemberRepositoryInterface $wahana_3d_member_repository,
        UserHasListEventRepositoryInterface $user_has_list_event_repository,
        UserRepositoryInterface $user_repository,
        RoleRepositoryInterface $role_repository,
        PembayaranRepositoryInterface $pembayaran_repository
    ) {
        $this->wahana_3d_team_repository = $wahana_3d_team_repository;
        $this->wahana_3d_member_repository = $wahana_3d_member_repository;
        $this->user_has_list_event_repository = $user_has_list_event_repository;
        $this->user_repository = $user_repository;
        $this->role_repository = $role_repository;
        $this->pembayaran_repository = $pembayaran_repository;
    }

    public function execute(RegisterWahana3DKetuaRequest $request, UserAccount $account)
    {
        $registered_user = $this->wahana_3d_team_repository->findByUserId($account->getUserId());

        if ($registered_user) {
            UserException::throw("User Sudah Mendaftar di Event Wahana 3D", 1004, 404);
        }

        $user = $this->user_repository->find($account->getUserId());
        $role = $this->role_repository->find($user->getRoleId());

        if ($role->getName() != 'Mahasiswa') {
            UserException::throw("Role Anda Tidak Diperbolehkan Untuk Mengikuti Lomba Ini", 6002);
        }

        $buktiBayarUrl = ImageUpload::create(
            $request->getBuktiBayar(),
            'wahana_3d/bukti_bayar',
            $account->getUserId()->toString(),
            'Bukti Pembayaran'
        )->upload();

        $ktm_url = ImageUpload::create(
            $request->getKtm(),
            'wahana_3d/ktm',
            $account->getUserId()->toString(),
            'KTM'
        )->upload();

        $team_code = 'WHNSENI_3D_' . str_pad($this->wahana_3d_team_repository->countAllTeams() + 1, 3, '0', STR_PAD_LEFT);

        $current_time = Carbon::now()->addDay();

        $pembayaran = Pembayaran::create(
            $request->getBankId(),
            52,
            4,
            $request->getAtasNama(),
            $buktiBayarUrl,
            30000,
            $current_time
        );

        $this->pembayaran_repository->persist($pembayaran);

        $team = Wahana3DTeam::create(
            $pembayaran->getId(),
            $account->getUserId(),
            $request->getTeamName(),
            $team_code,
            $request->getDeskripsiKarya()
        );

        $nrp = new NRP($request->getNrp());
        $findNrp = $this->wahana_3d_member_repository->findNrp($nrp);

        if ($findNrp) {
            UserException::throw("NRP Anda Sudah Terdaftar", 6002);
        }

        if ($nrp->getDepartemen() == "" || $nrp->getFakultas() == "") {
            UserException::throw("NRP Anda Tidak Valid", 6002);
        }

        $member = Wahana3DMember::create(
            $team->getId(),
            Wahana3DMemberType::KETUA,
            $request->getDepartemenId(),
            $request->getName(),
            $nrp,
            $request->getKontak(),
            $ktm_url
        );

        $this->wahana_3d_team_repository->persist($team);
        $this->wahana_3d_member_repository->persist($member);

        $user_has_list_event = UserHasListEvent::create(
            52,
            $team->getUserId(),
        );

        $this->user_has_list_event_repository->persist($user_has_list_event);
        Mail::to($user->getEmail()->toString())->send(new PaymentWaiting(
            $user->getName(),
        ));
    }
}
