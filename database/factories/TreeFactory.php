<?php

use Faker\Generator as Faker;

$factory->define(App\Tree::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
