<?php

namespace App\Http\Controllers\Frontend\Community\GeneralQuestion;

use App\Http\Controllers\Frontend\Community\AbstractEdit;
use App\Models\GeneralQuestion;
use Assets;

/**
 * Class Edit
 * @package App\Http\Controllers\Frontend\Community\GeneralQuestion
 */
class Edit extends AbstractEdit
{
    /**
     * @param GeneralQuestion $item
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(GeneralQuestion $item)
    {
        $this->item = $item;

        Assets::group('frontend')->addJs('community/delete.js');

        return view('community.community_question.edit', $this->getTemplateVariables());
    }
}
