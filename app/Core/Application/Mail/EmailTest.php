<?php

namespace App\Core\Application\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

use function config;

class EmailTest extends Mailable
{
    use Queueable, SerializesModels;

    private string $name;
    private string $email;
    private string $no_telp;

    /**
     * @param string $name
     * @param string $email
     * @param string $no_telp
     */
    public function __construct(string $name, string $email, string $no_telp)
    {
        $this->name = $name;
        $this->email = $email;
        $this->no_telp = $no_telp;
    }

    public function build(): EmailTest
    {
        return $this->from(config('mail.from'))
            ->markdown('email.email_test', [
                "name" => $this->name,
                "email" => $this->email,
                "no_telp" => $this->no_telp,
            ]);
    }
}
