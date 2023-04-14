<?php

namespace App\Core\Application\Service\WahanaSeniAdminConfirm;

use App\Exceptions\UserException;

class WahanaSeniAdminConfirmRequest
{
    private string $pembayaran_id;
    private int $status_pembayaran_id;
    private string $type; // 2D | 3D
    private array $allowed_type = ['2D', '3D'];

    /**
     * @param string $pembayaran_id
     * @param int $status_pembayaran_id
     * @param string $type 2D | 3D
     */
    public function __construct(string $pembayaran_id, int $status_pembayaran_id, string $type)
    {
        $this->pembayaran_id = $pembayaran_id;
        $this->status_pembayaran_id = $status_pembayaran_id;
        if (!in_array($type, $this->allowed_type)) {
            UserException::throw("Type is not allowed", 500);
        }
        $this->type = $type;
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

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
