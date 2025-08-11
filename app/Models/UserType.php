<?php

namespace App\Models;

/**
 *
 */
class UserType extends BaseModel
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
