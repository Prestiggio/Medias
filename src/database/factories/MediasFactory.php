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

$factory->define(Ry\Medias\Models\Media::class, function (Faker\Generator $faker) {
    return [
        "owner_id" => 0, //user owner
        'title' => $faker->name,
        'descriptif' => $faker->text,
        "path" => $faker->imageUrl(),
        "type" => 'image',
        "height" => 480.
    ];
});
