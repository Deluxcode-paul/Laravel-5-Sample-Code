<?php

namespace App\Contracts;

/**
 * Interface HomeBanner
 * @package App\Contracts
 */
interface HomeBanner
{
    /**
     * @return string
     */
    public function getBannerHeading();
    /**
     * @return string
     */
    public function getBannerSubheading();

    /**
     * @return string
     */
    public function getBannerCategory();

    /**
     * @return string
     */
    public function getBannerTitle();

    /**
     * @return string
     */
    public function getBannerDescription();

    /**
     * @return string
     */
    public function getBannerUrl();

    /**
     * @return string
     */
    public function getBannerButton();

    /**
     * @param string $size
     * @return string
     */
    public function getBannerPicture($size = 'home_banner');

    /**
     * @return boolean
     */
    public function isRecipe();
}
