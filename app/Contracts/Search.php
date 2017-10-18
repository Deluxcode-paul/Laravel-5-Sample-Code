<?php

namespace App\Contracts;

interface Search
{
    /**
     * @return mixed
     */
    public function getFilter();

    /**
     * @return mixed
     */
    public function filterItems();

    /**
     * @return mixed
     */
    public function getFeatured();

    /**
     * @param $query
     * @return mixed
     */
    public function filterQuery(&$query);
}
