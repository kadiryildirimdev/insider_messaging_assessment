<?php

namespace App\Interfaces;

use App\Models\Message;
use App\Models\MessageStatus;
use App\Models\UserType;
use Illuminate\Database\Eloquent\Collection;

/**
 *
 */
interface MessageRepositoryInterface
{
    /**
     * @param array $data
     * @return Message|null
     */
    public function createBulk(array $data): ?Message;

    /**
     * @param array $data
     * @return Message|null
     */
    public function create(array $data): ?Message;

    /**
     * @param string $id
     * @return mixed
     */
    public function read(string $id): mixed;

    /**
     * @param array $data
     * @return mixed
     */
    public function list(array $data): mixed;

    /**
     * @param string $code
     * @return UserType|null
     */
    public function findUserTypeByCode(string $code): ?UserType;

    /**
     * @param string $code
     * @return MessageStatus|null
     */
    public function findMessageStatusByCode(string $code): ?MessageStatus;

    /**
     * @param string $userTypeId
     * @return array|null
     */
    public function getUsersByUserType(string $userTypeId): ?array;

    /**
     * @return Collection|null
     */
    public function getPendingMessages(): ?Collection;
}
