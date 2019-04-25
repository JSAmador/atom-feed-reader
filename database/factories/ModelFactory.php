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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'username' => $faker->name,
        'email' => $faker->email,
    ];
});

$factory->define(App\Feed::class, function (Faker\Generator $faker) {
    return [
        'entryid' => $faker->text(),
        'title' => $faker->title,
        'updated' => $faker->date(),
        'icon' => $faker->imageUrl(),
        'logo' => $faker->imageUrl(),
        'rights' => $faker->text(),
        'subtitle' => $faker->paragraph(10),
        'generator_id' => $faker->randomNumber(),
        'added_by' => $faker->randomNumber()
    ];
});
$factory->define(App\Entry::class, function (Faker\Generator $faker) {
    return [
        'entryid' => $faker->text(),
        'title' => $faker->title,
        'updated' => $faker->date(),
        'rights' => $faker->text(),
        'content' => $faker->paragraph(20),
        'summary' => $faker->paragraph(10),
        'published' => $faker->date(),
        'feed_id' => $faker->randomNumber(),
        'source_id' => $faker->randomNumber()

    ];
});

$factory->define(App\Person::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'uri' => $faker->url,
        'email' => $faker->email


    ];
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    return [
        'term' => $faker->text(),
        'scheme' => $faker->text(),
        'label' => $faker->text()

    ];
});


$factory->define(App\Source::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->title,
        'updated' => $faker->date(),

    ];
});

$factory->define(App\Generator::class, function (Faker\Generator $faker) {
    return [
        'uri' => $faker->url,
        'version' => $faker->text(),

    ];
});


$factory->define(App\Link::class, function (Faker\Generator $faker) {
    return [
        'href' => $faker->text(),
        'rel' => $faker->text(),
        'type' => $faker->text(),
        'hreflang' => $faker->text(),
        'title' => $faker->title,
        'length' => $faker->text()

    ];
});


