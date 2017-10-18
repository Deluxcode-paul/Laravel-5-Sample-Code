<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

/**
 * Class CuisinesTableSeeder
 */
class CuisinesTableSeeder extends Seeder
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
            'Ashkenazi',
            'Sephardi',
            'Israeli',
            'Moroccan',
            'Persian',
            'Indian',
            'Chinese',
            'Asian',
            'Korean',
            'Thai',
            'Greek',
            'Italian',
            'French',
            'Mexican',
            'Yemenite',
            'Scandinavian',
            'Cajun'
        ];

        if (0 == DB::table('cuisines')->count()) {
            foreach ($titles as $title) {
                DB::table('cuisines')->insert([
                    'title' => $title,
                    'created_at' => $dateTime,
                    'updated_at' => $dateTime
                ]);
            }
        }
    }
}
