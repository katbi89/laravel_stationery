<?php

use Faker\Generator as Faker;

$factory->define(App\Customer::class, function (Faker $faker) {
    return [
        'company' => $faker->company,
        'name' => $faker->name,
        'phone' => $faker->phoneNumber,
        'mobile' => $faker->phoneNumber,
        'address' => $faker->address,
        'balance' => $faker->randomNumber($nbDigits = 3, $strict = true),
        'notes' => $faker->sentence,
    ];
});
