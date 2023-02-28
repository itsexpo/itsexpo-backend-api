<?php

namespace App\Infrastrucutre\Repository;

use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeam;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeamId;
use App\Core\Domain\Repository\JurnalistikTeamRepositoryInterface;

class SqlJurnalistikTeamRepository implements JurnalistikTeamRepositoryInterface
{
    public function find(JurnalistikTeamId $jurnalistik_team_id): ?JurnalistikTeam
    {
        $row = DB::table('jurnalistik_team')->where('id', $jurnalistik_team_id)->first();

        return $this->constructFromRows([$row])[0];
    }

    /**
     * @throws Exception
     */
    private function constructFromRows(array $rows): array
    {
        $jurnalistik_team = [];
        foreach ($rows as $row) {
            $jurnalistik_team[] = new JurnalistikTeam(
                $row->id,
                $row->pembayaran_id,
                $row->team_name,
                $row->team_code,
                $row->team_status,
                $row->jumlah_anggota,
                $row->lomba_category,
                $row->jenis_kegiatan,
            );
        }
        return $jurnalistik_team;
    }
}