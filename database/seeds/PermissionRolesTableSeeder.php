<?php

use Illuminate\Database\Seeder;

class PermissionRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Admin',
                'permissions' => [
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
                ]
            ],
            [
                'name' => 'User',
                'permissions' => [
                ]
            ],
            [
                'name' => 'Top Professional Chef',
                'permissions' => [
                    ['name' => 'admin-access'],

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
                ]
            ],
            [
                'name' => 'Community Chef',
                'permissions' => [
                    ['name' => 'admin-access'],

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
                ]
            ],
        ];

        if (0 == DB::table('permission_roles')->count()) {
            foreach ($roles as $role) {
                $_role = DB::table('roles')->where('name', $role['name'])->first();
                if ($_role) {
                    foreach ($role['permissions'] as $permission) {
                        $_permission = DB::table('permissions')->where('name', $permission['name'])->first();
                        if ($_permission) {
                            $data = [
                                'permission_id' => $_permission->id,
                                'role_id' => $_role->id,
                            ];
                            DB::table('permission_roles')->insert($data);
                        }
                    }
                }
            }
        }
    }
}
