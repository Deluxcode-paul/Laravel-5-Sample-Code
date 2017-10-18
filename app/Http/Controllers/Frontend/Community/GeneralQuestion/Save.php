<?php

namespace App\Http\Controllers\Frontend\Community\GeneralQuestion;

use App\Http\Controllers\Frontend\Community\AbstractSave;
use App\Http\Requests\Frontend\Community\GeneralQuestionRequest;
use App\Models\GeneralQuestion;

/**
 * Class Save
 * @package App\Http\Controllers\Frontend\Community\GeneralQuestion
 */
class Save extends AbstractSave
{
    /**
     * @param GeneralQuestionRequest $request
     * @param GeneralQuestion $item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(GeneralQuestionRequest $request, GeneralQuestion $item)
    {
        $this->request = $request;
        $this->item    = $item;
        $this->save();

        return redirect()->route('community');
    }
}
