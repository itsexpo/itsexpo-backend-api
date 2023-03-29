<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeam;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeamId;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikJenisKegiatan;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikLombaCategory;
use App\Core\Domain\Models\Pembayaran\PembayaranId;

interface JurnalistikTeamRepositoryInterface
{
    public function find(JurnalistikTeamId $id): ?JurnalistikTeam;

    public function persist(JurnalistikTeam $team): void;

    public function incrementJumlahAnggota(string $team_code): void;

    public function decrementJumlahAnggota(string $team_code): void;

    public function findByTeamCode(string $team_code): ?JurnalistikTeam;

    public function countAllTeams(JurnalistikLombaCategory $role): int;

    public function countTeamWithJenis(JurnalistikJenisKegiatan $jenis_kegiatan): int;

    public function countTeamWithJenisAndCategory(JurnalistikJenisKegiatan $jenis_kegiatan, JurnalistikLombaCategory $lomba_category): int;

    public function constructFromRows(array $rows): array;

    public function getCreatedAt(JurnalistikTeamId $jurnalistik_team_id): ?string;

    public function updatePembayaran(JurnalistikTeamId $jurnalistik_team_id, PembayaranId $pembayaran_id);

    public function findByPembayaranId(PembayaranId $pembayaran_id): JurnalistikTeam;
}
