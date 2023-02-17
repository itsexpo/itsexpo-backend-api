<?php

namespace App\Core\Application\Service\GetUrlShortener;

use JsonSerializable;

class GetUrlShortenerResponse implements JsonSerializable
{
    private string $long_url;
    private int $visitor;

    public function __construct(string $long_url, int $visitor)
    {
        $this->long_url = $long_url;
        $this->visitor = $visitor;
    }

    public function jsonSerialize(): array
    {
        return [
            'long_url' => $this->long_url,
            'visitor' => $this->visitor,
        ];
    }
}
