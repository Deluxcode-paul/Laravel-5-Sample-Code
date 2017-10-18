<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $dateTime = Carbon::now()->toDateTimeString();

        if (0 == DB::table('states')->count()) {
            DB::table('states')->insert(array(
                array('title' => 'Alabama', 'code' => 'AL', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Alaska', 'code' => 'AK', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Arizona', 'code' => 'AZ', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Arkansas', 'code' => 'AR', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'California', 'code' => 'CA', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Colorado', 'code' => 'CO', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Connecticut', 'code' => 'CT', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Delaware', 'code' => 'DE', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array(
                    'title' => 'District of Columbia',
                    'code' => 'DC',
                    'created_at' => $dateTime,
                    'updated_at' => $dateTime
                ),
                array('title' => 'Florida', 'code' => 'FL', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Georgia', 'code' => 'GA', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Hawaii', 'code' => 'HI', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Idaho', 'code' => 'ID', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Illinois', 'code' => 'IL', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Indiana', 'code' => 'IN', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Iowa', 'code' => 'IA', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Kansas', 'code' => 'KS', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Kentucky', 'code' => 'KY', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Louisiana', 'code' => 'LA', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Maine', 'code' => 'ME', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Maryland', 'code' => 'MD', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Massachusetts', 'code' => 'MA', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Michigan', 'code' => 'MI', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Minnesota', 'code' => 'MN', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Mississippi', 'code' => 'MS', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Missouri', 'code' => 'MO', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Montana', 'code' => 'MT', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Nebraska', 'code' => 'NE', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Nevada', 'code' => 'NV', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'New Hampshire', 'code' => 'NH', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'New Jersey', 'code' => 'NJ', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'New Mexico', 'code' => 'NM', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'New York', 'code' => 'NY', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'North Carolina', 'code' => 'NC', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'North Dakota', 'code' => 'ND', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Ohio', 'code' => 'OH', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Oklahoma', 'code' => 'OK', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Oregon', 'code' => 'OR', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Pennsylvania', 'code' => 'PA', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Rhode Island', 'code' => 'RI', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'South Carolina', 'code' => 'SC', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'South Dakota', 'code' => 'SD', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Tennessee', 'code' => 'TN', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Texas', 'code' => 'TX', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Utah', 'code' => 'UT', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Vermont', 'code' => 'VT', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Virginia', 'code' => 'VA', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Washington', 'code' => 'WA', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'West Virginia', 'code' => 'WV', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Wisconsin', 'code' => 'WI', 'created_at' => $dateTime, 'updated_at' => $dateTime),
                array('title' => 'Wyoming', 'code' => 'WY', 'created_at' => $dateTime, 'updated_at' => $dateTime)
            ));
        }
    }
}
