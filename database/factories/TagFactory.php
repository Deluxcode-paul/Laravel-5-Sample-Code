<?php

$factory->define(App\Models\Tag::class, function (Faker\Generator $faker) {
    $dateTime = \Carbon\Carbon::now()->toDateTimeString();
    return [
        'title' => 'Tag-' . str_random(5),
        'created_at' => $dateTime,
        'updated_at' => $dateTime
    ];
});
