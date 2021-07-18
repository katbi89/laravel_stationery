<?php

use Faker\Generator as Faker;

$factory->define(App\Unit::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'capacity' => $faker->randomNumber($nbDigits = 2, $strict = true),
        'price' => $faker->randomNumber($nbDigits = 4, $strict = true),
        'item_id' => $faker->numberBetween($min = 1, $max = 50),
    ];
});
