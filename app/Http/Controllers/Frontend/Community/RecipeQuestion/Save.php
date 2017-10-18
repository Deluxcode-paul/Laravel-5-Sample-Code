<?php

namespace App\Http\Controllers\Frontend\Community\RecipeQuestion;

use App\Http\Controllers\Frontend\Community\AbstractSave;
use App\Http\Requests\Frontend\Community\RecipeQuestionRequest;
use App\Models\RecipeQuestion;

/**
 * Class Save
 * @package App\Http\Controllers\Frontend\Community\RecipeQuestion
 */
class Save extends AbstractSave
{
    /**
     * @param RecipeQuestionRequest $request
     * @param RecipeQuestion $item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(RecipeQuestionRequest $request, RecipeQuestion $item)
    {
        $this->request = $request;
        $this->item    = $item;
        $this->save();

        return redirect()->route('community');
    }
}
