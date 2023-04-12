<?php

namespace App\Core\Application\Service\RegisterWahana3D\Member;

use Illuminate\Http\UploadedFile;

class RegisterWahana3DMemberRequest
{
    private string $departemen_id;
    private string $name;
    private string $nrp;
    private string $kontak;
    private UploadedFile $ktm;

    /**
     * @param string $departemen_id
     * @param string $nama
     * @param string $nrp
     * @param string $kontak
     * @param UploadedFile $ktm
     */
    public function __construct(string $departemen_id, string $name, string $nrp, string $kontak, UploadedFile $ktm)
    {
        $this->departemen_id = $departemen_id;
        $this->name = $name;
        $this->nrp = $nrp;
        $this->kontak = $kontak;
        $this->ktm = $ktm;
    }

    /**
     * @return string
     */
    public function getDepartemenId(): string
    {
        return $this->departemen_id;
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
    public function getNrp(): string
    {
        return $this->nrp;
    }

    /**
     * @return string
     */
    public function getKontak(): string
    {
        return $this->kontak;
    }

    /**
     * @return UplaodedFile
     */
    public function getKtm(): UploadedFile
    {
        return $this->ktm;
    }
}
