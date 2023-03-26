<?php

namespace App\Core\Application\Service\KTIAdmin;

class KTIAdminRequest
{
    private string $per_page;
    private string $page;
    private ?array $filter;
    private ?string $search;

    /**
     * @param string $per_page
     * @param string $page
     * @param ?array $filter
     * @param ?string $search
     */
    public function __construct(string $per_page, string $page, ?array $filter, ?string $search)
    {
        $this->per_page = $per_page;
        $this->page = $page;
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
