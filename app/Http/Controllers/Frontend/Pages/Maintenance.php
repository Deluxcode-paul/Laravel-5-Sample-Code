<?php

namespace App\Http\Controllers\Frontend\Pages;

use App\Http\Controllers\Controller;

class Maintenance extends Controller
{
    /**
     * Controller main action
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        return redirect()->to('maintenance');
    }
}
