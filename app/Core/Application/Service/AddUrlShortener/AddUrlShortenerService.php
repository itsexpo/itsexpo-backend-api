<?php

namespace App\Core\Application\Service\AddUrlShortener;

use Exception;
use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Models\UrlShortener\UrlShortener;
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
        if (filter_var($request->getLongUrl(), FILTER_VALIDATE_URL) === false) {
            UserException::throw("URL tidak valid", 1006, 404);
        }
        
        $url_shortener = UrlShortener::create(
            $account->getUserId(),
            $request->getLongUrl(),
            $request->getShortUrl(),
            0
        );
        $this->url_shortener_repository->persist($url_shortener);
    }
}
