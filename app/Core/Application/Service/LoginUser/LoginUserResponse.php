<?php

namespace App\Core\Application\Service\LoginUser;

use JsonSerializable;

class LoginUserResponse implements JsonSerializable
{
    private string $token_jwt;
    private string $role;

    /**
     * @param string $token_jwt
     */
    public function __construct(string $token_jwt, string $role)
    {
        $this->token_jwt = $token_jwt;
        $this->role = $role;
    }

    public function jsonSerialize(): array
    {
        return [
            'token' => $this->token_jwt,
            'role' => $this->role
        ];
    }
}
