<?php

namespace App\Core\Application\Service\RegisterRobotInAction\Ketua;

use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Application\ImageUpload\ImageUpload;
use App\Core\Domain\Repository\RoleRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Models\RobotInAction\Team\RobotInActionTeam;
use App\Core\Domain\Models\RobotInAction\RobotInActionMemberType;
use App\Core\Domain\Models\RobotInAction\Member\RobotInActionMember;
use App\Core\Domain\Repository\RobotInActionTeamRepositoryInterface;
use App\Core\Domain\Repository\RobotInActionMemberRepositoryInterface;
use App\Core\Domain\Models\RobotInAction\Team\RobotInActionCompetitionStatus;
use App\Core\Domain\Models\UserHasListEvent\UserHasListEvent;
use App\Core\Domain\Repository\UserHasListEventRepositoryInterface;

class RegisterRobotInActionKetuaService
{
    private RobotInActionTeamRepositoryInterface $robot_in_action_team_repository;
    private RobotInActionMemberRepositoryInterface $robot_in_action_member_repository;
    private UserHasListEventRepositoryInterface $user_has_list_event_repository;
    private UserRepositoryInterface $user_repository;
    private RoleRepositoryInterface $role_repository;

    /**
     * @param RobotInActionTeamRepositoryInterface robot_in_action__team_repository
     * @param RobotInActionMemberRepositoryInterface $robot_in_action_member_repository
     * @param UserHasListEventRepositoryInterface $user_has_list_event_repository
     * @param UserRepositoryInterface $user_repository
     * @param RoleRepositoryInterface $role_repository
     */
    public function __construct(RobotInActionTeamRepositoryInterface $robot_in_action_team_repository, RobotInActionMemberRepositoryInterface $robot_in_action_member_repository, UserHasListEventRepositoryInterface $user_has_list_event_repository, UserRepositoryInterface $user_repository, RoleRepositoryInterface $role_repository)
    {
        $this->robot_in_action_team_repository = $robot_in_action_team_repository;
        $this->robot_in_action_member_repository = $robot_in_action_member_repository;
        $this->user_has_list_event_repository = $user_has_list_event_repository;
        $this->user_repository = $user_repository;
        $this->role_repository = $role_repository;
    }

    public function execute(RegisterRobotInActionKetuaRequest $request, UserAccount $account)
    {
        // Cek User Terdaftar
        $registeredUser = $this->robot_in_action_member_repository->findByUserId($account->getUserId());
        $user = $this->user_repository->find($account->getUserId());
        if ($registeredUser) {
            UserException::throw("User Sudah Mendaftar di Event Robot In Action", 1902, 404);
        }

        $user = $this->user_repository->find($account->getUserId());
        $role = $this->role_repository->find($user->getRoleId());

        $competition_status = null;
        if ($role->getName() == 'SMA/Sederajat') {
            $competition_status = RobotInActionCompetitionStatus::from('BENTENGAN');
        } elseif ($role->getName() == 'SMP/Sederajat') {
            $competition_status = RobotInActionCompetitionStatus::from('LINE_TRACER');
        } else {
            UserException::throw("Role Anda Tidak Diperbolehkan Mengikuti Lomba Ini", 6095);
        }


        // PEMBATASAN QUOTA
        $LINE_TRACER = 100;
        $BENTENGAN = 100;
        if ($competition_status == RobotInActionCompetitionStatus::LINE_TRACER) {
            $count = $this->robot_in_action_team_repository->countByCompetitionStatus($competition_status);
            if ($count >= $LINE_TRACER) {
                UserException::throw("Kompetisi LINE TRACER Sudah Penuh", 6096);
            }
        } else {
            $count = $this->robot_in_action_team_repository->countByCompetitionStatus($competition_status);
            if ($count >= $BENTENGAN) {
                UserException::throw("Kompetisi BENTENGAN Sudah Penuh", 6097);
            }
        }

        // Generate Team Code
        $team_code = 'RIA' . str_pad(
            $this->robot_in_action_team_repository->countAllTeams() + 1,
            3,
            "0",
            STR_PAD_LEFT
        );

        $team = RobotInActionTeam::create(
            null,
            $request->getTeamName(),
            $team_code,
            $competition_status,
            $request->getDeskripsiKarya(),
            1,
            false,
        );

        $this->robot_in_action_team_repository->persist($team);

        // Cek File Exception
        $idCardUrl = ImageUpload::create(
            $request->getIdCard(),
            'robotik/id_card',
            $account->getUserId()->toString(),
            "ID Card"
        )
            ->upload();

        $followUrl = ImageUpload::create(
            $request->getFollowSosmedUrl(),
            'robotik/follow_sosmed',
            $account->getUserId()->toString(),
            "Follow Sosmed"
        )
            ->upload();

        $shareUrl = ImageUpload::create(
            $request->getSharePosterUrl(),
            'robotik/share_poster',
            $account->getUserId()->toString(),
            "Share Poster"
        )
            ->upload();

        // Ceate Member
        $member = RobotInActionMember::create(
            $team->getId(),
            $account->getUserId(),
            $request->getName(),
            $request->getNoTelp(),
            RobotInActionMemberType::KETUA,
            $request->getAsalSekolah(),
            $idCardUrl,
            $followUrl,
            $shareUrl
        );
        $this->robot_in_action_member_repository->persist($member);
        $user_has_list_event = UserHasListEvent::create(
            13,
            $member->getUserId(),
        );
        $this->user_has_list_event_repository->persist($user_has_list_event);
    }
}
