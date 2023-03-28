<?php

namespace App\Core\Domain\Models\Pembayaran;

use Exception;
use Carbon\Carbon;

class Pembayaran
{
    private PembayaranId $id;
    private ?int $list_bank_id;
    private int $list_event_id;
    private int $status_pembayaran_id;
    private ?string $atas_nama;
    private ?string $bukti_pembayaran_url;
    private ?int $harga;
    private Carbon $deadline;

    public function __construct(PembayaranId $id, ?int $list_bank_id, int $list_event_id, int $status_pembayaran_id, ?string $atas_nama, ?string $bukti_pembayaran_url, ?int $harga, Carbon $deadline)
    {
        $this->id = $id;
        $this->list_bank_id = $list_bank_id;
        $this->list_event_id = $list_event_id;
        $this->status_pembayaran_id = $status_pembayaran_id;
        $this->atas_nama = $atas_nama;
        $this->bukti_pembayaran_url = $bukti_pembayaran_url;
        $this->harga = $harga;
        $this->deadline = $deadline;
    }

    /**
     * @throws Exception
     */
    public static function create(?int $list_bank_id, int $list_event_id, int $status_pembayaran_id, ?string $atas_nama, ?string $bukti_pembayaran_url, ?int $harga, Carbon $deadline): self
    {
        return new self(
            PembayaranId::generate(),
            $list_bank_id,
            $list_event_id,
            $status_pembayaran_id,
            $atas_nama,
            $bukti_pembayaran_url,
            $harga,
            $deadline
        );
    }
    
    /**
     * @throws Exception
     */
    public static function update(PembayaranId $id, ?int $list_bank_id, int $list_event_id, int $status_pembayaran_id, ?string $atas_nama, ?string $bukti_pembayaran_url, ?int $harga, Carbon $deadline): self
    {
        return new self(
            $id,
            $list_bank_id,
            $list_event_id,
            $status_pembayaran_id,
            $atas_nama,
            $bukti_pembayaran_url,
            $harga,
            $deadline
        );
    }

    /**
     * @return PembayaranId
     */
    public function getId(): PembayaranId
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getListBankId(): int | NULL
    {
        return $this->list_bank_id;
    }

    /**
     * @return int
     */
    public function getListEventId(): int
    {
        return $this->list_event_id;
    }

    /**
     * @return int
     */
    public function getStatusPembayaranId(): int
    {
        return $this->status_pembayaran_id;
    }

    /**
     * @return int
     */
    public function getHarga(): int | NULL
    {
        return $this->harga;
    }

    /**
     * @return string
     */
    public function getAtasNama(): string | NULL
    {
        return $this->atas_nama;
    }

    /**
     * @return string
     */
    public function getBuktiPembayaranUrl(): string | NULL
    {
        return $this->bukti_pembayaran_url;
    }

    public function getDeadline(): Carbon | NULL
    {
        return $this->deadline;
    }
}
