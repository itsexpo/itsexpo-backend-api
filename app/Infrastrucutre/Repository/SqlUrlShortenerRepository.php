<?php

namespace App\Infrastrucutre\Repository;

use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\UrlShortener\UrlShortener;
use App\Core\Domain\Repository\UrlShortenerRepositoryInterface;

class SqlUrlShortenerRepository implements UrlShortenerRepositoryInterface
{
    public function persist(UrlShortener $url_shortener): void
    {
        DB::table('url_shortener')->upsert([
            'id' => $url_shortener->getId()->toString(),
            'user_id' => $url_shortener->getUserId()->toString(),
            'long_url' => $url_shortener->getLongUrl(),
            'short_url' => $url_shortener->getShortUrl(),
            'visitor' => $url_shortener->getVisitor(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    private function constructFromRow($row): UrlShortener
    {
        return new UrlShortener(
            $row->id,
            $row->user_id,
            $row->long_url,
            $row->short_url,
            $row->visitor,
        );
    }
}
