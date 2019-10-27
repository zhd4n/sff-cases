<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Parts\Part;
use Faker\Generator as Faker;

$factory->define(Part::class, function (Faker $faker) {
    $title = $faker->company;

    return [
        'type'        => 'case',
        'title'       => $title,
        'slug'        => \Illuminate\Support\Str::slug($title),
        'description' => $faker->text(),
        'price'       => $faker->numerify('###.##'),
        'properties'  => ['some_property' => 'some_value'],
    ];
});
