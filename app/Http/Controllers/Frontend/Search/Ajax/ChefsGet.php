<?php

namespace App\Http\Controllers\Frontend\Search\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Chef;
use Illuminate\Http\Request;

/**
 * Class ChefsGet
 * @package App\Http\Controllers\Frontend\Search\Ajax
 */
class ChefsGet extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $word = $request->get('w');

        $result = Chef::where(function ($query) use ($word) {
            $query->where('first_name', 'like', '%' . $word . '%')
                ->orWhere('last_name', 'like', '%' . $word . '%');
        })->get()->pluck('fullName', 'id');
 
        return response()->json($result);
    }
}
