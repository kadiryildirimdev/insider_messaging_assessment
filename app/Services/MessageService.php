<?php

namespace App\Services;

use App\DTOs\MessageDTO;
use App\Enums\MessageStatusEnum;
use App\Interfaces\MessageRepositoryInterface;
use App\Interfaces\MessageServiceInterface;
use App\Jobs\SendMessageJob;
use App\Requests\CreateBulkMessageRequest;
use App\Requests\CreateMessageRequest;
use App\Requests\ListMessageRequest;
use App\Requests\ReadMessageRequest;
use App\Response\BaseResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

class MessageService implements MessageServiceInterface
{
    protected BaseResponse $response;
    protected MessageRepositoryInterface $messageRepository;

    public function __construct(BaseResponse $response, MessageRepositoryInterface $messageRepository)
    {
        $this->response = $response;
        $this->messageRepository = $messageRepository;
    }

    public function createBulk(CreateBulkMessageRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $userType = $this->messageRepository->findUserTypeByCode($request->get('user_type_code'));

            if($userType === null)
            {
                return $this->response->readResponse();
            }

            $users = $this->messageRepository->getUsersByUserType($userType->id);

            if($users === [])
            {
                return $this->response->readResponse();
            }

            $messageStatus = $this->messageRepository->findMessageStatusByCode(MessageStatusEnum::NOT_SENT->value);

            if($messageStatus === null)
            {
                return $this->response->readResponse();
            }

            $request->merge(['ref_user_type' => $userType->id]);
            $request->merge(['ref_message_status' => $messageStatus->id]);
            $request->merge(['message_receivers' => $users]);

            $message = $this->messageRepository->createBulk($request->toArray());

            if ($message === null) {
                DB::rollback();
                return $this->response->createResponse(status: false, httpCode: 400);
            }

            $message = $this->messageRepository->read($message->id);

            $dto = new MessageDTO($message->toArray());

            DB::commit();

            SendMessageJob::dispatch($message->id);

            return $this->response->createResponse(data: $dto->toArray());
        } catch (\Throwable $e) {
            DB::rollback();
            return $this->response->createResponse(status: false, httpCode: 400);
        }
    }

    public function create(CreateMessageRequest $request): JsonResponse
    {
        // TODO: Implement create() method.
    }

    public function update(string $id, array $data): JsonResponse
    {
        // TODO: Implement create() method.
    }

    public function read(ReadMessageRequest $request): JsonResponse
    {
        $message = $this->messageRepository->read($request->get('id'));

        if ($message === null) {
            return $this->response->readResponse();
        }

        $dto = new MessageDTO($message->toArray());

        return $this->response->readResponse($dto->toArray());
    }

    public function list(ListMessageRequest $request): JsonResponse
    {
        $messages = $this->messageRepository->list($request->toArray());

        $dto = null;

        if ($messages->items() !== []) {
            foreach ($messages->items() as $item) {
                $dto[] = new MessageDTO($item->toArray());
            }
        }

        return $this->response->listResponse($dto, $messages);
    }

}
