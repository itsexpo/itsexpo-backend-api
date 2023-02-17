<?php

namespace App\Core\Application\Service\DeleteUrlShortener;

use App\Core\Domain\Models\UrlShortener\UrlShortenerId;

class DeleteUrlShortenerRequest
{
    private UrlShortenerId $url_id;

    /**
     * @param UrlShortenerId $long_url
     */

    public function __construct(UrlShortenerId $url_id)
    {
        $this->url_id = $url_id;
    }

    public function getUrlId(): UrlShortenerId
    {
        return $this->url_id;
    }
}
