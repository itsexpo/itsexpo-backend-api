<?php

namespace App\Core\Domain\Models\RobotInAction\Team;

use Exception;
use App\Core\Domain\Models\Pembayaran\PembayaranId;

class RobotInActionTeam
{
    private RobotInActionTeamId $id;
    private ?PembayaranId $pembayaran_id;
    private string $team_name;
    private string $team_code;
    private RobotInActionCompetitionStatus $competition_status;
    private string  $deskripsi_karya;
    private int $jumlah_anggota;
    private bool $team_status;
    private string $created_at;

    public function __construct(RobotInActionTeamId $id, ?PembayaranId $pembayaran_id, string $team_name, string $team_code, RobotInActionCompetitionStatus $competition_status, string  $deskripsi_karya, int $jumlah_anggota, bool $team_status, string $created_at)
    {
        $this->id = $id;
        $this->pembayaran_id = $pembayaran_id;
        $this->team_name = $team_name;
        $this->team_code = $team_code;
        $this->competition_status = $competition_status;
        $this->deskripsi_karya = $deskripsi_karya;
        $this->jumlah_anggota = $jumlah_anggota;
        $this->team_status = $team_status;
        $this->created_at = $created_at;
    }

    /**
     * @throws Exception
     */
    public static function create(?PembayaranId $pembayaran_id, string $team_name, string $team_code, RobotInActionCompetitionStatus $competition_status, string  $deskripsi_karya, int $jumlah_anggota, bool $team_status): self
    {
        return new self(
            RobotInActionTeamId::generate(),
            $pembayaran_id,
            $team_name,
            $team_code,
            $competition_status,
            $deskripsi_karya,
            $jumlah_anggota,
            $team_status,
            "null"
        );
    }

    /**
     * @return RobotInActionTeamId
     */
    public function getId(): RobotInActionTeamId
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
     * @return int
     */
    public function getJumlahAnggota(): int
    {
        return $this->jumlah_anggota;
    }

    /**
     * @return RobotInActionCompetitionStatus
     */
    public function getCompetitionStatus(): RobotInActionCompetitionStatus
    {
        return $this->competition_status;
    }

    /**
     * @return string
     */
    public function getDeskripsiKarya(): string
    {
        return $this->deskripsi_karya;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }
}
