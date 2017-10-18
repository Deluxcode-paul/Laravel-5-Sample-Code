<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

/**
 * Class PreferencesTableSeeder
 */
class PreferencesTableSeeder extends Seeder
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
            'Meat',
            'Dairy',
            'Parve'
        ];

        if (0 == DB::table('preferences')->count()) {
            foreach ($titles as $title) {
                DB::table('preferences')->insert([
                    'title' => $title,
                    'created_at' => $dateTime,
                    'updated_at' => $dateTime
                ]);
            }
        }
    }
}
