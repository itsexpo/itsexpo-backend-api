<?php

namespace App\Core\Application\Service\RegisterWahana2D;

use Illuminate\Http\UploadedFile;

class RegisterWahana2DRequest
{
    private string $name;
    private string $nrp;
    private string $departemen_id;
    private string $kontak;
    private int $bank_id;
    private string $atas_nama;
    private UploadedFile $ktm;
    private UploadedFile $bukti_bayar;

    /**
     * @param string $name
     * @param string $nrp
     * @param string $departemen_id
     * @param string $kontak
     * @param int $bank_id
     * @param string $atas_nama
     * @param UploadedFile $ktm
     * @param UploadedFile $bukti_bayar
     */

    public function __construct(string $name, string $nrp, string $departemen_id, string $kontak, int $bank_id, string $atas_nama, UploadedFile $ktm, UploadedFile $bukti_bayar)
    {
        $this->name = $name;
        $this->nrp = $nrp;
        $this->departemen_id = $departemen_id;
        $this->kontak = $kontak;
        $this->bank_id = $bank_id;
        $this->atas_nama = $atas_nama;
        $this->ktm = $ktm;
        $this->bukti_bayar = $bukti_bayar;
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

    public function getBankId(): int
    {
        return $this->bank_id;
    }

    public function getAtasNama(): string
    {
        return $this->atas_nama;
    }

    /**
     * @return UploadedFile
     */
    public function getKTM(): UploadedFile
    {
        return $this->ktm;
    }

    public function getBuktiBayar(): UploadedFile
    {
        return $this->bukti_bayar;
    }
}
