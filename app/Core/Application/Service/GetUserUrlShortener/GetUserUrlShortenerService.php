<?php

namespace App\Core\Application\Service\GetUserUrlShortener;

use App\Exceptions\UserException;
use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\UserAccount;
use App\Core\Application\Service\PaginationResponse;
use App\Core\Domain\Models\UrlShortener\UrlShortener;
use App\Core\Domain\Repository\UrlShortenerRepositoryInterface;
use App\Core\Application\Service\GetUrlShortener\GetUrlShortenerResponse;

class GetUserUrlShortenerService
{
    private UrlShortenerRepositoryInterface $url_shortener_repository;

    public function __construct(UrlShortenerRepositoryInterface $url_shortener_repository)
    {
        $this->url_shortener_repository = $url_shortener_repository;
    }

    public function execute(GetUserUrlShortenerRequest $request, UserAccount $account)
    {
        $rows = DB::table('url_shortener');

        if ($request->getSearch()) {
            $rows->where('url_shortener.short_url', 'like', '%'.$request->getSearch().'%')
            ->orWhere('url_shortener.long_url', 'like', '%'.$request->getSearch().'%');
        }

        $rows = $rows->paginate($request->getPerPage(), ['url_shortener.*'], 'url_shortener_page', $request->getPage());

        $url_shorteners = [];
        foreach ($rows as $row) {
            $url_shorteners[] = $this->url_shortener_repository->constructFromRows([$row])[0];
        }

        $url_shorteners_pagination = [
            "data" => $url_shorteners,
            "max_page" => ceil($rows->total() / $request->getPerPage())
        ];

        $max_page = $url_shorteners_pagination['max_page'];

        $url_shortener_response = array_map(function (UrlShortener $url_shortener) {
            return new GetUrlShortenerResponse(
                $url_shortener->getLongUrl(),
                $url_shortener->getShortUrl(),
                $url_shortener->getVisitor(),
            );
        }, $url_shorteners_pagination['data']);

        return new PaginationResponse($url_shortener_response, $request->getPage(), $max_page);
        // if ($request->getSearch()) {
        //     rows
        // }
        // $shorten_url = $this->url_shortener_repository->findByUserIdPaginate($request->getPage(), $request->getPerPage(), $account->getUserId());
        // $max_page = $shorten_url['max_page'];
        // if (!$shorten_url) {
        //     return UserException::throw("Short URL tidak ditemukan", 5009, 400);
        // }
        // $url_shortener_response = array_map(function (UrlShortener $url_shortener) {
        //     return new GetUserUrlShortenerResponse(
        //         $url_shortener
        //     );
        // }, $shorten_url['data']);

        // return new PaginationResponse($url_shortener_response, $request->getPage(), $max_page);
    }
}
