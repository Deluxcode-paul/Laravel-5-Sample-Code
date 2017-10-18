<?php

namespace App\Http\Controllers\Frontend\Community\RecipeAnswer;

use App\Http\Controllers\Frontend\Community\AbstractReplySave;
use App\Http\Requests\Frontend\Community\RecipeAnswerRequest;
use App\Models\RecipeAnswer;

/**
 * Class Save
 * @package App\Http\Controllers\Frontend\Community\RecipeAnswer
 */
class Save extends AbstractReplySave
{
    /**
     * @param RecipeAnswerRequest $request
     * @param RecipeAnswer $item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(RecipeAnswerRequest $request, RecipeAnswer $item)
    {
        $this->request = $request;
        $this->item    = $item;
        $this->save();

        return redirect()->route('community');
    }
}
