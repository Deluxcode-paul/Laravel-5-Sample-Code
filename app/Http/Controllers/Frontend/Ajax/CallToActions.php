<?php

namespace App\Http\Controllers\Frontend\Ajax;

use App\Http\Controllers\Controller;
use App\Models\CallToAction;

class CallToActions extends Controller
{
    public function __invoke()
    {
        $actions = CallToAction::take(config('kosher.cta_limit'))->get();
        $content = view('common.ajax.call_to_actions', compact('actions'))->render();

        return response()->json(compact('content'));
    }
}
