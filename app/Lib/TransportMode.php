<?php

namespace App\Lib;

class TransportMode extends Enum
{
    const PETROL_CAR = '0.1645';
    const DIESEL_CAR = '0.16984';
    const ELECTRIC_CAR = '0.0514';
    const MOTORBIKE = '0.11367';
    const TRAIN = '0.02861';
    const BICYCLE = '0';
    const BUS = '0.10846';
    const WALK = '0';
    

    const MODES = [
        self::PETROL_CAR => 'Petrol Car',
        self::DIESEL_CAR => 'Diesel Car',
        self::ELECTRIC_CAR => 'Electric Car',
        self::MOTORBIKE => 'Motorbike',
        self::TRAIN => 'Train',
        self::BICYCLE => 'Bicycle',
        self::BUS => 'Bus',
        self::WALK => 'Walking',
    ];
}