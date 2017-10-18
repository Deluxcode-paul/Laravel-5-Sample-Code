<?php

namespace App\Http\Controllers\Frontend\Community;

use App\Http\Controllers\Controller;

/**
 * Class AbstractSave
 * @package App\Http\Controllers\Frontend\Community
 */
abstract class AbstractSave extends Controller
{
    /**
     * @var
     */
    protected $item;

    /**
     * @var
     */
    protected $request;

    /**
     * Save
     */
    protected function save()
    {
        $this->item->fill($this->request->only([
            'title',
            'details'
        ]));

        if ($this->request->get('tags')) {
            $this->item->tags()->sync($this->request->get('tags'));
        } else {
            $this->item->tags()->sync([]);
        }
        if ($this->request->get('chefs')) {
            $this->item->chefs()->sync($this->request->get('chefs'));
        } else {
            $this->item->chefs()->sync([]);
        }

        $this->item->save();
    }
}
