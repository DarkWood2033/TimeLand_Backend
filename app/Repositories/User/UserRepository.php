<?php

namespace App\Repositories\User;

use App\Entities\User;

interface UserRepository
{
    public function create($name, $email, $password): User;

    public function update(User $user): void;

    public function remove(User $user): void;

    public function deleteAll(): bool;

    public function getEdit($id): ?User;

    public function getAll();
}
