<?php

use Faker\Generator as Faker;

$factory->define(App\OrderItem::class, function (Faker $faker) {
    return [
        'count' => $faker->randomNumber($nbDigits = 3, $strict = true),
        'cost' => $faker->randomNumber($nbDigits = 3, $strict = true),
        'unit_id' => $faker->numberBetween($min = 1, $max = 5),
        'item_id' => $faker->numberBetween($min = 1, $max = 50),
        'order_id' => $faker->numberBetween($min = 1, $max = 50),
    ];
});
