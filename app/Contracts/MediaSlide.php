<?php

namespace App\Contracts;

interface MediaSlide
{
    /**
     * @return boolean
     */
    public function isVideo();

    /**
     * @return mixed
     */
    public function getDetailPageUrl();
}
