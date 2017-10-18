<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

/**
 * Class IngredientsTableSeeder
 */
class IngredientsTableSeeder extends Seeder
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
            'Drumstick',
            'Spinach',
            'Onion',
            'Mushroom',
            'Radish',
            'Lettuce',
            'Leek',
            'Pumpkin',
            'Garlic',
            'Cucumber',
            'Zucchini',
            'Corn',
            'Celery',
            'Carrot',
            'Cabbage',
            'Avocado',
            'Eggplant',
            'Potatoes',
            'Ginger',
            'Tomatoes',
            'Oregano',
            'Salt',
            'Paprika',
            'Marjoram',
            'Dill',
            'Cloves',
            'Cinnamon',
            'Basil',
            'Parsley',
            'Beef',
            'Turkey',
            'Ham',
            'Crab',
            'Chicken',
            'Bacon',
            'Sugar',
            'Hazelnut',
            'Pistachio',
            'Peanuts',
            'Almonds',
            'Walnuts',
            'Milk',
            'Yogurt',
            'Brie Cheese',
            'Ricotta Cheese',
            'Parmesan Cheese',
            'Blue Cheese',
            'Cheddar Cheese',
            'Mascarpone Cheese',
            'Provolone Cheese',
            'Mozzarella Cheese',
            'Butter',
        ];

        if (0 == DB::table('ingredients')->count()) {
            foreach ($titles as $title) {
                DB::table('ingredients')->insert([
                    'title' => $title,
                    'created_at' => $dateTime,
                    'updated_at' => $dateTime
                ]);
            }
        }
    }
}
