<?php

namespace App\Core\Application\Service\RegisterWahana2D;

use Illuminate\Http\UploadedFile;

class RegisterWahana2DRequest
{
    private string $name;
    private string $nrp;
    private string $departemen_id;
    private string $kontak;
    private UploadedFile $ktm;

    /**
     * @param string $name
     * @param string $nrp
     * @param string $departemen_id
     * @param string $kontak
     * @param UploadedFile $ktm
     */

    public function __construct(string $name, string $nrp, string $departemen_id, string $kontak, UploadedFile $ktm)
    {
        $this->name = $name;
        $this->nrp = $nrp;
        $this->departemen_id = $departemen_id;
        $this->kontak = $kontak;
        $this->ktm = $ktm;
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
    public function getDepartemenId(): string
    {
        return $this->departemen_id;
    }

    /**
     * @return string
     */
    public function getKontak(): string
    {
        return $this->kontak;
    }

    /**
     * @return UploadedFile
     */
    public function getKTM(): UploadedFile
    {
        return $this->ktm;
    }
}
