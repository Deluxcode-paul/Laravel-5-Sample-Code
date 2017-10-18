<?php

namespace App\Http\Controllers\Frontend\Community\Question;

use App\Events\GeneralQuestion\GeneralQuestionPosted;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Community\AskQuestionRequest;
use App\Models\GeneralQuestion;
use Illuminate\Support\Facades\Auth;

/**
 * Class SaveQuestion
 * @package App\Http\Controllers\Frontend\Community
 */
class SaveQuestion extends Controller
{
    /**
     * @param AskQuestionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(AskQuestionRequest $request)
    {
        $question = new GeneralQuestion();
        $question->fill($request->only([
            'title',
            'details'
        ]));
        $question->user_id = Auth::user()->id;
        $question->save();

        if ($request->get('tags')) {
            $question->tags()->sync($request->get('tags'));
        }
        if ($request->get('chefs')) {
            $question->chefs()->sync($request->get('chefs'));
        }

        event(new GeneralQuestionPosted($question));

        return redirect()->route('community');
    }
}
