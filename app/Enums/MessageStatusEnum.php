<?php

namespace App\Enums;

enum MessageStatusEnum: string
{
    case SENT      = '00001';
    case NOT_SENT  = '00002';
}
