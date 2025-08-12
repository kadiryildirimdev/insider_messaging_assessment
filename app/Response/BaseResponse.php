<?php

namespace App\Response;

use Illuminate\Http\JsonResponse;

/**
 *
 */
class BaseResponse
{
    /**
     * @param bool $status
     * @param array|null $data
     * @param string|null $message
     * @param int|null $httpStatus
     * @return JsonResponse
     */
    private function base(bool $status = true, ?array $data = null, ?string $message = null, ?int $httpStatus = null): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $httpStatus);
    }

    /**
     * @param int $currentPage
     * @param int $lastPage
     * @param int $total
     * @param array|null $data
     * @param string|null $message
     * @return JsonResponse
     */
    private function listBase(int $currentPage, int $lastPage, int $total, ?array $data = null, ?string $message = null): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'meta' => [
                'current_page' => $currentPage,
                'last_page' => $lastPage,
                'total' => $total,
            ],
            'data' => $data
        ], 200);
    }

    /**
     * @param array|null $data
     * @param bool|null $status
     * @param int|null $httpCode
     * @return JsonResponse
     */
    public function createResponse(array $data = null, ?bool $status = true, ?int $httpCode = 200): JsonResponse
    {
        return $this->base($status, $data, $status ? __('CREATE_SUCCESS') : __('CREATE_FAILED'), $httpCode);
    }

    /**
     * @param array|null $data
     * @return JsonResponse
     */
    public function readResponse(?array $data = null): JsonResponse
    {
        return $this->base(true, $data, $data === null ? __('NO_RECORD_FOUND') : __('RECORD_FOUND'), 200);
    }

    /**
     * @param array|null $data
     * @param bool|null $status
     * @param int|null $httpCode
     * @return JsonResponse
     */
    public function updateResponse(array $data = null, ?bool $status = true, ?int $httpCode = 200): JsonResponse
    {
        return $this->base(true, $data, $status ? __('UPDATE_SUCCESS') : __('UPDATE_FAILED'), $httpCode);
    }

    /**
     * @param bool|null $status
     * @param int|null $httpCode
     * @return JsonResponse
     */
    public function deleteResponse(?bool $status = true, ?int $httpCode = 200): JsonResponse
    {
        return $this->base($status, null, $status ? __('DELETE_SUCCESS') : __('DELETE_FAILED'), $httpCode);
    }

    /**
     * @param array|null $data
     * @param mixed $meta
     * @return JsonResponse
     */
    public function listResponse(?array $data = null, mixed $meta): JsonResponse
    {
        return $this->listBase($meta->currentPage(), $meta->lastPage(), $meta->total(), $data, __('LIST_SUCCESS'));
    }
}
