<?php

namespace App\Core\Application\Service\RegisterJurnalistikMember;

use App\Core\Domain\Models\Jurnalistik\Member\JurnalistikMember;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Repository\JurnalistikMemberRepositoryInterface;
use App\Core\Domain\Repository\JurnalistikTeamRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class RegisterJurnalistikMemberService
{
    private JurnalistikMemberRepositoryInterface $jurnalistik_member_repository;
    private JurnalistikTeamRepositoryInterface $jurnalistik_team_repository;
    private UserRepositoryInterface $user_repository;

    /**
     * @param JurnalistikMemberRepositoryInterface $jurnalistik_member_repository
     * @param JurnalistikTeamRepositoryInterface $jurnalistik_team_repository
     * @param UserRepositoryInterface $user_repository
     */
    public function __construct(JurnalistikMemberRepositoryInterface $jurnalistik_member_repository, JurnalistikTeamRepositoryInterface $jurnalistik_team_repository, UserRepositoryInterface $user_repository)
    {
        $this->jurnalistik_member_repository = $jurnalistik_member_repository;
        $this->jurnalistik_team_repository = $jurnalistik_team_repository;
        $this->user_repository = $user_repository;
    }

    public function execute(RegisterJurnalistikMemberRequest $request, UserAccount $account)
    {
        Storage::putFileAs('jurnalistik/idcard', $request->getIdCard(), "idcard_".$request->getName());
        Storage::putFileAs('jurnalistik/followsosmed', $request->getFollowSosmedUrl(), "follow_".$request->getName()); // Temp
        Storage::putFileAS('jurnalistik/shareposterurl', $request->getSharePosterUrl(), "share_".$request->getName());
    
        $idCardUrl = 'jurnalistik/idcard/idcard_'.$request->getName();
        $followUrl = 'jurnalistik/followsosmed/follow_'.$request->getName();
        $shareUrl = 'jurnalistik/shareposterurl/share_'.$request->getName();

        $member = JurnalistikMember::create(
            null, //Bagaimana cara dapetin register_team_id
            $account->getUserId(),
            $request->getKabupatenId(),
            $request->getProvinsiId(),
            $request->getName(),
            $request->getMemberType(),
            $request->getAsalInstansi(),
            $request->getIdLine(),
            $idCardUrl,
            $followUrl,
            $shareUrl
        );
        $this->jurnalistik_member_repository->persist($member);
    }
}
