<?php

namespace App\Enums;

/**
 * Class ContactInquiryTypes
 * @package App\Enums
 */
class ContactInquiryTypes extends AbstractEnum
{
    /**
     * @var string
     */
    const CLAIM_PROFILE = 'claim-profile';
    const GENERAL_SUPPORT = 'general-support';
    const SUGGEST_ARTICLE = 'suggest-an-article';
    const SUGGEST_CHEF = 'suggest-a-chef';
    const SUGGEST_RECIPE = 'suggest-a-recipe';
    const SUGGEST_VIDEO = 'suggest-a-video';

    /**
     * @var array
     */
    protected static $labels = [
        self::CLAIM_PROFILE => 'enums.inquiry_type.claim_profile',
        self::GENERAL_SUPPORT => 'enums.inquiry_type.general_support',
        self::SUGGEST_ARTICLE => 'enums.inquiry_type.suggest_article',
        self::SUGGEST_CHEF => 'enums.inquiry_type.suggest_chef',
        self::SUGGEST_RECIPE => 'enums.inquiry_type.suggest_recipe',
        self::SUGGEST_VIDEO => 'enums.inquiry_type.suggest_video',
    ];
}
