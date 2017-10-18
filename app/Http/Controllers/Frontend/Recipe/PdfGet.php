<?php

namespace App\Http\Controllers\Frontend\Recipe;

use App\Models\Recipe;
use Barryvdh\DomPDF\Facade as PDF;

/**
 * Class PdfGet
 * @package App\Http\Controllers\Frontend\Recipe
 */
class PdfGet extends View
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
        $pdf = PDF::loadView('recipe.pdf', $options);

        return $pdf->download(str_slug($this->recipe->title, '_').'.pdf');
    }
}
