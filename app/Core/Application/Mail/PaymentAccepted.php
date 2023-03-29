<?php

namespace App\Core\Application\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use function config;

class PaymentAccepted extends Mailable
{
    use Queueable, SerializesModels;

    private string $name;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function build(): PaymentAccepted
    {
        return $this->from(config('mail.from'))
            ->markdown('email.payment_accepted', [
                "name" => $this->name,
            ]);
    }
}
