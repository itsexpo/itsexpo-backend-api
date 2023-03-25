<?php

namespace App\Core\Application\Service\CreatePembayaranKTI;

use Illuminate\Http\UploadedFile;

class CreatePembayaranKTIRequest
{
    private int $bank_id;
    private int $harga;
    private string $kti_team_id;
    private string $atas_nama;
    private UploadedFile $bukti_pembayaran;

    /**
     * @param int $bank_id
     * @param int $harga
     * @param string $kti_team_id
     * @param string $atas_nama
     * @param UploadedFile $bukti_pembayaran
     */

    public function __construct(int $bank_id, int $harga, string $kti_team_id, string $atas_nama, UploadedFile $bukti_pembayaran)
    {
        $this->bank_id = $bank_id;
        $this->harga = $harga;
        $this->kti_team_id = $kti_team_id;
        $this->atas_nama = $atas_nama;
        $this->bukti_pembayaran = $bukti_pembayaran;
    }

    /**
     * @return int
     */
    public function getBankId() : int
    {
        return $this->bank_id;
    }

    /**
     * @return int
     */
    public function getHarga() : int
    {
        return $this->harga;
    }

    /**
     * @return string
     */
    public function getKTITeamId() : string
    {
        return $this->kti_team_id;
    }

    /**
     * @return string
     */
    public function getAtasNama() : string
    {
        return $this->atas_nama;
    }

    /**
     * @return UploadedFile
     */
    public function getBuktiPembayaran(): UploadedFile
    {
        return $this->bukti_pembayaran;
    }
}
