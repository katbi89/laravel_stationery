<?php

use Faker\Generator as Faker;

$factory->define(App\Item::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->sentences($nb = 3, $asText = true),
        'image' => 'storage/images/1542007956.jpeg',
        'amount' => $faker->randomNumber($nbDigits = 3, $strict = true),
        'notes' => $faker->sentence,
        'tree_id' => $faker->numberBetween($min = 1, $max = 50),
    ];
});
