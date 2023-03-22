<?php

namespace App\Core\Domain\Models\Pembayaran;

use Exception;

class Pembayaran
{
    private PembayaranId $id;
    private int $list_bank_id;
    private int $list_event_id;
    private int $status_pembayaran_id;
    private string $atas_nama;
    private string $bukti_pembayaran_url;
    private int $harga;

    public function __construct(PembayaranId $id, int $list_bank_id, int $list_event_id, int $status_pembayaran_id, string $atas_nama, string $bukti_pembayaran_url, int $harga)
    {
        $this->id = $id;
        $this->list_bank_id = $list_bank_id;
        $this->list_event_id = $list_event_id;
        $this->status_pembayaran_id = $status_pembayaran_id;
        $this->atas_nama = $atas_nama;
        $this->bukti_pembayaran_url = $bukti_pembayaran_url;
        $this->harga = $harga;
    }

    /**
     * @throws Exception
     */
    public static function create(int $list_bank_id, int $list_event_id, int $status_pembayaran_id, string $atas_nama, string $bukti_pembayaran_url, int $harga): self
    {
        return new self(
            PembayaranId::generate(),
            $list_bank_id,
            $list_event_id,
            $status_pembayaran_id,
            $atas_nama,
            $bukti_pembayaran_url,
            $harga,
        );
    }
    
    /**
     * @throws Exception
     */
    public static function update(PembayaranId $id, int $list_bank_id, int $list_event_id, int $status_pembayaran_id, string $atas_nama, string $bukti_pembayaran_url, int $harga): self
    {
        return new self(
            $id,
            $list_bank_id,
            $list_event_id,
            $status_pembayaran_id,
            $atas_nama,
            $bukti_pembayaran_url,
            $harga,
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
    public function getListBankId(): int
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
    public function getHarga(): int
    {
        return $this->harga;
    }

    /**
     * @return string
     */
    public function getAtasNama(): string
    {
        return $this->atas_nama;
    }

    /**
     * @return string
     */
    public function getBuktiPembayaranUrl(): string
    {
        return $this->bukti_pembayaran_url;
    }
}
