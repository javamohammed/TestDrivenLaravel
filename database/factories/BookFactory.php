<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Book;
use Faker\Generator as Faker;
use App\Author;

$factory->define(Book::class, function (Faker $faker) {
    return [
        //
        'title' => $faker->sentence,
        'author_id' => factory(Author::class)
    ];
});
