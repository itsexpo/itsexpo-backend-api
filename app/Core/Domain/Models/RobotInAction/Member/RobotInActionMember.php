<?php

namespace App\Core\Domain\Models\RobotInAction\Member;

use Exception;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\RobotInAction\Team\RobotInActionTeamId;

class RobotInActionMember
{
    private RobotInActionMemberId $id;
    private ?RobotInActionTeamId $robot_in_action_team_id;
    private UserId $user_id;
    private string $name;
    private string $no_telp;
    private string $member_type;
    private string $asal_sekolah;
    private string $id_card_url;
    private string $follow_sosmed_url;
    private string $share_poster_url;

    public function __construct(RobotInActionMemberId $id, ?RobotInActionTeamId $robot_in_action_team_id, UserId $user_id, string $name, string $no_telp, string $member_type, string $asal_sekolah, string $id_card_url, string $follow_sosmed_url, string $share_poster_url)
    {
        $this->id = $id;
        $this->robot_in_action_team_id = $robot_in_action_team_id;
        $this->user_id = $user_id;
        $this->name = $name;
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
    public static function create(?RobotInActionTeamId $robot_in_action_team_id, UserId $user_id, string $name, string $no_telp, string $member_type, string $asal_sekolah, string $id_card_url, string $follow_sosmed_url, string $share_poster_url): self
    {
        return new self(
            RobotInActionMemberId::generate(),
            $robot_in_action_team_id,
            $user_id,
            $name,
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
        return $this->robot_in_action_team_id;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getNoTelp(): string
    {
        return $this->no_telp;
    }

    /**
     * @return string
     */
    public function getMemberType(): string
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
