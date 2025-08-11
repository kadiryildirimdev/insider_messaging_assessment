<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 */
class BaseModel extends Model
{
    use HasUuids, SoftDeletes;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array|string[]
     */
    protected array $userstamps = ['created_by', 'updated_by', 'deleted_by'];

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var array
     */
    protected $hidden = [];

    /**
     * @return BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return BelongsTo
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * @return BelongsTo
     */
    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
