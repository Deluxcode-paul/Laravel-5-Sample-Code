<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

/**
 * Class SourcesTableSeeder
 */
class SourcesTableSeeder extends Seeder
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
            'Mishpacha'
        ];

        if (0 == DB::table('sources')->count()) {
            foreach ($titles as $title) {
                DB::table('sources')->insert([
                    'title' => $title,
                    'created_at' => $dateTime,
                    'updated_at' => $dateTime
                ]);
            }
        }
    }
}
