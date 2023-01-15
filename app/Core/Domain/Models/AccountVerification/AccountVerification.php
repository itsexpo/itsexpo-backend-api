<?php

namespace App\Core\Domain\Models\AccountVerification;

use Exception;
use App\Core\Domain\Models\Email;

class AccountVerification
{
    private AccountVerificationId $id;
    private Email $email;
    private string $token;

    /**
     * @param AccountVerificationId $id
     * @param Email $email
     * @param string $token
     */
    public function __construct(AccountVerificationId $id, Email $email, string $token)
    {
        $this->id = $id;
        $this->email = $email;
        $this->token = $token;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @throws Exception
     */
    public static function create(Email $email, string $token): self
    {
        return new self(
            AccountVerificationId::generate(),
            $email,
            $token
        );
    }

    /**
     * @return AccountVerificationId
     */
    public function getId(): AccountVerificationId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
}
