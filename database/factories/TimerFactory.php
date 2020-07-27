<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Timer;
use Faker\Generator as Faker;

$factory->define(Timer::class, function (Faker $faker) {
    $item = [
        'name' => $faker->name,
        'items' => array_fill(0, mt_rand(2, 5), [
            'time' => mt_rand(5,40),
            'type' => array_rand(['work', 'rest', 'after', 'before'])
        ]),
        'common_time' => 0,
        'user_id' => mt_rand(1,2),
        'type' => array_rand(['constructor', 'interval'])
    ];

    foreach ($item['items'] as $i){
        $item['common_time'] += $i['time'];
    }

    return $item;
});
