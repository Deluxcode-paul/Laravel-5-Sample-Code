<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

/**
 * Class HolidaysTableSeeder
 */
class HolidaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateTime = Carbon::now()->toDateTimeString();
        $holidays = [
            [
                'title' => 'Shabbos',
                'starts_at' => null
            ],
            [
                'title' => 'Purim',
                'starts_at' => '2017-03-11'
            ],
            [
                'title' => 'Passover',
                'starts_at' => '2017-04-10'
            ],
            [
                'title' => 'Shavuot',
                'starts_at' => '2017-05-30'
            ],
            [
                'title' => 'Rosh Hashanah',
                'starts_at' => '2016-10-02'
            ],
            [
                'title' => 'Sukkot',
                'starts_at' => '2016-10-16'
            ],
            [
                'title' => 'Chanukah',
                'starts_at' => '2016-12-24'
            ],
            [
                'title' => 'Yom Kippur',
                'starts_at' => '2017-09-30'
            ],
            [
                'title' => 'Tu-Bishvat',
                'starts_at' => '2017-02-11'
            ],
        ];

        if (0 == DB::table('holidays')->count()) {
            foreach ($holidays as $holiday) {
                DB::table('holidays')->insert([
                    'title' => $holiday['title'],
                    'image' => '',
                    'starts_at' => $holiday['starts_at'],
                    'created_at' => $dateTime,
                    'updated_at' => $dateTime
                ]);
            }
        }
    }
}
