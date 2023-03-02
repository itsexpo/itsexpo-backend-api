<?php

namespace App\Core\Application\Service\RegisterJurnalistikTeam;

use App\Core\Domain\Models\Jurnalistik\JurnalistikMemberType;
use Illuminate\Support\Str;
use App\Core\Domain\Models\UserAccount;
use Illuminate\Support\Facades\Storage;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeam;
use App\Core\Domain\Models\Jurnalistik\Member\JurnalistikMember;
use App\Core\Domain\Repository\JurnalistikTeamRepositoryInterface;
use App\Core\Domain\Repository\JurnalistikMemberRepositoryInterface;

class RegisterJurnalistikTeamService
{
    private JurnalistikTeamRepositoryInterface $jurnalistik_team_repository;
    private JurnalistikMemberRepositoryInterface $jurnalistik_member_repository;

    /**
     * @param JurnalistikTeamRepositoryInterface $jurnalistik_team_repository
     * @param JurnalistikMemberRepositoryInterface $jurnalistik_member_repository
     */
    public function __construct(JurnalistikTeamRepositoryInterface $jurnalistik_team_repository, JurnalistikMemberRepositoryInterface $jurnalistik_member_repository)
    {
        $this->jurnalistik_team_repository = $jurnalistik_team_repository;
        $this->jurnalistik_member_repository = $jurnalistik_member_repository;
    }

    public function execute(RegisterJurnalistikTeamRequest $request, UserAccount $account)
    {
        $team = JurnalistikTeam::create(
            null,
            $request->getTeamName(),
            Str::random(8),
            false,
            0,
            $request->getLombaCategory(),
            $request->getJenisKegiatan()
        );
        $this->jurnalistik_team_repository->persist($team);
    
        $idCardUrl = Storage::putFileAs('jurnalistik/id_card', $request->getIdCard(), "id_card_".$account->getUserId()->toString());
        $followUrl = Storage::putFileAs('jurnalistik/follow_sosmed', $request->getFollowSosmedUrl(), "follow_sosmed_".$account->getUserId()->toString());
        $shareUrl = Storage::putFileAS('jurnalistik/share_poster', $request->getSharePosterUrl(), "share_poster_".$account->getUserId()->toString());
        $member = JurnalistikMember::create(
            $team->getId(),
            $account->getUserId(),
            $request->getKabupatenId(),
            $request->getProvinsiId(),
            $request->getName(),
            JurnalistikMemberType::KETUA,
            $request->getAsalInstansi(),
            $request->getIdLine(),
            $idCardUrl,
            $followUrl,
            $shareUrl
        );
        $this->jurnalistik_member_repository->persist($member);
    }
}
