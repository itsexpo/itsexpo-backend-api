<?php

namespace App\Core\Application\Service\JurnalistikAdminConfirm;

class JurnalistikAdminConfirmRequest
{
    private string $pembayaran_id;
    private int $status_pembayaran_id;

    /**
     * @param string $pembayaran_id
     * @param int $status_pembayaran_id
     */
    public function __construct(string $pembayaran_id, int $status_pembayaran_id)
    {
        $this->pembayaran_id = $pembayaran_id;
        $this->status_pembayaran_id = $status_pembayaran_id;
    }

    /**
     * @return string
     */
    public function getPembayaranId(): string
    {
        return $this->pembayaran_id;
    }

    /**
     * @return int
     */
    public function getStatusPembayaranId(): int
    {
        return $this->status_pembayaran_id;
    }
}
