<?php

namespace App\Lib;

class UserRole extends Enum
{
    const ADMIN_ROLE = 'admin';
    const USER_ROLE = 'user';    

    const ROLES = [
        self::ADMIN_ROLE => 'Admin',
        self::USER_ROLE => 'User',
    ];
}
