<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RecipeCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateTime = Carbon::now()->toDateTimeString();
        $titles = [
            'Main Dishes',
            'Appetizers & Starters',
            'Side dishes',
            'Salads',
            'Breads',
            'Soups',
            'Desserts'
        ];

        if (0 == DB::table('recipe_categories')->count()) {
            foreach ($titles as $title) {
                DB::table('recipe_categories')->insert([
                    'title' => $title,
                    'image' => '',
                    'created_at' => $dateTime,
                    'updated_at' => $dateTime
                ]);
            }
        }
    }
}
