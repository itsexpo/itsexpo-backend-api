<?php

namespace App\Core\Application\Service\CreatePembayaranJurnalistik;

use Illuminate\Http\UploadedFile;

class CreatePembayaranJurnalistikRequest
{
    private int $bank_id;
    private int $harga;
    private string $jurnalistik_team_id;
    private UploadedFile $bukti_pembayaran;

    /**
     * @param int $bank_id
     * @param int $harga
     * @param string $jurnalistik_team_id
     * @param UploadedFile $bukti_pembayaran
     */

    public function __construct(int $bank_id, int $harga, string $jurnalistik_team_id, UploadedFile $bukti_pembayaran)
    {
        $this->bank_id = $bank_id;
        $this->harga = $harga;
        $this->jurnalistik_team_id = $jurnalistik_team_id;
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
    public function getJurnalistikTeamId() : string
    {
        return $this->jurnalistik_team_id;
    }

    /**
     * @return UploadedFile
     */
    public function getBuktiPembayaran(): UploadedFile
    {
        return $this->bukti_pembayaran;
    }
}
