<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Review' => 'App\Policies\ReviewPolicy',
        'App\Models\ReviewComment' => 'App\Policies\ReviewCommentPolicy',
        'App\Models\RecipeQuestion' => 'App\Policies\RecipeQuestionPolicy',
        'App\Models\RecipeAnswer' => 'App\Policies\RecipeAnswerPolicy',
        'App\Models\ArticleComment' => 'App\Policies\ArticleCommentPolicy',
        'App\Models\ArticleReply' => 'App\Policies\ArticleReplyPolicy',
        'App\Models\GeneralQuestion' => 'App\Policies\GeneralQuestionPolicy',
        'App\Models\GeneralAnswer' => 'App\Policies\GeneralAnswerPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
