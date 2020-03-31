<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        "number" => $faker->unique()->randomNumber(4),
        "last_name" => $faker->lastName,
        "first_name" => $faker->firstName,
    ];
});