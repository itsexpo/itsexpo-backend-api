<?php

namespace App\Core\Application\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use function config;

class PaymentWaiting extends Mailable
{
    use Queueable, SerializesModels;

    private string $name;
    private string $event;

    /**
     * @param string $name
     * @param string $event
     */
    public function __construct(string $name, string $event)
    {
        $this->name = $name;
        $this->event = $event;
    }

    public function build(): PaymentWaiting
    {
        return $this->from(config('mail.from'))
            ->markdown('email.payment_waiting', [
                "name" => $this->name,
                "event" => $this->event,
            ]);
    }
}
