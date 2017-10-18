<?php

namespace App\Contracts\Community;

interface CommunityChildItem
{
    /**
     * @param $query
     * @return mixed
     */
    public function scopeRecent($query);

    /**
     * @param $query
     * @return mixed
     */
    public function scopeVotes($query);

    /**
     * @return mixed
     */
    public function getUserCanEditAttribute();

    /**
     * @return mixed
     */
    public function getUserCanReportAttribute();

    /**
     * @return mixed
     */
    public function getUserCanVoteAttribute();

    /**
     * @return string
     */
    public function getPublishedAtAttribute();

    /**
     * @return string
     */
    public function getDataTypeAttribute();

    /**
     * @return string
     */
    public function getEditUrlAttribute();

    /**
     * @return string
     */
    public function getUpdateUrlAttribute();

    /**
     * @return string
     */
    public function getDeleteUrlAttribute();

    /**
     * @return string
     */
    public function getOwnerUrl();
}
