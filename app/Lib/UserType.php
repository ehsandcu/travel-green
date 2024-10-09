<?php

namespace App\Lib;

class UserType extends Enum
{
    const STUDENT = 'student';
    const STAFF = 'staff';
    

    const TYPES = [
        self::STUDENT => 'Student',
        self::STAFF => 'Staff',
    ];
}
