<?php

namespace App\Core\Application\Service\GetUrlShortener;

use JsonSerializable;

class GetUrlShortenerResponse implements JsonSerializable
{
    private string $long_url;
    private string $short_url;
    private int $visitor;

    public function __construct(string $long_url, string $short_url, int $visitor)
    {
        $this->long_url = $long_url;
        $this->short_url = $short_url;
        $this->visitor = $visitor;
    }

    public function jsonSerialize(): array
    {
        return [
            'long_url' => $this->long_url,
            'short_url' => $this->short_url,
            'visitor' => $this->visitor,
        ];
    }
}
