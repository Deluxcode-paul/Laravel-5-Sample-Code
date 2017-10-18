<?php

namespace App\Http\Controllers\Frontend\User\Profile\Activity\Ajax\Reply;

use App\Events\RecipeAnswer\RecipeAnswerPosted;
use App\Http\Controllers\Frontend\User\Profile\AbstractProfile;
use App\Http\Requests\Frontend\User\Profile\Activity\Reply\RecipeQuestionRequest;
use App\Models\RecipeAnswer;
use App\Models\RecipeQuestion as RecipeQuestionModel;

class RecipeQuestion extends AbstractProfile
{
    /**
     * @param RecipeQuestionRequest $request
     * @param RecipeQuestionModel $question
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(RecipeQuestionRequest $request, RecipeQuestionModel $question)
    {
        $item = new RecipeAnswer();
        $item->user_id = $this->currentUser->id;
        $item->recipe_question_id = $question->id;
        $item->fill($request->only([
            'details'
        ]));
        $item->save();

        event(new RecipeAnswerPosted($item));

        $content = view('community.blocks.items.reply_ajax', compact('item'))->render();

        return response()->json(compact('content'));
    }
}
