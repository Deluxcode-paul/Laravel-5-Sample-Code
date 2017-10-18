<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

/**
 * Class AllergensTableSeeder
 */
class AllergensTableSeeder extends Seeder
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
            'Gluten',
            'Dairy',
            'Wheat',
            'Tree nuts',
            'Peanuts',
            'Soy',
            'Egg',
            'Sesame'
        ];

        if (0 == DB::table('allergens')->count()) {
            foreach ($titles as $title) {
                DB::table('allergens')->insert([
                    'title' => $title,
                    'created_at' => $dateTime,
                    'updated_at' => $dateTime
                ]);
            }
        }
    }
}
