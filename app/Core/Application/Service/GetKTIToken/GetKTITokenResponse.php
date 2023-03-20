<?php

namespace App\Core\Application\Service\GetKTIToken;

use Illuminate\Http\UploadedFile;
use JsonSerializable;

class GetKTITokenResponse implements JsonSerializable
{
    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function jsonSerialize(): array
    {
        return [
            'token' => $this->token,
        ];
    }
}
