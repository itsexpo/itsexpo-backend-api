<?php

namespace App\Core\Application\Service\CreatePembayaranRobotInAction;

use Illuminate\Http\UploadedFile;

class CreatePembayaranRobotInActionRequest
{
    private int $bank_id;
    private int $harga;
    private string $robotInAction_team_id;
    private UploadedFile $bukti_pembayaran;

    /**
     * @param int $bank_id
     * @param int $harga
     * @param string $robotInAction_team_id
     * @param UploadedFile $bukti_pembayaran
     */

    public function __construct(int $bank_id, int $harga, string $robotInAction_team_id, UploadedFile $bukti_pembayaran)
    {
        $this->bank_id = $bank_id;
        $this->harga = $harga;
        $this->robotInAction_team_id = $robotInAction_team_id;
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
    public function getRobotInActionTeamId() : string
    {
        return $this->robotInAction_team_id;
    }

    /**
     * @return UploadedFile
     */
    public function getBuktiPembayaran(): UploadedFile
    {
        return $this->bukti_pembayaran;
    }
}
