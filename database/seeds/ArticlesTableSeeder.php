<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

/**
 * Class ArticlesTableSeeder
 */
class ArticlesTableSeeder extends Seeder
{

    const COUNT_OF_TAGS = 5;
    const COUNT_OF_ARTICLES = 10;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateTime = Carbon::now()->toDateTimeString();

        if (0 == DB::table('article_categories')->count()) {
            DB::table('article_categories')->insert(
                [
                    ['title' => 'Articles Category 1', 'id' => 1, 'created_at' => $dateTime, 'updated_at' => $dateTime],
                    ['title' => 'Articles Category 2', 'id' => 2, 'created_at' => $dateTime, 'updated_at' => $dateTime]
                ]
            );
        }

        if (0 == DB::table('articles')->count()) {
            $tags = \App\Models\Tag::all()->pluck('id');

            for ($i = 0; $i < self::COUNT_OF_ARTICLES; $i++) {
                $article = [
                    'user_id' => 1,
                    'category_id' => mt_rand(1, 2),
                    'title' => substr(Lipsum::short()->text(1), 0, mt_rand(20, 50)),
                    'image' => '',
                    'content' => Lipsum::short()->text(mt_rand(3, 7)),
                    'is_featured' => mt_rand(0, 1),
                    'created_at' => $dateTime,
                    'updated_at' => $dateTime,
                    'published_at' => $dateTime,
                ];

                $articleId = DB::table('articles')->insertGetId($article);

                $articleModel = \App\Models\Article::find($articleId);

                $insertedTags = $tags->random(self::COUNT_OF_TAGS);
                foreach ($insertedTags as $tag) {
                    $articleModel->tags()->attach($tag);
                }
            }
        }
    }
}
