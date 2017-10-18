<?php

use App\Models\Article;
use Illuminate\Database\Seeder;

/**
 * Class ArticleSlugSeeder
 */
class ArticleSlugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articles = Article::whereNull('slug')->get();
        foreach ($articles as $article) {
            $article->save();
        }
    }
}
