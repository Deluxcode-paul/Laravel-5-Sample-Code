<?php

$factory->define(App\Models\Recipe::class, function (Faker\Generator $faker) {
    $preference = App\Models\Preference::inRandomOrder()->first();
    $user = App\Models\User::inRandomOrder()->first();
    $serving = collect([2, 4, 6, 8]);
    $difficulty = collect(App\Enums\RecipeDifficulty::values());
    $cookTime = collect([30, 45, 60, 75, 90, 105, 120]);
    $blessingType = App\Models\BlessingType::inRandomOrder()->first();
    $images = collect([
        'bra68e35130abd18a4dd8dae7ef9bbc2.jpg',
        'br20f2b2eae3ed0d0f3e82b91a85e245.jpg',
        'brc6057f99cecff193fa42a84900520e.jpg',
        '55ab6d957978466f2e3c4ded6b0cc65e.jpg',
        'brc715231017a4f93e7c175efcb9e32f.jpg',
        'br09d9e1fb18e82474e46397323e2eba.jpg',
        '55956ac1ed8ae57804331c2fa0d57a85.jpg',
        'br70044c6e43e6bd5567ed72b8683bbf.jpg',
        'br254843cfedff67b2427dbfa39d2743.jpg',
        '558ba1f9ff8bbb35df5e9047e5cbe05c.jpg',
        'br6eecb3aeba3d9cb276ff827d477d1b.jpg',
        '55b6448a647f8d2ff5734a2e2c2030c1.jpg'
    ]);

    return [
        'title' => $faker->sentence,
        'image' => $images->random(),
        //$faker->image(public_path('seeds/recipe_images'), 800, 600, 'food', false),
        'user_id' => $user->id,
        'description' => $faker->paragraph,
        'cook_time' => $cookTime->random(),
        'serving' => $serving->random(),
        'preference_id' => $preference->id,
        'difficulty' => $difficulty->random(),
        'blessing_type_id' => $blessingType->id,
        'is_featured' => $faker->boolean,
        'is_banner' => $faker->boolean,
        'is_archive' => $faker->boolean
    ];
});

$factory->define(App\Models\IngredientGroup::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
    ];
});

$factory->define(App\Models\RecipeIngredient::class, function (Faker\Generator $faker) {
    $ingredient = App\Models\Ingredient::inRandomOrder()->first();
    $ingredientGroup = App\Models\IngredientGroup::inRandomOrder()->first();

    return [
        'ingredient_id' => $ingredient->id,
        'ingredient_group_id' => $ingredientGroup->id,
        'description' => $faker->sentence,
    ];
});

$factory->define(App\Models\RecipeCooking::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'note' => $faker->paragraph,
        'tip' => $faker->paragraph,
        'variation' => $faker->sentence
    ];
});

$factory->define(App\Models\CookingStep::class, function (Faker\Generator $faker) {
    return [
        'description' => $faker->paragraph,
        'image' => null
    ];
});

$factory->define(App\Models\Review::class, function (Faker\Generator $faker) {
    $user = App\Models\User::inRandomOrder()->first();

    return [
        'title' => $faker->sentence,
        'details' => $faker->paragraph,
        'rating' => rand(1, 5),
        'views' => 0,
        'votes' => 0,
        'reports' => 0,
        'comments' => 0,
        'user_id' => $user->id,
        'activity_month' => rand(1, 12),
        'activity_year' => 2016
    ];
});

$factory->define(App\Models\RecipeQuestion::class, function (Faker\Generator $faker) {
    $user = App\Models\User::inRandomOrder()->first();

    return [
        'title' => $faker->sentence,
        'details' => $faker->paragraph,
        'views' => 0,
        'votes' => 0,
        'reports' => 0,
        'answers' => 0,
        'user_id' => $user->id,
        'activity_month' => rand(1, 12),
        'activity_year' => 2016
    ];
});

$factory->define(App\Models\ReviewComment::class, function (Faker\Generator $faker) {
    $user = App\Models\User::inRandomOrder()->first();

    return [
        'details' => $faker->paragraph,
        'votes' => 0,
        'reports' => 0,
        'user_id' => $user->id
    ];
});

$factory->define(App\Models\RecipeAnswer::class, function (Faker\Generator $faker) {
    $user = App\Models\User::inRandomOrder()->first();

    return [
        'details' => $faker->paragraph,
        'votes' => 0,
        'reports' => 0,
        'user_id' => $user->id
    ];
});

$factory->define(App\Models\Video::class, function (Faker\Generator $faker) {
    $videos = collect([
        'https://www.youtube.com/watch?v=atm6kKYUDRE',
        'https://www.youtube.com/watch?v=cxB4ACaaR4I',
        'https://www.youtube.com/watch?v=5AcZCo4QSxQ',
        'https://www.youtube.com/watch?v=2-aEm3vAxpU',
        'https://www.youtube.com/watch?v=uKUvtyjw8R0',
        'https://www.youtube.com/watch?v=GkpNjn1aBAo',
        'https://www.youtube.com/watch?v=69hWzKST2D8',
        'https://www.youtube.com/watch?v=fwpPCKF0mAE',
        'https://www.youtube.com/watch?v=SVDSrYJTTCw',
        'https://www.youtube.com/watch?v=ayjhkytFuL0',
        'https://www.youtube.com/watch?v=OYx8owj30FI',
        'https://www.youtube.com/watch?v=UO-cE9PGb5Y',
        'https://www.youtube.com/watch?v=BFdQUgAFtGU',
        'https://www.youtube.com/watch?v=iUeDMqi_-dE',
        'https://www.youtube.com/watch?v=-lMphXmWvbk',
        'https://www.youtube.com/watch?v=LKaQ4fDklyg'
    ]);

    $video = $videos->random();
    $apiData = App\Facades\BfmVideo::getData($video);
    if (empty($apiData['thumbnail_large'])) {
        $image = null;
    } else {
        $image = App\Facades\BfmImage::saveExternal($apiData['thumbnail_large']);
    }

    return [
        'owner_type' => 'App\Models\Recipe',
        'video' => $video,
        'image' => $image,
        'title' => null,
        'description' => null,
        'episode' => null,
    ];
});
