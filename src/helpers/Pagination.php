<?php

namespace HefestoMVC\helpers;

class Pagination
{
    private $totalRecords;
    private $perPage;
    private $currentPage;
    private $offset;

    public function __construct($totalRecords, $perPage, $currentPage = 1)
    {
        $this->totalRecords = $totalRecords;
        $this->perPage = $perPage;
        $this->currentPage = max(1, $currentPage); // Garante que a página atual seja pelo menos 1
        $this->offset = ($this->currentPage - 1) * $this->perPage;
    }

    public function getOffset()
    {
        return $this->offset;
    }

    public function getLimit()
    {
        return $this->perPage;
    }

    public function getTotalPages()
    {
        return (int) ceil($this->totalRecords / $this->perPage);
    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    public function getNextPage()
    {
        $next = $this->currentPage + 1;
        return $next <= $this->getTotalPages() ? $next : null;
    }

    public function getPrevPage()
    {
        $prev = $this->currentPage - 1;
        return $prev >= 1 ? $prev : null;
    }

    public function getPageRange($range = 5)
    {
        $totalPages = $this->getTotalPages();

        $start = max(1, $this->currentPage - floor($range / 2));
        $end = min($totalPages, $start + $range - 1);

        // Ajusta o início se o fim atingir o limite máximo
        $start = max(1, $end - $range + 1);

        return range($start, $end);
    }
}