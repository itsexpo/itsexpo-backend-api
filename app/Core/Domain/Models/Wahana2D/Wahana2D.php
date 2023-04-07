<?php

namespace App\Core\Domain\Models\Wahana2D;

use App\Core\Domain\Models\NRP;
use App\Core\Domain\Models\Pembayaran\PembayaranId;

class Wahana2D
{
    private Wahana2DId $id;
    private ?PembayaranId $pembayaran_id;
    private string $departemen_id;
    private string $name;
    private NRP $nrp;
    private string $kontak;
    private bool $status;
    private string $ktm;
    private string $created_at;

    public function __construct(Wahana2DId $id, ?PembayaranId $pembayaran_id, string $departemen_id, string $name, NRP $nrp, string $kontak, bool $status, string $ktm, string $created_at)
    {
        $this->id = $id;
        $this->pembayaran_id = $pembayaran_id;
        $this->departemen_id = $departemen_id;
        $this->name = $name;
        $this->nrp = $nrp;
        $this->kontak = $kontak;
        $this->status = $status;
        $this->ktm = $ktm;
        $this->created_at = $created_at;
    }

    /**
     * @throws Exception
     */
    public static function create(?PembayaranId $pembayaran_id, string $departemen_id, string $name, NRP $nrp, string $kontak, bool $status, string $ktm): self
    {
        return new self(
            Wahana2DId::generate(),
            $pembayaran_id,
            $departemen_id,
            $name,
            $nrp,
            $kontak,
            $status,
            $ktm,
            "null"
        );
    }

    /**
     * @return Wahana2DId
     */
    public function getId(): Wahana2DId
    {
        return $this->id;
    }

    /**
     * @return ?PembayaranId
     */
    public function getPembayaranId(): ?PembayaranId
    {
        return $this->pembayaran_id;
    }

    /**
     * @return string
     */
    public function getDepartemenId(): string
    {
        return $this->departemen_id;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getNrp(): NRP
    {
        return $this->nrp;
    }

    public function getKontak(): string
    {
        return $this->kontak;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function getKTM(): string
    {
        return $this->ktm;
    }
}
