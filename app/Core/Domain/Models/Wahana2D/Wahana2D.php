<?php

namespace App\Core\Domain\Models\Wahana2D;

use App\Core\Domain\Models\NRP;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Pembayaran\PembayaranId;

class Wahana2D
{
    private Wahana2DId $id;
    private UserId $user_id;
    private ?PembayaranId $pembayaran_id;
    private string $departemen_id;
    private string $name;
    private NRP $nrp;
    private string $kontak;
    private bool $status;
    private string $ktm;
    private ?string $upload_karya_url;
    private ?string $deskripsi_url;
    private ?string $form_keaslian_url;
    private string $created_at;

    public function __construct(Wahana2DId $id, UserId $user_id, ?PembayaranId $pembayaran_id, string $departemen_id, string $name, NRP $nrp, string $kontak, bool $status, string $ktm, ?string $upload_karya_url, ?string $deskripsi_url, ?string $form_keaslian_url, string $created_at)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->pembayaran_id = $pembayaran_id;
        $this->departemen_id = $departemen_id;
        $this->name = $name;
        $this->nrp = $nrp;
        $this->kontak = $kontak;
        $this->status = $status;
        $this->ktm = $ktm;
        $this->upload_karya_url = $upload_karya_url;
        $this->deskripsi_url = $deskripsi_url;
        $this->form_keaslian_url = $form_keaslian_url;
        $this->created_at = $created_at;
    }

    /**
     * @throws Exception
     */
    public static function create(UserId $user_id, ?PembayaranId $pembayaran_id, string $departemen_id, string $name, NRP $nrp, string $kontak, bool $status, string $ktm, ?string $upload_karya_url = null, ?string $deskripsi_url = null, ?string $form_keaslian_url = null): self
    {
        return new self(
            Wahana2DId::generate(),
            $user_id,
            $pembayaran_id,
            $departemen_id,
            $name,
            $nrp,
            $kontak,
            $status,
            $ktm,
            $upload_karya_url,
            $deskripsi_url,
            $form_keaslian_url,
            "null",
        );
    }

    /**
     * @throws Exception
     */
    public static function update(Wahana2DId $id, UserId $user_id, ?PembayaranId $pembayaran_id, string $departemen_id, string $name, NRP $nrp, string $kontak, bool $status, string $ktm, string $upload_karya_url, string $deskripsi_url, string $form_keaslian_url): self
    {
        return new self(
            $id,
            $user_id,
            $pembayaran_id,
            $departemen_id,
            $name,
            $nrp,
            $kontak,
            $status,
            $ktm,
            $upload_karya_url,
            $deskripsi_url,
            $form_keaslian_url,
            "null",
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
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->user_id;
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

    public function getUploadKaryaUrl(): ?string
    {
        return $this->upload_karya_url;
    }

    public function getDeskripsiUrl(): ?string
    {
        return $this->deskripsi_url;
    }

    public function getFormKeaslianUrl(): ?string
    {
        return $this->form_keaslian_url;
    }
}
