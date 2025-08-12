<?php

namespace App\DTOs;

use App\DTOs;

/**
 *
 */
class MessageDTO extends BaseDTO
{
    public ?array $message_status;

    public ?array $user_type;

    public string $content;

    public ?array $message_receivers;


    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->message_status = isset($data['message_status']) ? [
            'id' => $data['message_status']['id'] ?? null,
            'name' => $data['message_status']['name'] ?? null,
        ] : null;

        if(isset($data['user_type'])){
            $this->user_type = [
                'id' => $data['user_type']['id'] ?? null,
                'name' => $data['user_type']['name'] ?? null,
            ];
        }else{
            $this->user_type = null;
        }

        $this->content = $data['content'];

        if (isset($data['message_receivers'])) {
            $receivers = null;
            foreach ($data['message_receivers'] as $receiver) {
                $receivers[] = [
                    'id' => $receiver['user']['id'] ?? null,
                    'full_name' => $receiver['user']['full_name'] ?? null,
                    'phone_number' => $receiver['phone_number'],
                    'email' => $receiver['user']['email'] ?? null,
                    'sent_at' => $receiver['sent_at'] ?? null,
                ];
            }
            $this->message_receivers = $receivers;
        }

        $this->active = $data['active'];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'message_status' => $this->message_status,
            'user_type' => $this->user_type,
            'content' => $this->content,
            'message_receivers' => $this->message_receivers,
            'active' => $this->active,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
