<?php

namespace App\Models;

/**
 *
 */
class MessageStatus extends BaseModel
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'code',
        'name',
        'description',
        'active'
    ];
}
