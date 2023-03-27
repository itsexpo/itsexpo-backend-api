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

    public function delete(UrlShortenerId $url_shortener): void
    {
        DB::table('url_shortener')
            ->where('id', '=', $url_shortener->toString())
            ->delete();
    }

    public function update(UrlShortenerId $url_id, string $long_url, string $short_url): void
    {
        DB::table('url_shortener')
            ->where('id', '=', $url_id->toString())
            ->update([
                'long_url' => $long_url,
                'short_url' => $short_url
            ]);
    }

    public function find(UrlShortenerId $url_id): ?UrlShortener
    {
        $row = DB::table('url_shortener')->where('id', $url_id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function findByUserIdPaginate(int $page, int $per_page, UserId $user_id): array
    {
        $rows = DB::table('url_shortener')->where('user_id', $user_id->toString())
            ->paginate($per_page, ['*'], 'url_shortener_page', $page);
        $url_shortener = [];
        foreach ($rows as $row) {
            $url_shortener[] = $this->constructFromRows([$row])[0];
        }
        return [
            "data" => $url_shortener,
            "max_page" => ceil($rows->total() / $per_page)
        ];
    }

    public function addVisitor(string $short_url): void
    {
        $row = DB::table('url_shortener')->where('short_url', $short_url);
        if ($row) {
            $visitor = $row->first()->visitor + 1;
            $row->update(['visitor' => $visitor]);
        }
    }
    
    public function findByShortUrl(string $short_url): ?UrlShortener
    {
        $row = DB::table('url_shortener')->where('short_url', $short_url)->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }
    
    public function findByLongUrl(string $long_url): ?UrlShortener
    {
        $row = DB::table('url_shortener')->where('long_url', $long_url)->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    /**
     * @throws Exception
     */
    public function constructFromRows(array $rows): array
    {
        $url_shortener = [];
        foreach ($rows as $row) {
            $url_shortener[] = new UrlShortener(
                new UrlShortenerId($row->id),
                new UserId($row->user_id),
                $row->long_url,
                $row->short_url,
                $row->visitor,
                $row->created_at,
                $row->updated_at
            );
        }
        return $url_shortener;
    }
}
