<?php

namespace App\Core\Application\Service\GetJurnalistikAdminDetail;

use App\Core\Domain\Models\Jurnalistik\Member\JurnalistikMember;
use JsonSerializable;

class GetJurnalistikAdminDetailTeamMemberResponse
{
    private string $kabupaten;
    private string $provinsi;
    private string $name;
    private bool $ketua;
    private string $id_line;
    private string $id_card_url;
    private string $follow_sosmed_url;
    private string $share_poster_url;

    public function __construct(
        string $kabupaten,
        string $provinsi,
        string $name,
        bool $ketua,
        string $id_line,
        string $id_card_url,
        string $follow_sosmed_url,
        string $share_poster_url
    ) {
        $this->kabupaten = $kabupaten;
        $this->provinsi = $provinsi;
        $this->name = $name;
        $this->ketua = $ketua;
        $this->id_line = $id_line;
        $this->id_card_url = $id_card_url;
        $this->follow_sosmed_url = $follow_sosmed_url;
        $this->share_poster_url = $share_poster_url;
    }

    /**
     * Get the value of kabupaten
     */
    public function getKabupaten()
    {
        return $this->kabupaten;
    }

    /**
     * Get the value of provinsi
     */
    public function getProvinsi()
    {
        return $this->provinsi;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of ketua
     */
    public function getKetua()
    {
        return $this->ketua;
    }

    /**
     * Get the value of id_line
     */
    public function getIdLine()
    {
        return $this->id_line;
    }

    /**
     * Get the value of id_card_url
     */
    public function getIdCardUrl()
    {
        return $this->id_card_url;
    }

    /**
     * Get the value of share_poster_url
     */
    public function getSharePosterUrl()
    {
        return $this->share_poster_url;
    }

    /**
     * Get the value of follow_sosmed_url
     */
    public function getFollowSosmedUrl()
    {
        return $this->follow_sosmed_url;
    }
}

class GetJurnalistikAdminDetailResponse implements JsonSerializable
{
    private string $team_name;
    private string $team_code;
    private string $payment_status;
    private string $payment_image;
    private array  $team_member;

    public function __construct(
        string $team_name,
        string $team_code,
        string $payment_status,
        string $payment_image,
        GetJurnalistikAdminDetailTeamMemberResponse ...$team_members,
    ) {
        $this->team_name = $team_name;
        $this->team_code = $team_code;
        $this->payment_status = $payment_status;
        $this->payment_image = $payment_image;
        foreach ($team_members as $team_member) {
            $this->team_member[] = $team_member;
        }
    }

    public function jsonSerialize(): array
    {
        return [
            'team_name' => $this->team_name,
            'team_code' => $this->team_code,
            'payment_status' => $this->payment_status,
            'payment_image' => $this->payment_image,
            'team_member' => $this->team_member,

        ];
    }
}
