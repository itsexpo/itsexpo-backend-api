<?php

namespace App\Core\Application\Service\RegisterWahana3D\Ketua;

use Illuminate\Http\UploadedFile;

class RegisterWahana3DKetuaRequest
{
    private string $team_name;
    private string $name;
    private string $nrp;
    private string $kontak;
    private string $departemen_id;
    private string $deskripsi_karya;
    private int $bank_id;
    private string $atas_nama;
    private UploadedFile $ktm;
    private UploadedFile $bukti_bayar;

    /**
     * @param string $team_name
     * @param string $email_team
     * @param string $name
     * @param string $nrp
     * @param string $kontak
     * @param string $departemen_id
     * @param string $deskripsi_karya
     * @param int $bank_id
     * @param string $atas_nama
     * @param UploadedFile $ktm
     * @param UploadedFile $bukti_bayar
     */
    public function __construct(string $team_name, string $name, string $nrp, string $kontak, string $departemen_id, string $deskripsi_karya, int $bank_id, string $atas_nama, UploadedFile $ktm, UploadedFile $bukti_bayar)
    {
        $this->team_name = $team_name;
        $this->name = $name;
        $this->nrp = $nrp;
        $this->kontak = $kontak;
        $this->departemen_id = $departemen_id;
        $this->deskripsi_karya = $deskripsi_karya;
        $this->bank_id = $bank_id;
        $this->atas_nama = $atas_nama;
        $this->ktm = $ktm;
        $this->bukti_bayar = $bukti_bayar;
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
     * @return string
     */
    public function getDepartemenId(): string
    {
        return $this->departemen_id;
    }

    /**
     * @return string
     */
    public function getDeskripsiKarya(): string
    {
        return $this->deskripsi_karya;
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
    public function getKtm(): UploadedFile
    {
        return $this->ktm;
    }

    public function getBuktiBayar(): UploadedFile
    {
        return $this->bukti_bayar;
    }
}
