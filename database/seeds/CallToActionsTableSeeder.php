<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CallToActionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateTime = Carbon::now()->toDateTimeString();
        $items = [
            array (
                'title' => 'What is Kosher?',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'link' => '',
                'button_text' => 'SEE WHAT KOSHER IS',
                'image' => ''
            ),
            array (
                'title' => 'Join the conversation',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'link' => '',
                'button_text' => 'JOIN',
                'image' => ''
            ),
            array (
                'title' => 'Ask the Kosher.com Experts',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'link' => '',
                'button_text' => 'ASK EXPERTS',
                'image' => ''
            ),
        ];

        if (0 == DB::table('call_to_actions')->count()) {
            foreach ($items as $item) {
                $item['created_at'] = $dateTime;
                $item['updated_at'] = $dateTime;
                DB::table('call_to_actions')->insert($item);
            }
        }
    }
}
