<?php

namespace App\Core\Application\Service\RobotInActionAdmin;

class RobotInActionAdminRequest
{
    private string $per_page;
    private string $page;
    private ?array $filter;
    private ?string $search;

    public function __construct(string $per_page, string $page, ?array $filter, ?string $search)
    {
        $this->per_page = $per_page;
        $this->page = $page;
        $this->filter = $filter;
        $this->search = $search;
    }

    /**
     * Get the value of page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Get the value of per_page
     */
    public function getPerPage()
    {
        return $this->per_page;
    }

    /**
     * Get the value of filter
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Get the value of search
     */
    public function getSearch()
    {
        return $this->search;
    }
}
