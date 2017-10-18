<?php

namespace App\Http\Controllers\Frontend\User\Profile\Account\Save;

use App\Http\Controllers\Frontend\User\Profile\AbstractProfile;
use App\Facades\BfmImage;
use App\Http\Requests\Frontend\User\Profile\Account\SaveImageRequest;

/**
 * Class Image
 * @package App\Http\Controllers\Frontend\User\Profile\Account\Save
 */
class Image extends AbstractProfile
{
    /**
     * @param SaveImageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(SaveImageRequest $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->getPathname();
            $imageName = $image->getClientOriginalName();
            $publicPath = public_path('files'). '/'. $imageName;
            BfmImage::orientateAndSave($imagePath, $publicPath);

            $sourceFilePath = BfmImage::getPublicPath('files/'.$imageName);
            $targetFilePath = BfmImage::generateFullPath($imageName);

            $this->currentUser->image = BfmImage::save($sourceFilePath, $targetFilePath);
            $this->currentUser->save();
        }

        return redirect()->route('user.profile.account.view');
    }
}
