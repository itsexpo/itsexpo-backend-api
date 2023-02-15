<?php

namespace App\Core\Application\Service\GetUserUrlShortener;

use App\Core\Domain\Models\UrlShortener\UrlShortener;
use JsonSerializable;

class GetUserUrlShortenerResponse implements JsonSerializable
{
    private UrlShortener $url_shortener;

    public function __construct(UrlShortener $url_shortener)
    {
        $this->url_shortener = $url_shortener;
    }
 
    public function jsonSerialize(): array
    {
        return [
            'short_url' => $this->url_shortener->getShortUrl(),
            'long_url' => $this->url_shortener->getLongUrl(),
            'visitor' => $this->url_shortener->getVisitor(),
        ];
    }
}
