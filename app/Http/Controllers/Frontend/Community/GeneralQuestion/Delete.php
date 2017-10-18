<?php

namespace App\Http\Controllers\Frontend\Community\GeneralQuestion;

use App\Http\Controllers\Frontend\Community\AbstractEdit;
use App\Models\GeneralQuestion;

/**
 * Class Edit
 * @package App\Http\Controllers\Frontend\Community\GeneralQuestion
 */
class Delete extends AbstractEdit
{
    /**
     * @param GeneralQuestion $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(GeneralQuestion $item)
    {
        $this->authorize('delete', $item);

        $item->delete();

        return redirect()->route('community');
    }
}
