<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Event;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Event::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence($nbwords = 4),
        'description'=> $faker->paragraph($nbSentences = 2),
        'date'=> $faker->dateTimeBetween('+0 days', '+2 years')->format("Y-m-d"),
        'city'=>$faker->city,
        'maximum'=>$faker->numberBetween($min = 10, $max = 50),
        'user_id' => $faker->numberBetween($min = 1, $max = 20)
    ];
});
