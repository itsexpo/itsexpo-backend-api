<?php

namespace App\Core\Domain\Models\UrlShortener;

use Exception;
use App\Core\Domain\Models\User\UserId;

class UrlShortener
{
    private UrlShortenerId $id;
    private UserId $user_id;
    private string $long_url;
    private string $short_url;
    private int $visitor;
    private string $created_at;
    private string $updated_at;

    /**
     * @param UrlShortenerId $id
     * @param UserId $user_id
     * @param string $long_url
     * @param string $short_url
     * @param int $visitor
     * @param string $created_at
     * @param string $updated_at
     */
    public function __construct(UrlShortenerId $id, UserId $user_id, string $long_url, string $short_url, int $visitor, string $created_at, string $updated_at)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->long_url = $long_url;
        $this->short_url = $short_url;
        $this->visitor = $visitor;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    /**
     * @throws Exception
     */
    public static function create(UserId $user_id, string $long_url, string $short_url, int $visitor): self
    {
        return new self(
            UrlShortenerId::generate(),
            $user_id,
            $long_url,
            $short_url,
            $visitor,
            "null",
            "null"
        );
    }

    /**
     * @return UrlShortenerId
     */
    public function getId(): UrlShortenerId
    {
        return $this->id;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function getLongUrl(): string
    {
        return $this->long_url;
    }

    /**
     * @return string
     */
    public function getShortUrl(): string
    {
        return $this->short_url;
    }

    /**
     * @return int
     */
    public function getVisitor(): int
    {
        return $this->visitor;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }
}
