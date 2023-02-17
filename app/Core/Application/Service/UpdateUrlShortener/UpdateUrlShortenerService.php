<?php

namespace App\Core\Application\Service\UpdateUrlShortener;

use Exception;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Repository\UrlShortenerRepositoryInterface;
use App\Exceptions\UserException;

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
        
        $user_id_req = $this->url_shortener_repository->findById($request->getUrlId())->getUserId()->toString();
        
        if ($user_id->toString() != $user_id_req) {
            UserException::throw('User does not have permission to perform this action', 1200, 403);
        }

        $this->url_shortener_repository->update(
            $request->getUrlId(),
            $request->getLongUrl(),
            $request->getShortUrl()
        );
    }
}
