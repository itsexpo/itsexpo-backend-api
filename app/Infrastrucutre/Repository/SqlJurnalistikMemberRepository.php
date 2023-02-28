<?php

namespace App\Infrastrucutre\Repository;

use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\Jurnalistik\Member\JurnalistikMember;
use App\Core\Domain\Models\Jurnalistik\Member\JurnalistikMemberId;
use App\Core\Domain\Repository\JurnalistikMemberRepositoryInterface;

class SqlJurnalistikMemberRepository implements JurnalistikMemberRepositoryInterface
{
    public function find(JurnalistikMemberId $jurnalistik_member_id): ?JurnalistikMember
    {
        $row = DB::table('jurnalistik_member')->where('id', $jurnalistik_member_id)->first();

        return $this->constructFromRows([$row])[0];
    }

    /**
     * @throws Exception
     */
    private function constructFromRows(array $rows): array
    {
        $jurnalistik_member = [];
        foreach ($rows as $row) {
            $jurnalistik_member[] = new JurnalistikMember(
                $row->id,
                $row->jurnalistik_team_id,
                $row->user_id,
                $row->member_type,
                $row->kabupaten_id,
                $row->povinsin_id,
                $row->name,
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
