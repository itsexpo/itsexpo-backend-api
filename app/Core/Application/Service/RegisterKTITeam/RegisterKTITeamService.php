<?php

namespace App\Core\Application\Service\RegisterKTITeam;

use App\Core\Application\ImageUpload\ImageUpload;
use App\Core\Domain\Models\KTI\KTIMemberType;
use App\Core\Domain\Models\KTI\Member\KTIMember;
use App\Core\Domain\Models\KTI\Team\KTITeam;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Models\UserHasListEvent\UserHasListEvent;
use App\Core\Domain\Repository\KTIMemberRepositoryInterface;
use App\Core\Domain\Repository\KTITeamRepositoryInterface;
use App\Core\Domain\Repository\RoleRepositoryInterface;
use App\Core\Domain\Repository\UserHasListEventRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Exceptions\UserException;

class RegisterKTITeamService
{
    private KTITeamRepositoryInterface $kti_team_repository;
    private KTIMemberRepositoryInterface $kti_member_repository;
    private UserHasListEventRepositoryInterface $user_has_list_event_repository;
    private UserRepositoryInterface $user_repository;
    private RoleRepositoryInterface $role_repository;

    /**
     * @param KTITeamRepositoryInterface $kti_team_repository;
     * @param UserHasListEventRepositoryInterface $user_has_list_event_repository
     * @param UserRepositoryInterface $user_repository
     * @param RoleRepositoryInterface $role_repository
     * @param KTIMemberRepositoryInterface $kti_member_repository
     */
    public function __construct(KTITeamRepositoryInterface $kti_team_repository, KTIMemberRepositoryInterface $kti_member_repository, UserHasListEventRepositoryInterface $user_has_list_event_repository, UserRepositoryInterface $user_repository, RoleRepositoryInterface $role_repository)
    {
        $this->kti_team_repository = $kti_team_repository;
        $this->kti_member_repository = $kti_member_repository;
        $this->user_has_list_event_repository = $user_has_list_event_repository;
        $this->user_repository = $user_repository;
        $this->role_repository = $role_repository;
    }

    public function execute(RegisterKTITeamRequest $request, UserAccount $account)
    {
        $registered_user = $this->kti_team_repository->findByUserId($account->getUserId());

        if ($registered_user) {
            UserException::throw("User Sudah Mendaftar di Event Karya Tulis Ilmiah", 1004, 404);
        }

        $user = $this->user_repository->find($account->getUserId());
        $role = $this->role_repository->find($user->getRoleId());
        if ($role->getName() != 'Mahasiswa') {
            UserException::throw("Role Anda Tidak Diperbolehkan Untuk Mengikuti Lomba Ini", 6002);
        }

        $followUrl = ImageUpload::create(
            $request->getFollowSosmed(),
            'kti/follow_sosmed',
            $account->getUserId()->toString(),
            'Follow Sosmed'
        )->upload();

        $shareUrl = ImageUpload::create(
            $request->getRepostKTI(),
            'kti/share_poster',
            $account->getUserId()->toString(),
            'Share poster'
        )->upload();

        $twibbonUrl = ImageUpload::create(
            $request->getTwibbon(),
            'kti/twibbon',
            $account->getUserId()->toString(),
            'Twibbon'
        )->upload();

        $abstrakUrl = ImageUpload::create(
            $request->getFileAbstrak(),
            'kti/file_abstrak',
            $account->getUserId()->toString(),
            'File Abstract'
        )->upload();
      
        // Persist disini
        $team = KTITeam::create(
            null,
            $account->getUserId(),
            $request->getTeamName(),
            $request->getAsalInstansi(),
            $followUrl,
            $shareUrl,
            $twibbonUrl,
            $abstrakUrl
        );

        $this->kti_team_repository->persist($team);

        $member = KTIMember::create(
            $team->getId(),
            $request->getNamaKetua(),
            $request->getNoTelpKetua(),
            KTIMemberType::KETUA
        );

        $this->kti_member_repository->persist($member);

        // List Event
        $user_has_list_event = UserHasListEvent::create(
            12,
            $team->getUserId(),
        );
        $this->user_has_list_event_repository->persist($user_has_list_event);
    }
}
