<?php

namespace App\Models;

use App\Contracts\HomeBanner;
use App\Contracts\MediaSlide;
use App\Contracts\Searchable;
use App\Contracts\Taggable;
use App\Contracts\VideoOwner;
use App\Enums\Search;
use App\Facades\BfmImage;
use App\Enums\RecipeDifficulty;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class Recipe
 *
 * @package App\Models
 *
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $image
 * @property integer $user_id
 * @property string $description
 * @property integer $cook_time
 * @property integer $serving
 * @property integer $preference_id
 * @property integer $difficulty
 * @property integer $blessing_type_id
 * @property integer $rating
 * @property boolean $is_featured
 * @property boolean $is_banner
 * @property boolean $is_archive
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Allergen[] $allergens
 * @property-read BlessingType $blessingType
 * @property-read RecipeCategory[] $categories
 * @property-read Cuisine[] $cuisines
 * @property-read Diet[] $diets
 * @property-read Holiday[] $holidays
 * @property-read Preference $preference
 * @property-read Source[] $sources
 * @property-read Tag[] $tags
 * @property-read User $user
 * @method static Recipe whereId($value)
 * @method static Recipe whereTitle($value)
 * @method static Recipe whereUserId($value)
 * @method static Recipe whereDescription($value)
 * @method static Recipe whereCookTime($value)
 * @method static Recipe whereServing($value)
 * @method static Recipe wherePreferenceId($value)
 * @method static Recipe whereDifficulty($value)
 * @method static Recipe whereBlessingTypeId($value)
 * @method static Recipe whereIsFeatured($value)
 * @method static Recipe whereIsBanner($value)
 * @method static Recipe whereIsArchive($value)
 * @method static Recipe whereCreatedAt($value)
 * @method static Recipe whereUpdatedAt($value)
 * @method static Recipe enabled()
 * @method static Recipe featured()
 * @mixin \Eloquent
 */
