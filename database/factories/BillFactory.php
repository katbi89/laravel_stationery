<?php

use Faker\Generator as Faker;

$factory->define(App\Bill::class, function (Faker $faker) {
    return [
        'order_id' => $faker->numberBetween($min = 1, $max = 50),
        'cost' => $faker->randomNumber($nbDigits = 3, $strict = true),
        'date' => $faker->date(),
        'time' => $faker->time(),
        'notes' => $faker->sentence,
        'supplier_id' => $faker->numberBetween($min = 1, $max = 50),
    ];
});
