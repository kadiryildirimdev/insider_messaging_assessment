<?php

namespace App\Interfaces;

use App\Models\Message;
use App\Models\MessageStatus;
use App\Models\UserType;

interface MessageRepositoryInterface
{
    public function create(array $data): ?Message;

    public function update(string $id, array $data): bool;

    public function read(string $id): ?Message;

    public function list(array $data);

    public function findUserTypeByCode(string $code): ?UserType;

    public function findMessageStatusByCode(string $code): ?MessageStatus;

    public function getUsersByUserType(string $userTypeId): ?array;
}
