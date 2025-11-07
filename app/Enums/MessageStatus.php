<?php

namespace App\Enums;

enum MessageStatus: string
{
    case Read = 'read';

    case Unread = 'Unread';
}
