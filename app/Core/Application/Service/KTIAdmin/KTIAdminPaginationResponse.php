<?php

namespace App\Core\Application\Service\KTIAdmin;

use JsonSerializable;

class KTIAdminPaginationResponse implements JsonSerializable
{
    private array $data;
    private int $page;
    private float $max_page;
    private int $total_tim;
    private int $revisi;
    private int $gagal;
    private int $success;
    private int $awaiting_verification;
    private int $awaiting_payment;

    /**
     * @param array $data
     * @param int $page
     * @param float $max_page
     * @param int $total_tim
     * @param int $revisi
     * @param int $gagal
     * @param int $success
     * @param int $awaiting_verification
     * @param int $awaiting_payment
     */
    public function __construct(array $data, int $page, float $max_page, int $total_tim, int $revisi, int $gagal, int $success, int $awaiting_verification, int $awaiting_payment)
    {
        $this->data = $data;
        $this->page = $page;
        $this->max_page = $max_page;
        $this->total_tim = $total_tim;
        $this->gagal = $gagal;
        $this->revisi = $revisi;
        $this->success = $success;
        $this->awaiting_verification = $awaiting_verification;
        $this->awaiting_payment = $awaiting_payment;
    }

    public function jsonSerialize(): mixed
    {
        return [
          "data_per_page" => $this->data,
          "meta" => [
            "page" => $this->page,
            "max_page" => $this->max_page,
            "total_tim" => $this->total_tim,
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