class Recipe extends AbstractRecipe implements VideoOwner, Taggable, MediaSlide, HomeBanner, Searchable
{
    const COUNT_RELATED_RECIPES = 4;
    const COUNT_RELATED_ARTICLES = 4;
    const COUNT_PREVIEW_TITLE_WORDS = 8;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'image',
        'user_id',
        'description',
        'cook_time',
        'serving',
        'preference_id',
        'difficulty',
        'blessing_type_id',
        'is_featured',
        'is_banner',
        'is_archive',
        'slug',
    ];

    /**
     * The attributes that should be processed as images.
     *
     * @var array
     */
    protected $images = [
        'image'
    ];

    /**
     * @var array
     */
    protected $appends = [
        'icon',
        'creator',
        'creatorUrl',
        'cookingTime',
        'listImage',
        'detailUrl',
        'hasVideo'
    ];

    /**
     * @return string
     */
    public function getTagsString()
    {
        return $this->tags->pluck('title')->implode(Tag::SEPARATOR);
    }

    /**
     * @param string $query
     * @return array
     */
    public function getIngredientGroups($query)
    {
        $groupsCollection = DB::table('recipe_ingredients')
            ->join('ingredient_groups', 'ingredient_groups.id', '=', 'recipe_ingredients.ingredient_group_id')
            ->where('recipe_ingredients.recipe_id', $this->id);

        if (!empty($query)) {
            $groupsCollection->where('ingredient_groups.title', 'LIKE', '%' . $query . '%');
        }

        $groups = $groupsCollection->pluck('ingredient_groups.title', 'ingredient_groups.id')->all();

        return array_filter($groups);
    }

    /**
     * @return mixed
     */
    public function getMedia()
    {
        $media = $this->galleryImages()->get();
        $videos = $this->videos()->get();
        foreach ($videos as $video) {
            $media->push($video);
        }

        return $media->shuffle()->prepend($this);
    }

    /**
     * @return string
     */
    public function getPrintUrl()
    {
        return route('recipe.print', ['id' => $this->id]);
    }

    /**
     * @return string
     */
    public function getPdfUrl()
    {
        return route('recipe.pdf', ['id' => $this->id]);
    }

    /**
     * @return string
     */
    public function getDifficultyLabel()
    {
        return RecipeDifficulty::label($this->difficulty);
    }

    /**
     * @return mixed
     */
    public function getHolidaysLabel()
    {
        return $this->holidays->implode('title', ', ');
    }

    /**
     * @return mixed
     */
    public function getCuisinesLabel()
    {
        return $this->cuisines->implode('title', ', ');
    }

    /**
     * @return mixed
     */
    public function getSourceLabel()
    {
        return $this->sources->implode('title', ', ');
    }

    /**
     * @return mixed
     */
    public function getDietsLabel()
    {
        return $this->diets->implode('title', ', ');
    }

    /**
     * @return mixed
     */
    public function getFreeOFLabels()
    {
        return $this->diets->implode('title', ', ');
    }

    /**
     * @return mixed
     */
    public function getFreeOfCount()
    {
        return $this->diets->implode('title', ', ');
    }

    /**
     * @return mixed
     */
    public function getIngredientsCount()
    {
        $tree = $this->getIngredientsGroupTree();
        $counts = $tree->map(function ($item) {
            return $item->count();
        });
        return $counts->sum();
    }

    /**
     * @return static
     */
    public function getIngredientsGroupTree()
    {
        $groupsCollection = DB::table('recipe_ingredients')
            ->select(
                'ingredients.title as ingredient_title',
                'ingredients.id as ingredient_index',
                'ingredient_groups.*',
                'recipe_ingredients.*'
            )
            ->join('ingredients', 'ingredients.id', '=', 'recipe_ingredients.ingredient_id')
            ->join('ingredient_groups', 'ingredient_groups.id', '=', 'recipe_ingredients.ingredient_group_id')
            ->where('recipe_ingredients.recipe_id', $this->id);

        return $groupsCollection->get()->groupBy('title');
    }

    /**
     * @return Collection|static[]
     */
    public function getRelatedRecipes()
    {
        $selectedId = [$this->id];
        $count = self::COUNT_RELATED_RECIPES;
        $result = new Collection();

        $queries = $this->getRecipesQueries();

        foreach ($queries as $query) {
            /** @var \Illuminate\Database\Query\Builder $query */
            $res = $query
                ->whereNotIn('recipes.id', $selectedId)
                ->distinct()
                ->limit($count)
                ->get();

            $result = $res->merge($result)->unique();

            $selectedId = array_merge(
                $selectedId,
                $result->map(function ($item) {
                    return $item->id;
                })->toArray()
            );
            $selectedId = array_unique($selectedId);

            if ($result->count() >= self::COUNT_RELATED_RECIPES) {
                break;
            } else {
                $count -= $res->count();
            }
        }

        $ids = $result->map(function ($item) {
            return $item->id;
        });

        return Recipe::whereIn('id', $ids)->orderBy('updated_at')->get();
    }

    /**
     * @return array
     */
    private function getRecipesQueries()
    {
        $categories = $this->categories->map(function ($item) {
            return [$item->id];
        });
        $holidays = $this->holidays->map(function ($item) {
            return [$item->id];
        });
        $tags = $this->tags->map(function ($item) {
            return [$item->id];
        });

        $queries = [];

        // Show the recipes of the same category, holiday, keywords;
        $queries [] = DB::table('recipes')
            ->select('recipes.id')
            ->join('recipe_has_category', 'recipes.id', '=', 'recipe_has_category.recipe_id')
            ->join('recipe_has_holiday', 'recipes.id', '=', 'recipe_has_holiday.recipe_id')
            ->join('recipe_has_tag', 'recipes.id', '=', 'recipe_has_tag.recipe_id')
            ->whereIn('recipe_has_category.category_id', $categories)
            ->whereIn('recipe_has_holiday.holiday_id', $holidays)
            ->whereIn('recipe_has_tag.tag_id', $tags);

        // Show the recipes of the same category, holiday;
        $queries [] = DB::table('recipes')
            ->select('recipes.id')
            ->join('recipe_has_category', 'recipes.id', '=', 'recipe_has_category.recipe_id')
            ->join('recipe_has_holiday', 'recipes.id', '=', 'recipe_has_holiday.recipe_id')
            ->whereIn('recipe_has_category.category_id', $categories)
            ->whereIn('recipe_has_holiday.holiday_id', $holidays);

        // Show the recipes of the same category or holiday;
        $queries [] = DB::table('recipes')
            ->select('recipes.id')
            ->join('recipe_has_category', 'recipes.id', '=', 'recipe_has_category.recipe_id')
            ->join('recipe_has_holiday', 'recipes.id', '=', 'recipe_has_holiday.recipe_id')
            ->orWhere(function ($query) use ($categories, $holidays) {
                $query->whereIn('recipe_has_category.category_id', $categories)
                    ->orWhereIn('recipe_has_holiday.holiday_id', $holidays);
            });

        // Show featured recipes
        $queries [] = DB::table('recipes')
            ->select('recipes.id')
            ->where('recipes.is_featured', 1);

        // Show any recipes
        $queries [] = DB::table('recipes')
            ->select('recipes.id');

        return $queries;
    }

    /**
     * @return array
     */
    private function getArticlesQueries()
    {
        $tags = $this->tags->map(function ($item) {
            return [$item->id];
        });

        $queries = [];

        // Show the recipes of the same category, holiday, keywords;
        $queries [] = DB::table('articles')
            ->select('articles.id')
            ->join('article_has_tag', 'articles.id', '=', 'article_has_tag.article_id')
            ->whereIn('article_has_tag.tag_id', $tags);

        // Show the recipes of the same category, holiday;
        $queries [] = DB::table('articles')
            ->select('articles.id');

        return $queries;
    }

    /**
     * @return array
     */
    public function getRelatedArticles()
    {
        $selectedId = [];
        $count = self::COUNT_RELATED_ARTICLES;
        $result = new Collection();

        $queries = $this->getArticlesQueries();

        foreach ($queries as $query) {
            $res = $query
                ->whereNotIn('articles.id', $selectedId)
                ->limit($count)
                ->get();

            $result = $res->merge($result)->unique();

            $selectedId = $result->map(function ($item) {
                return [$item->id];
            })->toArray();

            if ($result->count() >= self::COUNT_RELATED_ARTICLES) {
                break;
            } else {
                $count -= $res->count();
            }
        }

        $ids = $result->map(function ($item) {
            return $item->id;
        });

        return Article::whereIn('id', $ids)->orderBy('updated_at')->get();
    }

    /**
     * Return list image
     * @return string
     */
    public function getListImageAttribute()
    {
        return $this->getImage('recipe_list_item');
    }

    /**
     * @param string $size
     * @return string
     */
    public function getImage($size = 'recipe_list_item')
    {
        return BfmImage::init($this->image)->get($size);
    }

    /**
     * @param string $size
     * @param int $blur
     * @return string
     */
    public function getBlurredImage($size = 'recipe_list_item', $blur = 60)
    {
        return BfmImage::init($this->image)->blur($blur)->get($size);
    }

    /**
     * Return image
     * @return mixed
     */
    public function getIconAttribute()
    {
        $icon = '';

        if (isset($this->user) && $this->user->isTopChef()) {
            $icon = 'top_chef';
        }

        return $icon;
    }

    /**
     * Return recipe creator name
     * @return mixed
     */
    public function getCreatorAttribute()
    {
        return $this->user->fullName;
    }

    /**
     * @return string
     */
    public function getCreatorUrl()
    {
        return $this->user->publicProfileUrl;
    }

    /**
     * @return string
     */
    public function getCreatorImage()
    {
        return $this->user->getImage();
    }

    /**
     * Return recipe creator name
     * @return mixed
     */
    public function getCreatorUrlAttribute()
    {
        return $this->user->publicProfileUrl;
    }

    /**
     * Return formatted cooking time
     */
    public function getCookingTimeAttribute()
    {
        $time = $this->cook_time;

        if ($time < 1) {
            $result = '';
        } elseif ($time < 60) {
            $result = sprintf('%02d m', $time);
        } else {
            $hours = floor($time / 60);
            $minutes = ($time % 60);
            if ($minutes == 0) {
                $result = sprintf('%d h', $hours);
            } elseif ($minutes == 30) {
                $result = sprintf('%d.5 h', $hours);
            } else {
                $result = sprintf('%d h %02d m', $hours, $minutes);
            }
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getDetailUrlAttribute()
    {
        return $this->getUrl();
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return route('recipe.view', [$this->id, $this->slug]);
    }

    /**
     * @return string
     */
    public function getShortUrl()
    {
        return route('recipe.view.short', [$this->id]);
    }

    /**
     * @return string
     */
    public function getUrlText()
    {
        return trans('pages/video.links.view_full_recipe');
    }


    /**
     * @param int $length
     * @return string
     */
    public function getPreviewTitle($length = self::COUNT_PREVIEW_TITLE_WORDS)
    {
        return Str::words($this->title, $length);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return str_limit(strip_tags($this->description), 300);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return trans('common.video_owner_types.recipe');
    }

    /**
     * @return string
     */
    public function getCreator()
    {
        return $this->getCreatorAttribute();
    }

    /**
     * @return string
     */
    public function getBreadcrumb()
    {
        return 'recipe';
    }

    /**
     * @return bool
     */
    public function canBeSaved()
    {
        return true;
    }

    public function isVideo()
    {
        return false;
    }

    public function getDetailPageUrl()
    {
        return $this->getUrl();
    }

    /**
     * @return bool
     */
    public function hasCookingImages()
    {
        return DB::table('recipes')
            ->join('recipe_cooking', 'recipe_cooking.recipe_id', '=', 'recipes.id')
            ->join('cooking_steps', 'cooking_steps.cooking_id', '=', 'recipe_cooking.id')
            ->where('recipes.id', $this->id)
            ->whereNotNull('cooking_steps.image')
            ->count();
    }

    public function getReviewsPage()
    {
        $perPage = config('kosher.pagination.recipe_detail_page_reviews');
        return Review::forRecipe($this->id)
            ->recent()
            ->paginate($perPage);
    }

    public function getQuestionsPage()
    {
        $perPage = config('kosher.pagination.recipe_detail_page_questions');
        return RecipeQuestion::forRecipe($this->id)
            ->recent()
            ->paginate($perPage);
    }

    /**
     * @return int
     */
    public function getCookTimeHours()
    {
        return floor($this->cook_time / 60);
    }

    /**
     * @return int
     */
    public function getCookTimeMinutes()
    {
        return intval($this->cook_time % 60);
    }

    /**
     * @return mixed
     */
    public function getHasVideoAttribute()
    {
        return boolval($this->videos()->count() > 0);
    }

    /**
     * @return string
     */
    public function getBannerHeading()
    {
        return trans('pages/home.headings.whats');
    }

    /**
     * @return string
     */
    public function getBannerSubheading()
    {
        return trans('pages/home.headings.cooking');
    }

    /**
     * @return string
     */
    public function getBannerCategory()
    {
        $categoriesCount = $this->categories->count();
        if ($categoriesCount) {
            if ($categoriesCount > 1) {
                return '';
            } else {
                return $this->categories->first()->title;
            }
        } else {
            return '';
        }
    }

    /**
     * @return string
     */
    public function getBannerTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getBannerDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getBannerUrl()
    {
        return $this->detailUrl;
    }

    /**
     * @return string
     */
    public function getBannerButton()
    {
        return trans('pages/home.buttons.view_recipe');
    }

    /**
     * @param string $size
     * @return string
     */
    public function getBannerPicture($size = 'home_banner')
    {
        return $this->getImage($size);
    }

    /**
     * @return boolean
     */
    public function isRecipe()
    {
        return true;
    }

    /**
     * @param string $keyword
     * @return string
     */
    public function getSearchUrl($keyword)
    {
        return route('search.recipes') . '?' . Search::P_KEYWORD . '=' . urlencode(trim($keyword));
    }

    /**
     * @return string
     */
    public function generateSlug()
    {
        return str_slug($this->title, '-');
    }

    /**
     * @return boolean
     */
    public function isSaved()
    {
        if (Auth::guest()) {
            return false;
        } else {
            $count = DB::table('recipe_boxes')
                ->where('user_id', Auth::user()->id)
                ->where('recipe_id', $this->id)
                ->count();
            return $count > 0;
        }
    }
}
