<?php

namespace App\Http\Controllers\Backend\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class Checkbox
 * @package App\Http\Controllers\Backend\Ajax
 */
class Checkbox extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $result = ['status' => 'error'];
        $id = intval($request->input('id', 0));
        $model = $request->input('model', '');
        if (class_exists($model)) {
            $entry = $model::find($id);
            if ($entry) {
                $field = $request->input('field', '');
                $value = boolval($request->input('value', 0));
                if (isset($entry->{$field})) {
                    $entry->{$field} = !$value;
                    if ($entry->save()) {
                        $result['status'] = 'ok';
                    }
                }
            }
        }

        return response()->json($result);
    }
}
