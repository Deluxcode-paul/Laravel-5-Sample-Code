<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

/**
 * Class BlessingTypesTableSeeder
 */
class BlessingTypesTableSeeder extends Seeder
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
            'Hamotzi',
            'Mezonot',
            'Ha-aitz',
            'Ha-adamah',
            'Shehakol',
            'Al Hamichyah',
            'Al Hagefen',
            "Al Haaretz v'al Hapeirot",
            'Borei Nifashot'
        ];

        if (0 == DB::table('blessing_types')->count()) {
            foreach ($titles as $title) {
                DB::table('blessing_types')->insert([
                    'title' => $title,
                    'created_at' => $dateTime,
                    'updated_at' => $dateTime
                ]);
            }
        }
    }
}
