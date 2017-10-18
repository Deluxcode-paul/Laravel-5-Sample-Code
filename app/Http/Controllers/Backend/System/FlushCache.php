<?php

namespace App\Http\Controllers\Backend\System;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Prologue\Alerts\Facades\Alert;

/**
 * Class FlushCache
 * @package App\Http\Controllers\Backend\System
 */
class FlushCache extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke()
    {
        Cache::flush();
        Alert::success(trans('crud.notifications.cache_flush_success'))->flash();

        return redirect()->back();
    }
}
