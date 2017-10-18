<?php

namespace App\Http\Controllers\Frontend\Community;

use App\Http\Controllers\Controller;

/**
 * Class AbstractReplySave
 * @package App\Http\Controllers\Frontend\Community
 */
abstract class AbstractReplySave extends Controller
{
    /**
     * @var
     */
    protected $item;

    /**
     * @var
     */
    protected $request;

    /**
     * Save
     */
    protected function save()
    {
        $this->item->fill($this->request->only([
            'details'
        ]));

        $this->item->save();
    }
}
