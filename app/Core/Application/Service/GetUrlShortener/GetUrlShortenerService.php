<?php

namespace App\Core\Application\Service\GetUrlShortener;

use App\Exceptions\UserException;
use App\Core\Domain\Repository\UrlShortenerRepositoryInterface;

class GetUrlShortenerService
{
    private UrlShortenerRepositoryInterface $url_shortener_repository;

    public function __construct(UrlShortenerRepositoryInterface $url_shortener_repository)
    {
        $this->url_shortener_repository = $url_shortener_repository;
    }

    public function execute(GetUrlShortenerRequest $request)
    {
        $shorten_url = $this->url_shortener_repository->findByShortUrl($request->getShortUrl());
        if (!$shorten_url) {
            return UserException::throw("Short URL tidak ditemukan", 5009, 400);
        }
        $this->url_shortener_repository->addVisitor($request->getShortUrl());
        $response = new GetUrlShortenerResponse(
            $shorten_url->getLongUrl(),
            $shorten_url->getShortUrl(),
            $shorten_url->getVisitor()
        );

        return $response;
    }
}
