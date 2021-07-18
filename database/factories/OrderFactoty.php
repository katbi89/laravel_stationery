<?php

use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'cost' => $faker->randomNumber($nbDigits = 3, $strict = true),
        'date' => $faker->date(),
        'time' => $faker->time(),
        'notes' => $faker->sentence,
        'customer_id' => $faker->numberBetween($min = 1, $max = 50),
    ];
});
