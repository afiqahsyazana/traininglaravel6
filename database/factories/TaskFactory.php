<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$userIds= \App\User::get()->pluck('id');

$factory->define(Task::class, function (Faker $faker) use ($userIds){
    return [
        'name' => $faker->name,
        'category' => $faker->randomElement(['main', 'secondary']),
        'user_id' => $faker->randomElement($userIds),
        'content' => $faker->text,
        'active' => $faker->randomElement([0,1])

    ];
});
