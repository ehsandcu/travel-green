<?php

namespace App\Lib;

class RouteType extends Enum
{
    const ONE_WAY = '1';
    const RETURN = '2';   

    const TYPES = [
        self::ONE_WAY => 'One Way',        
        self::RETURN => 'Return',        
    ];
}
