<?php

namespace App\Core\Application\Service\RegisterRobotInAction\Member;

use Illuminate\Http\UploadedFile;

class RegisterRobotInActionMemberRequest
{
    private string $name;
    private string $no_telp;
    private string $member_type;
    private string $asal_sekolah;
    private UploadedFile $id_card;
    private UploadedFile $follow_sosmed;
    private UploadedFile $share_poster;

    /**
     * @param string $name
     * @param string $no_telp
     * @param string $member_type
     * @param string $asal_sekolah
     * @param UploadedFile $id_card
     * @param UploadedFile $follow_sosmed
     * @param UploadedFile $share_poster
     */
    public function __construct(string $member_type, string $name, string $no_telp, string $asal_sekolah, UploadedFile $id_card, UploadedFile $follow_sosmed, UploadedFile $share_poster)
    {
        $this->member_type = $member_type;
        $this->name = $name;
        $this->no_telp = $no_telp;
        $this->asal_sekolah = $asal_sekolah;
        $this->id_card = $id_card;
        $this->follow_sosmed = $follow_sosmed;
        $this->share_poster = $share_poster;
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
        return $this->follow_sosmed;
    }

    /**
     * @return UploadedFile
     */
    public function getSharePosterUrl(): UploadedFile
    {
        return $this->share_poster;
    }
}
