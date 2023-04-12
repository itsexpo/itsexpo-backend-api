<?php

namespace App\Core\Application\Service\Wahana2DAdmin;

use App\Core\Domain\Models\Wahana2D\Wahana2D;
use JsonSerializable;

class Wahana2DAdminPaginationResponse implements JsonSerializable
{
    private array $data;
    private int $page;
    private float $max_page;
    private int $totalpendatar;
    private int $revisi;
    private int $gagal;
    private int $success;
    private int $awaiting_verification;
    private int $awaiting_payment;

    /**
     * @param array $data
     * @param int $page
     * @param float $max_page
     */
    public function __construct(array $data, int $page, float $max_page, int $totalpendatar, int $revisi, int $gagal, int $success, int $awaiting_verification, int $awaiting_payment)
    {
        $this->data = $data;
        $this->page = $page;
        $this->max_page = $max_page;
        $this->totalpendatar = $totalpendatar;
        $this->revisi = $revisi;
        $this->gagal = $gagal;
        $this->success = $success;
        $this->awaiting_payment = $awaiting_payment;
        $this->awaiting_verification = $awaiting_verification;
    }

    public function jsonSerialize(): array
    {
        return [
            "data_per_page" => $this->data,
            "meta" => [
                "page" => $this->page,
                "max_page" => $this->max_page,
                "total_tim" => $this->totalpendatar,
                "pembayaran" => [
                    "revisi" => $this->revisi,
                    "gagal" => $this->gagal,
                    "success" => $this->success,
                    "awaiting_verification" => $this->awaiting_verification,
                    "awaiting_payment" => $this->awaiting_payment
                ]


            ]
        ];
    }
}
