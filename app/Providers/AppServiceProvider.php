<?php

namespace App\Providers;

use App\Facades\BfmImage;
use App\Facades\BfmVideo;
use App\Facades\KosherHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use View;
use App\Enums\UserRole;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $view->with('currentUser', Auth::user());
            }

            if (\Request::route()) {
                $view->with('currentRoute', \Request::route()->getName());
            }

            $roles = [
                'admin'             => UserRole::label(UserRole::ROLE_ADMIN),
                'user'              => UserRole::label(UserRole::ROLE_USER),
                'community_chef'    => UserRole::label(UserRole::ROLE_COMMUNITY_CHEF),
                'professional_chef' => UserRole::label(UserRole::ROLE_PROFESSIONAL_CHEF),
                'chefs' => [
                    UserRole::label(UserRole::ROLE_COMMUNITY_CHEF),
                    UserRole::label(UserRole::ROLE_PROFESSIONAL_CHEF)
                ]
            ];

            $view->with('roles', $roles);
        });

        Validator::extend('bfm_image', function ($attribute, $value, $parameters, $validator) {
            $fullPath = BfmImage::generateFullPath($value);
            if (File::exists($fullPath)) {
                return true;
            }

            $filePath = BfmImage::getPublicPath($value);

            return File::exists($filePath) && in_array(File::mimeType($filePath), BfmImage::getAllowedMimeTypes());
        });

        Validator::extend('kosher_video', function ($attribute, $value, $parameters, $validator) {
            return in_array(BfmVideo::getType($value), BfmVideo::getValidTypes());
        });

        Validator::extend('kosher_required_wysiwyg', function ($attribute, $value, $parameters, $validator) {
            $filtered = KosherHelper::filterWysiwygContent($value);

            return !empty($filtered);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
