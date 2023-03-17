<?php

namespace App\Core\Domain\Models\Jurnalistik\Team;

use Exception;
use App\Core\Domain\Models\Pembayaran\PembayaranId;

class JurnalistikTeam
{
    private JurnalistikTeamId $id;
    private ?PembayaranId $pembayaran_id;
    private string $team_name;
    private string $team_code;
    private bool $team_status;
    private int $jumlah_anggota;
    private JurnalistikLombaCategory $lomba_category;
    private JurnalistikJenisKegiatan $jenis_kegiatan;
    private string $created_at;

    public function __construct(JurnalistikTeamId $id, ?PembayaranId $pembayaran_id, string $team_name, string $team_code, bool $team_status, int $jumlah_anggota, JurnalistikLombaCategory $lomba_category, JurnalistikJenisKegiatan $jenis_kegiatan, string $created_at)
    {
        $this->id = $id;
        $this->pembayaran_id = $pembayaran_id;
        $this->team_name = $team_name;
        $this->team_code = $team_code;
        $this->team_status = $team_status;
        $this->jumlah_anggota = $jumlah_anggota;
        $this->lomba_category = $lomba_category;
        $this->jenis_kegiatan = $jenis_kegiatan;
        $this->created_at = $created_at;
    }

    /**
     * @throws Exception
     */
    public static function create(?PembayaranId $pembayaran_id, string $team_name, string $team_code, bool $team_status, int $jumlah_anggota, JurnalistikLombaCategory $lomba_category, JurnalistikJenisKegiatan $jenis_kegiatan): self
    {
        return new self(
            JurnalistikTeamId::generate(),
            $pembayaran_id,
            $team_name,
            $team_code,
            $team_status,
            $jumlah_anggota,
            $lomba_category,
            $jenis_kegiatan,
            "null"
        );
    }

    /**
     * @return JurnalistikTeamId
     */
    public function getId(): JurnalistikTeamId
    {
        return $this->id;
    }

    /**
     * @return ?PembayaranId
     */
    public function getPembayaranId(): ?PembayaranId
    {
        return $this->pembayaran_id;
    }

    /**
     * @return string
     */
    public function getTeamName(): string
    {
        return $this->team_name;
    }

    /**
     * @return string
     */
    public function getTeamCode(): string
    {
        return $this->team_code;
    }

    /**
     * @return bool
     */
    public function getTeamStatus(): bool
    {
        return $this->team_status;
    }

    /**
     * @return void
     */
    public function setTeamStatus(bool $team_status): void
    {
        $this->team_status = $team_status;
    }

    /**
     * @return int
     */
    public function getJumlahAnggota(): int
    {
        return $this->jumlah_anggota;
    }

    /**
     * @return JurnalistikLombaCategory
     */
    public function getLombaCategory(): JurnalistikLombaCategory
    {
        return $this->lomba_category;
    }

    /**
     * @return JurnalistikJenisKegiatan
     */
    public function getJenisKegiatan(): JurnalistikJenisKegiatan
    {
        return $this->jenis_kegiatan;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }
}
