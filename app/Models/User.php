<?php

namespace App\Models;

use App\Enums\UserRole;
use App\Facades\BfmImage;
use App\Notifications\EmailConfirmation;
use App\Notifications\ResetPassword;
use Backpack\CRUD\CrudTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\DatabaseNotification as DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 *
 * @package App\Models
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $image
 * @property string $bio
 * @property string $city
 * @property integer $country_id
 * @property integer $state_id
 * @property string $place_of_work
 * @property string $status
 * @property string $facebook
 * @property string $instagram
 * @property string $twitter
 * @property string $youtube
 * @property string $pinterest
 * @property string $website
 * @property boolean $is_featured
 * @property boolean $is_subscribed
 * @property string $password
 * @property string $remember_token
 * @property boolean $is_confirmed
 * @property string $confirmation_code
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read DatabaseNotification[] $notifications
 * @property-read DatabaseNotification[] $unreadNotifications
 * @method static User whereId($value)
 * @method static User whereName($value)
 * @method static User whereEmail($value)
 * @method static User wherePassword($value)
 * @method static User whereRememberToken($value)
 * @method static User whereCreatedAt($value)
 * @method static User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends AppModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;
    use CrudTrait;
    use Notifiable;
    use SoftDeletes;
    use HasRoles;

    const SHORT_BIO_COUNT_WORDS = 30;

    const SEPARATOR =", ";

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that should be processed as images.
     *
     * @var array
     */
    protected $images = [
        'image'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'image',
        'bio',
        'city',
        'country_id',
        'state_id',
        'place_of_work',
        'status',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'pinterest',
        'website',
        'email',
        'is_featured',
        'password',
        'is_confirmed',
        'confirmation_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'listImage',
        'activityImage',
        'publicProfileUrl',
        'fullName',
        'location'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function allergens()
    {
        return $this->belongsToMany(
            'App\Models\Allergen',
            'user_has_allergen',
            'user_id',
            'allergen_id'
        )->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function diets()
    {
        return $this->belongsToMany(
            'App\Models\Diet',
            'user_has_diet',
            'user_id',
            'diet_id'
        )->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipes()
    {
        return $this->hasMany('App\Models\Recipe');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany('App\Models\Article');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos()
    {
        return $this->hasMany('App\Models\Video');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function recipeBox()
    {
        return $this->belongsToMany(
            'App\Models\Recipe',
            'recipe_boxes',
            'user_id',
            'recipe_id'
        )->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state()
    {
        return $this->belongsTo('App\Models\State');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    /**
     * Return shopping list for current user
     * @param array $recipes
     * @return mixed
     */
    public function getShoppingList($recipes = [])
    {
        $query = ShoppingList::where('user_id', $this->id)->orderBy('updated_at', 'desc');
        if (count($recipes)) {
            $query->whereIn('recipe_id', $recipes);
        }

        $results = [];
        $lists = $query->get();
        foreach ($lists as $list) {
            $results[$list->recipe_id]['id'] = $list->recipe_id;
            $results[$list->recipe_id]['title'] = $list->recipe->title;
            $results[$list->recipe_id]['detailUrl'] = $list->recipe->detailUrl;
            $results[$list->recipe_id]['updated_at'] = $list->updated_at;

            if (!isset($results[$list->recipe_id]['ingredients'])) {
                $results[$list->recipe_id]['ingredients'] = collect();
            }
            $ingredient = new \stdClass() ;
            $ingredient->title = $list->ingredient->description;
            $ingredient->shopping_list_id = $list->id;
            $results[$list->recipe_id]['ingredients']->push($ingredient);
        }

        $items = collect();
        foreach ($results as $result) {
            $item = new \stdClass() ;
            $item->id = $result['id'];
            $item->title = $result['title'];
            $item->ingredients = $result['ingredients'];
            $item->detailUrl = $result['detailUrl'];
            $item->updated_at = $result['updated_at'];
            $items->push($item);
        }

        return $items;
    }

    /**
     * Delete recipes from shopping list
     * @param array $recipes
     * @return mixed
     */
    public function deleteRecipesFromShoppingList(array $recipes)
    {
        return DB::table('shopping_lists')
            ->where('user_id', $this->id)
            ->whereIn('recipe_id', $recipes)
            ->delete();
    }

    /**
     * Delete ingredient from shopping list
     * @param $ingredient
     * @return mixed
     */
    public function deleteIngredientFromShoppingList($ingredient)
    {
        return DB::table('shopping_lists')
            ->where('id', $ingredient)
            ->delete();
    }

    /**
     * Checks ingredient owner
     * @param $ingredient
     * @return bool
     */
    public function checkIngredientOwner($ingredient)
    {
        return DB::table('shopping_lists')
            ->where('user_id', $this->id)
            ->where('id', $ingredient)
            ->count() ? true : false;
    }

    /**
     * Soft delete account by its owner
     */
    public function softDeleteByOwner()
    {
        Auth::logout();

        $this->delete();
    }

    /**
     * @param $allergenId
     * @return mixed
     */
    public function hasAllergen($allergenId)
    {
        return $this->allergens->contains($allergenId);
    }

    /**
     * @param $dietId
     * @return mixed
     */
    public function hasDiet($dietId)
    {
        return $this->diets->contains($dietId);
    }

    /**
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * @return void
     */
    public function sendEmailConfirmationNotification()
    {
        $this->notify(new EmailConfirmation());
    }

    /**
     * @param string $size
     * @return mixed
     */
    public function getImage($size = 'user_avatar')
    {
        if (empty($this->image) || BfmImage::isLost($this->image)) {
            return BfmImage::init('user_avatar.png')->placeholder()->get($size);
        } else {
            return BfmImage::init($this->image)->get($size);
        }
    }

    /**
     * @return mixed
     */
    public function getListImageAttribute()
    {
        return $this->getImage('user_search');
    }

    /**
     * @return mixed
     */
    public function getActivityImageAttribute()
    {
        return $this->getImage('user_activity');
    }

    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        return implode(' ', array_filter([$this->first_name, $this->last_name]));
    }

    /**
     * @return string
     */
    public function getProfileUrlAttribute()
    {
        return route('user.profile.account.view');
    }

    /**
     * @return string
     */
    public function getPublicProfileUrlAttribute()
    {
        return route('user.view', ['user' => $this->id]);
    }

    /**
     * @return string
     */
    public function getLocationAttribute()
    {
        $country = ($this->country_id && $this->country) ? $this->country->title : '';
        $state = ($this->state_id && $this->state) ? $this->state->title : '';

        return implode(', ', array_filter([$this->city, $state, $country]));
    }

    /**
     * @return string
     */
    public function getBioShortAttribute()
    {
        return Str::words($this->bio, self::SHORT_BIO_COUNT_WORDS);
    }

    /**
     * Scope for chefs
     * @return  mixed
     */
    public function scopeChefs($query)
    {
        $query
            ->join('role_users', 'users.id', '=', 'role_users.user_id')
            ->whereIn('role_users.role_id', [UserRole::ROLE_COMMUNITY_CHEF, UserRole::ROLE_PROFESSIONAL_CHEF]);
        return $query;
    }

    /**
     * Scope for featured data
     * @return  mixed
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for random data
     * @param $query
     * @return mixed
     */
    public function scopeRandom($query)
    {
        return $query->orderBy(DB::raw('RAND()'));
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole(UserRole::label(UserRole::ROLE_ADMIN));
    }

    /**
     * @return bool
     */
    public function isCommunityChef()
    {
        return $this->hasRole(UserRole::label(UserRole::ROLE_COMMUNITY_CHEF));
    }

    /**
     * @return bool
     */
    public function isTopChef()
    {
        return $this->hasRole(UserRole::label(UserRole::ROLE_PROFESSIONAL_CHEF));
    }

    /**
     * @return bool
     */
    public function isChef()
    {
        $roles = [
            UserRole::label(UserRole::ROLE_PROFESSIONAL_CHEF),
            UserRole::label(UserRole::ROLE_COMMUNITY_CHEF)
        ];

        return $this->hasAnyRole($roles);
    }

    /**
     * @return bool
     */
    public function isRegularUser()
    {
        return $this->hasRole(UserRole::label(UserRole::ROLE_USER));
    }

    /**
     * @return string
     */
    public function getShortUrl()
    {
        return $this->publicProfileUrl;
    }

    /**
     * @return bool
     */
    public function isNotifiable()
    {
        return $this->is_subscribed && $this->is_confirmed;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->publicProfileUrl;
    }

    /**
     * @return mixed
     */
    public function queryChefVideos()
    {
        $userId = $this->id;

        return Video::where('user_id', $userId)
            ->orWhere(function ($query) use ($userId) {
                $query->whereNull('user_id'); // show episode
                $query->whereHas('show.chefs', function ($query) use ($userId) {
                    $query->where('users.id', $userId);
                });
            });
    }
}
