<?php

namespace App\Components;

use App\Enums\RecipesSorting;
use App\Enums\Search;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;
use Request;
use URL;

/**
 * Class KosherHelper
 * @package App\Components
 */
final class KosherHelper
{
    /**
     * @var string Active class name
     */
    const ACTIVE_CLASS = 'active';

    /**
     * @param string|array $route
     * @param string $title
     * @param array $attributes
     * @return string
     */
    public function linkRoute($route, $title = '', $attributes = [])
    {
        $currentRoute = Request::route()->getName();

        $attributes = $this->prepareAttributes($attributes);

        if (is_array($route)) {
            $attributes['class'][] = in_array($currentRoute, $route) ? self::ACTIVE_CLASS : '';
            $url = route(array_shift($route));
        } else {
            $attributes['class'][] = ($currentRoute == $route) ? self::ACTIVE_CLASS : '';
            $url = route($route);
        }

        $attributes = $this->processAttributes($attributes);

        return $this->renderLink($url, $title, $attributes);
    }

    /**
     * @param string|array $url
     * @param string $title
     * @param array $attributes
     * @return string
     */
    public function link($url, $title = '', $attributes = [])
    {
        $currentUrl = url_locale(Request::path());

        $attributes = $this->prepareAttributes($attributes);

        if (is_array($url)) {
            $url = array_map('url', $url);
            $attributes['class'][] = in_array($currentUrl, $url) ? self::ACTIVE_CLASS : '';
            $url = array_shift($url);
        } else {
            $attributes['class'][] = ($currentUrl == url_locale($url)) ? self::ACTIVE_CLASS : '';
        }

        $attributes = $this->processAttributes($attributes);

        return $this->renderLink($url, $title, $attributes);
    }

    /**
     * @param array $attributes
     * @return array
     */
    private function prepareAttributes($attributes)
    {
        if (empty($attributes['class'])) {
            $attributes['class'] = [];
        } else {
            $attributes['class'] = explode(' ', $attributes['class']);
        }

        return $attributes;
    }

    /**
     * @param array $attributes
     * @return array
     */
    private function processAttributes($attributes)
    {
        $attributes['class'] = array_filter($attributes['class']);

        if (empty($attributes['class'])) {
            unset($attributes['class']);
        } else {
            $attributes['class'] = implode(' ', $attributes['class']);
        }

        return $attributes;
    }

    /**
     * @param string $url
     * @param string $title
     * @param array $attributes
     * @return HtmlString
     */
    private function renderLink($url, $title = '', $attributes = [])
    {
        $url = URL::toLocale($url, [], env('APP_SECURE', false));

        if (empty($title) && $title !== '') {
            $title = $url;
        }

        return $this->toHtmlString('<a href="' . $url . '"' . $this->attributes($attributes) . '>' . $title . '</a>');
    }

    /**
     * Build an HTML attribute string from an array.
     *
     * @param array $attributes
     *
     * @return string
     */
    private function attributes($attributes)
    {
        $html = [];

        foreach ((array) $attributes as $key => $value) {
            $element = $this->attributeElement($key, $value);
            if (! is_null($element)) {
                $html[] = $element;
            }
        }

        return count($html) > 0 ? ' ' . implode(' ', $html) : '';
    }

    /**
     * Build a single attribute element.
     *
     * @param string $key
     * @param string $value
     *
     * @return string
     */
    private function attributeElement($key, $value)
    {
        if (is_numeric($key)) {
            $key = $value;
        }

        if (! is_null($value)) {
            return $key . '="' . e($value) . '"';
        }
    }

    /**
     * Transform the string to an Html serializable object
     *
     * @param $html
     *
     * @return \Illuminate\Support\HtmlString
     */
    private function toHtmlString($html)
    {
        return new HtmlString($html);
    }

    /**
     * @return array
     */
    public function getFeaturedRecipesUrl()
    {
        return route('recipes.list').'?'.Search::P_FEATURED.'=on';
    }

    /**
     * @param string $inquiry_type
     * @return string
     */
    public function getContactUrl($inquiry_type = '')
    {
        $url = route('contact');
        $params = [];
        if ($inquiry_type) {
            $params['inquiry_type'] = $inquiry_type;
        }
        if (Auth::check()) {
            $user = Auth::user();
            $params['email'] = $user->email;
            $params['full_name'] = $user->fullName;
        }

        if (count($params)) {
            $query = [];
            foreach ($params as $key => $value) {
                $query[] = $key.'='.$value;
            }
            $url = $url.'?'.implode('&', $query);
        }

        return $url;
    }

    /**
     * @return string
     */
    public function getSearchKeywordParameter()
    {
        return Search::P_KEYWORD;
    }

    /**
     * @param $route
     * @param $keyword
     * @return string
     */
    public function getSearchSectionUrl($route, $keyword)
    {
        return route($route).'?'.Search::P_KEYWORD.'='.$keyword;
    }

    /**
     * @return string
     */
    public function getNewestRecipesUrl()
    {
        return route('recipes.list').'?'.Search::P_SORT.'='.RecipesSorting::MOST_RECENT;
    }

    /**
     * Trim titles for breadcrumbs
     *
     * @param string $text
     * @param int $width
     * @param string $marker
     * @return string
     */
    public function trimForBreadcrumbs($text, $width = 50, $marker = '[...]')
    {
        return mb_strimwidth($text, 0, $width, $marker);
    }

    /**
     * @param integer $id
     * @return string
     */
    public function getRecipeUrlById($id)
    {
        $recipe = Recipe::find($id);
        if ($recipe) {
            return $recipe->getUrl();
        }

        return '';
    }

    /**
     * @param string $value
     * @return string
     */
    public function filterWysiwygContent($value)
    {
        return trim(strip_tags(str_replace('&nbsp;', '', $value), '<img><embed><object><iframe>'));
    }
}
