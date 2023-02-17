<?php

namespace App\Core\Application\Service\UpdateUrlShortener;

use Exception;
use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Models\UrlShortener\UrlShortenerId;
use App\Core\Domain\Repository\UrlShortenerRepositoryInterface;

class UpdateUrlShortenerService
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
    public function execute(UpdateUrlShortenerRequest $request, UserAccount $account)
    {
        $user_id = $account->getUserId();

        $url_shortener = $this->url_shortener_repository->find(new UrlShortenerId($request->getUrlId()));
        $is_short_url = $this->url_shortener_repository->findByShortUrl($request->getShortUrl());
        $is_long_url = $this->url_shortener_repository->findByLongUrl($request->getLongUrl());

        if ($is_short_url) {
            if ($request->getShortUrl() != $url_shortener->getShortUrl() && $request->getShortUrl() == $is_short_url->getShortUrl()) {
                UserException::throw('Short Url Already Exist', 1200, 403);
            }
        }

        if ($is_long_url) {
            if ($request->getLongUrl() != $url_shortener->getLongUrl() && $request->getLongUrl() == $is_long_url->getLongUrl()) {
                UserException::throw('Long Url Already Exist', 1200, 403);
            }
        }

        if ($user_id->toString() != $url_shortener->getUserId()->toString()) {
            UserException::throw('User is not verified', 1200, 403);
        }

        $this->url_shortener_repository->update(
            new UrlShortenerId($request->getUrlId()),
            $request->getLongUrl(),
            $request->getShortUrl()
        );
    }
}
