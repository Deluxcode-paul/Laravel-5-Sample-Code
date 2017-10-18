<?php

namespace App\Http\Controllers\Frontend\User\Profile\Account;

use App\Http\Controllers\Frontend\User\Profile\AbstractProfile;

class Delete extends AbstractProfile
{
    public function __invoke()
    {
        $this->currentUser->softDeleteByOwner();

        return redirect()->route('login');
    }
}
