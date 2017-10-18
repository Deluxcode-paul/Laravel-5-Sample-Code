<?php

namespace App\Http\Controllers\Frontend\User\Profile\ShoppingLists;

use App\Http\Controllers\Frontend\User\Profile\AbstractProfile;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Assets;

/**
 * Class View
 * @package App\Http\Controllers\Frontend\User\Profile\ShoppingLists
 */
class View extends AbstractProfile
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var integer
     */
    protected $currPage;

    /**
     * @var integer
     */
    protected $perPage;

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        $this->request = $request;
        $this->perPage = config('kosher.pagination.shopping_list');
        $this->currPage = $request->get('page', 1);

        $shoppingList = $this->currentUser->getShoppingList();

        $data = [];
        $data['page'] = $this->currPage;
        $data['paginator'] = $this->getPagination(
            $shoppingList->count(),
            $this->perPage,
            $this->currPage
        );
        $data['shoppingList'] = $shoppingList->forPage(
            $this->currPage,
            $this->perPage
        );

        Assets::group('frontend')->addJs('share/print.js');
        Assets::group('frontend')->addJs('user/profile/shopping_list.js');

        return view('user.profile.shopping_lists', $data);
    }

    /**
     * @param $totalCount
     * @param $perPage
     * @param $currPage
     * @return LengthAwarePaginator
     */
    protected function getPagination($totalCount, $perPage, $currPage)
    {
        $pagination = new LengthAwarePaginator([], $totalCount, $perPage, $currPage);
        $pagination->setPath('/' . $this->request->path());

        return $pagination;
    }
}
