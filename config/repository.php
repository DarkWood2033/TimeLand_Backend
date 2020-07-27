<?php

use App\Entities\Timer;
use App\Entities\User;
use App\Repositories\Timer\DoctrineTimerRepository;
use App\Repositories\Timer\TimerRepository;
use App\Repositories\User\DoctrineUserRepository;
use App\Repositories\User\UserRepository;

return [
    UserRepository::class => [
        'concrete' => DoctrineUserRepository::class,
        'entity' => User::class,
        'caching' => [
            'enabled' => true,
            'lifetime' => 3600
        ]
    ],
    TimerRepository::class => [
        'concrete' => DoctrineTimerRepository::class,
        'entity' => Timer::class,
        'caching' => [
            'enabled' => true,
            'lifetime' => 3600
        ]
    ]
];
