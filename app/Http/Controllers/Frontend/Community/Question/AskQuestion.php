<?php

namespace App\Http\Controllers\Frontend\Community\Question;

use App\Http\Controllers\Controller;
use App\Http\Traits\Community;
use Assets;

/**
 * Class AskQuestion
 * @package App\Http\Controllers\Frontend\Community
 */
class AskQuestion extends Controller
{
    use Community;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        $tags = $this->getTags();
        $chefs = $this->getChefs();

        Assets::group('frontend')->config(['js_dir' => '/js'])->addJs('community/ask_question.js');

        return view('community.ask_question', compact('tags', 'chefs'));
    }
}
