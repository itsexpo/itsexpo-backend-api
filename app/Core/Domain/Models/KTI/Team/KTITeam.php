<?php

namespace App\Core\Domain\Models\KTI\Team;

use App\Core\Domain\Models\Pembayaran\PembayaranId;
use App\Core\Domain\Models\User\UserId;

class KTITeam
{
    private KTITeamId $id;
    private ?PembayaranId $pembayaran_id;
    private UserId $user_id;
    private string $team_name;
    private string $team_code;
    private string $asal_instansi;
    private string $follow_sosmed;
    private string $bukti_repost;
    private string $twibbon;
    private string $abstrak;
    private string $created_at;

    public function __construct(KTITeamId $id, ?PembayaranId $pembayaran_id, UserId $user_id, string $team_name, string $team_code, string $asal_instansi, string $follow_sosmed, string $bukti_repost, string $twibbon, string $abstrak, string $created_at)
    {
        $this->id = $id;
        $this->pembayaran_id = $pembayaran_id;
        $this->user_id = $user_id;
        $this->team_name = $team_name;
        $this->team_code = $team_code;
        $this->asal_instansi = $asal_instansi;
        $this->follow_sosmed = $follow_sosmed;
        $this->bukti_repost = $bukti_repost;
        $this->twibbon = $twibbon;
        $this->abstrak = $abstrak;
        $this->created_at = $created_at;
    }

    /**
     * @throws Exception
     */
    public static function create(?PembayaranId $pembayaran_id, UserId $user_id, string $team_name, string $team_code, string $asal_instansi, string $follow_sosmed, string $bukti_repost, string $twibbon, string $abstrak): self
    {
        return new self(
            KTITeamId::generate(),
            $pembayaran_id,
            $user_id,
            $team_name,
            $team_code,
            $asal_instansi,
            $follow_sosmed,
            $bukti_repost,
            $twibbon,
            $abstrak,
            "null"
        );
    }

    /**
     * @return KTITeamId
     */
    public function getId(): KTITeamId
    {
        return $this->id;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getTeamCode(): string
    {
        return $this->team_code;
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
    public function getAsalInstansi(): string
    {
        return $this->asal_instansi;
    }

    /**
     * @return string
     */
    public function getFollowSosmed(): string
    {
        return $this->follow_sosmed;
    }

    /**
     * @return string
     */
    public function getBuktiRepost(): string
    {
        return $this->bukti_repost;
    }

    /**
     * @return string
     */
    public function getTwibbon(): string
    {
        return $this->twibbon;
    }

    /**
     * @return string
     */
    public function getAbstrak(): string
    {
        return $this->abstrak;
    }
}
