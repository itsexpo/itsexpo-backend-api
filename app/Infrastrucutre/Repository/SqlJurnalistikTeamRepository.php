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

    public function findByTeamCode(string $team_code): ?JurnalistikTeam
    {
        $row = DB::table('jurnalistik_team')->where('team_code', $team_code)->first();

        return $this->constructFromRows([$row])[0];
    }

    public function incrementJumlahAnggota(string $team_code): void
    {
        $jurnalistik_team = DB::table('jurnalistik_team')->where('team_code', $team_code);
        if (!$jurnalistik_team->first()) {
            return;
        }
        $jurnalistik_team->update(
            ['jumlah_anggota' => (int)$jurnalistik_team->first()->jumlah_anggota + 1]
        );
    }

    public function decrementJumlahAnggota(string $team_code): void
    {
        $jurnalistik_team = DB::table('jurnalistik_team')->where('team_code', $team_code);
        if (!$jurnalistik_team->first()) {
            return;
        }
        $jurnalistik_team->update(
            ['jumlah_anggota' => (int)$jurnalistik_team->first()->jumlah_anggota - 1]
        );
      }
    public function persist(JurnalistikTeam $team): void
    {
        DB::table('jurnalistik_team')->upsert([
             'id' => $team->getId()->toString(),
             'pembayaran_id' => $team->getPembayaranId(),
             'team_name' => $team->getTeamName(),
             'team_code' => $team->getTeamCode(),
             'team_status' => $team->getTeamStatus(),
             'jumlah_anggota' => $team->getJumlahAnggota(),
             'lomba_category' => $team->getLombaCategory(),
             'jenis_kegiatan' => $team->getJenisKegiatan(),
         ], 'id');
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
