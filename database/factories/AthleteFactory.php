<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Athlete;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Athlete::class, function (Faker $faker) {
    return [
        //
        'user_id' => factory('App\User')->create(['isTrainer' => 0,])->id,
    ];
});
