<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(Task::class, function (Faker $faker) {

    return [
        'name' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'responsible_user_id' => App\User::all()->random()->id,
        'director_user_id' => App\User::all()->random()->id,
        'status_id' => App\Status::all()->random()->id,
        'date_end' => $faker->dateTimeBetween('now', '+6 months')
    ];
});
