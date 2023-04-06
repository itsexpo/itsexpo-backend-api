<?php

namespace App\Core\Application\Service\GetRobotInActionAdminDetail;

use JsonSerializable;

class GetRobotInActionAdminDetailTeamMemberResponse implements JsonSerializable
{
    private string $nama;
    private bool $ketua;
    private string $no_telp;
    private string $id_card_url;
    private string $follow_sosmed_url;
    private string $share_poster_url;

    public function __construct(
        string $nama,
        bool $ketua,
        string $no_telp,
        string $id_card_url,
        string $follow_sosmed_url,
        string $share_poster_url
    ) {
        $this->nama = $nama;
        $this->ketua = $ketua;
        $this->no_telp = $no_telp;
        $this->id_card_url = $id_card_url;
        $this->follow_sosmed_url = $follow_sosmed_url;
        $this->share_poster_url = $share_poster_url;
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->nama,
            'ketua' => $this->ketua,
            'no_telp' => $this->no_telp,
            'id_card_url' => $this->id_card_url,
            'follow_sosmed_url' => $this->follow_sosmed_url,
            'share_poster_url' => $this->share_poster_url,
        ];
    }

    /**
     * Get the value of nama
     */
    public function getName()
    {
        return $this->nama;
    }

    /**
     * Get the value of ketua
     */
    public function getKetua()
    {
        return $this->ketua;
    }

    /**
     * Get the value of no_telp
     */
    public function getNoTelp()
    {
        return $this->no_telp;
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
