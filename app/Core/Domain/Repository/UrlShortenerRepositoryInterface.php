<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Models\UrlShortener\UrlShortener;

interface UrlShortenerRepositoryInterface
{
    public function persist(UrlShortener $url_shortener): void;

    public function find(string $url_shortener): ?UrlShortener;

    public function addVisitor(string $url_shortener): void;
}
