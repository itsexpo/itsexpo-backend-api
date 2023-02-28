<?php

namespace App\Core\Application\Service\GetUserUrlShortener;

class GetUserUrlShortenerRequest
{
    private ?string $search;
    private int $page;
    private int $per_page;

    /**
     * @param ?string $search
     * @param int $page
     * @param int $per_page
     */
    public function __construct(?string $search, int $page, int $per_page)
    {
        $this->search = $search;
        $this->page = $page;
        $this->per_page = $per_page;
    }

    /**
     * @return ?string
     */
    public function getSearch(): ?string
    {
        return $this->search;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->per_page;
    }
}
