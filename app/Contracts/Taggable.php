<?php

namespace App\Contracts;

/**
 * Interface Taggable
 * @package App\Contracts
 */
interface Taggable
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags();

    /**
     * @return string
     */
    public function getTagsString();
}
