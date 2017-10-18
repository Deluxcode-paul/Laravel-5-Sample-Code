<?php

namespace App\Http\Controllers\Frontend\Community\GeneralAnswer;

use App\Http\Controllers\Controller;
use App\Models\GeneralAnswer;
use Assets;

/**
 * Class Edit
 * @package App\Http\Controllers\Frontend\Community\ArticleComment
 */
class Edit extends Controller
{
    /**
     * @param GeneralAnswer $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(GeneralAnswer $item)
    {
        Assets::group('frontend')->addJs('community/delete.js');

        return view('community.community_answer.edit', compact('item'));
    }
}
