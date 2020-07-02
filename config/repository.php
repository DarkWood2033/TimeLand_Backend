<?php

use App\Entities\User;
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
    ]
];
