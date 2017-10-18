<?php

namespace App\Http\Traits;

use App\Enums\UserRole;
use App\Models\Article;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Video;

/**
 * Class Search
 * @package App\Http\Traits
 */
trait Search
{
    /**
     * @param string $keyword
     * @return array
     */
    protected function getCountByKeyword($keyword)
    {
        $count = [];
        $count['recipes'] = $this->getRecipesCountByKeyword($keyword);
        $count['lifestyle'] = $this->getArticlesCountByKeyword($keyword);
        $count['chefs'] = $this->getChefsCountByKeyword($keyword);
        $count['watch'] = $this->getVideosCountByKeyword($keyword);

        return $count;
    }

    /**
     * @param string $keyword
     * @return integer
     */
    protected function getRecipesCountByKeyword($keyword)
    {
        $query = Recipe::published();

        if (strlen($keyword)) {
            $query->where(function ($whereQuery) use ($keyword) {
                $whereQuery->where('title', 'like', '%' . $keyword . '%');
                $whereQuery->orWhereHas('tags', function ($hasQuery) use ($keyword) {
                    $hasQuery->where('title', 'like', '%' . $keyword . '%');
                });
                $whereQuery->orWhereHas('preference', function ($hasQuery) use ($keyword) {
                    $hasQuery->where('title', 'like', '%' . $keyword . '%');
                });
                $whereQuery->orWhereHas('allergens', function ($hasQuery) use ($keyword) {
                    $hasQuery->where('title', 'like', '%' . $keyword . '%');
                });
                $whereQuery->orWhereHas('ingredients', function ($hasQuery) use ($keyword) {
                    $hasQuery->where('description', 'like', '%' . $keyword . '%');
                });
                $whereQuery->orWhereHas('sources', function ($hasQuery) use ($keyword) {
                    $hasQuery->where('title', 'like', '%' . $keyword . '%');
                });
                $whereQuery->orWhereHas('categories', function ($hasQuery) use ($keyword) {
                    $hasQuery->where('title', 'like', '%' . $keyword . '%');
                });
                $whereQuery->orWhereHas('cuisines', function ($hasQuery) use ($keyword) {
                    $hasQuery->where('title', 'like', '%' . $keyword . '%');
                });
                $whereQuery->orWhereHas('user', function ($hasQuery) use ($keyword) {
                    $hasQuery->where('first_name', 'like', '%' . $keyword . '%');
                    $hasQuery->orWhere('last_name', 'like', '%' . $keyword . '%');
                    $hasQuery->orWhere('name', 'like', '%' . $keyword . '%');
                });
                $whereQuery->orWhereHas('holidays', function ($hasQuery) use ($keyword) {
                    $hasQuery->where('title', 'like', '%' . $keyword . '%');
                });
                $whereQuery->orWhereHas('diets', function ($hasQuery) use ($keyword) {
                    $hasQuery->where('title', 'like', '%' . $keyword . '%');
                });
                $whereQuery->orWhereHas('blessingType', function ($hasQuery) use ($keyword) {
                    $hasQuery->where('title', 'like', '%' . $keyword . '%');
                });
            });
        }

        return (int) $query->count();
    }

    /**
     * @param string $keyword
     * @return integer
     */
    private function getArticlesCountByKeyword($keyword)
    {
        $query = Article::published();

        if (strlen($keyword)) {
            $query->where(function ($whereQuery) use ($keyword) {
                $whereQuery->where('title', 'like', '%'.$keyword.'%');
                $whereQuery->orWhereHas('tags', function ($hasQuery) use ($keyword) {
                    $hasQuery->where('title', 'like', '%'.$keyword.'%');
                });
                $whereQuery->orWhereHas('category', function ($hasQuery) use ($keyword) {
                    $hasQuery->where('title', 'like', '%'.$keyword.'%');
                });
            });
        }

        return (int) $query->count();
    }

    /**
     * @param string $keyword
     * @return integer
     */
    protected function getChefsCountByKeyword($keyword)
    {
        $query = User::whereHas('roles', function ($hasQuery) {
            $hasQuery->whereIn('id', [
                UserRole::ROLE_COMMUNITY_CHEF,
                UserRole::ROLE_PROFESSIONAL_CHEF
            ]);
        });

        if (strlen($keyword)) {
            $query->where(function ($whereQuery) use ($keyword) {
                $whereQuery->where('first_name', 'like', '%'.$keyword.'%');
                $whereQuery->orWhere('last_name', 'like', '%'.$keyword.'%');
                $whereQuery->orWhere('name', 'like', '%'.$keyword.'%');
            });
        }

        return (int) $query->count();
    }

    /**
     * @param string $keyword
     * @return integer
     */
    protected function getVideosCountByKeyword($keyword)
    {
        $query = Video::query();

        if (strlen($keyword)) {
            $query->where('title', 'like', '%'.$keyword.'%');
            $query->orWhereHas('tags', function ($hasQuery) use ($keyword) {
                $hasQuery->where('title', 'like', '%'.$keyword.'%');
            });
        }

        return (int) $query->count();
    }
}
