<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

// class PhotoFactory extends Factory
// {
    // /**
    //  * Define the model's default state.
    //  *
    //  * @return array
    //  */
    // public function definition()
    // {
    //     return [
    //         //
    //     ];
    // }
// }

$factory->define(App\Photo::class, function (Faker $faker) {
    return [
        'id' => Str::random(12),
        'user_id' => fn() => factory(App\User::class)->create()->id,
        'filename' => Str::random(12) . '.jpg',
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
