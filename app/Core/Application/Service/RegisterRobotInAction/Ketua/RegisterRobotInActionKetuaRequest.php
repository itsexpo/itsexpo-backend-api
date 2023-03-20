<?php

namespace App\Core\Application\Service\RegisterRobotInAction\Ketua;

use Illuminate\Http\UploadedFile;

class RegisterRobotInActionKetuaRequest
{
    private string $team_name;
    private string $name;
    private string $no_telp;
    private string $member_type;
    private string $asal_sekolah;
    private string $deskripsi_karya;
    private UploadedFile $id_card;
    private UploadedFile $follow_sosmed_url;
    private UploadedFile $share_poster_url;

    /**
     * @param string $team_name
     * @param string $name
     * @param string $no_telp
     * @param string $member_type
     * @param string $asal_sekolah
     * @param string $deskripsi_karya
     * @param UploadedFile $id_card
     * @param UploadedFile $follow_sosmed_url
     * @param UploadedFile $share_poster_url
     */
    public function __construct(string $member_type, string $team_name, string $name, string $no_telp, string $deskripsi_karya, string $asal_sekolah, UploadedFile $id_card, UploadedFile $follow_sosmed_url, UploadedFile $share_poster_url)
    {
        $this->member_type = $member_type;
        $this->team_name = $team_name;
        $this->name = $name;
        $this->no_telp = $no_telp;
        $this->deskripsi_karya = $deskripsi_karya;
        $this->asal_sekolah = $asal_sekolah;
        $this->id_card = $id_card;
        $this->follow_sosmed_url = $follow_sosmed_url;
        $this->share_poster_url = $share_poster_url;
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
    public function getTeamName(): string
    {
        return $this->team_name;
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
    public function getAsalSekolah(): string
    {
        return $this->asal_sekolah;
    }

    /**
     * @return UploadedFile
     */
    public function getIdCard(): UploadedFile
    {
        return $this->id_card;
    }

    /**
     * @return UploadedFile
     */
    public function getFollowSosmedUrl(): UploadedFile
    {
        return $this->follow_sosmed_url;
    }

    /**
     * @return UploadedFile
     */
    public function getSharePosterUrl(): UploadedFile
    {
        return $this->share_poster_url;
    }
}
