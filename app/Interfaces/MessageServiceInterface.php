<?php

namespace App\Interfaces;

use App\Requests\CreateBulkMessageRequest;
use App\Requests\CreateMessageRequest;
use App\Requests\ListMessageRequest;
use App\Requests\ReadMessageRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 *
 */
interface MessageServiceInterface
{
    /**
     * @param CreateBulkMessageRequest $request
     * @return JsonResponse
     */
    public function createBulk(CreateBulkMessageRequest $request): JsonResponse;

    /**
     * @param CreateMessageRequest $request
     * @return JsonResponse
     */
    public function create(CreateMessageRequest $request): JsonResponse;

    /**
     * @param ReadMessageRequest $request
     * @return JsonResponse
     */
    public function read(ReadMessageRequest $request): JsonResponse;

    /**
     * @param ListMessageRequest $request
     * @return JsonResponse
     */
    public function list(ListMessageRequest $request): JsonResponse;
}
