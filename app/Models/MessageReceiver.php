<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 */
class MessageReceiver extends BaseModel
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'transaction_id',
        'ref_message',
        'ref_user',
        'phone_number',
        'send_at',
        'active'
    ];

    /**
     * @return BelongsTo
     */
    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'ref_message');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ref_user');
    }
}
