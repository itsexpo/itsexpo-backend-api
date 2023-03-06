<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\Jurnalistik\JurnalistikMemberType;
use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\Jurnalistik\Member\JurnalistikMember;
use App\Core\Domain\Models\Jurnalistik\Member\JurnalistikMemberId;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeamId;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Repository\JurnalistikMemberRepositoryInterface;

class SqlJurnalistikMemberRepository implements JurnalistikMemberRepositoryInterface
{
    public function find(JurnalistikMemberId $jurnalistik_member_id): ?JurnalistikMember
    {
        $row = DB::table('jurnalistik_member')->where('id', $jurnalistik_member_id->toString())->first();
        if (!$row) {
            return null;
        }
        return $this->constructFromRows([$row])[0];
    }


    public function updateTeamId(JurnalistikMemberId $personal_id, JurnalistikTeamId $team_id): void
    {
        DB::table('jurnalistik_member')->where('id', $personal_id->toString())->update([
            'jurnalistik_team_id' => $team_id->toString(),
        ]);
    }

    public function findByUserId(UserId $user_id): ?JurnalistikMember
    {
        $row = DB::table('jurnalistik_member')->where('user_id', $user_id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function findKetua(JurnalistikTeamId $team_id): ?JurnalistikMember
    {
        $row = DB::table('jurnalistik_member')->where('jurnalistik_team_id', $team_id->toString())->where('member_type', 'ketua')->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function findAllMember(JurnalistikTeamId $jurnalistik_team_id): array
    {
        $row = DB::table('jurnalistik_member')->where('jurnalistik_team_id', $jurnalistik_team_id->toString())->get();

        return $this->constructFromRows($row->all());
    }

    /**
     * @throws Exception
     */
    private function constructFromRows(array $rows): array
    {
        $jurnalistik_member = [];
        foreach ($rows as $row) {
            $jurnalistik_member[] = new JurnalistikMember(
                new JurnalistikMemberId($row->id),
                new JurnalistikTeamId($row->jurnalistik_team_id),
                new UserId($row->user_id),
                $row->kabupaten_id,
                $row->provinsi_id,
                $row->name,
                JurnalistikMemberType::from($row->member_type),
                $row->asal_instansi,
                $row->id_line,
                $row->id_card_url,
                $row->follow_sosmed_url,
                $row->share_poster_url,
            );
        }
        return $jurnalistik_member;
    }

    public function persist(JurnalistikMember $member): void
    {
        DB::table('jurnalistik_member')->upsert(
            [
              'id' => $member->getId()->toString(),
              'jurnalistik_team_id' => $member->getJurnalistikTeamId()?$member->getJurnalistikTeamId()->toString(): null,
              'user_id' => $member->getUserId()->toString(),
              'provinsi_id' => $member->getProvinsiId(),
              'kabupaten_id' => $member->getKabupatenId(),
              'name' => $member->getName(),
              'member_type' => $member->getMemberType()->value,
              'asal_instansi' => $member->getAsalInstansi(),
              'id_line' => $member->getIdLine(),
              'id_card_url' => $member->getIdCardUrl(),
              'follow_sosmed_url' => $member->getFollowSosmedUrl(),
              'share_poster_url' => $member->getSharePosterUrl(),
            ],
            'id'
        );
    }
}
