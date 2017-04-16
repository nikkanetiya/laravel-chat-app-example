<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->firstName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'image' => $faker->randomElement(['profile-1.png', 'profile-2.png', 'profile-3.png']) // Use default image for now
    ];
});

$factory->define(App\Conversation::class, function (Faker\Generator $faker) {
    return [
        'message' => $faker->realText(50),
        'user_id' => function() {
            return App\User::inRandomOrder()->limit(1)->value('id');
        },
        'sender_id' => function (array $conversation) {
            return App\User::where('id', '!=', $conversation['user_id'])->inRandomOrder()->limit(1)->value('id');
        }
    ];
});