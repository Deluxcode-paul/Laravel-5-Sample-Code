<?php

namespace App\Http\Controllers\Frontend\Community;

use App\Http\Controllers\Controller;
use App\Http\Traits\Community;
use App\Models\Tag;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Facades\DB;
use Assets;

/**
 * Class AbstractDetails
 * @package App\Http\Controllers\Frontend\Community
 */
abstract class AbstractEdit extends Controller
{
    use Community;

    /**
     * @var
     */
    protected $item;

    /**
     * @return array
     */
    protected function getTemplateVariables()
    {
        $data = [];

        $data['tags']  = $this->getTags();
        $data['chefs'] = $this->getChefs();
        $data['item']  = $this->item;

        return $data;
    }
}
