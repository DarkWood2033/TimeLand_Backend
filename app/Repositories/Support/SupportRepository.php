<?php

namespace App\Repositories\Support;

use App\Entities\Support;

interface SupportRepository
{
    public function create($name, $email, $subject, $message): Support;

    public function update(Support $timer): void;

    public function remove(Support $timer): void;

    public function deleteAll(): bool;

    public function getEdit($id): ?Support;

    public function getAll();
}
