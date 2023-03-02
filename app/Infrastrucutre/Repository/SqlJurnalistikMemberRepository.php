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

    public function findByUser(UserId $user_id): ?JurnalistikMember
    {
        $row = DB::table('jurnalistik_member')->where('user_id', $user_id->toString())->first();

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
}
