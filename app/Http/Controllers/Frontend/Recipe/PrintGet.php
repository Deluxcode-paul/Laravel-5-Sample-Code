<?php

namespace App\Http\Controllers\Frontend\Recipe;

use App\Models\Recipe;

/**
 * Class PrintGet
 * @package App\Http\Controllers\Frontend\Recipe
 */
class PrintGet extends View
{
    /**
     * @param $id
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke($id, $slug = '')
    {
        $this->recipe = Recipe::find($id);
        if (empty($this->recipe)) {
            abort(404);
        }

        return $this->init();
    }

    /**
     * @param array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function render($options)
    {
        return view('recipe.print', $options);
    }
}
