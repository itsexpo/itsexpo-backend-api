<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikJenisKegiatan;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikLombaCategory;
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

    public function persist(JurnalistikTeam $team): void
    {
        DB::table('jurnalistik_team')->upsert([
             'id' => $team->getId()->toString(),
             'pembayaran_id' => $team->getPembayaranId(),
             'team_name' => $team->getTeamName(),
             'team_code' => $team->getTeamCode(),
             'team_status' => $team->getTeamStatus(),
             'jumlah_anggota' => $team->getJumlahAnggota(),
             'lomba_category' => $team->getLombaCategory()->value,
             'jenis_kegiatan' => $team->getJenisKegiatan()->value,
         ], 'id');
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
                JurnalistikLombaCategory::from($row->lomba_category),
                JurnalistikJenisKegiatan::from($row->jenis_kegiatan),
            );
        }
        return $jurnalistik_team;
    }

    public function countAllTeams(): int
    {
        $newest = DB::table('jurnalistik_team')->max('created_at');
        if ($newest === null) {
            return 0;
        }
        
        $data = DB::table('jurnalistik_team')->where('created_at', '=', $newest)->first();
        $team_code = (int)(explode('-', $data->team_code))[2];
        
        return $team_code;
    }

    public function countTeamWithJenis(JurnalistikJenisKegiatan $jenis_kegiatan): int
    {
        $count = DB::table('jurnalistik_team')
            ->where('jenis_kegiatan', '=', $jenis_kegiatan->value)
            ->count();
        return $count;
    }

    public function countTeamWithJenisAndCategory(JurnalistikJenisKegiatan $jenis_kegiatan, JurnalistikLombaCategory $lomba_category): int
    {
        $count = DB::table('jurnalistik_team')
            ->where('jenis_kegiatan', '=', $jenis_kegiatan->value)
            ->where('lomba_category', '=', $lomba_category->value)
            ->count();
        return $count;
    }
}
