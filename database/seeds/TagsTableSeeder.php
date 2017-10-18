<?php

use Illuminate\Database\Seeder;

/**
 * Class TagsTableSeeder
 */
class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateTime = \Carbon\Carbon::now()->toDateTimeString();

        if (0 == DB::table('tags')->count()) {
            $words = explode(",", 'wiggly,color,graceful,drawer,trains,match,ripe,stupid,allow,wretched,hammer,pass,organic,stop,' .
                'mourn,thankful,horse,flag,enchanting,soggy,release');
            foreach ($words as $tag) {
                App\Models\Tag::create([
                    'title' => $tag,
                    'created_at' => $dateTime,
                    'updated_at' => $dateTime
                ]);
            }
        }
    }
}
