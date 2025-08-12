<?php

namespace App\Interfaces;

use App\Requests\CreateBulkMessageRequest;
use App\Requests\CreateMessageRequest;
use App\Requests\ListMessageRequest;
use App\Requests\ReadMessageRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

interface MessageServiceInterface
{
    public function createBulk(CreateBulkMessageRequest $request): JsonResponse;

    public function create(CreateMessageRequest $request): JsonResponse;

    public function read(ReadMessageRequest $request): JsonResponse;

    public function list(ListMessageRequest $request): JsonResponse;
}
