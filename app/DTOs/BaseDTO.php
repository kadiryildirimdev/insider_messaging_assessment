<?php

namespace App\DTOs;

/**
 *
 */
class BaseDTO
{
    /**
     * @var string|mixed
     */
    public string $id;

    /**
     * @var bool|mixed
     */
    public bool $active;

    /**
     * @var array|null[]|null
     */
    public ?array $created_by;

    /**
     * @var array|null[]|null
     */
    public ?array $updated_by;

    /**
     * @var string|mixed|null
     */
    public ?string $created_at;

    /**
     * @var string|mixed|null
     */
    public ?string $updated_at;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->active = $data['active'];
        $this->created_by = isset($data['created_by']) ? [
            'id' => $data['created_by']['id'] ?? null,
            'name' => $data['created_by']['name'] ?? null,
            'surname' => $data['created_by']['surname'] ?? null,
        ] : null;
        $this->updated_by = isset($data['updated_by']) ? [
            'id' => $data['updated_by']['id'] ?? null,
            'name' => $data['updated_by']['name'] ?? null,
            'surname' => $data['updated_by']['surname'] ?? null,
        ] : null;
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return void
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return void
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    /**
     * @return array|null[]|null
     */
    public function getCreatedBy(): ?array
    {
        return $this->created_by;
    }

    /**
     * @param array|null $created_by
     * @return void
     */
    public function setCreatedBy(?array $created_by): void
    {
        $this->created_by = $created_by;
    }

    /**
     * @return array|null[]|null
     */
    public function getUpdatedBy(): ?array
    {
        return $this->updated_by;
    }

    /**
     * @param array|null $updated_by
     * @return void
     */
    public function setUpdatedBy(?array $updated_by): void
    {
        $this->updated_by = $updated_by;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    /**
     * @param string|null $created_at
     * @return void
     */
    public function setCreatedAt(?string $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }

    /**
     * @param string|null $updated_at
     * @return void
     */
    public function setUpdatedAt(?string $updated_at): void
    {
        $this->updated_at = $updated_at;
    }
}
