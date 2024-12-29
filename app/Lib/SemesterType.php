<?php

namespace App\Lib;

class SemesterType extends Enum
{
    const WINTER = 'winter';
    const SPRING = 'spring';    

    const TYPES = [
        self::WINTER => [
            'label' => 'September - December',
            'start_date' => '09', //according to DCU Academic Calendar
            'end_date' => '21', //according to DCU Academic Calendar
        ],
        self::SPRING => [
            'label' => 'January - May',
            'start_date' => '13', //according to DCU Academic Calendar
            'end_date' => '06', //according to DCU Academic Calendar
        ]
    ];
}
