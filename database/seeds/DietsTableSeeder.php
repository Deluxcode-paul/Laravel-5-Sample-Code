<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

/**
 * Class DietsTableSeeder
 */
class DietsTableSeeder extends Seeder
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
            'Vegetarian',
            'Vegan',
            'Paleo',
            'Pescetarian'
        ];

        if (0 == DB::table('diets')->count()) {
            foreach ($titles as $title) {
                DB::table('diets')->insert([
                    'title' => $title,
                    'created_at' => $dateTime,
                    'updated_at' => $dateTime
                ]);
            }
        }
    }
}
