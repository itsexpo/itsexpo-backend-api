<?php

namespace App\Core\Application\Service\RegisterJurnalistikMember;

use App\Core\Application\ImageUpload\ImageUpload;
use App\Core\Domain\Models\Jurnalistik\JurnalistikMemberType;
use App\Core\Domain\Models\Jurnalistik\Member\JurnalistikMember;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Repository\JurnalistikMemberRepositoryInterface;
use App\Exceptions\UserException;
use Illuminate\Support\Facades\Storage;

class RegisterJurnalistikMemberService
{
    private JurnalistikMemberRepositoryInterface $jurnalistik_member_repository;

    /**
     * @param JurnalistikMemberRepositoryInterface $jurnalistik_member_repository
     */
    public function __construct(JurnalistikMemberRepositoryInterface $jurnalistik_member_repository)
    {
        $this->jurnalistik_member_repository = $jurnalistik_member_repository;
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
            "ID Card")
                ->upload();

        $followUrl = ImageUpload::create(
            $request->getFollowSosmedUrl(), 
            'jurnalistik/follow_sosmed', 
            $account->getUserId()->toString(), 
            "Follow Sosmed")
                ->upload();

        $shareUrl = ImageUpload::create(
            $request->getSharePosterUrl(), 
            'jurnalistik/share_poster', 
            $account->getUserId()->toString(), 
            "Share Poster")
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
    }
}
