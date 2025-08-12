<?php

namespace App\Repositories;

use App\Interfaces\MessageRepositoryInterface;
use App\Models\Message;
use App\Models\MessageStatus;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Database\Eloquent\Collection;

/**
 *
 */
class MessageRepository implements MessageRepositoryInterface
{
    /**
     * @param array $data
     * @return Message|null
     */
    public function createBulk(array $data): ?Message
    {
        try {
            $message = Message::create($data);

            foreach ($data['message_receivers'] as $receiver) {
                $message->messageReceivers()->create([
                    'ref_user' => $receiver['id'],
                    'phone_number' => $receiver['phone_number']
                ]);
            }

            return $message;

        } catch (\Exception $exception) {
            return null;
        }
    }

    /**
     * @param array $data
     * @return Message|null
     */
    public function create(array $data): ?Message
    {
        try {
            $message = Message::create($data);

            $message->messageReceivers()->create([
                'phone_number' => $data['phone_number']
            ]);

            return $message;

        } catch (\Exception $exception) {
            return null;
        }
    }

    /**
     * @param string $id
     * @return Message|null
     */
    public function read(string $id): ?Message
    {
        return Message::with(['messageStatus', 'userType', 'messageReceivers', 'messageReceivers.user', 'createdBy', 'updatedBy'])->where('id', $id)->first();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function list(array $data): mixed
    {
        return Message::with(['messageStatus', 'userType', 'messageReceivers', 'messageReceivers.user', 'createdBy', 'updatedBy'])
            ->orderBy('created_at')
            ->paginate(perPage: $data['per_page'] ?? 10, page: $data['page'] ?? 1);
    }

    /**
     * @param string $code
     * @return UserType|null
     */
    public function findUserTypeByCode(string $code): ?UserType
    {
        return UserType::where('code', $code)->first();
    }

    /**
     * @param string $code
     * @return MessageStatus|null
     */
    public function findMessageStatusByCode(string $code): ?MessageStatus
    {
        return MessageStatus::where('code', $code)->first();
    }

    /**
     * @param string $userTypeId
     * @return array|null
     */
    public function getUsersByUserType(string $userTypeId): ?array
    {
        return User::where('ref_user_type', $userTypeId)->get()->toArray();
    }

    /**
     * @return Collection|null
     */
    public function getPendingMessages(): ?Collection
    {
        return Message::with(['messageStatus', 'userType',
            'messageReceivers' => function ($query) {
                $query->whereNull('sent_at');
            },
            'messageReceivers.user', 'createdBy', 'updatedBy'])
            ->orderBy('created_at')
            ->get();
    }
}
