<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 */
class Message extends BaseModel
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'ref_message_status',
        'ref_user_type',
        'content',
        'active'
    ];

    /**
     * @return BelongsTo
     */
    public function messageStatus(): BelongsTo
    {
        return $this->belongsTo(MessageStatus::class, 'ref_message_status');
    }

    /**
     * @return BelongsTo
     */
    public function userType(): BelongsTo
    {
        return $this->belongsTo(UserType::class, 'ref_user_type');
    }

    /**
     * @return HasMany
     */
    public function messageReceivers(): HasMany
    {
        return $this->hasMany(MessageReceiver::class, 'ref_message');
    }
}
