<?php

namespace App\Core\Domain\Models\Jurnalistik\Member;

use App\Core\Domain\Models\Jurnalistik\JurnalistikMemberType;
use Exception;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeamId;

class JurnalistikMember
{
    private JurnalistikMemberId $id;
    private ?JurnalistikTeamId $jurnalistik_team_id;
    private UserId $user_id;
    private string $kabupaten_id;
    private string $provinsi_id;
    private string $name;
    private JurnalistikMemberType $member_type;
    private string $asal_instansi;
    private string $id_line;
    private string $id_card_url;
    private string $follow_sosmed_url;
    private string $share_poster_url;

    public function __construct(JurnalistikMemberId $id, ?JurnalistikTeamId $jurnalistik_team_id, UserId $user_id, string $kabupaten_id, string $provinsi_id, string $name, JurnalistikMemberType $member_type, string $asal_instansi, string $id_line, string $id_card_url, string $follow_sosmed_url, string $share_poster_url)
    {
        $this->id = $id;
        $this->jurnalistik_team_id = $jurnalistik_team_id;
        $this->user_id = $user_id;
        $this->kabupaten_id = $kabupaten_id;
        $this->provinsi_id = $provinsi_id;
        $this->name = $name;
        $this->member_type = $member_type;
        $this->asal_instansi = $asal_instansi;
        $this->id_line = $id_line;
        $this->id_card_url = $id_card_url;
        $this->follow_sosmed_url = $follow_sosmed_url;
        $this->share_poster_url = $share_poster_url;
    }

    /**
     * @throws Exception
     */
    public static function create(?JurnalistikTeamId $jurnalistik_team_id, UserId $user_id, string $kabupaten_id, string $provinsi_id, string $name, JurnalistikMemberType $member_type, string $asal_instansi, string $id_line, string $id_card_url, string $follow_sosmed_url, string $share_poster_url): self
    {
        return new self(
            JurnalistikMemberId::generate(),
            $jurnalistik_team_id,
            $user_id,
            $kabupaten_id,
            $provinsi_id,
            $name,
            $member_type,
            $asal_instansi,
            $id_line,
            $id_card_url,
            $follow_sosmed_url,
            $share_poster_url,
        );
    }

    /**
     * @return JurnalistikMemberId
     */
    public function getId(): JurnalistikMemberId
    {
        return $this->id;
    }

    /**
     * @return ?JurnalistikTeamId
     */
    public function getJurnalistikTeamId(): ?JurnalistikTeamId
    {
        return $this->jurnalistik_team_id;
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
    public function getKabupatenId(): string
    {
        return $this->kabupaten_id;
    }

    /**
     * @return string
     */
    public function getProvinsiId(): string
    {
        return $this->provinsi_id;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return JurnalistikMemberType
     */
    public function getMemberType(): JurnalistikMemberType
    {
        return $this->member_type;
    }

    /**
     * @return string
     */
    public function getIdLine(): string
    {
        return $this->id_line;
    }

    /**
     * @return string
     */
    public function getIdCardUrl(): string
    {
        return $this->id_card_url;
    }

    /**
     * @return string
     */
    public function getFollowSosmedUrl(): string
    {
        return $this->follow_sosmed_url;
    }

    /**
     * @return string
     */
    public function getSharePosterUrl(): string
    {
        return $this->share_poster_url;
    }
}
