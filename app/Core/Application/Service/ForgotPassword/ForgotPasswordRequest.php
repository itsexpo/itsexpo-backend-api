<?php

namespace App\Core\Application\Service\ForgotPassword;

use App\Core\Domain\Models\Email;

class ForgotPasswordRequest
{
    private Email $email;

    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }
}

class ChangePasswordRequest
{
    private string $token;
    private string $password;

    public function __construct(string $token, string $password)
    {
        $this->token = $token;
        $this->password = $password;
    }

    /**
     * Get the value of token
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Get the value of password
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
