<?php

namespace App\Core\Application\Service\RegisterRobotInAction\Member;

use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Application\ImageUpload\ImageUpload;
use App\Core\Domain\Models\RobotInAction\RobotInActionMemberType;
use App\Core\Domain\Models\UserHasListEvent\UserHasListEvent;
use App\Core\Domain\Models\RobotInAction\Member\RobotInActionMember;
use App\Core\Domain\Repository\UserHasListEventRepositoryInterface;
use App\Core\Domain\Repository\RobotInActionMemberRepositoryInterface;

class RegisterRobotInActionMemberService
{
    private RobotInActionMemberRepositoryInterface $robot_in_action_member_repository;
    private UserHasListEventRepositoryInterface $user_has_list_event_repository;

    /**
     * @param RobotInActionMemberRepositoryInterface $robot_int_action_member_repository
     * @param UserHasListEventRepositoryInterface $user_has_list_event_repository
     */
    public function __construct(RobotInActionMemberRepositoryInterface $robot_in_action_member_repository, UserHasListEventRepositoryInterface $user_has_list_event_repository)
    {
        $this->robot_in_action_member_repository = $robot_in_action_member_repository;
        $this->user_has_list_event_repository = $user_has_list_event_repository;
    }

    public function execute(RegisterRobotInActionMemberRequest $request, UserAccount $account)
    {
        // Cek User Terdaftar
        $registeredUser = $this->robot_in_action_member_repository->findByUserId($account->getUserId());

        if ($registeredUser) {
            UserException::throw("User Sudah Mendaftar di Event Robot In Action", 1902, 404);
        }

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


        $member = RobotInActionMember::create(
            null,
            $account->getUserId(),
            $request->getName(),
            $request->getNoTelp(),
            RobotInActionMemberType::MEMBER->value,
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
