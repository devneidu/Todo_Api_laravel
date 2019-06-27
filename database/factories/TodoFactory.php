<?php

use Faker\Generator as Faker;

$factory->define(App\Todo::class, function (Faker $faker) {
    return [
        'title' => $faker->words(rand(3, 5), true),
        'completed' => rand(0, 1),
        'user_id' => rand(1, 3),
        'date' => $faker->date('Y-m-d', 'now'),
        'time' => $faker->time('H:i:s')
    ];
});
