<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\MessageServiceInterface;
use App\Requests\CreateBulkMessageRequest;
use App\Requests\CreateMessageRequest;
use App\Requests\ListMessageRequest;
use App\Requests\ReadMessageRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class MessageController extends Controller
{
    protected MessageServiceInterface $messageService;

    public function __construct(MessageServiceInterface $messageService)
    {
        $this->messageService = $messageService;
    }

    public function createBulk(CreateBulkMessageRequest $request): JsonResponse
    {
        return $this->messageService->createBulk($request);
    }

    public function create(CreateMessageRequest $request): JsonResponse
    {
        return $this->messageService->create($request);
    }

    public function read(ReadMessageRequest $request): JsonResponse
    {
        return $this->messageService->read($request);
    }

    public function list(ListMessageRequest $request): JsonResponse
    {
        return $this->messageService->list($request);
    }
}
