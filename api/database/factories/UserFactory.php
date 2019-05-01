<?php

use App\Models\UserFiles;
use App\User;
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

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});


$factory->define(UserFiles::class, function (Faker $faker){
    return [
        'description' => $faker->sentence(6, true),
        'email' => $faker->safeEmail,
        'filename' => $faker->word.'.'.$faker->fileExtension,
        'file_hash'=> $faker->md5,
        'user_hash' => $faker->md5,
    ];
});