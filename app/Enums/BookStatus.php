<?php

namespace App\Enums;

enum BookStatus: string
{
    case Taken = 'taken';
    case Returned = 'returned';

}
