<?php

namespace App\Lib;

class TripJourney extends Enum
{
    const DAILY = 'daily';
    const WEEKLY = 'weekly';
    const MONTHLY = 'monthly';
    const SEMESTER = 'semester';
    const ANNUAL = 'annual';
    const CUSTOM = 'custom';    

    const JOURNEYS = [
        self::DAILY => [
            'label' => 'Daily',
            'color' => 'success',
        ],
        self::WEEKLY => [
            'label' => 'Weekly',
            'color' => 'info',
        ],
        self::MONTHLY => [
            'label' => 'Monthly',
            'color' => 'secondary',
        ],
        self::SEMESTER => [
            'label' => 'Semester',
            'color' => 'danger',
        ],
        self::ANNUAL => [
            'label' => 'Annual',
            'color' => 'warning',
        ],
        self::CUSTOM => [
            'label' => 'Custom',
            'color' => 'dark',
        ],
    ];
}
