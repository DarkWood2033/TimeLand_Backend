<?php

namespace App\Repositories\Timer;

use App\Entities\Timer;
use App\Entities\User;

interface TimerRepository
{
    public function create($name, User $user, array $items, $type, $common_time): Timer;

    public function update(Timer $timer): void;

    public function remove(Timer $timer): void;

    public function deleteAll(): bool;

    public function getEdit($id): ?Timer;

    public function getEditByUser(User $user, $id): ?Timer;

    public function getAllByUser(User $user);

    public function getAll();
}
