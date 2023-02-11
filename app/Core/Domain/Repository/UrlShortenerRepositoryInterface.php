<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\UrlShortener\UrlShortener;

interface UrlShortenerRepositoryInterface
{
    public function persist(UrlShortener $url_shortener): void;
}
