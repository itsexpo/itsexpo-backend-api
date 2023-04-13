<?php

namespace App\Core\Application\Service\Wahana3DAdmin;

class Wahana3DAdminRequest
{
    private string $page;
    private string $per_page;
    private ?array $filter;
    private ?string $search;

    /**
     * @param string $page
     * @param string @per_page
     * @param ?array $filter
     * @param ?string $search
     */
    public function __construct(string $per_page, string $page, ?array $filter, ?string $search)
    {
        $this->page = $page;
        $this->per_page = $per_page;
        $this->filter = $filter;
        $this->search = $search;
    }

    /**
     * @return string
     */
    public function getPerPage(): string
    {
        return $this->per_page;
    }

    /**
     * @return string
     */
    public function getPage(): string
    {
        return $this->page;
    }

    /**
     * @return ?array
     */
    public function getFilter(): ?array
    {
        return $this->filter;
    }

    /**
     * @return ?string
     */
    public function getSearch(): ?string
    {
        return $this->search;
    }
}
