<?php

namespace App\Core\Application\Service\RegisterJurnalistikMember;

use App\Core\Application\ImageCheck\ImageUpload;
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
            "id_card_")
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
            "Share Sosmed")
                ->upload();
        // if ($request->getIdCard()->getSize() > 1048576) {
        //     UserException::throw("ID Card Harus Dibawah 1Mb", 2000);
        // }
        // $idCardUrl = Storage::putFileAs('jurnalistik/id_card', $request->getIdCard(), "id_card_".$account->getUserId()->toString());
        // if (!$idCardUrl) {
        //     UserException::throw("Upload ID Card Gagal", 2003);
        // }
        // if ($request->getFollowSosmedUrl()->getSize() > 1048576) {
        //     UserException::throw("Follow Sosmed Harus Dibawah 1Mb", 2000);
        // }
        // $followUrl = Storage::putFileAs('jurnalistik/follow_sosmed', $request->getFollowSosmedUrl(), "follow_sosmed_".$account->getUserId()->toString());
        // if (!$followUrl) {
        //     UserException::throw("Upload Follow Url Card Gagal", 2003);
        // }
        // if ($request->getSharePosterUrl()->getSize() > 1048576) {
        //     UserException::throw("Share Sosmed Harus Dibawah 1Mb", 2000);
        // }
        // $shareUrl = Storage::putFileAS('jurnalistik/share_poster', $request->getSharePosterUrl(), "share_poster_".$account->getUserId()->toString());
        // if (!$shareUrl) {
        //     UserException::throw("Upload Share Sosmed Gagal", 2003);
        // }

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