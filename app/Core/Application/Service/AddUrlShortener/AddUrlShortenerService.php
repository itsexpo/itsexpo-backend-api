<?php

namespace App\Core\Application\Service\AddUrlShortener;

use App\Core\Domain\Models\UrlShortener\UrlShortener;
use App\Core\Domain\Models\UserAccount;
use Exception;
use App\Core\Domain\Repository\UrlShortenerRepositoryInterface;

class AddUrlShortenerService
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
    public function execute(AddUrlShortenerRequest $request, UserAccount $account)
    {
        $url_shortener = UrlShortener::create(
            $account->getUserId(),
            $request->getLongUrl(),
            $request->getShortUrl(),
            0
        );
        $this->url_shortener_repository->persist($url_shortener);
    }
}
