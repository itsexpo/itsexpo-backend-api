<?php

namespace App\Core\Application\Service\DeleteUrlShortener;

use Exception;
use App\Core\Domain\Repository\UrlShortenerRepositoryInterface;

class DeleteUrlShortenerService
{
    private UrlShortenerRepositoryInterface $url_shortener_repository;

    /**
     * @param UrlShortenerRepositoryInterface $url_shortener_repository
     */

    public function __construct(UrlShortenerRepositoryInterface $url_shortener_repository)
    {
        $this->url_shortener_repository = $url_shortener_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(DeleteUrlShortenerRequest $request)
    {
        $item = $request->getUrlId();
        $this->url_shortener_repository->delete($item);
    }
}
