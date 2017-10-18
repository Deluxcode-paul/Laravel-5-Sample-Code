<?php

namespace App\Enums;

class CommunityType extends AbstractEnum
{
    /**
     * @var string
     */
    const RECIPE_REVIEW    = 'recipe-review';
    const REVIEW_COMMENT   = 'review-comment';
    const RECIPE_QUESTION  = 'recipe-question';
    const RECIPE_ANSWER    = 'recipe-answer';
    const ARTICLE_COMMENT  = 'article-comment';
    const ARTICLE_REPLY    = 'article-reply';
    const GENERAL_QUESTION = 'community-question';
    const GENERAL_ANSWER   = 'community-answer';
}
