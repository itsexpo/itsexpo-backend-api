<?php

namespace App\Core\Application\Service\RegisterWahana2D;

use Illuminate\Support\Carbon;
use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Models\Wahana2D\Wahana2D;
use App\Core\Domain\Models\Wahana2D\Wahana2DId;
use App\Core\Application\ImageUpload\ImageUpload;
use App\Core\Domain\Models\Pembayaran\Pembayaran;
use App\Core\Domain\Repository\RoleRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Repository\Wahana2DRepositoryInterface;
use App\Core\Domain\Models\UserHasListEvent\UserHasListEvent;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Repository\UserHasListEventRepositoryInterface;

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

        $registered_user = $this->wahana_2d_repository->findByName($request->getName());
        if ($registered_user) {
            UserException::throw("Sudah terdapat pendaftar dengan nama yang sama", 1021, 404);
        }

        $role = $this->role_repository->find($user->getRoleId());

        if ($role->getName() != 'Mahasiswa') {
            UserException::throw("Role Anda Tidak Diperbolehkan Untuk Mengikuti Lomba Ini", 6002);
        }

        $ktmUrl = ImageUpload::create(
            $request->getKTM(),
            'wahana_2d/ktm',
            $account->getUserId()->toString(),
            'KTM'
        )->upload();
      
        $current_time = Carbon::now()->addDay();
        
        $pembayaran = Pembayaran::create(
            null,
            51,
            5,
            null,
            null,
            null,
            $current_time
        );
        
        $this->pembayaran_repository->persist($pembayaran);
        
        $registrant = Wahana2D::create(
            $pembayaran->getId(),
            $request->getDepartemenId(),
            $request->getName(),
            $request->getNrp(),
            $request->getKontak(),
            0,
            $request->getEmail(),
            $ktmUrl
        );
        
        $this->wahana_2d_repository->persist($registrant);

        $user_has_list_event = UserHasListEvent::create(
            51,
            $user->getId()
        );
        $this->user_has_list_event_repository->persist($user_has_list_event);
    }
}
