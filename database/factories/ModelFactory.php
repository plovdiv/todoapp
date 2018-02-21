<?php

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

/* @var  $factory \Illuminate\Database\Eloquent\Factory */
$factory->define(App\Task::class, function (Faker $faker) {
    return [
        'task_list_id' => function () {
            return factory(App\TaskList::class)->create()->id;
        },
        'name' => $faker->word,
    ];
});

/* @var  $factory \Illuminate\Database\Eloquent\Factory */
$factory->state(App\Task::class, 'completed', function (Faker $faker) {
    return [
        'done' => 1,
        'completed_at' => Carbon\Carbon::now()
    ];
});
/* @var  $factory \Illuminate\Database\Eloquent\Factory */
$factory->state(App\Task::class, 'uncompleted', function (Faker $faker) {
    return [
        'done' => 0,
    ];
});
/* @var  $factory \Illuminate\Database\Eloquent\Factory */
$factory->define(App\TaskList::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'name' => $faker->word,
    ];
});
/* @var  $factory \Illuminate\Database\Eloquent\Factory */
$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->firstName(5),
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => bin2hex(random_bytes(10)),
    ];
});
/* @var  $factory \Illuminate\Database\Eloquent\Factory */
$factory->define(App\Role::class, function (Faker $faker) {
    return [
        'name' => 'owner',
    ];
});
/* @var  $factory \Illuminate\Database\Eloquent\Factory */
$factory->state(App\Role::class, 'owner', function (Faker $faker) {
    return [
        'name' => 'owner',
    ];
});


$factory->state(App\Role::class, 'admin', function (Faker $faker) {
    return [
        'name' => 'admin',
    ];
});
