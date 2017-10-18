<?php

namespace App\Http\Controllers\Backend\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class Filter
 * @package App\Http\Controllers\Backend\Ajax
 */
class Filter extends Controller
{
    /**
     * @param Request $request
     */
    public function __invoke(Request $request)
    {
        $controller = $request->input('controller');
        $session = session('backpack.filters', []);
        $session[$controller] = $request->except(['_token', 'controller']);
        session(['backpack.filters' => $session]);
    }
}
