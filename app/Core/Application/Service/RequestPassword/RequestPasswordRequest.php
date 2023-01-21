<?php

namespace App\Core\Application\Service\RequestPassword;

use App\Core\Domain\Models\Email;
use App\Core\Domain\Service\GetIPInterface;

class RequestPasswordRequest
{
    private Email $email;
    private GetIPInterface $ip;

    public function __construct(Email $email, GetIPInterface $ip)
    {
        $this->email = $email;
        $this->ip = $ip;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * Get the value of ip
     */
    public function getIp(): GetIPInterface
    {
        return $this->ip;
    }
}
