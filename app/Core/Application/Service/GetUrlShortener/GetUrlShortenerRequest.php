<?php

namespace App\Core\Application\Service\GetUrlShortener;

class GetUrlShortenerRequest
{
    private string $shortUrl;

    public function __construct(string $shortUrl)
    {
        $this->shortUrl = $shortUrl;
    }

    /**
     * Get the value of shortUrl
     */
    public function getShortUrl()
    {
        return $this->shortUrl;
    }
}
