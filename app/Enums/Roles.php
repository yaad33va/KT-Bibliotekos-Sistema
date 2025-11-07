<?php

namespace App\Enums;

enum Roles: string
{
    case Administrator = 'administrator';

    case RegisteredUser = 'registered-user';

    case Librarian = 'librarian';
}
