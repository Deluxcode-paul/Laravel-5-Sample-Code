<?php

namespace App\Http\Controllers\Frontend\Pages;

use App\Http\Controllers\Controller;
use App\Http\Traits\Listing;
use App\Enums\VideoSorting;

abstract class AbstractWatch extends Controller
{
    use Listing;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Per Page items
     */
    protected $perPage;

    /**
     * Filter values
     * @var array
     */
    protected $filterValues = ['sort' => VideoSorting::RECENT];

    /**
     * @param $query
     * @return mixed
     */
    protected function getVideosPaged($query)
    {
        return $this->filterItems($query)->paginate($this->perPage);
    }

    /**
     * Return filter
     * @return \Illuminate\Support\Collection
     */
    protected function getFilter()
    {
        $filter = collect();

        $filter->put('sort', $this->getFilterSort());

        return $filter;
    }

    /**
     * Return sort for filter
     * @return \Illuminate\Support\Collection
     */
    protected function getFilterSort()
    {
        return collect(VideoSorting::labels());
    }

    /**
     * Filter video items
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function filterItems($query)
    {
        if ($this->filterValues['sort']) {
            switch ($this->filterValues['sort']) {
                case VideoSorting::OLDEST:
                    $query = $query->orderBy('created_at', 'ASC');
                    break;
                case VideoSorting::RECENT:
                default:
                    $query = $query->orderBy('created_at', 'DESC');
                    break;
            }
        }

        return $query;
    }
}
