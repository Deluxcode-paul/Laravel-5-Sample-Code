<?php

namespace App\Http\Controllers\Frontend\Community\GeneralAnswer;

use App\Http\Controllers\Frontend\Community\AbstractReplySave;
use App\Http\Requests\Frontend\Community\GeneralAnswerRequest;
use App\Models\GeneralAnswer;

/**
 * Class Save
 * @package App\Http\Controllers\Frontend\Community\GeneralAnswer
 */
class Save extends AbstractReplySave
{
    /**
     * @param GeneralAnswerRequest $request
     * @param GeneralAnswer $item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(GeneralAnswerRequest $request, GeneralAnswer $item)
    {
        $this->request = $request;
        $this->item    = $item;
        $this->save();

        return redirect()->route('community');
    }
}
