<?php

namespace App\Http\Controllers\Backend\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class Tags
 * @package App\Http\Controllers\Backend\Ajax
 */
class Tags extends Controller
{
    /**
     * @param Request $request
     * @return string
     */
    public function __invoke(Request $request)
    {
        $response = [];
        $query = $request->get('query');
        $model = urldecode($request->get('model'));
        $attribute = $request->get('attribute');

        if (!empty($model) && !empty('attribute')) {
            if (empty($query)) {
                $tags = $model::all();
            } else {
                $tags = $model::where($attribute, 'LIKE', '%' . $query . '%')->get();
            }

            foreach ($tags as $tag) {
                $response[] = [
                    'id' => $tag->$attribute,
                    'text' => $tag->$attribute
                ];
            }
        }

        return json_encode($response);
    }
}
