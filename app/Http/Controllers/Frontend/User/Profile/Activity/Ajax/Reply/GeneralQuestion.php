<?php

namespace App\Http\Controllers\Frontend\User\Profile\Activity\Ajax\Reply;

use App\Events\GeneralAnswer\GeneralAnswerPosted;
use App\Http\Controllers\Frontend\User\Profile\AbstractProfile;
use App\Http\Requests\Frontend\User\Profile\Activity\Reply\GeneralQuestionRequest;
use App\Models\GeneralAnswer;
use App\Models\GeneralQuestion as GeneralQuestionModel;

class GeneralQuestion extends AbstractProfile
{
    /**
     * @param GeneralQuestionRequest $request
     * @param GeneralQuestionModel $question
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(GeneralQuestionRequest $request, GeneralQuestionModel $question)
    {
        $item = new GeneralAnswer();
        $item->user_id = $this->currentUser->id;
        $item->question_id = $question->id;
        $item->fill($request->only([
            'details'
        ]));
        $item->save();

        event(new GeneralAnswerPosted($item));

        $content = view('community.blocks.items.reply_ajax', compact('item'))->render();

        return response()->json(compact('content'));
    }
}
