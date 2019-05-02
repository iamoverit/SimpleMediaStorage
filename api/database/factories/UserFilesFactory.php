<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use App\Models\UserFiles;
use Faker\Generator as Faker;

$factory->define(UserFiles::class, function (Faker $faker){
    return [
        'description' => $faker->sentence(6, true),
        'email' => $faker->safeEmail,
        'filename' => $faker->word.'.'.$faker->fileExtension,
        'file_hash'=> $faker->md5,
        'user_hash' => $faker->md5,
    ];
});
