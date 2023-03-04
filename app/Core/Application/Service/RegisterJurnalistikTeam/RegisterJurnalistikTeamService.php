<?php

namespace App\Core\Application\Service\RegisterJurnalistikTeam;

use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use Illuminate\Support\Facades\Storage;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeam;
use App\Core\Domain\Models\Jurnalistik\JurnalistikMemberType;
use App\Core\Domain\Models\Jurnalistik\Member\JurnalistikMember;
use App\Core\Domain\Repository\JurnalistikTeamRepositoryInterface;
use App\Core\Domain\Repository\JurnalistikMemberRepositoryInterface;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikJenisKegiatan;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikLombaCategory;

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
        // Cek User Terdaftar
        $registeredUser = $this->jurnalistik_member_repository->findByUserId($account->getUserId());
        if ($registeredUser) {
            UserException::throw("User Sudah Mendaftar di Event Jurnalistik", 1001, 404);
        }

        // Generate Team Code
        $team_code = 'JR-CITS-' . str_pad($this->jurnalistik_team_repository->countAllTeams() + 1, 3, "0", STR_PAD_LEFT);

        // Create Team
        $team = JurnalistikTeam::create(
            null,
            $request->getTeamName(),
            $team_code,
            false,
            0,
            JurnalistikLombaCategory::from($request->getLombaCategory()),
            JurnalistikJenisKegiatan::from($request->getJenisKegiatan())
        );
        $this->jurnalistik_team_repository->persist($team);
        
        // Cek File Exception
        if ($request->getIdCard()->getSize() > 1048576) {
            UserException::throw("ID Card Harus Dibawah 1Mb", 2000);
        }
        $idCardUrl = Storage::putFileAs('jurnalistik/id_card', $request->getIdCard(), "id_card_".$account->getUserId()->toString());
        if (!$idCardUrl) {
            UserException::throw("Upload ID Card Gagal", 2003);
        }
        if ($request->getFollowSosmedUrl()->getSize() > 1048576) {
            UserException::throw("Follow Sosmed Harus Dibawah 1Mb", 2000);
        }
        $followUrl = Storage::putFileAs('jurnalistik/follow_sosmed', $request->getFollowSosmedUrl(), "follow_sosmed_".$account->getUserId()->toString());
        if (!$followUrl) {
            UserException::throw("Upload Follow Url Card Gagal", 2003);
        }
        if ($request->getSharePosterUrl()->getSize() > 1048576) {
            UserException::throw("Share Sosmed Harus Dibawah 1Mb", 2000);
        }
        $shareUrl = Storage::putFileAS('jurnalistik/share_poster', $request->getSharePosterUrl(), "share_poster_".$account->getUserId()->toString());
        if (!$shareUrl) {
            UserException::throw("Upload Share Sosmed Gagal", 2003);
        }

        // Ceate Member
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
