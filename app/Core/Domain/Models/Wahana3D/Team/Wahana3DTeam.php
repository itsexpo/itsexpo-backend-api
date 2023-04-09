<?php

namespace App\Core\Domain\Models\Wahana3D\Team;

use App\Core\Domain\Models\Pembayaran\PembayaranId;
use App\Core\Domain\Models\User\UserId;

class Wahana3DTeam
{
    private Wahana3DTeamId $id;
    private ?PembayaranId $pembayaran_id;
    private UserId $user_id;
    private string $team_name;
    private string $team_code;
    private string $deskripsi_karya;
    private string $created_at;

    /**
     * @param Wahana3DTeamId $id
     * @param ?PembayaranId $pembayaran_id
     * @param UserId $user_id
     * @param string $team_name
     * @param string $team_code
     * @param Wahana3DCompetitionStatus $competition_status
     * @param string $deskripsi_karya
     * @param int $jumlah_anggota
     * @param bool $team_status
     * @param string $created_at
     */
    public function __construct(Wahana3DTeamId $id, ?PembayaranId $pembayaran_id, UserId $user_id, string $team_name, string $team_code, string $deskripsi_karya, string $created_at)
    {
        $this->id = $id;
        $this->pembayaran_id = $pembayaran_id;
        $this->user_id = $user_id;
        $this->team_name = $team_name;
        $this->team_code = $team_code;
        $this->deskripsi_karya = $deskripsi_karya;
        $this->created_at = $created_at;
    }

    /**
     * @throws Exception
     */
    public static function create(PembayaranId $pembayaran_id, UserId $user_id, string $team_name, string $team_code, string $deskripsi_karya): self
    {
        return new self(
            Wahana3DTeamId::generate(),
            $pembayaran_id,
            $user_id,
            $team_name,
            $team_code,
            $deskripsi_karya,
            "null"
        );
    }

    /**
     * @return Wahana3DTeamId
     */
    public function getId(): Wahana3DTeamId
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
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->user_id;
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