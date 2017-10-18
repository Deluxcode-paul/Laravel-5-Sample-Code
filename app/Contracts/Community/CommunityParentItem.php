<?php

namespace App\Contracts\Community;

interface CommunityParentItem
{
    /**
     * @return mixed
     */
    public function getDetailsUrlAttribute();

    /**
     * @param $query
     * @param $user
     * @return mixed
     */
    public function scopeForUser($query, $user);

    /**
     * @param $query
     * @return mixed
     */
    public function scopeRecent($query);

    /**
     * @param $query
     * @return mixed
     */
    public function scopePopular($query);

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
     * @return mixed
     */
    public function getReportedAttribute();

    /**
     * @return string
     */
    public function getPublishedAtAttribute();

    /**
     * @return string
     */
    public function getHasRatingAttribute();

    /**
     * @param $value
     * @return mixed
     */
    public function getRepliesAttribute($value);

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
}
