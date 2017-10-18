<?php

namespace App\Http\Traits;

trait Listing
{
    /**
     * Set Per Page value
     * @param $sessionKey
     */
    protected function setPerPage($sessionKey)
    {
        if ($this->request->has('per_page') &&
            in_array($this->request->per_page, config('kosher.pagination.per_page_selector'))) {
            $this->request->session()->put($sessionKey, $this->request->per_page);
        }

        $this->perPage = $this->request->session()->get(
            $sessionKey,
            config('kosher.pagination.default_per_page')
        );
    }

    /**
     * Set Query
     * @param $sessionKey
     */
    protected function setQuery($sessionKey)
    {
        if ($this->request->get('query') !== null) {
            $this->request->session()->put($sessionKey, $this->request->get('query'));
        }

        $this->query = $this->request->session()->get($sessionKey, '');
    }

    /**
     * Set Filter values
     * @param $sessionKey
     */
    protected function setFilterValues($sessionKey)
    {
        foreach ($this->filterValues as $filter => $value) {
            if ($this->request->get('reset') !== null) {
                $this->request->session()->forget($sessionKey.'_'.$filter);
            }
            if ($this->request->get($filter) !== null) {
                $this->request->session()->put($sessionKey.'_'.$filter, $this->request->get($filter));
            }
            $this->filterValues[$filter] = $this->request->session()
                ->get($sessionKey.'_'.$filter, $this->filterValues[$filter]);
        }
    }
}
