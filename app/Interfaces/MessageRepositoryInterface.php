<?php

namespace App\Interfaces;

use App\Models\Message;
use App\Models\MessageStatus;
use App\Models\UserType;
use Illuminate\Database\Eloquent\Collection;

interface MessageRepositoryInterface
{
    public function createBulk(array $data): ?Message;

    public function create(array $data): ?Message;

    public function read(string $id): ?Message;

    public function list(array $data);

    public function findUserTypeByCode(string $code): ?UserType;

    public function findMessageStatusByCode(string $code): ?MessageStatus;

    public function getUsersByUserType(string $userTypeId): ?array;

    public function getPendingMessages(): ?Collection;
}
