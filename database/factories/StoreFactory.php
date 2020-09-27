<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Stores;
use Faker\Generator as Faker;

$factory->define(Stores::class, function (Faker $faker) {
    return [
        'platform' => $faker->name,
    ];
});
