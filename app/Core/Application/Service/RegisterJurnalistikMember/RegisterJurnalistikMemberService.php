<?php

namespace App\Core\Application\Service\RegisterJurnalistikMember;

use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Application\ImageUpload\ImageUpload;
use App\Core\Domain\Models\Jurnalistik\JurnalistikMemberType;
use App\Core\Domain\Models\UserHasListEvent\UserHasListEvent;
use App\Core\Domain\Models\Jurnalistik\Member\JurnalistikMember;
use App\Core\Domain\Repository\UserHasListEventRepositoryInterface;
use App\Core\Domain\Repository\JurnalistikMemberRepositoryInterface;

class RegisterJurnalistikMemberService
{
    private JurnalistikMemberRepositoryInterface $jurnalistik_member_repository;
    private UserHasListEventRepositoryInterface $user_has_list_event_repository;

    /**
     * @param JurnalistikMemberRepositoryInterface $jurnalistik_member_repository
     * @param UserHasListEventRepositoryInterface $user_has_list_event_repository
     */
    public function __construct(JurnalistikMemberRepositoryInterface $jurnalistik_member_repository, UserHasListEventRepositoryInterface $user_has_list_event_repository)
    {
        $this->jurnalistik_member_repository = $jurnalistik_member_repository;
        $this->user_has_list_event_repository = $user_has_list_event_repository;
    }

    public function execute(RegisterJurnalistikMemberRequest $request, UserAccount $account)
    {
        // Cek User Terdaftar
        $registeredUser = $this->jurnalistik_member_repository->findByUserId($account->getUserId());

        if ($registeredUser) {
            UserException::throw("User Sudah Mendaftar di Event Jurnalistik", 1001, 404);
        }

        // Cek File Exception
        $idCardUrl = ImageUpload::create(
            $request->getIdCard(),
            'jurnalistik/id_card',
            $account->getUserId()->toString(),
            "ID Card"
        )
                ->upload();

        $followUrl = ImageUpload::create(
            $request->getFollowSosmedUrl(),
            'jurnalistik/follow_sosmed',
            $account->getUserId()->toString(),
            "Follow Sosmed"
        )
                ->upload();

        $shareUrl = ImageUpload::create(
            $request->getSharePosterUrl(),
            'jurnalistik/share_poster',
            $account->getUserId()->toString(),
            "Share Poster"
        )
                ->upload();

        // Create Member
        $member = JurnalistikMember::create(
            null,
            $account->getUserId(),
            $request->getKabupatenId(),
            $request->getProvinsiId(),
            $request->getName(),
            JurnalistikMemberType::MEMBER,
            $request->getAsalInstansi(),
            $request->getIdLine(),
            $idCardUrl,
            $followUrl,
            $shareUrl
        );
        $this->jurnalistik_member_repository->persist($member);
        $user_has_list_event = UserHasListEvent::create(
            11,
            $member->getUserId(),
        );
        $this->user_has_list_event_repository->persist($user_has_list_event);
    }
}
