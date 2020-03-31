<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Debtor;
use Faker\Generator as Faker;

$factory->define(Debtor::class, function (Faker $faker) {
    return [
        "code" => $faker->unique()->randomNumber(4),
        "description" => $faker->words(5, true),
        "address" => $faker->address,
        "contact_number" => $faker->phoneNumber,
        "owner" => $faker->name,
    ];
});