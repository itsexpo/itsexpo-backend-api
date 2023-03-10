<?php

namespace App\Core\Application\Service\GetJurnalistikAdminDetail;

use App\Core\Domain\Models\Jurnalistik\JurnalistikMemberType;

class GetJurnalistikAdminDetailTeamMemberResponse
{
    private string $kabupaten;
    private string $provinsi;
    private string $nama;
    private JurnalistikMemberType $ketua;
    private string $id_line;
    private string $id_card_url;
    private string $follow_sosmed_url;
    private string $share_poster_url;

    public function __construct(
        string $nama,
        JurnalistikMemberType $ketua,
        string $provinsi,
        string $id_line,
        string $kabupaten,
        string $id_card_url,
        string $follow_sosmed_url,
        string $share_poster_url
    ) {
        $this->nama = $nama;
        $this->ketua = $ketua;
        $this->provinsi = $provinsi;
        $this->id_line = $id_line;
        $this->kabupaten = $kabupaten;
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
