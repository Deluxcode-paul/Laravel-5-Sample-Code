<?php
return [
    'pagination' => [
        'per_page_selector' => [12, 24, 36],
        'mega_menu_categories' => 7,
        'featured_categories' => 4,
        'featured_recipes' => 12,
        'mega_menu_holidays' => 4,
        'default_per_page' => 12,
        'recipes_public_profile' => 8,
        'recipes_list' => 12,
        'articles_public_profile' => 6,
        'videos_public_profile' => 8,
        'comments_public_profile' => 4,
        'shopping_list' => 10,
        'home_banner_items' => 15,
        'home_newest_recipes' => 14,
        'home_archived_recipes' => 4,
        'home_popular_recipes' => 3,
        'home_shared_recipes' => 3,
        'home_chefs' => 5,
        'home_articles' => 4,
        'home_community' => 3,
        'lifestyle_banner_articles' => 15,
        'lifestyle_articles' => 12,
        'watch_banner_videos' => 15,
        'watch_shows' => 10,
        'search_no_results_chefs' => 3,
        'search_no_results_articles' => 3,
        'search_no_results_videos' => 3,
        'search_no_results_recipes' => 3,
        'community_popular_items' => 5,
        'community_popular_tags' => 10,
        'recipe_detail_page_reviews' => 3,
        'recipe_detail_page_questions' => 3,
        'article_detail_page_comments' => 3,
        'article_related' => 6,
        'generate_meal_no_results' => 4
    ],
    'cache_expiration_time' => 1,
    'search_route' => '/search',
    'cta_limit' => 3,
    'max_tags_ask_question' => 3,
    'max_chefs_ask_question' => 3,
    'date_formats' => [
        'FjY' => 'F j, Y'
    ],
    'validation' => [
        'img' => [
            'size' => 5120,
            'accept' => '.jpg, .jpeg, .gif, .png'
        ]
    ],
    'sitemap_date' => '2016-09-19T09:48:00+02:00',
    'links' => [
        'learn' => env('URL_LEARN', 'learn'),
        'what_is_kosher' => env('URL_WHAT_IS_KOSHER', ''),
        'new_to_kosher' => env('URL_NEW_TO_KOSHER', ''),
        'about' => env('URL_ABOUT', 'about'),
        'faq' => env('URL_FAQ', 'faq'),
        'terms' => env('URL_TERMS', 'terms'),
        'privacy' => env('URL_PRIVACY', 'privacy')
    ],
    'social' => [
        'facebook' => env('URL_SOCIAL_FACEBOOK', 'https://www.facebook.com/kosherdotcom'),
        'instagram' => env('URL_SOCIAL_INSTAGRAM', 'https://www.instagram.com/kosherdotcom/'),
        'pinterest' => env('URL_SOCIAL_PINTEREST', 'https://www.pinterest.com/kosherdotcom/'),
        'youtube' => env('URL_SOCIAL_YOUTUBE', 'https://www.youtube.com/channel/UCBlIwW_NkAlRUj6sdGwAfQg'),
        'vimeo' => env('URL_SOCIAL_VIMEO', '')
    ],
];
