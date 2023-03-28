<?php

namespace App\Core\Application\Service\UpdatePembayaran;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePembayaranRequest extends FormRequest
{
    private string $payment_id;

    public function __construct(string $payment_id)
    {
        $this->payment_id = $payment_id;
    }

    public function getPaymentId(): string
    {
        return $this->payment_id;
    }
}
