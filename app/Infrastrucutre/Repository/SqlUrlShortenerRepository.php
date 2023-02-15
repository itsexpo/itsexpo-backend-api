<?php

namespace App\Infrastrucutre\Repository;

use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\UrlShortener\UrlShortener;
use App\Core\Domain\Models\UrlShortener\UrlShortenerId;
use App\Core\Domain\Models\User\UserId;
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

    public function find(string $short_url): ?UrlShortener
    {
        $row = DB::table('url_shortener')->where('short_url', $short_url)->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRow($row);
    }

    public function addVisitor(string $short_url): void
    {
        $row = DB::table('url_shortener')->where('short_url', $short_url);
        $visitor = $row->first()->visitor + 1;
        if ($row) {
            $row->update(['visitor' => $visitor]);
        }
    }

    /**
     * @throws Exception
     */
    private function constructFromRow($row): UrlShortener
    {
        return new UrlShortener(
            new UrlShortenerId($row->id),
            new UserId($row->user_id),
            $row->long_url,
            $row->short_url,
            $row->visitor,
        );
    }
}
