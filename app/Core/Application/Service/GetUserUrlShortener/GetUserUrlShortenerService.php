<?php

namespace App\Core\Application\Service\GetUserUrlShortener;

use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Application\Service\PaginationResponse;
use App\Core\Domain\Models\UrlShortener\UrlShortener;
use App\Core\Domain\Repository\UrlShortenerRepositoryInterface;

class GetUserUrlShortenerService
{
    private UrlShortenerRepositoryInterface $url_shortener_repository;

    public function __construct(UrlShortenerRepositoryInterface $url_shortener_repository)
    {
        $this->url_shortener_repository = $url_shortener_repository;
    }

    public function execute(GetUserUrlShortenerRequest $request, UserAccount $account)
    {
        $shorten_url = $this->url_shortener_repository->findByUserIdPaginate($request->getPage(), $request->getPerPage(), $account->getUserId());
        $max_page = $shorten_url['max_page'];
        if (!$shorten_url) {
            return UserException::throw("Short URL tidak ditemukan", 5009, 400);
        }
        $url_shortener_response = array_map(function (UrlShortener $url_shortener) {
            return new GetUserUrlShortenerResponse(
                $url_shortener
            );
        }, $shorten_url['data']);

        return new PaginationResponse($url_shortener_response, $request->getPage(), $max_page);
    }
}
