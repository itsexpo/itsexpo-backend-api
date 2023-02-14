<?php

namespace App\Core\Application\Service\UpdateUrlShortener;

use App\Core\Domain\Models\UrlShortener\UrlShortenerId;

class UpdateUrlShortenerRequest
{
    private UrlShortenerId $url_id;
    private string $long_url;
    private string $short_url;

    /**
     * @param string $long_url
     * @param string $short_url
     */

    public function __construct(UrlShortenerId $url_id, string $long_url, string $short_url)
    {
        $this->url_id = $url_id;
        $this->long_url = $long_url;
        $this->short_url = $short_url;
    }

    public function getUrlId(): UrlShortenerId
    {
        return $this->url_id;
    }

    public function getLongUrl(): string
    {
        return $this->long_url;
    }

    public function getShortUrl(): string
    {
        return $this->short_url;
    }
}
