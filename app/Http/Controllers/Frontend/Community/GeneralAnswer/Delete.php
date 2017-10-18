<?php

namespace App\Http\Controllers\Frontend\Community\GeneralAnswer;

use App\Http\Controllers\Controller;
use App\Models\GeneralAnswer;

/**
 * Class Edit
 * @package App\Http\Controllers\Frontend\Community\ArticleComment
 */
class Delete extends Controller
{
    /**
     * @param GeneralAnswer $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(GeneralAnswer $item)
    {
        $this->authorize('delete', $item);

        $item->delete();

        return redirect()->route('community');
    }
}
