<?php

namespace App\Infrastrucutre\Repository;

use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeam;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeamId;
use App\Core\Domain\Repository\JurnalistikTeamRepositoryInterface;
use App\Core\Domain\Models\Pembayaran\PembayaranId;

class SqlJurnalistikTeamRepository implements JurnalistikTeamRepositoryInterface
{
    public function find(JurnalistikTeamId $jurnalistik_team_id): ?JurnalistikTeam
    {
        $row = DB::table('jurnalistik_team')->where('id', $jurnalistik_team_id->toString())->first();

        return $this->constructFromRows([$row])[0];
    }

    public function incrementJumlahAnggota(JurnalistikTeamId $jurnalistik_team_id): void
    {
        $jurnalistik_team = DB::table('jurnalistik_team')->where('id', $jurnalistik_team_id);
        $jurnalistik_team->update([
            'jumlah_anggota', $jurnalistik_team->first()['jumlah_anggota'] + 1,
        ]);
    }

    public function decrementJumlahAnggota(JurnalistikTeamId $jurnalistik_team_id): void
    {
        $jurnalistik_team = DB::table('jurnalistik_team')->where('id', $jurnalistik_team_id);
        $jurnalistik_team->update([
            'jumlah_anggota', $jurnalistik_team->first()['jumlah_anggota'] - 1,
        ]);
    }

    /**
     * @throws Exception
     */
    private function constructFromRows(array $rows): array
    {
        $jurnalistik_team = [];
        foreach ($rows as $row) {
            $jurnalistik_team[] = new JurnalistikTeam(
                new JurnalistikTeamId($row->id),
                new PembayaranId($row->pembayaran_id),
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
