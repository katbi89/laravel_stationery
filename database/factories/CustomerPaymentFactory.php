<?php

use Faker\Generator as Faker;

$factory->define(App\CustomerPayment::class, function (Faker $faker) {
    return [
        'amount' => $faker->randomNumber($nbDigits = 4, $strict = true),
        'date' => $faker->date(),
        'time' => $faker->time(),
        'notes' => $faker->sentence,
        'customer_id' => $faker->numberBetween($min = 1, $max = 50),
    ];
});
