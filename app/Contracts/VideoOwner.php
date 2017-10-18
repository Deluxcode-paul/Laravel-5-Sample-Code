<?php

namespace App\Contracts;

interface VideoOwner
{
    /**
     * @return string
     */
    public function getUrl();

    /**
     * @return string
     */
    public function getUrlText();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @return string
     */
    public function getType();

    /**
     * @return string
     */
    public function getCreator();

    /**
     * @return string
     */
    public function getCreatorUrl();

    /**
     * @return string
     */
    public function getCreatorImage();

    /**
     * @return string
     */
    public function getBreadcrumb();

    /**
     * @return boolean
     */
    public function canBeSaved();
}
