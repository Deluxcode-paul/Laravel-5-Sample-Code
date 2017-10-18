<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateTime = Carbon::now()->toDateTimeString();
        $permissions = [
            ['name' => 'admin-access'],
            ['name' => 'admin-full-access'],

            ['name' => 'recipes-access'],
            ['name' => 'recipes-list'],
            ['name' => 'recipe-create'],
            ['name' => 'recipe-update'],
            ['name' => 'recipe-delete'],

            ['name' => 'recipe-reviews-list'],
            ['name' => 'recipe-review-create'],
            ['name' => 'recipe-review-update'],
            ['name' => 'recipe-review-delete'],
            ['name' => 'recipe-review-reply'],

            ['name' => 'recipe-questions-list'],
            ['name' => 'recipe-question-create'],
            ['name' => 'recipe-question-update'],
            ['name' => 'recipe-question-delete'],
            ['name' => 'recipe-question-reply'],

            ['name' => 'articles-access'],
            ['name' => 'articles-list'],
            ['name' => 'article-create'],
            ['name' => 'article-update'],
            ['name' => 'article-delete'],

            ['name' => 'article-questions-list'],
            ['name' => 'article-question-create'],
            ['name' => 'article-question-update'],
            ['name' => 'article-question-delete'],
            ['name' => 'article-question-reply'],
        ];

        if (0 == DB::table('permissions')->count()) {
            foreach ($permissions as $permission) {
                $permission['created_at'] = $permission['updated_at'] = $dateTime;
                DB::table('permissions')->insert($permission);
            }
        }
    }
}
