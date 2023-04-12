<?php

namespace App\Core\Application\Service\Wahana2DAdmin;

class Wahana2DAdminRequest
{
    private String $per_page;
    private String $page;
    private ?array $filter;
    private ?String $search;

    public function __construct(String $per_page, String $page, ?array $filter, ?String $search)
    {
        $this->per_page = $per_page;
        $this->page = $page;
        $this->filter = $filter;
        $this->search = $search;
    }

    /**
     * Get the value of per_page
     */
    public function getPerPage()
    {
        return $this->per_page;
    }

    /**
     * Get the value of page
     */
    public function getPage()
    {
        return $this->page;
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
