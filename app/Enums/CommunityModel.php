<?php

namespace App\Enums;

class CommunityModel extends AbstractEnum
{
    /**
     * @var string
     */
    const RECIPE_REVIEW    = 'App\Models\Review';
    const REVIEW_COMMENT   = 'App\Models\ReviewComment';
    const RECIPE_QUESTION  = 'App\Models\RecipeQuestion';
    const RECIPE_ANSWER    = 'App\Models\RecipeAnswer';
    const ARTICLE_COMMENT  = 'App\Models\ArticleComment';
    const ARTICLE_REPLY    = 'App\Models\ArticleReply';
    const GENERAL_QUESTION = 'App\Models\GeneralQuestion';
    const GENERAL_ANSWER   = 'App\Models\GeneralAnswer';
}
