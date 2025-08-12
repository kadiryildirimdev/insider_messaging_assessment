<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\MessageServiceInterface;
use App\Requests\CreateBulkMessageRequest;
use App\Requests\CreateMessageRequest;
use App\Requests\ListMessageRequest;
use App\Requests\ReadMessageRequest;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 *
 */
class MessageController extends Controller
{
    /**
     * @var MessageServiceInterface
     */
    protected MessageServiceInterface $messageService;

    /**
     * @param MessageServiceInterface $messageService
     */
    public function __construct(MessageServiceInterface $messageService)
    {
        $this->messageService = $messageService;
    }

    /**
     * @OA\Post(
     *     path="/api/messages/createBulk",
     *     tags={"createBulk"},
     *     summary="Create bulk messages",
     *     operationId="c71881de7ec32d1779a9a897ea7a0b61",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="user_type_code",
     *                 type="string",
     *                 enum={"00001", "00002", "00003", "00004"}
     *             ),
     *             @OA\Property(
     *                 property="content",
     *                 type="string",
     *                 minLength=1,
     *                 maxLength=150,
     *                 example="Test Mesajı"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function createBulk(CreateBulkMessageRequest $request): JsonResponse
    {
        return $this->messageService->createBulk($request);
    }

    /**
     * @OA\Post(
     *     path="/api/messages/create",
     *     tags={"create"},
     *     summary="Create single message",
     *     operationId="c71881de7ec32d1779a9a897ea7a0b62",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="content",
     *                 type="string",
     *                 minLength=1,
     *                 maxLength=150,
     *                 example="Test Mesajı"
     *             ),
     *             @OA\Property(
     *                 property="phone_number",
     *                 type="string",
     *                 minLength=14,
     *                 maxLength=14,
     *                 example="00905538876292"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function create(CreateMessageRequest $request): JsonResponse
    {
        return $this->messageService->create($request);
    }

    /**
     * @OA\Get(
     *     path="/api/messages/read",
     *     tags={"read"},
     *     summary="Read message details",
     *     operationId="c71881de7ec32d1779a9a897ea7a0b63",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=true,
     *         description="Mesaj UUID değeri",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     *
     */
    public function read(ReadMessageRequest $request): JsonResponse
    {
        return $this->messageService->read($request);
    }

    /**
     * @OA\Get(
     *     path="/api/messages/list",
     *     tags={"list"},
     *     summary="List of messages",
     *     operationId="c71881de7ec32d1779a9a897ea7a0b64",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         description="Sayfa numarası",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         description="Sayfa başına gösterilecek kayıt sayısı",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function list(ListMessageRequest $request): JsonResponse
    {
        return $this->messageService->list($request);
    }
}
