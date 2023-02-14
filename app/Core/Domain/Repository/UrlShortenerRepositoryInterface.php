<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\UrlShortener\UrlShortener;
use App\Core\Domain\Models\UrlShortener\UrlShortenerId;

interface UrlShortenerRepositoryInterface
{
    public function persist(UrlShortener $url_shortener): void;

    public function delete(UrlShortenerId $url_id): void;

    public function update(UrlShortenerId $url_id, string $long_url, string $short_url): void;

    public function find(UrlShortenerId $url_id): ?UrlShortener;
}
