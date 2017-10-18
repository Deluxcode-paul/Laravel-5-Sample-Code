<?php

namespace App\Http\Controllers\Backend\System;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Prologue\Alerts\Facades\Alert;

/**
 * Class FlushThumbnails
 * @package App\Http\Controllers\Backend\System
 */
class FlushThumbnails extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke()
    {
        $result = [];
        $result[] = File::cleanDirectory(public_path('blurred'));
        $result[] = File::cleanDirectory(public_path('resized'));

        if ($this->isSuccess($result)) {
            Alert::success(trans('crud.notifications.thumbs_flush_success'))->flash();
        } else {
            Alert::error(trans('crud.notifications.thumbs_flush_error'))->flash();
        }

        return redirect()->back();
    }

    /**
     * @param array $array
     * @return boolean
     */
    private function isSuccess($array)
    {
        if (count(array_unique($array)) === 1) {
            return current($array);
        }

        return false;
    }
}
