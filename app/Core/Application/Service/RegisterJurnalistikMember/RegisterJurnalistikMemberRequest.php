<?php

namespace App\Core\Application\Service\RegisterJurnalistikMember;

use App\Core\Domain\Models\Jurnalistik\JurnalistikMemberType;
use Illuminate\Http\UploadedFile;

class RegisterJurnalistikMemberRequest
{
    private string $kabupaten_id;
    private string $provinsi_id;
    private string $name;
    // private JurnalistikMemberType $member_type;
    private string $member_type;
    private string $asal_instansi;
    private string $id_line;
    private UploadedFile $id_card;
    private UploadedFile $follow_sosmed_url;
    private UploadedFile $share_poster_url;

    /**
     * @param string $provinsi_id
     * @param string $kabupaten_id
     * @param string $name
     * @param string $member_type
     * @param string $asal_instansi
     * @param string $id_line
     * @param UploadedFile $id_card
     * @param UploadedFile $follow_sosmed_url
     * @param UploadedFile $share_poster_url
     */
    public function __construct(string $provinsi_id, string $kabupaten_id, string $name, string $member_type, string $asal_instansi, string $id_line, UploadedFile $id_card, UploadedFile $follow_sosmed_url, UploadedFile $share_poster_url)
    {
        $this->provinsi_id = $provinsi_id;
        $this->kabupaten_id = $kabupaten_id;
        $this->name = $name;
        $this->member_type = $member_type;
        $this->asal_instansi = $asal_instansi;
        $this->id_line = $id_line;
        $this->id_card = $id_card;
        $this->follow_sosmed_url = $follow_sosmed_url;
        $this->share_poster_url = $share_poster_url;
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
    public function getName(): string
    {
        return $this->name;
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
    public function getAsalInstansi(): string
    {
        return $this->asal_instansi;
    }

    /**
     * @return string
     */
    public function getIdLine(): string
    {
        return $this->id_line;
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
