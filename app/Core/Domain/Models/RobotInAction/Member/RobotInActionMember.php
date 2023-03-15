<?php

namespace App\Core\Domain\Models\RobotInAction\Member;

use App\Core\Domain\Models\RobotInAction\RobotInActionMemberType;
use Exception;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\RobotInAction\Team\RobotInActionTeamId;

class RobotInActionMember
{
    private RobotInActionMemberId $id;
    private ?RobotInActionTeamId $RobotInAction_team_id;
    private UserId $user_id;
    private string $nama;
    private string $no_telp;
    private RobotInActionMemberType $member_type;
    private string $asal_sekolah;
    private string $id_card_url;
    private string $follow_sosmed_url;
    private string $share_poster_url;

    public function __construct(RobotInActionMemberId $id, ?RobotInActionTeamId $RobotInAction_team_id, UserId $user_id, string $nama, string $no_telp, RobotInActionMemberType $member_type, string $asal_sekolah, string $id_card_url, string $follow_sosmed_url, string $share_poster_url)
    {
        $this->id = $id;
        $this->RobotInAction_team_id = $RobotInAction_team_id;
        $this->user_id = $user_id;
        $this->nama = $nama;
        $this->no_telp = $no_telp;
        $this->member_type = $member_type;
        $this->asal_sekolah = $asal_sekolah;
        $this->id_card_url = $id_card_url;
        $this->follow_sosmed_url = $follow_sosmed_url;
        $this->share_poster_url = $share_poster_url;
    }

    /**
     * @throws Exception
     */
    public static function create(?RobotInActionTeamId $RobotInAction_team_id, UserId $user_id, string $nama, string $no_telp, RobotInActionMemberType $member_type, string $asal_sekolah, string $id_card_url, string $follow_sosmed_url, string $share_poster_url): self
    {
        return new self(
            RobotInActionMemberId::generate(),
            $RobotInAction_team_id,
            $user_id,
            $nama,
            $no_telp,
            $member_type,
            $asal_sekolah,
            $id_card_url,
            $follow_sosmed_url,
            $share_poster_url,
        );
    }

    /**
     * @return RobotInActionMemberId
     */
    public function getId(): RobotInActionMemberId
    {
        return $this->id;
    }

    /**
     * @return ?RobotInActionTeamId
     */
    public function getRobotInActionTeamId(): ?RobotInActionTeamId
    {
        return $this->RobotInAction_team_id;
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
    public function getAsalSekolah(): string
    {
        return $this->asal_sekolah;
    }

    /**
     * @return string
     */
    public function getnama(): string
    {
        return $this->nama;
    }

    /**
     * @return string
     */
    public function getNoTelp(): string
    {
        return $this->no_telp;
    }

    /**
     * @return RobotInActionMemberType
     */
    public function getMemberType(): RobotInActionMemberType
    {
        return $this->member_type;
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
