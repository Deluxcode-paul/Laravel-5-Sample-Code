<?php

namespace App\Contracts;

/**
 * Interface Searchable
 * @package App\Contracts
 */
interface Searchable
{
    /**
     * @param string $keyword
     * @return string
     */
    public function getSearchUrl($keyword);
}
